
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">     
			<ul class="breadcrumb">
				<li><a href="index.html">Home</a> <span class="divider">/</span></li>
				<li class="active">THANKS</li>
			</ul>
			<h3>THANKS</h3>
			<hr class="soft"/>
			<div align="center">
                <h3>YOUR ORDER HAS BEEN PLACED SUCCESSFULLY</h3>
                <p>Yout order number is {{ Session::get('order_id') }} and grand total is NPR {{ Session::get('grand_total') }}</p>
                <p>please make a payment by clicking on a below button</p>
                <!-- Place this where you need payment button -->
                <button id="payment-button" style="background-color: #5C2D91; cursor: pointer; color: #fff; border: none; padding: 5px 10px; border-radius: 2px">Pay with Khalti</button>
                @foreach( $orderDetails['orders_products'] as $product )
                    <input type="hidden" id="product_code" value="{{ $product['product_code'] }}">
                    <input type="hidden" id="product_name" value="{{ $product['product_name'] }}">
                    <input type="hidden" id="product_id" value="{{ $product['product_id'] }}">
                    <input type="hidden" id="grand_total" value="{{ Session::get('grand_total') }}">
                @endforeach
            </div>
	</div>

@endsection

<?php
Session::forget('order_id');
Session::forget('grand_total');
Session::forget('couponAmount');
Session::forget('couponCode');
?>