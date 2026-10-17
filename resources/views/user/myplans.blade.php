@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" x-data="myPlansManager()">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Investment Plans</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Track and manage your active investment portfolios</p>
            </div>

            <a href="{{ route('mplans') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Investment
            </a>
        </div>

        <!-- Alerts -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Filters and Statistics -->
        @if ($numOfPlan > 0)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
                <div class="p-6">
                    <!-- Statistics Row -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $numOfPlan }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Plans</div>
                        </div>

                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-green-600">{{ $plans->where('active', 'yes')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Active</div>
                        </div>

                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-red-600">{{ $plans->where('active', 'expired')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Expired</div>
                        </div>

                        <div class="text-center">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @php
                                $totalInvested = $plans->sum('amount');
                            @endphp
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalInvested) }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Invested</div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by status:</span>
                                <div class="relative">
                                    <select x-model="selectedFilter"
                                            @change="console.log('Filter changed to:', selectedFilter); updateFilter()"
                                            class="appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="All">All Plans</option>
                                        <option value="yes">Active Plans</option>
                                        <option value="expired">Expired Plans</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Showing {{ $plans->count() }} of {{ $plans->total() }} plans
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Investment Plans Grid -->
        <div class="space-y-6">
            @forelse ($plans as $plan)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <!-- Plan Info -->
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $plan->uplan->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 text-sm">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Investment Amount:</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->currency }}{{ number_format($plan->amount) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Expected ROI:</span>
                                            <span class="font-semibold text-green-600">{{ $plan->uplan->increment_amount	 }}%</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Expiration :</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $plan->expiration }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plan Details -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 lg:max-w-md">
                                <!-- Start Date -->
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $plan->created_at->format('M d') }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $plan->created_at->format('Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Start Date</div>
                                </div>

                                <!-- Arrow -->
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    <svg class="w-6 h-6 text-gray-400 sm:hidden rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>

                                <!-- End Date -->
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($plan->expire_date)->format('M d') }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($plan->expire_date)->format('Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">End Date</div>
                                </div>
                            </div>

                            <!-- Status and Actions -->
                            <div class="flex items-center gap-4">
                                <div class="text-center">
                                    @if ($plan->active == 'yes')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                            Active
                                        </span>
                                    @elseif($plan->active == 'expired')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                            Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                                            Inactive
                                        </span>
                                    @endif
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Status</div>
                                </div>

                                <a href="{{ route('plandetails', $plan->id) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-all duration-200">
                                    View Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Progress Bar (for active plans) -->
                        @if($plan->active == 'yes')
                            @php
                                $startDate = $plan->created_at;
                                $endDate = \Carbon\Carbon::parse($plan->expire_date);
                                $currentDate = now();
                                $totalDays = $startDate->diffInDays($endDate);
                                $elapsedDays = $startDate->diffInDays($currentDate);
                                $progress = $totalDays > 0 ? min(($elapsedDays / $totalDays) * 100, 100) : 0;
                                // Calculate remaining days - if end date is in the past, this will be 0
                                $remainingDays = $currentDate->lt($endDate) ? $currentDate->diffInDays($endDate) : 0;
                            @endphp
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Investment Progress</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $remainingDays }} days remaining</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-300"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    <span>{{ number_format($progress, 1) }}% complete</span>
                                    <span>{{ $totalDays }} total days</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Investment Plans Found</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8">
                            You don't have any investment plans at the moment or no plans match your current filter criteria.
                        </p>
                        <a href="{{ route('mplans') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Start Your First Investment
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (count($plans) > 0)
            <div class="mt-8 flex justify-center">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        // Make function available globally for Alpine.js
        window.myPlansManager = function() {
            return {
                selectedFilter: 'All',

                init() {
                    // Set initial filter value based on current URL if needed
                    const urlParts = window.location.pathname.split('/');
                    const currentFilter = urlParts[urlParts.length - 1];
                    console.log('Current URL parts:', urlParts);
                    console.log('Current filter from URL:', currentFilter);

                    if (['All', 'yes', 'expired'].includes(currentFilter)) {
                        this.selectedFilter = currentFilter;
                    } else if (urlParts[urlParts.length - 2] === 'myplans') {
                        // If we're on /dashboard/myplans without a sort parameter, default to 'All'
                        this.selectedFilter = 'All';
                    }
                    console.log('Alpine.js initialized with filter:', this.selectedFilter);
                },

                updateFilter() {
                    console.log('=== Filter Update Started ===');
                    console.log('Selected filter:', this.selectedFilter);
                    console.log('Current URL:', window.location.href);

                    const baseUrl = '{{ url("/dashboard/sort-plans") }}';
                    const targetUrl = `${baseUrl}/${this.selectedFilter}`;

                    console.log('Base URL:', baseUrl);
                    console.log('Target URL:', targetUrl);
                    console.log('=== Navigating to new URL ===');

                    // Add a small delay to see the console logs before navigation
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 100);
                }
            };
        }

        // Debug Alpine.js initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, Alpine.js should initialize soon');
            console.log('Current page URL:', window.location.href);
        });

        // Debug Alpine.js events
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized successfully');
        });
    </script>
@endsection
