
@extends('layouts.dasht')
@section('title', $title)
@section('content')
<div class="min-h-screen bg-gray-900 p-4 md:p-6" x-data="transactionHistory()" x-init="init()">
    <x-danger-alert />
    <x-success-alert />

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-4 mb-2">
                    <a href="{{ route('assetbalance') }}"
                       class="inline-flex items-center px-3 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white text-sm font-medium rounded-lg border border-gray-600 hover:border-gray-500 transition-all duration-200">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to Exchange
                    </a>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Exchange History</h1>
                <p class="text-gray-400 text-sm md:text-base">
                    Track all your cryptocurrency exchange transactions
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-2 px-3 py-2 bg-gray-800 rounded-lg border border-gray-700">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-gray-400">{{ $transactions->total() }} Total Transactions</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="mb-6">
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-4 md:p-6">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Search Transactions</label>
                    <div class="relative">
                        <input type="text"
                               x-model="searchQuery"
                               @input="filterTransactions()"
                               placeholder="Search by currency, amount, or date..."
                               class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-500">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Filter by Currency</label>
                        <select x-model="selectedCurrency"
                                @change="filterTransactions()"
                                class="bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">All Currencies</option>
                            <option value="BTC">Bitcoin (BTC)</option>
                            <option value="ETH">Ethereum (ETH)</option>
                            <option value="USDT">Tether (USDT)</option>
                            <option value="USD">US Dollar (USD)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Date Range</label>
                        <select x-model="dateRange"
                                @change="filterTransactions()"
                                class="bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Transaction History</h2>
                <div class="flex items-center gap-2">
                    <button @click="toggleView()"
                            class="inline-flex items-center px-3 py-1 bg-gray-700 hover:bg-gray-600 text-gray-300 text-xs font-medium rounded-md transition-colors duration-200">
                        <i data-lucide="layout-grid" x-show="viewMode === 'table'" class="w-3 h-3 mr-1"></i>
                        <i data-lucide="list" x-show="viewMode === 'cards'" class="w-3 h-3 mr-1"></i>
                        <span x-text="viewMode === 'table' ? 'Card View' : 'Table View'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div x-show="viewMode === 'table'" class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                <button @click="sortBy('source')" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                                    Source
                                    <i data-lucide="chevron-up-down" class="w-3 h-3"></i>
                                </button>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                <button @click="sortBy('dest')" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                                    Destination
                                    <i data-lucide="chevron-up-down" class="w-3 h-3"></i>
                                </button>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                <button @click="sortBy('amount')" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                                    Amount
                                    <i data-lucide="chevron-up-down" class="w-3 h-3"></i>
                                </button>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                <button @click="sortBy('quantity')" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                                    Received
                                    <i data-lucide="chevron-up-down" class="w-3 h-3"></i>
                                </button>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                <button @click="sortBy('created_at')" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                                    Date
                                    <i data-lucide="chevron-up-down" class="w-3 h-3"></i>
                                </button>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($transactions as $tran)
                        <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-xs font-bold text-orange-400">{{ strtoupper($tran->source) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ strtoupper($tran->source) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-xs font-bold text-green-400">{{ strtoupper($tran->dest) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ strtoupper($tran->dest) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-white">{{ number_format($tran->amount, 8) }}</div>
                                    <div class="text-gray-400">{{ strtoupper($tran->source) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-white">{{ number_format($tran->quantity, 8) }}</div>
                                    <div class="text-gray-400">{{ strtoupper($tran->dest) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    <div class="font-medium text-white">{{ \Carbon\Carbon::parse($tran->created_at)->format('M j, Y') }}</div>
                                    <div class="text-gray-400">{{ \Carbon\Carbon::parse($tran->created_at)->format('g:i A') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                    Completed
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                        <i data-lucide="activity" class="w-8 h-8 text-gray-500"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-2">No Transactions Found</h3>
                                    <p class="text-gray-400 mb-6">You haven't made any exchanges yet.</p>
                                    <a href="{{ route('assetbalance') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i data-lucide="repeat" class="w-4 h-4 mr-2"></i>
                                        Start Trading
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Mobile Card View -->
        <div x-show="viewMode === 'cards'" class="lg:hidden">
            <div class="space-y-4 p-4">
                @forelse($transactions as $tran)
                <div class="bg-gray-700 border border-gray-600 rounded-xl p-4 hover:bg-gray-600/50 transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-bold text-orange-400">{{ strtoupper($tran->source) }}</span>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-gray-400"></i>
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-bold text-green-400">{{ strtoupper($tran->dest) }}</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                            Completed
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Sent</div>
                            <div class="text-sm font-medium text-white">{{ number_format($tran->amount, 8) }}</div>
                            <div class="text-xs text-gray-400">{{ strtoupper($tran->source) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Received</div>
                            <div class="text-sm font-medium text-white">{{ number_format($tran->quantity, 8) }}</div>
                            <div class="text-xs text-gray-400">{{ strtoupper($tran->dest) }}</div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-600">
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>{{ \Carbon\Carbon::parse($tran->created_at)->format('M j, Y g:i A') }}</span>
                            <button class="text-blue-400 hover:text-blue-300 transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="activity" class="w-8 h-8 text-gray-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Transactions Found</h3>
                    <p class="text-gray-400 mb-6">You haven't made any exchanges yet.</p>
                    <a href="{{ route('assetbalance') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i data-lucide="repeat" class="w-4 h-4 mr-2"></i>
                        Start Trading
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Desktop Card View -->
        <div x-show="viewMode === 'cards'" class="hidden lg:block">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 p-6">
                @forelse($transactions as $tran)
                <div class="bg-gray-700 border border-gray-600 rounded-xl p-6 hover:bg-gray-600/50 transition-all duration-200 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-bold text-orange-400">{{ strtoupper($tran->source) }}</span>
                                </div>
                                <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400"></i>
                                <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-bold text-green-400">{{ strtoupper($tran->dest) }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                            Completed
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-4">
                        <div class="text-center p-4 bg-gray-800 rounded-lg">
                            <div class="text-xs text-gray-400 mb-2">Amount Sent</div>
                            <div class="text-lg font-bold text-white">{{ number_format($tran->amount, 8) }}</div>
                            <div class="text-sm text-gray-400">{{ strtoupper($tran->source) }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-800 rounded-lg">
                            <div class="text-xs text-gray-400 mb-2">Amount Received</div>
                            <div class="text-lg font-bold text-white">{{ number_format($tran->quantity, 8) }}</div>
                            <div class="text-sm text-gray-400">{{ strtoupper($tran->dest) }}</div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-white">{{ \Carbon\Carbon::parse($tran->created_at)->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($tran->created_at)->format('g:i A') }}</div>
                            </div>
                            <button class="inline-flex items-center px-3 py-1 bg-gray-800 hover:bg-gray-700 text-blue-400 hover:text-blue-300 text-sm font-medium rounded-md transition-colors duration-200">
                                <i data-lucide="external-link" class="w-3 h-3 mr-1"></i>
                                Details
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="activity" class="w-10 h-10 text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">No Transactions Found</h3>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">You haven't made any exchanges yet. Start trading to see your transaction history here.</p>
                    <a href="{{ route('assetbalance') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200">
                        <i data-lucide="repeat" class="w-5 h-5 mr-2"></i>
                        Start Trading
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="bg-gray-800 border border-gray-700 rounded-xl px-6 py-4">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>

<script>
function transactionHistory() {
    return {
        searchQuery: '',
        selectedCurrency: '',
        dateRange: '',
        viewMode: window.innerWidth >= 1024 ? 'table' : 'cards',
        sortField: 'created_at',
        sortDirection: 'desc',

        init() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Listen for window resize to adjust view mode
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024 && this.viewMode === 'cards') {
                    this.viewMode = 'table';
                } else if (window.innerWidth < 1024 && this.viewMode === 'table') {
                    this.viewMode = 'cards';
                }
            });
        },

        toggleView() {
            this.viewMode = this.viewMode === 'table' ? 'cards' : 'table';
        },

        filterTransactions() {
            // This would typically involve AJAX calls to filter server-side
            // For now, we'll implement client-side filtering if needed
            console.log('Filtering transactions...', {
                search: this.searchQuery,
                currency: this.selectedCurrency,
                dateRange: this.dateRange
            });
        },

        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }

            // Implement sorting logic here
            console.log('Sorting by:', field, this.sortDirection);
        }
    }
}
</script>
@endsection
