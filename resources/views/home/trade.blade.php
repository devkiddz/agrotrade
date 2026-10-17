@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gray-900 overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <!-- Grid Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="trading-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="20" cy="20" r="1" fill="currentColor"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#trading-grid)"/>
                </svg>
            </div>
        </div>
        <!-- Accent Elements -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full filter blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 pt-20 pb-12 relative z-10">
        <div class="max-w-4xl">
            <!-- Header Content -->
            <div class="space-y-6">
                <div class="inline-block px-4 py-1 rounded-full bg-blue-500/10 border border-blue-500/20">
                    <p class="text-sm font-medium text-blue-400">Professional Trading Platform</p>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    cTRADER <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">TRADE</span>
                </h1>

                <!-- Breadcrumb -->
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{$settings->site_address}}" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                {{$settings->site_name}}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="#" class="text-gray-400 hover:text-white ml-1 md:ml-2 transition-colors">cTrader</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-300 ml-1 md:ml-2">Trade</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "item": {
                "@id": "{{$settings->site_address}}",
                "name": "{{$settings->site_name}}"
            }
        },
        {
            "@type": "ListItem",
            "position": 2,
            "item": {
                "@id": "{{$settings->site_address}}platforms/ctrader-overview",
                "name": "cTrader"
            }
        },
        {
            "@type": "ListItem",
            "position": 3,
            "item": {
                "@id": "{{$settings->site_address}}ctrader/trade",
                "name": "Trade"
            }
        }
    ]
}</script>




</div></div></div></div>





<!-- Features Grid Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Reliable -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                <div class="relative p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500/50 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Reliable</h3>
                    <p class="text-gray-300">Featuring the market's sharpest execution, {{$settings->site_name}} Trade cTrader fills your orders in milliseconds without any requotes or price manipulation.</p>
                </div>
            </div>

            <!-- Intelligent -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                <div class="relative p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500/50 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Intelligent</h3>
                    <p class="text-gray-300">Make informed decisions with smart market analysis tools, Live Sentiment data and in-platform market insights from Trading Central.</p>
                </div>
            </div>

            <!-- Transparent -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                <div class="relative p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500/50 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Transparent</h3>
                    <p class="text-gray-300">Access transaction statistics, equity charts and detailed history of your deals for a crystal clear understanding of your performance.</p>
                </div>
            </div>

            <!-- Intuitive -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                <div class="relative p-6 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500/50 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Intuitive</h3>
                    <p class="text-gray-300">Easy to use and navigate, {{$settings->site_name}} Trade cTrader was built with real traders' needs in mind. Trade with {{$settings->site_name}} Trade cTrader and experience its distinct advantage.</p>
                </div>
            </div>
        </div>
    </div>
</section>



</div></div></div>
</section>







<!-- Expert Support Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Image -->
            <div class="relative" data-aos="fade-right" data-aos-duration="1200">
                <div class="relative">
                    <!-- Decorative Elements -->
                    <div class="absolute -inset-4">
                        <div class="w-full h-full mx-auto opacity-30 blur-lg filter">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-emerald-500 rounded-3xl"></div>
                        </div>
                    </div>

                    <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="commission-scheme" class="relative rounded-xl shadow-2xl w-full">
                </div>
            </div>

            <!-- Right Column - Content -->
            <div class="space-y-10">
                <!-- Expert Support -->
                <div class="bg-gray-800 rounded-xl p-8 border border-gray-700 hover:border-blue-500/50 transition-all duration-300">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        STAY UP TO DATE WITH OUR EXPERTS!
                    </h2>
                    <p class="text-gray-300 leading-relaxed">
                        Our local and international teams are here to support you on a 24/5 basis in more than 20 languages, while our wide range of payment methods gives you greater flexibility when it comes to deposits and withdrawals.
                    </p>
                </div>

                <!-- Trading Experience -->
                <div class="bg-gray-800 rounded-xl p-8 border border-gray-700 hover:border-emerald-500/50 transition-all duration-300">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Experience More Than Trading
                    </h2>
                    <p class="text-gray-300 leading-relaxed">
                        Our success is centred around a number of core values. They include providing competitive brokerage fees through tight spreads, ensuring lightning-fast execution, access to advanced trading platforms with a wide range of products, and exceptional customer service.
                    </p>
                </div>

                <!-- CTA Button -->
                <div class="pt-4">
                    <a href="about" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl" title="Learn About {{$settings->site_name}} Trade Commissions">
                        Learn More About Our Services
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
