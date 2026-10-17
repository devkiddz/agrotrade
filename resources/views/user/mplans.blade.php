@extends('layouts.dasht')
@section('title', $title)
@section('content')
<!-- Main Content Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Investment Plans</h1>
                <p class="text-gray-600 dark:text-gray-300">Upgrade your account with our high-yield investment opportunities</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Grow Your Portfolio
                </span>
            </div>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Plans Grid -->
    <div x-data="{ selectedPlan: null }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse ($plans as $index => $plan)
            <!-- Plan Card -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700"
                 :class="{'ring-4 ring-blue-500 dark:ring-blue-600': selectedPlan === {{ $index }}}">
                
                <!-- ROI Badge -->
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                        </svg>
                        {{$plan->increment_amount}}% ROI
                    </span>
                </div>
                
                <!-- Card Header with Gradient -->
                <div class="pt-8 px-6 pb-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{$plan->name}}</h3>
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-1 w-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full"></div>
                    </div>
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{Auth::user()->currency}}{{number_format($plan->min_price)}}
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">minimum</span>
                    </div>
                </div>
                
                <!-- Plan Features -->
                <div class="p-6">
                    <ul class="space-y-4">
                        <!-- Minimum Amount -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Min Investment:</span> 
                                    <span class="text-gray-900 dark:text-white">{{Auth::user()->currency}}{{number_format($plan->min_price)}}</span>
                                </p>
                            </div>
                        </li>
                        
                        <!-- Maximum Amount -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Max Investment:</span> 
                                    <span class="text-gray-900 dark:text-white">{{Auth::user()->currency}}{{number_format($plan->max_price)}}</span>
                                </p>
                            </div>
                        </li>
                        
                        <!-- ROI Details -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Return Rate:</span> 
                                    <span class="text-green-600 dark:text-green-400">{{$plan->increment_amount}}% {{$plan->increment_interval}}</span>
                                </p>
                            </div>
                        </li>
                        
                        <!-- Duration -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Duration:</span> 
                                    <span class="text-gray-900 dark:text-white">{{$plan->expiration}}</span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- Investment Form -->
                    <form method="post" action="{{route('joininvestmentplan')}}" class="mt-6">
                        @csrf
                        <div x-data="{ amount: '{{$plan->min_price}}' }" class="space-y-4">
                            <!-- Amount Input with Animation -->
                            <div>
                                <label for="amount-{{$index}}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Investment Amount ({{Auth::user()->currency}})
                                </label>
                                
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">{{Auth::user()->currency}}</span>
                                    </span>
                                    <input 
                                        type="number" 
                                        id="amount-{{$index}}"
                                        name="iamount" 
                                        min="{{$plan->min_price}}" 
                                        max="{{$plan->max_price}}" 
                                        x-model="amount"
                                        placeholder="Enter amount" 
                                        class="pl-8 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 transition-colors duration-200"
                                        @click="selectedPlan = {{$index}}"
                                    >
                                </div>
                                
                                <!-- Range Input -->
                                <div class="mt-4 px-1">
                                    <input 
                                        type="range" 
                                        min="{{$plan->min_price}}" 
                                        max="{{$plan->max_price}}" 
                                        x-model="amount"
                                        class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-600 dark:accent-blue-500"
                                    >
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>Min: {{Auth::user()->currency}}{{number_format($plan->min_price)}}</span>
                                        <span>Max: {{Auth::user()->currency}}{{number_format($plan->max_price)}}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Potential Return: 
                                        <span class="text-green-600 dark:text-green-400 font-medium">
                                            {{Auth::user()->currency}}<span x-text="(amount * {{$plan->increment_amount}} / 100).toFixed(2)"></span>
                                        </span>
                                        <span x-text="' ' + '{{$plan->increment_interval}}'"></span>
                                    </p>
                                </div>
                            </div>
                            
                            <input type="hidden" name="duration" value="{{$plan->expiration}}">
                            <input type="hidden" name="id" value="{{ $plan->id }}">
                            
                            <!-- Submit Button with Animation -->
                            <button 
                                type="submit" 
                                class="w-full relative py-3 px-6 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900"
                                @mouseenter="selectedPlan = {{$index}}"
                            >
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    Join Investment Plan
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <!-- Empty State with Animation -->
            <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">No Investment Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center max-w-md mb-6">
                    Investment plans are currently being updated. Please check back later for new investment opportunities.
                </p>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Dashboard
                </a>
            </div>
        @endforelse
    </div>

    <!-- Investment Guide Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Investment Guide
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Choose your plan</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Select an investment plan that matches your financial goals and risk tolerance.</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Invest securely</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Your funds are securely managed with state-of-the-art investment strategies.</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Earn returns</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Watch your investment grow with competitive returns deposited directly to your account.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for No Plans -->
<div id="withdrawdisabled" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="noPlansModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-2" id="noPlansModalTitle">No Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                    There are currently no investment plans available. Please check back later.
                </p>
                <div class="flex justify-center">
                    <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js Initialization -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('plans', () => ({
            init() {
                // Any initialization code can go here
            }
        }))
    })
</script>
@endsection
