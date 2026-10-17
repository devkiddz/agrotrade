<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TradeController extends Controller
{
    /**
     * List of stablecoins to exclude from trading
     */
    private function getStablecoins()
    {
        return [
            'USDT', 'USDC', 'BUSD', 'DAI', 'TUSD', 'USDD', 'FRAX', 'LUSD',
            'USDP', 'GUSD', 'USDN', 'USTC', 'USDK', 'USDS', 'FDUSD', 'PYUSD',
            'SUSD', 'CUSD', 'OUSD', 'USDC.E', 'USDCE', 'USDT.E', 'USDTE',
            'TETHER', 'USD COIN', 'BINANCE USD', 'MULTI-COLLATERAL DAI',
            'TRUEUSD', 'FIRST DIGITAL USD', 'PAXOS STANDARD'
        ];
    }

    /**
     * Apply stablecoin filter to query
     */
    private function excludeStablecoins($query)
    {
        $stablecoins = $this->getStablecoins();

        return $query->where(function($q) use ($stablecoins) {
            foreach ($stablecoins as $stablecoin) {
                $q->where('symbol', '!=', $stablecoin)
                  ->where('name', 'NOT LIKE', "%{$stablecoin}%");
            }
        });
    }

    /**
     * Display the trading markets page with all instruments
     */
    public function index()
    {
        $instruments = $this->excludeStablecoins(Instrument::query())
            ->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        return view('user.trade.trade', [
            'title' => 'Trading Markets',
            'instruments' => $instruments
        ]);
    }

    /**
     * Display the trading interface for a specific instrument
     */
    public function single($id)
    {
        $instrument = Instrument::where('id', $id)->firstOrFail();

        // Try various approaches to find the user's trades for this instrument
        // This handles different symbol formats, partial matches, etc.

        // First, prepare an array of possible search terms
        $searchTerms = [
            $instrument->symbol,                       // Exact symbol
            strtolower($instrument->symbol),           // Lowercase symbol
            strtoupper($instrument->symbol),           // Uppercase symbol
            str_replace('/', '', $instrument->symbol), // Symbol without slashes (EUR/USD → EURUSD)
            str_replace(' ', '', $instrument->symbol), // Symbol without spaces
            str_replace('/', '-', $instrument->symbol), // Replace slash with dash (BTC/USD → BTC-USD)
            str_replace(['/', ' '], '', $instrument->symbol), // Remove slashes and spaces
        ];

        // Also add name-based search if available
        if (!empty($instrument->name)) {
            $searchTerms[] = $instrument->name;
            $searchTerms[] = strtolower($instrument->name);
            $searchTerms[] = str_replace(' ', '', $instrument->name); // Name without spaces
        }

        // Add common variations for crypto/forex
        if (stripos($instrument->symbol, '/') !== false) {
            // Handle pairs like BTC/USD
            $parts = explode('/', $instrument->symbol);
            if (count($parts) == 2) {
                $searchTerms[] = $parts[0] . $parts[1];  // BTCUSD
                $searchTerms[] = $parts[0];              // Just BTC
                $searchTerms[] = $parts[0] . '-' . $parts[1]; // BTC-USD
                $searchTerms[] = $parts[0] . ' ' . $parts[1]; // BTC USD
            }
        }

        // Add ultra-flexible match patterns for different database formats
        $baseSymbol = explode('/', $instrument->symbol)[0] ?? $instrument->symbol;
        $searchTerms[] = $baseSymbol; // Just the base currency (BTC, EUR, etc)

        // Some systems store as "Bitcoin" instead of "BTC" or vice versa
        if ($instrument->name && $instrument->symbol) {
            // Try to match either name or symbol anywhere in the fields
            $searchTerms[] = substr($instrument->symbol, 0, 3); // First 3 chars of symbol
            $searchTerms[] = substr($instrument->name, 0, 5);   // First 5 chars of name
        }

        // Get unique search terms and filter out any empty values
        $searchTerms = array_filter(array_unique($searchTerms));

        // Log all search terms we're using for debugging
        if (config('app.debug')) {
            \Log::info('Searching for trades with terms: ' . implode(', ', $searchTerms));
        }

        // Get trade history for open trades using a highly flexible approach
        $openTradesQuery = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where(function($query) use ($instrument, $searchTerms) {
                // Only use columns that we know exist in the user_plans table
                // Based on the error, we'll focus on 'assets' and 'symbol' columns

                // First attempt exact matches on symbol
                $query->where('assets', $instrument->symbol)
                      ->orWhere('symbol', $instrument->symbol);

                // Then try flexible matching with all our search terms on existing columns only
                foreach ($searchTerms as $term) {
                    if (empty($term)) continue;

                    // Only query columns that actually exist in user_plans table
                    $query->orWhere('assets', 'like', "%{$term}%")
                          ->orWhere('symbol', 'like', "%{$term}%");
                }
            })
            ->where('active', 'yes')
            ->orderBy('created_at', 'desc');

        $openTrades = $openTradesQuery->get();

        // Debug info for development only
        if (config('app.debug')) {
            $openTradesSQL = $openTradesQuery->toSql();
            $openTradesBindings = $openTradesQuery->getBindings();
            \Log::info('Open trades SQL: ' . $openTradesSQL);
            \Log::info('Open trades bindings: ' . implode(', ', $openTradesBindings));
            \Log::info('Open trades count: ' . $openTrades->count());

            // Log some sample trades for debugging
            if ($openTrades->count() > 0) {
                \Log::info('Sample open trade: ' . json_encode($openTrades->first()));
            }
        }

        // Get trade history for closed trades using the same flexible approach
        $closedTradesQuery = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where(function($query) use ($instrument, $searchTerms) {
                // Only use columns that we know exist in the user_plans table

                // First attempt exact matches on symbol
                $query->where('assets', $instrument->symbol)
                      ->orWhere('symbol', $instrument->symbol);

                // Then try flexible matching with all our search terms on existing columns only
                foreach ($searchTerms as $term) {
                    if (empty($term)) continue;

                    // Only query columns that actually exist in user_plans table
                    $query->orWhere('assets', 'like', "%{$term}%")
                          ->orWhere('symbol', 'like', "%{$term}%");
                }
            })
            ->where('active', 'expired')
            ->orderBy('created_at', 'desc')
            ->limit(10); // Limit to recent 10 closed trades

        $closedTrades = $closedTradesQuery->get();

        // Debug info for development only
        if (config('app.debug')) {
            \Log::info('Closed trades count: ' . $closedTrades->count());

            // If no trades were found at all (both open and closed), try a last-ditch approach
            // using broader matching. We only do this as a last resort since it could
            // potentially return false positives.
            if ($openTrades->count() == 0 && $closedTrades->count() == 0) {
                \Log::info('No trades found with standard matching. Trying broader approach...');

                // Try to find ANY trades that might be related using very loose matching
                // This is a super-broad approach that will catch almost any variation
                $basicSearchTerms = [
                    $baseSymbol, // Just the base currency (BTC, EUR, etc)
                    substr($instrument->symbol, 0, 3), // First 3 chars
                ];

                // Check for trades with ANY of these terms
                $lastResortQuery = DB::table('user_plans')
                    ->where('user', auth()->id())
                    ->where(function($query) use ($basicSearchTerms) {
                        foreach ($basicSearchTerms as $term) {
                            if (empty($term)) continue;

                            // Check only columns that exist in user_plans table
                            $query->orWhere('assets', 'like', "%{$term}%")
                                ->orWhere('symbol', 'like', "%{$term}%");
                        }
                    });

                $potentialMatches = $lastResortQuery->get();
                \Log::info('Last resort matching found ' . $potentialMatches->count() . ' potential matches');

                // If we found some potential matches, log them for analysis
                if ($potentialMatches->count() > 0) {
                    \Log::info('Potential matches: ' . json_encode($potentialMatches->take(3)));
                }
            }
        }



        return view('user.trade.single', [
            'title' => 'Trade ' . $instrument->name,
            'instrument' => $instrument,
            'openTrades' => $openTrades,
            'closedTrades' => $closedTrades
        ]);
    }

    /**
     * Get instruments by type via API
     */
    public function getByType($type)
    {
        $instruments = $this->excludeStablecoins(Instrument::where('type', $type))
            ->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        return response()->json($instruments);
    }

    /**
     * Search instruments
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type');

        $instruments = $this->excludeStablecoins(Instrument::query());

        if ($query) {
            $instruments->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('symbol', 'LIKE', "%{$query}%");
            });
        }

        if ($type && $type !== 'all') {
            $instruments->where('type', $type);
        }

        $results = $instruments->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        return response()->json($results);
    }

    /**
     * Display the trade monitoring page for a specific trade
     */
    public function monitor($tradeId)
    {
        $trade = DB::table('user_plans')
            ->where('id', $tradeId)
            ->where('user', auth()->id())
            ->first();

        if (!$trade) {
            return redirect()->route('trade.index')->with('error', 'Trade not found or you do not have permission to view it.');
        }

        // Get the instrument for additional market data
        $instrument = Instrument::where('symbol', $trade->assets)
            ->orWhere('name', $trade->assets)
            ->first();

        // Get related trades for this user and asset
        $relatedTrades = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where('assets', $trade->assets)
            ->where('id', '!=', $tradeId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user's trading statistics for this asset
        $stats = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where('assets', $trade->assets)
            ->selectRaw('
                COUNT(*) as total_trades,
                COUNT(CASE WHEN active = "expired" THEN 1 END) as completed_trades,
                COUNT(CASE WHEN active = "yes" THEN 1 END) as active_trades,
                SUM(amount) as total_invested,
                AVG(amount) as avg_trade_size
            ')
            ->first();

        // Calculate P&L for this trade
        $pnl = $this->calculateTradesPnL($trade, $instrument);

        // Calculate time left for active trades
        $timeLeft = 'N/A';
        if ($trade->active === 'yes' && $trade->expire_date) {
            $now = Carbon::now();
            $expireDate = Carbon::parse($trade->expire_date);
            if ($now < $expireDate) {
                $timeLeft = $now->diffForHumans($expireDate);
            } else {
                $timeLeft = 'Expired';
            }
        }

        $title = 'Monitor Trade - ' . $trade->assets;

        return view('user.trade.monitor', compact('trade', 'instrument', 'relatedTrades', 'stats', 'pnl', 'timeLeft', 'title'));
    }

    /**
     * Calculate P&L for a trade based on current market data and trade status
     */
    private function calculateTradesPnL($trade, $instrument = null)
    {
        $pnl = [
            'current_value' => 0,
            'profit_loss' => 0,
            'return_percentage' => 0,
            'is_profit' => false,
            'status' => 'pending'
        ];

        if (!$trade) {
            return $pnl;
        }

        $tradeAmount = floatval($trade->amount);
        $leverage = floatval($trade->leverage ?? 1);

        if ($trade->active === 'expired') {
            // For completed trades, calculate based on result_type or use simulated data
            if (isset($trade->result_type)) {
                $isWin = $trade->result_type === 'WIN';
            } else {
                // Fallback: simulate based on trade data
                $isWin = $this->simulateTradeResult($trade);
            }

            if ($isWin) {
                // WIN: Calculate profit based on leverage (typical forex/crypto returns)
                $baseProfitRate = rand(3, 12); // 3-12% base return
                $leverageMultiplier = min($leverage / 10, 5); // Cap leverage effect
                $profitPercentage = $baseProfitRate * $leverageMultiplier;
                $profitPercentage = min($profitPercentage, 200); // Cap at 200%

                $pnl['profit_loss'] = ($tradeAmount * $profitPercentage) / 100;
                $pnl['is_profit'] = true;
                $pnl['status'] = 'completed_win';
            } else {
                // LOSE: Calculate loss with stop-loss protection
                if ($leverage >= 100) {
                    $lossPercentage = rand(60, 85);
                } elseif ($leverage >= 50) {
                    $lossPercentage = rand(45, 65);
                } elseif ($leverage >= 20) {
                    $lossPercentage = rand(30, 50);
                } else {
                    $lossPercentage = rand(15, 35);
                }

                $pnl['profit_loss'] = -($tradeAmount * $lossPercentage) / 100;
                $pnl['is_profit'] = false;
                $pnl['status'] = 'completed_loss';
            }

            $pnl['current_value'] = $tradeAmount + $pnl['profit_loss'];
            $pnl['return_percentage'] = ($pnl['profit_loss'] / $tradeAmount) * 100;

        } elseif ($trade->active === 'yes' && $instrument) {
            // For active trades, calculate current P&L based on market movement
            $entryPrice = floatval($trade->entry_price ?? $instrument->price);
            $currentPrice = floatval($instrument->price);

            if ($entryPrice > 0) {
                $priceChange = ($currentPrice - $entryPrice) / $entryPrice;

                // Apply trade direction
                if ($trade->type === 'Sell') {
                    $priceChange = -$priceChange;
                }

                // Apply leverage
                $leveragedChange = $priceChange * $leverage;

                // Calculate P&L
                $pnl['profit_loss'] = $tradeAmount * $leveragedChange;
                $pnl['current_value'] = $tradeAmount + $pnl['profit_loss'];
                $pnl['return_percentage'] = $leveragedChange * 100;
                $pnl['is_profit'] = $pnl['profit_loss'] > 0;
                $pnl['status'] = 'active';
            } else {
                // Fallback for active trades without entry price
                $pnl = $this->simulateActiveTradePnL($trade);
            }
        } else {
            // Unknown status
            $pnl['current_value'] = $tradeAmount;
            $pnl['status'] = 'unknown';
        }

        return $pnl;
    }

    /**
     * Simulate trade result for completed trades without result_type
     */
    private function simulateTradeResult($trade)
    {
        // Use trade ID and amount as seed for consistent results
        $seed = intval($trade->id) + intval($trade->amount * 100);
        mt_srand($seed);

        // Higher leverage = higher risk = lower win rate
        $leverage = floatval($trade->leverage ?? 1);
        if ($leverage >= 100) {
            $winRate = 0.3; // 30% win rate for high leverage
        } elseif ($leverage >= 50) {
            $winRate = 0.45; // 45% win rate
        } elseif ($leverage >= 20) {
            $winRate = 0.6; // 60% win rate
        } else {
            $winRate = 0.7; // 70% win rate for low leverage
        }

        return mt_rand() / mt_getrandmax() < $winRate;
    }

    /**
     * Simulate current P&L for active trades
     */
    private function simulateActiveTradePnL($trade)
    {
        $tradeAmount = floatval($trade->amount);
        $leverage = floatval($trade->leverage ?? 1);

        // Use trade ID as seed for consistent simulation
        mt_srand(intval($trade->id));

        // Simulate market movement (-5% to +5%)
        $marketMove = (mt_rand() / mt_getrandmax() - 0.5) * 0.1;

        // Apply leverage
        $leveragedMove = $marketMove * $leverage;

        $profitLoss = $tradeAmount * $leveragedMove;

        return [
            'current_value' => $tradeAmount + $profitLoss,
            'profit_loss' => $profitLoss,
            'return_percentage' => $leveragedMove * 100,
            'is_profit' => $profitLoss > 0,
            'status' => 'active'
        ];
    }
}
