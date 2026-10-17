@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="d-flex justify-content-between">
        <h1 class="h2">
            Currency swap
        </h1>
        <div>
            <a href="{{ route('swaphistory') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-clock-history"></i> Transactions
            </a>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row mt-3">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="bi bi-wallet"></i>
                    <div>
                        <p class="m-0">
                            <b>
                                {{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                            </b>
                        </p>
                        <small class="text-muted">Account Balance</small>
                    </div>
                </div>
            </div>
        </div>
        @if ($moresettings->btc == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex justify-content-between card-body">
                        <div>
                            <img width="23px" src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" />
                        </div>

                        <div>
                            <p class="m-0">
                                <b>
                                    {{ round($cbalance->btc, 8) }} BTC
                                </b>

                            </p>
                            <small class="text-muted usdelement" id="btc">BTC Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->eth == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <div>
                            <img width="23px" src="https://img.icons8.com/fluency/48/000000/ethereum.png" />
                        </div>
                        <div>
                            <p class="m-0 ">
                                <b>{{ round($cbalance->eth, 8) }} ETH</b>
                            </p>
                            <small class="text-muted usdelement" id="eth">ETH Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->ltc == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="23px" src="https://img.icons8.com/fluency/48/000000/litecoin.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->ltc, 8) }} LTC</b>
                            </p>
                            <small class="text-muted usdelement" id="ltc">LTC Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->link == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://img.icons8.com/cotton/64/000000/chainlink.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->link, 8) }} LINK</b>
                            </p>
                            <small class="text-muted usdelement" id="link">LINK Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($moresettings->bnb == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->bnb, 8) }} BNB</b>
                            </p>
                            <small class="text-muted usdelement" id="bnb">BNB Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($moresettings->ada == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://s2.coinmarketcap.com/static/img/coins/64x64/2010.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->ada, 8) }} ADA</b>
                            </p>
                            <small class="text-muted usdelement" id="ada">ADA Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($moresettings->aave == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px"
                                src="https://dynamic-assets.coinbase.com/6ad513d3c9108b163cf0a4c9fd3441cadcb9cf656ea7b9fb333eb7e4a94cd503528e0a94188285d31aedfc392f0793fd4161f7ad4e04d5f6b82e4d70a314d295/asset_icons/80f3d2256652f5ccd680fc48702d130dd01f1bd7c9737fac560a02949efac3b9.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->aave, 8) }} AAVE</b>
                            </p>
                            <small class="text-muted usdelement" id="aave">AAVE Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->usdt == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://img.icons8.com/color/48/000000/tether--v2.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->usdt, 8) }} USDT</b>
                            </p>
                            <small
                                class="text-muted">{{ $settings->currency }}{{ number_format(round($cbalance->usdt)) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->bch == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://img.icons8.com/material-sharp/24/000000/bitcoin.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->bch, 8) }} BCH</b>
                            </p>
                            <small class="text-muted usdelement" id="bch">BCH Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->xrp == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://img.icons8.com/fluency/48/000000/ripple.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->xrp, 8) }} XRP</b>
                            </p>
                            <small class="text-muted usdelement" id="xrp">XRP Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($moresettings->xlm == 'enabled')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="d-flex card-body justify-content-between">
                        <span>
                            <img width="21px" src="https://img.icons8.com/ios/50/000000/stellar.png" />
                        </span>
                        <div>
                            <p class="m-0">
                                <b>{{ round($cbalance->xlm, 8) }} XLM</b>
                            </p>
                            <small class="text-muted usdelement" id="xlm">XLM Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-7 mt-4">
            <div class="tradingview-widget-container">
                <div id="tradingview_f933e"></div>
                <div class="tradingview-widget-copyright">
                </div>
            </div>
        </div>
        <div class="col-lg-5 mt-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="javascript:void(0)" id="exchnageform">
                        @csrf
                        <div class="form-group">
                            <p class="mb-1">Source Account</p>
                            <select class="form-select" name="source" id="sourceasset">
                                @if ($moresettings->btc == 'enabled')
                                    <option value="btc">BTC</option>
                                @endif
                                @if ($moresettings->link == 'enabled')
                                    <option value="link">LINK</option>
                                @endif
                                @if ($moresettings->bnb == 'enabled')
                                    <option value="bnb">BNB</option>
                                @endif
                                @if ($moresettings->ada == 'enabled')
                                    <option value="ada">ADA</option>
                                @endif
                                @if ($moresettings->aave == 'enabled')
                                    <option value="aave">AAVE</option>
                                @endif
                                @if ($moresettings->xlm == 'enabled')
                                    <option value="xlm">XLM</option>
                                @endif
                                @if ($moresettings->xrp == 'enabled')
                                    <option value="xrp">XRP</option>
                                @endif
                                @if ($moresettings->ltc == 'enabled')
                                    <option value="ltc">LTC</option>
                                @endif
                                @if ($moresettings->bch == 'enabled')
                                    <option value="bch">BCH</option>
                                @endif
                                @if ($moresettings->eth == 'enabled')
                                    <option value="eth">ETH</option>
                                @endif
                                @if ($moresettings->usdt == 'enabled')
                                    <option value="usdt">USDT</option>
                                @endif
                                <option value="usd">USD</option>
                            </select>
                        </div>

                        <div class="form-group my-3">
                            <p class="mb-1">Destination Account</p>
                            <select name="destination" class="form-select" id="destinationasset">
                                <option value="usd">USD</option>
                                @if ($moresettings->btc == 'enabled')
                                    <option value="btc">BTC</option>
                                @endif
                                @if ($moresettings->link == 'enabled')
                                    <option value="link">LINK</option>
                                @endif
                                @if ($moresettings->bnb == 'enabled')
                                    <option value="bnb">BNB</option>
                                @endif
                                @if ($moresettings->ada == 'enabled')
                                    <option value="ada">ADA</option>
                                @endif
                                @if ($moresettings->aave == 'enabled')
                                    <option value="aave">AAVE</option>
                                @endif
                                @if ($moresettings->xlm == 'enabled')
                                    <option value="xlm">XLM</option>
                                @endif
                                @if ($moresettings->xrp == 'enabled')
                                    <option value="xrp">XRP</option>
                                @endif
                                @if ($moresettings->ltc == 'enabled')
                                    <option value="ltc">LTC</option>
                                @endif
                                @if ($moresettings->bch == 'enabled')
                                    <option value="bch">BCH</option>
                                @endif
                                @if ($moresettings->eth == 'enabled')
                                    <option value="eth">ETH</option>
                                @endif
                                @if ($moresettings->usdt == 'enabled')
                                    <option value="usdt">USDT</option>
                                @endif
                            </select>
                            <small class="fs-6 mt-1">NOTE: USD is your account balance.</small>
                        </div>

                        <div class="form-group">
                            <p class="mb-1">Amount</p>
                            <input type="text" name="amount" class="form-control" placeholder="Enter amount of btc"
                                id="amount">
                        </div>
                        <div class="form-group mt-3">
                            <p class="mb-1">You will get</p>
                            <div class="input-group">
                                <div class="spinner-border spinner-border-sm d-none" id="spinload" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Quantity of usd" id="quantity"
                                    readonly>
                            </div>

                            <input type="hidden" id="realquantity" name="quantity">
                            <div class="form-group mt-3">
                                <span class="mb-1 ml-2 caption">
                                    <span class=" font-weight-bolder">
                                        Fees = {{ $moresettings->fee }}%
                                    </span>
                                </span>
                            </div>

                            <div class="cta inline-group mt-2">
                                <button id="swapbtn" class="btn btn-success w-100 btn-sm" disbaled>
                                    Swap
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        var thme = 'light';
        if (localStorage.getItem('theme') != null) {
            thme = localStorage.getItem('theme');
        } else {
            thme = 'light';
        }

        new TradingView.widget({
            "width": "100%",
            "height": "457",
            "symbol": "COINBASE:BTCUSD",
            "interval": "1",
            "timezone": "Etc/UTC",
            "theme": thme,
            "style": "9",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "hide_side_toolbar": false,
            "allow_symbol_change": true,
            "calendar": false,
            "studies": [
                "BB@tv-basicstudies"
            ],
            "container_id": "tradingview_f933e"
        });
    </script>
    @include('user.exchangescript')
@endpush
