@extends('layouts.app')
@section('content')

<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                <a href="{{ route('admin.copy.index') }}" class="hover:text-gray-900 dark:hover:text-white">Copy Trading</a>
                <i data-lucide="chevron-right" class="w-4 h-4 mx-2"></i>
                <span class="text-gray-900 dark:text-white">Statistics</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Overview of copy trading system performance and metrics</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.copy.active-trades') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg font-medium hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                <i data-lucide="activity" class="w-4 h-4"></i>
                Active Trades
            </a>
            <a href="{{ route('admin.copy.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Experts -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Experts</p>
                    <p class="text-3xl font-bold">{{ $statistics['total_experts'] }}</p>
                    <p class="text-blue-100 text-xs mt-1">{{ $statistics['active_experts'] }} active</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
            </div>
        </div>

        <!-- Total Copiers -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Copiers</p>
                    <p class="text-3xl font-bold">{{ $statistics['total_copiers'] }}</p>
                    <p class="text-green-100 text-xs mt-1">{{ $statistics['active_copiers'] }} currently active</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i data-lucide="copy" class="w-8 h-8"></i>
                </div>
            </div>
        </div>

        <!-- Total Volume -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Volume</p>
                    <p class="text-3xl font-bold">${{ number_format($statistics['total_volume'], 0) }}</p>
                    <p class="text-purple-100 text-xs mt-1">All time copied amount</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i data-lucide="dollar-sign" class="w-8 h-8"></i>
                </div>
            </div>
        </div>

        <!-- Active Volume -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Active Volume</p>
                    <p class="text-3xl font-bold">${{ number_format($statistics['active_volume'], 0) }}</p>
                    <p class="text-orange-100 text-xs mt-1">Currently being copied</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <i data-lucide="trending-up" class="w-8 h-8"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Performing Experts -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Top Performing Experts</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Based on total profit percentage</p>
            </div>
            <div class="p-6">
                @if($top_experts->count() > 0)
                    <div class="space-y-4">
                        @foreach($top_experts as $index => $expert)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    @if($expert->photo)
                                        <img src="{{ asset('storage/' . $expert->photo) }}" 
                                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                             alt="{{ $expert->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($expert->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $expert->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $expert->activeCopiers()->count() }} active copiers</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">+{{ number_format((float)$expert->total_profit, 1) }}%</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $expert->win_rate }}% win rate</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="trending-up" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">No expert performance data available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Most Popular Experts -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Most Popular Experts</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Based on number of active copiers</p>
            </div>
            <div class="p-6">
                @if($popular_experts->count() > 0)
                    <div class="space-y-4">
                        @foreach($popular_experts as $index => $expert)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-blue-600 text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    @if($expert->photo)
                                        <img src="{{ asset('storage/' . $expert->photo) }}" 
                                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                             alt="{{ $expert->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($expert->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $expert->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $expert->followers }} total followers</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $expert->active_copiers_count }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">active copiers</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">No popularity data available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Copy Trading Activity</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Latest copy trading transactions and updates</p>
            </div>
            <div class="p-6">
                @if($recent_activity->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_activity as $activity)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    @if($activity->expert && $activity->expert->photo)
                                        <img src="{{ asset('storage/' . $activity->expert->photo) }}" 
                                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                             alt="{{ $activity->expert->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            @if($activity->expert)
                                                {{ substr($activity->expert->name, 0, 1) }}
                                            @else
                                                U
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            @if($activity->user)
                                                {{ $activity->user->name }}
                                            @else
                                                Unknown User
                                            @endif
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            @if($activity->active === 'yes')
                                                Started copying {{ $activity->expert ? $activity->expert->name : 'Unknown Expert' }}
                                            @else
                                                Stopped copying {{ $activity->expert ? $activity->expert->name : 'Unknown Expert' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format((float)$activity->amount, 2) }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="activity" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">No recent copy trading activity</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endsection
