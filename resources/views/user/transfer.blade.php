
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Transfer Funds</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Send funds securely to other platform users</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Balance Card -->
        <div class="mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 max-w-md mx-auto">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                        <i data-lucide="wallet" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Balance</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto p-6 md:p-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl mr-4">
                    <i data-lucide="send" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Send Funds</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Transfer funds to another user account</p>
                </div>
            </div>

            <form method="post" action="javascript:void(0)" id="transferform" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Recipient Email or Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="text" name="email" id="email"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="Enter recipient's email or username"
                            required>
                    </div>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Amount ({{ Auth::user()->currency }}) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="banknote" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="number" name="amount" id="amount"
                            min="{{ $moresettings->min_transfer }}"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="Enter amount to transfer"
                            required>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Minimum transfer amount: {{ Auth::user()->currency }}{{ number_format($moresettings->min_transfer, 2) }}
                    </p>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Transfer Information</h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                <p>Transfer fee: <span class="font-semibold">{{ $moresettings->transfer_charges }}%</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="password" id="acntpass">

                <button type="submit" id="subbtn"
                    class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>Transfer Funds</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Form submission handler with improved UX
            document.getElementById('transferform').addEventListener('submit', function(e) {
                e.preventDefault();

                (async () => {
                    // Enhanced password prompt
                    const { value: password } = await Swal.fire({
                        title: 'Confirm Transfer',
                        html: `<div class="text-left">
                                <p class="mb-4">Please enter your password to complete this transfer.</p>
                                <div class="bg-blue-50 p-3 rounded-lg mb-4">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-shield-alt mr-1"></i>
                                        This is a security measure to protect your account.
                                    </p>
                                </div>
                            </div>`,
                        input: 'password',
                        inputPlaceholder: 'Enter your account password',
                        confirmButtonText: 'Confirm Transfer',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Please enter your password to proceed';
                            }
                        },
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-2',
                            cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-xl px-6 py-2'
                        }
                    });

                    if (password) {
                        // Get form values for better UX messaging
                        const amount = document.getElementById('amount').value;
                        const recipient = document.getElementById('email').value;

                        // Update button state
                        const submitBtn = document.getElementById('subbtn');
                        const originalContent = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg> Processing...`;

                        // Set password and submit
                        document.getElementById('acntpass').value = password;

                        // Ajax submission
                        fetch("{{ route('transfertouser') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify({
                                email: recipient,
                                amount: amount,
                                password: password,
                                _token: document.querySelector('input[name="_token"]').value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Transfer Successful',
                                    html: `<div class="text-left">
                                        <p class="mb-3">${data.message}</p>
                                        <div class="bg-green-50 p-3 rounded-lg">
                                            <p class="text-sm text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Funds have been sent to ${recipient}
                                            </p>
                                        </div>
                                    </div>`,
                                    confirmButtonText: 'Continue',
                                    customClass: {
                                        popup: 'rounded-2xl',
                                        confirmButton: 'bg-green-600 hover:bg-green-700 text-white rounded-xl px-6 py-2',
                                    }
                                }).then(() => {
                                    window.location.href = "{{ url('/dashboard/transfer-funds') }}";
                                });
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalContent;

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Transfer Failed',
                                    text: data.message || 'An error occurred during transfer',
                                    confirmButtonText: 'Try Again',
                                    customClass: {
                                        popup: 'rounded-2xl',
                                        confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-2',
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalContent;

                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: 'Please try again or contact support if the problem persists',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'rounded-2xl',
                                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-2',
                                }
                            });
                        });
                    }
                })();
            });

            // Add live calculation of transfer fee as user types amount
            document.getElementById('amount').addEventListener('input', function() {
                const amount = parseFloat(this.value) || 0;
                const feePercentage = {{ $moresettings->transfer_charges }};
                const feeAmount = (amount * feePercentage / 100).toFixed(2);
                const netAmount = (amount - feeAmount).toFixed(2);

                const feeInfo = document.querySelector('.text-blue-700.dark\\:text-blue-400');
                if (feeInfo) {
                    feeInfo.innerHTML = `
                        <p>Transfer fee: <span class="font-semibold">${feePercentage}%</span> (${feeAmount} {{ Auth::user()->currency }})</p>
                        <p class="mt-1">Recipient will receive: <span class="font-semibold">${netAmount} {{ Auth::user()->currency }}</span></p>
                    `;
                }
            });
        });
    </script>
@endsection
