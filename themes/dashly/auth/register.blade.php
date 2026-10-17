@extends('layouts.guest')
@section('title', 'Sign up')
@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-md-7 col-lg-6 px-lg-4 px-xl-8 d-flex flex-column vh-100 py-6">
            @if (Session::has('status'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="/" class="navbar-brand mb-auto">
                <img src="{{ asset('storage/app/public/' . $settings->logo) }}" alt="Logo" class="logo-large"
                    width="125" height="25">
            </a>

            <div>
                <!-- Title -->
                <h1 class="mb-2">
                    Free Sign Up
                </h1>

                <!-- Subtitle -->
                <p class="text-secondary">
                    Don't have an account? Create your account, it takes less than a minute
                </p>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Username
                                </label>
                                <!-- Input -->
                                <input type="text" id="username" class="form-control" name="username"
                                    placeholder="Your username" required>
                            </div>
                            @error('username')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Full name
                                </label>
                                <!-- Input -->
                                <input type="text" class="form-control" name="name" placeholder="Your full name"
                                    required>
                            </div>
                            @error('name')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Email
                                </label>
                                <!-- Input -->
                                <input type="text" class="form-control" name="email" placeholder="Your email" required>
                            </div>
                            @error('email')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Phone Number
                                </label>
                                <!-- Input -->
                                <input type="text" class="form-control" name="phone" placeholder="Your phone number"
                                    required>
                            </div>
                            @error('phone')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Country
                                </label>
                                <select class="form-select" name="country" required>
                                    <option>Choose Country</option>
                                    @include('auth.countries')
                                </select>
                            </div>
                            @error('country')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (Session::has('ref_by'))
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <!-- Label -->
                                    <label class="form-label">
                                        Referral ID
                                    </label>
                                    <!-- Input -->
                                    <input type="text" class="form-control" value="{{ session('ref_by') }}"
                                        name="ref_by" required>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <!-- Label -->
                                    <label class="form-label">
                                        Referral ID (Optional)
                                    </label>
                                    <!-- Input -->
                                    <input type="text" class="form-control" name="ref_by" placeholder=" referral id">
                                </div>
                            </div>
                        @endif
                        @if ($settings->captcha == 'true')
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <!-- Label -->
                                    <label class="form-label">
                                        Captcha
                                    </label>
                                    <div class="position-relative">
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                </div>
                                @error('g-recaptcha-response')
                                    <small class="fs-6 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

                    </div> <!-- / .row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Password
                                </label>

                                <!-- Input -->
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" autocomplete="off"
                                        data-toggle-password-input placeholder="Your password" name="password" required>

                                    <button type="button" class="input-group-text px-4 text-secondary link-primary"
                                        data-toggle-password></button>
                                </div>
                            </div>
                            @error('password')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Confirm password
                                </label>
                                <!-- Input -->
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" autocomplete="off"
                                        data-toggle-password-input placeholder="Your password again"
                                        name="password_confirmation" required>

                                    <button type="button" class="input-group-text px-4 text-secondary link-primary"
                                        data-toggle-password></button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- / .row -->
                    @if ($terms->useterms == 'yes')
                        <div class="form-check">
                            <!-- Input -->
                            <input type="checkbox" class="form-check-input" id="agree" required>

                            <!-- Label -->
                            <label class="form-check-label" for="agree">
                                I agree with <a href="{{ route('privacy') }}">Terms & Conditions</a> and have understood
                                <a href="javascript: void(0);">Privacy Policy</a>
                            </label>
                        </div>
                    @endif

                    <!-- Button -->
                    <button type="submit" class="btn btn-primary mt-3">
                        Get started
                    </button>
                </form>
                @if ($settings->enable_social_login == 'yes')
                    <div class="my-2 text-center">
                        <small>Or</small>
                        <div class="row">
                            <!--end col-->
                            <div class="col-12 my-3">
                                <a href="{{ route('social.redirect', ['social' => 'google']) }}"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-google"></i> Sign up with
                                    Google</a>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-auto">
                <!-- Link -->
                <small class="mb-0 text-muted">
                    Already registered? <a href="{{ route('login') }}" class="fw-semibold">Login</a>
                </small>
            </div>
        </div>

        <div class="col-md-5 col-lg-6 d-none d-lg-block">
            <!-- Image -->
            <div class="bg-size-cover bg-position-center bg-repeat-no-repeat overlay overlay-dark overlay-50 vh-100 me-n4"
                style="background-image: url(themes/dashly/assets/images/covers/sign-up-cover.jpg);"></div>
        </div>
    </div> <!-- / .row -->
@endsection
