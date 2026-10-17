@extends('layouts.base')

@section('title', $settings->site_title)

@section('styles')
@parent

@endsection
@inject('content', 'App\Http\Controllers\FrontController')
@section('content')

<section class="hero-section">
	<div class="container">
		<h1>Terms Of Use</h1>
		<p class="wow slideInLeft">All users are advice to read carefully to know the guides governing our terms of use.</p>
	</div>
</section>
<div class="container my-5">
  <p>These {{$settings->site_name}} Terms of Use is entered into between you (hereinafter referred to as “you” or “your”) and {{$settings->site_name}} operators (as defined below). By accessing, downloading, using or clicking on “I agree” to accept any {{$settings->site_name}} Services (as defined below) provided by {{$settings->site_name}} (as defined below), you agree that you have read, understood and accepted all of the terms and conditions stipulated in these Terms of Use (hereinafter referred to as “these Terms”) as well as our Privacy Policy In addition, when using some features of the Services, you may be subject to specific additional terms and conditions applicable to those features.</p>
  <p>Please read the terms carefully as they govern your use of {{$settings->site_name}} Services. THESE TERMS CONTAIN IMPORTANT PROVISIONS INCLUDING AN ARBITRATION PROVISION THAT REQUIRES ALL CLAIMS TO BE RESOLVED BY WAY OF LEGALLY BINDING ARBITRATION. The terms of the arbitration provision are set forth in Article 10, “Resolving Disputes: Forum, Arbitration, Class Action Waiver”, hereunder. As with any asset, the values of Digital Currencies (as defined below) may fluctuate significantly and there is a substantial risk of economic losses when purchasing, selling, holding or investing in Digital Currencies and their derivatives.BY MAKING USE OF {{$settings->site_name}} SERVICES, YOU ACKNOWLEDGE AND AGREE THAT: (1) YOU ARE AWARE OF THE RISKS ASSOCIATED WITH TRANSACTIONS OF DIGITAL CURRENCIES AND THEIR DERIVATIVES; (2) YOU SHALL ASSUME ALL RISKS RELATED TO THE USE OF {{$settings->site_name}} SERVICES AND TRANSACTIONS OF DIGITAL CURRENCIES AND THEIR DERIVATIVES; AND (3) {{$settings->site_name}} SHALL NOT BE LIABLE FOR ANY SUCH RISKS OR ADVERSE OUTCOMES.</p>
  <p>By accessing, using or attempting to use {{$settings->site_name}} Services in any capacity, you acknowledge that you accept and agree to be bound by these Terms. If you do not agree, do not access {{$settings->site_name}} or utilize {{$settings->site_name}} services.</p>						
</div>







@endsection