@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Managed Accounts
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-lg-8">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-header border-0">
                    <!-- Title -->
                    <h2 class="h3 mb-0">
                        Advanced {{ $settings->site_name }} Account manager
                    </h2>
                </div>

                <div class="card-body">
                    <h4 class="mb-3">Description</h4>

                    <p class="mb-3">
                        Don’t have time to trade or learn how to trade?</p>
                    <p>
                        Our Account Management Service is The Best Profitable Trading Option for you,
                        We can help you to manage your account in the financial MARKET with a simple
                        subscription model.
                    </p>
                    <small>
                        Terms and Conditions apply</small><br>Reach us at {{ $settings->contact_email }}
                    for more info.

                    <h4 class="my-3">Checklist</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist1" checked
                                    disabled>
                                <label class="form-check-label" for="checklist1">
                                    Trade on your behalf
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist2" checked
                                    disabled>
                                <label class="form-check-label" for="checklist2">
                                    Manage your account
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    Withdraw your profit yourself
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    24/7 Support
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Transparency
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    You're 100% in Control
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Safe & Secure
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-5">Accounts under management.</h4>
                    @if ($subscriptions->count() === 0)
                        <div class="text-center">
                            <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                            <h2 class="h3">You have no managed accounts</h2>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#submitmt4modal">
                                Add Account
                            </a>
                        </div>
                    @else
                        <div class=" table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Account</th>
                                    <th>Currency</th>
                                    <th>Leverage</th>
                                    <th>Server</th>
                                    <th>Duration</th>
                                    <th>Account Password</th>
                                    <th>Status</th>
                                    <th>Submited at</th>
                                    <th>Start/End date</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td>
                                                {{ $sub->mt4_id }} <br> {{ $sub->account_type }}
                                            </td>
                                            <td>
                                                {{ $sub->currency }}
                                            </td>
                                            <td>
                                                {{ $sub->leverage }}
                                            </td>
                                            <td>
                                                {{ $sub->server }}
                                            </td>
                                            <td>
                                                {{ $sub->duration }}
                                            </td>
                                            <td>
                                                **********
                                            </td>
                                            <td>
                                                <span class="badge bg-info"> {{ $sub->status }}</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($sub->created_at)->format('M d Y') }}
                                            </td>
                                            <td>
                                                @if (!empty($sub->start_date))
                                                    {{ \Carbon\Carbon::parse($sub->start_date)->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                                /
                                                @if (!empty($sub->end_date))
                                                    {{ \Carbon\Carbon::parse($sub->end_date)->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $endAt = \Carbon\Carbon::parse($sub->end_date);
                                                    $remindAt = \Carbon\Carbon::parse($sub->reminded_at);
                                                @endphp
                                                <a href="#" data-bs-toggle="modal" class="btn btn-danger btn-sm"
                                                    onclick="deletemt4()">Cancel</a>
                                                @if (($sub->status != 'Pending' && now()->isSameDay($remindAt)) || $sub->status == 'Expired')
                                                    <a href="{{ route('renewsub', $sub->id) }}"
                                                        class="btn btn-primary btn-sm">Renew</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <livewire:user.add-new-account />
        </div>
    </div> <!-- / .row -->
@endsection
@push('scripts')
    <script type="text/javascript">
        function deletemt4() {
            Swal.fire({
                title: 'Error!',
                text: 'Send an Email to {{ $settings->contact_email }} to have your Account cancelled.',
                icon: 'error',
                confirmButtonText: 'Okay'
            });
        }
    </script>
@endpush
