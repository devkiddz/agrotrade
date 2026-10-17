@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->

    <div class="d-flex justify-content-between">
        <h1 class="h2">
            Swap History
        </h1>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('assetbalance') }}">
                <i class="bi bi-arrow-left"></i>
                back
            </a>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Source</th>
                                            <th>Destination</th>
                                            <th>Amount(src)</th>
                                            <th>Quantity(dest)</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $tran)
                                            <tr>
                                                <td>{{ $tran->source }}</td>
                                                <td>{{ $tran->dest }}</td>
                                                <td>{{ round(number_format($tran->amount, 2, '.', ','), 6) }}</td>
                                                <td>{{ round($tran->quantity, 8) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tran->created_at)->toDayDateTimeString() }}
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No record available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
