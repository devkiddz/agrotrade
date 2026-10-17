@extends('layouts.dasht')
@section('title', 'My Investment Plans')

@section('styles')
@parent
<style>
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

    .investment-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .investment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Staggered animation for cards */
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
    .stagger-item:nth-child(6) { animation-delay: 0.6s; }
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">My Investments</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title with Action -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">My Investment Plans</h1>
                <p class="text-gray-600 dark:text-gray-300">Track the performance of your investment portfolio</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('user.plans.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Invest in New Plan
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Investment Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Invested</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">{{ Auth::user()->currency }}{{ number_format($stats['total_invested'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Profit</p>
                    <p class="text-xl font-bold text-green-600 dark:text-green-500">{{ Auth::user()->currency }}{{ number_format($stats['total_profit'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Plans</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $stats['active'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-fade-in stagger-item">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Plans</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $stats['active'] + $stats['completed'] + $stats['pending'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6 overflow-x-auto">
        <div class="flex space-x-6">
            <a href="{{ route('user.plans.my', ['status' => 'all']) }}" class="py-3 px-1 border-b-2 {{ $status === 'all' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap font-medium text-sm">
                All Plans
            </a>
            <a href="{{ route('user.plans.my', ['status' => 'active']) }}" class="py-3 px-1 border-b-2 {{ $status === 'active' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap font-medium text-sm">
                Active
                @if($stats['active'] > 0)
                <span class="ml-1 px-2 py-0.5 bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400 rounded-full text-xs">{{ $stats['active'] }}</span>
                @endif
            </a>
            <a href="{{ route('user.plans.my', ['status' => 'pending']) }}" class="py-3 px-1 border-b-2 {{ $status === 'pending' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap font-medium text-sm">
                Pending
                @if($stats['pending'] > 0)
                <span class="ml-1 px-2 py-0.5 bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400 rounded-full text-xs">{{ $stats['pending'] }}</span>
                @endif
            </a>
            <a href="{{ route('user.plans.my', ['status' => 'completed']) }}" class="py-3 px-1 border-b-2 {{ $status === 'completed' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap font-medium text-sm">
                Completed
                @if($stats['completed'] > 0)
                <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400 rounded-full text-xs">{{ $stats['completed'] }}</span>
                @endif
            </a>
            <a href="{{ route('user.plans.my', ['status' => 'cancelled']) }}" class="py-3 px-1 border-b-2 {{ $status === 'cancelled' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap font-medium text-sm">
                Cancelled
            </a>
        </div>
    </div>

    <!-- Investment Plans List -->
    <div class="space-y-6">
        @forelse($userPlans as $index => $userPlan)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden investment-card animate-fade-in stagger-item">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-start">
                        <!-- Status Badge -->
                        <span class="status-badge status-{{ $userPlan->status }} mr-4">
                            {{ ucfirst($userPlan->status) }}
                        </span>

                        <!-- Plan Name -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $userPlan->plan->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Invested on {{ $userPlan->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Amount Info -->
                    <div class="mt-4 md:mt-0 text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Invested Amount</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount, 2) }}
                        </div>
                    </div>
                </div>

                <!-- Progress Section -->
                @if($userPlan->status === 'active')
                <div class="mt-6">
                    <div class="flex justify-between text-xs mb-2">
                        <span class="text-gray-500 dark:text-gray-400">Progress</span>
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $userPlan->getProgressPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $userPlan->getProgressPercentage() }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs mt-2">
                        <span class="text-gray-500 dark:text-gray-400">Started: {{ $userPlan->activated_at->format('M d, Y') }}</span>
                        <span class="text-gray-500 dark:text-gray-400">Ends: {{ $userPlan->expires_at->format('M d, Y') }}</span>
                    </div>
                </div>
                @endif

                <!-- ROI & Actions -->
                <div class="flex flex-col sm:flex-row justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex space-x-6">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Current Value</span>
                            <div class="text-lg font-bold {{ $userPlan->current_value > $userPlan->invested_amount ? 'text-green-600 dark:text-green-500' : 'text-gray-900 dark:text-white' }}">
                                {{ Auth::user()->currency }}{{ number_format($userPlan->current_value, 2) }}
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Profit</span>
                            <div class="text-lg font-bold {{ $userPlan->total_profit > 0 ? 'text-green-600 dark:text-green-500' : 'text-gray-900 dark:text-white' }}">
                                {{ Auth::user()->currency }}{{ number_format($userPlan->total_profit, 2) }}
                            </div>
                        </div>

                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">ROI</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $userPlan->roi_percentage }}%
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-0 space-x-2">
                        @if($userPlan->status === 'pending')
                        <a href="{{ route('user.plans.payment', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Complete Payment
                        </a>
                        <a href="{{ route('user.plans.cancel', $userPlan->id) }}" onclick="return confirm('Are you sure you want to cancel this plan?')" class="inline-flex items-center px-4 py-2 border border-red-500 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 text-sm rounded-lg transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        @else
                        <a href="{{ route('user.plans.details', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Details
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 16h.01M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-2">No Investment Plans Found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">You don't have any {{ $status !== 'all' ? $status : '' }} investment plans yet.</p>
            <a href="{{ route('user.plans.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Browse Investment Plans
            </a>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($userPlans->total() > 0)
        <div class="mt-6">
            {{ $userPlans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
