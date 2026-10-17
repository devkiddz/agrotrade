@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
<!-- Modern Hero Section -->
<div class="relative min-h-[40vh] overflow-hidden bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-800")
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzYjgyZjYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMiIvPjxjaXJjbGUgY3g9IjIiIGN5PSI1OCIgcj0iMiIvPjxjaXJjbGUgY3g9IjU4IiBjeT0iNTgiIHI9IjIiLz48Y2lyY2xlIGN4PSI1OCIgY3k9IjIiIHI9IjIiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-20"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/20 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-blue-500/20 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 container mx-auto px-6 py-12">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 rounded-full border border-blue-500/20 mb-4">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-blue-200 text-sm font-medium">AI-Powered Trading</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-white via-blue-200 to-blue-200 bg-clip-text text-transparent">
                    Bot Trading
                </span>
                <br>
                <span class="bg-gradient-to-r from-blue-400 to-blue-400 bg-clip-text text-transparent">
                    Hub
                </span>
            </h1>

            <p class="text-lg text-blue-100/80 mb-6 max-w-xl mx-auto leading-relaxed">
                Invest in AI-powered trading bots that work 24/7 to maximize your profits across multiple markets.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                   class="group relative inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-lg rounded-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-300">
                    <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                    Back to Dashboard
                </a>
                <a href="{{ route('user.bots.dashboard') }}"
                   class="group relative inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white transition-all duration-300">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                    My Bot Investments
                </a>
            </div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-[120px]">
            <path fill="rgb(249 250 251)" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,85.3C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-12">

        @if($userInvestments->count() > 0)
        <!-- Active Investments Overview -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Your Active Bot Investments</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($userInvestments as $investment)
                <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            @if($investment->bot->image)
                                <img src="{{ asset('storage/app/public/' . $investment->bot->image) }}"
                                     alt="{{ $investment->bot->name }}"
                                     class="w-12 h-12 rounded-xl object-cover">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <i data-lucide="bot" class="w-6 h-6 text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $investment->bot->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($investment->bot->bot_type) }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                            Active
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Investment</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($investment->investment_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Current Balance</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($investment->current_balance, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Profit</span>
                            <span class="font-medium text-green-600 dark:text-green-400">+${{ number_format($investment->total_profit, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Days Remaining</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $investment->days_remaining }} days</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex gap-2">
                            <a href="{{ route('user.bots.show', $investment->bot) }}"
                               class="flex-1 text-center py-2 px-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium transition-colors">
                                View Details
                            </a>
                            <a href="{{ route('user.bots.history', $investment) }}"
                               class="flex-1 text-center py-2 px-3 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-lg text-sm font-medium transition-colors">
                                History
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Available Trading Bots -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Available Trading Bots</h2>
                    <p class="text-gray-600 dark:text-gray-400">Choose from our AI-powered trading bots</p>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-filter="all">
                        All Bots
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-filter="forex">
                        Forex
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-filter="crypto">
                        Crypto
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-filter="stocks">
                        Stocks
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-filter="commodities">
                        Commodities
                    </button>
                </div>
            </div>

            <!-- Bots Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($bots as $bot)
                <div class="bot-card group relative bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 overflow-hidden hover:shadow-2xl transition-all duration-300"
                     data-category="{{ $bot->bot_type }}">

                    <!-- Bot Header -->
                    <div class="relative p-6 pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                @if($bot->image)
                                    <img src="{{ asset('storage/app/public/' . $bot->image) }}"
                                         alt="{{ $bot->name }}"
                                         class="w-14 h-14 rounded-xl object-cover border-2 border-white dark:border-gray-700 shadow-lg">
                                @else
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center border-2 border-white dark:border-gray-700 shadow-lg">
                                        <i data-lucide="bot" class="w-7 h-7 text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $bot->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $bot->bot_type }} Trading</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                {{ $bot->success_rate }}% Success
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            {{ Str::limit($bot->description, 120) }}
                        </p>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $bot->daily_profit_range }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Daily Profit</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $bot->duration_days }} Days</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Duration</div>
                            </div>
                        </div>

                        <!-- Investment Range -->
                        <div class="flex items-center justify-between text-sm mb-4">
                            <span class="text-gray-600 dark:text-gray-400">Investment Range:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                ${{ number_format($bot->min_investment) }} - ${{ number_format($bot->max_investment) }}
                            </span>
                        </div>

                        <!-- Trading Pairs -->
                        @if($bot->trading_pairs && count($bot->trading_pairs) > 0)
                        <div class="mb-4">
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Trading Pairs:</div>
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($bot->trading_pairs, 0, 4) as $pair)
                                <span class="px-2 py-1 text-xs bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 rounded">
                                    {{ $pair }}
                                </span>
                                @endforeach
                                @if(count($bot->trading_pairs) > 4)
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded">
                                    +{{ count($bot->trading_pairs) - 4 }} more
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Performance Stats -->
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-6">
                            <div class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3 h-3"></i>
                                <span>{{ $bot->active_investments_count }} Active Users</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="trending-up" class="w-3 h-3"></i>
                                <span>${{ number_format($bot->total_earned, 0) }} Total Earned</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('user.bots.show', $bot) }}"
                           class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-300 group">
                            <span>Invest Now</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($bots->count() === 0)
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="bot" class="w-12 h-12 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Trading Bots Available</h3>
                <p class="text-gray-600 dark:text-gray-400">Trading bots will be available soon. Check back later!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.filter-btn {
    background: rgb(249 250 251);
    color: rgb(75 85 99);
}

.dark .filter-btn {
    background: rgb(31 41 55);
    color: rgb(156 163 175);
}

.filter-btn:hover,
.filter-btn.active {
    background: rgb(59 130 246);
    color: white;
}

.dark .filter-btn:hover,
.dark .filter-btn.active {
    background: rgb(59 130 246);
    color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const botCards = document.querySelectorAll('.bot-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            // Filter cards
            botCards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in-out';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

@endsection
