
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" x-data="{ showConfirmModal: false, amount: '' }">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Withdraw Funds</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Withdraw your funds quickly and securely</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Withdrawal</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Withdrawal Form Card -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
            <div class="p-6 border-b border-gray-700 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full" :class="{'bg-blue-100 dark:bg-blue-900/30': '{{ $payment_mode }}' == 'Bitcoin' || '{{ $payment_mode }}' == 'Ethereum', 'bg-green-100 dark:bg-green-900/30': '{{ $payment_mode }}' == 'Bank Transfer', 'bg-purple-100 dark:bg-purple-900/30': '{{ $payment_mode }}' == 'USDT'}">
                        <i data-lucide="{{ $payment_mode == 'Bitcoin' ? 'bitcoin' : ($payment_mode == 'Ethereum' ? 'zap' : ($payment_mode == 'USDT' ? 'circle-dollar-sign' : 'building-bank')) }}" class="w-6 h-6" :class="{'text-blue-600 dark:text-blue-400': '{{ $payment_mode }}' == 'Bitcoin' || '{{ $payment_mode }}' == 'Ethereum', 'text-green-600 dark:text-green-400': '{{ $payment_mode }}' == 'Bank Transfer', 'text-purple-600 dark:text-purple-400': '{{ $payment_mode }}' == 'USDT'}"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white dark:text-white">{{ $payment_mode }} Withdrawal</h2>
                        <p class="text-sm text-gray-300 dark:text-gray-400">Complete your withdrawal request</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('completewithdrawal') }}" class="p-6" x-on:submit="showConfirmModal = true; return false;" id="withdrawalForm">
                @csrf
                <input type="hidden" name="method" value="{{ $payment_mode }}">

                <!-- Amount Field -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                        Amount to withdraw ({{ Auth::user()->currency }})
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">{{ $settings->currency }}</span>
                        </div>
                        <input type="number"
                               name="amount"
                               id="amount"
                               required
                               min="1"
                               placeholder="Enter amount to withdraw"
                               x-model="amount"
                               class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-800 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                        />
                    </div>
                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-400">
                        Available balance: {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                    </p>
                </div>
                <!-- Payment Method Specific Fields -->
                @if($payment_mode=="Bank Transfer")
                    <div class="bg-gray-800 dark:bg-gray-700/50 p-4 rounded-xl mb-6">
                        <h3 class="text-lg font-semibold text-white dark:text-white mb-4">Bank Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Bank Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="building-bank" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="bank_name"
                                           id="bank_name"
                                           placeholder="Enter bank name"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="account_name" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Account Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="account_name"
                                           id="account_name"
                                           placeholder="Enter account name"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="account_no" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Account Number
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="hash" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="account_no"
                                           id="account_no"
                                           placeholder="Enter account number"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="swiftcode" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Swift Code
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="code" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="swiftcode"
                                           id="swiftcode"
                                           placeholder="Enter swift code"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-6">
                        <label for="details" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                            {{ $payment_mode }} Wallet Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="wallet" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input type="text"
                                   name="details"
                                   id="details"
                                   required
                                   placeholder="Enter {{ $payment_mode }} wallet address"
                                   class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                            />
                        </div>
                        <p class="mt-2 text-xs text-gray-400 dark:text-gray-400">
                            Please ensure you enter the correct wallet address to avoid loss of funds
                        </p>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 py-3 px-5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="arrow-right-circle" class="h-5 w-5"></i>
                        <span>Complete Withdrawal</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Withdrawal Information Card -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto mt-8 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-blue-500/20 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white dark:text-white">Withdrawal Information</h3>
            </div>

            <div class="pl-10 space-y-3">
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">Withdrawals are typically processed within 24 hours</p>
                </div>
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">Minimum withdrawal amount: {{ Auth::user()->currency }}50</p>
                </div>
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">A {{ Auth::user()->currency }}5 fee applies to all withdrawals</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirmModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showConfirmModal = false"></div>

            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl transform transition-all max-w-md w-full p-6 z-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500/20 dark:bg-blue-900/30 mb-4">
                        <i data-lucide="alert-circle" class="h-8 w-8 text-blue-400 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white dark:text-white mb-2">Confirm Withdrawal</h3>
                    <p class="mb-6 text-gray-300 dark:text-gray-400">
                        Are you sure you want to withdraw {{ Auth::user()->currency }}<span x-text="amount"></span> to your {{ $payment_mode }} account?
                    </p>
                    <div class="flex justify-center gap-4">
                        <button @click="showConfirmModal = false"
                                class="px-4 py-2 bg-gray-700 dark:bg-gray-700 text-gray-300 dark:text-gray-300 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                            Cancel
                        </button>
                        <button @click="document.getElementById('withdrawalForm').submit()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none transition-colors">
                            Confirm Withdrawal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endsection
