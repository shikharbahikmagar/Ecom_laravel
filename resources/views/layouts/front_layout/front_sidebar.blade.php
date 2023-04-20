<?php 
use App\Section;
$sections = Section::sections();

?>
<div id="sidebar" class="span3">
				<div class="well well-small"><a id="myCart" href="product_summary.html"><img src="{{ asset('images/front_images/ico-cart.png') }}" alt="cart">3 Items in your cart</a></div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">
					@foreach($sections as $section)
					@if(count($section['categories'])>0)
					<li class="subMenu"><a>{{ $section['name'] }}</a>
						<ul>
							@foreach($section['categories'] as $category)
							<li><a href="{{ url($category['url']) }}"><i class="icon-chevron-right"></i><strong>{{ $category['category_name'] }}</strong></a></li>
							@foreach($category['subcategories'] as $subcategory)
							<li><a href="{{ url($subcategory['url']) }}"><i class="icon-chevron-right"></i>{{ $subcategory['category_name'] }}</a></li>
							@endforeach
							@endforeach
						</ul>
					</li>
					@endif
					@endforeach
				</ul>
				<br/>
				<div class="thumbnail">
					<img src="{{ asset('images/front_images/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
					<div class="caption">
						<h5>Payment Methods</h5>
					</div>
				</div>
			</div>