@extends('layouts.dasht')
@section('title', $title)

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

<!-- Modern Hero Section -->
<div class="relative min-h-[40vh] overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzYjgyZjYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMiIvPjxjaXJjbGUgY3g9IjIiIGN5PSI1OCIgcj0iMiIvPjxjaXJjbGUgY3g9IjU4IiBjeT0iNTgiIHI9IjIiLz48Y2lyY2xlIGN4PSI1OCIgY3k9IjIiIHI9IjIiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-20"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/20 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-500/20 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 container mx-auto px-6 py-12">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 rounded-full border border-blue-500/20 mb-4">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-blue-200 text-sm font-medium">Live Copy Trading</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-white via-blue-200 to-purple-200 bg-clip-text text-transparent">
                    Copy Trading
                </span>
                <br>
                <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                    Hub
                </span>
            </h1>

            <p class="text-lg text-blue-100/80 mb-6 max-w-xl mx-auto leading-relaxed">
                Follow top-performing traders and automatically replicate their winning strategies.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                   class="group relative inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-lg rounded-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-300">
                    <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                    Back to Dashboard
                </a>
                <div class="flex items-center gap-4 text-blue-200">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                        <span class="text-sm">Secure</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-4 h-4 text-blue-400"></i>
                        <span class="text-sm">Profitable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-[120px]">
            <path fill="rgb(248 250 252)" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,85.3C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</div>

<!-- Main Content -->
<div class="bg-slate-50 dark:bg-slate-900 min-h-screen">
    <div class="container mx-auto px-6 py-12">

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Total Traders -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <i data-lucide="users" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">{{ count($copytradings) }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Expert Traders</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Active & Verified</span>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <i data-lucide="trending-up" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">87%</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Success Rate</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Profitable Trades</span>
                    </div>
                </div>
            </div>

            <!-- Min Investment -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                            <i data-lucide="wallet" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">{{ $settings->currency }}50</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Min Investment</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400">
                        <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Start Small</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="mb-8">
            <x-danger-alert />
            <x-success-alert />
        </div>

        <!-- Traders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ hoveredCard: null }">
            @foreach ($copytradings as $copytrading)
            <div class="group relative"
                 x-on:mouseenter="hoveredCard = {{ $copytrading->id }}"
                 x-on:mouseleave="hoveredCard = null">

                <!-- Card Glow Effect -->
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>

                <!-- Main Card -->
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-1">

                    <!-- Card Header -->
                    <div class="relative h-24 bg-gradient-to-br from-slate-800 via-blue-900 to-indigo-900 overflow-visible">
                        <!-- Pattern Overlay -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDIwIDAgTCAwIDAgMCAyMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2IoMjU1IDI1NSAyNTUgLyAwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-50"></div>

                        <!-- Tag Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-400/90 text-yellow-900 rounded-full backdrop-blur-sm">
                                {{ $copytrading->tag }}
                            </span>
                        </div>
                    </div>

                    <!-- Trader Avatar - Completely Outside Header -->
                    <div class="flex justify-center -mt-16 mb-4 relative z-20">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-2xl bg-white group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('/storage/app/public/photos/'.$copytrading->photo) }}"
                                     class="w-full h-full object-cover"
                                     alt="{{ $copytrading->name }}">
                            </div>
                            <!-- Verified Badge -->
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center border-3 border-white dark:border-slate-700 shadow-lg">
                                <i data-lucide="check" class="w-5 h-5 text-white"></i>
                            </div>
                            <!-- Online Status Indicator -->
                            <div class="absolute top-2 right-2 w-5 h-5 bg-green-400 rounded-full border-3 border-white dark:border-slate-700 animate-pulse shadow-lg">
                                <div class="absolute inset-1 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="pb-6 px-6">
                        <!-- Trader Name & Rating - Centered -->
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ $copytrading->name }}
                            </h3>
                            <div class="flex items-center justify-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $copytrading->rating)
                                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                                    @else
                                        <i data-lucide="star" class="w-4 h-4 text-slate-300 dark:text-slate-600"></i>
                                    @endif
                                @endfor
                                <span class="text-sm text-slate-500 dark:text-slate-400 ml-2">({{ $copytrading->rating }}/5)</span>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Followers</span>
                                </div>
                                <div class="text-lg font-bold text-slate-900 dark:text-white">{{ number_format($copytrading->followers) }}</div>
                            </div>

                            <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                <div class="flex items-center gap-2 mb-1">
                                    <i data-lucide="trending-up" class="w-4 h-4 text-green-500"></i>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Profit Rate</span>
                                </div>
                                <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $copytrading->equity }}%</div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Min. Capital</span>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $settings->currency }}{{ number_format($copytrading->price) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Profit</span>
                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $settings->currency }}{{ number_format($copytrading->total_profit) }}</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                                                @if(in_array($copytrading->id, $userCopyTrades))
                        <form method="post" action="{{ route('cancelcopytrade') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full py-3 px-4 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group/btn">
                                <span class="flex items-center justify-center gap-2">
                                    <i data-lucide="x" class="w-4 h-4 transition-transform group-hover/btn:scale-110"></i>
                                    Stop Copying
                                </span>
                            </button>
                        </form>
                        @else
                        <button onclick="openInvestModal({{ $copytrading->id }}, '{{ $copytrading->name }}', {{ $copytrading->price }})"
                                class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group/btn">
                            <span class="flex items-center justify-center gap-2">
                                <i data-lucide="copy" class="w-4 h-4 transition-transform group-hover/btn:scale-110"></i>
                                Copy Expert
                            </span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Enhanced Styles -->
<style>
    /* Font Smoothing */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(3deg); }
    }

    /* Custom Animations */
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Gradient Animations */
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #2563eb, #7c3aed);
    }
</style>

<!-- Scripts -->
<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Initialize Alpine.js Data
    document.addEventListener('alpine:init', () => {
        Alpine.store('ui', {
            hoveredCard: null
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Modern Copy Trading Investment Modal
    function openInvestModal(expertId, expertName, minAmount) {
        Swal.fire({
            title: `Copy ${expertName}`,
            html: `
                <div class="text-left space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Investment Amount</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" 
                                   id="investAmount" 
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Enter amount"
                                   min="${minAmount}"
                                   step="0.01"
                                   value="${minAmount}">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimum investment: $${minAmount}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            You'll automatically copy all trades from this expert trader.
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Start Copying',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 rounded-xl px-6 py-2',
                cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-xl px-6 py-2'
            },
            preConfirm: () => {
                const amount = document.getElementById('investAmount').value;
                if (!amount || amount < minAmount) {
                    Swal.showValidationMessage(`Please enter an amount of at least $${minAmount}`);
                    return false;
                }
                return { expertId, amount };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("joincopytrade") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const expertIdInput = document.createElement('input');
                expertIdInput.type = 'hidden';
                expertIdInput.name = 'expert_id';
                expertIdInput.value = result.value.expertId;
                form.appendChild(expertIdInput);
                
                const amountInput = document.createElement('input');
                amountInput.type = 'hidden';
                amountInput.name = 'amount';
                amountInput.value = result.value.amount;
                form.appendChild(amountInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@endsection
