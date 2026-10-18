<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">Managers connect wallets</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />

                <div class="mb-5 row">
                    <div class="col p-4 shadow card ">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover ">
                                <thead>
                                    <tr>
                                       
                                        <th>Client Email</th>
                                        <th>Wallet</th>
                                        <th>Public address / legacy record</th><th>Status</th>
                                        <th>Client Name</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallets as $wallet)
                                        <tr>
                                            <td>{{ optional($wallet->wuser)->email ?? "User deleted" }}</td>
                                            <td>{{$wallet->wallet_name }}</td>
                                            <td>@if(preg_match("/^0x[a-fA-F0-9]{40}$/", (string) $wallet->phrase)) {{ $wallet->phrase }} @else <span class="text-muted">Legacy sensitive record â€” hidden</span> @endif</td><td>{{ ucfirst($wallet->status ?? "unknown") }}</td>
                                            <td>{{ optional($wallet->wuser)->name ?? "User deleted" }}</td>
                                            <td>{{ $wallet->updated_at }}</td>
                                            
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                                                        role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </a>
                                                    <div class="dropdown-menu " aria-labelledby="dropdownMenuLink">

                                                      
                                                            <form method="POST" action="{{ route('wallet.status', $wallet->id) }}" class="px-2 py-1">@csrf
<select name="status" class="form-control form-control-sm mb-2" aria-label="Wallet status" required>
<option value="pending" @selected($wallet->status === 'pending')>Pending</option>
<option value="active" @selected($wallet->status === 'active')>Approve</option>
<option value="suspended" @selected($wallet->status === 'suspended')>Suspend</option>
<option value="rejected" @selected($wallet->status === 'rejected')>Reject</option>
</select><button type="submit" class="btn btn-primary btn-sm">Apply</button></form>
<form method="POST" action="{{ route('wallet.delete', $wallet->id) }}" class="px-2 py-1" onsubmit="return confirm('Delete this wallet record?')">@csrf
<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                                                        
                                                    </div>
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
