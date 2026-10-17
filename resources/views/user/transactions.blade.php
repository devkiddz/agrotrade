@extends('layouts.dasht')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 flex items-center justify-center backdrop-blur-sm">
                    <i data-lucide="credit-card" class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-light text-slate-800 dark:text-white mb-1 sm:mb-2">
                        Transaction History
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-light text-base sm:text-lg">
                        Monitor all your financial activities
                    </p>
                </div>
            </div>
        </div>

        <!-- Modern Glass Card -->
        <div class="bg-gray-900 rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-gray-700 shadow-xl floating-animation">
            <!-- Navigation Tabs -->
            <div x-data="{ activeTab: 'deposits' }" class="w-full">
                <!-- Mobile-First Tab Navigation -->
                <div class="flex flex-col sm:flex-row gap-2 p-2 mb-6 sm:mb-8 bg-gray-800 rounded-xl sm:rounded-2xl backdrop-blur-sm">
                    <button @click="activeTab = 'deposits'"
                            :class="activeTab === 'deposits' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="arrow-down-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Deposits</span>
                    </button>
                    <button @click="activeTab = 'withdrawals'"
                            :class="activeTab === 'withdrawals' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="arrow-up-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Withdrawals</span>
                    </button>
                    <button @click="activeTab = 'others'"
                            :class="activeTab === 'others' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="activity" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Others</span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-2 sm:p-4 lg:p-6">
                    <!-- Deposits Tab -->
                    <div x-show="activeTab === 'deposits'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Deposit History</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Track your deposit transactions</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search deposits..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if($deposits->count() > 0)
                                @foreach ($deposits as $deposit)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center">
                                                <i data-lucide="arrow-down" class="w-5 h-5 text-emerald-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($deposit->amount, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Deposit</div>
                                            </div>
                                        </div>
                                        @if ($deposit->status == 'Processed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-400">
                                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></div>
                                                {{ $deposit->status }}
                                            </span>
                                        @elseif($deposit->status == 'Pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-900/30 text-amber-400">
                                                <div class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></div>
                                                {{ $deposit->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-400">Payment Mode</span>
                                        <span class="text-blue-400 bg-blue-900/30 px-2 py-1 rounded-lg">{{ $deposit->payment_mode }}</span>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <i data-lucide="arrow-down-circle" class="w-8 h-8 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">No deposits yet</h4>
                                    <p class="text-slate-400 font-light text-sm">Your deposit history will appear here</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if($deposits->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Payment Mode</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($deposits as $deposit)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center">
                                                        <i data-lucide="arrow-down" class="w-5 h-5 text-emerald-500"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($deposit->amount, 2) }}</div>
                                                        <div class="text-slate-400 text-sm">Deposit</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                                                    {{ $deposit->payment_mode }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($deposit->status == 'Processed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-900/30 text-emerald-400">
                                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                                        {{ $deposit->status }}
                                                    </span>
                                                @elseif($deposit->status == 'Pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-900/30 text-amber-400">
                                                        <div class="w-2 h-2 bg-amber-500 rounded-full mr-2"></div>
                                                        {{ $deposit->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <i data-lucide="arrow-down-circle" class="w-10 h-10 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">No deposits yet</h4>
                                    <p class="text-slate-400 font-light">Your deposit history will appear here</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Withdrawals Tab -->
                    <div x-show="activeTab === 'withdrawals'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Withdrawal History</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Track your withdrawal transactions</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search withdrawals..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if($withdrawals->count() > 0)
                                @foreach ($withdrawals as $withdrawal)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-500/20 flex items-center justify-center">
                                                <i data-lucide="arrow-up" class="w-5 h-5 text-red-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Withdrawal</div>
                                            </div>
                                        </div>
                                        @if ($withdrawal->status == 'Processed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-400">
                                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></div>
                                                {{ $withdrawal->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-900/30 text-red-400">
                                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></div>
                                                {{ $withdrawal->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-400">Total Deducted</span>
                                            <span class="text-white">{{ Auth::user()->currency }}{{ number_format($withdrawal->to_deduct, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-400">Payment Mode</span>
                                            <span class="text-blue-400 bg-blue-900/30 px-2 py-1 rounded-lg">{{ $withdrawal->payment_mode }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <i data-lucide="arrow-up-circle" class="w-8 h-8 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">No withdrawals yet</h4>
                                    <p class="text-slate-400 font-light text-sm">Your withdrawal history will appear here</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if($withdrawals->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Amount Requested</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Total Deducted</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Payment Mode</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($withdrawals as $withdrawal)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-500/20 flex items-center justify-center">
                                                        <i data-lucide="arrow-up" class="w-5 h-5 text-red-500"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}</div>
                                                        <div class="text-slate-400 text-sm">Withdrawal</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->to_deduct, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Including fees</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                                                    {{ $withdrawal->payment_mode }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($withdrawal->status == 'Processed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-900/30 text-emerald-400">
                                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                                        {{ $withdrawal->status }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-900/30 text-red-400">
                                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                        {{ $withdrawal->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <i data-lucide="arrow-up-circle" class="w-10 h-10 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">No withdrawals yet</h4>
                                    <p class="text-slate-400 font-light">Your withdrawal history will appear here</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Other Transactions Tab -->
                    <div x-show="activeTab === 'others'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Other Transactions</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Additional transaction history</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search transactions..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if(isset($t_history) && $t_history->count() > 0)
                                @foreach ($t_history as $history)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                                <i data-lucide="activity" class="w-5 h-5 text-indigo-500"></i>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ $history->type }}</div>
                                                <div class="text-slate-400 text-sm">Transaction</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-white font-medium">
                                                @if(isset($settings))
                                                    {{ $settings->currency }}{{ number_format($history->amount, 2) }}
                                                @else
                                                    ${{ number_format($history->amount, 2) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-400">Description</span>
                                        <span class="text-slate-300">{{ $history->plan ?? 'N/A' }}</span>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <i data-lucide="activity" class="w-8 h-8 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">No other transactions</h4>
                                    <p class="text-slate-400 font-light text-sm">Additional transactions will appear here</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if(isset($t_history) && $t_history->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Description</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($t_history as $history)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                                        <i data-lucide="activity" class="w-5 h-5 text-indigo-500"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ $history->type }}</div>
                                                        <div class="text-slate-400 text-sm">Transaction</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-white font-medium">
                                                    @if(isset($settings))
                                                        {{ $settings->currency }}{{ number_format($history->amount, 2) }}
                                                    @else
                                                        ${{ number_format($history->amount, 2) }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-slate-300 font-light">{{ $history->plan ?? 'N/A' }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <i data-lucide="activity" class="w-10 h-10 text-slate-400"></i>
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">No other transactions</h4>
                                    <p class="text-slate-400 font-light">Additional transactions will appear here</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Mobile-First Responsive Styles */
    .glass-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.15);
    }

    .glass-input {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(75, 85, 99, 0.6);
    }

    .glass-input:focus {
        background: rgba(31, 41, 55, 0.9);
        border-color: rgba(59, 130, 246, 0.8);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Floating Animation - Reduced for mobile */
    .floating-animation {
        animation: floating 8s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translate(0, 0px); }
        50% { transform: translate(0, -5px); }
    }

    /* Enhanced Mobile Responsiveness */
    @media (max-width: 640px) {
        .floating-animation {
            animation: none; /* Disable animation on mobile for better performance */
        }

        /* Reduce padding on mobile */
        .mobile-padding {
            padding: 0.75rem;
        }

        /* Better touch targets */
        button {
            min-height: 44px;
        }

        /* Improved readability */
        .mobile-text {
            font-size: 0.875rem;
            line-height: 1.5;
        }
    }

    @media (max-width: 768px) {
        /* Stack elements vertically on tablets */
        .tablet-stack {
            flex-direction: column;
            gap: 1rem;
        }

        /* Full width search on mobile */
        .mobile-search {
            width: 100%;
        }
    }

    /* Custom scrollbar for better mobile experience */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: rgba(75, 85, 99, 0.3);
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }

    /* Enhanced focus states for accessibility */
    button:focus,
    input:focus {
        outline: 2px solid rgba(59, 130, 246, 0.5);
        outline-offset: 2px;
    }

    /* Smooth transitions for better UX */
    * {
        transition: all 0.2s ease-in-out;
    }

    /* Status indicators */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Card hover effects */
    .transaction-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .transaction-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Print styles */
    @media print {
        .floating-animation {
            animation: none;
        }

        .glass-card {
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: none;
        }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .glass-card {
            background: #1f2937;
            border: 2px solid #6b7280;
        }

        .text-slate-400 {
            color: #d1d5db;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .floating-animation,
        .transition-all,
        .transition-colors,
        .transition-transform {
            animation: none;
            transition: none;
        }
    }
</style>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>

@endsection
