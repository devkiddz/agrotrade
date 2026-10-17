@extends('layouts.dasht')
@section('title', $plan->name)

@section('styles')
@parent
<style>
    .progress-ring {
        transform: rotate(-90deg);
    }

    .plan-features li:before {
        content: "✓";
        color: #4f46e5;
        margin-right: 0.5rem;
        font-weight: bold;
    }

    .plan-details-card {
        transition: all 0.3s ease;
    }

    .plan-details-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Animation for fade in */
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
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

    .animate-fade-in-delay-1 {
        animation-delay: 0.1s;
    }

    .animate-fade-in-delay-2 {
        animation-delay: 0.2s;
    }

    .animate-fade-in-delay-3 {
        animation-delay: 0.3s;
    }

    /* ROI Calculator styles */
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #4f46e5;
    }

    input[type="range"]::-moz-range-thumb {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #4f46e5;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
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
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $plan->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Plan Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl p-8 mb-8 animate-fade-in shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                @if($plan->badge_text)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-indigo-800 mb-3">
                    {{ $plan->badge_text }}
                </span>
                @endif
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $plan->name }}</h1>
                @if($plan->description)
                <p class="text-indigo-100 text-lg mb-4">{{ $plan->description }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <div class="inline-flex items-center px-3 py-1 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>{{ $plan->min_return }}% - {{ $plan->max_return }}% ROI</span>
                    </div>
                    <div class="inline-flex items-center px-3 py-1 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $plan->duration }} {{ Str::plural($plan->duration_type, $plan->duration) }}</span>
                    </div>
                    <div class="inline-flex items-center px-3 py-1 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ ucfirst($plan->payout_interval) }} payouts</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Plan Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Plan Investment Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden animate-fade-in">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Plan Investment Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Investment Range</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ Auth::user()->currency }}{{ number_format($plan->min_price, 2) }} - {{ Auth::user()->currency }}{{ number_format($plan->max_price, 2) }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ROI Range</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $plan->min_return }}% - {{ $plan->max_return }}%
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Duration</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $plan->duration }} {{ Str::plural($plan->duration_type, $plan->duration) }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Payout Frequency</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ ucfirst($plan->payout_interval) }}
                            </p>
                        </div>

                        @if($plan->allow_compounding)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Compounding</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Available
                                @if($plan->compounding_percentage)
                                (Up to {{ $plan->compounding_percentage }}%)
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($plan->bonus_percentage > 0)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Bonus</h3>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-500">
                                {{ $plan->bonus_percentage }}% on investment
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Plan Features -->
            @if(count($plan->planFeatures) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden animate-fade-in animate-fade-in-delay-1">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Plan Features</h2>
                </div>
                <div class="p-6">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($plan->planFeatures as $feature)
                        <li class="flex items-start">
                            @if($feature->included)
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            @endif
                            <span class="text-gray-700 dark:text-gray-300">{{ $feature->feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Expected Returns Examples -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden animate-fade-in animate-fade-in-delay-2">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Example Returns</h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Investment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Return</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Net Profit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ROI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($examples as $example)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                        {{ Auth::user()->currency }}{{ number_format($example['investment'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                        {{ Auth::user()->currency }}{{ number_format($example['return'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600 dark:text-green-500 font-medium">
                                        +{{ Auth::user()->currency }}{{ number_format($example['profit'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                        {{ number_format(($example['profit'] / $example['investment']) * 100, 2) }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Investment Form -->
        <div class="lg:col-span-1 animate-fade-in animate-fade-in-delay-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-24">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Invest in this Plan</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('user.plans.purchase') }}" method="POST" id="purchaseForm">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                        <!-- Investment Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Investment Amount ({{ Auth::user()->currency }})
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}</span>
                                </div>
                                <input type="number" id="amount" name="amount"
                                    min="{{ $plan->min_price }}" max="{{ $plan->max_price }}" step="0.01"
                                    value="{{ $plan->min_price }}"
                                    class="pl-9 block w-full rounded-lg border border-gray-300 dark:border-gray-600 py-2.5 px-4 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                    required
                                >
                            </div>
                            <div class="flex justify-between mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <span>Min: {{ Auth::user()->currency }}{{ number_format($plan->min_price, 2) }}</span>
                                <span>Max: {{ Auth::user()->currency }}{{ number_format($plan->max_price, 2) }}</span>
                            </div>
                        </div>

                        <!-- Compounding Options (if available) -->
                        @if($plan->allow_compounding)
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <label for="compounding" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable Compounding
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="compounding" name="compounding" value="1" class="sr-only peer">
                                    <div class="relative w-10 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 dark:peer-focus:ring-indigo-600 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div id="compoundingOptions" class="hidden p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-2">
                                <label for="compounding_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Compounding Percentage (%)
                                </label>
                                <input type="range" id="compounding_percentage" name="compounding_percentage"
                                    min="10" max="{{ $plan->compounding_percentage ?? 100 }}" step="10" value="50"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                >
                                <div class="flex justify-between mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    <span>10%</span>
                                    <span id="compoundingValue">50%</span>
                                    <span>{{ $plan->compounding_percentage ?? 100 }}%</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Method
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label for="payment_method_balance" class="cursor-pointer">
                                    <input type="radio" id="payment_method_balance" name="payment_method" value="balance" class="hidden peer" checked>
                                    <div class="flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <span>Balance</span>
                                    </div>
                                </label>

                                <label for="payment_method_bitcoin" class="cursor-pointer">
                                    <input type="radio" id="payment_method_bitcoin" name="payment_method" value="bitcoin" class="hidden peer">
                                    <div class="flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Bitcoin</span>
                                    </div>
                                </label>

                                <label for="payment_method_ethereum" class="cursor-pointer">
                                    <input type="radio" id="payment_method_ethereum" name="payment_method" value="ethereum" class="hidden peer">
                                    <div class="flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Ethereum</span>
                                    </div>
                                </label>

                                <label for="payment_method_bank_transfer" class="cursor-pointer">
                                    <input type="radio" id="payment_method_bank_transfer" name="payment_method" value="bank_transfer" class="hidden peer">
                                    <div class="flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        </svg>
                                        <span>Bank</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Account Balance -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
                            <div>
                                <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Your Balance</span>
                                <span class="text-lg font-bold text-gray-800 dark:text-white">{{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2) }}</span>
                            </div>
                            <a href="{{ route('deposit') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">
                                Add Funds
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="invest-btn" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Invest Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Compounding toggle
        const compoundingCheckbox = document.getElementById('compounding');
        const compoundingOptions = document.getElementById('compoundingOptions');
        const compoundingSlider = document.getElementById('compounding_percentage');
        const compoundingValue = document.getElementById('compoundingValue');

        if (compoundingCheckbox && compoundingOptions) {
            compoundingCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    compoundingOptions.classList.remove('hidden');
                } else {
                    compoundingOptions.classList.add('hidden');
                }
            });

            if (compoundingSlider && compoundingValue) {
                compoundingSlider.addEventListener('input', function() {
                    compoundingValue.textContent = this.value + '%';
                });
            }
        }
    });
</script>
@endsection
