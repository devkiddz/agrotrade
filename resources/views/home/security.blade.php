
@extends('layouts.base')

@section('title', 'Terms And Condition')


@section('content')
<section class="hero-section">
	<div class="container">
		<h1>Services</h1>
	</div>
</section>

<section class="bg-light-blue py-5">
	<div class="container">
		<div class="text-center">
			<div class="text-primary text-uppercase small font-weight-bold">OUR SERVICES</div>
			<h1 class="my-4">Bring to the table win-win survival<br/>strategies to ensure proactive<br/>domination. </h1>
			<div class="divider"></div>
		</div>
		<div class="sliderteam mt-4">
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/investment-consultancy-sm.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Investment Consultancy</h5>
						<!-- featured-desc-->
						<p>We do in-depth work on formulating clients' investment strategies, helping them fulfill their investment dreams.</p>
                        <p>Bullishforx Limited provides investors with investment products, advice and/or planning, do in-depth work on formulating investment strategies, helping you fulfill your needs and reach your financial goals. We also provide strategic advice on asset allocation, risk management, investment policy development, asset class structuring, investment manager evaluation and monitoring.</p>
                                    
					</div>
				</div>
			</div>
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/crypto-investment-sm.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Cryptocurrency Investment</h5>
						<!-- featured-desc-->
						<p>Virtual or crypto currencies like Bitcoin and Ethereum are definitely by far the hottest investment.</p>
                        <p>Cryptocurrency is a form of digital money that is designed to be secure and, in many cases, anonymous. It is a currency associated with the internet that uses cryptography, the process of converting legible information into an almost uncrackable code, to track purchases and transfers.</p>
					</div>
				</div>
			</div>
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/forex-investment-sm.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Forex Trading</h5>
						<!-- featured-desc-->
						<p>The Forex market also referred to as the "Currency market", it is the largest and most liquid market in the world.</p>
                        <p>The foreign exchange market (Forex) is the "place" where currencies are traded. Currencies are important to most people around the world, whether they realize it or not, because currencies need to be exchanged in order to conduct foreign trade and business. If you are living in the U.S. and want to buy cheese from France, either you or the company that you buy the cheese from has to pay the French for the cheese in euros (EUR).</p>
                                    
					</div>
				</div>
			</div>
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/stock-investment-sm.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Stock & Commodities</h5>
						<p>Stock &amp; Commodities can actually reduce overall risk as a part of a diversified portfolio.</p>
						<p>Investing in stocks can be very costly if you trade constantly, especially with a minimum amount of money available to invest. Stock investing &amp; Commodity investing do not always deliver the same return, there are times when one investment outperforms the other; maintaining an allocation to each group may help contribute to a portfolio's overall long-term performance.</p>
					</div>
				</div>
			</div>
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/real-estate-investment-sm.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Real Estate Investment</h5>
						<p>Buying real estate is about more than just finding a place to call home. Investing in real estate has become increasingly popular over the last 50 years and has become a common investment vehicle.</p>
						<p>Although the real estate market has plenty of opportunities for making big gains, buying and owning real estate is a lot more complicated than investing in stocks and bonds.</p>
					</div>
				</div>
			</div>
			<div class="feature-10 m-3">
				<div>
					<img src="temp/custom/images/cannabis-legalised.jpg" alt="">
					<div class="feature-10-desc">
						<h5>Cannabis Investment</h5>
						
						<p>Cannabis, also known as marijuana among other names, is a psychoactive drug from the Cannabis plant used for medical or recreational purposes.</p>
						<p>Global spending on legal cannabis is expected to grow 230%, to $31.3% billion in 2022, compared to $9.5 billion in 2017, according to Arcview Market Research and BDS Analytics.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center my-4">
			<a href="register" class="btn btn-primary">GET STARTED</a>
		</div>
	</div>
</section>
<section class="ttm-row ttm-bgcolor-darkgrey ttm-bg ttm-bgimage-yes bg-img1 services-section clearfix text-light" style="background-image: url(images/row-bgimage-2.jpg);">
	<div class="ttm-row-wrapper-bg-layer ttm-bg-layer"></div>
	<div class="container">
		<div class="text-center">
			<div class="row">
				<div class="col-md-12">
					<div class="text-primary text-uppercase small font-weight-bold">{{$settings->site_name}}</div>
					<h1 class="my-4">How Does it Work?</h1>
					<div class="divider"></div>
				</div>
			</div>
			<div style="max-width: 700px;margin-left: auto;margin-right: auto;">
			<div class="mt-4 videoWrapper">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/x7msE3tx8QI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div></div>
		</div>
		<div class="text-center my-4" style="position: relative;">
			<a href="services" class="btn btn-primary">READ MORE</a>
		</div>
	</div>
</section>
<div class="bg-white">
	<div class="container py-5">

	
	</div>
</div>
<script src="temp/custom/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

$('.sliderteam').slick({
	slidesToShow: 3,
	lazyLoad: 'ondemand',
	slidesToScroll: 3,
	autoplay: false,
	autoplaySpeed: 3000,
	infinite: true,
	arrows: false,
	dots: false,
	responsive: [
    {
      breakpoint: 645,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },]
});
</script>


@endsection