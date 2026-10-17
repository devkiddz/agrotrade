@extends('layouts.dasht')
@section('title', 'Invest in Plan')

@section('styles')
@parent
<style>
    .investment-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .investment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Slider styles */
    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 8px;
        border-radius: 5px;
        background: #d3d3d3;
        outline: none;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
    }

    .dark .slider {
        background: #4b5563;
    }

    .dark .slider::-webkit-slider-thumb {
        background: #6366f1;
    }

    .dark .slider::-moz-range-thumb {
        background: #6366f1;
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
    <!-- Header Section -->
    <div class="mb-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('user.plans.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Investment Plans</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('user.plans.show', $plan->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $plan->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Invest</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Invest in {{ $plan->name }}</h1>
        <p class="text-gray-600 dark:text-gray-300">Complete your investment details below</p>
    </div>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Investment Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
                <form action="{{ route('user.plans.process', $plan->id) }}" method="POST" id="investmentForm">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Investment Amount</h3>

                        <!-- Investment Amount Slider -->
                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Investment Amount</label>
                            <div class="flex items-center mb-2">
                                <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}{{ number_format($plan->min_amount, 2) }}</span>
                                <div class="mx-4 flex-1">
                                    <input type="range" id="amountSlider" class="slider" min="{{ $plan->min_amount }}" max="{{ $plan->max_amount }}" step="1" value="{{ old('amount', $plan->min_amount) }}">
                                </div>
                                <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}{{ number_format($plan->max_amount, 2) }}</span>
                            </div>
                            <div class="mt-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}</span>
                                    </div>
                                    <input type="number" id="amount" name="amount" value="{{ old('amount', $plan->min_amount) }}" min="{{ $plan->min_amount }}" max="{{ $plan->max_amount }}" step="0.01" required class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm">
                                </div>
                                @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Available Balance: {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Payment Method</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="wallet" name="payment_method" value="wallet" checked class="peer hidden">
                                    <label for="wallet" class="block cursor-pointer p-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-400 dark:hover:border-gray-500">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Wallet Balance</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Use your existing account balance</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" id="crypto" name="payment_method" value="crypto" class="peer hidden">
                                    <label for="crypto" class="block cursor-pointer p-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-400 dark:hover:border-gray-500">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Cryptocurrency</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Pay with Bitcoin, Ethereum, etc.</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Investment Options -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Investment Options</h4>

                            @if($plan->compound_interest)
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="compound_interest" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Enable Compound Interest</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Compound interest reinvests your earnings to potentially increase your returns.
                                </p>
                            </div>
                            @endif

                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="auto_renewal" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Auto-renew After Maturity</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Automatically reinvest in this plan after it reaches maturity.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Referral Code -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Referral Code (Optional)</h3>

                        <div>
                            <label for="referral_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Have a Referral Code?</label>
                            <input type="text" id="referral_code" name="referral_code" value="{{ old('referral_code') }}" class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Enter referral code">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                If someone referred you, enter their code here. They will receive a {{ $plan->referral_bonus }}% bonus.
                            </p>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-8">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-700 dark:text-gray-300">I agree to the <a href="{{ route('terms') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Privacy Policy</a></label>
                            </div>
                        </div>
                        @error('terms')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Complete Investment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Investment Summary -->
        <div>
            <div class="sticky top-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6 animate-fade-in stagger-item">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Investment Summary</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Selected Plan:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $plan->name }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Investment Amount:</span>
                            <span class="font-medium text-gray-900 dark:text-white" id="summaryAmount">{{ Auth::user()->currency }}{{ number_format($plan->min_amount, 2) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Return Rate:</span>
                            <span class="font-medium text-green-600 dark:text-green-500">{{ $plan->expected_return }}% / {{ $plan->return_interval }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Duration:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $plan->duration }} {{ Str::plural('Day', $plan->duration) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Total Return:</span>
                            <span class="font-medium text-green-600 dark:text-green-500" id="summaryReturn">{{ Auth::user()->currency }}0.00</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Maturity Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white" id="maturityDate">{{ now()->addDays($plan->duration)->format('M d, Y') }}</span>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between text-lg">
                                <span class="font-medium text-gray-900 dark:text-white">Final Amount:</span>
                                <span class="font-bold text-gray-900 dark:text-white" id="summaryFinal">{{ Auth::user()->currency }}0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Need Help Card -->
                <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-xl p-6 animate-fade-in stagger-item">
                    <h4 class="font-medium text-indigo-900 dark:text-indigo-300 mb-2">Need Help?</h4>
                    <p class="text-sm text-indigo-700 dark:text-indigo-400 mb-4">If you have any questions about this investment plan, our support team is available 24/7.</p>
                    <a href="{{ route('user.support') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Contact Support
                        <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
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
    const amountSlider = document.getElementById('amountSlider');
    const amountInput = document.getElementById('amount');
    const summaryAmount = document.getElementById('summaryAmount');
    const summaryReturn = document.getElementById('summaryReturn');
    const summaryFinal = document.getElementById('summaryFinal');
    const maturityDate = document.getElementById('maturityDate');

    const currency = "{{ Auth::user()->currency }}";
    const expectedReturn = {{ $plan->expected_return }};
    const duration = {{ $plan->duration }};
    const returnInterval = "{{ $plan->return_interval }}";

    // Function to calculate returns
    function calculateReturns(amount) {
        let intervalFactor;
        switch(returnInterval) {
            case 'daily':
                intervalFactor = duration;
                break;
            case 'weekly':
                intervalFactor = Math.floor(duration / 7);
                break;
            case 'monthly':
                intervalFactor = Math.floor(duration / 30);
                break;
            default:
                intervalFactor = 1;
        }

        const totalReturn = amount * (expectedReturn / 100) * intervalFactor;
        const finalAmount = parseFloat(amount) + parseFloat(totalReturn);

        return {
            totalReturn: totalReturn.toFixed(2),
            finalAmount: finalAmount.toFixed(2)
        };
    }

    // Function to update display
    function updateDisplay() {
        const amount = parseFloat(amountInput.value);
        const { totalReturn, finalAmount } = calculateReturns(amount);

        summaryAmount.textContent = `${currency}${amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        summaryReturn.textContent = `${currency}${parseFloat(totalReturn).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        summaryFinal.textContent = `${currency}${parseFloat(finalAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

        // Update maturity date
        const today = new Date();
        const futureDate = new Date(today.setDate(today.getDate() + duration));
        maturityDate.textContent = futureDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    // Event listeners
    amountSlider.addEventListener('input', function() {
        amountInput.value = this.value;
        updateDisplay();
    });

    amountInput.addEventListener('input', function() {
        // Ensure the value is within min and max
        const min = parseFloat(this.min);
        const max = parseFloat(this.max);
        const value = parseFloat(this.value);

        if (!isNaN(value)) {
            if (value < min) this.value = min;
            if (value > max) this.value = max;

            // Update slider position
            amountSlider.value = this.value;

            // Update summary
            updateDisplay();
        }
    });

    // Initialize display
    updateDisplay();
});
</script>
@endsection
