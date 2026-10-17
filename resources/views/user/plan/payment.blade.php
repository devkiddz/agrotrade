@extends('layouts.app')
@section('title', 'Plan Payment')

@section('styles')
@parent
<style>
    .payment-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .payment-method-option {
        @apply border rounded-lg p-4 cursor-pointer;
        transition: all 0.2s ease;
    }

    .payment-method-option:hover {
        @apply border-indigo-400;
    }

    .payment-method-option.selected {
        @apply border-indigo-500 ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/20;
    }

    .payment-icon {
        @apply w-12 h-12 flex items-center justify-center rounded-full mr-4;
    }

    .payment-icon.crypto {
        @apply bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400;
    }

    .payment-icon.bank {
        @apply bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400;
    }

    .payment-icon.card {
        @apply bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400;
    }

    .payment-icon.wallet {
        @apply bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400;
    }

    /* Animation for the form */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stagger-item:nth-child(1) { animation-delay: 0.1s; }
    .stagger-item:nth-child(2) { animation-delay: 0.2s; }
    .stagger-item:nth-child(3) { animation-delay: 0.3s; }
    .stagger-item:nth-child(4) { animation-delay: 0.4s; }
    .stagger-item:nth-child(5) { animation-delay: 0.5s; }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="max-w-4xl mx-auto mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Complete Your Investment</h1>
        <p class="text-gray-600 dark:text-gray-300">Choose your preferred payment method to fund your investment plan.</p>
    </div>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column - Payment Methods -->
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8 animate-fade-in stagger-item">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Payment Method</h2>

                    <form action="{{ route('user.plans.payment.process', $userPlan->id) }}" method="POST" id="paymentForm">
                        @csrf

                        <!-- Payment Method Selection -->
                        <div class="mb-8">
                            <div class="space-y-4">
                                <!-- Wallet Option -->
                                <div class="payment-method-option selected" data-method="wallet">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="wallet" checked class="hidden" id="wallet">
                                        <div class="payment-icon wallet">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <label for="wallet" class="block text-lg font-medium text-gray-900 dark:text-white cursor-pointer">
                                                Account Balance
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Pay using your available account balance</p>
                                            <p class="mt-1 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                                Available: {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Crypto Option -->
                                <div class="payment-method-option" data-method="crypto">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="crypto" class="hidden" id="crypto">
                                        <div class="payment-icon crypto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <label for="crypto" class="block text-lg font-medium text-gray-900 dark:text-white cursor-pointer">
                                                Cryptocurrency
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Pay using Bitcoin, Ethereum, or other cryptocurrencies</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Transfer Option -->
                                <div class="payment-method-option" data-method="bank">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="bank" class="hidden" id="bank">
                                        <div class="payment-icon bank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <label for="bank" class="block text-lg font-medium text-gray-900 dark:text-white cursor-pointer">
                                                Bank Transfer
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Pay via direct bank transfer to our account</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Credit Card Option -->
                                <div class="payment-method-option" data-method="card">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="card" class="hidden" id="card">
                                        <div class="payment-icon card">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <label for="card" class="block text-lg font-medium text-gray-900 dark:text-white cursor-pointer">
                                                Credit/Debit Card
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Pay securely with your credit or debit card</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Form Sections -->
                        <div class="payment-sections">
                            <!-- Wallet Payment Section -->
                            <div id="wallet-section" class="payment-section">
                                <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg mb-6">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm text-indigo-700 dark:text-indigo-300">
                                            The amount will be deducted from your account balance.
                                        </p>
                                    </div>
                                </div>

                                @if(auth()->user()->account_bal < $userPlan->invested_amount)
                                <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg mb-6">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm text-red-700 dark:text-red-300">
                                            Insufficient funds. Please deposit more or choose another payment method.
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('user.deposits.new') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    Deposit Funds
                                </a>
                                @endif
                            </div>

                            <!-- Crypto Payment Section -->
                            <div id="crypto-section" class="payment-section hidden">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Select Cryptocurrency</h3>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        <div class="relative">
                                            <input type="radio" id="btc" name="crypto_currency" value="btc" class="peer hidden" checked>
                                            <label for="btc" class="block cursor-pointer p-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-400 dark:hover:border-gray-500">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('dash/bitcoin-btc-logo.png') }}" alt="Bitcoin" class="h-8 w-8 mr-3">
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">Bitcoin</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">BTC</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="relative">
                                            <input type="radio" id="eth" name="crypto_currency" value="eth" class="peer hidden">
                                            <label for="eth" class="block cursor-pointer p-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-400 dark:hover:border-gray-500">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('dash/ethereum-eth-logo.png') }}" alt="Ethereum" class="h-8 w-8 mr-3">
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">Ethereum</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">ETH</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="relative">
                                            <input type="radio" id="usdt" name="crypto_currency" value="usdt" class="peer hidden">
                                            <label for="usdt" class="block cursor-pointer p-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-400 dark:hover:border-gray-500">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('dash/tether-usdt-logo.png') }}" alt="USDT" class="h-8 w-8 mr-3">
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">Tether</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">USDT</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Payment Instructions</h4>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">Please send exactly <span class="font-bold text-indigo-600 dark:text-indigo-400">0.0043 BTC</span> to the following address:</p>

                                        <div class="bg-white dark:bg-gray-800 p-3 rounded-md border border-gray-200 dark:border-gray-600 mb-4 flex items-center justify-between">
                                            <code class="text-sm break-all text-gray-800 dark:text-gray-200">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</code>
                                            <button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="flex justify-center mb-4">
                                            <div class="bg-white p-2 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" viewBox="0 0 100 100">
                                                    <!-- QR Code would be generated here -->
                                                    <rect width="100" height="100" fill="white" />
                                                    <path d="M30,30 L30,40 L40,40 L40,30 Z" fill="black" />
                                                    <path d="M30,50 L30,70 L50,70 L50,50 Z" fill="black" />
                                                    <path d="M60,30 L60,50 L70,50 L70,30 Z" fill="black" />
                                                    <path d="M60,60 L60,70 L70,70 L70,60 Z" fill="black" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <p class="mb-2">• After sending, please provide the transaction ID below.</p>
                                            <p class="mb-2">• The payment will be confirmed after 1 network confirmation.</p>
                                            <p>• Your plan will be activated automatically upon confirmation.</p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction ID</label>
                                        <input type="text" id="transaction_id" name="transaction_id" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Enter transaction ID after payment">
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Transfer Section -->
                            <div id="bank-section" class="payment-section hidden">
                                <div class="mb-6">
                                    <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 mb-6">
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Bank Transfer Instructions</h4>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">Please transfer <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount, 2) }}</span> to the following bank account:</p>

                                        <div class="space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Bank Name:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ config('app.bank_name', 'BlueTrade Bank') }}</span>
                                            </div>

                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Account Name:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ config('app.account_name', 'BlueTrade Ltd') }}</span>
                                            </div>

                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Account Number:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ config('app.account_number', '1234567890') }}</span>
                                            </div>

                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Sort Code/Routing Number:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ config('app.sort_code', '012345') }}</span>
                                            </div>

                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Reference:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">INV-{{ $userPlan->id }}-{{ Auth::user()->id }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                                            <p class="mb-2">• Please use the reference number above in your transfer description.</p>
                                            <p class="mb-2">• Upload the receipt/proof of transfer below.</p>
                                            <p>• Your plan will be activated within 24 hours after verification.</p>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Payment Proof</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                    <label for="payment_proof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 focus-within:outline-none">
                                                        <span>Upload a file</span>
                                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    PNG, JPG, PDF up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Credit Card Section -->
                            <div id="card-section" class="payment-section hidden">
                                <div class="mb-6">
                                    <div class="mb-6">
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Card Number</label>
                                        <input type="text" id="card_number" name="card_number" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="0000 0000 0000 0000">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiry Date</label>
                                            <input type="text" id="expiry_date" name="expiry_date" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="MM/YY">
                                        </div>

                                        <div>
                                            <label for="cvv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CVV</label>
                                            <input type="text" id="cvv" name="cvv" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="123">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="card_holder" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Card Holder Name</label>
                                        <input type="text" id="card_holder" name="card_holder" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="John Doe">
                                    </div>

                                    <div>
                                        <div class="flex items-center">
                                            <input id="save_card" name="save_card" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                                            <label for="save_card" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                Save card for future payments
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            Complete Payment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div>
                <div class="sticky top-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Investment Summary</h3>

                        <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-300">Plan:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $userPlan->plan->name }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-300">Duration:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $userPlan->plan->duration }} {{ Str::plural('Day', $userPlan->plan->duration) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Return Rate:</span>
                                <span class="font-medium text-green-600 dark:text-green-500">{{ $userPlan->plan->expected_return }}% / {{ $userPlan->plan->return_interval }}</span>
                            </div>
                        </div>

                        <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-300">Investment Amount:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-300">Expected Profit:</span>
                                <span class="font-medium text-green-600 dark:text-green-500">{{ Auth::user()->currency }}{{ number_format($userPlan->expected_profit, 2) }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between text-lg font-bold">
                                <span class="text-gray-900 dark:text-white">Total Payout:</span>
                                <span class="text-indigo-600 dark:text-indigo-400">{{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount + $userPlan->expected_profit, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Secure Payment</h4>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">All transactions are secured and encrypted with industry-standard security measures.</p>
                            </div>
                        </div>
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
    // Payment method selection
    const paymentOptions = document.querySelectorAll('.payment-method-option');
    const paymentSections = document.querySelectorAll('.payment-section');

    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            paymentOptions.forEach(opt => opt.classList.remove('selected'));

            // Add selected class to clicked option
            this.classList.add('selected');

            // Check the radio input within this option
            const radioInput = this.querySelector('input[type="radio"]');
            radioInput.checked = true;

            // Show corresponding section
            const method = this.dataset.method;
            paymentSections.forEach(section => {
                section.classList.add('hidden');
            });

            document.getElementById(`${method}-section`).classList.remove('hidden');
        });
    });

    // File upload preview
    const fileInput = document.getElementById('payment_proof');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                const fileNameElement = this.parentElement.nextElementSibling;
                fileNameElement.textContent = fileName;
            }
        });
    }

    // Card number formatting
    const cardInput = document.getElementById('card_number');
    if (cardInput) {
        cardInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.substring(0, 16);

            // Add spaces after every 4 digits
            const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = formatted;
        });
    }

    // Expiry date formatting
    const expiryInput = document.getElementById('expiry_date');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.substring(0, 4);

            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            e.target.value = value;
        });
    }

    // CVV validation
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
        cvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.substring(0, 4);
            e.target.value = value;
        });
    }
});
</script>
@endsection
