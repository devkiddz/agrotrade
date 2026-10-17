@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-4 sm:py-8" x-data="{ showCodeInfo: false, selectedMethod: '' }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">Fund Withdrawals</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm sm:text-base">Securely withdraw your funds using various payment methods</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-white/80 hover:bg-white dark:bg-gray-800/80 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm text-sm sm:text-base">
                <i data-lucide="arrow-left" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                <span class="hidden sm:inline">Back to Dashboard</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-4 sm:mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs sm:text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                        <i data-lucide="home" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mx-1"></i>
                        <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Withdrawals</span>
                    </div>
                </li>
            </ol>
        </nav>

        @if(Auth::user()->withdrawal_code === 'on')
            <!-- Withdrawal Code Required Section -->
            <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 max-w-4xl mx-auto backdrop-blur-sm">
                <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                    <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                        <div class="p-3 sm:p-4 bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-xl backdrop-blur-sm">
                            <i data-lucide="shield-check" class="w-6 h-6 sm:w-8 sm:h-8 text-amber-400"></i>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">Security Verification Required</h2>
                            <p class="text-gray-300 mt-1 text-sm sm:text-base">Additional verification needed to process your withdrawal</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Enhanced Warning Message -->
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-l-4 border-amber-500 p-4 sm:p-6 mb-6 sm:mb-8 rounded-lg backdrop-blur-sm">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-shrink-0 mb-3 sm:mb-0">
                                <i data-lucide="info" class="h-5 w-5 sm:h-6 sm:w-6 text-amber-400" aria-hidden="true"></i>
                            </div>
                            <div class="sm:ml-4 flex-1">
                                <div class="text-sm sm:text-base font-medium text-amber-300 mb-2">
                                    Withdrawal Code Required
                                </div>
                                <p class="text-xs sm:text-sm text-amber-200 leading-relaxed">
                                    For your security, this withdrawal requires a verification code. Please contact our customer support team via live chat or email at
                                    <a href="mailto:{{$settings->contact_email}}" class="font-semibold underline hover:text-amber-100 transition-colors">{{$settings->contact_email}}</a>
                                    to obtain your withdrawal verification code.
                                </p>
                                <button @click="showCodeInfo = !showCodeInfo" class="mt-3 flex items-center text-xs sm:text-sm font-medium text-amber-300 hover:text-amber-200 transition-colors">
                                    <span x-text="showCodeInfo ? 'Hide security details' : 'Learn about withdrawal security'"></span>
                                    <i x-bind:data-lucide="showCodeInfo ? 'chevron-up' : 'chevron-down'" class="ml-1 w-3 h-3 sm:w-4 sm:h-4"></i>
                                </button>
                                <div x-show="showCodeInfo" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-3 p-3 sm:p-4 bg-amber-500/10 rounded-lg text-xs sm:text-sm text-amber-200" style="display: none;">
                                    <p class="font-medium mb-2">Why withdrawal codes are required:</p>
                                    <ul class="space-y-1 text-xs">
                                        <li>• Enhanced security to protect your account from unauthorized access</li>
                                        <li>• Verification that all withdrawal requests are legitimate and authorized</li>
                                        <li>• Additional layer of protection against fraudulent transactions</li>
                                        <li>• Compliance with financial security regulations and best practices</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Withdrawal Code Form -->
                    <div class="bg-gray-800/50 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                        <form action="{{ route('userwithdrawal') }}" method="post" class="space-y-4 sm:space-y-6">
                            @csrf
                            <div>
                                <label for="withdrawal_code" class="block text-sm font-semibold text-gray-200 mb-3">
                                    Enter Withdrawal Verification Code
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="shield-check" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="withdrawal_code"
                                           id="withdrawal_code"
                                           required
                                           placeholder="Enter your verification code here"
                                           class="pl-10 sm:pl-12 block w-full rounded-xl border-gray-600/50 bg-gray-800/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-white text-sm sm:text-base py-3 sm:py-4 transition-all duration-200 backdrop-blur-sm"
                                    />
                                </div>
                                <p class="mt-2 text-xs text-gray-400">This code was provided by our customer support team</p>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] text-sm sm:text-base">
                                <i data-lucide="check-circle" class="h-4 w-4 sm:h-5 sm:w-5"></i>
                                <span>Verify & Continue</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

@else
        <!-- Withdrawal Method Selection -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 max-w-4xl mx-auto mb-6 sm:mb-8 backdrop-blur-sm">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <div class="p-3 sm:p-4 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-xl backdrop-blur-sm">
                        <i data-lucide="credit-card" class="w-6 h-6 sm:w-8 sm:h-8 text-blue-400"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Select Withdrawal Method</h2>
                        <p class="text-gray-300 mt-1 text-sm sm:text-base">Choose your preferred payment method for receiving funds</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <form method="POST" action="{{ route('withdrawamount') }}" class="space-y-6 sm:space-y-8">
                    @csrf

                    <!-- Enhanced Withdrawal Method Selector -->
                    <div>
                        <label for="method" class="block text-sm font-semibold text-gray-200 mb-3 sm:mb-4">
                            Payment Method
                        </label>
                        <div class="relative">
                            <select
                                name="method"
                                id="method"
                                required
                                x-model="selectedMethod"
                                class="appearance-none block w-full pl-4 pr-12 py-3 sm:py-4 border border-gray-600/50 bg-gray-800/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white text-sm sm:text-base transition-all duration-200 backdrop-blur-sm"
                            >
                                <option value="" disabled selected>Choose a withdrawal method</option>
                                @forelse ($wmethods as $method)
                                    <option value="{{$method->name}}">{{$method->name}}</option>
                                @empty
                                    <option value="" disabled>No withdrawal methods available</option>
                                @endforelse
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i data-lucide="chevron-down" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Method Details Card -->
                    <div x-show="selectedMethod" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-xl p-4 sm:p-6 border border-blue-500/30 backdrop-blur-sm" style="display: none;">
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <!-- Enhanced Dynamic icon based on method -->
                            <div class="p-3 rounded-xl shadow-sm mx-auto sm:mx-0" :class="{
                                'bg-orange-500/20': selectedMethod === 'Bitcoin',
                                'bg-blue-500/20': selectedMethod === 'Ethereum',
                                'bg-green-500/20': selectedMethod === 'Bank Transfer',
                                'bg-blue-500/20': selectedMethod === 'USDT',
                                'bg-gray-500/20': !['Bitcoin', 'Ethereum', 'Bank Transfer', 'USDT'].includes(selectedMethod)
                            }">
                                <i :data-lucide="selectedMethod === 'Bitcoin' ? 'bitcoin' : (selectedMethod === 'Ethereum' ? 'zap' : (selectedMethod === 'Bank Transfer' ? 'building-bank' : (selectedMethod === 'USDT' ? 'circle-dollar-sign' : 'credit-card')))" class="w-5 h-5 sm:w-6 sm:h-6" :class="{
                                    'text-orange-400': selectedMethod === 'Bitcoin',
                                    'text-blue-400': selectedMethod === 'Ethereum',
                                    'text-green-400': selectedMethod === 'Bank Transfer',
                                    'text-blue-400': selectedMethod === 'USDT',
                                    'text-gray-400': !['Bitcoin', 'Ethereum', 'Bank Transfer', 'USDT'].includes(selectedMethod)
                                }"></i>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="font-semibold text-white text-base sm:text-lg" x-text="selectedMethod + ' Withdrawal'"></h3>
                                <p class="text-xs sm:text-sm text-gray-300 mt-1" x-text="'You have selected ' + selectedMethod + ' as your preferred withdrawal method.'"></p>
                                <div class="mt-3 flex items-center justify-center sm:justify-start gap-2 text-xs text-blue-400">
                                    <i data-lucide="shield-check" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                                    <span>Secure & encrypted transaction</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 sm:gap-3 py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] text-sm sm:text-base">
                        <i data-lucide="arrow-right" class="h-4 w-4 sm:h-5 sm:w-5"></i>
                        <span>Proceed to Withdrawal</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Enhanced Withdrawal History -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 max-w-6xl mx-auto backdrop-blur-sm">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <div class="p-3 sm:p-4 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 rounded-xl backdrop-blur-sm">
                        <i data-lucide="history" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-400"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Withdrawal History</h2>
                        <p class="text-gray-300 mt-1 text-sm sm:text-base">Monitor the status and details of your withdrawal requests</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <div class="overflow-hidden rounded-xl border border-gray-700/50 shadow-sm backdrop-blur-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-800/50 to-gray-700/50">
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider hidden sm:table-cell">Method</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-900/50 divide-y divide-gray-700/50">
                                @forelse ($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-800/30 transition-all duration-200">
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-1.5 sm:p-2 bg-gray-800/50 rounded-lg mr-2 sm:mr-3 hidden sm:block">
                                                    <i data-lucide="banknote" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm sm:text-base font-semibold text-white">{{Auth::user()->currency}}{{ number_format($withdrawal->amount, 2, '.', ',') }}</div>
                                                    <div class="text-xs text-gray-400 hidden sm:block">Withdrawal Amount</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            <div class="text-xs sm:text-sm text-white font-medium">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('H:i A') }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap hidden sm:table-cell">
                                            <div class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                                <i data-lucide="{{ $withdrawal->payment_mode == 'Bitcoin' ? 'bitcoin' : ($withdrawal->payment_mode == 'Ethereum' ? 'zap' : ($withdrawal->payment_mode == 'USDT' ? 'circle-dollar-sign' : 'building-bank')) }}" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                                {{ $withdrawal->payment_mode }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            @if($withdrawal->status=='Pending')
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                                                    <i data-lucide="clock" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                                    <span class="hidden sm:inline">{{ $withdrawal->status }}</span>
                                                    <span class="sm:hidden">Pending</span>
                                                </span>
                                            @elseif($withdrawal->status=='Rejected')
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-red-500/20 text-red-300 border border-red-500/30">
                                                    <i data-lucide="x-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                                    <span class="hidden sm:inline">{{ $withdrawal->status }}</span>
                                                    <span class="sm:hidden">Rejected</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-green-500/20 text-green-300 border border-green-500/30">
                                                    <i data-lucide="check-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                                    <span class="hidden sm:inline">{{ $withdrawal->status }}</span>
                                                    <span class="sm:hidden">Complete</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-3 sm:p-4 bg-gray-800/50 rounded-full mb-3 sm:mb-4">
                                                    <i data-lucide="inbox" class="w-6 h-6 sm:w-8 sm:h-8 text-gray-500"></i>
                                                </div>
                                                <h3 class="text-base sm:text-lg font-medium text-white mb-1">No withdrawals yet</h3>
                                                <p class="text-sm text-gray-400">Your withdrawal history will appear here once you make your first request</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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
