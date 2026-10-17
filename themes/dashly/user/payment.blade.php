@extends('layouts.dashly')
@section('title', $title)
@push('styles')
    <link rel="stylesheet" href="{{ asset('dash/css/stripeglobal.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/stripenormalize.css') }}">
@endpush
@section('content')
    @php
        if ($payment_mode->name == 'Bitcoin') {
            $coin = 'BTC';
        } elseif ($payment_mode->name == 'Litecoin') {
            $coin = 'LTC';
        } elseif ($payment_mode->name == 'Ethereum') {
            $coin = 'ETH';
        } elseif ($payment_mode->name == 'BUSD') {
            $coin = 'BUSD';
        } else {
            $coin = 'USDT.TRC20';
        }
    @endphp
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2">
                    Make payment
                </h1>
                <div>
                    <a href="{{ route('cancelpayment') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-x"></i>
                        Cancel payment
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div @class(['card'])>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar avatar-lg text-bg-gray-300 d-flex align-items-center justify-content-center">
                            @if (empty($payment_mode->img_url))
                                <svg width="42px" height="37px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M512 512m-480 0a480 480 0 1 0 960 0 480 480 0 1 0-960 0Z" fill="#E9E8FF" />
                                    <path d="M467.2 332.8l230.4-83.2 44.8 83.2zM384 332.8l96-83.2 38.4 51.2-64 32z"
                                        fill="#C6C9FF" />
                                    <path
                                        d="M300.8 755.2c-25.6 0-51.2-25.6-51.2-51.2V384c0-25.6 25.6-51.2 51.2-51.2h428.8c25.6 0 51.2 25.6 51.2 51.2v313.6c0 25.6-25.6 51.2-51.2 51.2l-428.8 6.4z"
                                        fill="#8880FE" />
                                    <path
                                        d="M761.6 608H704c-25.6 0-51.2-19.2-51.2-51.2v-19.2c0-25.6 25.6-51.2 51.2-51.2h57.6c25.6 0 51.2 19.2 51.2 51.2v25.6c0 25.6-19.2 44.8-51.2 44.8z"
                                        fill="#C6C9FF" />
                                </svg>
                            @else
                                <img src="{{ $payment_mode->img_url }}" alt="" srcset="" width="42px"
                                    height="37px">
                            @endif
                        </div>
                        <div>
                            <h1>{{ $settings->currency . ' ' . $amount }}</h1>
                        </div>
                    </div>
                    <!-- Title -->
                    <h3 class="card-title mt-3 mb-0 text-dark">{{ $payment_mode->name }}</h3>
                    <span class="text-muted m-0 p-0">Pay via {{ strtolower($payment_mode->name) }}</span>
                </div>
            </div>
        </div>
    </div>
    @if ($title != 'Complete Payment')
        @if ($payment_mode->methodtype == 'crypto')
            @include('livewire.user.deposit.crypto-payment')
            {{-- <livewire:user.deposit.crypto-payment /> --}}
        @endif
        @if ($payment_mode->methodtype == 'currency')
            @include('livewire.user.deposit.currency-payment')
            {{-- <livewire:user.deposit.bank-payment /> --}}
        @endif
    @endif
    {{-- Automatic Cryptopayment qrcode --}}
    @if ($title == 'Complete Payment')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                                <div class="text-center">
                                    <h4>
                                        Send {{ $amount }} to the below address or
                                        scan the {{ $coin }} QR code to complete payment.
                                    </h4>
                                    <h4><strong>{{ $p_address }}</strong></h4>
                                    <div>
                                        <img width="220" height="220" alt="Payment QR code" src="{{ $p_qrcode }}">
                                    </div>
                                    <div class="mt-3">
                                        <small>
                                            you can exit this page after scanning and completed payment, the
                                            system will keep track of your payment and update your account
                                            accordingly
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script type="text/javascript">
        var stripe = Stripe("{{ $settings->s_p_k }}");
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
            }
        };
        const paybtn = document.querySelector('#stripesubmit');
        paybtn.disabled = true;

        var card = elements.create("card", {
            style: style
        });

        card.mount("#card-element");

        function checkcardforerrors() {
            card.on('change', function(event) {
                if (event.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: event.error.message,
                        icon: 'error',
                    });
                    paybtn.disabled = true;
                } else {
                    paybtn.disabled = false;
                }
            });
        }
        checkcardforerrors();

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
            paybtn.disabled = true;
            ev.preventDefault();
            checkcardforerrors();
            document.getElementById('spinner').classList.remove('d-none');
            document.getElementById('buttontext').classList.add('d-none');

            // If the client secret was rendered server-side as a data-secret attribute
            // on the <form> element, you can retrieve it here by calling `form.dataset.secret`
            var clientSecret = "{{ $intent }}";
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: "{{ Auth::user()->name }}"
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error processing your payment, Please try depositing again.',
                        icon: 'error',
                    });
                    paybtn.disabled = false;
                    document.getElementById('spinner').classList.add('d-none');
                    document.getElementById('buttontext').classList.remove(
                        'd-none');
                    console.log(result.error.message);
                } else {
                    // The payment has been processed!
                    if (result.paymentIntent.status === 'succeeded') {
                        $.ajax({
                            url: "{{ url('/dashboard/submit-stripe-payment') }}",
                            type: 'POST',
                            data: $('#selectform').serialize(),
                            success: function(data) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.success,
                                    icon: 'success',
                                });
                                setTimeout(function() {
                                    window.location.replace(
                                        "{{ route('accounthistory') }}");
                                }, 3000);
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error Submiting Payment Data',
                                    icon: 'error',
                                    confirmButtonText: 'Okay'
                                });
                                console.log(error);
                                paybtn.disabled = false;
                                document.getElementById('spinner').classList.add('d-none');
                                document.getElementById('buttontext').classList.remove(
                                    'd-none');
                            },
                        });
                    }
                }
            });

        });
    </script>
@endpush
