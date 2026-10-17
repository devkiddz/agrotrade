@extends('layouts.guest')
@section('title', 'Verify email address')
@section('content')
    <div class="row align-items-center justify-content-center vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 py-6">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    A verification link has been sent to the email address, please click on the link to verify your
                    email address.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Title -->
            <h1 class="mb-2 text-center">
                Verify your email
            </h1>
            <p class="text-secondary text-center">
                We've sent a link to your email address <br />
                Please follow the link inside to continue
            </p>
            <form method="POST" action="{{ route('verification.send') }}" class="mt-4 login-form">
                @csrf
                <div class="row align-items-center text-center">
                    <div class="col-12">
                        <!-- Link -->
                        <small class="mb-0 text-muted">Didn't receive an email?
                            <button class="fw-semibold btn btn-link" type="submit">
                                {{ __('Resend Verification Email') }}</button>
                        </small>
                    </div>
                </div> <!-- / .row -->
            </form>
            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

        </div>
    </div> <!-- / .row -->
@endsection
