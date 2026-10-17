@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Signal Provider
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (!$subscription)
                                <div class="text-center">
                                    <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                    <p>You do not have have a subscription</p>
                                    <button type="button" class="btn btn-primary px-4 btn-sm"" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Subscribe Now
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalCenterTitle">Subscribe payment
                                                    to signal provider</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <livewire:user.subscribe-to-signal />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class=" h5">{{ $subscription->subscription }} Subscription</h3>
                                            <h3 class="text-primary">{{ $settings->currency . $subscription->amount_paid }}
                                            </h3>
                                        </div>
                                        <div>
                                            <small class="text-danger">Expiring</small>
                                            <p class="m-0">
                                                {{ \Carbon\Carbon::parse($subscription->expired_at)->toDayDateTimeString() }}
                                            </p>

                                            @if (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->reminded_at)) or
                                                    now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->expired_at)))
                                                <div>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Pay
                                                        @if ($subscription->subscription == 'Monthly')
                                                            {{ $settings->currency . $set->signal_monthly_fee }}
                                                        @elseif ($subscription->subscription == 'Quarterly')
                                                            {{ $settings->currency . $set->signal_monthly_fee }}
                                                        @else
                                                            {{ $settings->currency . $set->signal_yearly_fee }}
                                                        @endif
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Renew
                                                                        your Subscription</h6>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h5>
                                                                        @if ($subscription->subscription == 'Monthly')
                                                                            {{ $settings->currency . $set->signal_monthly_fee }}
                                                                        @elseif ($subscription->subscription == 'Quarterly')
                                                                            {{ $settings->currency . $set->signal_monthly_fee }}
                                                                        @else
                                                                            {{ $settings->currency . $set->signal_yearly_fee }}
                                                                        @endif will be deducted from
                                                                        your
                                                                        account balance..
                                                                    </h5>
                                                                    <div class="mt-2 text-right">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a href="{{ route('renewsignals') }}"
                                                                            class="btn btn-primary btn-sm">Yes,
                                                                            Proceed</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
