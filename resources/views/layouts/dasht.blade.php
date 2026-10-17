<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'light' ? false : true }"
      :class="{ 'dark': darkMode }"
      class="dark bg-gray-900">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" <head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{{ asset('storage/app/public/' . $settings->favicon) }}" rel="icon" type="image/x-icon" />
    <!-- Inter Font -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Enable dark mode class strategy -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        'glass': 'rgba(255, 255, 255, 0.05)',
                    },
                    backdropBlur: {
                        'xs': '2px',
                    },
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'gradient-y': 'gradient-y 15s ease infinite',
                        'gradient-xy': 'gradient-xy 15s ease infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        'gradient-y': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'center top'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'center center'
                            }
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'gradient-xy': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Set dark mode as default if no preference is stored
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    // Default to dark if no preference is set
                    this.darkMode = localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme');
                    this.updateTheme();
                },
                darkMode: true, // Set default to true
                toggle() {
                    this.darkMode = !this.darkMode;
                    this.updateTheme();
                },
                updateTheme() {
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            });
        });
    </script>
<script src="https://unpkg.com/lucide@latest"></script>
<!-- Tailwind CDN -->
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

</head>
<body x-data="{ darkMode: localStorage.theme === 'dark' || !localStorage.theme, sidebarOpen: false }"
      :class="{ 'dark': darkMode }"
      class="dark text-gray-100 bg-gray-900" x-cloak>
      <style>
       body {
    overflow-x: hidden;
  }

  [x-cloak] {
    display: none !important;
  }
        </style>
<!-- Professional Trading Navbar -->
<nav x-data="{
  open: false,
  darkMode: localStorage.theme === 'dark' || !localStorage.theme,
  notificationOpen: false,
  quickActionsOpen: false
}"
     class="bg-white/98 dark:bg-gray-900/98 backdrop-blur-xl border-b border-gray-200/80 dark:border-gray-700/80 sticky top-0 z-50 shadow-sm dark:shadow-gray-900/20" x-cloak>

  <!-- Main Navigation Container -->
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">

      <!-- Left Section: Logo & Quick Market Info -->
      <div class="flex items-center space-x-4">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
          <img src="{{ asset('storage/app/public/'.$settings->logo)}}" class="h-8 w-auto" alt="Logo" />
          <div class="hidden sm:block">
            <span class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
              {{ config('app.name', 'BluTrade') }}
            </span>
            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
              Professional Trading
            </div>
          </div>
        </a>

        <!-- Live Market Ticker (Hidden on small screens) -->
        <div class="hidden lg:flex items-center space-x-4 ml-8 pl-8 border-l border-gray-200 dark:border-gray-700"
             x-data="cryptoPrices()" x-init="fetchPrices()">
          <div class="flex items-center space-x-2">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">LIVE</span>
          </div>
          <div class="text-sm">
            <span class="text-gray-500 dark:text-gray-400">BTC:</span>
            <span class="font-mono ml-1"
                  :class="btcChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                  x-text="'$' + (btcPrice ? btcPrice.toLocaleString() : '...')"></span>
          </div>
          <div class="text-sm">
            <span class="text-gray-500 dark:text-gray-400">ETH:</span>
            <span class="font-mono ml-1"
                  :class="ethChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                  x-text="'$' + (ethPrice ? ethPrice.toLocaleString() : '...')"></span>
          </div>
        </div>
      </div>

      <!-- Center Section: Account Balance (Desktop) -->
      <div class="hidden md:flex items-center space-x-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-4 py-2 rounded-lg border border-blue-100 dark:border-blue-800">
          <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Account Balance</div>
          <div class="text-lg font-bold text-gray-900 dark:text-white">
            {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
          </div>
        </div>
      </div>

      <!-- Right Section: Actions & User -->
      <div class="flex items-center space-x-2">

        <!-- Quick Actions Dropdown (Desktop) -->
        <div class="hidden md:block relative" x-data="{ quickActionsOpen: false }">
          <button @click="quickActionsOpen = !quickActionsOpen"
                  class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
            <i data-lucide="zap" class="w-4 h-4"></i>
            <span>Quick Trade</span>
            <i data-lucide="chevron-down" class="w-4 h-4" :class="quickActionsOpen ? 'rotate-180' : ''"></i>
          </button>

          <div x-show="quickActionsOpen" @click.away="quickActionsOpen = false"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 scale-95"
               x-transition:enter-end="opacity-100 scale-100"
               class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20" x-cloak>
            <div class="p-2">
              <a href="{{ route('deposits') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-3 text-green-500"></i>
                Deposit Funds
              </a>
              <a href="{{ route('withdrawalsdeposits') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="minus-circle" class="w-4 h-4 mr-3 text-red-500"></i>
                Withdraw
              </a>
              <a href="{{ route('trade.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="trending-up" class="w-4 h-4 mr-3 text-blue-500"></i>
                Trade Markets
              </a>
            </div>
          </div>
        </div>

        <!-- Notifications -->
        <div class="relative" x-data="{ notificationOpen: false }">
          <button @click="notificationOpen = !notificationOpen"
                  class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
            <i data-lucide="bell" class="w-5 h-5"></i>
            @php
                $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                    ->where('is_read', 0)
                    ->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] text-xs font-medium text-white bg-red-500 rounded-full px-1 border-2 border-white dark:border-gray-900">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
          </button>

          <div x-show="notificationOpen" @click.away="notificationOpen = false"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 scale-95"
               x-transition:enter-end="opacity-100 scale-100"
               class="absolute right-0 sm:right-0 sm:left-auto left-1/2 sm:transform-none transform -translate-x-1/2 mt-2 w-80 max-w-[90vw] bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20" x-cloak>
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
              <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                Notifications
                @if($unreadCount > 0)
                  <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-500 rounded-full">
                    {{ $unreadCount }}
                  </span>
                @endif
              </h3>
              {{-- @if($unreadCount > 0)
              <a href="{{ route('notifications.mark-all-read') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                Mark all read
              </a>
              @endif --}}
            </div>

            <div class="max-h-[60vh] overflow-y-auto">
              @php
                  $notifications = \App\Models\Notification::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->take(5)
                      ->get();
              @endphp

              @forelse($notifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="block border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                  <div class="px-4 py-3 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                    <div class="flex items-start">
                      <div class="flex-shrink-0 mt-0.5">
                        <span class="flex h-8 w-8 rounded-full items-center justify-center {{ $notification->type === 'warning' ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500' : ($notification->type === 'success' ? 'bg-green-100 text-green-600 dark:bg-green-900/20 dark:text-green-500' : ($notification->type === 'danger' ? 'bg-red-100 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500')) }}">
                          <i data-lucide="{{ $notification->type === 'warning' ? 'alert-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'alert-octagon' : 'info')) }}" class="w-4 h-4"></i>
                        </span>
                      </div>
                      <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white {{ !$notification->is_read ? 'font-semibold' : '' }}">
                          {{ $notification->title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                          {{ \Illuminate\Support\Str::limit($notification->message, 100) }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                          {{ $notification->created_at->diffForHumans() }}
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              @empty
                <div class="py-8 text-center">
                  <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 mb-4">
                    <i data-lucide="bell-off" class="h-6 w-6"></i>
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-400">No notifications</p>
                  <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">We'll notify you when something arrives</p>
                </div>
              @endforelse
            </div>

            @if(count($notifications) > 0)
              <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                <a href="{{ route('notifications') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all notifications</a>
              </div>
            @endif
          </div>
        </div>

        <!-- Dark Mode Toggle -->
        <button
          x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
          @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', darkMode)"
          class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200"
          :aria-pressed="darkMode">
          <i data-lucide="sun" x-show="!darkMode" class="w-5 h-5"></i>
          <i data-lucide="moon" x-show="darkMode" class="w-5 h-5"></i>
        </button>

        <!-- Language Translator (Desktop) -->
       

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ dropdownOpen: false }">
          <button @click="dropdownOpen = !dropdownOpen"
                  class="flex items-center space-x-3 px-2 py-2 text-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-medium">
                {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <div class="hidden sm:block text-left">
                <div class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[120px]">
                  {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                  Trading Account
                </div>
              </div>
            </div>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400" :class="dropdownOpen ? 'rotate-180' : ''"></i>
          </button>

          <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 scale-95"
               x-transition:enter-end="opacity-100 scale-100"
               class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20" x-cloak>

            <!-- User Info Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-medium">
                  {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                  <div class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ auth()->user()->name }}
                  </div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Menu Items -->
            <div class="p-2">
              <a href="{{ route('profile') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="user" class="w-4 h-4 mr-3"></i>
                Profile Settings
              </a>
              <a href="{{ route('accounthistory') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="receipt" class="w-4 h-4 mr-3"></i>
                Account History
              </a>
              <a href="{{ route('support') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                <i data-lucide="help-circle" class="w-4 h-4 mr-3"></i>
                Support Center
              </a>
              <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">
                  <i data-lucide="log-out" class="w-4 h-4 mr-3"></i>
                  Sign Out
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
          <i data-lucide="menu" x-show="!sidebarOpen" class="w-5 h-5"></i>
          <i data-lucide="x" x-show="sidebarOpen" class="w-5 h-5"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Market Ticker -->
  <div class="lg:hidden bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 px-4 py-2"
       x-data="cryptoPrices()" x-init="fetchPrices()">
    <div class="flex items-center justify-between text-xs">
      <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-1">
          <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
          <span class="text-gray-600 dark:text-gray-400">LIVE</span>
        </div>
        <div>
          <span class="text-gray-500 dark:text-gray-400">BTC:</span>
          <span class="font-mono ml-1"
                :class="btcChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                x-text="'$' + (btcPrice ? btcPrice.toLocaleString() : '...')"></span>
        </div>
        <div>
          <span class="text-gray-500 dark:text-gray-400">ETH:</span>
          <span class="font-mono ml-1"
                :class="ethChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                x-text="'$' + (ethPrice ? ethPrice.toLocaleString() : '...')"></span>
        </div>
      </div>
      <div class="md:hidden">
        <div class="text-gray-500 dark:text-gray-400">Balance:</div>
        <div class="font-semibold text-gray-900 dark:text-white">
          {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
        </div>
      </div>
    </div>
  </div>
</nav>



<!-- Sidebar Toggle Wrapper -->
<div class="flex min-h-screen bg-gray-900" x-cloak>

  <!-- Sidebar -->
<aside x-cloak
  :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
  class="fixed z-50 md:z-40 top-0 left-0 w-72 h-full bg-white dark:bg-gray-900 shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0 overflow-y-auto">

    <!-- User Profile Section -->
    <div class="relative p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="relative">

<div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 text-lg font-medium mx-auto mb-3">
    {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
</div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                    {{ auth()->user()->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Account Balance: {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Live Market Prices -->
    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20" x-cloak>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Live Market</h3>
            <span class="flex items-center text-xs text-green-600 dark:text-green-400">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                <span class="font-medium">LIVE</span>
            </span>
        </div>
        <div class="space-y-2">
            <coingecko-coin-price-marquee-widget
                coin-ids="bitcoin,ethereum,eos,ripple,litecoin"
                currency="usd"
                background-color="transparent"
                locale="en"
                font-color="#333">
            </coingecko-coin-price-marquee-widget>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-6 text-sm pb-20" x-cloak>
        <!-- Overview Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Overview</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounthistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('accounthistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="receipt" class="w-5 h-5 mr-3"></i>
                        Account Statement
                    </a>
                </li>
            </ul>
        </div>

        <!-- Portfolio & Investments Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
                <span>Portfolio & Investments</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('mplans') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('user.plans.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="target" class="w-5 h-5 mr-3"></i>
                        Investment Plans
                    </a>
                </li>
                <li>
                    <a href="{{ route('myplans', 'All') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('myplans') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="pie-chart" class="w-5 h-5 mr-3"></i>
                        My Portfolio
                    </a>
                </li>
                <li>
                    <a href="{{ route('tradinghistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('tradinghistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="activity" class="w-5 h-5 mr-3"></i>
                        Performance History
                    </a>
                </li>
            </ul>
        </div>

        <!-- Trading & Markets Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>Trading & Markets</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('trade.index') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('trade.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="candlestick-chart" class="w-5 h-5 mr-3"></i>
                        Live Markets
                        <span class="ml-auto flex items-center px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full">
                            <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse mr-1.5"></div>
                            Live
                        </span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Real-time market trading
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('copy.dashboard') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('copy.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="users-2" class="w-5 h-5 mr-3"></i>
                        Copy Trading
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-full">Pro</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Follow expert traders
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.bots.index') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('user.bots.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="bot" class="w-5 h-5 mr-3"></i>
                        AI Trading Bots
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-full">AI</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Automated trading algorithms
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Trading Signals Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="radio" class="w-4 h-4"></i>
                <span>Market Intelligence</span>
            </div>
            
            <ul class="space-y-1">
                <!--@if(Auth::check() && Auth::user()->signals)-->
                <!--<li>-->
                <!--    <a href="{{ route('mysingals', 'All') }}"-->
                <!--       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('mysingals') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">-->
                <!--        <i data-lucide="signal" class="w-5 h-5 mr-3"></i>-->
                <!--        My Signals-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endif-->
                <li>
                    <a href="{{ route('signal') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('signals') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="zap" class="w-5 h-5 mr-3"></i>
                        Premium Signals
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full">Premium</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Expert trading insights
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Wallet & Funds Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="wallet" class="w-4 h-4"></i>
                <span>Wallet & Funds</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('deposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('deposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-3"></i>
                        Deposit Funds
                    </a>
                </li>
                <li>
                    <a href="{{ route('withdrawalsdeposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('withdrawalsdeposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="minus-circle" class="w-5 h-5 mr-3"></i>
                        Withdraw Funds
                    </a>
                </li>
                <li>
                    <a href="{{ route('transferview') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('transferview') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="arrow-left-right" class="w-5 h-5 mr-3"></i>
                        Internal Transfer
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('assetbalance') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('assetbalance') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="repeat" class="w-5 h-5 mr-3"></i>
                        Currency Exchange
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full">Swap</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Exchange between cryptocurrencies and fiat
                        </div>
                    </a>
                </li> --}}
            </ul>
        </div>

        <!-- Credit & Financing Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>Credit & Financing</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('loan') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('loan') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="file-plus" class="w-5 h-5 mr-3"></i>
                        Apply for Credit
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full">Fast</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Apply for loans and credit facilities
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('veiwloan')}}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('veiwloan') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                        Credit History
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            View your loan applications and status
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Account Management Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="user-circle" class="w-4 h-4"></i>
                <span>Account Management</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('profile') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('profile') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="user" class="w-5 h-5 mr-3"></i>
                        Profile Settings
                    </a>
                </li>
                @if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes')
                <li x-data="{ kycOpen: false }" x-cloak>
                    @if(Auth::user()->account_verify === 'Verified')
                        <!-- Verified Status -->
                        <div class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800">
                            <i data-lucide="shield-check" class="w-5 h-5 mr-3 text-green-600 dark:text-green-400"></i>
                            <span class="font-medium text-green-700 dark:text-green-300">Account Verified</span>
                        </div>
                    @else
                        <!-- KYC Dropdown -->
                        <div class="relative">
                            <button @click="kycOpen = !kycOpen"
                                    class="flex items-center w-full px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 {{ request()->routeIs('account.verify') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                                <i data-lucide="shield-alert" class="w-5 h-5 mr-3"></i>
                                <span class="flex-1 text-left">Identity Verification</span>
                                <i data-lucide="chevron-down"
                                   :class="kycOpen ? 'rotate-180' : 'rotate-0'"
                                   class="w-4 h-4 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Content -->
                            <div x-show="kycOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="mt-2 ml-8 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm" x-cloak>

                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">
                                    Identity Verification
                                </h4>

                                @if(Auth::user()->account_verify === 'Under review')
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        Your verification is under review
                                    </p>
                                    <div class="flex items-center text-xs text-yellow-600 dark:text-yellow-400">
                                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                        <span>Processing</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        Complete your identity verification to unlock full trading features
                                    </p>
                                    <a href="{{ route('account.verify') }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                                        <span>Verify Now</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </li>
                @endif
            </ul>
        </div>

        <!-- Growth & Referrals Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>Growth & Rewards</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('referuser') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('referuser') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                        Referral Program
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full">{{$settings->referral_commission}}%</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Earn {{$settings->referral_commission}}% commission on referrals
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Support & Help Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                <span>Support & Help</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('support') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('support') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="headphones" class="w-5 h-5 mr-3"></i>
                        Support Center
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Get help from our support team
                        </div>
                    </a>
                </li>
            </ul>
        </div>

            <!-- Account Actions -->
            <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                <!-- Language Translator (Mobile/Sidebar) -->
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-3 py-2 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors duration-150">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

  <!-- Sidebar overlay for mobile -->
  <div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-cloak>
  </div>

  <!-- Main content placeholder -->
  <div class="flex-1 ml-0 md:ml-64 p-4 pb-20 md:pb-4">
    <!-- Your main dashboard content goes here -->
    @yield('content')
  </div>
</div>





<!-- Modern Mobile Navigation with Glassmorphism -->
<link href="https://unpkg.com/lucide@latest" rel="stylesheet">

<div class="fixed bottom-0 w-full z-30 md:hidden" x-data="{ fabOpen: false }" x-cloak>
  <!-- Bottom Navigation Bar with Glassmorphism -->
  <div class="flex justify-between items-center bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg px-6 py-4 shadow-[0_-8px_30px_rgba(0,0,0,0.12)] relative border-t border-gray-200/20 dark:border-gray-700/20">
    <!-- Language Selector (Mobile) -->
    <div class="group flex flex-col items-center relative">
      <div class="relative">
        <div class="gtranslate_wrapper_mobile_nav"></div>
        <style>
          .gtranslate_wrapper_mobile_nav {
            display: flex;
            flex-direction: column;
            align-items: center;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper {
            position: static !important;
            transform: none !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            width: auto !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper a {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper a:hover {
            transform: scale(1.05) !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper img {
            width: 24px !important;
            height: 24px !important;
            border-radius: 4px !important;
            margin: 0 !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options {
            position: fixed !important;
            bottom: 80px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            z-index: 1000 !important;
            max-height: 300px !important;
            overflow-y: auto !important;
            width: 280px !important;
            max-width: 90vw !important;
          }

          .dark .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options {
            background: #374151 !important;
            border-color: #4b5563 !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options a {
            padding: 8px 12px !important;
            display: flex !important;
            align-items: center !important;
            flex-direction: row !important;
            gap: 8px !important;
            color: #374151 !important;
            font-size: 14px !important;
            border-bottom: 1px solid #f3f4f6 !important;
          }

          .dark .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options a {
            color: #f9fafb !important;
            border-bottom-color: #4b5563 !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options a:hover {
            background: #f3f4f6 !important;
            transform: none !important;
          }

          .dark .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options a:hover {
            background: #4b5563 !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options a:last-child {
            border-bottom: none !important;
          }

          .gtranslate_wrapper_mobile_nav .gt_float_wrapper .gt_options img {
            width: 20px !important;
            height: 20px !important;
          }
        </style>
        <script>
          if (!window.gtranslateSettingsMobileNav) {
            window.gtranslateSettingsMobileNav = {
              "default_language": "en",
              "wrapper_selector": ".gtranslate_wrapper_mobile_nav",
              "flag_style": "3d",
              "alt_flags": {"en": "usa"},
              "switcher_horizontal_position": "center",
              "switcher_vertical_position": "bottom"
            };

            // Load script for mobile nav if not already loaded
            var script = document.createElement('script');
            script.src = 'https://cdn.gtranslate.net/widgets/latest/float.js';
            script.defer = true;
            document.head.appendChild(script);
          }
        </script>

        <i data-lucide="globe" class="w-6 h-6 text-gray-500 group-hover:text-blue-600 transition-colors duration-200"></i>
      </div>
      <span class="text-xs mt-1 text-gray-500 group-hover:text-blue-600">Language</span>
    </div>

    <a href="{{ route('deposits') }}"
       class="group flex flex-col items-center relative">
      <div class="p-2 rounded-xl transition-all duration-300 ease-out
                  {{ request()->routeIs('deposits')
                     ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                     : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i data-lucide="banknote" class="w-6 h-6
           {{ request()->routeIs('deposits')
              ? 'text-blue-600 dark:text-blue-400'
              : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
           transition-colors duration-300"></i>
      </div>
      <span class="text-xs font-medium mt-1
            {{ request()->routeIs('deposits')
               ? 'text-blue-600 dark:text-blue-400'
               : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
            transition-colors duration-300">Deposit</span>
    </a>

    <a href="{{ route('profile') }}"
       class="group flex flex-col items-center relative">
      <div class="p-2 rounded-xl transition-all duration-300 ease-out
                  {{ request()->routeIs('profile')
                     ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                     : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i data-lucide="user" class="w-6 h-6
           {{ request()->routeIs('profile')
              ? 'text-blue-600 dark:text-blue-400'
              : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
           transition-colors duration-300"></i>
      </div>
      <span class="text-xs font-medium mt-1
            {{ request()->routeIs('profile')
               ? 'text-blue-600 dark:text-blue-400'
               : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
            transition-colors duration-300">Profile</span>
    </a>

    <!-- Animated FAB Button -->
    <button @click="fabOpen = !fabOpen"
            class="absolute -top-7 left-1/2 transform -translate-x-1/2
                   bg-gradient-to-r from-blue-600 to-indigo-600 text-white
                   w-14 h-14 rounded-full flex items-center justify-center
                   shadow-[0_8px_30px_rgba(59,130,246,0.5)]
                   border-4 border-white dark:border-gray-900
                   hover:scale-110 hover:shadow-[0_8px_35px_rgba(59,130,246,0.6)]
                   active:scale-95
                   transition-all duration-300 ease-out">
      <i data-lucide="zap" class="w-6 h-6 transform transition-transform group-hover:scale-110"></i>
      <!-- Pulse Effect -->
      <span class="absolute w-full h-full rounded-full bg-blue-500 animate-ping opacity-20"></span>
    </button>

<a href="{{ route('support') }}"
   class="flex flex-col items-center
          {{ request()->routeIs('support') ? 'text-blue-600 font-semibold' : 'text-gray-500' }}
          hover:text-blue-600">
  <i data-lucide="life-buoy" class="w-6 h-6"></i>
  <span class="text-xs mt-1">Support</span>
</a>



   <a href="{{ route('dashboard') }}"
   class="flex flex-col items-center
          {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-600">
 <i data-lucide="home" class="w-6 h-6 transition-colors duration-200"></i>
  <span class="text-xs mt-1">Home</span>
</a>
  </div>

  <!-- Modern FAB Overlay Menu -->
  <div x-show="fabOpen"
       @click.away="fabOpen = false"
       class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-40 flex items-center justify-center p-4"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0" x-cloak>

    <!-- Menu Card -->
    <div class="bg-gray-900 p-6 rounded-2xl
                shadow-[0_8px_30px_rgba(0,0,0,0.3)]
                space-y-4 w-72 max-w-full
                border border-gray-700
                transform transition-all duration-300
                animate-slideUp">

      <!-- Quick Actions Grid -->
      <div class="grid grid-cols-2 gap-4 mb-6">
        <a href="{{ route('mplans') }}"
           class="flex flex-col items-center p-4 rounded-xl
                  bg-gray-800 border border-gray-700
                  hover:bg-gray-700 hover:shadow-lg hover:scale-105 transition-all duration-300
                  group">
          <i data-lucide="trending-up" class="w-6 h-6 mb-2 text-blue-400
                                              group-hover:scale-110 transition-transform duration-300"></i>
          <span class="text-sm font-medium text-gray-200">Invest</span>
        </a>

        <a href="{{ route('withdrawalsdeposits') }}"
           class="flex flex-col items-center p-4 rounded-xl
                  bg-gray-800 border border-gray-700
                  hover:bg-gray-700 hover:shadow-lg hover:scale-105 transition-all duration-300
                  group">
          <i data-lucide="wallet" class="w-6 h-6 mb-2 text-green-400
                                       group-hover:scale-110 transition-transform duration-300"></i>
          <span class="text-sm font-medium text-gray-200">Withdraw</span>
        </a>
      </div>

      <!-- Menu Links -->
      <div class="space-y-2">
        <a href="{{ route('copy.dashboard') }}" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <i data-lucide="copy" class="w-5 h-5 mr-3 text-blue-400
                                     group-hover:scale-110 transition-transform duration-300"></i>
          <span class="font-medium">Copy Trading</span>
          <!--<span class="ml-auto text-xs font-bold text-green-400">New</span>-->
        </a>

        <a href="{{ route('transferview') }}" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <i data-lucide="refresh-ccw" class="w-5 h-5 mr-3 text-purple-400
                                             group-hover:rotate-180 transition-transform duration-500"></i>
          <span class="font-medium">Transfer Funds</span>
        </a>

        {{-- <a href="{{ route('assetbalance') }}" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <i data-lucide="repeat" class="w-5 h-5 mr-3 text-indigo-400
                                        group-hover:scale-110 transition-transform duration-300"></i>
          <span class="font-medium">Currency Exchange</span>
          <span class="ml-auto text-xs font-bold text-indigo-400">Swap</span>
        </a> --}}

        <a href="#" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <i data-lucide="users" class="w-5 h-5 mr-3 text-orange-400
                                      group-hover:scale-110 transition-transform duration-300"></i>
          <span class="font-medium">Refer Friends</span>
          <span class="ml-auto text-xs font-bold text-orange-400">+{{$settings->referral_commission}}%</span>
        </a>

        <a href="{{ route('support') }}" class="flex items-center p-3 rounded-lg text-gray-100
                                               hover:bg-gray-800
                                               transition-colors duration-200 group">
          <i data-lucide="life-buoy" class="w-5 h-5 mr-3 text-cyan-400
                                           group-hover:scale-110 transition-transform duration-300"></i>
          <span class="font-medium">Support</span>
        </a>

        <a href="{{ route('user.bots.index') }}" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <i data-lucide="newspaper" class="w-5 h-5 mr-3 text-indigo-400
                                          group-hover:scale-110 transition-transform duration-300"></i>
          <span class="font-medium">Bots Trading</span>
        </a>
      </div>

      <!-- Close Button -->
      <button @click="fabOpen = false"
              class="absolute top-2 right-2 p-2 rounded-full
                     text-gray-400 hover:text-gray-200
                     hover:bg-gray-800
                     transition-colors duration-200">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>
  </div>

  <style>
    @keyframes slideUp {
      from { opacity: 0; transform: scale(0.95) translateY(10px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-slideUp {
      animation: slideUp 0.3s ease-out forwards;
    }
  </style>
</div>

<!-- Script for Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  // Initialize Lucide icons
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
  });

  // Re-initialize icons when Alpine renders new content
  document.addEventListener('alpine:init', () => {
    Alpine.nextTick(() => {
      lucide.createIcons();
    });
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<!-- Live Crypto Prices Script -->
<script>
// Alpine.js component for live crypto prices
function cryptoPrices() {
  return {
    btcPrice: null,
    ethPrice: null,
    btcChange: 0,
    ethChange: 0,
    lastUpdate: null,

    async fetchPrices() {
      try {
        // Using CoinGecko API (free, no API key required)
        const response = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum&vs_currencies=usd&include_24hr_change=true');
        const data = await response.json();

        if (data.bitcoin && data.ethereum) {
          this.btcPrice = Math.round(data.bitcoin.usd);
          this.ethPrice = Math.round(data.ethereum.usd);
          this.btcChange = data.bitcoin.usd_24h_change || 0;
          this.ethChange = data.ethereum.usd_24h_change || 0;
          this.lastUpdate = new Date();

          console.log('Crypto prices updated:', {
            BTC: this.btcPrice,
            ETH: this.ethPrice,
            time: this.lastUpdate
          });
        }
      } catch (error) {
        console.error('Error fetching crypto prices:', error);
        // Fallback to static values on error
        this.btcPrice = this.btcPrice || 45320;
        this.ethPrice = this.ethPrice || 2850;
      }

      // Update prices every 30 seconds
      setTimeout(() => this.fetchPrices(), 30000);
    }
  }
}

// Initialize when Alpine is ready
document.addEventListener('alpine:init', () => {
  // Register the component globally
  Alpine.data('cryptoPrices', cryptoPrices);
});
</script>

@yield('scripts')
@include('layouts.lang')
@include('layouts.livechat')
</body>
</html>
