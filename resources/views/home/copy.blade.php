@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <div class="absolute top-0 left-0 w-full h-full">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad1" x1="50%" x2="50%" y1="0%" y2="100%">
                        <stop stop-color="#3B82F6" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#10B981" stop-opacity=".2" offset="100%"/>
                    </linearGradient>
                </defs>
                <path fill="url(#grad1)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-full h-full">
            <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2" opacity="0.15">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <div class="w-full md:w-2/3" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Advanced Trading Platform
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">cTRADER COPY</span>
                        <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Smart Strategy Replication</span>
                    </h1>
                    <p class="mt-3 text-lg text-gray-300 max-w-2xl mx-auto">
                        Replicate successful trading strategies from top-performing traders. Diversify your portfolio and maximize profits with our intelligent copy-trading platform.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 mt-6">
                        <a href="register" class="px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Get Started
                        </a>
                        <a href="#features" class="px-6 py-3 text-base font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Key Features
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Amplify Your Trading Potential</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Our copy trading platform delivers innovative features to help you optimize your investment strategy and maximize returns.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Copy 400+ Strategies</h3>
                <p class="text-gray-300">Access hundreds of strategies for more than 1000 instruments across 7 asset classes, providing diverse opportunities for every trading style.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Select Top Performers</h3>
                <p class="text-gray-300">Use our advanced reporting tools to rank strategies according to performance and select the most suitable ones for your unique circumstances.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Stay Protected</h3>
                <p class="text-gray-300">Our system employs sophisticated calculations to maintain your exposure at an optimal level for your account, protecting your investments.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Combine With Other Methods</h3>
                <p class="text-gray-300">Our integrated platform allows you to combine copying with manual and automated trading, tailoring your approach to your preferences.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Trading Process
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">How Copy Trading Works</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Get started with copy trading in just a few simple steps
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">1</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Browse Strategies</h3>
                    <p class="text-gray-300">Explore our marketplace of trading strategies. Filter by performance metrics, risk level, asset class, and more to find strategies that match your investment goals.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">2</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Select & Subscribe</h3>
                    <p class="text-gray-300">Choose the strategies you want to follow. Set your risk parameters and allocation amount to customize how much capital you want to allocate to each strategy.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">3</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Automated Trading</h3>
                    <p class="text-gray-300">Once subscribed, trades will be automatically executed in your account based on the strategy provider's activity, adjusted to your risk settings and capital allocation.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Expert Support Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image Column -->
            <div class="relative" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 300)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    class="relative z-10"
                >
                    <div class="relative rounded-lg overflow-hidden shadow-2xl">
                        <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Expert Support" class="w-full">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-400 opacity-20"></div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-teal-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="space-y-8" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 500)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                >
                    <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Premium Support
                    </div>

                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">
                        <span class="block">STAY UP TO DATE</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">WITH OUR EXPERTS!</span>
                    </h2>

                    <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 mb-8">
                        <p class="text-gray-300 text-lg">
                            Our local and international teams are here to support you on a 24/5 basis in more than 20 languages, while our wide range of payment methods gives you greater flexibility when it comes to deposits and withdrawals.
                        </p>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-4">Experience More Than Trading</h3>

                    <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
                        <p class="text-gray-300 text-lg">
                            Our success is centred around a number of core values. They include providing competitive brokerage fees through tight spreads, ensuring lightning-fast execution, access to advanced trading platforms with a wide range of products, and exceptional customer service.
                        </p>
                    </div>

                    <div class="mt-8">
                        <a href="about" title="Learn About {{$settings->site_name}} Trade Commissions" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500 transition-all duration-200">
                            Learn More
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="relative px-8 py-12 md:p-12 lg:px-16 lg:py-16">
                <!-- Background Pattern -->
                <div class="absolute inset-0 overflow-hidden opacity-10">
                    <svg class="absolute right-0 top-0 h-full" viewBox="0 0 800 800">
                        <path fill="none" stroke="white" stroke-width="2" d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764">
                        </path>
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Ready to Start Copy Trading?
                    </h2>
                    <p class="mt-4 text-xl text-blue-100">
                        Join thousands of traders using our platform to replicate successful strategies and maximize profits.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="/register" class="px-8 py-4 text-base font-medium text-blue-900 bg-white border border-transparent rounded-lg shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Create Free Account
                        </a>
                        <a href="login" class="ml-4 px-8 py-4 text-base font-medium text-white bg-transparent border border-white rounded-lg shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
