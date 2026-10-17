@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">All Signals</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="col-12 card shadow p-4 ">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>Client name</th>
                                     <th>Asset</th>
                                     <th>Signal Type</th>
                                    <th>Signal Name</th>
                                    <th>Signal Status</th>
                                    <th>Amount Invested</th>
                                    <th>Expiration </th>
                                   
                                    {{-- <th>ROI</th> --}}
                                    <th>Start Date</th>
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($signals as $signal)
                                    <tr>
                                        
                                         @if (isset( $signal->suser->name ) &&  $signal->suser->name!= null) 
                                        <td>{{ $signal->suser->name }} 
                                            </td>
                                            @endif
                                            
                                          <td>{{ $signal->asset }}</td>
                                          @if($signal->status=='ongoing')
                                           <td><strong><span class="text-success">{{ $signal->status }}</span></strong></i></td>
                                        @else
                                        <td><strong><span class="text-danger">{{ $signal->status }}</span></strong></i></td>
                                        @endif
                                        @if($signal->order_type	=='Buy')
                                           <td><strong><span class="text-success"><i class="fas fa-arrow-up mr-1"></i>{{ $signal->order_type }}</span></strong></i></td>
                                        @else
                                        <td><strong><span class="text-danger"><i class="fas fa-arrow-down mr-1"></i>{{ $signal->order_type }}</span></strong></i></td>
                                        @endif
                                        <td>{{ $signal->dsignal->name }}</td>
                                      
                                       
                                        <td>
                                            {{ $signal->suser->currency }}{{ $signal->amount }}
                                        </td>
                                        <td>{{ $signal->expiration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($signal->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('deletesignal', $signal->id) }}">Delete Signal</a>
                                                
                                                        @if ($signal->status == 'ongoing')
                                                        <a href="{{ route('signalmarkas', ['id' => $signal->id, 'status' => 'expired']) }}"
                                                            class="m-1 btn btn-danger btn-sm">Mark as expired</a>
                                                    @else
                                                        <a href="{{ route('signalmarkas', ['id' => $signal->id, 'status' => 'ongoing']) }}"
                                                            class="m-1 btn btn-success btn-sm">Mark as active</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
