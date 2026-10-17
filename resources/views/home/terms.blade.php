@extends('layouts.base')

@section('title', 'Terms')

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
        <div class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Legal Documentation
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                <span class="block">Privacy Policy</span>
                <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Your Data Protection</span>
            </h1>
            <p class="max-w-2xl mt-5 mx-auto text-xl text-gray-300">
                Understanding how we protect your information and respect your privacy
            </p>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="py-12 bg-gray-900">
    <div class="container max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
            <div class="p-6 md:p-10">
                <!-- Policy Content -->
                <div class="prose prose-lg prose-invert max-w-none">
                    <div class="space-y-8">

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Our Commitment</h2>
                            <p class="text-gray-300 mb-4">
                                Privacy is of utmost importance at {{$settings->site_name}}. We recognize the significance of protecting information which is stored on our servers or network or is intended to be stored on our servers or network and which relates to an individual. The data we protect are the "Personal Data" which is any information relating to an identified or identifiable natural person, sometimes called a data subject, and have made protecting the privacy and the confidentiality of Personal Data a fundamental component of the way we do business.
                            </p>
                            <p class="text-gray-300 mb-4">
                                This Privacy Policy informs you of the ways we work to ensure privacy and the confidentiality of Personal Data and describes the information we gather, how we use those Personal Data and the circumstances under which we disclose such information to third-parties.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Regulatory Compliance</h2>
                            <p class="text-gray-300 mb-4">
                                This Privacy Policy is designed to address regulatory requirements of the jurisdictions in which {{$settings->site_name}} offers its Services, including the General Data Protection Regulation ("GDPR"), as enacted by the European Commission. In this Privacy Policy, the term "Service" and "Services" has the same meaning as described in the User Agreement.
                            </p>
                            <p class="text-gray-300 mb-4">
                                If you do not agree with this Privacy Policy, in general, or any part of it, you should not use the Services. This Privacy Policy is periodically reviewed to ensure that any new obligations and changes to our business model are taken into consideration. We may amend this Privacy Policy at any time by posting an amended version on our website.
                            </p>
                            <p class="text-gray-300 mb-4">
                                Our Services are offered through one or more subsidiaries of {{$settings->site_name}}. By using the Services, you understand that your Personal Data may be used by {{$settings->site_name}}.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Collection of Personal Data</h2>
                            <p class="text-gray-300 mb-4">When you access or use the Services, we collect the following information:</p>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Information You May Provide to Us</h3>
                            <p class="text-gray-300 mb-4">
                                You may give us information about you by filling in forms on our website or through our app or by corresponding with us by phone, email or otherwise. This includes information you provide when you register to use the Services and when you report a problem with the website.
                            </p>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Information We Collect About You</h3>
                            <p class="text-gray-300 mb-4">With regard to each of your visits to our website, we automatically collect the following information:</p>

                            <ul class="list-disc pl-6 text-gray-300 space-y-2 mb-6">
                                <li>
                                    <span class="text-white font-medium">Login Information:</span> We log technical information about your use of the Services, including the type of browser and version you use, the last access time of your account, the Internet Protocol (IP) address used to create the account and the most recent IP address used to access the account.
                                </li>
                                <li>
                                    <span class="text-white font-medium">Device Information:</span> We collect information about the device you use to access your account, including the hardware model, operating system and version, and unique device identifiers, but this information is anonymous and not tied to any particular person.
                                </li>
                                <li>
                                    <span class="text-white font-medium">Transaction Information:</span> In connection with our Conversion Service, as such term is defined in our User Agreement, we may collect and maintain information relating to transactions you effect in your account.
                                </li>
                            </ul>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Information We Collect Required By Law, Rule, or Regulation</h3>
                            <p class="text-gray-300 mb-4">Depending on the Service, we may collect information from you in order to meet regulatory obligations around know-your-customer ("KYC") and anti-money laundering ("AML") requirements. Information that we collect from you includes the following:</p>

                            <ul class="list-disc pl-6 text-gray-300 space-y-2">
                                <li>Full name</li>
                                <li>Residential address</li>
                                <li>Contact details (telephone number, email address)</li>
                                <li>Date and place of birth, gender, place of citizenship</li>
                                <li>Your status as a politically exposed person</li>
                                <li>Source of funds & proof of address</li>
                                <li>Passport and/or national driver's license or government-issued identification card to verify your identity</li>
                                <li>Transaction history and account balances in connection with your use of certain Services</li>
                            </ul>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Disclosure of Personal Data</h2>
                            <p class="text-gray-300 mb-4">
                                We may share your information with selected recipients to perform functions required to provide certain Services to you.
                            </p>
                            <p class="text-gray-300 mb-4">
                                We also may share Personal Data with a buyer or other successor in the event of a merger, divestiture, restructuring, reorganization, dissolution or other sale or transfer of some or all of {{$settings->site_name}}' assets, whether as a going concern or as part of bankruptcy, liquidation or similar proceeding, in which Personal Data held by {{$settings->site_name}} is among the assets transferred.
                            </p>
                            <p class="text-gray-300 mb-4">
                                Except where we are required by law to disclose Personal Data, or are exempted from, released from or not subject to any legal requirement concerning the disclosure of Personal Data, we will require any person to whom we provide your Personal Data to agree to comply with our Privacy Policy in force at that time or requirements substantially similar to such policy. We will make reasonable commercial efforts to ensure that they comply with such policy or requirements, however, where not expressly prohibited by law, we will have no liability to you, if any person fails to do so.
                            </p>
                            <p class="text-gray-300 mb-4">
                                We shall require any third-party, including without limitation, any government or enforcement entity, seeking access to the data we hold to a court order, or equivalent proof that they are statutorily authorized to access your data and that their request is valid and within their statutory or regulatory power.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Security of Your Personal Data</h2>
                            <p class="text-gray-300 mb-4">
                                We protect Personal Data with appropriate physical, technological and organizational safeguards and security measures. Your Personal Data comes to us via the internet which chooses its own routes and means, whereby information is conveyed from location to location. We audit our procedures and security measures regularly to ensure they are being properly administered and remain effective and appropriate.
                            </p>
                            <p class="text-gray-300 mb-4">
                                Every member of {{$settings->site_name}} is committed to our privacy policies and procedures to safeguard Personal Data. Our site has security measures in place to protect against the loss, misuse and unauthorized alteration of the information under our control. More specifically, our server uses TLS (Transport Layer Security) security protection by encrypting your Personal Data to prevent individuals from accessing such Personal Data as it travels over the internet.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-blue-400 mb-4">Your Rights</h2>
                            <p class="text-gray-300 mb-4">The rights that are available to you in relation to the Personal Data we hold about you are outlined below:</p>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Information Access</h3>
                            <p class="text-gray-300 mb-4">
                                If you ask us, we will confirm whether we are processing your Personal Data and, if so, what information we process and, if requested, provide you with a copy of that information within 30 days from the date of your request.
                            </p>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Erasure</h3>
                            <p class="text-gray-300 mb-4">
                                You can ask us to delete or remove your Personal Data in certain circumstances such as if we no longer need it, provided that we have no legal or regulatory obligation to retain that data. Such requests will be subject to any agreements that you have entered into with us, and to any retention limits, we are required to comply with in accordance with applicable laws and regulations. If we have disclosed your Personal Data to others, we will let them know about the erasure request where possible. If you ask us, if possible and lawful to do so, we will also inform you with whom we have shared your Personal Data so that you can contact them directly.
                            </p>

                            <h3 class="text-xl font-semibold text-white mt-6 mb-3">Processing Restrictions</h3>
                            <p class="text-gray-300 mb-4">
                                You can ask us to block or suppress the processing of your Personal Data in certain circumstances, such as, if you contest the accuracy of that Personal Data or object to us processing it. It will not stop us from storing your Personal Data. We will inform you before we decide not to agree with any requested restriction. If we have disclosed your Personal Data to others, we will let them know about the restriction of processing where possible. If you ask us, if possible and lawful to do so, we will also inform you with whom we have shared your Personal Data so that you can contact them directly.
                            </p>

                            <p class="text-gray-300 mt-8 mb-4">
                                By using the Services, you signify your agreement to this Privacy Policy. {{$settings->site_name}} reserves the right to change or amend this Privacy Policy at any time. If we make any material changes to this Privacy Policy, the revised Policy will be posted here and we will notify our users at least 30 days prior to the changes taking effect so that you are always aware of what information we collect, how we use it and under what circumstances we disclose it. Please check this page frequently to see any updates or changes to this Privacy Policy.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-12 text-center" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <span x-text="open ? 'Hide Data Protection Details' : 'Learn More About Data Protection'">Learn More About Data Protection</span>
                        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                             :class="{'transform rotate-180': open}">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="mt-8 bg-gray-900 bg-opacity-50 p-6 rounded-xl backdrop-blur-sm border border-gray-700">
                        <p class="text-gray-300">
                            At {{$settings->site_name}}, we are committed to protecting your personal data and privacy rights. For any questions about our privacy practices or to exercise your data protection rights, please contact our Data Protection Officer at privacy@{{$settings->site_name}}.com.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/about" class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-6 rounded-xl border border-gray-700 hover:border-blue-500 transition-colors duration-300 group">
                <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-blue-400">About Us</h3>
                <p class="text-gray-400">Learn more about our company and mission</p>
            </a>
            <a href="/contact" class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-6 rounded-xl border border-gray-700 hover:border-blue-500 transition-colors duration-300 group">
                <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-blue-400">Contact Us</h3>
                <p class="text-gray-400">Questions about privacy? Get in touch</p>
            </a>
            <a href="/register" class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-6 rounded-xl border border-gray-700 hover:border-blue-500 transition-colors duration-300 group">
                <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-blue-400">Start Trading</h3>
                <p class="text-gray-400">Create an account to begin trading</p>
            </a>
        </div>
    </div>
</section>

@endsection
