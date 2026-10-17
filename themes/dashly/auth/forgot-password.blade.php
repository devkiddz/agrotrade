@extends('layouts.guest')
@section('title', 'Forgot your password')
@section('content')
    <div class="row align-items-center justify-content-center vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 py-6">
            @if (Session::has('message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Title -->
            <h1 class="mb-2 text-center">
                Forgot password?
            </h1>

            <!-- Subtitle -->
            <p class="text-secondary text-center">
                Enter your email address and we'll send you an email with instructions to reset your password
            </p>

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">

                            <!-- Label -->
                            <label class="form-label">
                                Email Address
                            </label>

                            <!-- Input -->
                            <input type="email" class="form-control" name="email"
                                placeholder="Enter your email address">
                        </div>
                        @error('email')
                            <small class="fs-6 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> <!-- / .row -->

                <div class="row align-items-center text-center">
                    <div class="col-12">
                        <!-- Button -->
                        <button type="submit" class="btn w-100 btn-primary mt-3 mb-2">Reset password</button>
                    </div>
                    <div class="col-12">
                        <!-- Link -->
                        <small class="mb-0 text-muted">Back to <a href="{{ route('login') }}" class="fw-semibold">Sign
                                in</a></small>
                    </div>
                </div> <!-- / .row -->
            </form>
        </div>
    </div> <!-- / .row -->
@endsection
