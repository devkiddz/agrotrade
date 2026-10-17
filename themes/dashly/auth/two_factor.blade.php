@extends('layouts.guest')
@section('title', 'Two factor authentication')
@section('content')
    <div class="row align-items-center justify-content-center vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 py-6">
            @if (Session::has('message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Title -->
            <h1 class="mb-2 text-center">
                Two factor authentication
            </h1>

            <!-- Subtitle -->
            <p class="text-secondary text-center">
                A 2FA authentication code has been sent to your email, kindly
                check your email and enter code below to continue.
            </p>

            <form method="POST" action="{{ route('twofalogin') }}">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                            <!-- Label -->
                            <label class="form-label">
                                Code
                            </label>
                            <input type="password" class="form-control" name="twofa"
                                placeholder="Enter the code you receive here" required>
                        </div>
                        @error('twofa')
                            <small class="fs-6 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> <!-- / .row -->

                <div class="row align-items-center text-center">
                    <div class="col-12">
                        <!-- Button -->
                        <button type="submit" class="btn w-100 btn-primary mt-3 mb-2">Sign in</button>
                    </div>
                    <div class="col-12">
                        <!-- Link -->
                        <small class="mb-0 text-muted">Back to
                            <a href="{{ route('adminlogout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                class="">
                                Sign in
                            </a>
                    </div>
                </div> <!-- / .row -->
            </form>
            <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div> <!-- / .row -->

@endsection
