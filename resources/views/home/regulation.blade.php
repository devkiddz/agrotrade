@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gray-900 overflow-hidden">
    <!-- Background with overlay -->
    <div class="absolute inset-0">
        <!-- Dynamic grid pattern background -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="regulation-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5" />
                            <circle cx="20" cy="20" r="1" fill="currentColor" opacity="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#regulation-grid)" />
                </svg>
            </div>
        </div>
        <!-- Glowing accent elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500 rounded-full filter blur-3xl opacity-10"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-emerald-400 rounded-full filter blur-3xl opacity-10"></div>
    </div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-4xl">
            <!-- Title and Breadcrumb -->
            <div class="mb-8">
                <div class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-emerald-400 uppercase bg-emerald-900 bg-opacity-30 rounded-full mb-4">
                    Company Information
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Regulation and Licensing</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{$settings->site_address}}" class="text-gray-400 hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{$settings->site_name}}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{$settings->site_address}}company" class="text-gray-400 hover:text-white ml-1 md:ml-2">Company</a>
                            </div>
                        </li>
                    </ol>
                </nav>

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
                                    "@id": "{{$settings->site_address}}company",
                                    "name": "Company"
                                }
                            }
                        ]
                    }
                </script>
            </div>

            <!-- Main Content -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-300 leading-relaxed">
                                {{$settings->site_name}} with registration number 709718501 is a company registered under the Laws of Seychelles and is licensed by the Financial Services Authority (FSA) of Seychelles.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-emerald-900 bg-opacity-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-300 leading-relaxed">
                                {{$settings->site_name}} is a tradename of {{$settings->site_name}} with registration number HE 19818009, which is registered as a Cyprus Investment Firm (CIF) and licensed by the Cyprus Securities and Exchange Commission (CySEC) in accordance with the Markets In Financial Instruments Directive (MiFID II).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Indicators Section -->
<section class="py-16 bg-gray-800 relative overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="trust-grid" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                    <circle cx="25" cy="25" r="1" fill="currentColor"/>
                    <circle cx="0" cy="0" r="1" fill="currentColor"/>
                    <circle cx="0" cy="50" r="1" fill="currentColor"/>
                    <circle cx="50" cy="0" r="1" fill="currentColor"/>
                    <circle cx="50" cy="50" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#trust-grid)"/>
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <div class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full mb-4">
                Our Commitment
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Regulatory Framework</h2>
            <p class="text-gray-300 max-w-2xl mx-auto">
                We maintain the highest standards of regulatory compliance and financial security to protect our clients' interests.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Client Fund Protection -->
            <div class="relative group" x-data="{ isHovered: false }" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-emerald-500 rounded-lg opacity-30 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-gray-900 p-6 rounded-lg border border-gray-700">
                    <div class="w-12 h-12 rounded-full bg-blue-900 bg-opacity-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Client Fund Protection</h3>
                    <p class="text-gray-400">All client funds are held in segregated accounts at top-tier banks, ensuring maximum security and compliance with regulatory requirements.</p>
                </div>
            </div>

            <!-- Regulatory Compliance -->
            <div class="relative group" x-data="{ isHovered: false }" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-blue-600 rounded-lg opacity-30 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-gray-900 p-6 rounded-lg border border-gray-700">
                    <div class="w-12 h-12 rounded-full bg-emerald-900 bg-opacity-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Regulatory Compliance</h3>
                    <p class="text-gray-400">We maintain strict compliance with all applicable regulations and regularly undergo audits to ensure transparency and security.</p>
                </div>
            </div>

            <!-- Risk Management -->
            <div class="relative group" x-data="{ isHovered: false }" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-500 rounded-lg opacity-30 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-gray-900 p-6 rounded-lg border border-gray-700">
                    <div class="w-12 h-12 rounded-full bg-purple-900 bg-opacity-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Risk Management</h3>
                    <p class="text-gray-400">Advanced risk management systems and procedures are in place to protect both our clients and our operations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-900 relative">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-gray-900 opacity-50"></div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="rgba(17, 24, 39, 1)" fill-opacity="1" d="M0,224L40,213.3C80,203,160,181,240,181.3C320,181,400,203,480,218.7C560,235,640,245,720,229.3C800,213,880,171,960,165.3C1040,160,1120,192,1200,192C1280,192,1360,160,1400,144L1440,128L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto bg-gray-800 bg-opacity-80 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Trade with Confidence</h2>
                <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                    Start trading with a regulated broker that prioritizes your security and success.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="register" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-emerald-500 text-white font-medium rounded-lg transition duration-300 transform hover:scale-105 flex items-center justify-center">
                        <span>Open Account</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="#" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Learn More</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
