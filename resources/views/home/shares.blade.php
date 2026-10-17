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
                        <pattern id="shares-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5" />
                            <circle cx="20" cy="20" r="1" fill="currentColor" opacity="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#shares-grid)" />
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
                    Investment Products
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Share Trading</h1>
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
                                <a href="#" class="text-gray-400 hover:text-white ml-1 md:ml-2">Trading</a>
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
                                    "@id": "{{$settings->site_address}}trading",
                                    "name": "Trading"
                                }
                            }
                        ]
                    }
                </script>
            </div>

            <!-- Main Content -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
                <div class="prose prose-lg prose-invert max-w-none">
                    <p class="text-gray-300 leading-relaxed">
                        Shares are units of equity ownership interest in a corporation that exist as a financial asset providing for an equal distribution in any residual profits, if any are declared, in the form of dividends. Shareholders may also enjoy capital gains if the value of the company rises.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


</div></div></div></section>






<!-- Share Trading Table Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <!-- Trading Table Card -->
        <div class="bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-700">
            <!-- Table Header -->
            <div class="p-6 bg-gray-800 border-b border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-2xl font-bold text-white">Available Shares</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Search Box -->
                        <div class="relative">
                            <input type="text" class="search-box w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500 placeholder-gray-400"
                                placeholder="Search shares...">
                            <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table id="tt-spreads-6023e31008b95" class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Symbol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Change</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Volume</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(function() {
    var $dttble = $('#tt-spreads-6023e31008b95').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
        "responsive": true,
        "paging": false,
        "ordering": true,
        "searching": true,
        "language": {
            "zeroRecords": "No matching records found",
            "search": ""
        },
        "dom": '<"top"f>rt<"bottom"ilp><"clear">',
        "columnDefs": [
            { targets: [ 'category', 'sub_category' ], visible: false }
        ],
        "drawCallback": function(settings) {
            // Apply Tailwind classes to DataTables elements
            $('.dataTables_wrapper').addClass('bg-gray-800');
            $('.dataTables_info').addClass('text-gray-400 p-4');
            $('.dataTables_filter input').addClass('bg-gray-700 border border-gray-600 rounded-lg text-gray-200 px-4 py-2');
        },
        initComplete: function() {
            $('.loader').hide();
            $('.pat').removeClass('loading');

            // Connect search box
            $('.search-box').keyup(function() {
                $dttble.search(this.value).draw();
            });
        }
    });

    // Responsive handling
    $(window).on('resize', function() {
        setTimeout(function() {
            AOS.refresh();
            $dttble.columns.adjust().draw();
        }, 250);
    });
});
</script>


<!-- Features Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Trade What You Want, When You Want</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-emerald-400 mx-auto"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Image -->
            <div class="relative" data-aos="fade-right" data-aos-duration="1200">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-emerald-400/20 rounded-xl filter blur-xl"></div>
                    <img src="temp/custom/img/commission-scheme-crypt1t1.png" alt="commission-scheme" class="relative z-10 w-full rounded-xl shadow-2xl">
                </div>
            </div>

            <!-- Right Column - Content -->
            <div class="space-y-8">
                <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
                    <p class="text-xl text-gray-200 leading-relaxed mb-6">
                        One of the primary goals of {{$settings->site_name}} is to provide the best product in the market. Our relationships with leading tier one financial institutions mean deep liquidity and tighter spreads for Forex traders.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Trade Forex, Indices, Shares & Commodities</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Access global markets 24 hours / 7 days</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Multilingual customer support</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Trade on the go on our mobile apps</span>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a href="trading-conditions" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl" title="Learn About {{$settings->site_name}} Commissions">
                            Learn More About Our Commissions
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








<!-- CTA Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl overflow-hidden shadow-2xl">
            <div class="relative px-8 py-12 md:p-12">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-blue-500/30 to-emerald-400/30 blur-3xl"></div>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <!-- Contact Section -->
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Connect With Us</h3>
                        <p class="text-gray-300 mb-6">Get in touch with our expert team for personalized support</p>
                        <div class="flex items-center justify-center md:justify-start space-x-4">
                            <a href="mailto:{{$settings->contact_email}}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300">
                                <i class="fa fa-envelope text-gray-200"></i>
                            </a>
                            <!-- Add more social icons as needed -->
                        </div>
                    </div>

                    <!-- Live Chat Section -->
                    <div class="text-center md:text-right">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Need Help?</h3>
                        <a onclick="openLiveChat(event)" href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fa fa-commenting mr-2"></i>
                            Start Live Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
