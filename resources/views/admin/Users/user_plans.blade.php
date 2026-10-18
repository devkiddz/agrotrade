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
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1  d-inline"> {{ $user->name }} Clients Trades</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('viewuser', $user->id) }}"> <i
                                    class="fa fa-arrow-left"></i> back</a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col card p-3 shadow ">
                        <div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table">
                            <span style="margin:3px;">
                                <table id="ShipTable" class="table table-hover ">
                                    <thead>
                                        <tr>
                                            {{-- <th>Client name</th> --}}
                                            <th>Assets</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Leverage</th>
                                            <th>Trade Type</th>
                                            <th>Duration</th>
                                            <th>Created on</th>
                                            <th>Expire At</th>
                                            <th>Actions</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            @php $controlState = $tradeControls[$plan->id] ?? 'active'; @endphp
                                            <tr>
                                                {{-- <td>{{$plan->duser->name}}</td> --}}
                                                <td>{{ $plan->assets }}</td>
                                                <td>{{ $user->currency }}{{ number_format($plan->amount) }}</td>
                                                <td>
                                                    @if ($controlState !== 'active')
                                                        <span class="badge badge-warning">{{ ucfirst($controlState) }}</span>
                                                    @elseif ($plan->active == 'yes')
                                                        <span class="badge badge-success">{{ $plan->active }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $plan->active }}</span>
                                                    @endif
                                                </td>
                                                <td>1:{{ $plan->leverage }}</td>
                                                @if($plan->type=='Buy')
                                                <td >
                                                    <span class='badge badge-success'>{{ $plan->type }}</span>
                                                </td>
                                                @else
                                                <td>
                                                    <span class="badge badge-danger">{{ $plan->type }}</span>
                                                </td>
                                                   
                                                @endif
                                                
                                                <td>{{ $plan->inv_duration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($plan->created_at)->toDayDateTimeString() }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() }}
                                                </td>

                                                                                                <td>
                                                    @php
                                                        $investmentState = $tradeControls[$plan->id] ?? 'active';
                                                        $isActiveInvestment = $plan->active === 'yes' && $investmentState === 'active';
                                                        $isPausedInvestment = $plan->active === 'yes' && $investmentState === 'paused';
                                                    @endphp
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                        <div class="dropdown-menu dropdown-menu-right shadow-sm" style="min-width: 190px; z-index: 1100;">
                                                            @if ($isActiveInvestment)
                                                                <form method="post" action="{{ route('admin.investment-controls.update', ['type' => 'modern', 'id' => $plan->id]) }}" onsubmit="return agrotradeInvestmentReason(this, 'Pause');">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="pause"><input type="hidden" name="reason" value="">
                                                                    <button type="submit" class="dropdown-item text-warning">Pause investment</button>
                                                                </form>
                                                            @elseif ($isPausedInvestment)
                                                                <form method="post" action="{{ route('admin.investment-controls.update', ['type' => 'modern', 'id' => $plan->id]) }}" onsubmit="return agrotradeInvestmentReason(this, 'Resume');">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="resume"><input type="hidden" name="reason" value="">
                                                                    <button type="submit" class="dropdown-item text-success">Resume investment</button>
                                                                </form>
                                                            @endif
                                                            @if ($isActiveInvestment || $isPausedInvestment)
                                                                <form method="post" action="{{ route('admin.investment-controls.update', ['type' => 'modern', 'id' => $plan->id]) }}" onsubmit="return agrotradeInvestmentReason(this, 'Mark Completed');">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="complete"><input type="hidden" name="reason" value="">
                                                                    <button type="submit" class="dropdown-item">Mark completed</button>
                                                                </form>
                                                            @endif
                                                                                                                        @if ($isActiveInvestment)
                                                                <div class="dropdown-divider"></div>
                                                                <a href="{{ route('markprofit', $plan->id) }}" class="dropdown-item" onclick="return confirm('Mark this trade as profit? This may change customer balances.');">Mark as profit</a>
                                                                <a href="{{ route('markloss', $plan->id) }}" class="dropdown-item" onclick="return confirm('Mark this trade as loss? This may change customer balances.');">Mark as loss</a>
                                                            @endif
                                                            @if ($investmentState === 'completed')
                                                                <span class="dropdown-item-text text-muted">Completed · read only</span>
                                                            @elseif (!$isActiveInvestment && !$isPausedInvestment)
                                                                <span class="dropdown-item-text text-muted">{{ ucfirst($investmentState) }}</span>
                                                            @endif
                                                            @if ($investmentState !== 'completed')
                                                                <div class="dropdown-divider"></div>
                                                                <a href="{{ route('deleteplan', $plan->id) }}" class="dropdown-item text-danger" onclick="return confirm('Delete this investment record?');">Delete trade</a>
                                                            @endif
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
    {{-- AGROTRADE_FINAL_ACTION_MENU_R3 --}}
    <script>
    function agrotradeInvestmentReason(form, label) {
        var reason = window.prompt(label + ' — reason (5–1000 characters):');
        if (reason === null) return false;
        reason = reason.trim();
        if (reason.length < 5 || reason.length > 1000) { window.alert('Reason must contain 5–1000 characters.'); return false; }
        if (!window.confirm('Confirm: ' + label + ' this investment?')) return false;
        form.elements['reason'].value = reason;
        return true;
    }
    </script>
    @endsection
