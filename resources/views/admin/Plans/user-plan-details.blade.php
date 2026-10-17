@extends('layouts.app')
@section('title', 'Plan Investment Details')

@section('content')
<div class="mt-2">
    @include('admin.atlantis.layout.alert')
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Investment Details</h4>
                <a href="{{ route('admin.user-plans.index') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to User Plans
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Investment Details -->
                    <div class="col-md-7">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Investment ID</th>
                                    <td><strong>{{ $userPlan->id }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Investor</th>
                                    <td>
                                        @if($userPlan->user)
                                        <a href="{{ route('viewuser', $userPlan->user_id) }}" target="_blank">
                                            <strong>{{ $userPlan->user->name }}</strong> ({{ $userPlan->user->email }})
                                        </a>
                                        @else
                                        <span class="text-danger">User not found</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Plan Name</th>
                                    <td>{{ $userPlan->plan ? $userPlan->plan->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Investment Amount</th>
                                    <td>{{ $settings->currency }}{{ number_format($userPlan->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>ROI</th>
                                    <td>
                                        {{ $userPlan->plan ? $userPlan->plan->roi_percentage : 0 }}% per
                                        {{ $userPlan->plan ? $userPlan->plan->roi_interval : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($userPlan->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($userPlan->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                        @elseif($userPlan->status == 'completed')
                                        <span class="badge bg-info">Completed</span>
                                        @elseif($userPlan->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $userPlan->start_date ? $userPlan->start_date->format('Y-m-d H:i:s') : 'Not started yet' }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $userPlan->end_date ? $userPlan->end_date->format('Y-m-d H:i:s') : 'Not determined yet' }}</td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $userPlan->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Last ROI Payment</th>
                                    <td>{{ $userPlan->last_roi_date ? $userPlan->last_roi_date->format('Y-m-d H:i:s') : 'No ROI payment yet' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Payouts</th>
                                    <td>{{ $settings->currency }}{{ number_format($userPlan->total_paid_amount, 2) }}</td>
                                </tr>
                                @if($userPlan->status == 'cancelled')
                                <tr>
                                    <th>Cancellation Reason</th>
                                    <td>{{ $userPlan->cancellation_reason ?: 'No reason provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Cancelled At</th>
                                    <td>{{ $userPlan->cancelled_at ? $userPlan->cancelled_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                                @endif
                                @if($userPlan->status == 'completed')
                                <tr>
                                    <th>Completed At</th>
                                    <td>{{ $userPlan->completed_at ? $userPlan->completed_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Actions Panel -->
                    <div class="col-md-5">
                        @if($userPlan->status == 'pending')
                        <div class="card bg-light mb-3">
                            <div class="card-header">Approve Investment</div>
                            <div class="card-body">
                                <p>This investment is waiting for your approval.</p>
                                <form action="{{ route('admin.user-plans.approve', $userPlan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Are you sure you want to approve this investment?')">
                                        <i class="fa fa-check"></i> Approve Investment
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                        @if(in_array($userPlan->status, ['pending', 'active']))
                        <div class="card bg-light mb-3">
                            <div class="card-header">Cancel Investment</div>
                            <div class="card-body">
                                <form action="{{ route('admin.user-plans.cancel', $userPlan) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cancellation_reason">Cancellation Reason</label>
                                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to cancel this investment?')">
                                        <i class="fa fa-times"></i> Cancel Investment
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                        @if($userPlan->status == 'active')
                        <div class="card bg-light mb-3">
                            <div class="card-header">Add Manual Payout</div>
                            <div class="card-body">
                                <form action="{{ route('admin.user-plans.payout', $userPlan) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ $settings->currency }}</span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notes">Notes (Optional)</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-money-bill"></i> Add Manual Payout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payout History -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Payout History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($userPlan->payouts) > 0)
                                @foreach($userPlan->payouts as $payout)
                                <tr>
                                    <td>{{ $payout->id }}</td>
                                    <td>{{ $settings->currency }}{{ number_format($payout->amount, 2) }}</td>
                                    <td>
                                        @if($payout->payout_type == 'roi')
                                            <span class="badge bg-info">ROI Payment</span>
                                        @elseif($payout->payout_type == 'manual')
                                            <span class="badge bg-warning">Manual Payment</span>
                                        @elseif($payout->payout_type == 'completion')
                                            <span class="badge bg-success">Completion Bonus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $payout->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payout->notes ?: 'N/A' }}</td>
                                    <td>{{ $payout->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No payout history found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
