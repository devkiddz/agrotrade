@php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = "light";
} else {
	$bg = 'dark';
    $text = "light";
}
@endphp
@extends('layouts.app')

@section('content')
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Trading Bots Management</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Bot Trading</a>
                </li>
            </ul>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-robot"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Bots</p>
                                    <h4 class="card-title">{{ $stats['total_bots'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active Bots</p>
                                    <h4 class="card-title">{{ $stats['active_bots'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Investments</p>
                                    <h4 class="card-title">${{ number_format($stats['total_investments'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Profits</p>
                                    <h4 class="card-title">${{ number_format($stats['total_profits'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bots Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Trading Bots</h4>
                            <div class="ml-auto">
                                <button id="bulkTradeBtn" class="btn btn-success btn-round mr-2" onclick="generateBulkTrades()">
                                    <i class="fa fa-chart-line"></i> Generate 20 Trades Per Bot
                                </button>
                                <a href="{{ route('admin.bots.create') }}" class="btn btn-primary btn-round">
                                    <i class="fa fa-plus"></i> Add New Bot
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="botsTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Bot</th>
                                        <th>Market</th>
                                        <th>Investment Range</th>
                                        <th>Success Rate</th>
                                        <th>Investors</th>
                                        <th>Status</th>
                                        <th style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bots as $bot)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm">
                                                    @if($bot->image)
                                                        <img src="{{ asset('storage/app/public/' . $bot->image) }}" alt="Bot" class="avatar-img rounded-circle">
                                                    @else
                                                        <div class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-robot text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <h6 class="fw-bold mb-1">{{ $bot->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($bot->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($bot->bot_type) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                ${{ number_format($bot->min_investment, 0) }} - ${{ number_format($bot->max_investment, 0) }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $bot->success_rate }}%"
                                                 aria-valuenow="{{ $bot->success_rate }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <small>{{ $bot->success_rate }}%</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $bot->user_investments_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            @if($bot->status == 'active')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($bot->status == 'inactive')
                                                <span class="badge badge-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-warning">Maintenance</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.bots.show', $bot) }}"
                                                   class="btn btn-link btn-primary btn-lg"
                                                   data-toggle="tooltip" data-original-title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.bots.edit', $bot) }}"
                                                   class="btn btn-link btn-primary btn-lg"
                                                   data-toggle="tooltip" data-original-title="Edit Bot">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg"
                                                        data-toggle="tooltip" data-original-title="Delete Bot"
                                                        onclick="confirmDelete({{ $bot->id }})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <form id="delete-form-{{ $bot->id }}"
                                                      action="{{ route('admin.bots.destroy', $bot) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px;">
                                                <i class="fas fa-robot fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No trading bots found</h5>
                                                <p class="text-muted">Create your first trading bot to get started</p>
                                                <a href="{{ route('admin.bots.create') }}" class="btn btn-primary">
                                                    <i class="fa fa-plus"></i> Create Trading Bot
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($bots->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bots->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script src="{{ asset('dash/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    $('#botsTable').DataTable({
        "pageLength": 10,
        "searching": true,
        "paging": true,
        "info": true,
        "columnDefs": [
            { "orderable": false, "targets": [6] } // Disable sorting on Actions column
        ]
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

function confirmDelete(botId) {
    swal({
        title: 'Are you sure?',
        text: "This will permanently delete the trading bot and all associated data!",
        type: 'warning',
        buttons: {
            confirm: {
                text: 'Yes, delete it!',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            document.getElementById('delete-form-' + botId).submit();
        }
    });
}

function generateBulkTrades() {
    const btn = document.getElementById('bulkTradeBtn');
    const originalText = btn.innerHTML;

    swal({
        title: 'Generate Bulk Trades?',
        text: "This will generate 20 trades for each active bot investment. Are you sure?",
        type: 'info',
        buttons: {
            confirm: {
                text: 'Yes, generate trades!',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((confirmed) => {
        if (confirmed) {
            // Show loading state
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generating Trades...';
            btn.disabled = true;

            // Make the request
            fetch('/cron/bulk-bot-trades/20', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;

                if (data.success) {
                    swal({
                        title: 'Success!',
                        text: `Generated ${data.total_trades_created} trades across ${data.investments_processed} bot investments`,
                        type: 'success',
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    }).then(() => {
                        // Optionally reload the page to see updated statistics
                        location.reload();
                    });
                } else {
                    swal({
                        title: 'Error!',
                        text: data.message || 'Failed to generate trades',
                        type: 'error',
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }
                    });
                }
            })
            .catch(error => {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;

                swal({
                    title: 'Error!',
                    text: 'Network error occurred while generating trades',
                    type: 'error',
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    }
                });
                console.error('Error:', error);
            });
        }
    });
}
</script>
        </div>
    </div>
</div>
@endsection
