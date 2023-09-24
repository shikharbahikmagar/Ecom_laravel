
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
			@if(Session::has('success_message'))
						<div class="alert alert-success" role="alert">
					{{ Session::get('success_message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					@endif
					@if(Session::has('error_message'))
						<div class="alert alert-danger" role="alert">
					{{ Session::get('error_message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					@endif
					@if(!isset($_REQUEST['search']))
					<hr class="soft"/>
					<form class="form-horizontal span6" id="sortProducts" name="sortProducts">
						<input type="hidden" name="url" id="url" value="{{ $url }}">
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
					@endif
			<br class="clr"/>
			<div class="tab-content filter_products">
				@include('front.products.ajax_products_listings')
			</div>
			<!-- <a href="compair.html" class="btn btn-large pull-right">Compare Product</a> -->
			@if(!isset($_REQUEST['search']))
			<div class="pagination">
				@if(isset($_GET["sort"]) && !empty($_GET['sort']))
				{{  $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
				@else
				{{ $categoryProducts->links() }} 
				@endif
			</div>
			@endif
			<br class="clr"/>
		</div>
@endsection