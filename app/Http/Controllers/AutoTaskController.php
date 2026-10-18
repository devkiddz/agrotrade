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
        // Phase 1B-F0: fail closed if another financial run holds the cache lock.
        $agrotradeRunLock = \Illuminate\Support\Facades\Cache::lock('agrotrade:financial:legacy-cron', 7200);
        if (!$agrotradeRunLock->get()) {
            \Illuminate\Support\Facades\Log::warning('Agrotrade financial cron overlapping run blocked: autotopup');
            return response()->json(['success' => false, 'message' => 'Financial processing already running'], 409);
        }
        try {
        // automatic roi for investment plans
        $this->automaticRoi();

        // automatic trading profit calculation
        $this->automaticTradingProfit();

        // automatic copy trading profit calculation
        $this->automaticCopyTradingProfits();

        // automatic bot trading profit calculation
        $this->automaticBotTradingProfits();

        // check for subscription expiration

        } finally {
            $agrotradeRunLock->release();
        }
    }

    /**
     * Calculate and distribute automatic ROI for investment plans
     */
    public function automaticRoi()
    {
        $settings = Settings::find(1);
        if (!$settings || $settings->trade_mode != 'on') return;

        $ids = Investment::where('active', 'yes')->pluck('id');
        foreach ($ids as $id) {
            $completionMail = null;
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($id, $settings, &$completionMail) {
                    $plan = Investment::whereKey($id)->lockForUpdate()->first();
                    if (!$plan || $plan->active !== 'yes') return;
                    // Phase 1C: row lock serializes admin controls with ROI settlement.
                    if (!\Illuminate\Support\Facades\Schema::hasTable('agrotrade_investment_controls')) return;
                    if (\Illuminate\Support\Facades\DB::table('agrotrade_investment_controls')->where('investment_type', 'legacy')->where('investment_id', $plan->id)->where('state', '!=', 'active')->exists()) return;
                    $dplan = Plans::find($plan->plan);
                    if (!$dplan) return;
                    $user = User::whereKey($plan->user)->lockForUpdate()->first();
                    if (!$user) return;
                    $now = now();
                    // Preserve the original interval and payout formulas.
                    $last = $plan->last_growth->copy();
                    if ($dplan->increment_interval == 'Monthly') $nextDrop = $last->addDays(25);
                    elseif ($dplan->increment_interval == 'Weekly') $nextDrop = $last->addDays(6);
                    elseif ($dplan->increment_interval == 'Daily') $nextDrop = $last->addHours(20);
                    elseif ($dplan->increment_interval == 'Hourly') $nextDrop = $last->addMinutes(49);
                    elseif ($dplan->increment_interval == 'Every 30 Minutes') $nextDrop = $last->addMinutes(25);
                    else $nextDrop = $last->addMinutes(10);

                    if ($now->greaterThan($plan->expire_date)) {
                        if ($settings->return_capital) {
                            User::whereKey($user->id)->increment('account_bal', $plan->amount);
                            $th = new Tp_Transaction();
                            $th->plan = $dplan->name;
                            $th->user = $user->id;
                            $th->amount = $plan->amount;
                            $th->user_plan_id = $plan->id;
                            $th->type = 'Investment capital';
                            $th->save();
                        }
                        $plan->active = 'expired';
                        $plan->save();
                        $this->createUserNotification($user->id, 'Investment Plan Completed',
                            "Your investment plan '{$dplan->name}' has been completed. Total profit earned: {$user->currency}{$plan->profit_earned}",
                            'info', $plan->id, 'Investment');
                        if ($user->sendinvplanemail == 'Yes') {
                            $completionMail = [
                                'email' => $user->email, 'name' => $user->name,
                                'currency' => $user->currency, 'amount' => $plan->amount,
                                'plan' => $dplan->name, 'site' => $settings->site_name,
                            ];
                        }
                        return;
                    }
                    if ($user->trade_mode != 'on' || $now->lessThan($nextDrop)) return;
                    if ($now->isWeekend() && $settings->weekend_trade != 'on') {
                        $plan->last_growth = $nextDrop;
                        $plan->save();
                        return;
                    }
                    $increment = $dplan->increment_type == 'Percentage'
                        ? (floatval($plan->amount) * floatval($dplan->increment_amount)) / 100
                        : floatval($dplan->increment_amount);
                    User::whereKey($user->id)->increment('roi', $increment);
                    User::whereKey($user->id)->increment('account_bal', $increment);
                    $th = new Tp_Transaction();
                    $th->plan = $dplan->name;
                    $th->user = $user->id;
                    $th->amount = $increment;
                    $th->user_plan_id = $plan->id;
                    $th->type = 'ROI';
                    $th->save();
                    $plan->last_growth = $nextDrop;
                    $plan->profit_earned = $plan->profit_earned + $increment;
                    $plan->save();
                    $this->createUserNotification($user->id, 'ROI Earnings Received',
                        "You have received a return of {$user->currency}{$increment} from your investment in {$dplan->name}.",
                        'success', $th->id, 'Tp_Transaction');
                }, 3);
                if ($completionMail) {
                    try {
                        $obj = new \stdClass();
                        $obj->receiver_email = $completionMail['email'];
                        $obj->receiver_plan = $completionMail['plan'];
                        $obj->received_amount = $completionMail['currency'] . $completionMail['amount'];
                        $obj->sender = $completionMail['site'];
                        $obj->receiver_name = $completionMail['name'];
                        $obj->date = Carbon::now();
                        $obj->subject = 'Investment plan closed';
                        Mail::to($completionMail['email'])->send(new endplan($obj));
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::error('Investment completion email failed: ' . $e->getMessage());
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Legacy ROI processing failed for investment ' . $id . ': ' . $e->getMessage());
                throw $e; // Stop the batch: never silently report financial processing as successful.
            }
        }
    }

    /**
     * Settle each matured trade atomically; its active-state transition is the replay guard.
     */
    public function automaticTradingProfit()
    {
        $settings = Settings::find(1);
        if (!$settings || $settings->trade_mode != 'on') return;
        $ids = User_plans::where('active', 'yes')->pluck('id');
        foreach ($ids as $id) {
            $mailData = null;
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($id, &$mailData) {
                    $trade = User_plans::whereKey($id)->lockForUpdate()->first();
                    if (!$trade || $trade->active !== 'yes' || !now()->greaterThan($trade->expire_date)) return;
                    $user = User::whereKey($trade->user)->lockForUpdate()->first();
                    if (!$user) return;
                    $profitResult = $this->calculateTradingResult($trade);
                    if ($profitResult['result'] == 'WIN') {
                        $profit = (floatval($trade->amount) * floatval($profitResult['percentage'])) / 100;
                        User::whereKey($user->id)->increment('roi', $profit);
                        User::whereKey($user->id)->increment('account_bal', $trade->amount + $profit);
                        $trade->profit_earned = ($trade->profit_earned ?? 0) + $profit;
                        Tp_Transaction::create(['user' => $user->id, 'plan' => $trade->assets,
                            'amount' => $profit, 'type' => 'WIN', 'leverage' => $profitResult['percentage']]);
                        Tp_Transaction::create(['user' => $user->id, 'plan' => $trade->assets,
                            'amount' => $trade->amount, 'type' => 'Trading capital return', 'leverage' => 0]);
                        $this->createUserNotification($user->id, 'Trading Profit Generated',
                            "Your {$trade->assets} trade has completed successfully with a profit of {$user->currency}{$profit} ({$profitResult['percentage']}%).",
                            'success', $trade->id, 'User_plans');
                    } else {
                        $actualLoss = (floatval($trade->amount) * floatval($profitResult['loss_percentage'])) / 100;
                        $refundAmount = floatval($trade->amount) - $actualLoss;
                        $trade->profit_earned = ($trade->profit_earned ?? 0) - $actualLoss;
                        if ($refundAmount > 0) {
                            User::whereKey($user->id)->increment('account_bal', $refundAmount);
                            Tp_Transaction::create(['user' => $user->id, 'plan' => $trade->assets,
                                'amount' => $refundAmount, 'type' => 'Trading capital refund', 'leverage' => 0]);
                        }
                        Tp_Transaction::create(['user' => $user->id, 'plan' => $trade->assets,
                            'amount' => $actualLoss, 'type' => 'LOSE', 'leverage' => $profitResult['loss_percentage']]);
                        $this->createUserNotification($user->id, 'Trading Loss',
                            "Your {$trade->assets} trade resulted in a {$profitResult['loss_percentage']}% loss ({$user->currency}{$actualLoss}). Due to leverage protection, {$user->currency}{$refundAmount} has been refunded to your account.",
                            'warning', $trade->id, 'User_plans');
                    }
                    $trade->active = 'expired';
                    $trade->save();
                    $user->trade = 0;
                    $user->save();
                    if ($user->sendroiemail == 'Yes') {
                        $mailData = ['email' => $user->email, 'name' => $user->name,
                            'message' => "Your {$trade->assets} trade has been completed with a {$profitResult['result']} result.",
                            'subject' => "Trading Result: {$profitResult['result']}"];
                    }
                }, 3);
                if ($mailData) {
                    try {
                        Mail::to($mailData['email'])->send(new NewNotification($mailData['message'], $mailData['subject'], $mailData['name']));
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::error('Trading settlement email failed: ' . $e->getMessage());
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Trading settlement failed for trade ' . $id . ': ' . $e->getMessage());
                throw $e;
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
