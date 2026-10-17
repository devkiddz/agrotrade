@extends('layouts.app')
@section('title', 'Edit Trade')
@section('content')

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Trade</h4>
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
                        <a href="{{ route('admin.dashboard') }}">background</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}">Back</a>
                    </li>
                </ul>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6><i class="fas fa-exclamation-triangle mr-2"></i>Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Edit Trade Form -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">
                                    <i class="fas fa-edit mr-2"></i>Edit Trade #{{ $trade->id }}
                                </h4>
                                <div class="ml-auto">
                                    <a href="{{ route('admin.trades.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left mr-1"></i>Back to Trades
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Trade User Info -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-user mr-2"></i>Trade Owner Information</h6>
                                        <strong>Name:</strong> {{ $trade->user->name ?? 'N/A' }}<br>
                                        <strong>Email:</strong> {{ $trade->user->email ?? 'N/A' }}<br>
                                        <strong>Created:</strong> {{ $trade->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.trades.update', $trade->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="assets">Asset <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('assets') is-invalid @enderror"
                                                   id="assets" name="assets" value="{{ old('assets', $trade->assets) }}" required>
                                            @error('assets')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symbol">Symbol</label>
                                            <input type="text" class="form-control @error('symbol') is-invalid @enderror"
                                                   id="symbol" name="symbol" value="{{ old('symbol', $trade->symbol) }}"
                                                   placeholder="e.g., BTC/USD">
                                            @error('symbol')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Trade Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="Buy" {{ old('type', $trade->type) == 'Buy' ? 'selected' : '' }}>Buy</option>
                                                <option value="Sell" {{ old('type', $trade->type) == 'Sell' ? 'selected' : '' }}>Sell</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount">Amount ($) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                                   id="amount" name="amount" value="{{ old('amount', $trade->amount) }}"
                                                   step="0.01" min="0" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="leverage">Leverage</label>
                                            <input type="number" class="form-control @error('leverage') is-invalid @enderror"
                                                   id="leverage" name="leverage" value="{{ old('leverage', $trade->leverage) }}"
                                                   min="1" max="1000">
                                            <small class="form-text text-muted">Leave empty for no leverage</small>
                                            @error('leverage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profit_earned">Profit/Loss ($)</label>
                                            <input type="number" class="form-control @error('profit_earned') is-invalid @enderror"
                                                   id="profit_earned" name="profit_earned" value="{{ old('profit_earned', $trade->profit_earned) }}"
                                                   step="0.01">
                                            <small class="form-text text-muted">Positive for profit, negative for loss</small>
                                            @error('profit_earned')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="active">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('active') is-invalid @enderror" id="active" name="active" required>
                                                <option value="yes" {{ old('active', $trade->active) == 'yes' ? 'selected' : '' }}>Active</option>
                                                <option value="expired" {{ old('active', $trade->active) == 'expired' ? 'selected' : '' }}>Expired</option>
                                            </select>
                                            @error('active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expire_date">Expiry Date</label>
                                            <input type="datetime-local" class="form-control @error('expire_date') is-invalid @enderror"
                                                   id="expire_date" name="expire_date"
                                                   value="{{ old('expire_date', $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('Y-m-d\TH:i') : '') }}">
                                            @error('expire_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <a href="{{ route('admin.trades.index') }}" class="btn btn-secondary mr-2">
                                                <i class="fas fa-times mr-1"></i>Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i>Update Trade
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="fas fa-bolt mr-2"></i>Quick Actions
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-block"
                                            onclick="showAddProfitForm({{ $trade->id }})">
                                        <i class="fas fa-plus mr-2"></i>Add Profit to User ROI
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-block"
                                            onclick="deleteTrade({{ $trade->id }})">
                                        <i class="fas fa-trash mr-2"></i>Delete This Trade
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Profit Modal -->
<div class="modal fade" id="addProfitModal" tabindex="-1" role="dialog" aria-labelledby="addProfitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProfitModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Add Profit to User ROI
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProfitForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        This will add the specified amount to both the trade's profit_earned and the user's ROI.
                    </div>
                    <div class="form-group">
                        <label for="profit_amount">Profit Amount ($)</label>
                        <input type="number" class="form-control" id="profit_amount" name="profit_amount"
                               step="0.01" required placeholder="Enter amount to add">
                        <small class="form-text text-muted">Use positive numbers for profit, negative for loss</small>
                    </div>
                    <div class="form-group">
                        <label for="profit_note">Note (Optional)</label>
                        <textarea class="form-control" id="profit_note" name="note" rows="3"
                                  placeholder="Add a note about this profit adjustment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i>Add Profit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
/* Sidebar Toggle Styles */
.sidebar {
    transition: all 0.3s ease;
}

.main-panel {
    transition: all 0.3s ease;
}

/* When sidebar is hidden */
body.sidebar-hide .sidebar {
    transform: translateX(-100%);
}

body.sidebar-hide .main-panel {
    margin-left: 0 !important;
    width: 100% !important;
}

/* Mobile sidebar overlay */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

/* Responsive behavior */
@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        left: -270px;
        z-index: 1050;
    }

    .sidebar.sidebar-show {
        left: 0;
    }

    .main-panel {
        margin-left: 0 !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Atlantis Theme Sidebar Toggle Functionality
    $('.toggle-sidebar').on('click', function(e) {
        e.preventDefault();
        console.log('Sidebar toggle clicked');

        // Toggle sidebar classes
        $('body').toggleClass('sidebar-hide');
        $('.sidebar').toggleClass('sidebar-show');
        $('.main-panel').toggleClass('full-height');

        // Check if sidebar is now hidden/shown
        if ($('body').hasClass('sidebar-hide')) {
            console.log('Sidebar hidden');
        } else {
            console.log('Sidebar shown');
        }
    });

    // Mobile sidebar toggle (sidenav-toggler)
    $('.sidenav-toggler').on('click', function(e) {
        e.preventDefault();
        console.log('Mobile sidebar toggle clicked');

        // For mobile, use different classes
        $('.sidebar').toggleClass('sidebar-show');
        $('body').toggleClass('sidebar-show');

        // Add overlay for mobile
        if ($('.sidebar').hasClass('sidebar-show')) {
            if (!$('.sidebar-overlay').length) {
                $('<div class="sidebar-overlay"></div>').appendTo('body');
            }
        } else {
            $('.sidebar-overlay').remove();
        }
    });

    // Close sidebar when clicking overlay (mobile)
    $(document).on('click', '.sidebar-overlay', function() {
        $('.sidebar').removeClass('sidebar-show');
        $('body').removeClass('sidebar-show');
        $(this).remove();
    });

    // Make functions globally available
    window.showAddProfitForm = showAddProfitForm;
    window.deleteTrade = deleteTrade;

    console.log('Functions assigned to window:', {
        showAddProfitForm: typeof window.showAddProfitForm,
        deleteTrade: typeof window.deleteTrade
    });
});// Simple function to show add profit modal
function showAddProfitForm(tradeId) {
    console.log('Opening add profit form for trade ID:', tradeId);

    // Set form action
    var profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
    $('#addProfitForm').attr('action', profitUrl);

    // Clear form
    $('#profit_amount').val('');
    $('#profit_note').val('');

    // Show the modal
    $('#addProfitModal').modal('show');
}

// Delete Trade Function
function deleteTrade(tradeId) {
    console.log('Delete Trade ID:', tradeId);

    var deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
    console.log('Delete URL:', deleteUrl);

    swal({
        title: "Delete Trade?",
        text: "This action cannot be undone. The trade record will be permanently deleted.",
        type: "warning",
        buttons: {
            cancel: {
                visible: true,
                text: "Cancel",
                className: "btn btn-secondary"
            },
            confirm: {
                text: "Yes, delete it!",
                className: "btn btn-danger"
            }
        }
    }).then((willDelete) => {
        if (willDelete) {
            console.log('Deleting trade with URL:', deleteUrl);

            // Create and submit form with proper Laravel URL
            var form = $('<form method="POST" action="' + deleteUrl + '">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '</form>');
            $('body').append(form);
            form.submit();
        }
    });
}
</script>

<style>
/* Sidebar Toggle Styles */
.sidebar {
    transition: all 0.3s ease;
}

.main-panel {
    transition: all 0.3s ease;
}

/* When sidebar is hidden */
body.sidebar-hide .sidebar {
    transform: translateX(-100%);
}

body.sidebar-hide .main-panel {
    margin-left: 0 !important;
    width: 100% !important;
}

/* Mobile sidebar overlay */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

/* Responsive behavior */
@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        left: -270px;
        z-index: 1050;
    }

    .sidebar.sidebar-show {
        left: 0;
    }

    .main-panel {
        margin-left: 0 !important;
    }
}
</style>
@endsection
