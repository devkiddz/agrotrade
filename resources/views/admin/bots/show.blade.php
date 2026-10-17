@php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = "light";
} else {
	$bg = 'dark';
    $text = "light";
}
@endphp
@extends('layouts.app')

@section('content')
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">{{ $bot->name }} Details</h4>
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
                    <a href="{{ route('admin.bots.index') }}">Bot Trading</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $bot->name }}</a>
                </li>
            </ul>
        </div>

        <!-- Bot Information Card -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('{{ asset('dash/img/blogpost.jpg') }}')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                @if($bot->image)
                                    <img src="{{ asset('storage/app/public/' . $bot->image) }}" alt="Bot" class="avatar-img rounded-circle">
                                @else
                                    <div class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-robot text-white fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ $bot->name }}</div>
                            <div class="job">{{ ucfirst($bot->bot_type) }} Trading Bot</div>
                            <div class="desc">{{ $bot->description }}</div>
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="{{ route('admin.bots.edit', $bot) }}">
                                    <span class="btn-label just-icon"><i class="flaticon-edit"></i></span>
                                </a>
                                <a class="btn btn-success btn-twitter btn-sm btn-link" href="{{ route('admin.bots.analytics', $bot) }}">
                                    <span class="btn-label just-icon"><i class="flaticon-chart-pie"></i></span>
                                </a>
                                <form action="{{ route('admin.bots.toggle-status', $bot) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $bot->status == 'active' ? 'warning' : 'primary' }} btn-sm btn-link">
                                        <span class="btn-label just-icon">
                                            <i class="flaticon-{{ $bot->status == 'active' ? 'pause' : 'play' }}"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number">{{ $bot->user_investments_count ?? 0 }}</div>
                                <div class="title">Investors</div>
                            </div>
                            <div class="col">
                                <div class="number">{{ $bot->success_rate }}%</div>
                                <div class="title">Success Rate</div>
                            </div>
                            <div class="col">
                                <div class="number">{{ $bot->duration_days }}</div>
                                <div class="title">Days</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Bot Statistics -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bot Performance Statistics</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total Earned</p>
                                                    <h4 class="card-title">${{ number_format($bot->total_earned, 2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total Users</p>
                                                    <h4 class="card-title">{{ $bot->total_users }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Profit Range</p>
                                                    <h4 class="card-title">{{ $bot->daily_profit_min }}%-{{ $bot->daily_profit_max }}%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Last Trade</p>
                                                    <h4 class="card-title">
                                                        @if($bot->last_trade)
                                                            {{ $bot->last_trade->diffForHumans() }}
                                                        @else
                                                            Never
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bot Configuration -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bot Configuration</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-typo">
                                    <tbody>
                                        <tr>
                                            <td><strong>Market Type:</strong></td>
                                            <td>{{ ucfirst($bot->bot_type) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Min Investment:</strong></td>
                                            <td>${{ number_format($bot->min_investment, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Max Investment:</strong></td>
                                            <td>${{ number_format($bot->max_investment, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Success Rate:</strong></td>
                                            <td>{{ $bot->success_rate }}%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Duration:</strong></td>
                                            <td>{{ $bot->duration_days }} days</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-typo">
                                    <tbody>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($bot->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($bot->status == 'inactive')
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @else
                                                    <span class="badge badge-warning">Maintenance</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daily Profit Min:</strong></td>
                                            <td>{{ $bot->daily_profit_min }}%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daily Profit Max:</strong></td>
                                            <td>{{ $bot->daily_profit_max }}%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $bot->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated:</strong></td>
                                            <td>{{ $bot->updated_at->format('M d, Y') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($bot->trading_pairs)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Trading Pairs</h5>
                                <div class="d-flex flex-wrap">
                                    @php
                                        $tradingPairs = $bot->trading_pairs;
                                        if (is_string($tradingPairs)) {
                                            $tradingPairs = json_decode($tradingPairs, true) ?: [];
                                        } elseif (!is_array($tradingPairs)) {
                                            $tradingPairs = [];
                                        }
                                    @endphp
                                    @foreach($tradingPairs as $pair)
                                        <span class="badge badge-primary mr-2 mb-2">{{ $pair }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Trades -->
        @if(count($recentTrades) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Recent Trading Activity</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Investment</th>
                                        <th>Pair</th>
                                        <th>Result</th>
                                        <th>Profit/Loss</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTrades as $trade)
                                    <tr>
                                        <td>{{ $trade->userBotInvestment->user->name ?? 'N/A' }}</td>
                                        <td>${{ number_format($trade->userBotInvestment->investment_amount, 2) }}</td>
                                        <td>{{ $trade->trading_pair }}</td>
                                        <td>
                                            @if($trade->result == 'profit')
                                                <span class="badge badge-success">Profit</span>
                                            @else
                                                <span class="badge badge-danger">Loss</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-{{ $trade->result == 'profit' ? 'success' : 'danger' }}">
                                                ${{ number_format($trade->profit_loss, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $trade->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        </div>
    </div>
</div>
@endsection
