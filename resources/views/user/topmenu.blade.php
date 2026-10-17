<!-- Main nav -->
<nav class="navbar navbar-main navbar-expand-lg navbar-dark bg-primary navbar-border" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand + Toggler (for mobile devices) -->
        <div class="pl-4 d-block d-md-none">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/app/public/' . $settings->logo) }}" class="navbar-brand-img" alt="...">
            </a>
        </div>

        <!-- User's navbar -->
        <div class="ml-auto navbar-user d-lg-none">
            <ul class="flex-row navbar-nav align-items-center">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><i class="far fa-bars"></i></a>
                </li>

                @if ($settings->enable_kyc == 'yes')
                    <li class="nav-item dropdown dropdown-animate">
                        @if (Auth::user()->account_verify == 'Verified')
                            <a class="nav-link nav-link-icon" href="#">
                                <i class="fas fa-user-check"></i>
                                <strong style="font-size:8px;">Verified</strong>
                            </a>
                        @else
                            <a class="nav-link nav-link-icon" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                                <strong style="font-size:8px;">KYC</strong>
                            </a>
                            <div class="p-0 dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow">
                                <div class="p-2">
                                    <h5 class="mb-0 heading h6">KYC Verification</h5>
                                </div>
                                <div class="pb-2 mt-0 text-center list-group list-group-flush">
                                    @if (Auth::user()->account_verify == 'Under review')
                                        Your Submission is under review
                                    @else
                                        <div class="">
                                            <a href="{{ route('account.verify') }}"
                                                class="btn btn-primary btn-sm">Verify
                                                Account </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </li>
                @endif

                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm rounded-circle">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="px-0 dropdown-header">Hi, {{ Auth::user()->name }}!</h6>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="far fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Navbar nav -->
        <div class="collapse navbar-collapse navbar-collapse-fade" id="navbar-main-collapse">

            <!-- Right menu -->
            <ul class="navbar-nav ml-lg-auto align-items-center d-none d-lg-flex">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><i class="far fa-bars"></i></a>
                </li>

                <!-- Notifications -->
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                                ->where('is_read', 0)
                                ->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="badge badge-success badge-circle badge-sm badge-floating border-white">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-arrow">
                        <div class="px-3 py-2 border-bottom">
                            <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                Notifications
                                @if($unreadCount > 0)
                                <a href="{{ route('notifications.mark-all-read') }}" class="text-sm text-primary">Mark all read</a>
                                @endif
                            </h6>
                        </div>
                        <div class="py-2 list-group list-group-flush">
                            @php
                                $notifications = \App\Models\Notification::where('user_id', Auth::id())
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp

                            @forelse($notifications as $notification)
                                <a href="{{ route('notifications.show', $notification->id) }}" class="list-group-item list-group-item-action {{ !$notification->is_read ? 'bg-light' : '' }}">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <i class="fas fa-{{ $notification->type === 'warning' ? 'exclamation-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'times-circle' : 'info-circle')) }} text-{{ $notification->type === 'warning' ? 'warning' : ($notification->type === 'success' ? 'success' : ($notification->type === 'danger' ? 'danger' : 'info')) }} fa-2x"></i>
                                        </div>
                                        <div class="flex-fill">
                                            <h6 class="text-sm mb-0 {{ !$notification->is_read ? 'font-weight-bold' : 'text-muted' }}">
                                                {{ $notification->title }}
                                            </h6>
                                            <p class="text-xs text-muted mb-0">
                                                {{ \Illuminate\Support\Str::limit($notification->message, 60) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash fa-3x text-muted"></i>
                                    <p class="mt-2">No notifications</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="py-2 text-center border-top">
                            <a href="{{ route('notifications') }}" class="link link-sm link--style-3">View all notifications</a>
                        </div>
                    </div>
                </li>

                @if ($settings->enable_kyc == 'yes')
                    <li class="nav-item dropdown dropdown-animate">
                        @if (Auth::user()->account_verify == 'Verified')
                            <a class="nav-link nav-link-icon" href="#">
                                <i class="fas fa-user-check"></i>
                                <strong style="font-size:8px;">Verified</strong>
                            </a>
                        @else
                            <a class="nav-link nav-link-icon" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                                <strong style="font-size:8px;">KYC</strong>
                            </a>
                            <div class="p-0 dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow">
                                <div class="p-2">
                                    <h5 class="mb-0 heading h6">KYC Verification</h5>
                                </div>
                                <div class="pb-2 mt-0 text-center list-group list-group-flush">
                                    @if (Auth::user()->account_verify == 'Under review')
                                        Your Submission is under review
                                    @else
                                        <div class="">
                                            <a href="{{ route('account.verify') }}"
                                                class="btn btn-primary btn-sm">Verify
                                                Account </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </li>
                @endif

                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media media-pill align-items-center">
                            <span class="avatar rounded-circle">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </span>
                            <div class="ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="px-0 dropdown-header">Hi, {{ Auth::user()->name }}!</h6>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="far fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
