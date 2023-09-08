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
              <li class="breadcrumb-item active">Categories</li>
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
                  <?php Session::forget('success_message'); ?>
                  @endif
        <form method="post" name="ShippingChargeForm" id="ShippingChargeForm" enctype="multipart/form-data"
        action="{{ url('admin/edit_shipping_charges/'.$shippingDetails['id']) }}" >@csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit Shipping Charge</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                    <label for="country_name">Country Name</label>
                    <input readonly="" type="text" class="form-control" id="country_name" name="country_name" value="{{ $shippingDetails['country'] }}">
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                    <label for="shipping_charge">Shipping Charges</label>
                    <input type="text" class="form-control" id="shipping_charge" name="shipping_charge" placeholder="Enter Shipping Charge"
                    @if(!empty($shippingDetails['shipping_charges']))
                    value="{{ $shippingDetails['shipping_charges'] }}" @else value="{{ old('shipping_charge') }}" @endif>
                  </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
          <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>

@endsection