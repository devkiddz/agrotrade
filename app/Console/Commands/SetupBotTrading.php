<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TradingBot;
use App\Models\Settings;

class SetupBotTrading extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:bottrading';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup bot trading system with sample trading bots';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Setting up Bot Trading System...');
        $this->newLine();

        try {
            // Check if bots already exist
            $botsCount = TradingBot::count();
            
            if ($botsCount == 0) {
                $this->info('📊 Creating sample trading bots...');
                
                // Sample trading bots
                $bots = [
                    [
                        'name' => 'ForexMaster Pro',
                        'bot_type' => 'forex',
                        'description' => 'Advanced forex trading bot specializing in major currency pairs. Uses sophisticated algorithms to analyze market trends and execute profitable trades with high precision. Perfect for conservative investors seeking steady returns.',
                        'min_investment' => 100.00,
                        'max_investment' => 10000.00,
                        'daily_profit_min' => 0.8,
                        'daily_profit_max' => 2.5,
                        'success_rate' => 87,
                        'duration_days' => 30,
                        'status' => 'active',
                        'trading_pairs' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'USD/CHF', 'AUD/USD'],
                        'risk_settings' => [
                            'stop_loss' => 3,
                            'take_profit' => 8,
                            'max_trades_per_day' => 6,
                            'risk_per_trade' => 1.5,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'Neural Network AI',
                            'indicators' => ['RSI', 'MACD', 'Moving Averages', 'Bollinger Bands'],
                            'timeframe' => '1H',
                            'market_analysis' => 'Technical & Fundamental',
                        ]
                    ],
                    [
                        'name' => 'CryptoGain Elite',
                        'bot_type' => 'crypto',
                        'description' => 'High-performance cryptocurrency trading bot designed for the volatile crypto markets. Leverages machine learning to identify optimal entry and exit points across major cryptocurrencies.',
                        'min_investment' => 250.00,
                        'max_investment' => 25000.00,
                        'daily_profit_min' => 1.2,
                        'daily_profit_max' => 4.5,
                        'success_rate' => 82,
                        'duration_days' => 45,
                        'status' => 'active',
                        'trading_pairs' => ['BTC/USD', 'ETH/USD', 'BNB/USD', 'ADA/USD', 'SOL/USD', 'DOT/USD'],
                        'risk_settings' => [
                            'stop_loss' => 5,
                            'take_profit' => 12,
                            'max_trades_per_day' => 8,
                            'risk_per_trade' => 2.5,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'Deep Learning Algorithm',
                            'indicators' => ['Volume Analysis', 'RSI', 'MACD', 'Fibonacci'],
                            'timeframe' => '4H',
                            'market_analysis' => 'Technical & Sentiment Analysis',
                        ]
                    ],
                    [
                        'name' => 'StockTrader AI',
                        'bot_type' => 'stocks',
                        'description' => 'Intelligent stock trading bot focusing on blue-chip stocks and growth companies. Combines fundamental analysis with technical indicators for optimal stock selection and timing.',
                        'min_investment' => 500.00,
                        'max_investment' => 50000.00,
                        'daily_profit_min' => 0.5,
                        'daily_profit_max' => 2.0,
                        'success_rate' => 89,
                        'duration_days' => 60,
                        'status' => 'active',
                        'trading_pairs' => ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'META'],
                        'risk_settings' => [
                            'stop_loss' => 4,
                            'take_profit' => 10,
                            'max_trades_per_day' => 4,
                            'risk_per_trade' => 2.0,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'Quantitative Analysis AI',
                            'indicators' => ['P/E Ratio', 'Moving Averages', 'Volume', 'Support/Resistance'],
                            'timeframe' => '1D',
                            'market_analysis' => 'Fundamental & Technical',
                        ]
                    ],
                    [
                        'name' => 'GoldRush Bot',
                        'bot_type' => 'commodities',
                        'description' => 'Specialized commodities trading bot with expertise in precious metals and energy markets. Ideal for portfolio diversification and inflation hedging strategies.',
                        'min_investment' => 200.00,
                        'max_investment' => 15000.00,
                        'daily_profit_min' => 0.7,
                        'daily_profit_max' => 2.8,
                        'success_rate' => 84,
                        'duration_days' => 90,
                        'status' => 'active',
                        'trading_pairs' => ['GOLD', 'SILVER', 'OIL', 'COPPER', 'NATURAL_GAS'],
                        'risk_settings' => [
                            'stop_loss' => 4,
                            'take_profit' => 9,
                            'max_trades_per_day' => 5,
                            'risk_per_trade' => 2.0,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'Commodity Price Prediction AI',
                            'indicators' => ['Supply/Demand', 'Economic Indicators', 'Seasonal Trends'],
                            'timeframe' => '4H',
                            'market_analysis' => 'Fundamental & Macro Economic',
                        ]
                    ],
                    [
                        'name' => 'IndexMaster Pro',
                        'bot_type' => 'indices',
                        'description' => 'Advanced index trading bot that capitalizes on major market indices movements. Uses correlation analysis and macro-economic indicators for strategic positioning.',
                        'min_investment' => 300.00,
                        'max_investment' => 20000.00,
                        'daily_profit_min' => 0.6,
                        'daily_profit_max' => 2.2,
                        'success_rate' => 86,
                        'duration_days' => 75,
                        'status' => 'active',
                        'trading_pairs' => ['S&P500', 'NASDAQ', 'DOW', 'FTSE', 'DAX', 'NIKKEI'],
                        'risk_settings' => [
                            'stop_loss' => 3,
                            'take_profit' => 8,
                            'max_trades_per_day' => 4,
                            'risk_per_trade' => 1.8,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'Market Index Analysis AI',
                            'indicators' => ['Economic Calendar', 'VIX', 'Moving Averages', 'Market Correlation'],
                            'timeframe' => '1D',
                            'market_analysis' => 'Macro Economic & Technical',
                        ]
                    ],
                    [
                        'name' => 'ScalpMaster Quick',
                        'bot_type' => 'forex',
                        'description' => 'High-frequency scalping bot designed for quick profits from small price movements. Perfect for active traders seeking multiple daily opportunities with controlled risk.',
                        'min_investment' => 150.00,
                        'max_investment' => 5000.00,
                        'daily_profit_min' => 1.5,
                        'daily_profit_max' => 3.5,
                        'success_rate' => 79,
                        'duration_days' => 21,
                        'status' => 'active',
                        'trading_pairs' => ['EUR/USD', 'GBP/JPY', 'USD/CAD', 'AUD/NZD'],
                        'risk_settings' => [
                            'stop_loss' => 2,
                            'take_profit' => 5,
                            'max_trades_per_day' => 12,
                            'risk_per_trade' => 1.0,
                        ],
                        'strategy_details' => [
                            'algorithm' => 'High-Frequency Trading AI',
                            'indicators' => ['Price Action', 'Level 2 Data', 'Order Flow'],
                            'timeframe' => '5M',
                            'market_analysis' => 'Technical & Price Action',
                        ]
                    ]
                ];

                foreach ($bots as $bot) {
                    TradingBot::create($bot);
                }

                $this->info('✓ Created ' . count($bots) . ' sample trading bots');
            } else {
                $this->info('✓ Trading bots already exist (' . $botsCount . ' bots)');
            }

            // Check settings
            $settings = Settings::first();
            if ($settings && !$settings->trade_mode) {
                $settings->update(['trade_mode' => 'on']);
                $this->info('✓ Enabled trade mode in settings');
            }

            $this->newLine();
            $this->info('🎉 Bot Trading setup completed successfully!');
            $this->newLine();
            $this->info('Next steps:');
            $this->info('1. Visit /dashboard/bot-trading to see available bots');
            $this->info('2. Visit /dashboard/bot-trading/dashboard to manage your bot investments');
            $this->info('3. Run the AutoTaskController cron to generate profits automatically');
            $this->info('4. Admin can manage bots at /admin/dashboard/bots');

        } catch (\Exception $e) {
            $this->error('Error setting up bot trading: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
