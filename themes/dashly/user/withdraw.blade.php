@extends('layouts.dasht')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Complete withdrawal request
    </h1>
    @if (session('status'))
        <script type="text/javascript">
            Swal.fire({
                title: 'Error!',
                text: "{{ session('status') }}",
                icon: 'error',
                confirmButtonText: 'Okay'
            })
        </script>
        {{ session()->forget('status') }}
    @endif
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5 row">
                        <div class="col-lg-8 offset-md-2">
                            <div class="mb-3">
                                <h4 class="h2"> <i class="bi bi-cursor"></i> {{ $payment_mode }}</h4>
                            </div>
                            @if ($payment_mode == 'USDT' and $settings->auto_merchant_option == 'Binance' and $settings->withdrawal_option == 'auto')
                                <livewire:user.crypto-withdaw :payment_mode="$payment_mode" />
                            @else
                                <form action="{{ route('completewithdrawal') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="">Enter Amount to
                                            withdraw({{ $settings->currency }})</label>
                                        <input class="form-control " placeholder="Enter Amount" type="number"
                                            name="amount" step="any" required>
                                    </div>
                                    <input value="{{ $payment_mode }}" type="hidden" name="method">

                                    @if (Auth::user()->sendotpemail == 'Yes')
                                        <div class="mb-3">
                                            <label class="m-1 d-inline">Enter OTP</label>
                                            <div class="float-right m-1 btn-group d-inline">
                                                <a class="btn btn-primary btn-sm" href="{{ route('getotp') }}"> <i
                                                        class="fa fa-envelope"></i> Request OTP</a>
                                            </div>
                                            <input class="form-control " placeholder="Enter OTP" type="text"
                                                name="otpcode" required>
                                            <small class="">OTP will be sent to your email when you
                                                request</small>
                                        </div>
                                    @endif
                                    @if (!$default or $payment_mode == 'BUSD')
                                        @if ($methodtype == 'crypto')
                                            <div class="mb-3">
                                                <h5 class="">Enter {{ $payment_mode }} Address </h5>
                                                <input class="form-control " placeholder="Enter {{ $payment_mode }} Address"
                                                    type="text" name="details" required>
                                                <small class="">{{ $payment_mode }} is not a default
                                                    withdrawal option in your account, please enter the correct
                                                    wallet address to recieve your funds.</small>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                <label class="">Enter {{ $payment_mode }} Details </label>
                                                <textarea class="form-control " row="4" name="details"
                                                    placeholder="BankName: Name, Account Number: Number, Account name: Name, Swift Code: Code" required>
                                            
                                            </textarea>
                                                <small class="">{{ $payment_mode }} is not a default
                                                    withdrawal option in your account, please enter the correct bank
                                                    details seperated by comma to recieve your funds.</small> <br />
                                                <span class="text-danger">BankName: Name, Account Number: Number,
                                                    Account name: Name, Swift Code: Code</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type='submit'>Complete Request</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
