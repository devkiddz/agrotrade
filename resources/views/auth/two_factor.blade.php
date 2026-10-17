@extends('layouts.guest1')
@section('title', 'Two-Factor Authentication - Secure Verification')
@section('content')

<!-- Advanced 2FA Challenge -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ recovery: false }">
    <div class="max-w-md w-full space-y-8">

        <!-- 2FA Challenge Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Dynamic Security Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500/10 mb-4">
                    <i data-lucide="smartphone" x-show="!recovery" class="h-8 w-8 text-blue-400"></i>
                    <i data-lucide="key-round" x-show="recovery" class="h-8 w-8 text-amber-400"></i>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    Two-Step Verification
                </h1>

                <!-- Dynamic Descriptions -->
                <p class="text-gray-400 text-sm md:text-base" x-show="!recovery">
                    Enter the 6-digit code from your authenticator app to secure your trading account
                </p>
                <p class="text-gray-400 text-sm md:text-base" x-show="recovery">
                    Use one of your emergency recovery codes to regain access to your account
                </p>
            </div>

            <!-- Dynamic Security Notice -->
            <div class="mb-6 p-4 rounded-xl border transition-all duration-300"
                 :class="recovery ? 'bg-amber-500/10 border-amber-500/20' : 'bg-blue-500/10 border-blue-500/20'">
                <div class="flex items-start gap-3">
                    <i data-lucide="shield-alert" x-show="!recovery" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0"></i>
                    <i data-lucide="alert-triangle" x-show="recovery" class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                    <div class="text-sm">
                        <p class="font-bold mb-1" :class="recovery ? 'text-amber-300' : 'text-blue-300'">
                            <span x-show="!recovery">Authenticator Required</span>
                            <span x-show="recovery">Recovery Mode</span>
                        </p>
                        <p class="text-gray-300" x-show="!recovery">
                            Open your authenticator app (Google Authenticator, Authy, etc.) and enter the current 6-digit code.
                        </p>
                        <p class="text-gray-300" x-show="recovery">
                            Recovery codes are single-use only. Save remaining codes in a secure location after use.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                    <div class="space-y-2">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-400 flex-shrink-0"></i>
                                <span class="text-red-300 text-sm font-medium">{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12" x-show="! recovery">
                        <div class="mb-5">
                            <label class="form-label">
                                Code
                            </label>
                            <!-- Input -->
                            <input type="text" inputmode="numeric" class="form-control"
                                placeholder="Enter auth code from your app" name="code" autofocus x-ref="code"
                                autocomplete="one-time-code">
                        </div>
                    </div>
                    <!--end col-->

                    <div class="col-lg-12" x-show="recovery">
                        <div class="mb-5">
                            <label class="form-label">
                                {{ __('Recovery Code') }}
                            </label>
                            <input id="recovery_code" class="form-control" type="text" name="recovery_code"
                                x-ref="recovery_code" autocomplete="one-time-code">
                        </div>
                    </div>
                    <!--end col-->

                    <div class="my-2 col-lg-12 text-center">
                        <button class="btn btn-link" type="button" x-show="! recovery"
                            x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                            {{ __('Use a recovery code') }}
                        </button>
                    </div>

                    <div class="my-2 col-lg-12 text-center">
                        <button class="btn btn-link" type="button" x-show="recovery"
                            x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                            {{ __('Use an authentication code') }}
                        </button>
                    </div>
                </div>
                <div class="row align-items-center text-center">
                    <div class="col-12">
                        <!-- Button -->
                        <button type="submit" class="btn w-100 btn-primary mt-3 mb-2">Verify & sign in</button>
                    </div>
                </div> <!-- / .row -->
                <!--end row-->
            </form>

        </div>
    </div> <!-- / .row -->
@endsection
{{-- <div x-data="{ recovery: false }">
    <section class=" auth">
        <div class="container">
            <div class="pb-3 row justify-content-center">

                <div class="col-12 col-md-6 col-lg-6 col-sm-10 col-xl-6">
                    <a href="/"><img src="{{ asset('storage/app/public/' . $settings->logo) }}" alt=""
                            class="mb-3 img-fluid auth__logo"></a>

                    <div class="bg-white shadow card login-page roundedd border-1 ">
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mb-4 text-sm text-center text-dark" x-show="! recovery">
                                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                                </div>

                                <div class="mb-4 text-sm text-center text-dark" x-show="recovery">
                                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!---->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end section-->
</div> --}}
