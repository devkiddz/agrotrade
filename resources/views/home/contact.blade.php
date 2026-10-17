@extends('layouts.base')

@section('title', 'Contact us')

@inject('content', 'App\Http\Controllers\FrontController')
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
        <div class="text-center mb-8">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Get in Touch
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                <span class="block">Contact Us</span>
                <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">We're Here to Help</span>
            </h1>
            <p class="max-w-2xl mt-5 mx-auto text-xl text-gray-300">
                Have questions about trading? Our multilingual support team is available to assist you 24/7.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Send Us a Message</h2>

                        <form method="post" enctype="text/plain" x-data="{ formType: 'Trading Question', name: '', email: '', message: '' }">
                            <div class="space-y-6">
                                <!-- Select Type -->
                                <div>
                                    <label for="select" class="block text-sm font-medium text-gray-300 mb-2">Select Topic</label>
                                    <select
                                        x-model="formType"
                                        class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        id="select"
                                        name="question">
                                        <option value="Trading Question">Trading Question</option>
                                        <option value="Finance Question">Finance Question</option>
                                        <option value="Technical Question">Technical Question</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                                        <input
                                            x-model="name"
                                            type="text"
                                            class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            id="name"
                                            placeholder="Your name"
                                            name="name"
                                            required>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                                        <input
                                            x-model="email"
                                            type="email"
                                            class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            id="email"
                                            placeholder="email@example.com"
                                            name="email"
                                            required>
                                    </div>
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Your Message</label>
                                    <textarea
                                        x-model="message"
                                        class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all min-h-[150px]"
                                        placeholder="How can we help you?"
                                        name="message"
                                        required></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <a
                                        href=""
                                        @click.prevent="window.location.href=`mailto:{{$settings->contact_email}}?subject=${formType}&body=Name: ${name}%0D%0A%0D%0AEmail: ${email}%0D%0A%0D%0AMessage: ${message}`"
                                        class="inline-flex items-center justify-center w-full px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        Send Message
                                    </a>
                                    <p class="mt-3 text-xs text-gray-400 text-center">
                                        Your information is secure and encrypted
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Customer Support -->
                    <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white">Customer Support</h3>
                            </div>
                            <p class="text-gray-300 mb-4">
                                Our multilingual support team is ready to assist you with any questions or concerns.
                            </p>
                            <div class="flex items-center text-blue-400 hover:text-blue-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span>24/7 Support Available</span>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white">Address</h3>
                            </div>
                            <p class="text-gray-300 mb-2">
                                11 GRACE AVENUE, STE 108<br>
                                GREAT NECK, NEW YORK, 11021<br>
                                USA
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white">Phone</h3>
                            </div>
                            <a href="tel:7027064466" class="text-blue-400 hover:text-blue-300 transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                702-706-4466
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-white">Email</h3>
                            </div>
                            <div class="space-y-2">
                                <a href="mailto:{{$settings->emailfrom}}" class="text-blue-400 hover:text-blue-300 transition flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    {{$settings->emailfrom}}
                                </a>
                                <a href="mailto:{{$settings->contact_email}}" class="text-blue-400 hover:text-blue-300 transition flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    {{$settings->contact_email}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Global Presence Section -->
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
            <h2 class="text-3xl font-bold text-white">Global Presence</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
            <p class="mt-4 max-w-3xl mx-auto text-gray-300">
                With teams around the world, we provide support in multiple languages and time zones
            </p>
        </div>

        <!-- Interactive Global Offices -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <!-- North America Region -->
            <div x-data="{ open: false }" class="relative bg-gray-900 bg-opacity-70 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-xl group hover:border-blue-500 transition-all duration-300">
                <div class="p-6 cursor-pointer" @click="open = !open">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">North America</h3>
                        <div class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 transition-transform duration-300" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-300">New York, San Francisco, Toronto</p>

                    <div class="absolute inset-0 bg-gradient-to-r from-blue-800/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>

                <div x-show="open" x-collapse x-cloak class="bg-gray-800 border-t border-gray-700 p-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-blue-400">New York</h4>
                            <p class="text-gray-300 text-sm mt-1">11 GRACE AVENUE, STE 108<br>GREAT NECK, NEW YORK, 11021</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:30 AM - 4:00 PM EST</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">San Francisco</h4>
                            <p class="text-gray-300 text-sm mt-1">301 HOWARD STREET<br>SAN FRANCISCO, CA 94105</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 6:30 AM - 1:00 PM PST</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">Toronto</h4>
                            <p class="text-gray-300 text-sm mt-1">199 BAY STREET<br>TORONTO, ONTARIO, M5L 1E2</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:30 AM - 4:00 PM EST</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Europe Region -->
            <div x-data="{ open: false }" class="relative bg-gray-900 bg-opacity-70 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-xl group hover:border-blue-500 transition-all duration-300">
                <div class="p-6 cursor-pointer" @click="open = !open">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Europe</h3>
                        <div class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 transition-transform duration-300" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-300">London, Frankfurt, Zurich</p>

                    <div class="absolute inset-0 bg-gradient-to-r from-blue-800/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>

                <div x-show="open" x-collapse x-cloak class="bg-gray-800 border-t border-gray-700 p-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-blue-400">London</h4>
                            <p class="text-gray-300 text-sm mt-1">1 CANADA SQUARE<br>CANARY WHARF, LONDON, E14 5AB</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 8:00 AM - 4:30 PM GMT</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">Frankfurt</h4>
                            <p class="text-gray-300 text-sm mt-1">MAINZER LANDSTRASSE 50<br>FRANKFURT, 60325</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:00 AM - 5:30 PM CET</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">Zurich</h4>
                            <p class="text-gray-300 text-sm mt-1">BAHNHOFSTRASSE 64<br>ZURICH, 8001</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:00 AM - 5:30 PM CET</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Asia Region -->
            <div x-data="{ open: false }" class="relative bg-gray-900 bg-opacity-70 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-xl group hover:border-blue-500 transition-all duration-300">
                <div class="p-6 cursor-pointer" @click="open = !open">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Asia Pacific</h3>
                        <div class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 transition-transform duration-300" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-300">Singapore, Hong Kong, Tokyo</p>

                    <div class="absolute inset-0 bg-gradient-to-r from-blue-800/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>

                <div x-show="open" x-collapse x-cloak class="bg-gray-800 border-t border-gray-700 p-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-blue-400">Singapore</h4>
                            <p class="text-gray-300 text-sm mt-1">ONE RAFFLES QUAY<br>SINGAPORE, 048583</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:00 AM - 5:00 PM SGT</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">Hong Kong</h4>
                            <p class="text-gray-300 text-sm mt-1">INTERNATIONAL FINANCE CENTRE<br>CENTRAL, HONG KONG</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:30 AM - 4:00 PM HKT</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-400">Tokyo</h4>
                            <p class="text-gray-300 text-sm mt-1">MARUNOUCHI BUILDING<br>CHIYODA-KU, TOKYO, 100-0005</p>
                            <p class="text-blue-400 text-sm mt-1">Trading Hours: 9:00 AM - 3:00 PM JST</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Trading Statistics -->
        <!--<div class="mt-12 bg-gray-900 bg-opacity-80 backdrop-blur-sm border border-gray-700 rounded-xl p-8 shadow-xl">-->
        <!--    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">-->
        <!--        <div class="p-4" x-data="{ count: 0 }" x-intersect="setTimeout(() => { for(var i=0; i<=24; i++) { setTimeout(() => { count = Math.ceil(i * 24/24); }, i*40) } }, 100)">-->
        <!--            <div class="text-3xl font-bold text-blue-400 mb-2"><span x-text="count"></span>+</div>-->
        <!--            <div class="text-lg text-gray-300">Trading Hours</div>-->
        <!--            <div class="text-xs text-gray-400 mt-1">Around the Clock Support</div>-->
        <!--        </div>-->
        <!--        <div class="p-4" x-data="{ count: 0 }" x-intersect="setTimeout(() => { for(var i=0; i<=12; i++) { setTimeout(() => { count = Math.ceil(i * 12/12); }, i*40) } }, 100)">-->
        <!--            <div class="text-3xl font-bold text-blue-400 mb-2"><span x-text="count"></span>+</div>-->
        <!--            <div class="text-lg text-gray-300">Languages</div>-->
        <!--            <div class="text-xs text-gray-400 mt-1">Multilingual Support</div>-->
        <!--        </div>-->
        <!--        <div class="p-4" x-data="{ count: 0 }" x-intersect="setTimeout(() => { for(var i=0; i<=150; i++) { setTimeout(() => { count = Math.ceil(i * 150/150); }, i*15) } }, 100)">-->
        <!--            <div class="text-3xl font-bold text-blue-400 mb-2"><span x-text="count"></span>+</div>-->
        <!--            <div class="text-lg text-gray-300">Countries</div>-->
        <!--            <div class="text-xs text-gray-400 mt-1">Global Market Access</div>-->
        <!--        </div>-->
        <!--        <div class="p-4" x-data="{ count: 0 }" x-intersect="setTimeout(() => { for(var i=0; i<=15; i++) { setTimeout(() => { count = Math.ceil(i * 15/15); }, i*40) } }, 100)">-->
        <!--            <div class="text-3xl font-bold text-blue-400 mb-2"><span x-text="count"></span>+</div>-->
        <!--            <div class="text-lg text-gray-300">Offices</div>-->
        <!--            <div class="text-xs text-gray-400 mt-1">Worldwide Locations</div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-900" x-data="{ activeTab: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white">Frequently Asked Questions</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
            <p class="mt-4 max-w-3xl mx-auto text-gray-300">
                Find answers to common questions about our services and support
            </p>
        </div>

        <div class="max-w-3xl mx-auto bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
            <!-- FAQ Item 1 -->
            <div class="border-b border-gray-700 last:border-b-0">
                <button
                    @click="activeTab = (activeTab === 1) ? null : 1"
                    class="flex items-center justify-between w-full py-5 px-6 text-left text-white focus:outline-none"
                >
                    <span class="font-semibold text-lg">How can I contact customer support?</span>
                    <svg
                        class="w-5 h-5 text-blue-400 transition-transform duration-200"
                        :class="{'rotate-180': activeTab === 1}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div
                    x-show="activeTab === 1"
                    x-collapse
                    x-cloak
                    class="px-6 pb-5 text-gray-300"
                >
                    You can contact our customer support team through email, phone, or by filling out the contact form on this page. Our team is available 24/7 to assist you with any questions or concerns.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="border-b border-gray-700 last:border-b-0">
                <button
                    @click="activeTab = (activeTab === 2) ? null : 2"
                    class="flex items-center justify-between w-full py-5 px-6 text-left text-white focus:outline-none"
                >
                    <span class="font-semibold text-lg">How long does it take to get a response?</span>
                    <svg
                        class="w-5 h-5 text-blue-400 transition-transform duration-200"
                        :class="{'rotate-180': activeTab === 2}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div
                    x-show="activeTab === 2"
                    x-collapse
                    x-cloak
                    class="px-6 pb-5 text-gray-300"
                >
                    Our support team typically responds to inquiries within 1-2 hours. For urgent matters, we recommend calling our support line for immediate assistance.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="border-b border-gray-700 last:border-b-0">
                <button
                    @click="activeTab = (activeTab === 3) ? null : 3"
                    class="flex items-center justify-between w-full py-5 px-6 text-left text-white focus:outline-none"
                >
                    <span class="font-semibold text-lg">In which languages is support available?</span>
                    <svg
                        class="w-5 h-5 text-blue-400 transition-transform duration-200"
                        :class="{'rotate-180': activeTab === 3}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div
                    x-show="activeTab === 3"
                    x-collapse
                    x-cloak
                    class="px-6 pb-5 text-gray-300"
                >
                    We provide multilingual support including English, Spanish, Chinese, Japanese, Russian, German, French, Arabic, and Portuguese. This ensures clear communication with our global client base.
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
