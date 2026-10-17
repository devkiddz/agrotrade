@extends('layouts.guest')
@section('title', 'Authenticate account')
@section('content')
    <div class="row align-items-center justify-content-around vh-100" x-data="{ recovery: false }">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 py-6">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Title -->
            <h1 class="text-center mb-2">2-step verification</h1>
            <!-- Heading -->
            <p class="text-secondary text-center" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </p>
            <p class="text-secondary text-center" x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </p>
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
                    <a href="/"><img src="{{ asset('storage/photos/' . $settings->logo) }}" alt=""
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
