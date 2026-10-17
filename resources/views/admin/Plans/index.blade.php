@extends('layouts.app')
@section('title', 'Investment Plans')

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
                <h4 class="card-title">Investment Plans</h4>
                <div>
                    <a href="{{ route('admin.plans.categories') }}" class="btn btn-primary btn-sm mr-1">
                        <i class="fa fa-layer-group"></i> Plan Categories
                    </a>
                    <a href="{{ route('admin.plans.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add New Plan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price Range</th>
                                <th>ROI</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                            <tr>
                                <td>
                                    @if($plan->icon)
                                    <img src="{{ asset('storage/' . $plan->icon) }}" alt="{{ $plan->name }}" style="width: 30px; height: 30px; margin-right: 5px;">
                                    @endif
                                    {{ $plan->name }}
                                </td>
                                <td>{{ $plan->category ? $plan->category->name : 'No Category' }}</td>
                                <td>{{ $settings->currency }}{{ number_format($plan->min_amount, 2) }} - {{ $settings->currency }}{{ number_format($plan->max_amount, 2) }}</td>
                                <td>{{ $plan->roi_percentage }}% per {{ $plan->roi_interval }}</td>
                                <td>{{ $plan->duration }} {{ $plan->duration_unit }}</td>
                                <td>
                                    <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $plan->is_active ? 'btn-success' : 'btn-danger' }}">
                                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    {!! $plan->is_featured ? '<span class="badge bg-success"><i class="fa fa-star"></i> Featured</span>' : '<span class="badge bg-secondary">No</span>' !!}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            "order": [[ 0, "asc" ]],
            "pageLength": 25
        });
    });
</script>
@endsection
