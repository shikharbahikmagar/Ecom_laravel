@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">     
			<ul class="breadcrumb">
				<li><a href="index.html">Home</a> <span class="divider">/</span></li>
				<li class="active"><?php echo $categoryDetails['breadcrumbs']; ?></li>
			</ul>
			<h3>{{ $categoryDetails['categoryDetails']['category_name'] }} <small class="pull-right">{{ count($categoryProducts) }} products are available </small></h3>
			<hr class="soft"/>
			<p>
				{{ $categoryDetails['categoryDetails']['description'] }}
			</p>
			<hr class="soft"/>
			<form class="form-horizontal span6" id="sortProducts" name="sortProducts">
				<div class="control-group">
					<label class="control-label alignL">Sort By </label>
					<select name="sort" id="sort">
					<option value="">Select</option>
					<option value="latest_product" @if(isset($_GET["sort"]) && $_GET["sort"] == 
					"latest_product") selected="" @endif >Latest Product</option>
						<option value="price_low_to_high" @if(isset($_GET["sort"]) && $_GET["sort"] == 
					"price_low_to_high") selected="" @endif>Price: Low to High</option>
						<option value="price_high_to_low"
						@if(isset($_GET["sort"]) && $_GET["sort"] == 
					"price_high_to_low") selected="" @endif>Price: High to Low</option>
						<option value="product_name_a_to_z"
						@if(isset($_GET["sort"]) && $_GET["sort"] == 
					"product_name_a_to_z") selected="" @endif>Product Name: a to z</option>
						<option value="product_name_z_to_a"
						@if(isset($_GET["sort"]) && $_GET["sort"] == 
					"product_name_z_to_a") selected="" @endif>Product Name: z to a</option>
					</select>
				</div>
			</form>
			
			<div id="myTab" class="pull-right">
				<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
				<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
			</div>
			<br class="clr"/>
			<div class="tab-content">
				<div class="tab-pane" id="listView">
                    @foreach($categoryProducts as $product)
                    <div class="row">
						<div class="span2">
                        <?php $product_image_path = 'images/product_images/small/'.$product['main_image'];
								$dummy_image = 'images/product_images/dummy_image/dummy_image.png';
								?>
								@if(isset($product['main_image']))
								<img style="width: 160px; height: 175px" src="{{ asset($product_image_path) }}" alt=""/>
								@else
								<img style="width: 175px; height: 175px" src="{{ asset($dummy_image) }}" alt="">
								@endif
								<!-- @if(!empty($product['main_image']) && file_exists($product_image_path))
								<img style="width: 160px; height: 175px" src="{{ asset($product_image_path) }}" alt=""/>
								@else
									<img style="width: 175px; height: 175px" src="{{ asset($dummy_image) }}" alt="">
								@endif -->
						</div>
						<div class="span4">
							<hr class="soft"/>
							<h5>{{ $product['product_name'] }}</h5>
							<p>
							{{ $product['brand'] ['name']}}
							</p>
							<a class="btn btn-small pull-right" href="product_details.html">View Details</a>
							<br class="clr"/>
						</div>
						<div class="span3 alignR">
							<form class="form-horizontal qtyFrm">
								<h3>{{ $product['product_price'] }}</h3>
								<label class="checkbox">
									<input type="checkbox">  Adds product to compair
								</label><br/>
								
								<a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
								<a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
								
							</form>
						</div>
					</div>
					<hr class="soft"/>
                    @endforeach
				</div>
				<div class="tab-pane  active" id="blockView">
					<ul class="thumbnails">
                        @foreach($categoryProducts as $product)
						<li class="span3">
							<div class="thumbnail">
								<a href="product_details.html">
                                <?php $product_image_path = 'images/product_images/small/'.$product['main_image'];
								$dummy_image = 'images/product_images/dummy_image/dummy_image.png';
								?>
								@if(isset($product['main_image']))
								<img style="width: 160px; height: 175px" src="{{ asset($product_image_path) }}" alt=""/>
								@else
								<img style="width: 175px; height: 175px" src="{{ asset($dummy_image) }}" alt="">
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
									<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{ $product['product_price'] }}</a></h4>
								</div>
							</div>
						</li>
                        @endforeach
					</ul>
					<hr class="soft"/>
				</div>
			</div>
			<a href="compair.html" class="btn btn-large pull-right">Compare Product</a>
			<div class="pagination">
		
				
				@if(isset($_GET["sort"]) && !empty($_GET['sort']))
				{{  $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
				@else
				{{ $categoryProducts->links() }} 
				@endif
			</div>
			<br class="clr"/>
		</div>
@endsection