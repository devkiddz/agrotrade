@extends('layouts.dasht')

@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900" x-cloak>
    <!-- Clean Header Section -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-8">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4" x-cloak>
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $experts->count() }} Expert Traders Available</span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-4">
                    Copy Expert Traders
                </h1>

                <!-- Description -->
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Choose from our top-performing traders and automatically copy their trades to your portfolio.
                </p>

                <!-- Navigation -->
                <div class="flex flex-wrap items-center justify-center gap-4" x-cloak>
                    <a href="{{ route('copy.dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Dashboard
                    </a>

                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            <span>Verified</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                            <span>Proven Results</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg" x-cloak>
                <div class="flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg" x-cloak>
                <div class="flex items-center">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif


        <!-- Expert Traders Grid -->
        @if($experts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" x-cloak>
                @foreach($experts as $expert)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all duration-300">

                        <!-- Expert Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <!-- Status Badge -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2 py-1 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded text-xs font-medium">
                                    Active
                                </span>
                            </div>

                            <!-- Expert Avatar & Info -->
                            <div class="text-center">
                                @if($expert->photo)
                                    <img src="{{ asset('storage/app/public/'.$expert->photo) }}"
                                         class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600 mx-auto mb-3"
                                         alt="{{ $expert->name }}">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 text-lg font-medium mx-auto mb-3">
                                        {{ substr($expert->name, 0, 1) }}
                                    </div>
                                @endif

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $expert->name }}</h3>

                                @if($expert->tag)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $expert->tag }}</p>
                                @endif

                                <!-- Rating -->
                                <div class="flex items-center justify-center gap-1 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $expert->rating)
                                            <i data-lucide="star" class="w-4 h-4 text-yellow-500 fill-current"></i>
                                        @else
                                            <i data-lucide="star" class="w-4 h-4 text-gray-300 dark:text-gray-600"></i>
                                        @endif
                                    @endfor
                                    <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">({{ $expert->rating }})</span>
                                </div>

                                <!-- Followers -->
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($expert->followers) }} followers
                                </div>
                            </div>
                        </div>

                        <!-- Performance Stats -->
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <!-- Win Rate -->
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $expert->win_rate }}%</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Win Rate</div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1 mt-2">
                                        <div class="bg-green-500 h-1 rounded-full transition-all duration-500"
                                             style="width: {{ $expert->win_rate }}%"></div>
                                    </div>
                                </div>

                                <!-- Total Profit -->
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                    <div class="text-lg font-semibold text-green-600 dark:text-green-400">+{{ number_format((float)$expert->total_profit, 0) }}%</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Total Return</div>
                                </div>

                                <!-- Equity -->
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format((float)$expert->equity, 0) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Equity</div>
                                </div>

                                <!-- Total Trades -->
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($expert->total_trades) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Total Trades</div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($expert->description)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $expert->description }}</p>
                                </div>
                            @endif

                            <!-- Minimum Investment -->
                            <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Minimum Investment</span>
                                    <span class="text-base font-semibold text-gray-900 dark:text-white">${{ number_format((float)$expert->price, 2) }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if(in_array($expert->id, $userCopyTrades))
                                <button class="w-full py-3 px-4 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-medium rounded-lg cursor-not-allowed"
                                        disabled x-cloak>
                                    <span class="flex items-center justify-center gap-2">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                        Already Copying
                                    </span>
                                </button>
                            @else
                                <button type="button"
                                        onclick="console.log('Button clicked!'); try { startCopyTrading({{ $expert->id }}, {{ json_encode($expert->name) }}, {{ $expert->price }}); } catch(e) { console.error('Error:', e); alert('Error: ' + e.message); }"
                                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl" x-cloak>
                                    <span class="flex items-center justify-center gap-2">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                        Start Copying (${{ number_format((float)$expert->price, 2) }})
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16" x-cloak>
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Expert Traders Available</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                    Expert traders are being added soon. Check back later for trading opportunities.
                </p>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script x-cloak>
        // Initialize Lucide icons when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing Lucide icons...');
            lucide.createIcons();
            console.log('SweetAlert2 available:', typeof Swal !== 'undefined');
        });

        // Simple copy trading function with SweetAlert confirmation
        window.startCopyTrading = function(expertId, expertName, minAmount) {
            console.log('startCopyTrading called with:', expertId, expertName, minAmount);
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 not loaded. Falling back to basic confirmation.');
                if (confirm(`Start copying ${expertName} with minimum investment of $${minAmount}?`)) {
                    submitCopyForm(expertId, minAmount);
                }
                return;
            }
            Swal.fire({
                title: `Start copying ${expertName}?`,
                html: `<div class="text-left space-y-4">Minimum investment: <b>$${minAmount}</b></div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Start Copying',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitCopyForm(expertId, minAmount);
                }
            });
        }

        function submitCopyForm(expertId, minAmount) {
            console.log('Submitting copy form...', expertId, minAmount);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('copy.start') }}';
            // CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            // Expert ID
            const expertInput = document.createElement('input');
            expertInput.type = 'hidden';
            expertInput.name = 'expert_id';
            expertInput.value = expertId;
            form.appendChild(expertInput);
            // Amount
            const amountInput = document.createElement('input');
            amountInput.type = 'hidden';
            amountInput.name = 'amount';
            amountInput.value = minAmount;
            form.appendChild(amountInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
