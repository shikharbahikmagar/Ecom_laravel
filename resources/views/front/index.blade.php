@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
				<div class="well well-small">
					<h4>Featured Products <small class="pull-right">{{ $featuredItemCount }} Featured Products</small></h4>
					<div class="row-fluid">
						<div id="featured" @if($featuredItemCount>4) class="carousel slide" @endif>
							<div class="carousel-inner">
								@foreach($featuredItemChunk as $key=>$featuredItem)
								<div class="item @if($key == 1) active @endif">
									<ul class="thumbnails">
										@foreach($featuredItem as $item)
										<li class="span3">
											<div class="thumbnail">
												
												<a href="product_details.html">
													<?php $product_image_path = 'images/product_images/small/'.$item['main_image'];
													?>
													@if(!empty($item['main_image']) && file_exists($product_image_path))
													<img src="{{ asset($product_image_path) }}" alt=""></a>
													@else
													<img src="{{ asset('images/product_images/dummy_image/dummy_image.png') }}" alt="">
													@endif
												<div class="caption">
													<h5>{{ $item['product_name'] }}</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">{{ $item['product_price'] }}</span></h4>
												</div>
											</div> 
										</li>
										@endforeach
									</ul>
								</div>
								@endforeach
							</div>
							<a class="left carousel-control" href="#featured" data-slide="prev">&lsaquo;</a>
							<a class="right carousel-control" href="#featured" data-slide="next">&rsaquo;</a>
						</div>
					</div>
				</div>
				<h4>Latest Products </h4>
				
				<ul class="thumbnails">
				@foreach($latestProducts as $newProduct)
					<li class="span3">
						<div class="thumbnail">
						<i class="tag"></i>
							<a  href="product_details.html">
								<?php $latest_image_path = 'images/product_images/small/'.$newProduct['main_image'];
								$dummy_image = 'images/product_images/dummy_image/dummy_image.png';
								?>
								@if(!empty($newProduct['main_image']) && file_exists($latest_image_path))
								<img style="width: 160px; height: 175px" src="{{ asset($latest_image_path) }}" alt=""/></a>
								@else
								{
									<img style="width: 175px; height: 175px" src="{{ asset($dummy_image) }}" alt="">
								}
								@endif
							<div class="caption">
								<h5>{{ $newProduct['product_name'] }}</h5>
								<p>
									{{ $newProduct['product_color'] }}
								</p>
								
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> 
								<a class="btn btn-primary" href="#">{{ $newProduct['product_price'] }}</a></h4>
							</div>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
@endsection