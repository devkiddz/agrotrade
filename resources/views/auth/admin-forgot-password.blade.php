@extends('layouts.guest1')
@section('title', 'Admin Password Recovery - Secure Access Recovery')
@section('content')

<!-- Admin Password Recovery Interface -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">

        <!-- Admin Password Recovery Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Security Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-500/10 mb-4">
                    <i data-lucide="shield-question" class="h-8 w-8 text-orange-400"></i>
                </div>

                <!-- Admin Badge -->
                <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/20 rounded-full px-4 py-2 mb-4">
                    <i data-lucide="key" class="w-4 h-4 text-orange-400"></i>
                    <span class="text-orange-300 text-sm font-bold">Admin Recovery</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    Forgot Password?
                </h1>
                <p class="text-gray-400 text-sm md:text-base">
                    Secure password recovery for administrative access
                </p>
            </div>

            <!-- Alert Messages -->
            <x-danger-alert />
            <x-success-alert />

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">Recovery Email Sent</p>
                            <p class="text-gray-300">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recovery Instructions -->
            <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-start gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0"></i>
                    <div class="text-sm">
                        <p class="text-blue-300 font-bold mb-1">Password Recovery Process</p>
                        <p class="text-gray-300">
                            Enter your admin email address below. We'll send you secure instructions with a recovery token to reset your password.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Password Recovery Form -->
            <form method="POST" action="{{ route('sendpasswordrequest') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        Admin Email Address
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none transition-all duration-200"
                            placeholder="Enter your admin email address"
                            autocomplete="email"
                            required
                            autofocus
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="flex items-center gap-2 text-red-400 text-sm">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <p class="text-xs text-gray-500">Enter the email address associated with your admin account</p>
                </div>

                <!-- Security Notice -->
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-yellow-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            <p class="text-yellow-300 font-bold mb-1">Security Notice</p>
                            <ul class="text-gray-300 space-y-1">
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    Recovery token will expire in 15 minutes
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    Only admin emails can request recovery
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    All recovery attempts are logged
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Send Recovery Email Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500/50"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Send Recovery Instructions
                    </span>
                </button>

                <!-- Back to Admin Login -->
                <div class="text-center">
                    <a href="{{ route('adminloginform') }}"
                       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors duration-200">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Admin Sign In
                    </a>
                </div>
            </form>

            <!-- Recovery Process Steps -->
            <div class="mt-8 bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                <h4 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                    <i data-lucide="list-checks" class="w-4 h-4 text-blue-400"></i>
                    Recovery Process
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">1</span>
                        <span>Enter your admin email address</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">2</span>
                        <span>Check your email for recovery instructions</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">3</span>
                        <span>Use the token to reset your password</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">4</span>
                        <span>Access your admin account with new password</span>
                    </div>
                </div>
            </div>

            <!-- Admin Security Features -->
            <div class="mt-6 pt-6 border-t border-gray-700">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-3">Enterprise admin security</p>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span class="flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3 h-3"></i>
                            <span class="text-xs">Encrypted</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            <span class="text-xs">Time-Limited</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="eye" class="w-3 h-3"></i>
                            <span class="text-xs">Audit Logged</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-900/5 via-gray-900 to-yellow-900/5"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/2 translate-x-1/2 w-96 h-96 bg-yellow-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Support Information -->
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                Need immediate assistance?
                <a href="mailto:admin-support@bluetrade.com" class="text-orange-400 hover:text-orange-300 font-medium ml-1 transition-colors duration-200">
                    Contact Admin Support
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

        // Auto-focus email input
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }

        // Email validation feedback
        emailInput.addEventListener('input', function(e) {
            const value = e.target.value;
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            const parent = e.target.parentElement;

            if (value && isValid) {
                parent.classList.remove('border-gray-600', 'border-red-500');
                parent.classList.add('border-green-500');
            } else if (value && !isValid) {
                parent.classList.remove('border-gray-600', 'border-green-500');
                parent.classList.add('border-red-500');
            } else {
                parent.classList.remove('border-green-500', 'border-red-500');
                parent.classList.add('border-gray-600');
            }
        });

        // Form submission feedback
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitButton.innerHTML = '<span class="flex items-center justify-center gap-2"><i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>Sending Recovery Email...</span>';
            submitButton.disabled = true;

            // Re-initialize icons
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        });
    });
</script>
@endsection
