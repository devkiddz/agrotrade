<?php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = 'light';
} else {
    $text = "light";
	$bg = 'dark';
}
?>
@extends('layouts.app')
    @section('content')
        @include('admin.topmenu')
        @include('admin.sidebar')
		<div class="main-panel">
			<div class="content bg-{{$bg}}">
				<div class="page-inner">
					<div class="mt-2 mb-4">
						<h1 class="title1 text-{{$text}}">Add Copy Trading  Paln</h1>
					</div>
					<x-danger-alert/>
                    <x-success-alert/>
					<div class="mb-5 row">
						<div class="col-lg-10  ">
                            <div class="p-3 card bg-{{$bg}}">
                                <form role="form" method="post" action="{{ route('addcopytrading') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Expert Trader Tag (MID/PRO)</h5>
                                            <input  class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Enter Expert Trader Tag" type="text" name="tag" required>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Trader Name</h5> 
                                            <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Enter Expert Trader Name" type="text" name="name" required>   
                                            
                                       </div>	
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Expert Trader Number of Followers</h5> 			 
                                             <input placeholder="Enter Expert Trader Number of Followers" class="form-control text-{{$text}} bg-{{$bg}}" type="text" name="followers" required>  
                                             <small class="text-{{$text}}">This is the  number of followers who currently trading with the Expert</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                             <h5 class="text-{{$text}}">Enter Expert Total profit ({{$settings->currency}})</h5> 			 
                                             <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Enter Expert Total profit" type="text" name="total_profit" required> 
                                            <small class="text-{{$text}}">This is the Total Profit made by this Expert trader</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Copy Trade Type (Copy/Buy)</h5> 
                                            <select class="form-control text-{{$text}} bg-{{$bg}}" name="button_name">
                                                <option>Copy</option>
                                                <option>Buy</option>
                
                                            </select>  
                                        
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Expert Trader Active Days</h5> 
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Enter maximum return" type="text" name="active_days" required>  
                                           <small class="text-{{$text}}">This is the expected days trader is available</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">Equity (Wining rate) %</h5> 
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Enter Expert trade Equity" type="text" name="equity" value="0" required>  
                                           <small class="text-{{$text}}">This is Expert Wining Rate </small>  
                                       </div>
                                       
                                      

                                       <div class="form-group col-md-5">
                                           <h5 class="text-{{$text}}"> Startup Amount ({{$settings->currency}})</h5> 
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder=" Startup Amount" type="text" name="price" required> 
                                           <small class="text-{{$text}}">This is the price of this Copytrading </small>   
                                       </div>
                                      
                                       <div class="form-group col-md-5">
                                        <h5 class="text-{{$text}}">Expert Trader rating</h5> 
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Expert Trader rating" type="number" name="rating" required> 
                                           <small class="text-{{$text}}">This Expert Trader rating  (Max is 5 stars)  </small> 
                                           <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                             <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            
                                       </div>



                                       <div class="form-group col-md-5">
                                        <h5 class="text-{{$text}}">Expert Trader Photo</h5> 
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="Expert Trader photo" type="file"  name="photo" required> 
                                           <small class="text-{{$text}}">This Expert Trader Photo </small> 
                                        
                                       </div>
                                       <div class="form-group col-md-12">
                                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                           <input type="submit" class="btn btn-secondary" value="Add New Copy Trading Plan">   
                                       </div>
                                    </div>
                               </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
            
            <div id="durationModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-{{$bg}}">
                            <h5 class="text-{{$text}}">FIRSTLY, Always preceed the time frame with a digit, that is do not write the number in letters, <br> <br> SECONDLY, always add space after the number, <br> <br> LASTLY, the first letter of the timeframe should be in CAPS and always add 's' to the timeframe even if your duration is just a day, month or year.</h5>
                            <h2 class="text-{{$text}}">Eg, 1 Days, 3 Weeks, 1 Hours, 48 Hours, 4 Months, 1 Years, 9 Months</h2>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="topupModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-{{$bg}}">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function getduration(id, event){
                    event.preventDefault();
                    document.getElementById('duridden').value = id;
                }
            </script>
            <style>
                .checked {
  color: orange;
}
                </style>

	@endsection