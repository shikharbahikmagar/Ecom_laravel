<?php
 use App\Banner;
 $getBanners = Banner::banners();
$bannerCount = Banner::where('status', 1)->count();
?>
@if(isset($page_name) && $page_name=="index")
<div id="carouselBlk">
	<div id="myCarousel" @if($bannerCount>1) class="carousel slide" @endif>
		<div class="carousel-inner">
			@foreach($getBanners as $key=>$banner)
			<div class="item @if($key==0) active @endif">
				<div class="container">
					<a href="{{ url('/') }}"><img src="{{ asset('images/front_images/carousel/'.$banner['image']) }}" alt=""/></a>
					<div class="carousel-caption">
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>
</div>
@endif