@extends('layouts.dasht')
@section('title', 'Investment Plan Details')

@section('styles')
@parent
<style>
    .detail-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .status-badge {
        @apply px-3 py-1 text-xs font-medium rounded-full;
    }

    .status-active {
        @apply bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300;
    }

    .status-pending {
        @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300;
    }

    .status-completed {
        @apply bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300;
    }

    .status-cancelled {
        @apply bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300;
    }

    /* Chart styles */
    .chart-container {
        height: 300px;
        width: 100%;
        position: relative;
    }

    /* Payout table styles */
    .payout-row {
        transition: background-color 0.2s;
    }
    .payout-row:hover {
        @apply bg-gray-50 dark:bg-gray-700/50;
    }

    /* Animation for the cards */
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
    <!-- Header with Breadcrumbs -->
    <div class="mb-8">
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
                        <a href="{{ route('user.plans.my') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">My Investments</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $userPlan->plan->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Investment Plan Details</h1>
                <p class="text-gray-600 dark:text-gray-300">Track the performance of your investment</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('user.plans.my') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Investments
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Plan Summary Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 animate-fade-in stagger-item">
        <div class="p-6">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                <!-- Left Section: Plan Details -->
                <div class="lg:max-w-lg">
                    <div class="flex items-center mb-4">
                        <span class="status-badge status-{{ $userPlan->status }} mr-4">
                            {{ ucfirst($userPlan->status) }}
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $userPlan->plan->name }}</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Invested Amount</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Current Value</p>
                            <p class="text-xl font-bold {{ $userPlan->current_value > $userPlan->invested_amount ? 'text-green-600 dark:text-green-500' : 'text-gray-900 dark:text-white' }}">
                                {{ Auth::user()->currency }}{{ number_format($userPlan->current_value, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Return Rate</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $userPlan->plan->expected_return }}% <span class="text-sm font-normal">/ {{ $userPlan->plan->return_interval }}</span></p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Profit</p>
                            <p class="text-xl font-bold {{ $userPlan->total_profit > 0 ? 'text-green-600 dark:text-green-500' : 'text-gray-900 dark:text-white' }}">
                                {{ Auth::user()->currency }}{{ number_format($userPlan->total_profit, 2) }}
                                <span class="text-sm font-normal">({{ $userPlan->roi_percentage }}% ROI)</span>
                            </p>
                        </div>
                    </div>

                    <!-- Duration Info -->
                    @if($userPlan->status === 'active')
                    <div class="mt-6">
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-gray-500 dark:text-gray-400">Progress</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $userPlan->getProgressPercentage() }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $userPlan->getProgressPercentage() }}%"></div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Started On</p>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $userPlan->activated_at->format('M d, Y') }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $userPlan->plan->duration }} {{ Str::plural('Day', $userPlan->plan->duration) }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Ends On</p>
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $userPlan->expires_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Section: Value Chart -->
                <div class="mt-6 lg:mt-0 lg:ml-10 lg:flex-1">
                    <div class="chart-container">
                        <canvas id="valueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                @if($userPlan->status === 'pending')
                <a href="{{ route('user.plans.payment', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Complete Payment
                </a>
                <a href="{{ route('user.plans.cancel', $userPlan->id) }}" onclick="return confirm('Are you sure you want to cancel this plan?')" class="inline-flex items-center px-4 py-2 border border-red-500 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                @elseif($userPlan->status === 'active')
                <a href="{{ route('user.plans.reinvest', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reinvest Profits
                </a>
                <a href="{{ route('user.plans.compound', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Compound Interest
                </a>
                <a href="{{ route('user.plans.withdraw', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    Withdraw Profits
                </a>
                @endif

                <a href="{{ route('user.plans.contract', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    View Contract
                </a>

                <a href="#" onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-sm rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Details
                </a>
            </div>
        </div>
    </div>

    <!-- Plan Features and Information -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Plan Features Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden detail-card animate-fade-in stagger-item md:col-span-2">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Plan Features</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($userPlan->plan->features as $feature)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="ml-3 text-base text-gray-700 dark:text-gray-300">{{ $feature->description }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Plan Description -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">About This Plan</h4>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $userPlan->plan->description !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk Level & Category Info -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden detail-card animate-fade-in stagger-item">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Investment Information</h3>

                <!-- Risk Level -->
                <div class="mb-6">
                    <h4 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Risk Level</h4>
                    <div class="flex items-center">
                        @php
                            $riskLevel = $userPlan->plan->risk_level;
                            $riskColor = $riskLevel <= 2 ? 'green' : ($riskLevel <= 3 ? 'yellow' : 'red');
                        @endphp

                        <div class="flex-1">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-{{ $riskColor }}-500 h-2.5 rounded-full" style="width: {{ $riskLevel * 20 }}%"></div>
                            </div>
                        </div>
                        <span class="ml-3 text-{{ $riskColor }}-600 dark:text-{{ $riskColor }}-400 font-medium">
                            @if($riskLevel <= 2)
                                Low
                            @elseif($riskLevel <= 3)
                                Medium
                            @else
                                High
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Investment Category -->
                <div class="mb-6">
                    <h4 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Category</h4>
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                            @if($userPlan->plan->category->slug === 'crypto')
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-6h2v2h-2v-2zm0-8h2v6h-2V6z"/>
                            </svg>
                            @elseif($userPlan->plan->category->slug === 'stocks')
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                            @elseif($userPlan->plan->category->slug === 'real-estate')
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            @else
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $userPlan->plan->category->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $userPlan->plan->category->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Plan Details List -->
                <div>
                    <h4 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Plan Details</h4>
                    <ul class="space-y-3">
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Min Investment</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->currency }}{{ number_format($userPlan->plan->min_amount, 2) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Max Investment</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ Auth::user()->currency }}{{ number_format($userPlan->plan->max_amount, 2) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Return Period</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ ucfirst($userPlan->plan->return_interval) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Return</span>
                            <span class="text-green-600 dark:text-green-500 font-medium">{{ $userPlan->plan->total_return }}%</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Duration</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ $userPlan->plan->duration }} {{ Str::plural('Day', $userPlan->plan->duration) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Referral Bonus</span>
                            <span class="text-gray-900 dark:text-white font-medium">{{ $userPlan->plan->referral_bonus }}%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Earning History -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 animate-fade-in stagger-item">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Earning History</h3>

            @if(count($payouts) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($payouts as $payout)
                        <tr class="payout-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $payout->created_at->format('M d, Y - h:ia') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-green-600 dark:text-green-500">{{ Auth::user()->currency }}{{ number_format($payout->amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($payout->payout_type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($payouts->hasPages())
            <div class="mt-6">
                {{ $payouts->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
                </svg>
                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No Earnings Yet</h4>
                <p class="text-gray-500 dark:text-gray-400">You haven't received any payouts for this investment yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('valueChart').getContext('2d');

    // Chart data
    const chartData = @json($chartData);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Investment Value',
                data: chartData.values,
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '{{ Auth::user()->currency }}' + new Intl.NumberFormat().format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return '{{ Auth::user()->currency }}' + new Intl.NumberFormat().format(value);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
