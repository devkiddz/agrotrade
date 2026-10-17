@extends('layouts.guest1')
@section('title', 'Reset your password')
@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-8">
        <!-- Status Messages -->
        @if (Session::has('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                <div class="flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-400"></i>
                    <p class="text-green-300 text-sm font-bold">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if (Session::has('message'))
            <div class="p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-center gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
                    <p class="text-blue-300 text-sm font-bold">{{ Session::get('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Logo and Header -->
        <div class="text-center space-y-6">
            <div class="flex justify-center">
                <a href="/" class="inline-block">
                    <img src="{{ asset('storage/app/public/' . $settings->logo) }}"
                         alt="{{ $settings->site_name }}"
                         class="h-12 sm:h-16 w-auto">
                </a>
            </div>

            <!-- Header Section -->
            <div class="space-y-3">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="p-2 bg-blue-500/20 rounded-lg">
                        <i data-lucide="key-round" class="w-6 h-6 text-blue-400"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Reset Password</h1>
                </div>
                <p class="text-gray-400 text-sm sm:text-base max-w-sm mx-auto leading-relaxed">
                    Enter your email address and create a new secure password for your trading account.
                </p>
            </div>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 sm:p-8 space-y-6">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i data-lucide="mail" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="your.email@example.com">
                    </div>
                    @error('email')
                        <p class="text-sm text-red-400 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-gray-200">
                        New Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i data-lucide="lock" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               autocomplete="new-password"
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-12 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="Create strong password">
                        <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-400 transition-colors"
                                onclick="togglePassword('password')">
                            <i data-lucide="eye" class="h-5 w-5" id="password-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-400 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-200">
                        Confirm Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i data-lucide="key" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-12 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="Confirm your password">
                        <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-400 transition-colors"
                                onclick="togglePassword('password_confirmation')">
                            <i data-lucide="eye" class="h-5 w-5" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-sm font-bold text-gray-200 mb-2">Password Requirements:</p>
                    <ul class="text-xs text-gray-300 space-y-1">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                            At least 8 characters long
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                            Contains uppercase and lowercase letters
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                            Includes at least one number or special character
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-2 focus:ring-blue-400/20">
                    <i data-lucide="key-round" class="w-5 h-5"></i>
                    <span>Reset Password</span>
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-700">
                <p class="text-gray-400 text-sm">
                    Remember your password?
                    <a href="{{ route('login') }}"
                       class="font-bold text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                        Back to Login
                    </a>
                </p>
            </div>

            <!-- Security Notice -->
            <div class="p-4 bg-amber-500/10 rounded-xl border border-amber-500/20">
                <div class="flex items-start gap-3">
                    <i data-lucide="shield-alert" class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h4 class="text-sm font-bold text-amber-300 mb-1">Security Notice</h4>
                        <p class="text-xs text-gray-300">
                            For your security, this password reset link will expire in 60 minutes.
                            Choose a strong, unique password for your trading account.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Indicators -->
        <div class="flex items-center justify-center gap-6 text-xs text-gray-500">
            <div class="flex items-center gap-1">
                <i data-lucide="shield" class="w-3 h-3"></i>
                <span>SSL Secured</span>
            </div>
            <div class="flex items-center gap-1">
                <i data-lucide="lock" class="w-3 h-3"></i>
                <span>256-bit Encryption</span>
            </div>
            <div class="flex items-center gap-1">
                <i data-lucide="award" class="w-3 h-3"></i>
                <span>Regulated Platform</span>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');

    if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.setAttribute('data-lucide', 'eye-off');
    } else {
        field.type = 'password';
        eyeIcon.setAttribute('data-lucide', 'eye');
    }

    // Reinitialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}
</script>
@endsection
