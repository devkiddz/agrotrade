@extends('layouts.dasht')
@section('title', $title)
@section('content')
<div class="min-h-screen bg-gray-900 p-4 md:p-6">
    <x-danger-alert />
    <x-success-alert />

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Crypto Exchange</h1>
                <p class="text-gray-400 text-sm md:text-base">
                    Trade cryptocurrencies with fixed rates and low fees
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('swaphistory') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i data-lucide="history" class="w-4 h-4 mr-2"></i>
                    Transaction History
                </a>
            </div>
        </div>
    </div>

    <!-- Portfolio Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <!-- USD Balance Card -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-blue-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-400"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Account Balance</p>
                    <p class="text-lg font-bold text-white">
                        {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                    </p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-full h-full bg-gradient-to-r from-green-400 to-green-500 rounded-full"></div>
            </div>
        </div>

        <!-- Crypto Balance Cards -->
        @if ($moresettings->btc == 'enabled')
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                    <img src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" alt="BTC" class="w-8 h-8">
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Bitcoin</p>
                    <p class="text-lg font-bold text-white">{{ round($cbalance->btc, 8) }} BTC</p>
                    <p class="text-xs text-gray-400">~{{ Auth::user()->currency }}{{ number_format(round($cbalance->btc * 45000)) }}</p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-3/4 h-full bg-gradient-to-r from-orange-400 to-orange-500 rounded-full"></div>
            </div>
        </div>
        @endif

        @if ($moresettings->eth == 'enabled')
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-blue-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <img src="https://img.icons8.com/fluency/48/000000/ethereum.png" alt="ETH" class="w-8 h-8">
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Ethereum</p>
                    <p class="text-lg font-bold text-white">{{ round($cbalance->eth, 8) }} ETH</p>
                    <p class="text-xs text-gray-400">~{{ Auth::user()->currency }}{{ number_format(round($cbalance->eth * 3000)) }}</p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-2/3 h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full"></div>
            </div>
        </div>
        @endif

        @if ($moresettings->usdt == 'enabled')
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-green-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <img src="https://img.icons8.com/color/48/000000/tether--v2.png" alt="USDT" class="w-8 h-8">
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Tether</p>
                    <p class="text-lg font-bold text-white">{{ round($cbalance->usdt, 8) }} USDT</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->currency }}{{ number_format(round($cbalance->usdt)) }}</p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-full h-full bg-gradient-to-r from-green-400 to-green-500 rounded-full"></div>
            </div>
        </div>
        @endif

        <!-- Additional crypto cards with fixed prices -->
        @if ($moresettings->ltc == 'enabled')
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-gray-400/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gray-500/20 rounded-xl flex items-center justify-center">
                    <img src="https://img.icons8.com/fluency/48/000000/litecoin.png" alt="LTC" class="w-8 h-8">
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Litecoin</p>
                    <p class="text-lg font-bold text-white">{{ round($cbalance->ltc, 8) }} LTC</p>
                    <p class="text-xs text-gray-400">~{{ Auth::user()->currency }}{{ number_format(round($cbalance->ltc * 100)) }}</p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-1/2 h-full bg-gradient-to-r from-gray-400 to-gray-500 rounded-full"></div>
            </div>
        </div>
        @endif

        @if ($moresettings->xrp == 'enabled')
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-blue-400/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-400/20 rounded-xl flex items-center justify-center">
                    <img src="https://img.icons8.com/fluency/48/000000/ripple.png" alt="XRP" class="w-8 h-8">
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Ripple</p>
                    <p class="text-lg font-bold text-white">{{ round($cbalance->xrp, 8) }} XRP</p>
                    <p class="text-xs text-gray-400">~{{ Auth::user()->currency }}{{ number_format(round($cbalance->xrp * 0.6)) }}</p>
                </div>
            </div>
            <div class="w-full h-1 bg-gray-700 rounded-full">
                <div class="w-1/3 h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full"></div>
            </div>
        </div>
        @endif

        @php
        $cryptoRates = [
            'bnb' => 300,
            'ada' => 0.5,
            'link' => 8,
            'aave' => 80,
            'bch' => 250,
            'xlm' => 0.3
        ];
        @endphp

        <!-- Additional crypto cards with fixed prices -->
        @foreach(['bnb', 'ada', 'link', 'aave', 'bch', 'xlm'] as $crypto)
            @if ($moresettings->$crypto == 'enabled')
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-purple-500/50 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        @switch($crypto)
                            @case('link')
                                <img src="https://img.icons8.com/cotton/64/000000/chainlink.png" alt="LINK" class="w-8 h-8">
                                @break
                            @case('bnb')
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png" alt="BNB" class="w-8 h-8">
                                @break
                            @case('ada')
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/2010.png" alt="ADA" class="w-8 h-8">
                                @break
                            @case('aave')
                                <img src="https://dynamic-assets.coinbase.com/6ad513d3c9108b163cf0a4c9fd3441cadcb9cf656ea7b9fb333eb7e4a94cd503528e0a94188285d31aedfc392f0793fd4161f7ad4e04d5f6b82e4d70a314d295/asset_icons/80f3d2256652f5ccd680fc48702d130dd01f1bd7c9737fac560a02949efac3b9.png" alt="AAVE" class="w-6 h-6">
                                @break
                            @case('bch')
                                <img src="https://img.icons8.com/material-sharp/24/000000/bitcoin.png" alt="BCH" class="w-8 h-8">
                                @break
                            @case('xlm')
                                <img src="https://img.icons8.com/ios/50/000000/stellar.png" alt="XLM" class="w-8 h-8">
                                @break
                        @endswitch
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ strtoupper($crypto) }}</p>
                        <p class="text-lg font-bold text-white">{{ round($cbalance->$crypto, 8) }} {{ strtoupper($crypto) }}</p>
                        <p class="text-xs text-gray-400">~{{ Auth::user()->currency }}{{ number_format(round($cbalance->$crypto * $cryptoRates[$crypto])) }}</p>
                    </div>
                </div>
                <div class="w-full h-1 bg-gray-700 rounded-full">
                    <div class="w-1/4 h-full bg-gradient-to-r from-purple-400 to-purple-500 rounded-full"></div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <!-- NEW SWAP SYSTEM: Complete Rewrite -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Left side: Swap Form -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-2">Instant Swap</h2>
                <p class="text-gray-400 text-sm">Exchange cryptocurrencies with guaranteed fixed rates</p>
            </div>

            <form id="newSwapForm" class="space-y-6">
                @csrf
                <!-- From Currency -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">From</label>
                    <div class="flex bg-gray-900 rounded-lg border border-gray-700 overflow-hidden">
                        <div class="w-1/3 border-r border-gray-700">
                            <select id="fromCurrency" class="bg-transparent w-full h-full px-3 py-3 text-white focus:outline-none">
                                <option value="usd">USD</option>
                                <option value="btc">BTC</option>
                                <option value="eth">ETH</option>
                                <option value="usdt">USDT</option>
                                <option value="ltc">LTC</option>
                                <option value="xrp">XRP</option>
                                <option value="bnb">BNB</option>
                                <option value="ada">ADA</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <input type="number" id="fromAmount" class="w-full h-full bg-transparent px-3 py-3 text-white focus:outline-none" placeholder="Enter amount" step="any">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500" id="fromBalance">Available: calculating...</p>
                </div>

                <!-- Swap Button -->
                <div class="flex justify-center">
                    <button type="button" id="swapDirectionBtn" class="bg-gray-700 hover:bg-gray-600 rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    </button>
                </div>

                <!-- To Currency -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">To</label>
                    <div class="flex bg-gray-900 rounded-lg border border-gray-700 overflow-hidden">
                        <div class="w-1/3 border-r border-gray-700">
                            <select id="toCurrency" class="bg-transparent w-full h-full px-3 py-3 text-white focus:outline-none">
                                <option value="btc">BTC</option>
                                <option value="usd">USD</option>
                                <option value="eth">ETH</option>
                                <option value="usdt">USDT</option>
                                <option value="ltc">LTC</option>
                                <option value="xrp">XRP</option>
                                <option value="bnb">BNB</option>
                                <option value="ada">ADA</option>
                            </select>
                        </div>
                        <div class="flex-1 relative">
                            <input type="text" id="toAmount" class="w-full h-full bg-transparent px-3 py-3 text-white focus:outline-none" readonly>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <div class="animate-pulse hidden" id="calculatingIndicator">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rate Info -->
                <div class="flex items-center justify-between py-3 px-4 bg-gray-900 rounded-lg border border-gray-700">
                    <div class="text-gray-400 text-sm">Exchange Rate</div>
                    <div class="text-white font-medium" id="exchangeRate">-</div>
                </div>

                <!-- Fee Info -->
                <div class="flex items-center justify-between py-3 px-4 bg-gray-900 rounded-lg border border-gray-700">
                    <div class="text-gray-400 text-sm">Fee ({{ $moresettings->fee ?? '0.5' }}%)</div>
                    <div class="text-white font-medium" id="feeAmount">-</div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="swapSubmitBtn" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Swap Now
                </button>

                <p class="text-center text-xs text-gray-500 mt-3">
                    By proceeding, you agree to our exchange terms and conditions.
                </p>
            </form>
        </div>

        <!-- Right side: Live Chart -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Market Chart</h2>
                <select id="chartPair" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-2 py-1">
                    <option value="BTCUSDT">BTC/USDT</option>
                    <option value="ETHUSDT">ETH/USDT</option>
                    <option value="LTCUSDT">LTC/USDT</option>
                    <option value="XRPUSDT">XRP/USDT</option>
                    <option value="BNBUSDT">BNB/USDT</option>
                    <option value="ADAUSDT">ADA/USDT</option>
                </select>
            </div>

            <!-- TradingView Chart -->
            <div id="tradingview_chart" class="h-80 rounded-lg overflow-hidden"></div>
        </div>
    </div>

    <!-- NEW ACCOUNT-TO-CRYPTO SWAP SYSTEM -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Left side: Swap Form -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-2">Account Balance Swap</h2>
                <p class="text-gray-400 text-sm">Convert between your account balance and crypto assets instantly</p>
            </div>

            <div class="p-4 bg-blue-900/20 border border-blue-800 rounded-lg mb-6">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-blue-300">Using fixed rates for guaranteed conversions. No slippage, no surprises.</p>
                    </div>
                </div>
            </div>

            <form id="accountSwapForm" class="space-y-6">
                @csrf
                <!-- Swap Direction Tabs -->
                <div class="grid grid-cols-2 bg-gray-900 rounded-lg overflow-hidden mb-2">
                    <button type="button" id="buyTab" class="py-3 px-4 text-center text-white bg-blue-600 font-medium">Buy Crypto</button>
                    <button type="button" id="sellTab" class="py-3 px-4 text-center text-gray-400 bg-transparent font-medium">Sell Crypto</button>
                </div>

                <!-- Account Balance Display -->
                <div class="flex items-center justify-between py-3 px-4 bg-gray-900/50 rounded-lg border border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-green-400"></i>
                        </div>
                        <div class="text-gray-300">Account Balance</div>
                    </div>
                    <div class="text-white font-medium" id="accountBalanceDisplay">{{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}</div>
                </div>

                <!-- Buy Crypto Form (Default View) -->
                <div id="buyForm" class="space-y-6">
                    <!-- Amount to Convert -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Amount to Convert</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">{{ Auth::user()->currency }}</span>
                            </div>
                            <input type="number" id="buyAmount" class="pl-10 w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter amount" step="any">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" id="buyMaxBtn" class="text-xs bg-blue-600 hover:bg-blue-700 text-white py-1 px-2 rounded">MAX</button>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Available: {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}</p>
                    </div>

                    <!-- Select Crypto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Select Cryptocurrency</label>
                        <div class="relative">
                            <select id="buyCrypto" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-10 px-4 py-3 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                <option value="btc">Bitcoin (BTC)</option>
                                <option value="eth">Ethereum (ETH)</option>
                                <option value="usdt">Tether (USDT)</option>
                                <option value="ltc">Litecoin (LTC)</option>
                                <option value="xrp">Ripple (XRP)</option>
                                <option value="bnb">Binance Coin (BNB)</option>
                                <option value="ada">Cardano (ADA)</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none crypto-icon" id="buyCryptoIcon">
                                <img src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" class="w-5 h-5">
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500" id="buyAvailableDisplay">Current: 0.00000000 BTC</p>
                    </div>

                    <!-- You'll Receive Display -->
                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-400">You'll Receive</span>
                            <span class="text-sm text-gray-400" id="buyRateDisplay">1 {{ Auth::user()->currency }} = 0.00000000 BTC</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="crypto-icon-receive mr-2">
                                    <img src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" class="w-6 h-6">
                                </div>
                                <div class="font-medium text-lg text-white" id="buyReceiveAmount">0.00000000</div>
                                <div class="text-lg text-white ml-1" id="buyReceiveSymbol">BTC</div>
                            </div>
                            <div class="text-sm text-gray-500" id="buyFeeInfo">Fee: 0.00000000 BTC</div>
                        </div>
                    </div>

                    <button type="submit" id="buySubmitBtn" class="w-full py-3 px-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Buy Crypto Now
                    </button>
                </div>

                <!-- Sell Crypto Form (Hidden by Default) -->
                <div id="sellForm" class="space-y-6 hidden">
                    <!-- Select Crypto to Sell -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Select Crypto to Sell</label>
                        <div class="relative">
                            <select id="sellCrypto" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg pl-10 px-4 py-3 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                <option value="btc">Bitcoin (BTC)</option>
                                <option value="eth">Ethereum (ETH)</option>
                                <option value="usdt">Tether (USDT)</option>
                                <option value="ltc">Litecoin (LTC)</option>
                                <option value="xrp">Ripple (XRP)</option>
                                <option value="bnb">Binance Coin (BNB)</option>
                                <option value="ada">Cardano (ADA)</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none crypto-icon" id="sellCryptoIcon">
                                <img src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" class="w-5 h-5">
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500" id="sellAvailableDisplay">Available: 0.00000000 BTC</p>
                    </div>

                    <!-- Amount to Sell -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Amount to Sell</label>
                        <div class="relative">
                            <input type="number" id="sellAmount" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter amount" step="any">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" id="sellMaxBtn" class="text-xs bg-blue-600 hover:bg-blue-700 text-white py-1 px-2 rounded">MAX</button>
                            </div>
                        </div>
                    </div>

                    <!-- You'll Receive Display -->
                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-400">You'll Receive</span>
                            <span class="text-sm text-gray-400" id="sellRateDisplay">1 BTC = {{ Auth::user()->currency }}0.00</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-400"></i>
                                </div>
                                <div class="font-medium text-lg text-white">{{ Auth::user()->currency }}<span id="sellReceiveAmount">0.00</span></div>
                            </div>
                            <div class="text-sm text-gray-500" id="sellFeeInfo">Fee: {{ Auth::user()->currency }}0.00</div>
                        </div>
                    </div>

                    <button type="submit" id="sellSubmitBtn" class="w-full py-3 px-4 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Sell Crypto Now
                    </button>
                </div>
            </form>
        </div>

        <!-- Right side: Crypto Price Cards & Chart -->
        <div class="space-y-6">
            <!-- Crypto Price Cards -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Current Rates</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://img.icons8.com/color/48/000000/bitcoin--v1.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">BTC</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}45,000.00</div>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://img.icons8.com/fluency/48/000000/ethereum.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">ETH</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}3,000.00</div>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://img.icons8.com/color/48/000000/tether--v2.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">USDT</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}1.00</div>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://img.icons8.com/fluency/48/000000/litecoin.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">LTC</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}100.00</div>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">BNB</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}300.00</div>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg border border-gray-700 p-3 flex flex-col">
                        <div class="flex items-center mb-2">
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/2010.png" class="w-5 h-5 mr-2">
                            <span class="text-sm text-gray-300">ADA</span>
                        </div>
                        <div class="text-white font-medium">{{ Auth::user()->currency }}0.50</div>
                    </div>
                </div>
            </div>

            <!-- Live Chart -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white">Market Chart</h2>
                    <select id="chartPair" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg px-2 py-1">
                        <option value="BTCUSDT">BTC/USDT</option>
                        <option value="ETHUSDT">ETH/USDT</option>
                        <option value="LTCUSDT">LTC/USDT</option>
                        <option value="XRPUSDT">XRP/USDT</option>
                        <option value="BNBUSDT">BNB/USDT</option>
                        <option value="ADAUSDT">ADA/USDT</option>
                    </select>
                </div>

                <!-- TradingView Chart -->
                <div id="tradingview_chart" class="h-60 rounded-lg overflow-hidden"></div>
            </div>
        </div>
    </div>
</div>

<!-- TradingView Widget -->
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<script type="text/javascript">
    // Fixed rates for all assets
    const fixedRates = {
        btc: 45000.00,
        eth: 3000.00,
        usdt: 1.00,
        bnb: 300.00,
        ada: 0.50,
        xrp: 0.60,
        ltc: 100.00,
        link: 8.00,
        aave: 80.00,
        bch: 250.00,
        xlm: 0.30,
        usd: 1.00
    };

    // User balances
    const userBalances = {
        usd: {{ Auth::user()->account_bal }},
        btc: {{ $cbalance->btc }},
        eth: {{ $cbalance->eth }},
        usdt: {{ $cbalance->usdt }},
        ltc: {{ $cbalance->ltc }},
        xrp: {{ $cbalance->xrp }},
        bnb: {{ $cbalance->bnb }},
        ada: {{ $cbalance->ada }},
        link: {{ $cbalance->link ?? 0 }},
        aave: {{ $cbalance->aave ?? 0 }},
        bch: {{ $cbalance->bch ?? 0 }},
        xlm: {{ $cbalance->xlm ?? 0 }}
    };

    // Crypto icons mapping
    const cryptoIcons = {
        btc: "https://img.icons8.com/color/48/000000/bitcoin--v1.png",
        eth: "https://img.icons8.com/fluency/48/000000/ethereum.png",
        usdt: "https://img.icons8.com/color/48/000000/tether--v2.png",
        ltc: "https://img.icons8.com/fluency/48/000000/litecoin.png",
        xrp: "https://img.icons8.com/fluency/48/000000/ripple.png",
        bnb: "https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png",
        ada: "https://s2.coinmarketcap.com/static/img/coins/64x64/2010.png",
        link: "https://img.icons8.com/cotton/64/000000/chainlink.png",
        aave: "https://dynamic-assets.coinbase.com/6ad513d3c9108b163cf0a4c9fd3441cadcb9cf656ea7b9fb333eb7e4a94cd503528e0a94188285d31aedfc392f0793fd4161f7ad4e04d5f6b82e4d70a314d295/asset_icons/80f3d2256652f5ccd680fc48702d130dd01f1bd7c9737fac560a02949efac3b9.png",
        bch: "https://img.icons8.com/material-sharp/24/000000/bitcoin.png",
        xlm: "https://img.icons8.com/ios/50/000000/stellar.png"
    };

    // Format numbers for display
    function formatNumber(number, decimals = 8) {
        if (number === undefined || isNaN(number)) return "0";

        // For very small numbers
        if (number > 0 && number < 0.000001) {
            return number.toExponential(decimals);
        }

        // For normal numbers
        const options = {
            minimumFractionDigits: 0,
            maximumFractionDigits: decimals
        };

        return number.toLocaleString('en-US', options);
    }

    // Format fiat numbers for display (2 decimal places)
    function formatFiat(number) {
        if (number === undefined || isNaN(number)) return "0.00";
        return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TradingView Widget
        let tradingViewWidget = new TradingView.widget({
            "width": "100%",
            "height": "100%",
            "symbol": "BINANCE:BTCUSDT",
            "interval": "30",
            "timezone": "Etc/UTC",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#1f2937",
            "enable_publishing": false,
            "hide_side_toolbar": false,
            "save_image": false,
            "container_id": "tradingview_chart"
        });

        // Update chart when pair changes
        document.getElementById('chartPair').addEventListener('change', function() {
            tradingViewWidget = new TradingView.widget({
                "width": "100%",
                "height": "100%",
                "symbol": "BINANCE:" + this.value,
                "interval": "30",
                "timezone": "Etc/UTC",
                "theme": "dark",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#1f2937",
                "enable_publishing": false,
                "hide_side_toolbar": false,
                "save_image": false,
                "container_id": "tradingview_chart"
            });
        });

        // Elements for Buy form
        const buyTabEl = document.getElementById('buyTab');
        const sellTabEl = document.getElementById('sellTab');
        const buyFormEl = document.getElementById('buyForm');
        const sellFormEl = document.getElementById('sellForm');
        const buyAmountEl = document.getElementById('buyAmount');
        const buyCryptoEl = document.getElementById('buyCrypto');
        const buyCryptoIconEl = document.getElementById('buyCryptoIcon').querySelector('img');
        const buyAvailableDisplayEl = document.getElementById('buyAvailableDisplay');
        const buyRateDisplayEl = document.getElementById('buyRateDisplay');
        const buyReceiveAmountEl = document.getElementById('buyReceiveAmount');
        const buyReceiveSymbolEl = document.getElementById('buyReceiveSymbol');
        const buyFeeInfoEl = document.getElementById('buyFeeInfo');
        const buyMaxBtnEl = document.getElementById('buyMaxBtn');
        const cryptoIconReceiveEl = document.querySelector('.crypto-icon-receive img');

        // Elements for Sell form
        const sellCryptoEl = document.getElementById('sellCrypto');
        const sellAmountEl = document.getElementById('sellAmount');
        const sellCryptoIconEl = document.getElementById('sellCryptoIcon').querySelector('img');
        const sellAvailableDisplayEl = document.getElementById('sellAvailableDisplay');
        const sellRateDisplayEl = document.getElementById('sellRateDisplay');
        const sellReceiveAmountEl = document.getElementById('sellReceiveAmount');
        const sellFeeInfoEl = document.getElementById('sellFeeInfo');
        const sellMaxBtnEl = document.getElementById('sellMaxBtn');

        // Tab switching
        buyTabEl.addEventListener('click', function() {
            buyTabEl.classList.remove('bg-transparent', 'text-gray-400');
            buyTabEl.classList.add('bg-blue-600', 'text-white');
            sellTabEl.classList.remove('bg-orange-600', 'text-white');
            sellTabEl.classList.add('bg-transparent', 'text-gray-400');
            buyFormEl.classList.remove('hidden');
            sellFormEl.classList.add('hidden');
        });

        sellTabEl.addEventListener('click', function() {
            sellTabEl.classList.remove('bg-transparent', 'text-gray-400');
            sellTabEl.classList.add('bg-orange-600', 'text-white');
            buyTabEl.classList.remove('bg-blue-600', 'text-white');
            buyTabEl.classList.add('bg-transparent', 'text-gray-400');
            sellFormEl.classList.remove('hidden');
            buyFormEl.classList.add('hidden');
            updateSellForm();
        });

        // Update Buy Form calculations
        function updateBuyForm() {
            const amount = parseFloat(buyAmountEl.value) || 0;
            const cryptoCode = buyCryptoEl.value;
            const feePercentage = {{ $moresettings->fee ?? 0.5 }};

            // Update crypto icon
            buyCryptoIconEl.src = cryptoIcons[cryptoCode] || cryptoIcons.btc;
            cryptoIconReceiveEl.src = cryptoIcons[cryptoCode] || cryptoIcons.btc;

            // Calculate conversion
            const cryptoRate = fixedRates[cryptoCode];
            const cryptoAmount = amount / cryptoRate;
            const feeAmount = cryptoAmount * (feePercentage / 100);
            const netAmount = cryptoAmount - feeAmount;

            // Update UI elements
            buyReceiveAmountEl.textContent = formatNumber(netAmount);
            buyReceiveSymbolEl.textContent = cryptoCode.toUpperCase();
            buyRateDisplayEl.textContent = `1 {{ Auth::user()->currency }} = ${formatNumber(1/cryptoRate)} ${cryptoCode.toUpperCase()}`;
            buyFeeInfoEl.textContent = `Fee: ${formatNumber(feeAmount)} ${cryptoCode.toUpperCase()} (${feePercentage}%)`;
            buyAvailableDisplayEl.textContent = `Current: ${formatNumber(userBalances[cryptoCode])} ${cryptoCode.toUpperCase()}`;
        }

        // Update Sell Form calculations
        function updateSellForm() {
            const cryptoCode = sellCryptoEl.value;
            const amount = parseFloat(sellAmountEl.value) || 0;
            const feePercentage = {{ $moresettings->fee ?? 0.5 }};

            // Update crypto icon
            sellCryptoIconEl.src = cryptoIcons[cryptoCode] || cryptoIcons.btc;

            // Calculate conversion
            const cryptoRate = fixedRates[cryptoCode];
            const usdAmount = amount * cryptoRate;
            const feeAmount = usdAmount * (feePercentage / 100);
            const netAmount = usdAmount - feeAmount;

            // Update UI elements
            sellAvailableDisplayEl.textContent = `Available: ${formatNumber(userBalances[cryptoCode])} ${cryptoCode.toUpperCase()}`;
            sellRateDisplayEl.textContent = `1 ${cryptoCode.toUpperCase()} = {{ Auth::user()->currency }}${formatNumber(cryptoRate, 2)}`;
            sellReceiveAmountEl.textContent = formatFiat(netAmount);
            sellFeeInfoEl.textContent = `Fee: {{ Auth::user()->currency }}${formatFiat(feeAmount)} (${feePercentage}%)`;
        }

        // Event listeners for Buy form
        buyAmountEl.addEventListener('input', updateBuyForm);
        buyCryptoEl.addEventListener('change', updateBuyForm);

        // Event listeners for Sell form
        sellAmountEl.addEventListener('input', updateSellForm);
        sellCryptoEl.addEventListener('change', updateSellForm);

        // Max buttons
        buyMaxBtnEl.addEventListener('click', function() {
            buyAmountEl.value = userBalances.usd.toFixed(2);
            updateBuyForm();
        });

        sellMaxBtnEl.addEventListener('click', function() {
            const cryptoCode = sellCryptoEl.value;
            sellAmountEl.value = userBalances[cryptoCode];
            updateSellForm();
        });

        // Form submissions
        document.getElementById('accountSwapForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let submitData = {};
            let submitBtn;

            // Determine which form is visible and collect data
            if (!buyFormEl.classList.contains('hidden')) {
                // Buy form active
                const amount = parseFloat(buyAmountEl.value) || 0;
                const cryptoCode = buyCryptoEl.value;

                // Validate amount
                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                // Validate balance
                if (amount > userBalances.usd) {
                    alert('Insufficient account balance');
                    return;
                }

                submitData = {
                    source: 'usd',
                    destination: cryptoCode,
                    amount: amount
                };
                submitBtn = document.getElementById('buySubmitBtn');

            } else {
                // Sell form active
                const cryptoCode = sellCryptoEl.value;
                const amount = parseFloat(sellAmountEl.value) || 0;

                // Validate amount
                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                // Validate balance
                if (amount > userBalances[cryptoCode]) {
                    alert(`Insufficient ${cryptoCode.toUpperCase()} balance`);
                    return;
                }

                submitData = {
                    source: cryptoCode,
                    destination: 'usd',
                    amount: amount
                };
                submitBtn = document.getElementById('sellSubmitBtn');
            }

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="flex items-center justify-center"><div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>Processing...</div>';

            // Submit to server
            fetch('{{ route('user.exchange.process') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(submitData)
            })
            .then(response => response.json())
            .then(data => {
                // Re-enable button
                submitBtn.disabled = false;

                if (!buyFormEl.classList.contains('hidden')) {
                    submitBtn.innerHTML = 'Buy Crypto Now';
                } else {
                    submitBtn.innerHTML = 'Sell Crypto Now';
                }

                if (data.status === 'success') {
                    // Show success message
                    alert(data.message || 'Transaction completed successfully!');

                    // Reset form
                    if (!buyFormEl.classList.contains('hidden')) {
                        buyAmountEl.value = '';
                        updateBuyForm();
                    } else {
                        sellAmountEl.value = '';
                        updateSellForm();
                    }

                    // Refresh page after 2 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    alert(data.message || 'An error occurred during the transaction.');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Re-enable button
                submitBtn.disabled = false;
                if (!buyFormEl.classList.contains('hidden')) {
                    submitBtn.innerHTML = 'Buy Crypto Now';
                } else {
                    submitBtn.innerHTML = 'Sell Crypto Now';
                }

                alert('Network error. Please try again.');
            });
        });

        // Initialize forms
        updateBuyForm();
        updateSellForm();

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

@endsection
