<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <x-danger-alert />
                <x-success-alert />
                <!-- Beginning of  Dashboard Stats  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-3 card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <h1 class="d-inline text-primary">{{ $user->name }}</h1><span></span>
                                        <div class="d-inline">
                                            <div class="float-right btn-group">
                                                <a class="btn btn-primary btn-sm" href="{{ route('manageusers') }}"> <i
                                                        class="fa fa-arrow-left"></i> back</a> &nbsp;
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" data-display="static" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-lg-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('loginactivity', $user->id) }}">Login Activity</a>
                                                    @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                                                        <a class="dropdown-item text-success"
                                                            href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}">
                                                            <i class="fas fa-unlock mr-2"></i>Unban / Enable Account
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}">
                                                            <i class="fas fa-ban mr-2"></i>Ban / Disable Account
                                                        </a>
                                                    @endif
                                                    <!--@if ($user->tradetype == 'Profit')-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ url('admin/dashboard/usertrademode') }}/{{ $user->id }}/off">Turn-->
                                                    <!--        trade mode to Loss</a>-->
                                                    <!--@else-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ url('admin/dashboard/usertrademode') }}/{{ $user->id }}/on">Turn trade mode to Profit</a>-->
                                                    <!--@endif-->
                                                    @if ($user->email_verified_at)
                                                    @else
                                                        <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}"
                                                            class="dropdown-item">Verify Email</a>
                                                    @endif
                                                    <a href="#" data-toggle="modal" data-target="#topupModal"
                                                        class="dropdown-item">Credit/Debit</a>


                                                        @if ($user->signal_status == 'on')
                                                        <a href="#" data-toggle="modal" data-target="#ugpradeSignalStatus"
                                                        class="dropdown-item">Turn off Upgrade Signal status</a>
                                                        @else
                                                        <a href="#" data-toggle="modal" data-target="#ugpradeSignalStatus"
                                                        class="dropdown-item">Turn on Upgrade Signal status</a>
                                                        @endif


                                                        @if ($user->plan_status=='on')
                                                        <a href="#" data-toggle="modal" data-target="#ugpradePlanStatus"
                                                        class="dropdown-item">Turn off Upgrade Plan status</a>
                                                        @else
                                                        <a href="#" data-toggle="modal" data-target="#ugpradePlanStatus"
                                                        class="dropdown-item">Turn on Upgrade Plan status</a>
                                                        @endif

                                                         {{-- <a href="#" data-toggle="modal" data-target="#userTax"
                                                        class="dropdown-item">On/Off Tax </a> --}}
                                                        <a href="#" data-toggle="modal" data-target="#TradingModal"
                                                        class="dropdown-item">Trade for this client</a>
                                                        @if($user->signals !=Null)
                                                        <a href="#" data-toggle="modal" data-target="#Signal"
                                                        class="dropdown-item"> Create Signal for this Client </a>
                                            @endif

                                                        <a href="#" data-toggle="modal" data-target="#Nostrades"
                                                        class="dropdown-item">Set Number of trade for Withdrawal </a>

                                                        <a href="#" data-toggle="modal" data-target="#Planhistory"
                                                        class="dropdown-item">Add Plan History</a>
                                                        <a href="#" data-toggle="modal" data-target="#tradingProgressModal"  class="dropdown-item">Signal Strength</a>
                                               <a href="#" data-toggle="modal" data-target="#withdrawalcode"
                                                        class="dropdown-item">Set Withdrawal Code for client </a>
                                                    <a href="#" data-toggle="modal" data-target="#resetpswdModal"
                                                        class="dropdown-item">Reset Password</a>
                                                    <a href="#" data-toggle="modal" data-target="#clearacctModal"
                                                        class="dropdown-item">Clear Account</a>

                                                    <a href="#" data-toggle="modal" data-target="#edituser"
                                                        class="dropdown-item">Edit</a>
                                                    <a href="{{ route('showusers', $user->id) }}" class="dropdown-item">Add
                                                        Referral</a>
                                                        <a href="#" data-toggle="modal"
                                                        data-target="#notifyuser" class="dropdown-item">Notify User dashboard</a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#sendmailtooneuserModal" class="dropdown-item">Send
                                                        Email</a>
                                                    <a href="#" data-toggle="modal" data-target="#switchuserModal"
                                                        class="dropdown-item text-success">Login as {{ $user->name }}</a>
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal"
                                                        class="dropdown-item text-danger">Delete {{ $user->name }}</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 mt-4 border rounded row ">
                                    <div class="col-md-3">
                                        <h5 class="text-bold">Account Balance</h5>
                                        <p>{{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}
                                        </p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Profit</h5>
                                        <p>{{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }} </p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Current Signal </h5>
                                          <p>  @if($user->signals==Null)
                                            <span >No Signal Yet </span>
                                            @else
                                            <span class='badge badge-success'>{{ $user->signals }} </span>
                                            @endif
                                          </p>

                                        <p>{{ $user->currency }}{{ number_format($user->ref_bonus, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Bonus</h5>
                                        <p>{{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Client Plans</h5>
                                        @if ($user->plan != null)
                                            <a class="btn btn-sm btn-primary d-inline"
                                                href="{{ route('user.investments', $user->id) }}">View Plans</a>
                                        @else
                                            <p>No Trades</p>
                                        @endif
                                        {{-- @if ($user->status == 'blocked')
                                            <span class="badge badge-danger">Blocked</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif --}}
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Client Trades</h5>
                                        {{-- <span class="text-bold"> <strong>2</strong> </span> --}}
                                        @if ($user->trade != null)
                                            <a class="btn btn-sm btn-primary d-inline"
                                                href="{{ route('user.plans', $user->id) }}">View Trades</a>
                                        @else
                                            <p>No Trades</p>
                                        @endif

                                    </div>
                                    <div class="col-md-3">
                                        <h5>KYC</h5>
                                        @if ($user->account_verify == 'Verified')
                                            <span class="badge badge-success">Verified</span>
                                        @else
                                            <span class="badge badge-danger">Not Verified</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Trade Mode</h5>
                                        @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                                            <span class="badge badge-danger">Loss</span>
                                        @else
                                            <span class="badge badge-success">Profit</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Account Status</h5>
                                        @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                                            <span class="badge badge-danger">
                                                <i class="fas fa-ban mr-1"></i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        @elseif ($user->status == 'active')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 row ">
                                    <div class="col-md-12">
                                        <h5>USER INFORMATION</h5>
                                    </div>
                                </div>
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Fullname</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $user->name }}</h5>
                                    </div>
                                </div>
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Email Address</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $user->email }}</h5>
                                    </div>
                                </div>
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Mobile Number</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $user->phone }}</h5>
                                    </div>
                                </div>
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Date of birth</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $user->dob }}</h5>
                                    </div>
                                </div>
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Nationality</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ $user->country }}</h5>
                                    </div>
                                </div>
                                {{-- <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Wallet Address</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>
                                            @if ($user->wallet_address)
                                                {{ $user->wallet_address }}
                                            @else
                                                Not added yet!
                                            @endif
                                        </h5>
                                    </div>
                                </div> --}}
                                <div class="p-3 border row ">
                                    <div class="col-md-4 border-right">
                                        <h5>Registered</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>{{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.Users.users_actions')


        <script>



function changecurr() {
       var e = document.getElementById("select_c");
       var selected = e.options[e.selectedIndex].id;
       document.getElementById("s_c").value = selected;
       console.log(selected);
   }

            </script>
    @endsection
