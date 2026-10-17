<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TradingBot;
use App\Models\Copytrading;
use App\Models\Settings;

class SetupAdvancedTrading extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:advanced-trading {--force : Force creation even if data exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup advanced trading system with 12 new trading bots and 12 copy trading experts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Setting up Advanced Trading System...');
        $this->info('📊 Adding 12 new trading bots and 12 copy trading experts');
        $this->newLine();

        try {
            $force = $this->option('force');
            
            // Create 12 new advanced trading bots
            $this->info('🤖 Creating 12 advanced trading bots...');
            $this->createAdvancedTradingBots($force);
            
            // Create 12 copy trading experts
            $this->info('👥 Creating 12 copy trading experts...');
            $this->createCopyTradingExperts($force);
            
            $this->newLine();
            $this->info('🎉 Advanced Trading setup completed successfully!');
            $this->info('✅ Total Trading Bots: ' . TradingBot::count());
            $this->info('✅ Total Copy Trading Experts: ' . Copytrading::count());
            
            $this->newLine();
            $this->info('📝 Next steps:');
            $this->info('1. Visit Admin -> Bot Trading to manage trading bots');
            $this->info('2. Visit Admin -> Copy Trading to manage copy trading experts');
            $this->info('3. Users can now choose from expanded bot and copy trading options');

        } catch (\Exception $e) {
            $this->error('Error setting up advanced trading: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Create 12 advanced trading bots
     */
    private function createAdvancedTradingBots($force = false)
    {
        $advancedBots = [
            [
                'name' => 'AlgoTrader Supreme',
                'bot_type' => 'crypto',
                'description' => 'Next-generation algorithmic trading bot powered by quantum computing principles. Specializes in high-frequency crypto arbitrage across multiple exchanges with lightning-fast execution.',
                'min_investment' => 500.00,
                'max_investment' => 100000.00,
                'daily_profit_min' => 2.1,
                'daily_profit_max' => 6.8,
                'success_rate' => 91,
                'duration_days' => 45,
                'status' => 'active',
                'trading_pairs' => ['BTC/USDT', 'ETH/USDT', 'BNB/USDT', 'ADA/USDT', 'SOL/USDT', 'AVAX/USDT'],
                'risk_settings' => [
                    'stop_loss' => 3.5,
                    'take_profit' => 12,
                    'max_trades_per_day' => 15,
                    'risk_per_trade' => 2.8,
                ],
                'strategy_details' => [
                    'algorithm' => 'Quantum ML Algorithm',
                    'indicators' => ['Volume Profile', 'Order Book Analysis', 'Multi-timeframe RSI'],
                    'timeframe' => '1M',
                    'market_analysis' => 'Technical & Arbitrage',
                ]
            ],
            [
                'name' => 'DeFi Yield Hunter',
                'bot_type' => 'crypto',
                'description' => 'Specialized DeFi protocol explorer that identifies the most profitable yield farming opportunities across decentralized exchanges and lending platforms.',
                'min_investment' => 1000.00,
                'max_investment' => 75000.00,
                'daily_profit_min' => 1.8,
                'daily_profit_max' => 5.2,
                'success_rate' => 88,
                'duration_days' => 60,
                'status' => 'active',
                'trading_pairs' => ['UNI/USDT', 'AAVE/USDT', 'COMP/USDT', 'SUSHI/USDT', 'CRV/USDT'],
                'risk_settings' => [
                    'stop_loss' => 4.0,
                    'take_profit' => 10,
                    'max_trades_per_day' => 8,
                    'risk_per_trade' => 2.5,
                ],
                'strategy_details' => [
                    'algorithm' => 'DeFi Yield Optimization',
                    'indicators' => ['APY Analysis', 'Liquidity Depth', 'Impermanent Loss Calculator'],
                    'timeframe' => '4H',
                    'market_analysis' => 'DeFi & Fundamental',
                ]
            ],
            [
                'name' => 'Forex Precision Elite',
                'bot_type' => 'forex',
                'description' => 'Premium forex trading bot utilizing advanced neural networks and sentiment analysis. Designed for institutional-grade precision in major and exotic currency pairs.',
                'min_investment' => 750.00,
                'max_investment' => 50000.00,
                'daily_profit_min' => 1.5,
                'daily_profit_max' => 4.1,
                'success_rate' => 93,
                'duration_days' => 90,
                'status' => 'active',
                'trading_pairs' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD', 'NZD/USD', 'USD/CAD'],
                'risk_settings' => [
                    'stop_loss' => 2.5,
                    'take_profit' => 8,
                    'max_trades_per_day' => 10,
                    'risk_per_trade' => 1.8,
                ],
                'strategy_details' => [
                    'algorithm' => 'Neural Network + Sentiment AI',
                    'indicators' => ['Economic Calendar', 'News Sentiment', 'Correlation Matrix'],
                    'timeframe' => '30M',
                    'market_analysis' => 'Technical & Fundamental & Sentiment',
                ]
            ],
            [
                'name' => 'Stock Momentum Master',
                'bot_type' => 'stocks',
                'description' => 'Advanced momentum trading bot that identifies breakout patterns and trending stocks. Focuses on high-volume stocks with strong directional moves.',
                'min_investment' => 1500.00,
                'max_investment' => 80000.00,
                'daily_profit_min' => 1.2,
                'daily_profit_max' => 3.8,
                'success_rate' => 89,
                'duration_days' => 120,
                'status' => 'active',
                'trading_pairs' => ['AAPL', 'TSLA', 'NVDA', 'AMD', 'GOOGL', 'AMZN', 'META', 'NFLX'],
                'risk_settings' => [
                    'stop_loss' => 3.0,
                    'take_profit' => 9,
                    'max_trades_per_day' => 6,
                    'risk_per_trade' => 2.2,
                ],
                'strategy_details' => [
                    'algorithm' => 'Momentum Detection AI',
                    'indicators' => ['Volume Spike', 'Relative Strength', 'Breakout Patterns'],
                    'timeframe' => '15M',
                    'market_analysis' => 'Technical & Volume Analysis',
                ]
            ],
            [
                'name' => 'Options Gamma Scalper',
                'bot_type' => 'options',
                'description' => 'Sophisticated options trading bot specializing in gamma scalping strategies. Exploits volatility changes and time decay for consistent profits.',
                'min_investment' => 2000.00,
                'max_investment' => 60000.00,
                'daily_profit_min' => 2.5,
                'daily_profit_max' => 7.2,
                'success_rate' => 85,
                'duration_days' => 30,
                'status' => 'active',
                'trading_pairs' => ['SPY', 'QQQ', 'IWM', 'AAPL', 'TSLA', 'AMZN'],
                'risk_settings' => [
                    'stop_loss' => 5.0,
                    'take_profit' => 15,
                    'max_trades_per_day' => 12,
                    'risk_per_trade' => 3.5,
                ],
                'strategy_details' => [
                    'algorithm' => 'Gamma Hedging Algorithm',
                    'indicators' => ['Implied Volatility', 'Greeks', 'Option Flow'],
                    'timeframe' => '5M',
                    'market_analysis' => 'Options & Volatility',
                ]
            ],
            [
                'name' => 'Commodity Weather AI',
                'bot_type' => 'commodities',
                'description' => 'Intelligent commodity trading bot that incorporates weather data, supply chain analysis, and seasonal patterns for agricultural and energy commodities.',
                'min_investment' => 800.00,
                'max_investment' => 40000.00,
                'daily_profit_min' => 1.3,
                'daily_profit_max' => 4.5,
                'success_rate' => 87,
                'duration_days' => 180,
                'status' => 'active',
                'trading_pairs' => ['WHEAT', 'CORN', 'SOYBEANS', 'COFFEE', 'SUGAR', 'COTTON'],
                'risk_settings' => [
                    'stop_loss' => 4.5,
                    'take_profit' => 11,
                    'max_trades_per_day' => 4,
                    'risk_per_trade' => 2.8,
                ],
                'strategy_details' => [
                    'algorithm' => 'Weather Pattern AI',
                    'indicators' => ['Weather Data', 'Supply Reports', 'Seasonal Trends'],
                    'timeframe' => '1D',
                    'market_analysis' => 'Fundamental & Weather',
                ]
            ],
            [
                'name' => 'Energy Futures Pro',
                'bot_type' => 'commodities',
                'description' => 'Professional energy trading bot focused on oil, gas, and renewable energy futures. Uses geopolitical analysis and supply-demand dynamics.',
                'min_investment' => 1200.00,
                'max_investment' => 70000.00,
                'daily_profit_min' => 1.7,
                'daily_profit_max' => 5.1,
                'success_rate' => 83,
                'duration_days' => 90,
                'status' => 'active',
                'trading_pairs' => ['WTI_OIL', 'BRENT_OIL', 'NATURAL_GAS', 'HEATING_OIL', 'GASOLINE'],
                'risk_settings' => [
                    'stop_loss' => 5.5,
                    'take_profit' => 13,
                    'max_trades_per_day' => 5,
                    'risk_per_trade' => 3.2,
                ],
                'strategy_details' => [
                    'algorithm' => 'Energy Market AI',
                    'indicators' => ['Inventory Reports', 'Geopolitical Events', 'Refinery Data'],
                    'timeframe' => '4H',
                    'market_analysis' => 'Fundamental & Geopolitical',
                ]
            ],
            [
                'name' => 'Index Arbitrage Bot',
                'bot_type' => 'indices',
                'description' => 'Advanced arbitrage bot that exploits price differences between index futures and their underlying components. High-frequency execution with minimal risk.',
                'min_investment' => 2500.00,
                'max_investment' => 120000.00,
                'daily_profit_min' => 0.8,
                'daily_profit_max' => 2.5,
                'success_rate' => 95,
                'duration_days' => 365,
                'status' => 'active',
                'trading_pairs' => ['SPX', 'NDX', 'RUT', 'VIX', 'DAX', 'FTSE'],
                'risk_settings' => [
                    'stop_loss' => 1.5,
                    'take_profit' => 4,
                    'max_trades_per_day' => 20,
                    'risk_per_trade' => 1.0,
                ],
                'strategy_details' => [
                    'algorithm' => 'Statistical Arbitrage',
                    'indicators' => ['Basis Spread', 'Fair Value', 'Correlation Analysis'],
                    'timeframe' => '1M',
                    'market_analysis' => 'Statistical & Arbitrage',
                ]
            ],
            [
                'name' => 'Bond Yield Hunter',
                'bot_type' => 'bonds',
                'description' => 'Sophisticated fixed-income trading bot that navigates interest rate changes and yield curve movements. Perfect for institutional-style bond trading.',
                'min_investment' => 5000.00,
                'max_investment' => 200000.00,
                'daily_profit_min' => 0.4,
                'daily_profit_max' => 1.8,
                'success_rate' => 92,
                'duration_days' => 365,
                'status' => 'active',
                'trading_pairs' => ['10Y_TREASURY', '30Y_TREASURY', '2Y_TREASURY', 'CORPORATE_BONDS'],
                'risk_settings' => [
                    'stop_loss' => 2.0,
                    'take_profit' => 5,
                    'max_trades_per_day' => 3,
                    'risk_per_trade' => 1.5,
                ],
                'strategy_details' => [
                    'algorithm' => 'Yield Curve Analysis AI',
                    'indicators' => ['Duration', 'Convexity', 'Credit Spreads'],
                    'timeframe' => '1D',
                    'market_analysis' => 'Interest Rate & Credit',
                ]
            ],
            [
                'name' => 'AI Sentiment Trader',
                'bot_type' => 'mixed',
                'description' => 'Revolutionary sentiment-based trading bot that analyzes social media, news, and market sentiment across multiple asset classes for predictive trading.',
                'min_investment' => 600.00,
                'max_investment' => 35000.00,
                'daily_profit_min' => 1.9,
                'daily_profit_max' => 5.8,
                'success_rate' => 86,
                'duration_days' => 60,
                'status' => 'active',
                'trading_pairs' => ['BTC/USD', 'ETH/USD', 'AAPL', 'TSLA', 'EUR/USD'],
                'risk_settings' => [
                    'stop_loss' => 4.0,
                    'take_profit' => 10,
                    'max_trades_per_day' => 8,
                    'risk_per_trade' => 2.5,
                ],
                'strategy_details' => [
                    'algorithm' => 'Sentiment Analysis AI',
                    'indicators' => ['Social Sentiment', 'News Analysis', 'Fear & Greed Index'],
                    'timeframe' => '1H',
                    'market_analysis' => 'Sentiment & Technical',
                ]
            ],
            [
                'name' => 'Volatility Surface Bot',
                'bot_type' => 'volatility',
                'description' => 'Advanced volatility trading bot that maps and trades the volatility surface across multiple assets. Ideal for sophisticated volatility strategies.',
                'min_investment' => 3000.00,
                'max_investment' => 150000.00,
                'daily_profit_min' => 1.1,
                'daily_profit_max' => 4.2,
                'success_rate' => 88,
                'duration_days' => 45,
                'status' => 'active',
                'trading_pairs' => ['VIX', 'VXX', 'UVXY', 'SVXY', 'VIXY'],
                'risk_settings' => [
                    'stop_loss' => 6.0,
                    'take_profit' => 14,
                    'max_trades_per_day' => 6,
                    'risk_per_trade' => 3.8,
                ],
                'strategy_details' => [
                    'algorithm' => 'Volatility Surface Mapping',
                    'indicators' => ['Implied Volatility', 'Term Structure', 'Skew Analysis'],
                    'timeframe' => '15M',
                    'market_analysis' => 'Volatility & Statistical',
                ]
            ],
            [
                'name' => 'Global Macro Beast',
                'bot_type' => 'mixed',
                'description' => 'Comprehensive macro trading bot that implements global macro strategies across currencies, bonds, commodities, and equities based on economic data.',
                'min_investment' => 10000.00,
                'max_investment' => 500000.00,
                'daily_profit_min' => 0.7,
                'daily_profit_max' => 2.8,
                'success_rate' => 90,
                'duration_days' => 365,
                'status' => 'active',
                'trading_pairs' => ['USD_INDEX', 'EUR/USD', 'GOLD', '10Y_BOND', 'SPX'],
                'risk_settings' => [
                    'stop_loss' => 3.5,
                    'take_profit' => 8,
                    'max_trades_per_day' => 4,
                    'risk_per_trade' => 2.0,
                ],
                'strategy_details' => [
                    'algorithm' => 'Global Macro AI',
                    'indicators' => ['Economic Data', 'Central Bank Policy', 'Global Flows'],
                    'timeframe' => '1D',
                    'market_analysis' => 'Macro Economic & Fundamental',
                ]
            ]
        ];

        $created = 0;
        foreach ($advancedBots as $bot) {
            if ($force || !TradingBot::where('name', $bot['name'])->exists()) {
                TradingBot::create($bot);
                $created++;
                $this->info("✓ Created bot: {$bot['name']}");
            } else {
                $this->info("- Bot already exists: {$bot['name']}");
            }
        }

        $this->info("✅ Created {$created} new trading bots");
    }

    /**
     * Create 12 copy trading experts
     */
    private function createCopyTradingExperts($force = false)
    {
        $copyExperts = [
            [
                'name' => 'Alexandra Chen',
                'photo' => 'avatar1.jpg',
                'rating' => 5,
                'followers' => 12450,
                'equity' => 285000.00,
                'total_profit' => 84750.00,
                'status' => 'active',
                'description' => 'Former Goldman Sachs quantitative analyst specializing in algorithmic trading strategies. 15+ years experience in institutional trading with consistent alpha generation.',
                'win_rate' => 89,
                'total_trades' => 3247,
                'price' => 2500.00,
                'tag' => 'Quant Expert',
                'type' => 'premium'
            ],
            [
                'name' => 'Marcus Rodriguez',
                'photo' => 'avatar2.jpg',
                'rating' => 5,
                'followers' => 8920,
                'equity' => 195000.00,
                'total_profit' => 56780.00,
                'status' => 'active',
                'description' => 'Crypto trading pioneer with deep expertise in DeFi protocols and yield farming strategies. Known for identifying emerging crypto trends before the market.',
                'win_rate' => 84,
                'total_trades' => 2156,
                'price' => 1800.00,
                'tag' => 'Crypto Specialist',
                'type' => 'premium'
            ],
            [
                'name' => 'Sarah Williams',
                'photo' => 'avatar3.jpg',
                'rating' => 4,
                'followers' => 15600,
                'equity' => 320000.00,
                'total_profit' => 94500.00,
                'status' => 'active',
                'description' => 'Forex market veteran with 20 years of experience in currency trading. Specializes in major pairs and carries trade strategies with exceptional risk management.',
                'win_rate' => 91,
                'total_trades' => 4567,
                'price' => 3200.00,
                'tag' => 'Forex Master',
                'type' => 'vip'
            ],
            [
                'name' => 'David Kim',
                'photo' => 'avatar4.jpg',
                'rating' => 5,
                'followers' => 6780,
                'equity' => 145000.00,
                'total_profit' => 42360.00,
                'status' => 'active',
                'description' => 'Growth stock specialist focusing on technology and biotech sectors. Former hedge fund manager with proven track record in identifying multi-bagger stocks.',
                'win_rate' => 78,
                'total_trades' => 1889,
                'price' => 2200.00,
                'tag' => 'Growth Stocks',
                'type' => 'premium'
            ],
            [
                'name' => 'Elena Volkov',
                'photo' => 'avatar5.jpg',
                'rating' => 5,
                'followers' => 9340,
                'equity' => 210000.00,
                'total_profit' => 63480.00,
                'status' => 'active',
                'description' => 'Options trading expert with deep knowledge of volatility strategies. Specializes in complex multi-leg options strategies and volatility arbitrage.',
                'win_rate' => 86,
                'total_trades' => 2945,
                'price' => 2800.00,
                'tag' => 'Options Pro',
                'type' => 'vip'
            ],
            [
                'name' => 'James Thompson',
                'photo' => 'avatar6.jpg',
                'rating' => 4,
                'followers' => 11200,
                'equity' => 185000.00,
                'total_profit' => 49870.00,
                'status' => 'active',
                'description' => 'Commodities trading specialist with expertise in energy and agricultural markets. Uses fundamental analysis and seasonal patterns for consistent profits.',
                'win_rate' => 82,
                'total_trades' => 1678,
                'price' => 1950.00,
                'tag' => 'Commodities',
                'type' => 'standard'
            ],
            [
                'name' => 'Yuki Tanaka',
                'photo' => 'avatar7.jpg',
                'rating' => 5,
                'followers' => 7650,
                'equity' => 265000.00,
                'total_profit' => 78940.00,
                'status' => 'active',
                'description' => 'Asian markets expert with deep understanding of Japanese and Chinese equity markets. Specializes in cross-border arbitrage and currency hedging.',
                'win_rate' => 88,
                'total_trades' => 3123,
                'price' => 2600.00,
                'tag' => 'Asian Markets',
                'type' => 'premium'
            ],
            [
                'name' => 'Roberto Silva',
                'photo' => 'avatar8.jpg',
                'rating' => 4,
                'followers' => 5890,
                'equity' => 132000.00,
                'total_profit' => 35680.00,
                'status' => 'active',
                'description' => 'Emerging markets specialist focusing on Latin American and Brazilian markets. Expert in currency volatility and emerging market dynamics.',
                'win_rate' => 79,
                'total_trades' => 1456,
                'price' => 1600.00,
                'tag' => 'Emerging Markets',
                'type' => 'standard'
            ],
            [
                'name' => 'Isabella Foster',
                'photo' => 'avatar9.jpg',
                'rating' => 5,
                'followers' => 13800,
                'equity' => 385000.00,
                'total_profit' => 124500.00,
                'status' => 'active',
                'description' => 'Fixed income and bond trading expert with institutional background. Specializes in yield curve strategies and credit spread trading.',
                'win_rate' => 93,
                'total_trades' => 2789,
                'price' => 3800.00,
                'tag' => 'Fixed Income',
                'type' => 'vip'
            ],
            [
                'name' => 'Mohammed Al-Rashid',
                'photo' => 'avatar10.jpg',
                'rating' => 4,
                'followers' => 8450,
                'equity' => 175000.00,
                'total_profit' => 45670.00,
                'status' => 'active',
                'description' => 'Middle Eastern markets specialist with expertise in oil and gas sector investments. Strong background in geopolitical analysis and energy trading.',
                'win_rate' => 81,
                'total_trades' => 1934,
                'price' => 2100.00,
                'tag' => 'Energy Sector',
                'type' => 'premium'
            ],
            [
                'name' => 'Lisa Anderson',
                'photo' => 'avatar11.jpg',
                'rating' => 5,
                'followers' => 16750,
                'equity' => 420000.00,
                'total_profit' => 145600.00,
                'status' => 'active',
                'description' => 'ESG and sustainable investing pioneer. Combines fundamental analysis with environmental and social impact criteria for long-term wealth creation.',
                'win_rate' => 87,
                'total_trades' => 2345,
                'price' => 4200.00,
                'tag' => 'ESG Investing',
                'type' => 'vip'
            ],
            [
                'name' => 'Viktor Petrov',
                'photo' => 'avatar12.jpg',
                'rating' => 4,
                'followers' => 10250,
                'equity' => 240000.00,
                'total_profit' => 67890.00,
                'status' => 'active',
                'description' => 'High-frequency trading specialist with expertise in market microstructure. Former prop trader with deep knowledge of algorithmic execution strategies.',
                'win_rate' => 85,
                'total_trades' => 5678,
                'price' => 2900.00,
                'tag' => 'HFT Expert',
                'type' => 'premium'
            ]
        ];

        $created = 0;
        foreach ($copyExperts as $expert) {
            if ($force || !Copytrading::where('name', $expert['name'])->exists()) {
                Copytrading::create($expert);
                $created++;
                $this->info("✓ Created copy expert: {$expert['name']}");
            } else {
                $this->info("- Copy expert already exists: {$expert['name']}");
            }
        }

        $this->info("✅ Created {$created} new copy trading experts");
    }
}
