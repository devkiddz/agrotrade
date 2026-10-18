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
        // Phase 1B-F0: fail closed if another financial run holds the cache lock.
        $agrotradeRunLock = \Illuminate\Support\Facades\Cache::lock('agrotrade:financial:new-roi', 7200);
        if (!$agrotradeRunLock->get()) {
            \Illuminate\Support\Facades\Log::warning('Agrotrade financial cron overlapping run blocked: processAutomaticRoi');
            return response()->json(['success' => false, 'message' => 'Financial processing already running'], 409);
        }
        try {
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

            foreach ($activePlans as $candidate) {
                try {
                    // The plan row is the per-investment serialization boundary.
                    $outcome = \Illuminate\Support\Facades\DB::transaction(function () use ($candidate, $settings) {
                        $userPlan = UserPlan::whereKey($candidate->id)->lockForUpdate()->first();
                        if (!$userPlan || $userPlan->status !== 'active') {
                            return 'skipped';
                        }
                        // Phase 1C: locked investment prevents admin/payout race.
                        if (!\Illuminate\Support\Facades\Schema::hasTable('agrotrade_investment_controls')) return 'skipped';
                    if (\Illuminate\Support\Facades\DB::table('agrotrade_investment_controls')->where('investment_type', 'modern')->where('investment_id', $userPlan->id)->where('state', '!=', 'active')->exists()) return 'skipped';
                        $plan = $userPlan->plan;
                        if (!$plan) {
                            return 'skipped';
                        }
                        $user = User::whereKey($userPlan->user_id)->lockForUpdate()->first();
                        if (!$user) {
                            return 'skipped';
                        }
                        // Use the locked user for all balance changes, not the preloaded snapshot.
                        $userPlan->setRelation('user', $user);
                        $userPlan->setRelation('plan', $plan);
                        $now = Carbon::now();
                        $lastPayout = $userPlan->last_payout_at ?? $userPlan->activated_at;
                        if (!$lastPayout || $now->lt($this->calculateNextPayoutDate($lastPayout, $plan->payout_interval))) {
                            return 'skipped';
                        }
                        if ($now->isWeekend() && $settings->weekend_trade != 'on') {
                            $userPlan->update(['last_payout_at' => $now]);
                            return 'skipped';
                        }
                        if ($userPlan->hasMatured()) {
                            $this->completePlan($userPlan, $settings);
                            return 'completed';
                        }
                        $roiPercentage = $this->calculateRoiPercentage($plan);
                        $roiAmount = $this->calculateRoiAmount($userPlan, $roiPercentage);
                        $this->processRoiPayment($userPlan, $roiAmount, $roiPercentage);
                        return 'processed';
                    }, 3);
                    if ($outcome === 'processed') {
                        $processed++;
                    } elseif ($outcome === 'completed') {
                        $completed++;
                    }
                } catch (\Throwable $e) {
                    Log::error('ROI transaction failed for user plan #' . $candidate->id . ': ' . $e->getMessage());
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
        } finally {
            $agrotradeRunLock->release();
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
            User::whereKey($user->id)->increment('roi', $roiAmount);
            User::whereKey($user->id)->increment('account_bal', $roiAmount);

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
                \Illuminate\Support\Facades\DB::afterCommit(function () use ($user, $plan, $roiAmount, $now) {
                    try {
                        Mail::to($user->email)->send(new NewRoi($user, $plan->name, $roiAmount, $now, 'New Return on Investment (ROI)'));
                    } catch (\Throwable $e) {
                        Log::error('Post-commit ROI email failed: ' . $e->getMessage());
                    }
                });
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
            User::whereKey($user->id)->increment('account_bal', $userPlan->invested_amount);

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
                \Illuminate\Support\Facades\DB::afterCommit(function () use ($user, $plan, $userPlan) {
                    try {
                        Mail::to($user->email)->send(new PlanCompleted($user, $plan, $userPlan));
                    } catch (\Throwable $e) {
                        Log::error('Post-commit plan completion email failed: ' . $e->getMessage());
                    }
                });
            } catch (\Exception $e) {
                Log::error("Failed to send plan completion email to {$user->email}: " . $e->getMessage());
            }
        }
    }
}
