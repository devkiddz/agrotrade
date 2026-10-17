<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use App\Models\Investment;
use App\Models\User_plans;
use App\Models\User_InvestmentPlans;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Traits\NotificationTrait;

class UserInvPlanController extends Controller
{
    use NotificationTrait;

    public function joinplan(Request $request){

        // Validate request inputs
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'asset' => 'required|string',
            'order_type' => 'required|string|in:Buy,Sell',
            'leverage' => 'required|numeric|min:1|max:100',
            'expire' => 'required|string',

        ]);

        // Get authenticated user
        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->back()->with('message', 'User not found.');
        }

        // Extract validated request data
        $amount = floatval($request->amount);
        $asset = $request->asset;
        $symbol = $request->symbol;
        $type = $request->order_type;
        $leverage = floatval($request->leverage);

        // Check if the user account balance can buy this plan
        if ($user->account_bal < $amount) {
            return redirect()->route('deposits')
                ->with('message', 'Your account is insufficient to purchase this trade. Please make a deposit.');
        }


        // Parse and calculate expiration date more safely
        try {
            $expiration = explode(" ", $request->expire);
            if (count($expiration) < 2) {
                return redirect()->back()->with('message', 'Invalid expiration format.');
            }

            $digit = intval($expiration[0]);
            $frame = strtolower($expiration[1]);

            // Map frame to Carbon method
            $frameMap = [
                'minutes' => 'addMinutes',
                'hours' => 'addHours',
                'days' => 'addDays',
                'weeks' => 'addWeeks',
                'months' => 'addMonths'
            ];

            if (!isset($frameMap[$frame])) {
                return redirect()->back()->with('message', 'Invalid time frame.');
            }

            $carbonMethod = $frameMap[$frame];
            $end_at = Carbon::now()->$carbonMethod($digit);

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error calculating expiration date.');
        }
       // return $end_at;

        // Use database transaction for data consistency
        try {
            DB::beginTransaction();

            // Debit user account
            $updatedUser = User::where('id', $user->id)
                ->update([
                    'account_bal' => $user->account_bal - $amount,
                ]);

            if (!$updatedUser) {
                throw new \Exception('Failed to update user balance');
            }

            // Save user trading plan
            $userplanid = DB::table('user_plans')->insertGetId([
                'plan' => 1,
                'user' => $user->id,
                'amount' => $amount,
                'active' => 'yes',
                'assets' => $asset,
                'symbol' => $symbol,
                'leverage' => $leverage,
                'inv_duration' => $request->expire,
                'type' => $type,
                'expire_date' => $end_at,
                'activated_at' => Carbon::now(),
                'last_growth' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if (!$userplanid) {
                throw new \Exception('Failed to create trading ');
            }

            // Create transaction history
            $transaction = Tp_Transaction::create([
                'user' => $user->id,
                'plan' => $asset,
                'amount' => $amount,
                'type' => $type,
                'leverage' => $leverage,
            ]);

            if (!$transaction) {
                throw new \Exception('Failed to create transaction history');
            }

            // Update user trading status
            $userUpdate = User::where('id', $user->id)
                ->update([
                    'trade' => 1,
                    'user_plan' => $userplanid,
                    'entered_at' => Carbon::now(),
                ]);

            if (!$userUpdate) {
                throw new \Exception('Failed to update user trading status');
            }

            DB::commit();

            // Send notifications about the trade
            try {
                $settings = Settings::find(1);
                if ($settings) {
                    // Send in-app notification for the trade
                    $this->sendtradeNotification($asset, $amount, $settings->currency, $userplanid);

                    // Send email notification to admin
                    if ($settings->contact_email) {
                        $message = "This is to inform you that {$user->name} just placed a trade on {$asset} asset for {$settings->currency}{$amount} with {$leverage}x leverage. Order type: {$type}";
                        $subject = "{$user->name} just traded {$asset} asset";

                        try {
                            Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send trade notification email to admin. User: ' . $user->name . ' (' . $user->email . '), Asset: ' . $asset . ', Amount: ' . $amount . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                // Log email error but don't fail the transaction
                \Log::error('Failed to send trading notification: ' . $e->getMessage());
            }

            return redirect()->back()
                ->with('success', "You have successfully traded {$asset}. Your trade is now active.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Failed to create trade: ' . $e->getMessage());
        }
    }



    public function joininvestmentplan(Request $request){
        // Validate request inputs
        $request->validate([
            'id' => 'required|exists:plans,id',
            'iamount' => 'nullable|numeric|min:1',
            'duration' => 'required|string'
        ]);

        // Get authenticated user
        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->back()->with('message', 'User not found.');
        }

        // Get investment plan
        $plan = Plans::find($request->id);
        if (!$plan) {
            return redirect()->back()->with('message', 'Investment plan not found.');
        }

        // Determine plan price
        $plan_price = (isset($request->iamount) && $request->iamount > 0)
            ? floatval($request->iamount)
            : floatval($plan->price);

        // Determine plan status
        $plan_status = ($user->user_plan_upgade == $plan->name) ? 'off' : 'on';

        // Check if the user account balance can buy this plan
        if ($user->account_bal < $plan_price) {
            return redirect()->route('deposits')
                ->with('message', 'Your account is insufficient to purchase this plan. Please make a deposit.');
        }

        // Parse and calculate expiration date more safely
        try {
            $expiration = explode(" ", $plan->expiration);
            if (count($expiration) < 2) {
                return redirect()->back()->with('message', 'Invalid plan expiration format.');
            }

            $digit = intval($expiration[0]);
            $frame = strtolower($expiration[1]);

            // Map frame to Carbon method
            $frameMap = [
                'minutes' => 'addMinutes',
                'hours' => 'addHours',
                'days' => 'addDays',
                'weeks' => 'addWeeks',
                'months' => 'addMonths'
            ];

            if (!isset($frameMap[$frame])) {
                return redirect()->back()->with('message', 'Invalid plan time frame.');
            }

            $carbonMethod = $frameMap[$frame];
            $end_at = Carbon::now()->$carbonMethod($digit);

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error calculating plan expiration date.');
        }

        // Use database transaction for data consistency
        try {
            DB::beginTransaction();

            // Credit user the plan bonus if applicable
            if ($plan->gift > 0) {
                $userUpdate = User::where('id', $user->id)
                    ->update([
                        'bonus' => $user->bonus + $plan->gift,
                        'account_bal' => $user->account_bal + $plan->gift,
                    ]);

                if (!$userUpdate) {
                    throw new \Exception('Failed to update user bonus');
                }

                // Create bonus transaction history
                Tp_Transaction::create([
                    'user' => $user->id,
                    'plan' => $plan->name,
                    'amount' => $plan->gift,
                    'type' => "Gift Bonus",
                ]);
            }

            // Debit user for plan purchase
            $userDebit = User::where('id', $user->id)
                ->update([
                    'account_bal' => $user->account_bal - $plan_price,
                    'plan_status' => $plan_status,
                ]);

            if (!$userDebit) {
                throw new \Exception('Failed to debit user account');
            }

            // Create purchase transaction history
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => $plan->name,
                'amount' => $plan_price,
                'type' => "Plan purchase",
            ]);

            // Save user investment plan
            $userplanid = DB::table('investments')->insertGetId([
                'plan' => $plan->id,
                'user' => $user->id,
                'amount' => $plan_price,
                'active' => 'yes',
                'inv_duration' => $request->duration,
                'expire_date' => $end_at,
                'activated_at' => Carbon::now(),
                'last_growth' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if (!$userplanid) {
                throw new \Exception('Failed to create investment plan');
            }

            // Update user plan status
            $userPlanUpdate = User::where('id', $user->id)
                ->update([
                    'plan' => $plan->id,
                    'user_plan' => $userplanid,
                    'entered_at' => Carbon::now(),
                ]);

            if (!$userPlanUpdate) {
                throw new \Exception('Failed to update user plan status');
            }

            DB::commit();

            // Send notification to user about plan purchase
            try {
                $settings = Settings::find(1);
                if ($settings) {
                    // Send in-app notification for the plan purchase
                    $this->sendPlanPurchaseNotification($plan->name, $plan_price, $settings->currency, $userplanid);

                    // Send notification email to admin
                    if ($settings->contact_email) {
                        $message = "This is to inform you that {$user->name} just purchased the {$plan->name} investment plan for {$settings->currency}{$plan_price}";
                        $subject = "{$user->name} purchased {$plan->name} Plan";

                        try {
                            Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send investment plan notification email to admin. User: ' . $user->name . ' (' . $user->email . '), Plan: ' . $plan->name . ', Amount: ' . $plan_price . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                // Log email error but don't fail the transaction
                \Log::error('Failed to send investment plan notification: ' . $e->getMessage());
            }

            return redirect()->back()
                ->with('success', "You have successfully purchased {$plan->name}.");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Failed to purchase investment plan: ' . $e->getMessage());
        }
    }

    public function cancelPlan($plan)
    {
        try {
            // Find the investment plan
            $investment = Investment::find($plan);
            if (!$investment) {
                return back()->with('message', 'Investment plan not found');
            }

            // Check if plan belongs to current user
            if ($investment->user != Auth::id()) {
                return back()->with('message', 'Unauthorized action');
            }

            // Check if plan is already cancelled
            if ($investment->active == 'cancelled') {
                return back()->with('message', 'Plan is already cancelled');
            }

            DB::beginTransaction();

            // Mark plan as cancelled
            $investment->active = 'cancelled';
            $investment->save();

            // Credit the user their capital
            $user = Auth::user();
            User::where('id', $investment->user)
                ->update([
                    'account_bal' => $user->account_bal + $investment->amount,
                ]);

            // Save to transaction history
            Tp_Transaction::create([
                'user' => $investment->user,
                'plan' => $investment->dplan->name ?? 'Investment Plan',
                'amount' => $investment->amount,
                'type' => "Investment capital for cancelled plan",
            ]);

            DB::commit();

            // Send notification email
            try {
                $planName = $investment->dplan->name ?? 'Investment Plan';
                $message = "You have successfully cancelled your {$planName} plan and your investment capital has been credited to your account. If this is a mistake, please contact us immediately to reactivate it for you.";

                try {
                    Mail::to($user->email)->send(new NewNotification($message, 'Investment Plan Cancelled', $user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send plan cancellation email to user. User: ' . $user->name . ' (' . $user->email . '), Plan: ' . $planName . ', Investment ID: ' . $investment->id . '. Error: ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send plan cancellation email: ' . $e->getMessage());
            }

            return back()->with('success', 'Plan cancelled successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('message', 'Failed to cancel plan: ' . $e->getMessage());
        }
    }
}
