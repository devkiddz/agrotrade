@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('user.bots.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Bot Dashboard
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Trading History</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $investment->bot->name ?? 'Bot' }} Trading History</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Track detailed trading performance and analytics</p>
            </div>

            <a href="{{ route('user.bots.dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Investment Overview -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Investment Overview</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Initial Investment -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($investment->amount, 2) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Initial Investment</div>
                    </div>

                    <!-- Current Balance -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-3m-3 3l-3-3"></path>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($investment->current_balance, 2) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Current Balance</div>
                    </div>

                    <!-- Total Profit/Loss -->
                    <div class="text-center">
                        <div class="w-12 h-12 {{ ($investment->total_profit - $investment->total_loss) >= 0 ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 {{ ($investment->total_profit - $investment->total_loss) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($investment->total_profit - $investment->total_loss) >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold {{ ($investment->total_profit - $investment->total_loss) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ ($investment->total_profit - $investment->total_loss) >= 0 ? '+' : '' }}${{ number_format($investment->total_profit - $investment->total_loss, 2) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Net P&L</div>
                    </div>

                    <!-- Performance -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        @php
                            $totalTrades = $investment->successful_trades + $investment->failed_trades;
                            $winRate = $totalTrades > 0 ? ($investment->successful_trades / $totalTrades) * 100 : 0;
                        @endphp
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($winRate, 1) }}%</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Win Rate</div>
                    </div>
                </div>

                <!-- Trading Statistics -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $investment->successful_trades + $investment->failed_trades }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Total Trades</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-green-600">{{ $investment->successful_trades }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Winning Trades</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-red-600">{{ $investment->failed_trades }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Losing Trades</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $investment->created_at->diffInDays(now()) }} days
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Active Duration</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trading History -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Trading History</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Detailed history of all trades executed by this bot</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $trades->total() }} total trades</span>
                </div>
            </div>

            @if($trades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Trade Details</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Type</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Amount</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">P&L</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Strategy</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Duration</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900 dark:text-white text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($trades as $trade)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $trade->trading_pair ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                Entry: ${{ number_format($trade->entry_price, 4) }}
                                                → Exit: ${{ number_format($trade->exit_price, 4) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $trade->trade_type == 'BUY' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                            {{ $trade->trade_type ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-900 dark:text-white font-medium">
                                        ${{ number_format($trade->amount, 2) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <span class="font-semibold {{ $trade->profit_loss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $trade->profit_loss >= 0 ? '+' : '' }}${{ number_format($trade->profit_loss, 2) }}
                                            </span>
                                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                                ({{ $trade->profit_loss >= 0 ? '+' : '' }}{{ number_format($trade->profit_percentage, 2) }}%)
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 dark:text-gray-400">
                                        {{ $trade->strategy_used ?? 'Auto' }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 dark:text-gray-400">
                                        @if($trade->opened_at && $trade->closed_at)
                                            @php
                                                $duration = \Carbon\Carbon::parse($trade->opened_at)->diffInMinutes(\Carbon\Carbon::parse($trade->closed_at));
                                            @endphp
                                            {{ $duration >= 60 ? number_format($duration / 60, 1) . 'h' : $duration . 'm' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $trade->result == 'profit' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                            {{ ucfirst($trade->result ?? 'completed') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($trades->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $trades->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Trading History</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        This bot hasn't executed any trades yet. Trading history will appear here once the bot starts making trades.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        // Initialize any interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any JavaScript functionality here
        });
    </script>
@endsection
