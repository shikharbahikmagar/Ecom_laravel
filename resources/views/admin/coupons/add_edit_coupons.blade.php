@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupons</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
      @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success_message'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  @endif
        <form method="post" name="BannerForm" id="BannerForm" enctype="multipart/form-data"
        @if(empty($coupon['id']))
        action="{{ url('admin/add-edit-coupons') }}" 
        @else
        action="{{ url('admin/add-edit-coupons/'.$coupon['id']) }}" 
        @endif>@csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                
                <div class="form-group">
                    <label for="coupon_option">Coupon Option</label><br>
                    <span><input id="automaticCoupon" type="radio" name="coupon_option" value="automatic">&nbsp;&nbsp;Automatic</span>
                    &nbsp;&nbsp;
                    <span><input id="manualCoupon" type="radio" name="coupon_option" value="manual">&nbsp;&nbsp;Manual</span>
                </div>
                <div class="form-group" id="couponField"  style="display:none;">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter Coupon Code"
                    @if(isset($coupon['coupon_code'])) value="{{ $coupon['coupon_code'] }}" @endif>
                </div>
                <div class="form-group">
                    <label for="coupon_type">Coupon Type</label><br>
                    <span><input id="automaticCoupon" type="radio" name="coupon_type" value="Multiple Times"
                    @if(isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Multiple Times") checked="" @endif>&nbsp;&nbsp;Multiple Times</span>
                    &nbsp;&nbsp;
                    <span><input id="manualCoupon" type="radio" name="coupon_type" value="Single Time"
                    @if(isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Single Time") checked="" @endif>&nbsp;&nbsp;Single Time</span>
                </div>
                <div class="form-group">
                    <label for="amount_type">Amount Type</label><br>
                    <span><input id="automaticCoupon" type="radio" name="amount_type" value="Percentage"
                    @if(isset($coupon['amount_type']) && $coupon['amount_type'] == "Percentage") checked="" @endif>&nbsp;&nbsp;Percentage</span>
                    &nbsp;(in %)&nbsp;
                    <span><input id="manualCoupon" type="radio" name="amount_type" value="Fixed"
                    @if(isset($coupon['amount_type']) && $coupon['amount_type'] == "Fixed") checked="" @endif>&nbsp; Fixed(in npr)&nbsp;</span>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount"
                    @if(isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @endif>
                </div>
              <div class="form-group">
              <label for="categories">Select Categories</label>
                  <select name="categories[]" class="form-control select2" multiple="" required="" >
                    <option value="">Select</option>
                    @foreach($categories as $section)
                    <optgroup label="{{ $section['name'] }}"></optgroup>
                    @foreach($section['categories'] as $category)
                    <option value="{{ $category['id'] }}" @if(in_array($category['id'], $selCats)) selected="" @endif>
                      &nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                    @foreach($category['subcategories'] as $subcategory)
                    <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'], $selCats)) selected="" @endif>
                    &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                    @endforeach
                    @endforeach
                    @endforeach
                  </select>
                </div>
            <div class="form-group">
                    <label for="users">Select Users</label>
                    <select name="users[]" class="form-control select2" id="" 
                    multiple="">
                    <option value="">Select</option>
                    @foreach($users as $user)
                    <option value="{{ $user['email'] }}" @if(in_array($user['email'], $selUsers)) selected="" @endif>{{ $user['email'] }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input id="expiry_date" required="" class="form-control" type="text" name="expiry_date"
                    data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask placeholder="enter expiry date"
                    @if(isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @endif>
                </div>
                </div>
            </div>
          </div>
          <div class="card-footer">
          <button class="btn btn-primary" type="submit">{{ $sub_btn_name }}</button>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>

@endsection