<?php
use App\Product;
?>
<div class="tab-pane  active" id="blockView">
					<ul class="thumbnails">
                        @foreach($categoryProducts as $product)
						<li class="span3">
							<div class="thumbnail" style="height: 420px;">
								<a href="{{ url('/product/'.$product['id']) }}">
                                <?php $product_image_path = 'images/product_images/small/'.$product['main_image'];
								$dummy_image = 'images/product_images/dummy_image/dummy_image.png';
								?>
								@if(isset($product['main_image']) && !empty($product['main_image']))
								<img style="width: 250px; height: 250px;" src="{{ asset($product_image_path) }}" alt=""/>
								@else
								<img style="width: 250px; height: 250px;" src="{{ asset($dummy_image) }}" alt="">
								@endif
								<!-- @if(!empty($product['main_image']) && file_exists($product_image_path))
								<img style="width: 160px; height: 175px" src="{{ asset($product_image_path) }}" alt=""/></a>
								@else
									<img style="width: 175px; height: 175px" src="{{ asset($dummy_image) }}" alt="">
								@endif -->
                                </a>
								<div class="caption">
									<h5>{{ $product['product_name'] }}</h5>
									<p>
										{{ $product['brand'] ['name']}}
									</p>
									<!-- <p>
										{{ $product['fabric']}}
									</p>
									<p>
										{{ $product['pattern']}}
									</p>
									<p>
										{{ $product['sleeve']}}
									</p>
									<p>
										{{ $product['fit']}}
									</p>
									<p>
										{{ $product['occasion']}} -->
									</p>
									<?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
									
									<h4 style="text-align:center"><a class="btn" href="{{ url('/product/'.$product['id']) }}"> <i class="icon-zoom-in"></i></a> 
									<a class="btn" href="{{ url('/product/'.$product['id']) }}">Add to <i class="icon-shopping-cart"></i></a>
									 <a class="btn btn-primary" href="#">
									 @if($discounted_price>0)
									 <del>{{$product['product_price']}}</del> 
									  <!-- {{ $discounted_price }} -->
									@else
									 {{ $product['product_price'] }}
									@endif	
									</a></h4>
									@if($discounted_price>0)
								<h4>Discounted Price Rs. {{ $discounted_price }}</h4>
								@endif
								</div>

							</div>
						</li>
                        @endforeach
					</ul>
					<hr class="soft"/>
				</div>