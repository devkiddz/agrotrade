@extends('layouts.dasht')
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 sm:mb-8 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Copy Trading Dashboard</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">Manage your copy trading portfolio and track performance</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('copy.experts') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                    <i data-lucide="users" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="hidden sm:inline">Browse Experts</span>
                    <span class="sm:hidden">Experts</span>
                </a>
                <button onclick="refreshDashboard()"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                    <i data-lucide="refresh-cw" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="hidden sm:inline">Refresh</span>
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-2 flex-shrink-0"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-2 flex-shrink-0"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Portfolio Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Active Copies -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">Active Copies</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 truncate">{{ $stats['active_copies'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Experts being copied</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl flex-shrink-0">
                        <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Invested -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">Total Invested</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 truncate">{{Auth::user()->currency}}{{ number_format($stats['total_invested'], 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Capital deployed</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 rounded-xl flex-shrink-0">
                        <i data-lucide="dollar-sign" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>

            <!-- Current Value -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">Current Value</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 truncate">{{Auth::user()->currency}}{{ number_format($stats['current_balance'], 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Portfolio value</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl flex-shrink-0">
                        <i data-lucide="wallet" class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total P&L -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2">Total P&L</p>
                        <p class="text-2xl sm:text-3xl font-bold {{ $stats['total_profit'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mb-1 truncate">
                            {{ $stats['total_profit'] >= 0 ? '+' : '' }}{{Auth::user()->currency}}{{ number_format($stats['total_profit'], 2) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $stats['total_invested'] > 0 ? number_format((($stats['total_profit'] / $stats['total_invested']) * 100), 2) : 0 }}% ROI
                        </p>
                    </div>
                    <div class="p-2 sm:p-3 bg-gradient-to-br {{ $stats['total_profit'] >= 0 ? 'from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30' : 'from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-800/30' }} rounded-xl flex-shrink-0">
                        <i data-lucide="{{ $stats['total_profit'] >= 0 ? 'trending-up' : 'trending-down' }}"
                           class="w-5 h-5 sm:w-6 sm:h-6 {{ $stats['total_profit'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($copyTrades->where('active', 'yes')->count() > 0)
            <!-- Active Copy Positions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 sm:mb-8 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <i data-lucide="trending-up" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400"></i>
                                Active Copy Positions
                            </h2>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Currently copying {{ $copyTrades->where('active', 'yes')->count() }} expert trader(s)</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-xs sm:text-sm font-medium text-green-600 dark:text-green-400">Live</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($copyTrades->where('active', 'yes') as $copyTrade)
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] relative overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute inset-0 opacity-5">
                                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500 rounded-full -translate-y-10 translate-x-10"></div>
                                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-indigo-500 rounded-full translate-y-8 -translate-x-8"></div>
                                </div>

                                <!-- Expert Header -->
                                <div class="flex items-start sm:items-center justify-between mb-4 sm:mb-6 relative z-10 gap-3">
                                    <div class="flex items-center space-x-3 min-w-0 flex-1">
                                        @if($copyTrade->expert && $copyTrade->expert->photo)
                                            <img src="{{ asset('storage/app/public/' . $copyTrade->expert->photo) }}"
                                                 class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700 shadow-lg flex-shrink-0"
                                                 alt="{{ $copyTrade->name }}">
                                        @else
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm sm:text-lg shadow-lg flex-shrink-0">
                                                {{ substr($copyTrade->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white text-base sm:text-lg truncate">{{ $copyTrade->name }}</h3>
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 truncate">{{ $copyTrade->tag ?? 'Expert Trader' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end space-y-1 sm:space-y-2 flex-shrink-0">
                                        <span class="px-2 sm:px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg text-xs font-medium shadow-sm">
                                            Active
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 text-right">
                                            {{ $copyTrade->started_at ? $copyTrade->started_at->diffForHumans() : 'Recently' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Investment Details -->
                                <div class="space-y-4 mb-6 relative z-10">
                                    <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Investment</span>
                                        <span class="font-bold text-gray-900 dark:text-white text-lg">{{Auth::user()->currency}}{{ number_format($copyTrade->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Current Value</span>
                                        <span class="font-bold text-gray-900 dark:text-white text-lg">${{ number_format($copyTrade->current_balance, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">P&L</span>
                                        <span class="font-bold text-lg {{ $copyTrade->total_profit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $copyTrade->total_profit >= 0 ? '+' : '' }}{{Auth::user()->currency}}{{ number_format($copyTrade->total_profit, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">ROI</span>
                                        <span class="font-bold text-lg {{ $copyTrade->profit_percentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $copyTrade->profit_percentage >= 0 ? '+' : '' }}{{ number_format($copyTrade->profit_percentage, 2) }}%
                                        </span>
                                    </div>
                                </div>

                                <!-- Performance Bar -->
                                <div class="mb-6 relative z-10">
                                    <div class="flex justify-between text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">
                                        <span>Performance</span>
                                        <span>{{ $copyTrade->total_trades ?? 0 }} trades</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2 sm:h-3 overflow-hidden">
                                        @php
                                            $winRate = $copyTrade->total_trades > 0 ? (($copyTrade->winning_trades ?? 0) / $copyTrade->total_trades) * 100 : 0;
                                        @endphp
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 sm:h-3 rounded-full transition-all duration-500 ease-out shadow-sm"
                                             style="width: {{ $winRate }}%"></div>
                                    </div>
                                    <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-2 text-center">
                                        {{ number_format($winRate, 1) }}% win rate
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 relative z-10">
                                    <button type="button"
                                            class="view-details-btn flex-1 px-3 sm:px-4 py-2 sm:py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm"
                                            data-id="{{ $copyTrade->id }}">
                                        <i data-lucide="bar-chart-3" class="w-4 h-4 inline mr-2"></i>
                                        <span class="hidden sm:inline">View Details</span>
                                        <span class="sm:hidden">Details</span>
                                    </button>
                                    <button type="button"
                                            class="stop-copy-btn px-3 sm:px-4 py-2 sm:py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm flex items-center justify-center"
                                            data-id="{{ $copyTrade->id }}"
                                            data-name="{{ $copyTrade->name }}">
                                        <i data-lucide="square" class="w-4 h-4"></i>
                                        <span class="ml-1 sm:hidden">Stop</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($copyTrades->where('active', 'no')->count() > 0)
            <!-- Copy Trading History -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 sm:mb-8 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-700/50">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="history" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 dark:text-gray-400"></i>
                        Copy Trading History
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Previous copy positions and their performance</p>
                </div>

                <!-- Mobile Card View -->
                <div class="block sm:hidden">
                    <div class="p-4 space-y-4">
                        @foreach($copyTrades->where('active', 'no') as $copyTrade)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                        {{ substr($copyTrade->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-medium text-gray-900 dark:text-white truncate">{{ $copyTrade->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $copyTrade->tag ?? 'Expert Trader' }}</div>
                                    </div>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-medium flex-shrink-0">
                                        Closed
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <div class="text-gray-500 dark:text-gray-400 text-xs">Investment</div>
                                        <div class="font-medium text-gray-900 dark:text-white">${{ number_format($copyTrade->price, 2) }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 dark:text-gray-400 text-xs">Final Value</div>
                                        <div class="font-medium text-gray-900 dark:text-white">${{ number_format($copyTrade->current_balance, 2) }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 dark:text-gray-400 text-xs">P&L</div>
                                        <div class="font-bold {{ $copyTrade->total_profit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $copyTrade->total_profit >= 0 ? '+' : '' }}${{ number_format($copyTrade->total_profit, 2) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 dark:text-gray-400 text-xs">ROI</div>
                                        <div class="font-bold {{ $copyTrade->profit_percentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $copyTrade->profit_percentage >= 0 ? '+' : '' }}{{ number_format($copyTrade->profit_percentage, 2) }}%
                                        </div>
                                    </div>
                                </div>

                                @if($copyTrade->started_at)
                                    @php
                                        $duration = $copyTrade->started_at->diffInDays($copyTrade->updated_at);
                                    @endphp
                                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Duration: {{ $duration }} day{{ $duration != 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Expert</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Investment</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Final Value</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">P&L</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">ROI</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Duration</th>
                                <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($copyTrades->where('active', 'no') as $copyTrade)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($copyTrade->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $copyTrade->name }}</span>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $copyTrade->tag ?? 'Expert Trader' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-900 dark:text-white font-medium">${{ number_format($copyTrade->price, 2) }}</td>
                                    <td class="py-4 px-6 text-gray-900 dark:text-white font-medium">${{ number_format($copyTrade->current_balance, 2) }}</td>
                                    <td class="py-4 px-6">
                                        <span class="font-semibold {{ $copyTrade->total_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $copyTrade->total_profit >= 0 ? '+' : '' }}${{ number_format($copyTrade->total_profit, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-semibold {{ $copyTrade->profit_percentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $copyTrade->profit_percentage >= 0 ? '+' : '' }}{{ number_format($copyTrade->profit_percentage, 2) }}%
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 dark:text-gray-400">
                                        @if($copyTrade->started_at)
                                            @php
                                                $duration = $copyTrade->started_at->diffInDays($copyTrade->updated_at);
                                            @endphp
                                            {{ $duration }} day{{ $duration != 1 ? 's' : '' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-medium">
                                            Closed
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($copyTrades->count() == 0)
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 text-center py-12 sm:py-20 px-4 sm:px-6 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-6 sm:top-10 left-6 sm:left-10 w-20 h-20 sm:w-32 sm:h-32 bg-blue-500 rounded-full"></div>
                    <div class="absolute bottom-6 sm:bottom-10 right-6 sm:right-10 w-16 h-16 sm:w-24 sm:h-24 bg-indigo-500 rounded-full"></div>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 sm:w-40 sm:h-40 bg-blue-300 rounded-full"></div>
                </div>

                <div class="relative z-10">
                    <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8 shadow-lg">
                        <i data-lucide="copy" class="w-8 h-8 sm:w-12 sm:h-12 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Start Copy Trading</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 sm:mb-10 max-w-lg mx-auto text-base sm:text-lg leading-relaxed px-4">
                        You haven't started copying any traders yet. Browse our expert traders and start copying their winning strategies to earn profits automatically.
                    </p>

                    <!-- Feature Highlights -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-10 max-w-4xl mx-auto">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 sm:p-6">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Expert Traders</h4>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Copy from verified professional traders with proven track records</p>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 sm:p-6">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i data-lucide="trending-up" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Auto Trading</h4>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Trades are executed automatically when experts make moves</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 sm:p-6 sm:col-span-2 lg:col-span-1">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i data-lucide="shield" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Risk Management</h4>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Set your own risk limits and stop-loss parameters</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center max-w-md mx-auto">
                        <a href="{{ route('copy.experts') }}"
                           class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm sm:text-base">
                            <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            <span class="hidden sm:inline">Browse Expert Traders</span>
                            <span class="sm:hidden">Browse Experts</span>
                        </a>
                        <button onclick="showHowItWorks()"
                               class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm sm:text-base">
                            <i data-lucide="help-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            How It Works
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Position Details Modal -->
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-2 sm:p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-5xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700 mx-2 sm:mx-0">
        <div class="flex justify-between items-center p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400"></i>
                <span class="hidden sm:inline">Copy Position Details</span>
                <span class="sm:hidden">Position Details</span>
            </h3>
            <button onclick="closeDetailsModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i data-lucide="x" class="w-5 h-5 sm:w-6 sm:h-6"></i>
            </button>
        </div>
        <div id="detailsContent" class="p-4 sm:p-6">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- How It Works Modal -->
<div id="howItWorksModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-2 sm:p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700 mx-2 sm:mx-0">
        <div class="flex justify-between items-center p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i data-lucide="help-circle" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400"></i>
                How Copy Trading Works
            </h3>
            <button onclick="closeHowItWorksModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i data-lucide="x" class="w-5 h-5 sm:w-6 sm:h-6"></i>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                <div class="space-y-4 sm:space-y-6">
                    <div class="flex items-start space-x-3 sm:space-x-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm sm:text-base">1</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Choose an Expert</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Browse through our verified expert traders and select one based on their performance, strategy, and risk profile.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 sm:space-x-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm sm:text-base">2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Set Your Investment</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Decide how much you want to invest and set your risk parameters including stop-loss and take-profit levels.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 sm:space-x-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm sm:text-base">3</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Auto-Copy Trades</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Our system automatically copies the expert's trades to your account in real-time, proportional to your investment.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 sm:space-x-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm sm:text-base">4</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Monitor & Profit</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Track your performance in real-time and watch your investment grow as the expert trader makes profitable trades.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 sm:p-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4 text-sm sm:text-base">Benefits of Copy Trading</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center space-x-3">
                            <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 flex-shrink-0"></i>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">No trading experience required</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 flex-shrink-0"></i>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Learn from expert strategies</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 flex-shrink-0"></i>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Diversify your portfolio</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 flex-shrink-0"></i>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">24/7 automated trading</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 flex-shrink-0"></i>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Full control over your funds</span>
                        </li>
                    </ul>

                    <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded">
                        <p class="text-xs sm:text-sm text-yellow-700 dark:text-yellow-400">
                            <strong>Risk Warning:</strong> Copy trading involves risk. Past performance is not indicative of future results.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function stopCopyPosition(copyTradeId, expertName) {
            Swal.fire({
                title: 'Stop Copy Trading?',
                html: `
                    <div class="text-left">
                        <p class="mb-4">Are you sure you want to stop copying <strong>${expertName}</strong>?</p>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Your current balance will be returned to your account immediately.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Stop Copying',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white rounded-xl px-6 py-2',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-xl px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('copy.stop', '') }}/${copyTradeId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function viewDetails(copyTradeId) {
            document.getElementById('detailsModal').classList.remove('hidden');
            document.getElementById('detailsModal').classList.add('flex');

            // Show loading indicator
            document.getElementById('detailsContent').innerHTML = '<div class="flex justify-center p-10"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div></div>';

            // Use the correct URL format with route parameter
            const url = `{{ url('/dashboard/copy-trading/analytics') }}/${copyTradeId}`;
            console.log('Fetching URL:', url);

            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    // Check if response is OK
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    // Check if this is an error response
                    if (data.error) {
                        document.getElementById('detailsContent').innerHTML = `
                            <div class="p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg">
                                <h3 class="font-bold mb-2">Server Response Error</h3>
                                <p>Server returned: ${data.error}</p>
                            </div>
                        `;
                        return;
                    }

                    // Handle successful response (has copyTrade field)
                    if (data.copyTrade) {
                        const copyTrade = data.copyTrade;
                        const trades = data.trades || [];
                        const dailyPerformance = data.dailyPerformance || [];

                        // Debug logging for ROI values
                        console.log('ROI Debug Info:');
                        console.log('data.roi:', data.roi);
                        console.log('copyTrade.profit_percentage:', copyTrade.profit_percentage);
                        console.log('copyTrade.price:', copyTrade.price);
                        console.log('copyTrade.current_balance:', copyTrade.current_balance);
                        console.log('copyTrade.total_profit:', copyTrade.total_profit);

                        // Calculate ROI using total_profit / price ratio (same as dashboard)
                        let calculatedROI = 0;
                        if (copyTrade.price && copyTrade.price > 0 && copyTrade.total_profit !== undefined) {
                            calculatedROI = (copyTrade.total_profit / copyTrade.price) * 100;
                        }
                        console.log('Calculated ROI from total_profit/price:', calculatedROI);

                        // Use profit_percentage from database if available, otherwise use calculated ROI
                        const finalROI = copyTrade.profit_percentage !== undefined && copyTrade.profit_percentage !== null && copyTrade.profit_percentage !== 0
                                        ? copyTrade.profit_percentage
                                        : calculatedROI;
                        console.log('Final ROI used:', finalROI);                        document.getElementById('detailsContent').innerHTML = `
                            <div class="space-y-6">
                                <!-- Expert Info -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                            ${copyTrade.name ? copyTrade.name.charAt(0) : 'E'}
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">${copyTrade.name || 'Expert Trader'}</h4>
                                            <p class="text-gray-600 dark:text-gray-400">${copyTrade.tag || 'Professional Trader'}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">$${Number(copyTrade.price || 0).toLocaleString()}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Investment</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">$${Number(copyTrade.current_balance || 0).toLocaleString()}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Current Value</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold ${(copyTrade.total_profit || 0) >= 0 ? 'text-green-600' : 'text-red-600'}">${(copyTrade.total_profit || 0) >= 0 ? '+' : ''}$${Number(copyTrade.total_profit || 0).toLocaleString()}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">P&L</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold ${finalROI >= 0 ? 'text-green-600' : 'text-red-600'}">${finalROI >= 0 ? '+' : ''}${Number(finalROI).toFixed(2)}%</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">ROI</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Performance Chart -->
                                <div>
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Performance History</h5>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                            Days Active: ${data.daysActive || 0} days
                                        </p>
                                        ${dailyPerformance.length > 0 ? `
                                            <div class="mt-4 space-y-2 max-h-40 overflow-y-auto">
                                                ${dailyPerformance.slice(-7).map(day => `
                                                    <div class="flex justify-between items-center text-sm">
                                                        <span class="text-gray-600 dark:text-gray-400">${new Date(day.date).toLocaleDateString()}</span>
                                                        <span class="font-medium ${day.change >= 0 ? 'text-green-600' : 'text-red-600'}">
                                                            ${day.change >= 0 ? '+' : ''}${day.change}%
                                                        </span>
                                                        <span class="font-bold text-gray-900 dark:text-white">$${Number(day.balance).toLocaleString()}</span>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        ` : '<p class="text-gray-600 dark:text-gray-400 text-center mt-4">No performance data available</p>'}
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        document.getElementById('detailsContent').innerHTML = `
                            <div class="p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg">
                                <h3 class="font-bold mb-2">Invalid Response</h3>
                                <p>Unexpected response format from server</p>
                                <pre class="text-xs mt-2 bg-red-50 dark:bg-red-900/50 p-2 rounded">${JSON.stringify(data, null, 2)}</pre>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching analytics:', error);
                    document.getElementById('detailsContent').innerHTML = `
                        <div class="p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg">
                            <h3 class="font-bold mb-2">Network/Server Error</h3>
                            <p>Error: ${error.message}</p>
                            <div class="mt-3 text-xs">
                                <p><strong>Troubleshooting steps:</strong></p>
                                <ul class="list-disc list-inside mt-1">
                                    <li>Check if the route exists in web.php</li>
                                    <li>Verify the controller method exists</li>
                                    <li>Check server logs for errors</li>
                                    <li>Ensure the copyTradeId is valid: ${copyTradeId}</li>
                                </ul>
                            </div>
                        </div>
                    `;
                });
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.getElementById('detailsModal').classList.remove('flex');
        }

        function showHowItWorks() {
            document.getElementById('howItWorksModal').classList.remove('hidden');
            document.getElementById('howItWorksModal').classList.add('flex');
        }

        function closeHowItWorksModal() {
            document.getElementById('howItWorksModal').classList.add('hidden');
            document.getElementById('howItWorksModal').classList.remove('flex');
        }

        function refreshDashboard() {
            window.location.reload();
        }

        // Initialize Lucide icons and add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Add event listeners for the details buttons
            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const copyTradeId = this.getAttribute('data-id');
                    viewDetails(copyTradeId);
                });
            });

            // Add event listeners for the stop copy buttons
            document.querySelectorAll('.stop-copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const copyTradeId = this.getAttribute('data-id');
                    const expertName = this.getAttribute('data-name');
                    stopCopyPosition(copyTradeId, expertName);
                });
            });

            console.log('Event listeners attached to buttons');
        });
    </script>
@endsection
