<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingBot;
use App\Models\UserBotInvestment;
use App\Models\BotTradingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BotController extends Controller
{
    /**
     * Display a listing of trading bots
     */
    public function index()
    {
        $bots = TradingBot::with(['userInvestments'])
                    ->withCount(['userInvestments', 'activeInvestments'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $stats = [
            'total_bots' => TradingBot::count(),
            'active_bots' => TradingBot::where('status', 'active')->count(),
            'total_investments' => UserBotInvestment::sum('investment_amount'),
            'total_profits' => UserBotInvestment::sum('total_profit'),
        ];

        $title = "Trading Bots Management";

        return view('admin.bots.index', compact('bots', 'stats', 'title'));
    }

    /**
     * Show the form for creating a new bot
     */
    public function create()
    {
        $botTypes = [
            'forex' => 'Forex Trading',
            'crypto' => 'Cryptocurrency',
            'stocks' => 'Stock Market',
            'commodities' => 'Commodities',
            'indices' => 'Market Indices'
        ];

        $tradingPairs = [
            'forex' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'USD/CHF', 'AUD/USD', 'USD/CAD'],
            'crypto' => ['BTC/USD', 'ETH/USD', 'BNB/USD', 'ADA/USD', 'SOL/USD', 'DOT/USD'],
            'stocks' => ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'META'],
            'commodities' => ['GOLD', 'SILVER', 'OIL', 'COPPER', 'WHEAT', 'NATURAL_GAS'],
            'indices' => ['S&P500', 'NASDAQ', 'DOW', 'FTSE', 'DAX', 'NIKKEI']
        ];

        $title = "Create New Trading Bot";

        return view('admin.bots.create', compact('botTypes', 'tradingPairs', 'title'));
    }

    /**
     * Store a newly created bot
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:trading_bots,name',
            'bot_type' => 'required|string|in:forex,crypto,stocks,commodities,indices',
            'description' => 'required|string|min:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'min_investment' => 'required|numeric|min:1|max:999999',
            'max_investment' => 'required|numeric|min:1|max:999999',
            'daily_profit_min' => 'required|numeric|min:0.1|max:100',
            'daily_profit_max' => 'required|numeric|min:0.1|max:100',
            'success_rate' => 'required|integer|min:50|max:99',
            'duration_days' => 'required|integer|min:1|max:365',
            'trading_pairs' => 'required|array|min:1',
            'trading_pairs.*' => 'required|string',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validate min/max investment logic
        if ($request->min_investment >= $request->max_investment) {
            return back()->with('error', 'Maximum investment must be greater than minimum investment')->withInput();
        }

        // Validate profit range logic
        if ($request->daily_profit_min >= $request->daily_profit_max) {
            return back()->with('error', 'Maximum daily profit must be greater than minimum daily profit')->withInput();
        }

        $botData = $request->except(['image', '_token']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bots', 'public');
            $botData['image'] = $imagePath;
        }

        // Prepare additional data
        $botData['risk_settings'] = [
            'stop_loss' => $request->input('stop_loss', 5), // Default 5%
            'take_profit' => $request->input('take_profit', 10), // Default 10%
            'max_trades_per_day' => $request->input('max_trades_per_day', 5),
            'risk_per_trade' => $request->input('risk_per_trade', 2), // 2% per trade
        ];

        $botData['strategy_details'] = [
            'algorithm' => $request->input('algorithm', 'Advanced AI Algorithm'),
            'indicators' => $request->input('indicators', ['RSI', 'MACD', 'Moving Averages']),
            'timeframe' => $request->input('timeframe', '1H'),
            'market_analysis' => $request->input('market_analysis', 'Technical & Fundamental'),
        ];

        TradingBot::create($botData);

        return redirect()->route('admin.bots.index')->with('success', 'Trading bot created successfully!');
    }

    /**
     * Display the specified bot
     */
    public function show(TradingBot $bot)
    {
        $bot->load(['userInvestments.user', 'activeInvestments']);

        // Calculate average success rate safely
        $avgSuccessfulTrades = $bot->userInvestments()->avg('successful_trades') ?? 0;
        $avgFailedTrades = $bot->userInvestments()->avg('failed_trades') ?? 0;
        $totalTrades = $avgSuccessfulTrades + $avgFailedTrades;

        $stats = [
            'total_users' => $bot->userInvestments()->distinct('user_id')->count(),
            'active_investments' => $bot->activeInvestments()->count(),
            'total_invested' => $bot->userInvestments()->sum('investment_amount'),
            'total_profits' => $bot->userInvestments()->sum('total_profit'),
            'avg_success_rate' => $totalTrades > 0 ? ($avgSuccessfulTrades / $totalTrades) * 100 : 0,
        ];

        $recentTrades = BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
            $query->where('bot_id', $bot->id);
        })->with(['userBotInvestment.user'])->latest('opened_at')->limit(20)->get();

        $title = "Bot Details - " . $bot->name;

        return view('admin.bots.show', compact('bot', 'stats', 'recentTrades', 'title'));
    }

    /**
     * Show the form for editing the specified bot
     */
    public function edit(TradingBot $bot)
    {
        $botTypes = [
            'forex' => 'Forex Trading',
            'crypto' => 'Cryptocurrency',
            'stocks' => 'Stock Market',
            'commodities' => 'Commodities',
            'indices' => 'Market Indices'
        ];

        $tradingPairs = [
            'forex' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'USD/CHF', 'AUD/USD', 'USD/CAD'],
            'crypto' => ['BTC/USD', 'ETH/USD', 'BNB/USD', 'ADA/USD', 'SOL/USD', 'DOT/USD'],
            'stocks' => ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'META'],
            'commodities' => ['GOLD', 'SILVER', 'OIL', 'COPPER', 'WHEAT', 'NATURAL_GAS'],
            'indices' => ['S&P500', 'NASDAQ', 'DOW', 'FTSE', 'DAX', 'NIKKEI']
        ];

        $title = "Edit Bot - " . $bot->name;

        return view('admin.bots.edit', compact('bot', 'botTypes', 'tradingPairs', 'title'));
    }

    /**
     * Update the specified bot
     */
    public function update(Request $request, TradingBot $bot)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:trading_bots,name,' . $bot->id,
            'bot_type' => 'required|string|in:forex,crypto,stocks,commodities,indices',
            'description' => 'required|string|min:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'min_investment' => 'required|numeric|min:1|max:999999',
            'max_investment' => 'required|numeric|min:1|max:999999',
            'daily_profit_min' => 'required|numeric|min:0.1|max:100',
            'daily_profit_max' => 'required|numeric|min:0.1|max:100',
            'success_rate' => 'required|integer|min:50|max:99',
            'duration_days' => 'required|integer|min:1|max:365',
            'trading_pairs' => 'required|array|min:1',
            'trading_pairs.*' => 'required|string',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $botData = $request->except(['image', '_token', '_method']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bot->image && Storage::disk('public')->exists($bot->image)) {
                Storage::disk('public')->delete($bot->image);
            }

            $imagePath = $request->file('image')->store('bots', 'public');
            $botData['image'] = $imagePath;
        }

        // Update additional data
        $botData['risk_settings'] = [
            'stop_loss' => $request->input('stop_loss', 5),
            'take_profit' => $request->input('take_profit', 10),
            'max_trades_per_day' => $request->input('max_trades_per_day', 5),
            'risk_per_trade' => $request->input('risk_per_trade', 2),
        ];

        $botData['strategy_details'] = [
            'algorithm' => $request->input('algorithm', 'Advanced AI Algorithm'),
            'indicators' => $request->input('indicators', ['RSI', 'MACD', 'Moving Averages']),
            'timeframe' => $request->input('timeframe', '1H'),
            'market_analysis' => $request->input('market_analysis', 'Technical & Fundamental'),
        ];

        $bot->update($botData);

        return redirect()->route('admin.bots.show', $bot)->with('success', 'Trading bot updated successfully!');
    }

    /**
     * Remove the specified bot
     */
    public function destroy(TradingBot $bot)
    {
        // Check if bot has active investments
        if ($bot->activeInvestments()->count() > 0) {
            return back()->with('error', 'Cannot delete bot with active investments. Please wait for all investments to complete.');
        }

        // Delete bot image if exists
        if ($bot->image && Storage::disk('public')->exists($bot->image)) {
            Storage::disk('public')->delete($bot->image);
        }

        $bot->delete();

        return redirect()->route('admin.bots.index')->with('success', 'Trading bot deleted successfully!');
    }

    /**
     * Toggle bot status
     */
    public function toggleStatus(TradingBot $bot)
    {
        $newStatus = $bot->status === 'active' ? 'inactive' : 'active';
        $bot->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Bot activated successfully!' : 'Bot deactivated successfully!';

        return back()->with('success', $message);
    }

    /**
     * Display general bot analytics dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_bots' => TradingBot::count(),
            'active_bots' => TradingBot::where('status', 'active')->count(),
            'total_investments' => UserBotInvestment::sum('investment_amount'),
            'total_profits' => UserBotInvestment::sum('total_profit'),
            'active_investments' => UserBotInvestment::where('status', 'active')->count(),
            'completed_investments' => UserBotInvestment::where('status', 'completed')->count(),
        ];

        // Get top performing bots
        $topBots = TradingBot::withCount(['userInvestments', 'activeInvestments'])
                        ->with(['userInvestments' => function($query) {
                            $query->selectRaw('bot_id, SUM(total_profit) as total_profits')
                                  ->groupBy('bot_id');
                        }])
                        ->orderBy('user_investments_count', 'desc')
                        ->limit(5)
                        ->get();

        // Calculate daily profits for the last 30 days
        $dailyProfits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $profit = BotTradingHistory::whereDate('closed_at', $date)->sum('profit_loss');

            $dailyProfits[] = [
                'date' => $date,
                'profit' => $profit
            ];
        }

        $title = "Bot Trading Analytics";

        return view('admin.bots.dashboard', compact('stats', 'topBots', 'dailyProfits', 'title'));
    }

    /**
     * Get bot analytics data
     */
    public function analytics(TradingBot $bot)
    {
        $investments = $bot->userInvestments()->with(['tradingHistory'])->get();

        // Calculate daily profits for the last 30 days
        $dailyProfits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $profit = BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
                $query->where('bot_id', $bot->id);
            })->whereDate('closed_at', $date)->sum('profit_loss');

            $dailyProfits[] = [
                'date' => $date,
                'profit' => $profit
            ];
        }

        return response()->json([
            'daily_profits' => $dailyProfits,
            'total_trades' => BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
                $query->where('bot_id', $bot->id);
            })->count(),
            'successful_trades' => BotTradingHistory::whereHas('userBotInvestment', function($query) use ($bot) {
                $query->where('bot_id', $bot->id);
            })->where('result', 'profit')->count(),
        ]);
    }
}
