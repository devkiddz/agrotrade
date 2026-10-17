@extends('layouts.dasht', ['title' => $title])

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900" x-cloak>
    <!-- Simple Header -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-3">
                        <a href="{{ route('user.bots.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Back to Bots
                        </a>
                    </div>
                    <h1 class="text-2xl font-medium text-gray-900 dark:text-white mb-2">{{ $bot->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $bot->description }}</p>
                </div>
                <div class="hidden lg:flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Active</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Performance Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Performance</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="text-2xl font-medium text-gray-900 dark:text-white">{{ number_format($botStats['success_rate'], 1) }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Success Rate</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="text-2xl font-medium text-gray-900 dark:text-white">{{ number_format($botStats['total_trades']) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Trades</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="text-2xl font-medium text-gray-900 dark:text-white">${{ number_format($botStats['total_profit'], 2) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Profit</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="text-2xl font-medium text-gray-900 dark:text-white">{{ number_format($botStats['expected_return'], 1) }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Expected Return</div>
                        </div>
                    </div>
                </div>

                <!-- Strategy Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Trading Strategy</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i data-lucide="target" class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2"></i>
                                    <span class="font-medium text-gray-900 dark:text-white">Strategy Type</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">{{ $bot->strategy ?? 'Advanced AI Trading' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i data-lucide="clock" class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2"></i>
                                    <span class="font-medium text-gray-900 dark:text-white">Trading Frequency</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">{{ $bot->trading_frequency ?? 'Multiple times daily' }}</p>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i data-lucide="info" class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2"></i>
                                <span class="font-medium text-gray-900 dark:text-white">Description</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">{{ $bot->strategy_description ?? 'Advanced machine learning algorithms analyze market patterns to execute profitable trades.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Trades -->
                @if($recentTrades && $recentTrades->count() > 0)
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Trades</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Date</th>
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Type</th>
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Amount</th>
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Result</th>
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Profit/Loss</th>
                                    <th class="text-left py-3 px-2 font-medium text-gray-600 dark:text-gray-400 text-sm">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTrades as $trade)
                                <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="py-3 px-2 text-gray-600 dark:text-gray-400 text-sm">{{ $trade->created_at->format('M d, Y H:i') }}</td>
                                    <td class="py-3 px-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            {{ $trade->trade_type == 'BUY' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' }}">
                                            {{ ucfirst($trade->trade_type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-gray-900 dark:text-white font-medium text-sm">${{ number_format($trade->amount, 2) }}</td>
                                    <td class="py-3 px-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            {{ $trade->result == 'profit' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' }}">
                                            {{ ucfirst($trade->result) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2">
                                        <span class="font-medium text-sm {{ $trade->profit_loss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $trade->profit_loss >= 0 ? '+' : '' }}${{ number_format($trade->profit_loss, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            {{ $trade->result == 'profit' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' }}">
                                            {{ number_format($trade->profit_percentage, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Investment Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Investment Details</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Minimum Investment</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($bot->min_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Maximum Investment</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($bot->max_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Expected ROI</span>
                            <span class="font-medium text-green-600 dark:text-green-400">{{ number_format($bot->expected_return, 1) }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Risk Level</span>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                {{ $bot->risk_level == 'low' ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400' :
                                   ($bot->risk_level == 'medium' ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' :
                                    'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400') }}">
                                {{ ucfirst($bot->risk_level) }}
                            </span>
                        </div>
                    </div>

                    @if($userInvestment)
                        <!-- Current Investment -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Your Investment</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Amount Invested</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($userInvestment->investment_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Current Profit</span>
                                    <span class="font-medium {{ $userInvestment->current_profit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $userInvestment->current_profit >= 0 ? '+' : '' }}${{ number_format($userInvestment->current_profit, 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">Total Value</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($userInvestment->current_balance, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <form id="cancelInvestmentForm" action="{{ route('user.bots.cancel', ['investment' => $userInvestment->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-2 inline"></i>
                                Cancel Investment
                            </button>
                        </form>
                    @else
                        <!-- Investment Form -->
                        <form action="{{ route('user.bots.invest', $bot) }}" method="POST" class="space-y-4" x-data="{ amount: {{ $bot->min_investment }}, autoReinvest: false }" x-cloak>
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Investment Amount</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number"
                                           name="amount"
                                           x-model="amount"
                                           min="{{ $bot->min_investment }}"
                                           max="{{ $bot->max_investment }}"
                                           step="0.01"
                                           class="w-full pl-8 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors text-gray-900 dark:text-white"
                                           required>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <span>Min: ${{ number_format($bot->min_investment, 2) }}</span>
                                    <span>Max: ${{ number_format($bot->max_investment, 2) }}</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox"
                                           name="auto_reinvest"
                                           x-model="autoReinvest"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Auto-reinvest profits</span>
                                </label>

                                <div x-show="autoReinvest" x-transition class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reinvestment Percentage</label>
                                    <input type="number"
                                           name="reinvest_percentage"
                                           min="0"
                                           max="100"
                                           value="50"
                                           class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors text-gray-900 dark:text-white">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Percentage of profits to automatically reinvest</p>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                                <i data-lucide="trending-up" class="w-4 h-4 mr-2 inline"></i>
                                Start Investment
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Risk Information Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <i data-lucide="shield-alert" class="w-4 h-4 mr-2 text-orange-500"></i>
                        Risk Information
                    </h3>

                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-start space-x-2">
                            <div class="w-1.5 h-1.5 bg-orange-400 rounded-full mt-2 flex-shrink-0"></div>
                            <p>Trading involves substantial risk and may result in loss of capital.</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <div class="w-1.5 h-1.5 bg-orange-400 rounded-full mt-2 flex-shrink-0"></div>
                            <p>Past performance does not guarantee future results.</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <div class="w-1.5 h-1.5 bg-orange-400 rounded-full mt-2 flex-shrink-0"></div>
                            <p>Only invest what you can afford to lose.</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <div class="w-1.5 h-1.5 bg-orange-400 rounded-full mt-2 flex-shrink-0"></div>
                            <p>Bot trading is automated but not guaranteed to be profitable.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // SweetAlert for cancel investment button
    document.addEventListener('DOMContentLoaded', function() {
        const cancelForm = document.getElementById('cancelInvestmentForm');

        if (cancelForm) {
            cancelForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to cancel this investment. This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, cancel investment',
                    cancelButtonText: 'No, keep my investment',
                    reverseButtons: true,
                    background: document.querySelector('html').classList.contains('dark') ? '#1f2937' : '#ffffff',
                    color: document.querySelector('html').classList.contains('dark') ? '#ffffff' : '#1f2937'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show processing state
                        Swal.fire({
                            title: 'Processing',
                            text: 'Cancelling your investment...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                                // Submit the form
                                cancelForm.submit();
                            }
                        });
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
