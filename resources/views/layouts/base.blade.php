
<!DOCTYPE html>
<html lang="en" class="dark">
<script>try { if (localStorage.getItem("darkMode") === "light") document.documentElement.classList.remove("dark"); } catch(e) {}</script>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#6366F1',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                        dark: {
                            100: '#374151',
                            200: '#1F2937',
                            300: '#111827',
                            400: '#0F172A',
                            500: '#0B1120',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        /* Alpine.js x-cloak directive */
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1F2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Form elements styling */
        .form-input {
            @apply bg-dark-100 border-0 rounded-lg px-4 py-3 text-gray-100 font-medium focus:ring-2 focus:ring-primary focus:outline-none transition-all duration-200;
        }

        .form-select {
            @apply bg-dark-100 border-0 rounded-lg px-4 py-3 text-gray-100 font-medium focus:ring-2 focus:ring-primary focus:outline-none transition-all duration-200;
        }

        .btn-primary {
            @apply bg-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
        }

        .btn-secondary {
            @apply bg-dark-100 hover:bg-dark-200 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
        }

        /* Navbar and mobile menu animations */
        .navbar-dropdown {
            @apply transition-all duration-300 ease-in-out transform origin-top;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Light mode overrides */
        /* Public navigation/footer light theme */
        html:not(.dark) header { background: #fff; border-color: #e5e7eb; }
        html:not(.dark) header .text-gray-200, html:not(.dark) header .text-gray-300 { color: #374151; }
        html:not(.dark) footer { background: #f8fafc; }
        html:not(.dark) footer .text-white { color: #111827; }
        html:not(.dark) {
            @apply bg-gray-100 text-gray-900;
        }

        html:not(.dark) body {
            @apply bg-gray-100 text-gray-900;
        }

        html:not(.dark) .bg-dark-400 {
            @apply bg-white;
        }

        html:not(.dark) .bg-dark-300 {
            @apply bg-gray-50;
        }

        html:not(.dark) .border-gray-800 {
            @apply border-gray-200;
        }

        html:not(.dark) .text-gray-200,
        html:not(.dark) .text-gray-300,
        html:not(.dark) .text-gray-400 {
            @apply text-gray-700;
        }

        html:not(.dark) .hover\:bg-dark-200:hover,
        html:not(.dark) .hover\:bg-gray-700:hover {
            @apply hover:bg-gray-200;
        }

        html:not(.dark) .bg-dark-500 {
            @apply bg-gray-100;
        }

/* AGROTRADE_UI_R2: public theme and compact language control */
.agrotrade-language { position: relative; min-width: 66px; max-width: 76px; flex-shrink: 0; }
.agrotrade-language .gtranslate_wrapper { width: 100%; }
.agrotrade-language select { width: 100%; max-width: 76px; height: 35px; padding: 0 19px 0 8px; border: 1px solid #334155; border-radius: 9px; background: #1e293b; color: #f8fafc; font: 600 12px/1.2 Inter, sans-serif; cursor: pointer; color-scheme: dark; }
.agrotrade-language select option { background: #1e293b; color: #f8fafc; }
html:not(.dark) .agrotrade-language select { background: #f1f5f9; border-color: #cbd5e1; color: #0f172a; color-scheme: light; }
html:not(.dark) .agrotrade-language select option { background: #fff; color: #0f172a; }
.agrotrade-language select:focus-visible { outline: 2px solid #3b82f6; outline-offset: 2px; }
html:not(.dark) .agrotrade-hero { background: linear-gradient(135deg, #f8fafc 0%, #e8f2ff 100%); }
html:not(.dark) .agrotrade-hero h1 .text-white { color: #0f172a; }
html:not(.dark) .agrotrade-hero p.text-gray-300 { color: #475569; }
html:not(.dark) .agrotrade-hero a.bg-dark-200 { background: #fff; color: #0f172a; border-color: #cbd5e1; }
html:not(.dark) .agrotrade-hero .text-primary { color: #2563eb; }
html:not(.dark) .agrotrade-hero .bg-blue-900 { background-color: #dbeafe; }

/* AGROTRADE_HERO_STICKY_R3: scoped public UI correction */
header { position: sticky !important; top: 0; z-index: 60 !important; }
/* Dark hero is preserved. Only light mode overrides its hard-coded colors. */
html:not(.dark) .agrotrade-hero { background: linear-gradient(135deg,#f8fafc 0%,#e9f2ff 100%) !important; }
html:not(.dark) .agrotrade-hero h1,
html:not(.dark) .agrotrade-hero h1 .text-white { color: #0f172a !important; }
html:not(.dark) .agrotrade-hero h1 .bg-clip-text { color: transparent !important; }
html:not(.dark) .agrotrade-hero p.text-gray-300,
html:not(.dark) .agrotrade-hero .space-y-6 > p { color: #475569 !important; }
html:not(.dark) .agrotrade-hero .text-primary { color: #1d4ed8 !important; }
html:not(.dark) .agrotrade-hero .bg-blue-900 { background-color: #dbeafe !important; }
html:not(.dark) .agrotrade-hero a.bg-dark-200 { background: #fff !important; color: #0f172a !important; border-color: #cbd5e1 !important; }
html:not(.dark) .agrotrade-hero a.bg-blue-600 { background-color: #2563eb !important; color: #fff !important; }
/* Keep the market chart itself dark: TradingView is independently themed. */
    </style>

    <title>{{$settings->site_name}} | CFD Trading — Trading on Stocks, Gold, Oil, Indices</title>
    <link rel="manifest" href="./">
    <meta name="theme-color" content="#111827">    <meta property="x-session-id" content="ghJjEOrjZ3KUPun1UQksVUbvK88y21dgIhKtb8GT">
    <meta property="og:site_name" content="{{$settings->site_name}}">
    <meta property="og:description" content="CFD Trading with {{$settings->site_name}}. Trading on Stocks, Gold, Oil, Indices with ultra-fast execution &amp; spreads from 0.0 pips. News, articles and training materials for experienced and novice traders.">
    <meta name="description" content="CFD Trading with {{$settings->site_name}}. Trading on Stocks, Gold, Oil, Indices with ultra-fast execution &amp; spreads from 0.0 pips. News, articles and training materials for experienced and novice traders.">
    <meta name="keywords" content="forex, CFDs, CFD, Bitcoin trading, crypto trading, online trading, Forex trading, Oil trading, Gold trading, trading indexes, shares trading, commodities trading, trading platform, Cryptocurrencies day trading">
    <meta property="og:type" content="website">
    <meta property="og:title" content="CFD Trading — Trading on Stocks, Gold, Oil, Indices | {{$settings->site_name}}">
    <meta property="og:image" content="img/share.jpg">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/app/public/'.$settings->favicon)}}" type="image/x-icon">

    <!-- Preload key assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery (required for some components) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript utilities -->
    <script>
        // Utility function for mobile menu
        document.addEventListener('alpine:init', () => {
            Alpine.store('navigation', {
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            });

            // Theme toggler
            Alpine.store('darkMode', {
                on: document.documentElement.classList.contains("dark"),
                toggle() {
                    this.on = !this.on;
                    if (this.on) {
                        document.documentElement.classList.add('dark');
                        document.body.classList.add('bg-gray-900');
                        document.body.classList.remove('bg-gray-100');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.body.classList.remove('bg-gray-900');
                        document.body.classList.add('bg-gray-100');
                    }
                    localStorage.setItem('darkMode', this.on ? 'dark' : 'light');
                }
            });
        });
    </script>
</head>

<body class="antialiased text-gray-200 bg-gray-900 font-sans min-h-screen flex flex-col">
    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:bg-blue-700 focus:text-white focus:fixed focus:px-4 focus:py-2 focus:top-2 focus:left-2 focus:z-50">
        Skip to main content
    </a>




















    <!-- Header -->
<header class="bg-gray-900 border-b border-gray-800 relative z-50 agrotrade-sticky-nav">
    <!-- Top Navigation Bar -->
    <div x-data="{ mobileMenuOpen: false }" class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                    </a>
                </div>

                <!-- Main Navigation - Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Trading</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Cryptocurrencies</a>
                            <a href="forex" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Forex</a>
                            <a href="shares" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Shares</a>
                            <a href="indices" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Indices</a>
                            <a href="etfs" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">ETFs</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>System</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="trade" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Trade</a>
                            <a href="copy" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Copy Trading</a>
                            <a href="automate" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Automated Trading</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Company</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="about" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">About Us</a>
                            <a href="why-us" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Why Us</a>
                            <a href="faq" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">FAQ</a>
                            <a href="regulation" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Legal & Regulation</a>
                        </div>
                    </div>

                    <a href="for-traders" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white">Education</a>
                    <a href="contacts" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white">Contact</a>
                </nav>

                <!-- Shared language selector -->
                <div class="agrotrade-language flex items-center mr-2">@include('layouts.lang')</div>
                <!-- Right Navigation -->
                <div class="hidden md:flex items-center">
                    <div class="flex space-x-1 mr-4">
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Desktop Version">
                            <i class="fas fa-desktop"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Windows App">
                            <i class="fab fa-windows"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Android App">
                            <i class="fab fa-android"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="iOS App">
                            <i class="fab fa-apple"></i>
                        </a>
                    </div>

                    <!-- Language Selector (Desktop) -->
                 

                    <!-- Dark/Light Mode Toggle -->
<button type="button" x-data @click="$store.darkMode.toggle()" class="p-2 mr-2 rounded-md text-gray-400 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Toggle color theme" :aria-pressed="$store.darkMode.on.toString()">
  <i x-show="$store.darkMode.on" class="fas fa-sun" aria-hidden="true"></i>
  <i x-show="!$store.darkMode.on" class="fas fa-moon" aria-hidden="true"></i>
</button>


                    <div class="flex items-center space-x-4">
                        <a href="login" class="text-gray-200 hover:text-white flex items-center">
                            <i class="fas fa-lock mr-1"></i>
                            <span>Log in</span>
                        </a>
                        <a href="register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Sign up
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button and theme toggle -->
                <div class="flex md:hidden items-center space-x-2">
                    <!-- Mobile Theme Toggle -->
<button type="button" x-data @click="$store.darkMode.toggle()" class="p-2 mr-2 rounded-md text-gray-400 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Toggle color theme" :aria-pressed="$store.darkMode.on.toString()">
  <i x-show="$store.darkMode.on" class="fas fa-sun" aria-hidden="true"></i>
  <i x-show="!$store.darkMode.on" class="fas fa-moon" aria-hidden="true"></i>
</button>


                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="md:hidden" id="mobile-menu" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <!-- Mobile Navigation -->
                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Trading</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
                        <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Cryptocurrencies</a>
                        <a href="forex" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Forex</a>
                        <a href="shares" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Shares</a>
                        <a href="indices" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Indices</a>
                        <a href="etfs" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">ETFs</a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>System</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
                        <a href="trade" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Trade</a>
                        <a href="copy" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Copy Trading</a>
                        <a href="automate" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Automated Trading</a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Company</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
                        <a href="about" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">About Us</a>
                        <a href="why-us" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Why Us</a>
                        <a href="faq" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">FAQ</a>
                        <a href="regulation" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Legal & Regulation</a>
                    </div>
                </div>

                <a href="for-traders" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Education</a>
                <a href="contacts" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Contact</a>

                <!-- Language Selector (Mobile) -->
               
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center justify-between px-4">
                        <div class="flex items-center space-x-3">
                            <a href="login" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-lock mr-1"></i> Log in
                            </a>
                            <a href="register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Sign up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



    <!--  sub menu -->

<!-- Market Ticker Widget -->
<div class="bg-dark-300 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-1">
            <div class="crypto-ticker-wrapper">
                <iframe src="https://widget.coinlib.io/widget?type=horizontal_v2&theme=dark&pref_coin_id=1505&invert_hover=no"
                        width="100%"
                        height="36px"
                        scrolling="auto"
                        marginwidth="0"
                        marginheight="0"
                        frameborder="0"
                        border="0"
                        class="w-full">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<main id="main-content" class="flex-grow">
    @yield('content')
</main>







<!-- Footer -->
<footer class="bg-dark-400 text-gray-300">
    <!-- Upper Footer -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center mb-6">
                            <a href="/" class="flex items-center">
                                <img class="h-8 w-auto" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                            </a>
                        </div>
                        <p class="text-sm text-gray-400 mb-6">
                            {{$settings->site_name}} offers CFD trading on stocks, forex, indices, commodities, and cryptocurrencies with competitive spreads and advanced trading tools.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Twitter</span>
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">LinkedIn</span>
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="mailto:{{$settings->contact_email}}" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Email</span>
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                        <ul class="space-y-3">
                            <li><a href="about" class="text-sm text-gray-400 hover:text-white transition">About Us</a></li>
                            <li><a href="why-us" class="text-sm text-gray-400 hover:text-white transition">Why Choose Us</a></li>
                            <li><a href="for-traders" class="text-sm text-gray-400 hover:text-white transition">Education</a></li>
                            <li><a href="contacts" class="text-sm text-gray-400 hover:text-white transition">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Trading -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Trading</h3>
                        <ul class="space-y-3">
                            <li><a href="cryptocurrencies" class="text-sm text-gray-400 hover:text-white transition">Cryptocurrencies</a></li>
                            <li><a href="forex" class="text-sm text-gray-400 hover:text-white transition">Forex</a></li>
                            <li><a href="shares" class="text-sm text-gray-400 hover:text-white transition">Shares</a></li>
                            <li><a href="indices" class="text-sm text-gray-400 hover:text-white transition">Indices</a></li>
                        </ul>
                    </div>

                    <!-- Account -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Your Account</h3>
                        <ul class="space-y-3">
                            <li><a href="login" class="text-sm text-gray-400 hover:text-white transition">Log In</a></li>
                            <li><a href="register" class="text-sm text-gray-400 hover:text-white transition">Create Account</a></li>
                            <li><a href="login" class="text-sm text-gray-400 hover:text-white transition">Demo Account</a></li>
                            <li><a href="contact" class="text-sm text-gray-400 hover:text-white transition">Help Center</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Availability -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h4 class="text-sm font-semibold text-white">Available On</h4>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Web Platform">
                            <i class="fas fa-desktop mr-2"></i>
                            <span class="text-sm">Web</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Windows App">
                            <i class="fab fa-windows mr-2"></i>
                            <span class="text-sm">Windows</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Android App">
                            <i class="fab fa-android mr-2"></i>
                            <span class="text-sm">Android</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="iOS App">
                            <i class="fab fa-apple mr-2"></i>
                            <span class="text-sm">iOS</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disclaimer & Legal -->
    <div class="bg-dark-500 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="text-xs text-gray-400">
                    <p class="mb-4 leading-relaxed">
                        <span class="font-semibold text-gray-300">RISK WARNING:</span> The Financial Products offered by the company include Contracts for Difference ('CFDs') and other complex financial products. Trading CFDs carries a high level of risk since leverage can work both to your advantage and disadvantage. As a result, CFDs may not be suitable for all investors because it is possible to lose all of your invested capital. You should never invest money that you cannot afford to lose. Before trading in the complex financial products offered, please ensure you understand the risks involved.
                    </p>
                    <div class="flex flex-wrap gap-4 mb-4">
                        <a href="terms" class="text-blue-400 hover:text-blue-300 transition">Terms & Conditions</a>
                        <a href="privacy" class="text-blue-400 hover:text-blue-300 transition">Privacy Policy</a>
                        <a href="regulation" class="text-blue-400 hover:text-blue-300 transition">Legal Documents</a>
                    </div>
                    <p>© <script>document.write(new Date().getFullYear())</script> {{$settings->site_name}}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    

</footer>

<!-- Sticky Market Ticker Widget -->
<div class="fixed bottom-0 left-0 right-0 z-30 bg-dark-400 border-t border-gray-800">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        {
        "symbols": [
        {
            "title": "EUR/USD"
        },
        {
            "title": "BTC/USD"
        },
        {
            "title": "ETH/USD"
        }
        ],
        "colorTheme": "dark",
        "isTransparent": false,
        "displayMode": "adaptive",
        "locale": "en"
        }
        </script>
    </div>
</div>

<!-- Live Chat Button -->
{{-- <div class="fixed bottom-20 right-6 z-40">
    <button onclick="openLiveChat(event)" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
        <i class="fas fa-comments text-xl"></i>
    </button>
</div> --}}











     <style>
       .last-widget{
          position: sticky;
          z-index: 10;
          bottom: 0;
        }
   </style>


        <div class = "last-widget">
        <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" >
  <div class="tradingview-widget-container__widget"></div>

  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
  {
      "proName": "FX_IDC:EURUSD",
      "title": "EUR/USD"
  },
  {
      "proName": "BITSTAMP:BTCUSD",
      "title": "BTC/USD"
  },
  {
      "proName": "BITSTAMP:ETHUSD",
      "title": "ETH/USD"
  }
  ],
  "colorTheme": "dark",
  "isTransparent": false,
  "displayMode": "adaptive",
  "locale": "en"
}
  </script>
</div>


        <!-- GetButton.io widget -->
<!--<script type="text/javascript">-->
<!--    (function () {-->
<!--        var options = {-->
            <!--whatsapp: "{{$settings->whatsapp}}", // WhatsApp number-->
            <!--call_to_action: "Message us", // Call to action-->
            <!--button_color: "#FF6550", // Color of button-->
            <!--position: "right", // Position may be 'right' or 'left'-->
<!--        };-->
<!--        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;-->
<!--        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';-->
<!--        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };-->
<!--        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);-->
<!--    })();-->
<!--</script>-->
<!-- Additional Scripts -->
<script>
    // Live Chat Function
    function openLiveChat(e) {
        e.preventDefault();
        console.log('Opening live chat...');
        // Implement your live chat functionality here
    }

    // Theme toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any custom components
        console.log('DOM loaded, initializing components...');
    });

    // Analytics (preserved from original)
    function bindGAEvents(eventCategory, callback, iter) {
        if (typeof iter === "undefined") { iter = 1; }
        if(window.dataLayer) {
            if (typeof callback === "function") {
                callback();
            }
        } else if(iter > 2 && typeof callback === "function") {
            callback();
        } else {
            setTimeout(function(){
                bindGAEvents(eventCategory, callback, iter + 1);
            }, 500);
        }
    }

    $(document).ready(function() {
        if('' == '1') {
            bindGAEvents('ex_new_user');
        }

        $(document).on('click', '.start-trading, .open-live-account, .open-demo-account', function (event) {
            var redirectLink = $(this).attr('href');
            bindGAEvents('ex_button', function(){
                window.location.href = redirectLink;
            });
            event.preventDefault();
        });
    });
</script>

@include('layouts.livechat')
<script>
/* Preserve GTranslate language values; abbreviate only option labels. */
(function () {
  const names = { english:'EN', french:'FR', spanish:'ES', german:'DE', portuguese:'PT', arabic:'AR', chinese:'ZH', 'chinese (simplified)':'ZH', 'chinese (traditional)':'ZH-TW', japanese:'JA', korean:'KO', italian:'IT', russian:'RU', hindi:'HI', dutch:'NL', turkish:'TR', swahili:'SW', hausa:'HA', yoruba:'YO', igbo:'IG' };
  function shorten() {
    document.querySelectorAll('.agrotrade-language select').forEach(function (select) {
      Array.from(select.options).forEach(function (option) {
        if (!option.dataset.fullLanguage) option.dataset.fullLanguage = option.textContent.trim();
        const full = option.dataset.fullLanguage;
        const code = option.value.trim().split('|').pop();
        const abbreviation = /^[a-z]{2,3}(-[a-z]{2,4})?$/i.test(code) ? code.toUpperCase() : (names[full.toLowerCase()] || full.slice(0, 2).toUpperCase());
        if (option.textContent !== abbreviation) option.textContent = abbreviation;
        option.title = full;
      });
      select.setAttribute('aria-label', 'Select translation language');
      select.title = 'Select language';
    });
  }
  document.addEventListener('DOMContentLoaded', function () {
    shorten();
    const target = document.querySelector('.agrotrade-language');
    if (target) new MutationObserver(shorten).observe(target, { childList: true, subtree: true });
  });
})();
</script>
</body>
</html>
