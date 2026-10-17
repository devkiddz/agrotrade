@extends('layouts.dasht', ['title' => $title])

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-800 text-white">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-16">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Bot Trading Dashboard</h1>
                    <p class="text-xl text-white/90 max-w-2xl">Monitor and manage your automated trading investments</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-32 h-32 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-16 h-16"></i>
                    </div>
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
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center">
                        <i data-lucide="wallet" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                    ${{ number_format($stats['total_invested'], 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Invested</div>
            </div>

            <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-2xl flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                    ${{ number_format($stats['current_balance'], 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Current Balance</div>
            </div>

            <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/50 rounded-2xl flex items-center justify-center">
                        <i data-lucide="arrow-up" class="w-6 h-6 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">
                    +${{ number_format($stats['total_profit'], 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Profit</div>
            </div>

            <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/50 dark:to-red-800/50 rounded-2xl flex items-center justify-center">
                        <i data-lucide="arrow-down" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-red-600 dark:text-red-400 mb-1">
                    -${{ number_format($stats['total_loss'], 2) }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Loss</div>
            </div>

            <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center">
                        <i data-lucide="bot" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['active_bots'] }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Active Bots</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Active Investments -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Investments</h2>
                            <a href="{{ route('user.bots.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-2xl transition-colors duration-200">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                New Investment
                            </a>
                        </div>

                        @if($investments->count() > 0)
                            <div class="space-y-4">
                                @foreach($investments as $investment)
                                <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-700/50 rounded-2xl border border-gray-200/50 dark:border-gray-600/50">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                                                <i data-lucide="bot" class="w-6 h-6 text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $investment->bot->name }}</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $investment->bot->description ?? 'Advanced Trading Bot' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ $investment->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                                {{ ucfirst($investment->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Invested</div>
                                            <div class="font-semibold text-gray-900 dark:text-white">${{ number_format($investment->investment_amount, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Current Value</div>
                                            <div class="font-semibold text-gray-900 dark:text-white">${{ number_format($investment->current_balance ?? $investment->investment_amount, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">P&L</div>
                                            @php
                                                $pnl = ($investment->current_balance ?? $investment->investment_amount) - $investment->investment_amount;
                                            @endphp
                                            <div class="font-semibold {{ $pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $pnl >= 0 ? '+' : '' }}${{ number_format($pnl, 2) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">ROI</div>
                                            @php
                                                $roi = $investment->investment_amount > 0 ? ($pnl / $investment->investment_amount) * 100 : 0;
                                            @endphp
                                            <div class="font-semibold {{ $roi >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $roi >= 0 ? '+' : '' }}{{ number_format($roi, 2) }}%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            Started: {{ $investment->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('user.bots.show', $investment->bot) }}" class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                                                <i data-lucide="eye" class="w-3 h-3 mr-1"></i>
                                                View
                                            </a>
                                            @if($investment->status == 'active')
                                            <button class="inline-flex items-center px-3 py-1 bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-xs font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-900/30 transition-colors duration-200">
                                                <i data-lucide="pause" class="w-3 h-3 mr-1"></i>
                                                Pause
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="bot" class="w-12 h-12 text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Investments Yet</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Start your automated trading journey today</p>
                                <a href="{{ route('user.bots.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white font-medium rounded-2xl transition-all duration-300 transform hover:scale-105">
                                    <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                                    Start Investing
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Recent Trading Activity -->
                <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Activity</h3>

                        @if($recentTrades->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTrades->take(5) as $trade)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 {{ $trade->profit_loss >= 0 ? 'bg-green-100 dark:bg-green-900/20' : 'bg-red-100 dark:bg-red-900/20' }} rounded-lg flex items-center justify-center">
                                            <i data-lucide="{{ $trade->profit_loss >= 0 ? 'trending-up' : 'trending-down' }}" class="w-4 h-4 {{ $trade->profit_loss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $trade->userBotInvestment->bot->name ?? 'Bot Trade' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $trade->opened_at->format('M d, H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium {{ $trade->profit_loss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $trade->profit_loss >= 0 ? '+' : '' }}${{ number_format($trade->profit_loss, 2) }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="activity" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">No trading activity yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-900 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-200/20 dark:border-gray-700/30 overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>

                        <div class="space-y-3">
                            <a href="{{ route('user.bots.index') }}" class="flex items-center w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-2xl hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-900/30 dark:hover:to-blue-800/30 transition-all duration-200 group">
                                <i data-lucide="plus" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">New Investment</span>
                            </a>

                            <a href="{{ route('withdrawalsdeposits') }}" class="flex items-center w-full px-4 py-3 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 text-green-700 dark:text-green-300 rounded-2xl hover:from-green-100 hover:to-green-200 dark:hover:from-green-900/30 dark:hover:to-green-800/30 transition-all duration-200 group">
                                <i data-lucide="download" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Withdraw Funds</span>
                            </a>

                            <a href="{{ route('deposits') }}" class="flex items-center w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-2xl hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-900/30 dark:hover:to-blue-800/30 transition-all duration-200 group">
                                <i data-lucide="upload" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Deposit Funds</span>
                            </a>

                            <a href="{{ route('support') }}" class="flex items-center w-full px-4 py-3 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 text-orange-700 dark:text-orange-300 rounded-2xl hover:from-orange-100 hover:to-orange-200 dark:hover:from-orange-900/30 dark:hover:to-orange-800/30 transition-all duration-200 group">
                                <i data-lucide="life-buoy" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Get Support</span>
                            </a>
                        </div>
                    </div>
                </div>
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
