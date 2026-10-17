@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Account Settings
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-4 col-xxl-3">
            <!-- Card -->
            <div class="card border-0 sticky-md-top top-10px">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <div class="avatar avatar-xxl avatar-circle mb-5">
                            <livewire:user.account-settings.update-profile-picture />
                        </div>
                        <h3 class="mb-0">{{ auth()->user()->name }}</h3>
                        <span class="small text-secondary fw-semibold">{{ auth()->user()->email }}</span>
                    </div>
                    <!-- Divider -->
                    <hr class="mb-0">
                </div>

                <ul class="scrollspy mb-5" id="account" data-scrollspy='{"offset": "30"}'>
                    <li class="active">
                        <a href="#basicInformationSection" class="d-flex align-items-center py-3">
                            <svg viewBox="0 0 24 24" height="14" width="14" class="me-3"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.750 6.000 A5.250 5.250 0 1 0 17.250 6.000 A5.250 5.250 0 1 0 6.750 6.000 Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" />
                                <path d="M2.25,23.25a9.75,9.75,0,0,1,19.5,0" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                            </svg>
                            Basic information
                        </a>
                    </li>

                    <li>
                        <a href="#passwordSection" class="d-flex align-items-center py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="14"
                                width="14" class="me-3">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M18.75 9.75H5.25C4.42157 9.75 3.75 10.4216 3.75 11.25V21.75C3.75 22.5784 4.42157 23.25 5.25 23.25H18.75C19.5784 23.25 20.25 22.5784 20.25 21.75V11.25C20.25 10.4216 19.5784 9.75 18.75 9.75Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M6.75 9.75V6C6.75 4.60761 7.30312 3.27226 8.28769 2.28769C9.27226 1.30312 10.6076 0.75 12 0.75C13.3924 0.75 14.7277 1.30312 15.7123 2.28769C16.6969 3.27226 17.25 4.60761 17.25 6V9.75" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M8.625 15C8.41789 15 8.25 14.8321 8.25 14.625C8.25 14.4179 8.41789 14.25 8.625 14.25" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M8.625 15C8.83211 15 9 14.8321 9 14.625C9 14.4179 8.83211 14.25 8.625 14.25" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M8.625 18.75C8.41789 18.75 8.25 18.5821 8.25 18.375C8.25 18.1679 8.41789 18 8.625 18" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M8.625 18.75C8.83211 18.75 9 18.5821 9 18.375C9 18.1679 8.83211 18 8.625 18" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M12 15C11.7929 15 11.625 14.8321 11.625 14.625C11.625 14.4179 11.7929 14.25 12 14.25" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M12 15C12.2071 15 12.375 14.8321 12.375 14.625C12.375 14.4179 12.2071 14.25 12 14.25" />
                                <g>
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M12 18.75C11.7929 18.75 11.625 18.5821 11.625 18.375C11.625 18.1679 11.7929 18 12 18" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M12 18.75C12.2071 18.75 12.375 18.5821 12.375 18.375C12.375 18.1679 12.2071 18 12 18" />
                                </g>
                                <g>
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M15.375 15C15.1679 15 15 14.8321 15 14.625C15 14.4179 15.1679 14.25 15.375 14.25" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M15.375 15C15.5821 15 15.75 14.8321 15.75 14.625C15.75 14.4179 15.5821 14.25 15.375 14.25" />
                                </g>
                                <g>
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M15.375 18.75C15.1679 18.75 15 18.5821 15 18.375C15 18.1679 15.1679 18 15.375 18" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M15.375 18.75C15.5821 18.75 15.75 18.5821 15.75 18.375C15.75 18.1679 15.5821 18 15.375 18" />
                                </g>
                            </svg>
                            Password
                        </a>
                    </li>



                    <li>
                        <a href="#paymentMethodsSection" class="d-flex align-items-center py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="14" width="14"
                                class="me-3">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                            stroke: currentColor;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-width: 1.5px;
                                        }
                                    </style>
                                </defs>
                                <title>credit-card-1</title>
                                <rect class="a" x="0.75" y="3.75" width="22.5" height="16.5"
                                    rx="1.5" ry="1.5" />
                                <line class="a" x1="0.75" y1="8.25" x2="23.25" y2="8.25" />
                                <line class="a" x1="5.25" y1="12.75" x2="13.5" y2="12.75" />
                                <line class="a" x1="5.25" y1="15.75" x2="10.5" y2="15.75" />
                            </svg>
                            Payment methods
                        </a>
                    </li>

                    <li>
                        <a href="#notificationsSection" class="d-flex align-items-center py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="14" width="14"
                                class="me-3">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                            stroke: currentColor;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-width: 1.5px;
                                        }
                                    </style>
                                </defs>
                                <title>alert-bell-notification-2</title>
                                <circle class="a" cx="18.875" cy="5.827" r="3" />
                                <path class="a" d="M9.125,21.75a2.087,2.087,0,0,0,4.005,0" />
                                <line class="a" x1="11.125" y1="3" x2="11.125" y2="0.75" />
                                <path class="a"
                                    d="M18.648,11.961c.189,5.756,1.477,6.789,1.477,6.789h-18s1.5-1.916,1.5-8.25a7.507,7.507,0,0,1,9.724-7.165" />
                            </svg>
                            Notifications
                        </a>
                    </li>
                    <li>
                        <a href="#privacyAndSafetySection" class="d-flex align-items-center py-3">
                            <svg viewBox="0 0 24 24" height="14" width="14" class="me-3"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.749,9a8.25,8.25,0,0,1,13.5-6.364" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <path
                                    d="M19.687,6a8.23,8.23,0,0,1,.562,3v6A8.25,8.25,0,0,1,12,23.25a8.336,8.336,0,0,1-1.5-.136"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" />
                                <path d="M6.751,21.365a8.234,8.234,0,0,1-3-6.365V12.75" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" />
                                <path d="M15.749,15V9a3.75,3.75,0,0,0-6-3" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <path d="M8.249,9v6A3.753,3.753,0,0,0,13.5,18.438" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <path d="M11.999 9.75L11.999 14.25" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                            </svg>
                            Privacy and Safety
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col">
            <!-- Card -->
            <div class="card border-0 scroll-mt-3" id="basicInformationSection">
                <div class="card-header">
                    <h2 class="h3 mb-0">Basic information</h2>
                </div>

                <livewire:user.account-settings.update-profile-info>
            </div>

            <!-- Card -->
            <div class="card border-0 scroll-mt-3" id="passwordSection">
                <div class="card-header">
                    <h2 class="h3 mb-0">Password</h2>
                </div>

                <livewire:user.account-settings.update-password>
            </div>


            <!-- Card -->
            <div class="card border-0 scroll-mt-3" id="paymentMethodsSection">
                <div class="card-header">
                    <h2 class="h3 mb-0">Payment methods</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mt-5">
                        <livewire:user.account-settings.update-payment-method>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="card border-0 scroll-mt-3" id="notificationsSection">
                <div class="card-header">
                    <h2 class="h3 mb-0">Notifications</h2>
                </div>

                <div class="card-body">
                    <p class="text-muted">In this setcion you will be able to configure the behaviour of notifications
                        in Dashly</p>
                    <livewire:user.account-settings.update-email-pref>
                </div>
            </div>
            <!-- Card -->
            <div class="card border-0 scroll-mt-3" id="privacyAndSafetySection">
                <div class="card-header">
                    <h2 class="h3 mb-0">Privacy and Safety</h2>
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="me-2">
                                <h3 class="h4 mb-0">Use 2-Step Verification</h3>
                            </div>
                            <a href="{{ route('twofa') }}" class="btn btn-sm text-bg-info-soft border-0">View</a>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="me-2">
                                <h3 class="h4 mb-0">Login activity</h3>
                            </div>
                            <a href="{{ route('twofa') }}" class="btn btn-sm text-bg-info-soft border-0">View</a>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="me-2">
                                <h3 class="h4 mb-0">Delete Account</h3>
                            </div>
                            <a href="{{ route('twofa') }}" class="btn btn-sm text-bg-danger-soft border-0">Delete
                                account
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.addEventListener('profile-updated', event => {
            var toastOptions = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            if (event.detail.type == 'success') {
                Command: toastr["success"](event.detail.message, "Success")
                toastr.options = toastOptions;
            }

            if (event.detail.type == 'error') {
                Command: toastr["error"](event.detail.message, "Error")
                toastr.options = toastOptions;
            }

        })
    </script>
@endpush
