@extends('layouts.app')
@section('title', 'Send Message to User')

@section('content')
@include('admin.topmenu')
    @include('admin.sidebar')
<div class="mt-2 mb-4">
    <h1 class="h3 mb-0 text-gray-800">Send Message to User</h1>
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

                <form method="POST" action="{{ route('admin.send.message') }}">
                    @csrf
                    <div class="form-group">
                        <label>Select User</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Select a user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Message Type</label>
                        <select name="type" class="form-control">
                            <option value="info">Information</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                            <option value="danger">Important</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
