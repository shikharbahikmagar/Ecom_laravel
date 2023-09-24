<?php 
use App\Section;
$sections = Section::sections();

?>
<div id="sidebar" class="span3">
				<div class="well well-small"><a id="myCart" href="{{ url('/cart') }}"><img src="{{ asset('images/front_images/ico-cart.png') }}" alt="cart"><span class="totalCartItems">[ {{ totalCartItems() }} ]</span>  Items in your cart</a></div>
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
				<br>
				@if(isset($page_name) && $page_name=="listing" && !isset($_REQUEST))
				<div class="well well-small">
					<h5>Fabric</h5>
					@foreach($fabricArray as $fabric)
					<input style="margin-top: -3px;" class="fabric" type="checkbox" name="fabric[]" id="{{ $fabric }}" value="{{ $fabric }}" >
					&nbsp;&nbsp;{{$fabric}} <br>
					@endforeach
				</div>
				<div class="well well-small">
					<h5>Pattern</h5>
					@foreach($patternArray as $pattern)
					<input style="margin-top: -3px;" class="pattern" type="checkbox" name="pattern[]" id="{{ $pattern }}" value="{{ $pattern }}" 
					>&nbsp;&nbsp;{{$pattern}} <br>
					@endforeach
				</div>
				<div class="well well-small">
					<h5>Sleeve</h5>
					@foreach($sleeveArray as $sleeve)
					<input style="margin-top: -3px;" class="sleeve" type="checkbox" name="sleeve[]" id="{{ $sleeve }}" value="{{ $sleeve }}" 
					>&nbsp;&nbsp;{{$sleeve}} <br>
					@endforeach
				</div>
				<div class="well well-small">
					<h5>Fit</h5>
					@foreach($fitArray as $fit)
					<input style="margin-top: -3px;" class="fit" type="checkbox" name="fit[]" id="{{ $fit }}" value="{{ $fit }}" 
					>&nbsp;&nbsp;{{$fit}} <br>
					@endforeach
				</div>
				<div class="well well-small">
					<h5>Occasion</h5>
					@foreach($occasionArray as $occasion)
					<input style="margin-top: -3px;" class="occasion" type="checkbox" name="occasion[]" id="{{ $occasion }}" value="{{ $occasion }}" 
					>&nbsp;&nbsp;{{$occasion}} <br>
					@endforeach
				</div>
				@endif
				<br/>
				<div class="thumbnail">
					<img src="{{ asset('images/front_images/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
					<div class="caption">
						<h5>Payment Methods</h5>
					</div>
				</div>
			</div>