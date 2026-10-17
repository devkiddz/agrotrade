@extends('layouts.guest1')
@section('title', 'Email Verification - Secure Your Trading Account')
@section('content')

<!-- Email Verification Interface -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">

        <!-- Email Verification Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Email Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-500/10 mb-4">
                    <i data-lucide="mail-check" class="h-8 w-8 text-green-400"></i>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    Verify Your Email
                </h1>
                <p class="text-gray-400 text-sm md:text-base">
                    Secure your trading account by verifying your email address
                </p>
            </div>

            <!-- Success Messages -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">Verification Email Sent</p>
                            <p class="text-gray-300">
                                A verification link has been sent to your email address. Please check your inbox and click the link to verify your account.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('message'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">Update</p>
                            <p class="text-gray-300">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Email Verification Instructions -->
            <div class="mb-8 p-6 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-start gap-4">
                    <i data-lucide="mail" class="w-6 h-6 text-blue-400 mt-1 flex-shrink-0"></i>
                    <div>
                        <h3 class="text-blue-300 font-bold text-lg mb-3">Check Your Email</h3>
                        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                            We've sent a secure verification link to your registered email address.
                            Click the link in the email to activate your trading account and access all features.
                        </p>

                        <!-- Email Steps -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">1</span>
                                <span>Check your inbox for our verification email</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">2</span>
                                <span>Click the "Verify Email" button in the email</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">3</span>
                                <span>Return to complete your account setup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="space-y-4">

                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                    @csrf

                    <!-- Resend Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            {{ __('Resend Verification Email') }}
                        </span>
                    </button>
                </form>

                <!-- Logout Option -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 border border-gray-600 hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500/50"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            {{ __('Sign Out') }}
                        </span>
                    </button>
                </form>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="mt-8 bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                <h4 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                    <i data-lucide="help-circle" class="w-4 h-4 text-yellow-400"></i>
                    Can't Find the Email?
                </h4>
                <ul class="text-gray-300 text-xs space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Check your spam or junk folder
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Ensure the email address is correct
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Wait a few minutes for delivery
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Click "Resend" if needed after 2 minutes
                    </li>
                </ul>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 pt-6 border-t border-gray-700">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-3">Why verify your email?</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                            <span>Account Security</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <i data-lucide="bell" class="w-4 h-4 text-blue-400"></i>
                            <span>Trade Alerts</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <i data-lucide="key" class="w-4 h-4 text-purple-400"></i>
                            <span>Password Recovery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-900/5 via-gray-900 to-blue-900/5"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-green-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/2 translate-x-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Support Contact -->
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                Need help?
                <a href="mailto:support@bluetrade.com" class="text-blue-400 hover:text-blue-300 font-medium ml-1 transition-colors duration-200">
                    Contact Support
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Add Lucide Icons Script -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Auto-check email status periodically (optional enhancement)
        let checkCount = 0;
        const maxChecks = 5;

        function showEmailTip() {
            if (checkCount < maxChecks) {
                setTimeout(() => {
                    const tipElement = document.querySelector('[data-email-tip]');
                    if (tipElement) {
                        tipElement.classList.add('animate-pulse');
                        setTimeout(() => {
                            tipElement.classList.remove('animate-pulse');
                        }, 2000);
                    }
                    checkCount++;
                    showEmailTip();
                }, 30000); // Show tip every 30 seconds
            }
        }

        // Start the tip system after 1 minute
        setTimeout(showEmailTip, 60000);

        // Add click tracking for resend button
        const resendButton = document.querySelector('button[type="submit"]');
        if (resendButton) {
            resendButton.addEventListener('click', function() {
                // Reset check count when resending
                checkCount = 0;

                // Visual feedback
                this.innerHTML = '<span class="flex items-center justify-center gap-2"><i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>Sending...</span>';

                // Re-initialize icons after content change
                setTimeout(() => {
                    lucide.createIcons();
                }, 100);
            });
        }
    });
</script>
@endsection
