<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TradingBot;
use App\Models\UserBotInvestment;
use App\Models\BotTradingHistory;
use App\Models\User;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Mail\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Traits\NotificationTrait;

class UserBotController extends Controller
{
    use NotificationTrait;
    /**
     * Display available trading bots
     */
    public function index()
    {
        $bots = TradingBot::active()
                    ->with(['userInvestments'])
                    ->withCount(['userInvestments', 'activeInvestments'])
                    ->get();

        $userInvestments = UserBotInvestment::where('user_id', Auth::id())
                                          ->where('status', 'active')
                                          ->with('bot')
                                          ->get();

        $title = 'Bot Trading';
        return view('user.bot.index', compact('bots', 'userInvestments', 'title'));
    }

    /**
     * Show bot details
     */
    public function show(TradingBot $bot)
    {
        if (!$bot->isAvailable()) {
            return redirect()->route('user.bots.index')->with('error', 'This bot is currently not available.');
        }

        $userInvestment = UserBotInvestment::where('user_id', Auth::id())
                                          ->where('bot_id', $bot->id)
                                          ->where('status', 'active')
                                          ->with('recentTrades')
                                          ->first();

        $recentTrades = collect();
        if ($userInvestment) {
            $recentTrades = $userInvestment->recentTrades;
        }

        // Calculate dynamic bot performance metrics
        $botStats = $this->calculateBotPerformanceMetrics($bot);

        $title = 'Bot Details - ' . $bot->name;
        return view('user.bot.show', compact('bot', 'userInvestment', 'recentTrades', 'botStats', 'title'));
    }

    /**
     * Calculate dynamic bot performance metrics
     */
    private function calculateBotPerformanceMetrics(TradingBot $bot)
    {
        // Get all investments for this bot
        $investments = $bot->userInvestments()->get();

        // Calculate total trades from trading history
        $totalTrades = BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
            $query->where('bot_id', $bot->id);
        })->count();

        // Calculate successful trades
        $successfulTrades = BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
            $query->where('bot_id', $bot->id);
        })->where('result', 'profit')->count();

        // Calculate total profit from all investments
        $totalProfit = $investments->sum('total_profit');

        // Calculate actual success rate
        $actualSuccessRate = $totalTrades > 0 ? round(($successfulTrades / $totalTrades) * 100, 1) : $bot->success_rate;

        // Get expected return (daily profit range average)
        $expectedReturn = ($bot->daily_profit_min + $bot->daily_profit_max) / 2;

        return [
            'success_rate' => $actualSuccessRate,
            'total_trades' => $totalTrades,
            'total_profit' => $totalProfit,
            'expected_return' => $expectedReturn,
            'total_users' => $investments->unique('user_id')->count(),
            'active_investments' => $bot->activeInvestments()->count(),
        ];
    }

    /**
     * Invest in a trading bot
     */
    public function invest(Request $request, TradingBot $bot)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $bot->min_investment . '|max:' . $bot->max_investment,
            'auto_reinvest' => 'boolean',
            'reinvest_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $amount = $request->amount;

        // Check if bot is available
        if (!$bot->isAvailable()) {
            return back()->with('error', 'This bot is currently not available for investment.');
        }

        // Check if user has sufficient balance
        if ($user->account_bal < $amount) {
            return back()->with('error', 'Insufficient account balance. Please fund your account first.');
        }

        // Check if user already has an active investment with this bot
        $existingInvestment = UserBotInvestment::where('user_id', $user->id)
                                              ->where('bot_id', $bot->id)
                                              ->where('status', 'active')
                                              ->first();

        if ($existingInvestment) {
            return back()->with('error', 'You already have an active investment with this bot.');
        }

        DB::beginTransaction();
        try {
            // Debug: Log current balance and amount
            \Log::info('Bot Investment - Before deduction', [
                'user_id' => $user->id,
                'current_balance' => $user->account_bal,
                'investment_amount' => $amount,
                'bot_id' => $bot->id
            ]);

            // Deduct amount from user balance
            $newBalance = $user->account_bal - $amount;

            // Ensure the balance is not negative (additional safety check)
            if ($newBalance < 0) {
                throw new \Exception('Insufficient balance for this investment.');
            }

            $userUpdated = $user->update([
                'account_bal' => $newBalance
            ]);

            if (!$userUpdated) {
                throw new \Exception('Failed to update user balance.');
            }

            // Refresh the user model to ensure we have the latest data
            $user->refresh();

            // Debug: Log after deduction
            \Log::info('Bot Investment - After deduction', [
                'user_id' => $user->id,
                'new_balance' => $user->account_bal,
                'expected_balance' => $newBalance
            ]);
            $user->refresh();

            // Create bot investment
            $investment = UserBotInvestment::create([
                'user_id' => $user->id,
                'bot_id' => $bot->id,
                'investment_amount' => $amount,
                'current_balance' => $amount,
                'started_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays($bot->duration_days),
                'auto_reinvest' => $request->boolean('auto_reinvest'),
                'reinvest_percentage' => $request->reinvest_percentage ?? 0,
                'status' => 'active',
            ]);

            // Record transaction
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Bot Investment - {$bot->name}",
                'amount' => $amount,
                'type' => 'Bot Investment',
                'status' => 'Processed',
            ]);

            // Update bot statistics
            $bot->increment('total_users');

            // Send notification email
            if ($user->sendroiemail == 'Yes') {
                try {
                    $message = "You have successfully invested {$amount} in the {$bot->name} trading bot. Your investment will be active for {$bot->duration_days} days.";
                    $subject = "Bot Investment Confirmed - {$bot->name}";
                    Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send bot investment email: ' . $e->getMessage());
                }
            }

            // Send in-app notification for bot purchase
            try {
                $settings = Settings::find(1);
                $this->sendBotPurchaseNotification($bot->name, $amount, $settings->currency, $investment->id);
            } catch (\Exception $e) {
                \Log::error('Failed to send bot purchase notification: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('user.bots.dashboard')->with('success', 'Successfully invested in ' . $bot->name . '!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bot investment failed: ' . $e->getMessage());
            return back()->with('error', 'Investment failed. Please try again.');
        }
    }

    /**
     * Cancel bot investment
     */
    public function cancel(UserBotInvestment $investment)
    {
        $user = Auth::user();

        // Check if investment belongs to current user
        if ($investment->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if investment is active
        if ($investment->status !== 'active') {
            return back()->with('error', 'This investment is not active.');
        }

        DB::beginTransaction();
        try {
            // Calculate refund amount (investment + profits - losses)
            $refundAmount = $investment->current_balance;

            // Update user balance
            $user->update([
                'account_bal' => $user->account_bal + $refundAmount
            ]);

            // Update investment status
            $investment->update([
                'status' => 'cancelled'
            ]);

            // Record transaction
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Bot Investment Cancelled - {$investment->bot->name}",
                'amount' => $refundAmount,
                'type' => 'Bot Investment Refund',
                'status' => 'Processed',
            ]);

            // Send notification email
            if ($user->sendroiemail == 'Yes') {
                try {
                    $message = "Your investment in {$investment->bot->name} has been cancelled and {$refundAmount} has been refunded to your account.";
                    $subject = "Bot Investment Cancelled";
                    Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send bot cancellation email: ' . $e->getMessage());
                }
            }

            DB::commit();
            return redirect()->route('user.bots.dashboard')->with('success', 'Investment cancelled successfully. Refund processed.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bot investment cancellation failed: ' . $e->getMessage());
            return back()->with('error', 'Cancellation failed. Please try again.');
        }
    }

    /**
     * User bot trading dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        $investments = UserBotInvestment::where('user_id', $user->id)
                                       ->with(['bot', 'tradingHistory'])
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        $activeInvestments = $investments->where('status', 'active');

        $stats = [
            'total_invested' => $investments->sum('investment_amount'),
            'current_balance' => $activeInvestments->sum('current_balance'),
            'total_profit' => $investments->sum('total_profit'),
            'total_loss' => $investments->sum('total_loss'),
            'active_bots' => $activeInvestments->count(),
        ];

        $recentTrades = BotTradingHistory::whereHas('userBotInvestment', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['userBotInvestment.bot'])->latest('opened_at')->limit(10)->get();

        $title = 'Bot Trading Dashboard';
        return view('user.bot.dashboard', compact('investments', 'stats', 'recentTrades', 'title'));
    }

    /**
     * Show trading history for specific investment
     */
    public function history(UserBotInvestment $investment)
    {
        $user = Auth::user();

        // Check if investment belongs to current user
        if ($investment->user_id !== $user->id) {
            return redirect()->route('user.bots.dashboard')->with('error', 'Unauthorized action.');
        }

        $trades = $investment->tradingHistory()
                            ->orderBy('opened_at', 'desc')
                            ->paginate(20);

        $title = 'Trading History - ' . $investment->bot->name;
        return view('user.bot.history', compact('investment', 'trades', 'title'));
    }

    /**
     * Get investment analytics data
     */
    public function analytics(UserBotInvestment $investment)
    {
        $user = Auth::user();

        // Check if investment belongs to current user
        if ($investment->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get daily profits for the last 30 days
        $dailyProfits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $profit = $investment->tradingHistory()
                                ->whereDate('closed_at', $date)
                                ->sum('profit_loss');

            $dailyProfits[] = [
                'date' => $date,
                'profit' => (float) $profit
            ];
        }

        return response()->json([
            'daily_profits' => $dailyProfits,
            'total_trades' => $investment->tradingHistory()->count(),
            'successful_trades' => $investment->tradingHistory()->where('result', 'profit')->count(),
            'success_rate' => $investment->success_rate,
            'roi_percentage' => $investment->roi_percentage,
        ]);
    }
}
