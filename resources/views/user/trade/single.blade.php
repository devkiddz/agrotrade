@extends('layouts.dasht')
@section('title', 'Trade ' . $instrument->name)
@section('content')

<div class="container mx-auto px-4 py-8" x-data="tradingSingle()" x-cloak>
    <!-- TradingView Ticker Tape Widget -->
    <!--<div class="mb-6">-->
    <!--    <div class="tradingview-widget-container">-->
    <!--        <div class="tradingview-widget-container__widget"></div>-->
    <!--        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>-->
    <!--        {-->
    <!--            "symbols": [-->
    <!--                {"proName": "BINANCE:BTCUSDT", "title": "BTC/USDT"},-->
    <!--                {"proName": "BINANCE:ETHUSDT", "title": "ETH/USDT"},-->
    <!--                {"proName": "FX:EURUSD", "title": "EUR/USD"},-->
    <!--                {"proName": "NASDAQ:AAPL", "title": "APPLE"},-->
    <!--                {"proName": "NASDAQ:TSLA", "title": "TESLA"},-->
    <!--                {"proName": "TVC:GOLD", "title": "GOLD"}-->
    <!--            ],-->
    <!--            "showSymbolLogo": true,-->
    <!--            "colorTheme": "dark",-->
    <!--            "isTransparent": true,-->
    <!--            "displayMode": "adaptive",-->
    <!--            "locale": "en"-->
    <!--        }-->
    <!--        </script>-->
    <!--    </div>-->
    <!--</div>-->


    <x-notify-alert />
    <x-danger-alert />
    <x-success-alert />

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('trade.index') }}"
           class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Markets
        </a>
    </div>

    <!-- Trading Interface -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Chart Section (Left Side) -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Instrument Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            @if($instrument->logo)
                                <img src="{{ $instrument->logo }}" alt="{{ $instrument->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-500 dark:text-gray-400 font-semibold">{{ substr($instrument->symbol, 0, 2) }}</span>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $instrument->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ $instrument->symbol }}</p>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->price, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                        <div class="flex items-center gap-1 {{ $instrument->percent_change_24h >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            @if($instrument->percent_change_24h >= 0)
                                <i data-lucide="trending-up" class="w-4 h-4"></i>
                            @else
                                <i data-lucide="trending-down" class="w-4 h-4"></i>
                            @endif
                            <span>{{ number_format($instrument->percent_change_24h, 2) }}%</span>
                            <span class="text-sm">({{ $instrument->change >= 0 ? '+' : '' }}${{ number_format($instrument->change, 2) }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Widget -->
           <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Price Chart</h2>
    </div>

    <!-- TradingView Chart -->
    <div class="tradingview-widget-container h-[600px]">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
        {
            "height": 600,
            "symbol": "{{ $instrument->symbol }}",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_chart"
        }
        </script>
    </div>
</div>
           <!-- Market Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Market Statistics</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24h High</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->high ?? 0, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24h Low</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->low ?? 0, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24h Volume</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            @if($instrument->volume >= 1e9)
                                ${{ number_format($instrument->volume / 1e9, 1) }}B
                            @elseif($instrument->volume >= 1e6)
                                ${{ number_format($instrument->volume / 1e6, 1) }}M
                            @elseif($instrument->volume >= 1e3)
                                ${{ number_format($instrument->volume / 1e3, 1) }}K
                            @else
                                ${{ number_format($instrument->volume ?? 0) }}
                            @endif
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Market Cap</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            @if($instrument->market_cap >= 1e9)
                                ${{ number_format($instrument->market_cap / 1e9, 1) }}B
                            @elseif($instrument->market_cap >= 1e6)
                                ${{ number_format($instrument->market_cap / 1e6, 1) }}M
                            @else
                                ${{ number_format($instrument->market_cap ?? 0) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trade History Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">




                <!-- Trade History Tabs -->
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 mb-6">
                    <button @click="activeTab = 'open'"
                            :class="activeTab === 'open' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-sm">
                        Open Trades ({{ $openTrades->count() }})
                    </button>
                    <button @click="activeTab = 'closed'"
                            :class="activeTab === 'closed' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-sm">
                        Closed Trades ({{ $closedTrades->count() }})
                    </button>
                </div>

                <!-- Open Trades -->
                <div x-show="activeTab === 'open'" x-transition>
                    @if($openTrades->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
                            @foreach($openTrades as $trade)
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-300 group">
                                    <!-- Active Trade Indicator -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <!-- Spinning yellow loader for active trades -->
                                                <div class="w-8 h-8 border-2 border-yellow-200 border-t-yellow-500 rounded-full animate-spin"></div>
                                                <!-- Pulsing ring for extra attention -->
                                                <div class="absolute inset-0 w-8 h-8 border-2 border-yellow-300 rounded-full animate-pulse opacity-50"></div>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <i data-lucide="activity" class="w-3 h-3 mr-1"></i>
                                                    Active
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold {{ $trade->type === 'Buy' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{Auth::user()->currency}}{{ number_format($trade->amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($trade->created_at)->format('M d, H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trade Details -->
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full {{ $trade->type === 'Buy' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($trade->type === 'Buy')
                                                        <i data-lucide="trending-up" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                                    @else
                                                        <i data-lucide="trending-down" class="w-5 h-5 text-red-600 dark:text-red-400"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $trade->type }} {{ $trade->assets }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        Leverage: 1:{{ $trade->leverage ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Progress Section -->
                                        @if($trade->expire_date)
                                            @php
                                                $start = \Carbon\Carbon::parse($trade->activated_at ?? $trade->created_at);
                                                $end = \Carbon\Carbon::parse($trade->expire_date);
                                                $now = \Carbon\Carbon::now();
                                                $total = $start->diffInMinutes($end);
                                                $elapsed = $start->diffInMinutes($now);
                                                $progress = $total > 0 ? min(($elapsed / $total) * 100, 100) : 0;
                                                $timeLeft = $now < $end ? $now->diffForHumans($end) : 'Expired';
                                                $randomProgress = rand(15, 85); // Random completion percentage for visual appeal
                                            @endphp

                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Time Progress</span>
                                                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $timeLeft }}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    <span>Started {{ \Carbon\Carbon::parse($trade->created_at)->diffForHumans() }}</span>
                                                    <span>{{ number_format($progress, 1) }}%</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Trade Info Grid -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Duration</div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $trade->inv_duration ?? 'N/A' }}</div>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Current P&L</div>
                                                <div class="font-medium {{ ($trade->profit_earned ?? 0) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ ($trade->profit_earned ?? 0) >= 0 ? '+' : '' }}{{Auth::user()->currency}}{{ number_format($trade->profit_earned ?? 0, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('trade.monitor', $trade->id) }}" class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium group-hover:bg-blue-50 group-hover:text-blue-600 dark:group-hover:bg-blue-900/30 dark:group-hover:text-blue-400 block text-center">
                                            <i data-lucide="eye" class="w-4 h-4 inline mr-2"></i>
                                            Monitor Trade
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i data-lucide="chart-line" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Open Trades</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You don't have any open trades for {{ $instrument->symbol }}</p>
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                Start Trading
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Closed Trades -->
                <div x-show="activeTab === 'closed'" x-transition>
                    @if($closedTrades->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
                            @foreach($closedTrades as $trade)
                                @php
                                    // Use actual profit_earned from user_plans table
                                    $actualProfitEarned = $trade->profit_earned ?? 0;
                                    $isProfit = $actualProfitEarned >= 0;
                                    $profitAmount = abs($actualProfitEarned);

                                    // Determine if trade was successful based on profit_earned
                                    $isSuccessful = $actualProfitEarned > 0;
                                @endphp
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-300 group">
                                    <!-- Trade Status Header -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            @if($trade->active === 'yes')
                                                <!-- Active Trade -->
                                                <div class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <div class="w-2 h-2 rounded-full bg-yellow-500 mr-1 animate-pulse"></div>
                                                    Active Trade
                                                </span>
                                            @elseif($trade->active === 'expired')
                                                <!-- Closed Trade -->
                                                <div class="w-8 h-8 rounded-full {{ $isSuccessful ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($isSuccessful)
                                                        <i data-lucide="check" class="w-4 h-4 text-green-600 dark:text-green-400"></i>
                                                    @else
                                                        <i data-lucide="x" class="w-4 h-4 text-red-600 dark:text-red-400"></i>
                                                    @endif
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isSuccessful ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                    <div class="w-2 h-2 rounded-full {{ $isSuccessful ? 'bg-green-500' : 'bg-red-500' }} mr-1"></div>
                                                    {{ $isSuccessful ? 'Completed' : 'Closed' }}
                                                </span>
                                            @else
                                                <!-- Unknown Status -->
                                                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    <i data-lucide="help-circle" class="w-4 h-4 text-gray-500"></i>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                                    <div class="w-2 h-2 rounded-full bg-gray-500 mr-1"></div>
                                                    Unknown
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{Auth::user()->currency}}{{ number_format($trade->amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($trade->created_at)->format('M d, H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trade Details -->
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full {{ $trade->type === 'Buy' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($trade->type === 'Buy')
                                                        <i data-lucide="trending-up" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                                    @else
                                                        <i data-lucide="trending-down" class="w-5 h-5 text-red-600 dark:text-red-400"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $trade->type }} {{ $trade->assets }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        Leverage: 1:{{ $trade->leverage ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Performance Metrics -->
                                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">P&L</div>
                                                    @if($trade->active === 'expired')
                                                        <div class="font-semibold {{ $isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                            {{ $isProfit ? '+' : '-' }}{{Auth::user()->currency}}{{ number_format($profitAmount, 2) }}
                                                        </div>
                                                    @else
                                                        <div class="font-semibold text-yellow-600 dark:text-yellow-400">
                                                            Pending
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Return</div>
                                                    @if($trade->active === 'expired' && $trade->amount > 0)
                                                        <div class="font-semibold {{ $isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                            {{ $isProfit ? '+' : '-' }}{{ number_format(($profitAmount / $trade->amount) * 100, 1) }}%
                                                        </div>
                                                    @else
                                                        <div class="font-semibold text-yellow-600 dark:text-yellow-400">
                                                            ---%
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Trade Timeline -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Duration</div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $trade->inv_duration ?? 'N/A' }}</div>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                @if($trade->active === 'yes')
                                                    <div class="text-gray-600 dark:text-gray-400 text-xs">Expires</div>
                                                    <div class="font-medium text-yellow-600 dark:text-yellow-400">
                                                        {{ $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('M d, H:i') : 'N/A' }}
                                                    </div>
                                                @else
                                                    <div class="text-gray-600 dark:text-gray-400 text-xs">Closed</div>
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($trade->expire_date ?? $trade->updated_at)->format('M d, H:i') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('trade.monitor', $trade->id) }}" class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium group-hover:bg-blue-50 group-hover:text-blue-600 dark:group-hover:bg-blue-900/30 dark:group-hover:text-blue-400 block text-center">
                                            <i data-lucide="bar-chart-3" class="w-4 h-4 inline mr-2"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($closedTrades->count() >= 10)
                            <div class="text-center mt-6 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Showing recent 10 trades</p>
                                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <i data-lucide="history" class="w-4 h-4 inline mr-2"></i>
                                    View All History
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i data-lucide="history" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Trade History</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You haven't completed any trades for {{ $instrument->symbol }} yet</p>
                            <div class="space-y-3">
                                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    Start Trading
                                </button>
                                <div>
                                    <a href="{{ url('user-trades-debug.php') }}" class="text-sm text-blue-600 hover:underline">
                                        View All Your Trades
                                    </a>
                                </div>
                            </div>
                            @if(config('app.debug') && auth()->user()->is_admin)
                                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                    <div class="text-xs text-yellow-800 dark:text-yellow-400">
                                        <strong>Debug Info:</strong> Looking for trades with: {{ $instrument->symbol }}, {{ $instrument->name }},
                                        {{ str_replace('/', '', $instrument->symbol) }}, and other variations.
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Trading Panel (Right Side) -->
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Place Order</h3>

                <!-- Order Type Tabs -->
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 mb-6">
                    <button @click="orderType = 'Buy'"
                            :class="orderType === 'Buy' ? 'bg-green-500 text-white' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors">
                        Buy
                    </button>
                    <button @click="orderType = 'Sell'"
                            :class="orderType === 'Sell' ? 'bg-red-500 text-white' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors">
                        Sell
                    </button>
                </div>

                <!-- Order Form -->
                <form action="{{ route('joinplan') }}" method="POST" class="space-y-4" @submit.prevent="submitOrder">
                    @csrf
                    <!-- Hidden fields for instrument data -->
                    <input type="hidden" name="plan_id" value="{{ $instrument->id }}">
                    <input type="hidden" name="symbol" value="{{ $instrument->symbol }}">
                    <input type="hidden" name="asset" value="{{ $instrument->name }}">
                    <input type="hidden" name="instrument_price" value="{{ $instrument->price }}">
                    <input type="hidden" name="order_type" x-model="orderType">

                    <!-- Order Type Selector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Type</label>
                        <select x-model="tradeType" name="trade_type" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">

                            <option value="market">Market Order</option>
                            <option value="limit">Limit Order</option>

                            <option value="stop">Stop Order</option>
                        </select>
                    </div>

                    <!-- Leverage Selector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Leverage</label>
                        <select name="leverage" id="leverage" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option disabled selected value="">Leverage</option>
                            <option value="10">1:10</option>
                            <option value="20">1:20</option>
                            <option value="30">1:30</option>
                            <option value="40">1:40</option>
                            <option value="50">1:50</option>
                            <option value="60">1:60</option>
                            <option value="70">1:70</option>
                            <option value="80">1:80</option>
                            <option value="90">1:90</option>
                            <option value="100">1:100</option>
                        </select>
                    </div>

                    <!-- Expiration Selector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiration</label>
                        <select name="expire" id="expire" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option disabled selected value="">Expiration</option>
                            <option value="3 Minutes">3 Minute</option>
                            <option value="5 Minutes">5 Minutes</option>
                            <option value="15 Minutes">15 Minutes</option>
                            <option value="30 Minutes">30 Minutes</option>
                            <option value="60 Minutes">1 Hour</option>
                            <option value="4 Hours">4 Hours</option>
                            <option value="1 Days">1 Day</option>
                            <option value="2 Days">2 Days</option>
                            <option value="7 Days">7 Days</option>
                        </select>
                    </div>

                    <!-- Price Input (for limit/stop orders) -->
                    <div >
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                        <input type="number"
                               x-model="price"
                               name="price"
                               step="any"
                               min="0"
                               placeholder="{{ $instrument->price }}"
                               class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                    </div>

                    <!-- Amount Input (Total Investment) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Investment Amount ($)</label>
                        <input type="number"
                               x-model="amount"
                               name="amount"
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               required
                               class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                    </div>                    <!-- Investment Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Investment Amount:</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="formatAmount()"></span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Units:</span>
                            <span class="text-sm text-gray-900 dark:text-white" x-text="formatUnits()"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Available Balance:</span>
                            <span class="text-sm text-gray-900 dark:text-white">${{ number_format(auth()->user()->account_bal ?? 0, 2) }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            :disabled="!amount || amount <= 0 || loading"
                            :class="orderType === 'Buy' ? 'bg-green-600 hover:bg-green-700 disabled:bg-green-300' : 'bg-red-600 hover:bg-red-700 disabled:bg-red-300'"
                            class="w-full py-3 px-4 text-white font-semibold rounded-lg transition-colors disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <template x-if="loading">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </template>
                        <span x-text="loading ? 'Processing...' : (orderType === 'Buy' ? 'Buy ' + '{{ $instrument->symbol }}' : 'Sell ' + '{{ $instrument->symbol }}')"></span>
                    </button>
                </form>

                <!-- Quick Amount Buttons -->
                <div class="mt-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Quick amounts:</div>
                    <div class="grid grid-cols-4 gap-2">
                        <button @click="setQuickAmount(25)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">25%</button>
                        <button @click="setQuickAmount(50)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">50%</button>
                        <button @click="setQuickAmount(75)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">75%</button>
                        <button @click="setQuickAmount(100)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">Max</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function tradingSingle() {
    return {
        instrument: @json($instrument),
        orderType: 'Buy',
        tradeType: 'market',
        amount: '',
        price: '',
        loading: false,
        activeTab: 'open', // Add tab state to the main Alpine component

        formatAmount() {
            if (!this.amount) return '$0.00';
            const amount = parseFloat(this.amount);
            return '$' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        formatUnits() {
            if (!this.amount) return '0';
            const amount = parseFloat(this.amount);
            const price = this.tradeType === 'market' ? this.instrument.price : (this.price || this.instrument.price);
            const units = amount / parseFloat(price);
            return units.toLocaleString('en-US', { minimumFractionDigits: 6, maximumFractionDigits: 6 });
        },

        setQuickAmount(percentage) {
            const balance = {{ auth()->user()->account_bal ?? 0 }};
            this.amount = (balance * percentage / 100).toFixed(2);
        },

        submitOrder() {
            if (!this.amount || this.amount <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid amount to trade.',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }

            const leverage = document.getElementById('leverage').value;
            const expire = document.getElementById('expire').value;

            if (!leverage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Select Leverage',
                    text: 'Please select a leverage ratio.',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }

            if (!expire) {
                Swal.fire({
                    icon: 'error',
                    title: 'Select Expiration',
                    text: 'Please select an expiration time.',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }

            const total = this.formatAmount();
            const units = this.formatUnits();
            const action = this.orderType.toUpperCase();

            Swal.fire({
                title: `Confirm ${action} Order`,
                html: `
                    <div class="text-left space-y-2">
                        <p><strong>Instrument:</strong> ${this.instrument.symbol}</p>
                        <p><strong>Action:</strong> ${action}</p>
                        <p><strong>Investment Amount:</strong> ${total}</p>
                        <p><strong>Units:</strong> ${units}</p>
                        <p><strong>Leverage:</strong> 1:${leverage}</p>
                        <p><strong>Expiration:</strong> ${expire}</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: this.orderType === 'Buy' ? '#10B981' : '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: `Yes, ${action}!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true;

                    // Show processing message
                    Swal.fire({
                        title: 'Processing Order...',
                        text: 'Please wait while we process your trade.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    this.$el.closest('form').submit();
                }
            });
        },        init() {
            // Initialize price for limit/stop orders
            this.price = this.instrument.price;

            // Initialize Lucide icons
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        }
    }
}

// Re-initialize icons after Alpine updates
document.addEventListener('alpine:updated', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

@endsection
