<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $theme = 'light';
    $bg_class = 'bg-white';
    $text_class = 'text-slate-800';
    $border_class = 'border-slate-200';
    $shadow_class = 'shadow-sm';
} else {
    $theme = 'dark';
    $bg_class = 'bg-slate-900';
    $text_class = 'text-slate-100';
    $border_class = 'border-slate-700';
    $shadow_class = 'shadow-md';
}
?>

<!-- Modern Admin Topbar -->
<header class="admin-topbar {{ $bg_class }} {{ $border_class }} border-b {{ $shadow_class }} fixed-top" x-data="{
    searchOpen: false,
    notificationsOpen: false,
    userMenuOpen: false,
    mobileMenuOpen: false
}">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between py-3">
            <!-- Left Section: Logo & Toggle -->
            <div class="d-flex align-items-center">
                <!-- Mobile Menu Toggle -->
                <button type="button"
                        class="mobile-menu-toggle btn btn-icon d-lg-none me-2"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        aria-label="Toggle mobile menu">
                    <i class="fas fa-bars {{ $text_class }}"></i>
                </button>

                <!-- Sidebar Toggle Button -->
                <button type="button"
                        class="sidebar-toggle btn btn-icon d-none d-lg-flex"
                        aria-label="Toggle sidebar">
                    <i class="fas fa-bars {{ $text_class }}"></i>
                </button>

                <!-- Logo - Mobile: Only Icon, Desktop: Full Logo -->
                <a href="{{ url('/admin/dashboard') }}" class="logo-link ms-2">
                    <div class="d-flex align-items-center">
                        <div class="logo-icon d-flex align-items-center justify-content-center rounded bg-primary bg-gradient text-white"
                             style="width: 36px; height: 36px;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="logo-text ms-2 fs-5 fw-bold d-none d-md-block {{ $text_class }}">
                            {{ $settings->site_name }} <span class="text-primary">Admin</span>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Center Section: Search Bar (Desktop) -->
            <div class="search-container d-none d-md-block flex-grow-1 mx-4">
                <form class="search-form position-relative">
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-transparent">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="search"
                               class="form-control border-0 {{ $theme == 'dark' ? 'bg-slate-800' : 'bg-slate-100' }} rounded-pill"
                               placeholder="Search users, transactions, or settings..."
                               aria-label="Search">
                    </div>
                </form>
            </div>

            <!-- Right Section: Actions & User Menu -->
            <div class="d-flex align-items-center">
                <!-- Mobile Search Toggle -->
                <button type="button"
                        class="btn btn-icon d-md-none me-1"
                        @click="searchOpen = !searchOpen"
                        aria-label="Toggle search">
                    <i class="fas fa-search {{ $text_class }}"></i>
                </button>

                <!-- Quick Actions -->
                <div class="btn-group me-1">
                    <button type="button"
                            class="btn btn-sm btn-outline-primary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="fas fa-plus me-1"></i> Quick Action
                    </button>
                    <ul class="dropdown-menu {{ $theme == 'dark' ? 'dropdown-menu-dark' : '' }} shadow">
                        <li>
                            <a class="dropdown-item" href="{{ route('manageusers') }}">
                                <i class="fas fa-user-plus me-2"></i> Add User
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/dashboard/mdeposits') }}">
                                <i class="fas fa-money-bill me-2"></i> New Deposit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/dashboard/mwithdrawals') }}">
                                <i class="fas fa-hand-holding-usd me-2"></i> Process Withdrawal
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.send.message.form') }}">
                                <i class="fas fa-envelope me-2"></i> Send Message
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Notifications Dropdown -->
                <div class="dropdown me-2" x-data="{ notificationCount: {{ $count ?? 0 }} }">
                    <button class="btn btn-icon position-relative"
                            type="button"
                            @click="notificationsOpen = !notificationsOpen"
                            @click.away="notificationsOpen = false"
                            aria-label="Notifications">
                        <i class="fas fa-bell {{ $text_class }}"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              x-show="notificationCount > 0">
                            <span x-text="notificationCount"></span>
                            <span class="visually-hidden">notifications</span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end {{ $theme == 'dark' ? 'dropdown-menu-dark' : '' }} shadow-lg p-0"
                         style="width: 320px; max-height: 480px; overflow-y: auto;"
                         x-show="notificationsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">

                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom {{ $border_class }}">
                            <h6 class="mb-0 fw-semibold {{ $text_class }}">Notifications</h6>
                            <a href="{{ route('admin.notifications') }}" class="text-decoration-none small">View All</a>
                        </div>

                        <div class="notifications-container">
                            @if(isset($notifications) && count($notifications) > 0)
                                @foreach($notifications as $notification)
                                    <a href="{{ route('admin.notifications') }}" class="dropdown-item notification-item d-flex p-3 border-bottom {{ $border_class }}">
                                        <div class="flex-shrink-0 notification-icon rounded-circle d-flex align-items-center justify-content-center
                                                {{ $notification->type == 'deposit' ? 'bg-success-soft text-success' :
                                                  ($notification->type == 'withdrawal' ? 'bg-danger-soft text-danger' :
                                                  'bg-primary-soft text-primary') }}"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas {{ $notification->type == 'deposit' ? 'fa-money-bill-wave' :
                                                          ($notification->type == 'withdrawal' ? 'fa-hand-holding-usd' :
                                                          'fa-bell') }}"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 {{ $text_class }}">{{ $notification->message }}</p>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="p-4 text-center text-muted">
                                    <i class="fas fa-bell-slash mb-3 d-block" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0">No new notifications</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button type="button"
                        class="btn btn-icon me-2"
                        id="theme-toggle"
                        aria-label="Toggle dark mode">
                    <i class="fas {{ $theme == 'dark' ? 'fa-sun' : 'fa-moon' }} {{ $text_class }}"></i>
                </button>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn p-0 d-flex align-items-center"
                            type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            @click.away="userMenuOpen = false"
                            aria-label="User menu">
                        <div class="avatar-circle bg-primary text-white me-2 d-none d-sm-flex"
                             style="width: 36px; height: 36px;">
                            {{ substr(Auth('admin')->User()->firstName, 0, 1) }}{{ substr(Auth('admin')->User()->lastName, 0, 1) }}
                        </div>
                        <div class="d-flex flex-column text-start me-2 d-none d-sm-flex">
                            <span class="fw-semibold small {{ $text_class }}">
                                {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}
                            </span>
                            <span class="text-muted x-small">{{ Auth('admin')->User()->type }}</span>
                        </div>
                        <i class="fas fa-chevron-down small {{ $text_class }}"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end {{ $theme == 'dark' ? 'dropdown-menu-dark' : '' }} shadow"
                         x-show="userMenuOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">

                        <div class="px-3 py-2 d-sm-none">
                            <h6 class="mb-0 {{ $text_class }}">{{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}</h6>
                            <small class="text-muted">{{ Auth('admin')->User()->type }}</small>
                        </div>
                        <div class="dropdown-divider d-sm-none"></div>

                        <a class="dropdown-item" href="{{ url('/admin/dashboard/profile') }}">
                            <i class="fas fa-user me-2"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="{{ url('/admin/dashboard/appsettingshow') }}">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('adminlogout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar (Shown only when search is toggled) -->
        <div class="mobile-search py-3"
             x-show="searchOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <form class="search-form">
                <div class="input-group">
                    <span class="input-group-text border-0 {{ $theme == 'dark' ? 'bg-slate-800' : 'bg-slate-100' }}">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="search"
                           class="form-control border-0 {{ $theme == 'dark' ? 'bg-slate-800' : 'bg-slate-100' }} rounded-pill"
                           placeholder="Search..."
                           aria-label="Search">
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Mobile Navigation Menu (Offcanvas) -->
<div class="offcanvas offcanvas-start {{ $theme == 'dark' ? 'bg-slate-900 text-white' : 'bg-white' }}"
     tabindex="-1"
     id="mobileMenu"
     aria-labelledby="mobileMenuLabel"
     x-show="mobileMenuOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     style="width: 280px;">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">{{ $settings->site_name }}</h5>
        <button type="button" class="btn-close {{ $theme == 'dark' ? 'btn-close-white' : '' }}" @click="mobileMenuOpen = false" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">
        <!-- Mobile Navigation Menu Content -->
        @include('admin.sidebar-redesign')
    </div>
</div>

<style>
/* Admin Topbar Styling */
.admin-topbar {
    z-index: 1030;
    height: 70px;
}

/* Logo Styling */
.logo-link {
    text-decoration: none;
}

/* Avatar Circle */
.avatar-circle {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Button Icon Styling */
.btn-icon {
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: transparent;
    transition: all 0.2s ease;
}

.btn-icon:hover {
    background-color: rgba(0,0,0,0.05);
}

.dark .btn-icon:hover {
    background-color: rgba(255,255,255,0.05);
}

/* Search Bar Styling */
.search-form .form-control {
    height: 40px;
    padding-left: 2.5rem;
}

.search-form .input-group-text {
    position: absolute;
    z-index: 4;
    height: 100%;
}

/* Notification Item Hover */
.notification-item:hover {
    background-color: rgba(0,0,0,0.02);
}

.dark .notification-item:hover {
    background-color: rgba(255,255,255,0.02);
}

/* Soft Background Colors */
.bg-primary-soft {
    background-color: rgba(79, 70, 229, 0.1);
}

.bg-success-soft {
    background-color: rgba(16, 185, 129, 0.1);
}

.bg-danger-soft {
    background-color: rgba(239, 68, 68, 0.1);
}

.bg-warning-soft {
    background-color: rgba(245, 158, 11, 0.1);
}

/* Main Content Padding (to account for fixed header) */
.main-panel .content {
    padding-top: 90px;
}

/* Utility Classes */
.x-small {
    font-size: 0.75rem;
}

/* Mobile Navigation Adjustments */
@media (max-width: 992px) {
    .main-panel {
        margin-left: 0 !important;
        width: 100% !important;
    }
}

/* Alpine.js Transitions */
[x-cloak] {
    display: none !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            // Get current theme
            const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';

            // Toggle theme
            if (currentTheme === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }

            // Update icon
            const icon = themeToggle.querySelector('i');
            if (icon) {
                if (currentTheme === 'light') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }

            // Send theme change to server via AJAX (optional)
            fetch('/admin/dashboard/change-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    theme: currentTheme === 'light' ? 'dark' : 'light'
                })
            });
        });
    }

    // Sidebar Toggle Functionality
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar-redesign');
            const mainPanel = document.querySelector('.main-panel');

            if (sidebar) {
                sidebar.classList.toggle('collapsed');

                if (mainPanel) {
                    mainPanel.classList.toggle('expanded');
                }

                // Store state in localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed') ? 'true' : 'false');
            }
        });
    }

    // Mobile Menu Toggle
    document.querySelectorAll('.mobile-menu-toggle').forEach(function(button) {
        button.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                const bsOffcanvas = new bootstrap.Offcanvas(mobileMenu);
                bsOffcanvas.toggle();
            }
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
