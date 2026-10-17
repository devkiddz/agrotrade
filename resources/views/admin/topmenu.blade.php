<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bgmenu = 'blue';
    $bg = 'light';
    $text = 'dark';
} else {
    $bgmenu = 'dark';
    $bg = 'dark';
    $text = 'light';
}

?>
<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="{{ $bgmenu }}">
        <a href="/" class="logo" style="font-size: 15px; color:#fff;">
            {{ $settings->site_name }}
        </a>
        <button class="ml-auto navbar-toggler sidenav-toggler" type="button" data-toggle="collapse" data-target="collapse"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu "></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical "></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu "></i>
            </button>
        </div>

    </div>
    <!-- End Logo Header -->




    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="{{ $bgmenu }}">

        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <a href="{{ route('manageusers') }}">
                    <form class="navbar-left navbar-form nav-search mr-md-3" action="javascript:void(0)">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="pr-1 btn btn-search">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input type="text" placeholder="Manage users"
                                class="form-control text-{{ $text }} ">
                        </div>
                    </form>
                </a>

                <script>
                    document.getElementById('searchform').addEventListener('subit'
                        searchuser);

                    function searchuser() {
                        console.log('ddj');
                        let url = "{{ route('manageusers') }}";
                        window.location.href = url;
                    }
                </script>
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                {{-- <li>
                    <form action="javascript:void(0)" method="post" id="styleform">
                        <div class="form-group">
                            <label class="style_switch">
                                <input name="style" id="style" type="checkbox" value="true" class="modes">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        @if (Auth('admin')->User()->dashboard_style == 'dark')
                        <script>document.getElementById("style").checked= true;</script>
                         @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>

                </li> --}}

                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown hidden-caret mr-3">
                    <a class="nav-link position-relative" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-bell text-white"></i>
                        @php
                            try {
                                // First try to get notifications specifically for admin
                                $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->where('is_read', 0)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

                                // If admin_id column doesn't exist, try user_id with admin check
                                if($notifications->isEmpty()) {
                                    $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                        ->where('type', 'admin')
                                        ->where('is_read', 0)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                }

                                // If still empty, try Laravel's polymorphic notifications
                                if($notifications->isEmpty()) {
                                    $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                        ->where('notifiable_type', 'App\Models\Admin')
                                        ->whereNull('read_at')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                }

                                $notificationCount = $notifications->count();
                            } catch (\Exception $e) {
                                // Log the error for debugging
                                \Log::error('Admin notification fetch error: ' . $e->getMessage());
                                $notifications = collect([]);
                                $notificationCount = 0;
                            }
                        @endphp
                        @if($notificationCount > 0)
                            <span class="notification-badge">
                                {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Modern Tailwind-styled Notification Dropdown -->
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown animated fadeIn p-0" style="width: 380px; max-height: 500px; overflow-y: auto;">
                        <!-- Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-t-lg">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold d-flex align-items-center">
                                    <i class="fas fa-bell mr-2"></i> Notifications
                                    @if($notificationCount > 0)
                                        <span class="ml-2 badge badge-light">{{ $notificationCount }}</span>
                                    @endif
                                </h6>
                                @if($notificationCount > 0)
                                    <a href="{{ route('admin.markallasread') }}" class="text-white small mark-all-read">Mark all as read</a>
                                @endif
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="notification-list p-3">
                            @forelse($notifications as $notification)
                                @php
                                    $type = $notification->data['type'] ?? $notification->type ?? 'info';
                                    $title = $notification->data['title'] ?? $notification->title ?? 'Notification';
                                    $message = Str::limit($notification->data['message'] ?? $notification->message ?? 'New notification received', 60);
                                    $icon = match($type) {
                                        'success' => 'check-circle',
                                        'warning' => 'exclamation-triangle',
                                        'danger' => 'exclamation-circle',
                                        default => 'bell',
                                    };
                                    $bgColor = match($type) {
                                        'success' => 'bg-green-100 text-green-600',
                                        'warning' => 'bg-yellow-100 text-yellow-600',
                                        'danger' => 'bg-red-100 text-red-600',
                                        default => 'bg-blue-100 text-blue-600',
                                    };
                                    // Convert Tailwind classes to Bootstrap equivalent
                                    $bootstrapBg = match($type) {
                                        'success' => 'bg-success',
                                        'warning' => 'bg-warning',
                                        'danger' => 'bg-danger',
                                        default => 'bg-info',
                                    };
                                @endphp

                                <div class="notification-item mb-3 p-3 bg-white rounded-lg shadow-sm border border-gray-200" data-id="{{ $notification->id }}">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 {{ $bootstrapBg }} p-2 mr-3 rounded-circle text-white">
                                            <i class="fas fa-{{ $icon }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('admin.notifications.show', $notification->id) }}" class="text-decoration-none">
                                                <h6 class="font-weight-bold mb-1">{{ $title }}</h6>
                                                <p class="small text-muted mb-1">{{ $message }}</p>
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="ml-2">
                                            <button class="btn btn-sm btn-outline-secondary mark-as-read" title="Mark as read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <!-- Empty Notifications -->
                                <div class="text-center py-4">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-bell-slash fa-3x"></i>
                                    </div>
                                    <h6 class="font-weight-bold">No new notifications</h6>
                                    <p class="small text-muted">You're all caught up!</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        @if($notificationCount > 0)
                            <div class="p-3 bg-light border-top">
                                <a href="{{ route('admin.notifications') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-list mr-2"></i> View All Notifications
                                </a>
                            </div>
                        @endif
                    </div>
                </li>

                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="text-white fas fa-user"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="{{ url('admin/dashboard/adminprofile') }}">Account
                                    Settings</a>
                                <a class="dropdown-item" href="{{ url('admin/dashboard/adminchangepassword') }}">Change
                                    Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('adminlogout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logoutform').submit();">
                                    Logout
                                </a>
                                <form id="logoutform" action="{{ route('adminlogout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>


<script type="text/javascript">
    //create investment
    $("#styleform").on('change', function() {
        $.ajax({
            url: "{{ url('admin/dashboard/changestyle') }}",
            type: 'POST',
            data: $("#styleform").serialize(),
            success: function(data) {
                location.reload(true);
            },
            error: function(data) {
                console.log('Something went wrong');
            },

        });
    });
</script>

<style>
/* Notification Badge Style */
.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 3px 7px;
    font-size: 0.65rem;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* Fix Tailwind gradient classes in Bootstrap */
.bg-gradient-to-r {
    background: linear-gradient(to right, #2563eb, #7c3aed);
}

.from-blue-600 {
    --tw-gradient-from: #2563eb;
}

.to-purple-600 {
    --tw-gradient-to: #7c3aed;
}

/* Custom notification styles */
.notification-dropdown {
    border: none !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    border-radius: 0.5rem !important;
}

.rounded-t-lg {
    border-top-left-radius: 0.5rem !important;
    border-top-right-radius: 0.5rem !important;
}

.notification-item {
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.notification-item:hover {
    background-color: rgba(0,123,255,0.05) !important;
    border-left-color: #007bff !important;
    transform: translateX(2px);
}

/* Notification links styling */
.notification-item a {
    color: inherit;
}

.notification-item a:hover {
    text-decoration: none;
}

/* Icon backgrounds */
.bg-green-100 { background-color: rgba(209, 250, 229, 1) !important; }
.bg-yellow-100 { background-color: rgba(254, 249, 195, 1) !important; }
.bg-red-100 { background-color: rgba(254, 226, 226, 1) !important; }
.bg-blue-100 { background-color: rgba(219, 234, 254, 1) !important; }

.text-green-600 { color: rgba(5, 150, 105, 1) !important; }
.text-yellow-600 { color: rgba(202, 138, 4, 1) !important; }
.text-red-600 { color: rgba(220, 38, 38, 1) !important; }
.text-blue-600 { color: rgba(37, 99, 235, 1) !important; }

/* Other Tailwind utility classes */
.px-4 { padding-left: 1rem !important; padding-right: 1rem !important; }
.py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
.mb-3 { margin-bottom: 0.75rem !important; }
</style>

<script>
$(document).ready(function() {
    // Mark all notifications as read
    $(document).on('click', '.mark-all-read', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ url("/admin/notifications/mark-all-read") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                // Remove notification badge
                $('.notification-badge').fadeOut();

                // Update notification list
                $('.notification-list').html(`
                    <div class="text-center py-4">
                        <div class="text-muted mb-3">
                            <i class="fas fa-bell-slash fa-3x"></i>
                        </div>
                        <h6 class="font-weight-bold">No new notifications</h6>
                        <p class="small text-muted">You're all caught up!</p>
                    </div>
                `);

                // Hide footer
                $('.dropdown-menu .bg-light').fadeOut();

                // Show success message
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'All notifications marked as read!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error marking notifications as read:', error);
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to mark notifications as read. Please try again.',
                    });
                }
            }
        });
    });

    // Mark individual notification as read when clicked
    $(document).on('click', '.mark-as-read', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $notificationItem = $(this).closest('.notification-item');
        const notificationId = $notificationItem.data('id');

        if(notificationId) {
            $.ajax({
                url: '{{ url("/admin/notifications/mark-as-read") }}/' + notificationId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Remove this notification from the list
                    $notificationItem.fadeOut(300, function() {
                        $(this).remove();

                        // Update badge count
                        const $badge = $('.notification-badge');
                        const currentCount = parseInt($badge.text()) || 0;
                        const newCount = Math.max(0, currentCount - 1);

                        if(newCount === 0) {
                            $badge.fadeOut();
                            $('.notification-list').html(`
                                <div class="text-center py-4">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-bell-slash fa-3x"></i>
                                    </div>
                                    <h6 class="font-weight-bold">No new notifications</h6>
                                    <p class="small text-muted">You're all caught up!</p>
                                </div>
                            `);
                            $('.dropdown-menu .bg-light').fadeOut();
                        } else {
                            $badge.text(newCount > 99 ? '99+' : newCount);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error marking notification as read:', error);
                }
            });
        }
    });

    // Auto-refresh notifications every 30 seconds
    setInterval(function() {
        refreshNotificationCount();
    }, 30000);

    function refreshNotificationCount() {
        $.ajax({
            url: '{{ url("/admin/notifications/count") }}',
            type: 'GET',
            success: function(response) {
                const count = response.count || 0;
                const $badge = $('.notification-badge');

                if(count > 0) {
                    if($badge.length === 0) {
                        // Create badge if it doesn't exist
                        $('<span class="notification-badge">' + (count > 99 ? '99+' : count) + '</span>')
                            .appendTo('.nav-link:has(.fa-bell)');
                    } else {
                        $badge.text(count > 99 ? '99+' : count).show();
                    }
                } else {
                    $badge.hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error refreshing notification count:', error);
            }
        });
    }
});
</script>
