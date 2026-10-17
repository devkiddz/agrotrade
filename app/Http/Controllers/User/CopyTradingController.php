<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\User_copytradings;
use App\Models\Tp_Transaction;
use App\Models\Copytrading;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CopyTradingController extends Controller
{
    /**
     * Display copy trading dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get all user's copy trades
        $copyTrades = User_copytradings::where('user', $user->id)
                                      ->with('expert')
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        // Calculate statistics
        $stats = [
            'active_copies' => $copyTrades->where('active', 'yes')->count(),
            'total_invested' => $copyTrades->where('active', 'yes')->sum('price'),
            'current_balance' => $copyTrades->where('active', 'yes')->sum('current_balance'),
            'total_profit' => $copyTrades->where('active', 'yes')->sum('total_profit'),
        ];

        $title = 'My Copy Trading Dashboard';

        return view('user.copy.dashboard', compact('copyTrades', 'stats', 'title'));
    }

    /**
     * Display available expert traders
     */
    public function experts()
    {
        $experts = Copytrading::where('status', 'active')
                             ->orderBy('rating', 'desc')
                             ->orderBy('win_rate', 'desc')
                             ->get();

        // Get user's active copy trades for checking
        $userCopyTrades = [];
        if (Auth::check()) {
            $userCopyTrades = User_copytradings::where('user', Auth::id())
                                              ->where('active', 'yes')
                                              ->pluck('cptrading')
                                              ->toArray();
        }

        $title = 'Expert Traders';

        return view('user.copy.experts', compact('experts', 'userCopyTrades', 'title'));
    }

    /**
     * Start copying an expert trader
     */
    public function startCopyTrading(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expert_id' => 'required|exists:copytradings,id',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $expertId = $request->expert_id;
        $amount = $request->amount;

        // Get the expert
        $expert = Copytrading::find($expertId);
        if (!$expert || $expert->status !== 'active') {
            return back()->with('error', 'Expert trader not available.');
        }

        // Check minimum investment
        if ($amount < $expert->price) {
            return back()->with('error', "Minimum investment for {$expert->name} is \${$expert->price}.");
        }

        // Check if user has sufficient balance
        if ($user->account_bal < $amount) {
            return back()->with('error', 'Insufficient account balance. Please fund your account first.');
        }

        // Check if user is already copying this expert
        $existingCopy = User_copytradings::where('user', $user->id)
                                        ->where('cptrading', $expertId)
                                        ->where('active', 'yes')
                                        ->first();

        if ($existingCopy) {
            return back()->with('error', "You are already copying {$expert->name}.");
        }

        DB::beginTransaction();
        try {
            // Deduct amount from user balance
            $newBalance = $user->account_bal - $amount;
            $user->update(['account_bal' => $newBalance]);

            // Create copy trading record
            $copyTrade = User_copytradings::create([
                'cptrading' => $expert->id,
                'user' => $user->id,
                'price' => $amount,
                'current_balance' => $amount,
                'active' => 'yes',
                'name' => $expert->name,
                'tag' => $expert->tag ?? '',
                'type' => $expert->type ?? 'expert',
                'started_at' => Carbon::now(),
                'last_profit' => Carbon::now(),
                'total_profit' => 0,
                'total_trades' => 0,
                'winning_trades' => 0,
                'profit_percentage' => 0,
            ]);

            // Record transaction
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Copy Trading - {$expert->name}",
                'amount' => $amount,
                'type' => 'Copy Trading Investment',
                'status' => 'Processed',
            ]);

            // Update expert followers count
            $expert->increment('followers');

            // Send notification email
            if ($user->sendroiemail == 'Yes') {
                try {
                    $message = "You have successfully started copying {$expert->name} with an investment of \${$amount}. You'll receive profits based on the expert's trading performance.";
                    $subject = "Copy Trading Started - {$expert->name}";
                    Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send copy trading email: ' . $e->getMessage());
                }
            }

            DB::commit();
            return redirect()->route('copy.dashboard')
                           ->with('success', "Successfully started copying {$expert->name}!");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Copy trading failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to start copy trading. Please try again.');
        }
    }

    /**
     * Stop copying a specific expert
     */
    public function stopCopyTrading($copyTradeId)
    {
        $user = Auth::user();

        $copyTrade = User_copytradings::where('id', $copyTradeId)
                                     ->where('user', $user->id)
                                     ->where('active', 'yes')
                                     ->first();

        if (!$copyTrade) {
            return back()->with('error', 'Copy trade not found or already stopped.');
        }

        DB::beginTransaction();
        try {
            // Calculate total return (current balance)
            $totalReturn = $copyTrade->current_balance;

            // Stop the copy trade
            $copyTrade->update(['active' => 'no']);

            // Return balance to user
            $user->update([
                'account_bal' => $user->account_bal + $totalReturn
            ]);

            // Record transaction
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Copy Trading Stopped - {$copyTrade->name}",
                'amount' => $totalReturn,
                'type' => 'Copy Trading Return',
                'status' => 'Processed',
            ]);

            // Update expert followers count
            $expert = Copytrading::find($copyTrade->cptrading);
            if ($expert && $expert->followers > 0) {
                $expert->decrement('followers');
            }

            // Send notification email
            if ($user->sendroiemail == 'Yes') {
                try {
                    $profit = $copyTrade->total_profit;
                    $message = "You have stopped copying {$copyTrade->name}. Your total return of \${$totalReturn} (including \${$profit} profit) has been credited to your account.";
                    $subject = "Copy Trading Stopped - {$copyTrade->name}";
                    Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send copy trading stop email: ' . $e->getMessage());
                }
            }

            DB::commit();
            return back()->with('success', 'Copy trading stopped successfully. Balance returned to your account.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Stop copy trading failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to stop copy trading. Please try again.');
        }
    }

    /**
     * Get copy trade details
     */
    public function getCopyTradeDetails($copyTradeId)
    {
        $user = Auth::user();

        $copyTrade = User_copytradings::where('id', $copyTradeId)
                                     ->where('user', $user->id)
                                     ->with('expert')
                                     ->first();

        if (!$copyTrade) {
            return response()->json(['success' => false, 'message' => 'Copy trade not found'], 404);
        }

        // Get recent trades (simulated for now)
        $trades = collect();
        for ($i = 0; $i < 10; $i++) {
            $isProfit = rand(1, 100) <= 70; // 70% win rate simulation
            $profitLoss = $isProfit ? rand(5, 50) : -rand(5, 30);

            $trades->push((object)[
                'id' => $i + 1,
                'pair' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD', 'USD/CHF'][rand(0, 4)],
                'profit_loss' => $profitLoss,
                'created_at' => now()->subDays(rand(0, 30))->toISOString(),
            ]);
        }

        return response()->json([
            'success' => true,
            'copyTrade' => $copyTrade,
            'trades' => $trades->sortByDesc('created_at')->values(),
        ]);
    }

    /**
     * Get analytics data for a copy trade
     */
    public function analytics($copyTradeId)
    {
        try {
            $user = Auth::user();

            $copyTrade = User_copytradings::where('id', $copyTradeId)
                                        ->where('user', $user->id)
                                        ->first();

            if (!$copyTrade) {
                return response()->json(['success' => false, 'message' => 'Copy trade not found'], 404);
            }

            // Get recent trades for this copy position
            // Check if trades table exists first
            if (Schema::hasTable('trades')) {
                $trades = DB::table('trades')
                        ->where('user_id', $user->id)
                        ->where('copy_trade_id', $copyTradeId)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
            } else {
                $trades = [];
            }

            $daysActive = $copyTrade->started_at ? Carbon::parse($copyTrade->started_at)->diffInDays(Carbon::now()) : 0;
            $roi = $copyTrade->profit_percentage ?? 0;

            return response()->json([
                'success' => true,
                'copyTrade' => $copyTrade,
                'trades' => $trades,
                'daysActive' => $daysActive,
                'roi' => number_format($roi, 2),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving analytics data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Automatic profit generation for copy trades (called by scheduler)
     */
    public function automaticCopyTradingProfits()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode !== 'on') {
            return;
        }

        // Get all active copy trades
        $activeCopyTrades = User_copytradings::where('active', 'yes')
                                            ->with(['user', 'expert'])
                                            ->get();

        foreach ($activeCopyTrades as $copyTrade) {
            if (!$copyTrade->user || !$copyTrade->expert) {
                continue;
            }

            try {
                $this->generateCopyTradeProfit($copyTrade);
            } catch (\Exception $e) {
                \Log::error("Failed to generate profit for copy trade {$copyTrade->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Generate profit for a specific copy trade
     */
    private function generateCopyTradeProfit($copyTrade)
    {
        $now = Carbon::now();
        $lastProfit = $copyTrade->last_profit ? Carbon::parse($copyTrade->last_profit) : Carbon::parse($copyTrade->started_at);

        // Generate profits every 2-8 hours
        $hoursToAdd = rand(2, 8);
        $nextProfitTime = $lastProfit->addHours($hoursToAdd);

        if ($now->greaterThanOrEqualTo($nextProfitTime)) {
            // Calculate profit based on expert's performance
            $profitResult = $this->calculateTradeProfit($copyTrade);

            DB::beginTransaction();
            try {
                if ($profitResult['is_profit']) {
                    $profit = $profitResult['amount'];
                    $newBalance = $copyTrade->current_balance + $profit;
                    $totalProfit = $copyTrade->total_profit + $profit;
                    $winningTrades = $copyTrade->winning_trades + 1;
                } else {
                    // Loss
                    $loss = $profitResult['amount'];
                    $newBalance = max(0, $copyTrade->current_balance - $loss);
                    $totalProfit = $copyTrade->total_profit - $loss;
                    $winningTrades = $copyTrade->winning_trades;
                }

                $totalTrades = $copyTrade->total_trades + 1;
                $profitPercentage = (($newBalance - $copyTrade->price) / $copyTrade->price) * 100;

                // Update copy trade record
                $copyTrade->update([
                    'current_balance' => $newBalance,
                    'total_profit' => $totalProfit,
                    'total_trades' => $totalTrades,
                    'winning_trades' => $winningTrades,
                    'profit_percentage' => $profitPercentage,
                    'last_profit' => $now,
                ]);

                // Record transaction
                $transactionType = $profitResult['is_profit'] ? 'Copy Trading Profit' : 'Copy Trading Loss';
                Tp_Transaction::create([
                    'user' => $copyTrade->user,
                    'plan' => "Copy Trading - {$copyTrade->name}",
                    'amount' => $profitResult['amount'],
                    'type' => $transactionType,
                    'status' => 'Processed',
                ]);

                // Send notification for significant profits (> 5% of investment)
                $user = User::find($copyTrade->user);
                if ($user && $user->sendroiemail == 'Yes' && $profitResult['is_profit'] && $profit > ($copyTrade->price * 0.05)) {
                    try {
                        $message = "Great news! Your copy trading with {$copyTrade->name} generated a profit of \${$profit}. Current balance: \${$newBalance}";
                        $subject = "Copy Trading Profit - {$copyTrade->name}";
                        Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send copy trading profit email: ' . $e->getMessage());
                    }
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }
    }

    /**
     * Calculate trade profit/loss based on expert performance
     */
    private function calculateTradeProfit($copyTrade)
    {
        $expert = $copyTrade->expert;

        // Use expert's win rate to determine if this trade is profitable
        $isProfit = rand(1, 100) <= $expert->win_rate;

        if ($isProfit) {
            // Profit: 0.5% to 4% of current balance
            $profitPercentage = rand(50, 400) / 100;
            $amount = ($copyTrade->current_balance * $profitPercentage) / 100;
        } else {
            // Loss: 0.2% to 2% of current balance
            $lossPercentage = rand(20, 200) / 100;
            $amount = ($copyTrade->current_balance * $lossPercentage) / 100;
        }

        return [
            'is_profit' => $isProfit,
            'amount' => round($amount, 2),
            'percentage' => $isProfit ? $profitPercentage : $lossPercentage,
        ];
    }
}
