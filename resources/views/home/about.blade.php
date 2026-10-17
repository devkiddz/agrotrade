
@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', 'About Us')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-20 md:z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full opacity-60 md:opacity-20">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="a" x1="50%" x2="50%" y1="0%" y2="100%">
                        <stop stop-color="#3B82F6" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#10B981" stop-opacity=".2" offset="100%"/>
                    </linearGradient>
                </defs>
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(0 -50)" />
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(350 150)" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-full h-full opacity-50 md:opacity-10">
            <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                    <path d="M733 738L520 660M603 493L731 737M520 660L309 538"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Our Company
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                <span class="block">About {{$settings->site_name}}</span>
                <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">We make trading available for everybody</span>
            </h1>
            <p class="max-w-2xl mt-5 mx-auto text-xl text-gray-300">
                Discover our mission to become the world's most trusted trading platform through innovation, security, and exceptional service
            </p>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-white">Our Values</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Value Card 1 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <!-- Card Background Glow Effect -->
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>

                <!-- Card Content -->
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/users.png" alt="Client Focus" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Client Focus</h3>
                    <p class="text-gray-300 text-center">Providing best customer service is our primary value. More than 100 account managers are focused on needs of our clients.</p>
                </div>
            </div>

            <!-- Value Card 2 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/website.png" alt="Simplicity" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Simplicity</h3>
                    <p class="text-gray-300 text-center">Everybody can become a trader with our easiest to use trading platform. {{$settings->site_name}} is available on all modern platforms: Web, Windows, MacOS, iPhone, iPad and Android.</p>
                </div>
            </div>

            <!-- Value Card 3 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/speed.png" alt="Speed" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Speed</h3>
                    <p class="text-gray-300 text-center">We provide fastest trading using cutting-edge technologies. No delays in order executions and lags in user interface.</p>
                </div>
            </div>

            <!-- Value Card 4 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/1497835.png" alt="Reliability" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Reliability</h3>
                    <p class="text-gray-300 text-center">Being industry leader we provide our clients with extra solidity. We are doing more than anyone else to satisfy needs of our clients.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-gray-800 relative overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 z-0 opacity-5">
        <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                    <path d="M 50 0 L 0 0 0 50" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white">Why is {{$settings->site_name}} One of the World's Most Trusted Brands?</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <div class="w-full lg:w-1/2">
                <div class="bg-gray-900 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-lg">
                    <img src="temp/custom/img/commission-scheme-crypt1d.png" alt="Trading Platform" class="w-full h-auto">
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Globally Regulated</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">40+ International Awards</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">24/7 Multilingual Customer Support</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Segregated Client Funds</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Personal Account Managers</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Consistently Tighter Spreads</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-8">
                    <a href="login" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Learn About Our Commissions
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="py-16 bg-gray-900 relative overflow-hidden">
    <!-- Background image with overlay -->
    <div class="absolute inset-0 z-0 opacity-20" style="background-image: url(temp/custom/img/abt.png); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white">About Us</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden p-6 md:p-10">
            <div class="prose prose-lg prose-invert max-w-none">
                <p>
                    {{$settings->site_name}} has become one of the most reputable brokers in the industry, offering to traders CFDs across Forex, Equities, Commodities and Futures. Trading on the Forex market is a legitimate and straightforward way of generating income. And the good news is that you don't have to be a professional trader in order to make money. All you need is the right personality and the right skill set and you can make money trading on foreign exchanges.
                </p>
                <p>
                    {{$settings->site_name}} lets you trade in the way that best suits you. Do you want to risk a little or a lot? Do you want gains in the short term or are you playing a longer game? Are you a day trader, a swing trader or a scalper? Are you an old hand or a rookie just testing the water? It does not matter because {{$settings->site_name}} puts you in control.
                </p>
                <p>
                    If you can control today's success and not let it cloud tomorrow's judgment, you probably have it in you to make money as a currency trader. The prizes in Forex are certainly glittering but it is level headedness and persistence that win the day. With the right tools, information and access to all the world's currencies, {{$settings->site_name}} puts you in control of the trades you make.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Expert Support Section -->
<section class="py-16 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse lg:flex-row gap-8 items-center">
            <!-- Left side: Image -->
            <div class="w-full lg:w-1/2">
                <div class="relative">
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-500 opacity-20 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-teal-400 opacity-20 rounded-full blur-xl"></div>

                    <!-- Image -->
                    <div class="relative bg-gray-900 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-lg">
                        <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Expert Support" class="w-full h-auto">
                    </div>
                </div>
            </div>

            <!-- Right side: Content -->
            <div class="w-full lg:w-1/2 space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">STAY UP TO DATE WITH OUR EXPERTS!</h2>
                    <p class="text-gray-300">
                        Our local and international teams are here to support you on a 24/5 basis in more than 20 languages, while our wide range of payment methods gives you greater flexibility when it comes to deposits and withdrawals.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">Experience More Than Trading</h2>
                    <p class="text-gray-300">
                        Our success is centred around a number of core values. They include providing competitive brokerage fees through tight spreads, ensuring lightning-fast execution, access to advanced trading platforms with a wide range of products, and exceptional customer service.
                    </p>
                </div>

                <div class="pt-6">
                    <a href="register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Start Trading Now
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

