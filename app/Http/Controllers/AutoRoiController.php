<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\PlanPayout;
use App\Models\Tp_Transaction;
use App\Mail\NewRoi;
use App\Mail\PlanCompleted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AutoRoiController extends Controller
{
    /**
     * Run the automatic ROI process for new plan system
     */
    public function processAutomaticRoi()
    {
        try {
            $settings = Settings::find(1);

            // Skip if trading mode is off
            if ($settings->trade_mode != 'on') {
                return response()->json(['message' => 'Trading mode is off. Skipping automatic ROI processing.']);
            }

            // Get all active user plans
            $activePlans = UserPlan::where('status', 'active')->get();
            $now = Carbon::now();
            $processed = 0;
            $completed = 0;

            foreach ($activePlans as $userPlan) {
                try {
                    // Get associated plan and user
                    $plan = $userPlan->plan;
                    $user = $userPlan->user;

                    if (!$plan || !$user) {
                        continue;
                    }

                    // Calculate next payout date based on payout interval
                    $lastPayout = $userPlan->last_payout_at ?? $userPlan->activated_at;

                    if (!$lastPayout) {
                        continue;
                    }

                    $nextPayoutDate = $this->calculateNextPayoutDate($lastPayout, $plan->payout_interval);

                    // Skip if it's not time for payout yet
                    if ($now->lt($nextPayoutDate)) {
                        continue;
                    }

                    // Skip weekend payouts if weekend trading is disabled
                    if ($now->isWeekend() && $settings->weekend_trade != 'on') {
                        // Just update the last payout time to prevent buildup
                        $userPlan->update(['last_payout_at' => $now]);
                        continue;
                    }

                    // Check if plan has matured
                    if ($userPlan->hasMatured()) {
                        $this->completePlan($userPlan, $settings);
                        $completed++;
                        continue;
                    }

                    // Calculate ROI amount
                    $roiPercentage = $this->calculateRoiPercentage($plan);
                    $roiAmount = $this->calculateRoiAmount($userPlan, $roiPercentage);

                    // Process the ROI payment
                    $this->processRoiPayment($userPlan, $roiAmount, $roiPercentage);

                    $processed++;

                } catch (\Exception $e) {
                    Log::error("Error processing ROI for user plan #{$userPlan->id}: " . $e->getMessage());
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "ROI processed for {$processed} active plans. {$completed} plans were completed."
            ]);

        } catch (\Exception $e) {
            Log::error("Error in automatic ROI process: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Calculate the next payout date based on interval
     */
    private function calculateNextPayoutDate(Carbon $lastPayout, string $interval): Carbon
    {
        return match ($interval) {
            'hourly' => $lastPayout->copy()->addHour(),
            'daily' => $lastPayout->copy()->addDay(),
            'weekly' => $lastPayout->copy()->addWeek(),
            'monthly' => $lastPayout->copy()->addMonth(),
            'quarterly' => $lastPayout->copy()->addMonths(3),
            'yearly' => $lastPayout->copy()->addYear(),
            default => $lastPayout->copy()->addDay(), // Default to daily
        };
    }

    /**
     * Calculate ROI percentage based on plan settings
     */
    private function calculateRoiPercentage(Plan $plan): float
    {
        // For plans with min and max return, use a random value in between
        if ($plan->min_return < $plan->max_return) {
            return mt_rand($plan->min_return * 100, $plan->max_return * 100) / 100;
        }

        return floatval($plan->min_return);
    }

    /**
     * Calculate ROI amount based on investment and percentage
     */
    private function calculateRoiAmount(UserPlan $userPlan, float $roiPercentage): float
    {
        // Base amount is the invested amount
        $baseAmount = $userPlan->invested_amount;

        // For compounding, use current value instead
        if ($userPlan->compounding_enabled && $userPlan->plan->profit_calculation === 'compound') {
            $baseAmount = $userPlan->current_value;
        }

        // Calculate ROI amount
        $roiAmount = ($baseAmount * $roiPercentage) / 100;

        return round($roiAmount, 8);
    }

    /**
     * Process ROI payment for a user plan
     */
    private function processRoiPayment(UserPlan $userPlan, float $roiAmount, float $roiPercentage): void
    {
        $user = $userPlan->user;
        $plan = $userPlan->plan;
        $now = Carbon::now();

        // Create payout record
        $payout = PlanPayout::create([
            'user_plan_id' => $userPlan->id,
            'user_id' => $user->id,
            'amount' => $roiAmount,
            'roi_percentage' => $roiPercentage,
            'type' => 'profit',
            'status' => 'processed',
            'processed_at' => $now,
            'remarks' => "Automatic ROI payout for {$plan->name} investment"
        ]);

        // Update user balance with ROI
        if ($userPlan->compounding_enabled) {
            // For compounding, add to current value of investment
            $userPlan->update([
                'current_value' => $userPlan->current_value + $roiAmount,
                'total_profit' => $userPlan->total_profit + $roiAmount,
                'last_payout_at' => $now,
            ]);
        } else {
            // Non-compounding, add to user's balance
            $user->update([
                'roi' => $user->roi + $roiAmount,
                'account_bal' => $user->account_bal + $roiAmount
            ]);

            $userPlan->update([
                'total_profit' => $userPlan->total_profit + $roiAmount,
                'last_payout_at' => $now,
            ]);
        }

        // Create transaction record
        Tp_Transaction::create([
            'user' => $user->id,
            'plan' => $plan->name,
            'amount' => $roiAmount,
            'type' => 'ROI',
            'user_plan_id' => $userPlan->id,
        ]);

        // Send email notification if enabled
        if ($user->sendroiemail == 'Yes') {
            try {
                Mail::to($user->email)->send(new NewRoi($user, $plan->name, $roiAmount, $now, 'New Return on Investment (ROI)'));
            } catch (\Exception $e) {
                Log::error("Failed to send ROI email to {$user->email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Complete a plan that has matured
     */
    private function completePlan(UserPlan $userPlan, Settings $settings): void
    {
        $user = $userPlan->user;
        $plan = $userPlan->plan;
        $now = Carbon::now();

        // Return capital if that's the platform setting
        if ($settings->return_capital) {
            // Add capital to user balance
            $user->update([
                'account_bal' => $user->account_bal + $userPlan->invested_amount
            ]);

            // Create transaction for returned capital
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => $plan->name,
                'amount' => $userPlan->invested_amount,
                'type' => 'Investment capital return',
                'user_plan_id' => $userPlan->id,
            ]);

            // Create payout record
            PlanPayout::create([
                'user_plan_id' => $userPlan->id,
                'user_id' => $user->id,
                'amount' => $userPlan->invested_amount,
                'type' => 'capital_return',
                'status' => 'processed',
                'processed_at' => $now,
                'remarks' => "Investment capital return for {$plan->name}"
            ]);
        }

        // Mark plan as completed
        $userPlan->update([
            'status' => 'completed',
            'last_payout_at' => $now,
        ]);

        // Send completion email notification
        if ($user->sendinvplanemail == "Yes") {
            try {
                Mail::to($user->email)->send(new PlanCompleted($user, $plan, $userPlan));
            } catch (\Exception $e) {
                Log::error("Failed to send plan completion email to {$user->email}: " . $e->getMessage());
            }
        }
    }
}
