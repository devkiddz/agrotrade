@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', 'cTrader Automate - Algorithmic Trading')

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
        <div class="flex flex-col-reverse items-center gap-8 md:flex-row">
            <!-- Left Column - Text Content -->
            <div class="w-full md:w-1/2" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Automated Trading
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">cTrader Automate</span>
                        <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Trading Algorithms Made Simple</span>
                    </h1>
                    <p class="mt-3 text-lg text-gray-300">
                        Create, customize, and deploy algorithmic trading strategies with ease. Take advantage of market opportunities 24/7 with smart automation.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="#features" class="px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Explore Features
                        </a>
                        <a href="#faq" class="px-6 py-3 text-base font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Chart Animation -->
            <div class="w-full md:w-1/2">
                <div class="relative h-64 md:h-96 overflow-hidden rounded-2xl shadow-2xl bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-full h-full p-6">
                            <div class="relative w-full h-full">
                                <!-- Trading Chart Visualization -->
                                <div class="absolute inset-0 flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            <span class="text-xs font-medium text-gray-300">BTC/USD</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-green-400">$38,245.75</span>
                                            <span class="text-xs text-green-400">+2.4%</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <!-- SVG Trading Chart Animation -->
                                        <svg class="w-full h-full" viewBox="0 0 400 200" preserveAspectRatio="none">
                                            <!-- Chart Grid Lines -->
                                            <line x1="0" y1="40" x2="400" y2="40" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="80" x2="400" y2="80" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="120" x2="400" y2="120" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="160" x2="400" y2="160" stroke="#374151" stroke-width="0.5" />

                                            <!-- Animated Chart Path -->
                                            <path d="M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20"
                                                  stroke="url(#chartGradient)" stroke-width="2" fill="none" stroke-linecap="round">
                                                <animate attributeName="d"
                                                    values="
                                                        M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20;
                                                        M0,140 C20,130 40,110 60,100 C80,90 100,70 120,80 C140,90 160,100 180,90 C200,80 220,40 240,50 C260,60 280,80 300,70 C320,60 340,40 360,50 C380,60 400,40 400,30;
                                                        M0,130 C20,140 40,120 60,130 C80,140 100,100 120,90 C140,80 160,70 180,60 C200,50 220,60 240,70 C260,80 280,90 300,80 C320,70 340,50 360,60 C380,70 400,50 400,40;
                                                        M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20"
                                                    dur="20s" repeatCount="indefinite" />
                                            </path>

                                            <!-- Gradient Definition -->
                                            <defs>
                                                <linearGradient id="chartGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#3B82F6" />
                                                    <stop offset="100%" stop-color="#10B981" />
                                                </linearGradient>
                                            </defs>
                                        </svg>

                                        <!-- Algorithm Markers -->
                                        <div class="absolute top-1/4 right-1/3 w-4 h-4 bg-blue-500 bg-opacity-30 rounded-full animate-ping">
                                            <div class="absolute inset-0 w-2 h-2 m-1 bg-blue-400 rounded-full"></div>
                                        </div>
                                        <div class="absolute top-2/3 left-1/4 w-4 h-4 bg-green-500 bg-opacity-30 rounded-full animate-ping" style="animation-delay: 1s">
                                            <div class="absolute inset-0 w-2 h-2 m-1 bg-green-400 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Algo Bot Elements -->
                    <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3 py-1 bg-blue-600 bg-opacity-30 rounded-full">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                        <span class="text-xs font-medium text-blue-300">Algo Bot Running</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-900" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Advanced Trading Automation
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Unlock the Power of Algorithmic Trading</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Our automation platform enables traders of all experience levels to implement sophisticated trading strategies without extensive programming knowledge.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Lightning Fast Execution</h3>
                <p class="text-gray-300">Our algorithmic trading system executes trades in milliseconds, capitalizing on market opportunities without human delay.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Backtesting & Optimization</h3>
                <p class="text-gray-300">Test your strategies against historical data to fine-tune parameters and optimize performance before risking real capital.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Advanced Risk Management</h3>
                <p class="text-gray-300">Implement sophisticated risk management rules including stop-loss, take-profit, and position sizing to protect your capital.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Knowledge Base
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Frequently Asked Questions</h2>
            <p class="mt-4 text-xl text-gray-300">Everything you need to know about our automated trading solutions</p>
        </div>

        <div class="space-y-6" x-data="{selected:null}">
            <!-- FAQ Item 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 1 ? selected = 1 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">How does a cBot work?</span>
                    <svg :class="{'rotate-180': selected == 1}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 1" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">A cBot analyses the indicators or the other parameters that it was programmed to use and once the predefined rules are met, it takes a particular action, such as entering, exiting or modifying a trade.</p>
                        <p>For example, if you are using a cBot that trades breakouts, your trade will be entered when the price breaks above a resistance or below a support level. Apart from rules for identifying trading opportunities, a cBot typically contains parameters for managing open positions such as Stop Loss/Take Profit Levels, trailing stops or other risk management features.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 2 ? selected = 2 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Can I convert an Expert Advisor that I am using on MT4 to a cBot?</span>
                    <svg :class="{'rotate-180': selected == 2}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 2" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>Yes, your MQL4 indicators and Expert Advisors can be converted to C#, for use on {{$settings->name}} cTrader. Please contact a consultant from the <a class="text-blue-400 hover:text-blue-300" target='_blank' href='https://ctdn.com/consultants/'>cTDN community</a>, who will be able to do this for you.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 3 ? selected = 3 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Based on which criteria should I select a cBot?</span>
                    <svg :class="{'rotate-180': selected == 3}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 3" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">There is no best way to select a cBot, but it's advisable to do your research first. When you are downloading a cBot from cTDN, you can get a good idea about how it works by viewing the developer's description which includes characteristics and tips about its usage.</p>
                        <p class="mb-3">Traders usually select a bot that suits their trading style, so if for example, you prefer trading with Fibonacci ratios, you may choose a Fibonacci cBot, and if you are into news trading, you may choose a cBot that trades when there's an important economic release.</p>
                        <p>In cTDN, you can also rank cBots according to popularity and user rating, so this could be another deciding factor, especially if you are a beginner.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 4 ? selected = 4 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">How do I know if my cBot is set to run correctly?</span>
                    <svg :class="{'rotate-180': selected == 4}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 4" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>Once you download the cBot file, you will have to run and install it on your computer. You should then be able to view it on {{$settings->name}} cTrader, at the left side of your chart under the cBots column. Once you define which instrument you'd like to run it for, click the "Play" button. The cBot will start working when the right conditions are met. Please note that you can stop it anytime, just by clicking the "Stop" button.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 5 ? selected = 5 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Can I run multiple cBots at the same time?</span>
                    <svg :class="{'rotate-180': selected == 5}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 5" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>Yes, you can run multiple cBots at the same time and for the same instrument.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 6 ? selected = 6 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Can I create my own cBot?</span>
                    <svg :class="{'rotate-180': selected == 6}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 6" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">If you have a specific trading strategy that you follow and has been proven effective, then it might be a good idea to automate it. It's important that your strategy is simple enough and that you are clear about the set of rules that your bot is going to be built on.</p>
                        <p>If you have no coding experience yourself, you may opt to hire a developer from the <a class="text-blue-400 hover:text-blue-300" target='_blank' href='https://ctdn.com/consultants/'>cTDN community</a>. Please post your request at the forum or contact one of the expert consultants.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 7 ? selected = 7 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">What types of custom indicators are available?</span>
                    <svg :class="{'rotate-180': selected == 7}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 7" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">Trend indicators that are smoothened or combined versions of the standard version, such as MACD, RSI, Heiken Ashi, Ichimoku and more.</p>
                        <p class="mb-3">Adjusted formulas of standard Volatility indicators such as Bollinger Bands, Donchian channels, Keltner channels, Average True Range etc.</p>
                        <p>Multiple other custom indicators that are based on Support & Resistance, Pivot Points, Harmonics, Polynomial Regression, Fibonacci etc.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 8 ? selected = 8 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">How can I start trading with a live account?</span>
                    <svg :class="{'rotate-180': selected == 8}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 8" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">Your live trading account can be up and running in less than 2 minutes. Please follow the steps below:</p>
                        <ul class="list-disc pl-5 mb-3 space-y-2">
                            <li>Step 1. Create Account.</li>
                            <li>Step 2. Fill in your email, password and phone number.</li>
                            <li>Step 3. Launch the platform and fund your account to start trading!</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Expert Support Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="w-full md:w-1/2">
                <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Trading Support" class="w-full max-w-md mx-auto rounded-xl shadow-2xl">
            </div>
            <div class="w-full md:w-1/2 space-y-8">
                <div>
                    <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Expert Support
                    </div>
                    <h2 class="text-3xl font-extrabold text-white mb-4">STAY UP TO DATE <br>WITH OUR EXPERTS!</h2>
                    <p class="text-gray-300">
                        Our local and international teams are here to support you on a 24/5 basis in more than 20 languages, while our wide range of payment methods gives you greater flexibility when it comes to deposits and withdrawals.
                    </p>
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold text-white mb-4">Experience More Than Trading</h2>
                    <p class="text-gray-300">
                        Our success is centred around a number of core values. They include providing competitive brokerage fees through tight spreads, ensuring lightning-fast execution, access to advanced trading platforms with a wide range of products, and exceptional customer service.
                    </p>
                </div>

                <a href="/about" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                    Learn About {{$settings->name}} Commissions
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
