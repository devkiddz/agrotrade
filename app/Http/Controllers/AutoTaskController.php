<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\Investment;
use App\Models\User_copytradings;
use App\Models\Tp_Transaction;
use App\Models\Notification;
use App\Mail\NewRoi;
use App\Mail\endplan;
use App\Mail\NewNotification;
use App\Models\Mt4Details;
use App\Traits\BinanceApi;
use App\Traits\Coinpayment;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AutoTaskController extends Controller
{
    use Coinpayment, BinanceApi;
    /*
        Automatic toup
        calculate top up earnings and
        auto increment earnings after the increment time
    */

    /**
     * Helper method to create user notifications
     *
     * @param int $userId User ID to send notification to
     * @param string $title Notification title
     * @param string $message Notification message
     * @param string $type Notification type (profit, system, warning, etc)
     * @param int|null $sourceId Related source ID (transaction, plan, etc)
     * @param string|null $sourceType Related source model type
     * @return Notification
     */
    private function createUserNotification($userId, $title, $message, $type = 'success', $sourceId = null, $sourceType = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
            'source_id' => $sourceId,
            'source_type' => $sourceType
        ]);
    }

    public function autotopup()
    {
        // automatic roi for investment plans
        $this->automaticRoi();

        // automatic trading profit calculation
        $this->automaticTradingProfit();

        // automatic copy trading profit calculation
        $this->automaticCopyTradingProfits();

        // automatic bot trading profit calculation
        $this->automaticBotTradingProfits();

        // check for subscription expiration

    }

    /**
     * Calculate and distribute automatic ROI for investment plans
     */
    public function automaticRoi()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            //get user investment plans
            $usersPlans = Investment::where('active', 'yes')->get();

            //get current date and time to be used for calculations of ROI
            $now = now();

            //logic to add auto roi
            foreach ($usersPlans as $plan) {
                //get plan
                $dplan = Plans::firstWhere('id', $plan->plan);
                if (!$dplan) continue; // Skip if plan doesn't exist

                //get user
                $user = User::firstWhere('id', $plan->user);
                if (!$user) continue; // Skip if user doesn't exist

                //know the plan increment interval
                if ($dplan->increment_interval == "Monthly") {
                    $nextDrop = $plan->last_growth->addDays(25);
                } elseif ($dplan->increment_interval == "Weekly") {
                    $nextDrop = $plan->last_growth->addDays(6);
                } elseif ($dplan->increment_interval == "Daily") {
                    $nextDrop = $plan->last_growth->addHours(20);
                } elseif ($dplan->increment_interval == "Hourly") {
                    $nextDrop = $plan->last_growth->addMinutes(49);
                } elseif ($dplan->increment_interval == "Every 30 Minutes") {
                    $nextDrop = $plan->last_growth->addMinutes(25);
                } else {
                    $nextDrop = $plan->last_growth->addMinutes(10);
                }

                //conditions
                $condition = $now->lessThanOrEqualTo($plan->expire_date) && $user->trade_mode == 'on';
                $condition2 = $now->greaterThan($plan->expire_date);

                //calculate increment
                if ($dplan->increment_type == "Percentage") {
                    $increment = (floatval($plan->amount) * floatval($dplan->increment_amount)) / 100;
                } else {
                    $increment = floatval($dplan->increment_amount);
                }

                if ($condition) {
                    if ($now->isWeekday() or $settings->weekend_trade == 'on') {
                        if ($now->greaterThanOrEqualTo($nextDrop)) {

                            User::where('id', $plan->user)
                                ->update([
                                    'roi' => $user->roi + $increment,
                                    'account_bal' => $user->account_bal + $increment,

                                ]);

                            //save to transactions history
                            $th = new Tp_Transaction();
                            $th->plan = $dplan->name;
                            $th->user = $user->id;
                            $th->amount = $increment;
                            $th->user_plan_id = $plan->id;
                            $th->type = "ROI";
                            $th->save();

                            Investment::where('id', $plan->id)
                                ->update([
                                    'last_growth' => $nextDrop,
                                     'profit_earned' => $plan->profit_earned + $increment,
                                ]);

                            // Create in-app notification for ROI earnings
                            $this->createUserNotification(
                                $user->id,
                                'ROI Earnings Received',
                                "You have received a return of {$user->currency}{$increment} from your investment in {$dplan->name}.",
                                'success',
                                $th->id,
                                'Tp_Transaction'
                            );

                            // if ($user->sendroiemail == 'Yes') {
                            //     //send email notification
                            //     $date = Carbon::now()->toDateTimeString();
                            //     Mail::to($user->email)->send(new NewRoi($user, $dplan->name, $increment, $date, 'New Return on Investment(ROI)'));
                            // }
                        }
                    }
                    if ($now->isWeekend() and $settings->weekend_trade != 'on') {
                        if ($now->greaterThanOrEqualTo($nextDrop)) {
                            Investment::where('id', $plan->id)
                                ->update([
                                    'last_growth' => $nextDrop,
                                ]);
                        }
                    }
                }

                if ($condition2) {
                    //release capital
                    if ($settings->return_capital) {
                        User::where('id', $plan->user)
                            ->update([
                                'account_bal' => $user->account_bal + $plan->amount,
                            ]);

                        //save to transactions history
                        $th = new Tp_transaction();
                        $th->plan = $dplan->name;
                        $th->user = $plan->user;
                        $th->amount = $plan->amount;
                        $th->type = "Investment capital";
                        $th->save();
                    }

                    //plan expired
                    Investment::where('id', $plan->id)
                        ->update([
                            'active' => "expired",
                        ]);

                    // Create in-app notification for plan expiration
                    $this->createUserNotification(
                        $user->id,
                        'Investment Plan Completed',
                        "Your investment plan '{$dplan->name}' has been completed. Total profit earned: {$user->currency}{$plan->profit_earned}",
                        'info',
                        $plan->id,
                        'Investment'
                    );

                    if ($user->sendinvplanemail == "Yes") {
                        //send email notification
                        $objDemo = new \stdClass();
                        $objDemo->receiver_email = $user->email;
                        $objDemo->receiver_plan = $dplan->name;
                        $objDemo->received_amount = "$user->currency$plan->amount";
                        $objDemo->sender = $settings->site_name;
                        $objDemo->receiver_name = $user->name;
                        $objDemo->date = \Carbon\Carbon::Now();
                        $objDemo->subject = "Investment plan closed";

                        try {
                            Mail::to($user->email)->send(new endplan($objDemo));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send investment plan completion email. User: ' . $user->name . ' (' . $user->email . '), Plan: ' . $dplan->name . ', Investment ID: ' . $plan->id . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate and distribute automatic trading profits for User_plans (trading)
     */
    public function automaticTradingProfit()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            // Get active trading plans (User_plans)
            $tradingPlans = User_plans::where('active', 'yes')->get();
            $now = now();

            foreach ($tradingPlans as $trade) {
                // Get user
                $user = User::firstWhere('id', $trade->user);
                if (!$user) continue;

                // Check if trade has expired
                $tradeExpired = $now->greaterThan($trade->expire_date);
                $tradeActive = $now->lessThanOrEqualTo($trade->expire_date) && $user->trade_mode == 'on';

                if ($tradeExpired) {
                    // Generate random profit/loss based on market conditions and leverage
                    $profitResult = $this->calculateTradingResult($trade);

                    // Update user ROI based on trading result
                    if ($profitResult['result'] == 'WIN') {
                        $profit = (floatval($trade->amount) * floatval($profitResult['percentage'])) / 100;

                        User::where('id', $trade->user)
                            ->update([
                                'roi' => $user->roi + $profit,
                                'account_bal' => $user->account_bal + $trade->amount + $profit, // Return capital + profit
                            ]);

                        // Update user_plans profit_earned column
                        User_plans::where('id', $trade->id)
                            ->update([
                                'profit_earned' => ($trade->profit_earned ?? 0) + $profit,
                            ]);

                        // Save transaction history
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $profit,
                            'type' => 'WIN',
                            'leverage' => $profitResult['percentage'],
                        ]);

                        // Return capital transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $trade->amount,
                            'type' => 'Trading capital return',
                            'leverage' => 0,
                        ]);

                    } else {
                        // LOSE - Calculate loss based on leverage and market movement
                        $actualLoss = (floatval($trade->amount) * floatval($profitResult['loss_percentage'])) / 100;
                        $refundAmount = floatval($trade->amount) - $actualLoss;

                        // Update user_plans profit_earned column with negative loss
                        User_plans::where('id', $trade->id)
                            ->update([
                                'profit_earned' => ($trade->profit_earned ?? 0) - $actualLoss,
                            ]);

                        // Refund the remaining amount to user account
                        if ($refundAmount > 0) {
                            User::where('id', $trade->user)
                                ->update([
                                    'account_bal' => $user->account_bal + $refundAmount,
                                ]);

                            // Record refund transaction
                            Tp_Transaction::create([
                                'user' => $user->id,
                                'plan' => $trade->assets,
                                'amount' => $refundAmount,
                                'type' => 'Trading capital refund',
                                'leverage' => 0,
                            ]);
                        }

                        // Record loss transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $actualLoss,
                            'type' => 'LOSE',
                            'leverage' => $profitResult['loss_percentage'],
                        ]);
                    }

                    // Mark trade as expired
                    User_plans::where('id', $trade->id)
                        ->update([
                            'active' => 'expired',
                        ]);

                    // Update user trade status
                    User::where('id', $trade->user)
                        ->update([
                            'trade' => 0,
                        ]);

                    // Create in-app notification based on trading result
                    if ($profitResult['result'] == 'WIN') {
                        $profit = (floatval($trade->amount) * floatval($profitResult['percentage'])) / 100;

                        $this->createUserNotification(
                            $user->id,
                            'Trading Profit Generated',
                            "Your {$trade->assets} trade has completed successfully with a profit of {$user->currency}{$profit} ({$profitResult['percentage']}%).",
                            'success',
                            $trade->id,
                            'User_plans'
                        );
                    } else {
                        $actualLoss = (floatval($trade->amount) * floatval($profitResult['loss_percentage'])) / 100;
                        $refundAmount = floatval($trade->amount) - $actualLoss;

                        $this->createUserNotification(
                            $user->id,
                            'Trading Loss',
                            "Your {$trade->assets} trade resulted in a {$profitResult['loss_percentage']}% loss ({$user->currency}{$actualLoss}). Due to leverage protection, {$user->currency}{$refundAmount} has been refunded to your account.",
                            'warning',
                            $trade->id,
                            'User_plans'
                        );
                    }

                    // Send notification email if enabled
                    if ($user->sendroiemail == 'Yes') {
                        $message = "Your {$trade->assets} trade has been completed with a {$profitResult['result']} result.";
                        $subject = "Trading Result: {$profitResult['result']}";

                        try {
                            Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send trading result notification email. User: ' . $user->name . ' (' . $user->email . '), Trade ID: ' . $trade->id . ', Asset: ' . $trade->assets . ', Result: ' . $profitResult['result'] . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate trading result based on market simulation and leverage
     * @param User_plans $trade
     * @return array
     */
    private function calculateTradingResult($trade)
    {
        $settings = Settings::find(1);
        // Simulate market conditions (60% win rate for realistic trading)
        $winChance = $settings->trading_winrate;
        $isWin = rand(1, 100) <= $winChance;

        if ($isWin) {
            // Calculate profit percentage based on leverage (more realistic returns)
            $baseProfitRate = rand(5, 15); // 5-15% base profit
            $leverageMultiplier = floatval($trade->leverage) / 10; // Leverage effect
            $profitPercentage = min($baseProfitRate * $leverageMultiplier, 200); // Cap at 200%

            return [
                'result' => 'WIN',
                'percentage' => round($profitPercentage, 2)
            ];
        } else {
            // Calculate loss based on leverage - higher leverage = higher potential loss but with stop-loss protection
            $leverage = floatval($trade->leverage);

            // Base loss percentage (what user actually loses from their investment)
            if ($leverage >= 100) {
                $lossPercentage = rand(40, 70); // High leverage: 40-70% loss, 30-60% refunded
            } elseif ($leverage >= 50) {
                $lossPercentage = rand(30, 50); // Medium-high leverage: 30-50% loss, 50-70% refunded
            } elseif ($leverage >= 20) {
                $lossPercentage = rand(20, 40); // Medium leverage: 20-40% loss, 60-80% refunded
            } elseif ($leverage >= 10) {
                $lossPercentage = rand(15, 30); // Low-medium leverage: 15-30% loss, 70-85% refunded
            } else {
                $lossPercentage = rand(10, 25); // Low leverage: 10-25% loss, 75-90% refunded
            }

            return [
                'result' => 'LOSE',
                'loss_percentage' => round($lossPercentage, 2),
                'percentage' => round($lossPercentage, 2) // For backward compatibility
            ];
        }
    }

    /**
     * Calculate and distribute copy trading profits automatically
     */
    public function automaticCopyTradingProfits()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            // Get all active copy trading plans
            $activeCopyTrades = User_copytradings::where('active', 'yes')->get();
            $now = Carbon::now();

            foreach ($activeCopyTrades as $copyTrade) {
                // Get user
                $user = User::find($copyTrade->user);
                if (!$user) continue;

                // Check if it's time to generate profit (every 4-6 hours)
                $lastProfit = $copyTrade->last_profit ? Carbon::parse($copyTrade->last_profit) : Carbon::parse($copyTrade->created_at);
                $hoursToAdd = rand(4, 6); // Random interval between 4-6 hours
                $nextProfitTime = $lastProfit->addHours($hoursToAdd);

                if ($now->greaterThanOrEqualTo($nextProfitTime)) {
                    // Generate copy trading profit based on expert performance
                    $profitResult = $this->calculateCopyTradingProfit($copyTrade);

                    if ($profitResult['result'] == 'PROFIT') {
                        $profit = $profitResult['amount'];

                        // Update user account with profit
                        User::where('id', $user->id)
                            ->update([
                                'roi' => $user->roi + $profit,
                                'account_bal' => $user->account_bal + $profit,
                            ]);

                        // Update copy trading record
                        User_copytradings::where('id', $copyTrade->id)
                            ->update([
                                'total_profit' => ($copyTrade->total_profit ?? 0) + $profit,
                                'last_profit' => $now,
                                'updated_at' => $now,
                            ]);

                        // Record transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $copyTrade->name,
                            'amount' => $profit,
                            'type' => "Copy Trading Profit from {$copyTrade->name}",
                            'leverage' => $profitResult['percentage'],
                        ]);

                        // Create in-app notification for copy trading profit
                        $this->createUserNotification(
                            $user->id,
                            'Copy Trading Profit',
                            "Your copy trading with {$copyTrade->name} has generated a profit of {$user->currency}{$profit} ({$profitResult['percentage']}%).",
                            'success',
                            $copyTrade->id,
                            'User_copytradings'
                        );

                        // Send profit notification if enabled
                        if ($user->sendroiemail == 'Yes') {
                            try {
                                $message = "Great news! Your copy trading with {$copyTrade->name} has generated a profit of {$user->currency}{$profit}. Keep copying and earning!";
                                $subject = "Copy Trading Profit Earned";
                                //Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                            } catch (\Exception $e) {
                                \Log::error('Failed to send copy trading profit email: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate copy trading profit based on expert performance simulation
     * @param User_copytradings $copyTrade
     * @return array
     */
    private function calculateCopyTradingProfit($copyTrade)
    {
        // Copy trading typically has higher success rate (70-80%)
        $profitChance = rand(70, 80);
        $isProfitable = rand(1, 100) <= $profitChance;

        if ($isProfitable) {
            // Calculate profit as percentage of investment (0.5% - 3% per session)
            $profitPercentage = rand(50, 300) / 100; // 0.5% to 3%
            $profitAmount = ($copyTrade->price * $profitPercentage) / 100;

            return [
                'result' => 'PROFIT',
                'amount' => round($profitAmount, 2),
                'percentage' => round($profitPercentage, 2)
            ];
        } else {
            // No profit this session
            return [
                'result' => 'NO_PROFIT',
                'amount' => 0,
                'percentage' => 0
            ];
        }
    }

    /**
     * Calculate and distribute bot trading profits automatically
     */
    public function automaticBotTradingProfits()
    {
        $settings = \App\Models\Settings::find(1);

        if ($settings && $settings->trade_mode == 'on') {
            // Get all active bot investments
            $activeBotInvestments = \App\Models\UserBotInvestment::where('status', 'active')
                                                                ->where('expires_at', '>', now())
                                                                ->with(['user', 'bot'])
                                                                ->get();

            foreach ($activeBotInvestments as $investment) {
                // Check if it's time to generate profit
                if (!$investment->shouldGenerateProfit()) {
                    continue;
                }

                $user = $investment->user;
                $bot = $investment->bot;

                if (!$user || !$bot) {
                    continue;
                }

                // Generate trading result
                $tradingResult = $this->calculateBotTradingResult($investment);

                if ($tradingResult['result'] === 'PROFIT') {
                    $profit = $tradingResult['amount'];

                    // Update user account with profit
                    \App\Models\User::where('id', $user->id)->update([
                        'roi' => $user->roi + $profit,
                        'account_bal' => $user->account_bal + $profit,
                    ]);

                    // Update bot investment record
                    $investment->update([
                        'current_balance' => $investment->current_balance + $profit,
                        'total_profit' => $investment->total_profit + $profit,
                        'successful_trades' => $investment->successful_trades + 1,
                        'last_profit_at' => now(),
                    ]);

                    // Create trading history record
                    \App\Models\BotTradingHistory::create([
                        'user_bot_investment_id' => $investment->id,
                        'trade_type' => $tradingResult['trade_type'],
                        'trading_pair' => $tradingResult['trading_pair'],
                        'entry_price' => $tradingResult['entry_price'],
                        'exit_price' => $tradingResult['exit_price'],
                        'amount' => $investment->current_balance * 0.1, // 10% of balance per trade
                        'profit_loss' => $profit,
                        'profit_percentage' => $tradingResult['percentage'],
                        'result' => 'profit',
                        'strategy_used' => $tradingResult['strategy'],
                        'opened_at' => now()->subMinutes(rand(15, 180)), // Random trade duration
                        'closed_at' => now(),
                    ]);

                    // Record transaction
                    \App\Models\Tp_Transaction::create([
                        'user' => $user->id,
                        'plan' => "Bot Trading Profit - {$bot->name}",
                        'amount' => $profit,
                        'type' => "Bot Trading Profit",
                        'leverage' => $tradingResult['percentage'],
                    ]);

                    // Create in-app notification for bot trading profit
                    $this->createUserNotification(
                        $user->id,
                        'Bot Trading Profit',
                        "Your {$bot->name} trading bot has generated a profit of {$user->currency}{$profit} using {$tradingResult['strategy']} strategy on {$tradingResult['trading_pair']}.",
                        'success',
                        $investment->id,
                        'UserBotInvestment'
                    );

                    // Send profit notification if enabled
                    if ($user->sendroiemail == 'Yes') {
                        try {
                            $message = "Your {$bot->name} trading bot has generated a profit of \${$profit}. Keep investing and earning!";
                            $subject = "Bot Trading Profit Earned";
                            \Mail::to($user->email)->send(new \App\Mail\NewNotification($message, $subject, $user->name));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send bot trading profit email: ' . $e->getMessage());
                        }
                    }

                } elseif ($tradingResult['result'] === 'LOSS') {
                    $loss = $tradingResult['amount'];

                    // Update bot investment record (loss)
                    $investment->update([
                        'current_balance' => max(0, $investment->current_balance - $loss),
                        'total_loss' => $investment->total_loss + $loss,
                        'failed_trades' => $investment->failed_trades + 1,
                        'last_profit_at' => now(),
                    ]);

                    // Create trading history record
                    \App\Models\BotTradingHistory::create([
                        'user_bot_investment_id' => $investment->id,
                        'trade_type' => $tradingResult['trade_type'],
                        'trading_pair' => $tradingResult['trading_pair'],
                        'entry_price' => $tradingResult['entry_price'],
                        'exit_price' => $tradingResult['exit_price'],
                        'amount' => $investment->current_balance * 0.1,
                        'profit_loss' => -$loss,
                        'profit_percentage' => -$tradingResult['percentage'],
                        'result' => 'loss',
                        'strategy_used' => $tradingResult['strategy'],
                        'opened_at' => now()->subMinutes(rand(15, 180)),
                        'closed_at' => now(),
                    ]);

                    // Create in-app notification for bot trading loss (only for significant losses)
                    if ($tradingResult['percentage'] > 1.0) {
                        $this->createUserNotification(
                            $user->id,
                            'Bot Trading Alert',
                            "Your {$bot->name} bot had a trade loss of {$tradingResult['percentage']}% on {$tradingResult['trading_pair']}. The system has automatically adjusted the strategy.",
                            'warning',
                            $investment->id,
                            'UserBotInvestment'
                        );
                    }
                }

                // Update bot statistics
                $bot->update([
                    'last_trade' => now(),
                    'total_earned' => $bot->total_earned + ($tradingResult['result'] === 'PROFIT' ? $profit : 0),
                ]);
            }

            // Check for expired investments
            $expiredInvestments = \App\Models\UserBotInvestment::where('status', 'active')
                                                               ->where('expires_at', '<=', now())
                                                               ->with(['user', 'bot'])
                                                               ->get();

            foreach ($expiredInvestments as $investment) {
                $user = $investment->user;
                $bot = $investment->bot;

                if (!$user || !$bot) {
                    continue;
                }

                // Return remaining balance to user
                if ($investment->current_balance > 0) {
                    \App\Models\User::where('id', $user->id)->update([
                        'account_bal' => $user->account_bal + $investment->current_balance,
                    ]);

                    // Record transaction
                    \App\Models\Tp_Transaction::create([
                        'user' => $user->id,
                        'plan' => "Bot Investment Completed - {$bot->name}",
                        'amount' => $investment->current_balance,
                        'type' => "Bot Investment Return",
                        'status' => 'Processed',
                    ]);
                }

                // Update investment status
                $investment->update(['status' => 'completed']);

                // Calculate totals for notifications
                $totalReturn = $investment->current_balance;
                $totalProfit = $investment->total_profit - $investment->total_loss;
                $profitPercent = $investment->initial_balance > 0 ?
                    round(($totalProfit / $investment->initial_balance) * 100, 2) : 0;

                // Create in-app notification for completed bot investment
                $notificationType = $totalProfit > 0 ? 'success' : 'info';
                $this->createUserNotification(
                    $user->id,
                    'Bot Investment Completed',
                    "Your {$bot->name} bot investment has completed with a " .
                    ($totalProfit > 0 ? "profit of {$user->currency}{$totalProfit} ({$profitPercent}%)" : "final balance of {$user->currency}{$totalReturn}") .
                    ". The funds have been credited to your account balance.",
                    $notificationType,
                    $investment->id,
                    'UserBotInvestment'
                );

                // Send completion notification
                if ($user->sendroiemail == 'Yes') {
                    try {
                        $message = "Your {$bot->name} bot investment has completed. Total return: \${$totalReturn}, Net profit: \${$totalProfit}";
                        $subject = "Bot Investment Completed";
                        \Mail::to($user->email)->send(new \App\Mail\NewNotification($message, $subject, $user->name));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send bot completion email: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * Calculate bot trading result with realistic market simulation
     */
    private function calculateBotTradingResult($investment)
    {
        $bot = $investment->bot;

        // Bot trading has higher success rate than manual trading
        $successRate = $bot->success_rate ?? 80;
        $isProfit = rand(1, 100) <= $successRate;

        // Get random trading pair from bot's supported pairs
        $tradingPairs = $bot->trading_pairs ?? ['EUR/USD', 'GBP/USD', 'BTC/USD'];
        $tradingPair = $tradingPairs[array_rand($tradingPairs)];

        // Generate realistic entry and exit prices
        $basePrice = $this->getBasePriceForPair($tradingPair);
        $entryPrice = $basePrice * (1 + (rand(-100, 100) / 10000)); // ±1% variation

        $tradeType = rand(0, 1) ? 'BUY' : 'SELL';

        if ($isProfit) {
            // Profitable trade
            $profitPercentage = rand((int)($bot->daily_profit_min * 100), (int)($bot->daily_profit_max * 100)) / 100;
            $profitAmount = ($investment->current_balance * $profitPercentage) / 100;

            $exitPrice = $tradeType === 'BUY'
                ? $entryPrice * (1 + $profitPercentage / 100)
                : $entryPrice * (1 - $profitPercentage / 100);

            return [
                'result' => 'PROFIT',
                'amount' => round($profitAmount, 2),
                'percentage' => round($profitPercentage, 2),
                'trade_type' => $tradeType,
                'trading_pair' => $tradingPair,
                'entry_price' => round($entryPrice, 5),
                'exit_price' => round($exitPrice, 5),
                'strategy' => $this->getRandomStrategy($bot),
            ];
        } else {
            // Loss trade (smaller losses to maintain profitability)
            $lossPercentage = rand(50, 200) / 100; // 0.5% - 2% loss
            $lossAmount = ($investment->current_balance * $lossPercentage) / 100;

            $exitPrice = $tradeType === 'BUY'
                ? $entryPrice * (1 - $lossPercentage / 100)
                : $entryPrice * (1 + $lossPercentage / 100);

            return [
                'result' => 'LOSS',
                'amount' => round($lossAmount, 2),
                'percentage' => round($lossPercentage, 2),
                'trade_type' => $tradeType,
                'trading_pair' => $tradingPair,
                'entry_price' => round($entryPrice, 5),
                'exit_price' => round($exitPrice, 5),
                'strategy' => $this->getRandomStrategy($bot),
            ];
        }
    }

    /**
     * Get base price for trading pair
     */
    private function getBasePriceForPair($pair)
    {
        $basePrices = [
            'EUR/USD' => 1.0850,
            'GBP/USD' => 1.2650,
            'USD/JPY' => 149.50,
            'USD/CHF' => 0.8950,
            'AUD/USD' => 0.6750,
            'USD/CAD' => 1.3450,
            'BTC/USD' => 43500.00,
            'ETH/USD' => 2650.00,
            'BNB/USD' => 315.00,
            'ADA/USD' => 0.485,
            'SOL/USD' => 98.50,
            'DOT/USD' => 7.25,
            'AAPL' => 195.50,
            'GOOGL' => 2850.00,
            'MSFT' => 415.00,
            'AMZN' => 3250.00,
            'TSLA' => 248.50,
            'META' => 485.00,
            'GOLD' => 2025.50,
            'SILVER' => 24.85,
            'OIL' => 78.50,
            'COPPER' => 3.85,
            'WHEAT' => 6.45,
            'NATURAL_GAS' => 2.95,
            'S&P500' => 4785.50,
            'NASDAQ' => 15250.00,
            'DOW' => 37850.00,
            'FTSE' => 7650.00,
            'DAX' => 16850.00,
            'NIKKEI' => 33250.00,
        ];

        return $basePrices[$pair] ?? 1.0000;
    }

    /**
     * Get random trading strategy
     */
    private function getRandomStrategy($bot)
    {
        $strategies = [
            'Trend Following',
            'Scalping',
            'Momentum Trading',
            'Mean Reversion',
            'Breakout Strategy',
            'Support & Resistance',
            'RSI Divergence',
            'MACD Crossover',
            'Moving Average Strategy',
            'Fibonacci Retracement',
        ];

        return $strategies[array_rand($strategies)];
    }
}
