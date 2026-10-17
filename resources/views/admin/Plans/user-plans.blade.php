@extends('layouts.app')
@section('title', 'User Investment Plans')

@section('styles')
<link href="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="mt-2">
    @include('admin.atlantis.layout.alert')
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">User Investment Plans</h4>
                <div>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-list"></i> Manage Plans
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form action="{{ route('admin.user-plans.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Filter by Status</label>
                                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_id">Filter by User ID</label>
                                <input type="number" class="form-control" id="user_id" name="user_id" value="{{ request('user_id') }}" placeholder="Enter User ID">
                            </div>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('admin.user-plans.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>ROI</th>
                                <th>Total Paid</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPlans as $userPlan)
                            <tr>
                                <td>{{ $userPlan->id }}</td>
                                <td>
                                    @if($userPlan->user)
                                    <a href="{{ route('viewuser', $userPlan->user_id) }}" target="_blank">
                                        {{ $userPlan->user->name }}
                                    </a>
                                    @else
                                    <span class="text-danger">User not found</span>
                                    @endif
                                </td>
                                <td>{{ $userPlan->plan ? $userPlan->plan->name : 'N/A' }}</td>
                                <td>{{ $settings->currency }}{{ number_format($userPlan->amount, 2) }}</td>
                                <td>{{ $userPlan->plan ? $userPlan->plan->roi_percentage : 0 }}% per {{ $userPlan->plan ? $userPlan->plan->roi_interval : 'N/A' }}</td>
                                <td>{{ $settings->currency }}{{ number_format($userPlan->total_paid_amount, 2) }}</td>
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
                                <td>{{ $userPlan->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.user-plans.show', $userPlan) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $userPlans->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 50,
            "searching": false,
            "paging": false,
            "info": false
        });
    });
</script>
@endsection
