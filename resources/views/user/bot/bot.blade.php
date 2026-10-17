@extends('layouts.dasht', ['title' => 'Bot Trading Overview'])

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-800 text-white">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -right-8 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute -bottom-8 left-1/3 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-16">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-white/90 text-sm font-medium">AI-Powered Trading Bots</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="text-white">
                    Automated Bot
                </span>
                <br>
                <span class="text-white">
                    Trading System
                </span>
            </h1>

            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
                Invest in cutting-edge AI trading bots that execute trades 24/7 across multiple markets.
                Our intelligent algorithms analyze market patterns and execute profitable trades automatically.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                   class="group relative inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 text-white hover:bg-white/20 transition-all duration-300">
                    <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                    Back to Dashboard
                </a>
                <a href="{{ route('user.bots.index') }}"
                   class="group relative inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-2xl text-white transition-all duration-300">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                    View All Bots
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -right-8 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute -bottom-8 left-1/3 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-12 -mt-8 relative z-10">
    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <!-- AI Intelligence -->
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-8 transition-all duration-300 hover:shadow-2xl">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="brain" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">AI Intelligence</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Advanced machine learning algorithms analyze market patterns and execute trades with precision.
            </p>
        </div>

        <!-- 24/7 Trading -->
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-8 transition-all duration-300 hover:shadow-2xl">
            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="clock" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">24/7 Trading</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Never miss a trading opportunity. Our bots work around the clock across global markets.
            </p>
        </div>

        <!-- Multi-Market -->
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-8 transition-all duration-300 hover:shadow-2xl">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="globe" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Multi-Market</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Trade across Forex, Crypto, Stocks, and Commodities with specialized bot strategies.
            </p>
        </div>
    </div>

    <!-- How It Works -->
    <div class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">How Bot Trading Works</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Our automated trading system follows a proven process to maximize your investment returns
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="relative text-center bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Choose Bot</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Select from our range of specialized trading bots based on your risk tolerance and preferred markets.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="relative text-center bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Invest Amount</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Set your investment amount within the bot's minimum and maximum limits.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="relative text-center bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">AI Trading</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    The bot automatically analyzes markets and executes profitable trades using advanced algorithms.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="relative text-center bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">4</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Earn Profits</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Watch your investment grow as the bot generates consistent profits over the investment period.
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">85%</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Average Success Rate</div>
        </div>
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6 text-center">
            <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">2.5%</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Daily Profit Target</div>
        </div>
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">24/7</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Market Monitoring</div>
        </div>
        <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6 text-center">
            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">5+</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Market Categories</div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-600 rounded-3xl p-8 md:p-12 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Bot Trading?</h2>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Join thousands of investors who are already earning consistent profits with our AI-powered trading bots.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.bots.index') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-2xl font-semibold hover:bg-blue-50 transition-colors">
                <i data-lucide="bot" class="w-5 h-5"></i>
                Browse Trading Bots
            </a>
            <a href="{{ route('user.bots.dashboard') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-2xl font-semibold hover:bg-white/20 transition-colors">
                <i data-lucide="activity" class="w-5 h-5"></i>
                My Investments
            </a>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endpush

@endsection
