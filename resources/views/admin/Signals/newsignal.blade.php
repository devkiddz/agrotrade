@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="title1 ">Add Investment Plan</h1>
                        </div>
                        <div>
                            <a href="{{ route('signals') }}" class="btn btn-sm btn-primary"> <i class="fa fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-lg-12 ">
                        <div class="p-3 card ">
                            <form role="form" method="post" action="{{ route('addsignal') }}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <h5 class="">Signal Name</h5>
                                        <input class="form-control  " placeholder="Enter Plan name" type="text"
                                            name="name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <h5 class="">Signal price({{ $settings->currency }})</h5>
                                        <input class="form-control  " placeholder="Enter Plan price" type="number"
                                            name="price" required>
                                        <small class="">This is the  amount a user can pay
                                            to get in this signal, enter the value without a comma(,)</small>
                                    </div>
                                    
                                   
                                   
                                    
                                    

                                    <div class="form-group col-md-6">
                                        <h5 class="">Increament (in % )</h5>
                                        <input class="form-control  " placeholder="Increament Amount" type="number"
                                            step="any" name="increment_amount" required>
                                        {{-- <small class="">This is the amount the system will add to
                                            users account as profit, based on what you selected in topup type and topup
                                            interval above.</small> --}}
                                    </div>

                                  
                                    <div class="form-group col-md-12">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-primary" value="Add Signal">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="topupModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body ">

                    </div>
                </div>
            </div>
        </div>

        <script>
            function getduration(id, event) {
                event.preventDefault();
                document.getElementById('duridden').value = id;
            }
        </script>
    @endsection
