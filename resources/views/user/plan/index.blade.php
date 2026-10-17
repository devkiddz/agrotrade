@extends('layouts.dasht')
@section('title', 'Investment Plans')

@section('styles')
@parent
<style>
    .plan-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(226, 232, 240, 1);
    }

    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .plan-card.featured {
        border: 1px solid rgba(79, 70, 229, 0.5);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1), 0 4px 6px -2px rgba(79, 70, 229, 0.05);
    }

    .category-pill {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .category-pill:hover {
        background-color: rgba(79, 70, 229, 0.1);
    }

    .category-pill.active {
        background-color: rgba(79, 70, 229, 1);
        color: white;
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

    .stagger-item {
        opacity: 0;
    }

    .stagger-item:nth-child(1) { animation-delay: 0.1s; }
    .stagger-item:nth-child(2) { animation-delay: 0.2s; }
    .stagger-item:nth-child(3) { animation-delay: 0.3s; }
    .stagger-item:nth-child(4) { animation-delay: 0.4s; }
    .stagger-item:nth-child(5) { animation-delay: 0.5s; }
    .stagger-item:nth-child(6) { animation-delay: 0.6s; }
    .stagger-item:nth-child(7) { animation-delay: 0.7s; }
    .stagger-item:nth-child(8) { animation-delay: 0.8s; }
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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Investment Plans</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title with Animation -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between animate-fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Investment Plans</h1>
                <p class="text-gray-600 dark:text-gray-300">Upgrade your account with our high-yield investment opportunities</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('user.plans.my') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    My Investments
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Categories Filter -->
    @if(count($categories) > 0)
    <div class="mb-8 overflow-x-auto">
        <div class="inline-flex items-center space-x-2 pb-2">
            <a href="{{ route('user.plans.index') }}" class="category-pill px-4 py-2 rounded-full text-sm font-medium {{ $categoryId === null ? 'active' : 'text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800' }}">
                All Plans
            </a>

            @foreach($categories as $category)
            <a href="{{ route('user.plans.index', ['category' => $category->id]) }}" class="category-pill px-4 py-2 rounded-full text-sm font-medium {{ $categoryId == $category->id ? 'active' : 'text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800' }}">
                {{ $category->name }}
                <span class="ml-1 text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5">{{ $category->plans_count }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $index => $plan)
        <div class="stagger-item animate-fade-in plan-card rounded-xl overflow-hidden {{ $plan->featured ? 'featured' : '' }} bg-white dark:bg-gray-800">
            <!-- Plan Header -->
            <div class="relative">
                <div class="p-6 {{ $plan->featured ? 'bg-gradient-to-r from-indigo-600 to-purple-600' : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800' }}">
                    @if($plan->badge_text)
                    <span class="absolute top-4 right-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $plan->featured ? 'bg-white text-indigo-600' : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' }}">
                        {{ $plan->badge_text }}
                    </span>
                    @endif

                    <h3 class="text-2xl font-bold mb-2 {{ $plan->featured ? 'text-white' : 'text-gray-800 dark:text-white' }}">{{ $plan->name }}</h3>

                    <div class="flex items-baseline mb-4">
                        <span class="text-3xl font-extrabold {{ $plan->featured ? 'text-white' : 'text-gray-900 dark:text-white' }}">
                            {{ Auth::user()->currency }}{{ number_format($plan->min_price, 2) }}
                        </span>
                        <span class="ml-2 {{ $plan->featured ? 'text-indigo-100' : 'text-gray-500 dark:text-gray-400' }}">
                            min investment
                        </span>
                    </div>

                    <div class="{{ $plan->featured ? 'text-white' : 'text-gray-700 dark:text-gray-300' }}">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>{{ $plan->min_return }}% - {{ $plan->max_return }}% ROI</span>
                        </div>
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $plan->duration }} {{ Str::plural($plan->duration_type, $plan->duration) }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ ucfirst($plan->payout_interval) }} payouts</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Features -->
            <div class="p-6">
                @if($plan->description)
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $plan->description }}</p>
                @endif

                <ul class="space-y-3 mb-6">
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

                <a href="{{ route('user.plans.show', $plan->id) }}" class="block w-full text-center py-3 px-4 rounded-lg {{ $plan->featured ? 'bg-indigo-600 hover:bg-indigo-700 text-white' : 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white' }} font-medium transition-colors duration-300">
                    View Details
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full p-8 text-center border rounded-xl bg-white dark:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 16h.01M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-2">No Investment Plans Available</h3>
            <p class="text-gray-500 dark:text-gray-400">There are currently no investment plans available in this category.</p>
        </div>
        @endforelse
    </div>

    <!-- Why Choose Us Section -->
    <div class="mt-16">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Why Choose Our Investment Plans?</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Our investment plans are designed to provide maximum returns with minimal risk. Here's why thousands of investors trust us.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Safe & Secure</h3>
                <p class="text-gray-600 dark:text-gray-400">Your investments are secured and protected by the latest security measures. We prioritize the safety of your funds.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">High Returns</h3>
                <p class="text-gray-600 dark:text-gray-400">Our investment plans offer competitive returns compared to traditional investment options, helping you grow your wealth faster.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Fast Payouts</h3>
                <p class="text-gray-600 dark:text-gray-400">Regular payouts directly to your account with no delays. We ensure you receive your returns on time, every time.</p>
            </div>
        </div>
    </div>
</div>
@endsection
