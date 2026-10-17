@extends('layouts.app')
@section('title', 'Notifications')


@section('content')
@include('admin.topmenu')
    @include('admin.sidebar')
<div class="mt-2 mb-4 d-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    <a href="{{ route('admin.markallasread') }}" class="btn btn-primary">Mark All as Read</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if(count($notifications) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                    <tr class="{{ $notification->is_read ? '' : 'table-light font-weight-bold' }}">
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ $notification->message }}</td>
                                        <td>
                                            <span class="badge badge-{{ $notification->type === 'warning' ? 'warning' : ($notification->type === 'success' ? 'success' : ($notification->type === 'danger' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($notification->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if(!$notification->is_read)
                                                <a href="{{ route('admin.markasread', $notification->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-check"></i> Mark as Read
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.deletenotification', $notification->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-bell-slash fa-3x text-muted"></i>
                        <p class="mt-3">You have no notifications</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
