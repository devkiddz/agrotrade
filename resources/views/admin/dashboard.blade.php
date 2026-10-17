<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bg = 'light';
    $text = 'dark';
    $gradient = 'primary';
} else {
    $bg = 'dark';
    $text = 'light';
    $gradient = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <!-- Modern Header Section -->
            <div class="panel-header bg-{{ $gradient }}-gradient">
                <div class="py-5 page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div>
                            <h2 class="pb-2 text-white fw-bold">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </h2>
                            <h5 class="mb-2 text-white op-7">
                                <i class="fas fa-user-shield me-2"></i>Welcome back, {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}!
                            </h5>
                            <p class="text-white op-5 mb-0">
                                <i class="far fa-clock me-1"></i>{{ date('l, F j, Y') }} • <span id="current-time"></span>
                            </p>
                        </div>
                        @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                            <div class="py-2 ml-md-auto py-md-0">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('mdeposits') }}" class="btn btn-success btn-lg shadow-sm">
                                        <i class="fas fa-arrow-down me-2"></i>Deposits
                                    </a>
                                    <a href="{{ route('mwithdrawals') }}" class="btn btn-danger btn-lg shadow-sm">
                                        <i class="fas fa-arrow-up me-2"></i>Withdrawals
                                    </a>
                                    <a href="{{ route('manageusers') }}" class="btn btn-info btn-lg shadow-sm">
                                        <i class="fas fa-users me-2"></i>Users
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <div class="page-inner mt--5">
                <!-- Enhanced Statistics Cards -->
                <div class="row g-4 mb-4">
                    <!-- Total Deposit Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-success text-white">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Total Deposits</p>
                                        <h4 class="fw-bold mb-0 text-dark">
                                            @foreach ($total_deposited as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </h4>
                                        <small class="text-success">
                                            <i class="fas fa-arrow-up me-1"></i>All time
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Deposits Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-warning text-white">
                                            <i class="fas fa-hourglass-half"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Pending Deposits</p>
                                        <h4 class="fw-bold mb-0 text-dark">
                                            @foreach ($pending_deposited as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </h4>
                                        <small class="text-warning">
                                            <i class="fas fa-clock me-1"></i>Awaiting approval
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Withdrawals Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-danger text-white">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Total Withdrawals</p>
                                        <h4 class="fw-bold mb-0 text-dark">
                                            @foreach ($total_withdrawn as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </h4>
                                        <small class="text-danger">
                                            <i class="fas fa-arrow-down me-1"></i>All time
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Withdrawals Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-info text-white">
                                            <i class="fas fa-pause-circle"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Pending Withdrawals</p>
                                        <h4 class="fw-bold mb-0 text-dark">
                                            @foreach ($pending_withdrawn as $deposited)
                                                @if (!empty($deposited->count))
                                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                                @else
                                                    {{ $settings->currency }}0.00
                                                @endif
                                            @endforeach
                                        </h4>
                                        <small class="text-info">
                                            <i class="fas fa-clock me-1"></i>Processing
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Statistics Section -->
                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-primary text-white">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Total Users</p>
                                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($user_count) }}</h4>
                                        <small class="text-primary">
                                            <i class="fas fa-user-plus me-1"></i>Registered
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-success text-white">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Active Users</p>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $activeusers }}</h4>
                                        <small class="text-success">
                                            <i class="fas fa-circle me-1"></i>Online
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-danger text-white">
                                            <i class="fas fa-user-times"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Blocked Users</p>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $blockeusers }}</h4>
                                        <small class="text-danger">
                                            <i class="fas fa-ban me-1"></i>Suspended
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card modern-stat-card border-0 shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="stat-icon bg-warning text-white">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1 fw-medium">Investment Plans</p>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $plans }}</h4>
                                        <small class="text-warning">
                                            <i class="fas fa-layer-group me-1"></i>Available
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Chart Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-white border-0 py-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark">
                                            <i class="fas fa-chart-bar me-2 text-primary"></i>System Statistics
                                        </h5>
                                        <p class="text-muted mb-0">Financial overview and transaction analytics</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-calendar me-2"></i>This Month
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Today</a></li>
                                            <li><a class="dropdown-item" href="#">This Week</a></li>
                                            <li><a class="dropdown-item" href="#">This Month</a></li>
                                            <li><a class="dropdown-item" href="#">This Year</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="chart-container position-relative">
                                    <canvas id="myChart" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart Script -->
    <script>
        // Real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        updateTime();
        setInterval(updateTime, 1000);

        // Enhanced Chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Deposits', 'Pending Deposits', 'Withdrawals', 'Pending Withdrawals', 'Total Transactions'],
                datasets: [{
                    label: "Amount in {{ $settings->currency }}",
                    data: [
                        "{{ $chart_pdepsoit }}",
                        "{{ $chart_pendepsoit }}",
                        "{{ $chart_pwithdraw }}",
                        "{{ $chart_pendwithdraw }}",
                        "{{ $chart_trans }}"
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(23, 162, 184, 1)',
                        'rgba(108, 117, 125, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': {{ $settings->currency }}' +
                                       new Intl.NumberFormat().format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#6c757d',
                            callback: function(value) {
                                return '{{ $settings->currency }}' + new Intl.NumberFormat().format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            },
                            color: '#495057'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    </script>

    <style>
        .modern-stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .modern-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .modern-stat-card:hover .stat-icon {
            transform: scale(1.1);
        }

        .chart-container {
            height: 400px;
        }

        .btn-group .btn {
            border-radius: 8px !important;
            margin: 0 2px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
    </style>
@endsection
