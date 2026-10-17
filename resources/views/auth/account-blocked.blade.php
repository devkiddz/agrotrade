@extends('layouts.guest1')
@section('title', 'Account Temporarily Locked')
@section('content')

<div class="min-h-screen bg-gray-900 relative overflow-hidden flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl">
        <!-- Account Blocked Card -->
        <div class="relative bg-gray-900 border border-red-500/30 rounded-3xl p-8 sm:p-12 shadow-2xl">
            <!-- Glow Effect -->
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-red-500/10 to-orange-500/10 blur-xl"></div>

            <div class="relative text-center">
                <!-- Lock Icon -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full bg-red-500/20 blur-lg"></div>
                        <div class="relative bg-gray-800 border border-red-500/30 rounded-full p-6">
                            <svg class="h-16 w-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                    Your Account Has Been
                </h1>
                <h2 class="text-2xl sm:text-3xl font-bold text-red-400 mb-6">
                    Temporarily Locked
                </h2>

                <!-- Message -->
                <div class="bg-gray-800/50 border border-red-500/20 rounded-2xl p-6 mb-8">
                    <p class="text-gray-300 text-lg leading-relaxed">
                        @if(session('user_name'))
                            Dear <span class="text-white font-semibold">{{ session('user_name') }}</span>,
                        @else
                            Dear Valued User,
                        @endif
                    </p>

                    @if(session('banned_reason'))
                        <p class="text-gray-300 text-lg leading-relaxed mt-4">
                            {{ session('banned_reason') }}
                        </p>
                    @endif

                    <p class="text-gray-300 text-lg leading-relaxed mt-4">
                        We noticed a potentially fraudulent transaction on your account and have temporarily locked it for your security.
                        Please contact us at
                        <a href="mailto:{{$settings->contact_email}}" class="text-blue-400 hover:text-blue-300 transition-colors">
                           {{$settings->contact_email}}
                        </a>
                        or via live chat, as soon as possible so we can verify the activity and restore your access.
                    </p>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <!-- Email Support -->
                    <div class="bg-gray-800/30 border border-gray-600/30 rounded-xl p-4">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="h-6 w-6 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-blue-400 font-semibold">Email Support</span>
                        </div>
                        <a href="mailto:{{$settings->contact_email}}"
                           class="text-white hover:text-blue-300 transition-colors text-sm">
                            {{$settings->contact_email}}
                        </a>
                    </div>

                    <!-- Live Chat -->
                    <div class="bg-gray-800/30 border border-gray-600/30 rounded-xl p-4">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="h-6 w-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.255-.949L5 20l1.395-3.72C5.512 15.042 5 13.574 5 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"/>
                            </svg>
                            <span class="text-green-400 font-semibold">Live Chat</span>
                        </div>
                        <span class="text-white text-sm">Available 24/7</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="mailto:support@{{ request()->getHost() }}?subject=Account%20Locked%20-%20Urgent%20Review%20Required&body=Hello%20Support%20Team,%0A%0AMy%20account%20has%20been%20temporarily%20locked.%20Please%20review%20and%20restore%20access.%0A%0AAccount%20Email:%20{{ session('user_email', '') }}%0A%0AThank%20you."
                       class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Support Now
                    </a>

                    <div class="text-center">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Return to Homepage
                        </a>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-8 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-yellow-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div class="text-left">
                            <p class="text-yellow-200 text-sm font-medium mb-1">Security Notice</p>
                            <p class="text-yellow-100 text-sm">
                                This temporary lock is for your protection. We take account security seriously and will restore access once verification is complete.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
