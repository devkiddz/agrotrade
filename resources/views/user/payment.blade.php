
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<!-- Notification Alerts -->

<!-- Main Payment Container -->
<div class="min-h-screen bg-gray-900" x-data="paymentHandler()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="space-y-4 mb-6">

    <x-danger-alert />
    <x-success-alert />
</div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-blue-500/10 rounded-full border border-blue-500/20 mb-6">
                <i data-lucide="shield-check" class="w-5 h-5 text-blue-400"></i>
                <span class="text-sm font-medium text-blue-300">Secure Payment Gateway</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Complete Your Deposit
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Securely deposit funds using <span class="text-blue-400 font-semibold">{{ $payment_mode->name }}</span>
                to start trading immediately
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-center mb-12">
            <div class="flex items-center space-x-4 sm:space-x-8">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-blue-400">Payment Method</span>
                </div>
                <div class="w-8 h-0.5 bg-blue-500"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500/20 border-2 border-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-blue-400">2</span>
                    </div>
                    <span class="ml-3 text-sm font-medium text-white">Send Payment</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-gray-400">3</span>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-400">Confirmation</span>
                </div>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('savedeposit') }}" class="space-y-8">
            @csrf

            <!-- Main Payment Card -->
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">

                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-b border-gray-800 p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-6 h-6 text-blue-400"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Payment Details</h2>
                                <p class="text-gray-400">{{ $payment_mode->name }} Deposit</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                <i data-lucide="shield" class="w-3 h-3 mr-1"></i>
                                SSL Secured
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                24/7 Support
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 space-y-8">

                    <!-- Amount Display -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-xl"></div>
                        <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700">
                            <div class="text-center">
                                <div class="inline-flex items-center gap-2 text-sm text-gray-400 mb-2">
                                    <i data-lucide="banknote" class="w-4 h-4"></i>
                                    <span>Amount to Deposit</span>
                                </div>
                                <div class="text-4xl sm:text-5xl font-bold text-white mb-4">
                                    {{ $amount }}<span class="text-2xl text-gray-400">{{ Auth::user()->currency }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/20 rounded-full border border-amber-500/30">
                                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-400"></i>
                                    <span class="text-sm text-amber-300">Send exact amount to avoid delays</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-gray-800/30 rounded-2xl p-6 border border-gray-700">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-3">How to Complete Your Payment</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">1</div>
                                        <div>
                                            <h4 class="font-medium text-white">Send Payment</h4>
                                            <p class="text-sm text-gray-400">Transfer {{ $amount }}{{ Auth::user()->currency }} to the wallet address</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">2</div>
                                        <div>
                                            <h4 class="font-medium text-white">Upload Proof</h4>
                                            <p class="text-sm text-gray-400">Take a screenshot of your transaction</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">3</div>
                                        <div>
                                            <h4 class="font-medium text-white">Submit & Wait</h4>
                                            <p class="text-sm text-gray-400">Submit proof and wait for confirmation</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- QR Code Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <i data-lucide="qr-code" class="w-5 h-5 text-blue-400"></i>
                                QR Code Payment
                            </h3>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-lg"></div>
                                <div class="relative bg-white p-6 rounded-2xl">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $payment_mode->wallet_address }}"
                                         alt="Payment QR Code"
                                         class="w-full h-auto max-w-[250px] mx-auto rounded-lg">
                                    <button type="button"
                                            @click="downloadQR()"
                                            class="absolute top-2 right-2 p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                                        <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
                                    </button>
                                </div>
                            </div>

                            <p class="text-sm text-gray-400 text-center">
                                Scan with your wallet app to send payment instantly
                            </p>
                        </div>

                        <!-- Wallet Address & Upload Section -->
                        <div class="space-y-6">

                            <!-- Wallet Address -->
                            <div class="space-y-3">
                                <label class="text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="wallet" class="w-5 h-5 text-blue-400"></i>
                                    Wallet Address
                                </label>
                                <div class="relative group">
                                    <div class="flex">
                                        <input type="text"
                                               value="{{ $payment_mode->wallet_address }}"
                                               class="flex-1 bg-gray-800 border border-gray-700 rounded-l-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors duration-200"
                                               readonly>
                                        <button type="button"
                                                @click="copyToClipboard('{{ $payment_mode->wallet_address }}')"
                                                class="px-4 py-3 bg-blue-600 hover:bg-blue-700 border border-blue-600 rounded-r-xl text-white transition-all duration-200 flex items-center gap-2">
                                            <i data-lucide="copy" class="w-4 h-4"></i>
                                            <span x-text="copied ? 'Copied!' : 'Copy'" class="text-sm font-medium"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="space-y-3">
                                <label class="text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="upload" class="w-5 h-5 text-blue-400"></i>
                                    Upload Payment Proof
                                </label>

                                <div class="relative">
                                    <input type="file"
                                           id="proof"
                                           name="proof"
                                           accept="image/*"
                                           required
                                           class="hidden"
                                           @change="handleFileUpload($event)">

                                    <label for="proof"
                                           class="relative block w-full border-2 border-dashed border-gray-600 hover:border-blue-500 rounded-2xl p-8 text-center cursor-pointer transition-all duration-200 group"
                                           :class="{ 'border-blue-500 bg-blue-500/5': isDragOver }"
                                           @dragover.prevent="isDragOver = true"
                                           @dragleave.prevent="isDragOver = false"
                                           @drop.prevent="handleFileDrop($event)">

                                        <div class="space-y-4">
                                            <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-500/30 transition-colors duration-200">
                                                <i data-lucide="upload-cloud" class="w-8 h-8 text-blue-400"></i>
                                            </div>

                                            <div x-show="!fileName">
                                                <p class="text-lg font-medium text-white">Choose file or drag & drop</p>
                                                <p class="text-sm text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                            </div>

                                            <div x-show="fileName" class="text-center">
                                                <p class="text-lg font-medium text-white" x-text="fileName"></p>
                                                <p class="text-sm text-gray-400" x-text="fileSize"></p>
                                                <button type="button"
                                                        @click.stop="removeFile()"
                                                        class="mt-2 text-red-400 hover:text-red-300 text-sm">
                                                    Remove file
                                                </button>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="method" value="{{ $payment_mode->name }}">
                    <input type="hidden" name="paymethd_method" value="{{ $payment_mode->name }}">
                    @if($asset)
                    <input type="hidden" name="asset" value="{{ $asset }}">
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                                :disabled="!fileName"
                                class="w-full relative group overflow-hidden"
                                :class="!fileName ? 'opacity-50 cursor-not-allowed' : 'hover:scale-[1.02] active:scale-[0.98]'">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur-lg opacity-50 group-hover:opacity-75 transition-opacity duration-200"></div>
                            <div class="relative bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-2xl flex items-center justify-center gap-3 transition-all duration-200">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                <span class="text-lg font-semibold">Submit Payment Proof</span>
                            </div>
                        </button>

                        <!-- Security Notice -->
                        <div class="mt-6 flex items-center justify-center gap-3 text-sm text-gray-400">
                            <i data-lucide="shield-check" class="w-5 h-5 text-green-400"></i>
                            <span>Protected by 256-bit SSL encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Help Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 text-center">
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="headphones" class="w-6 h-6 text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">24/7 Support</h3>
                <p class="text-gray-400 text-sm">Need help? Our support team is available around the clock</p>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 text-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="zap" class="w-6 h-6 text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Instant Processing</h3>
                <p class="text-gray-400 text-sm">Deposits are processed within minutes of confirmation</p>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 text-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield" class="w-6 h-6 text-purple-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Bank-Grade Security</h3>
                <p class="text-gray-400 text-sm">Your funds and data are protected with enterprise security</p>
            </div>
        </div>
    </div>
</div>

<script>
    function paymentHandler() {
        return {
            copied: false,
            fileName: '',
            fileSize: '',
            isDragOver: false,

            copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                    }, 2000);
                });
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                    this.fileSize = `${(file.size / 1024 / 1024).toFixed(2)}MB`;
                }
            },

            handleFileDrop(event) {
                this.isDragOver = false;
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    document.getElementById('proof').files = event.dataTransfer.files;
                    this.fileName = file.name;
                    this.fileSize = `${(file.size / 1024 / 1024).toFixed(2)}MB`;
                }
            },

            removeFile() {
                document.getElementById('proof').value = '';
                this.fileName = '';
                this.fileSize = '';
            },

            downloadQR() {
                const img = document.querySelector('img[alt="Payment QR Code"]');
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'payment-qr-code.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

@endsection


