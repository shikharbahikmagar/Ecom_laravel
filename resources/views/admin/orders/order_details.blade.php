@extends('layouts.admin_layout.admin_layout')
@section('content')
<?php use App\Product; ?> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            @if(Session::has('success_message'))
            <div class="col-sm-12">
                <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                </div>
                {{ Session::forget('success_message') }}
            @endif
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
        
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Order Details</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Order Date</td>
                    <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                </tr>
                <tr>
                    <td>Order Status</td>
                    <td>{{ $orderDetails['order_status'] }}</td>
                </tr>
                @if(!empty($orderDetails['courier_name']))
                <tr>
                    <td>Courier_name</td>
                    <td>{{ $orderDetails['courier_name'] }}</td>
                </tr>
                @endif
                @if(!empty($orderDetails['tracking_number']))
                <tr>
                    <td>Tracking Number</td>
                    <td>{{ $orderDetails['tracking_number'] }}</td>
                </tr>
                @endif
                <tr>
                    <td>Order Total</td>
                    <td>{{ $orderDetails['grand_total'] }}</td>
                </tr>
                <tr>
                    <td>Shipping Charges</td>
                    <td>{{ $orderDetails['shipping_charges'] }}</td>
                </tr>
                <tr>
                    <td>Coupon Code</td>
                    <td>{{ $orderDetails['coupon_code'] }}</td>
                </tr>
                <tr>
                    <td>Coupon Amount</td>
                    <td>{{ $orderDetails['coupon_amount'] }}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $orderDetails['payment_method'] }}</td>
                </tr>
                </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Delivery Address</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $orderDetails['address'] }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $orderDetails['city'] }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $orderDetails['state'] }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $orderDetails['country'] }}</td>
                    </tr>
                    <tr>
                        <td>Pincode</td>
                        <td>{{ $orderDetails['pincode'] }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $orderDetails['mobile'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Customer Details</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $orderDetails['email'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Billing Address</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $orderDetails['email'] }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $orderDetails['city'] }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $orderDetails['state'] }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $orderDetails['country'] }}</td>
                    </tr>
                    <tr>
                        <td>Pincode</td>
                        <td>{{ $orderDetails['pincode'] }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $orderDetails['mobile'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Update Order Status</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>
                          <form action="{{ url('/admin/update-order-status') }}" method="post">@csrf 
                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                            <select name="order_status" id="order_status" required>
                                <option value="">Select Status</option>
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status'])
                                && $orderDetails['order_status'] ==  $status['name'] ) selected="" @endif >{{ $status['name'] }}</option>
                                @endforeach
                            </select>&nbsp;&nbsp;
                            <input type="text" style="width: 120px" name="courier_name" @if(empty($orderDetails['courier_name'])) 
                            id="courier_name" @endif value="{{ $orderDetails['courier_name'] }}" placeholder="courier name">
                            <input type="text" style="width: 120px" name="tracking_number"@if(empty($orderDetails['tracking_number'])) 
                             id="tracking_number" @endif value="{{ $orderDetails['tracking_number'] }}" placeholder="tracking number">
                            <button type="submit">Update</button>
                          </form>  
                        </td>
                    </tr>
                    <tr>
                      <td>
                      @foreach($orderLog as $log)
                      <strong> {{ $log['order_status'] }} :</strong><br> 
                      {{ date('F j, y, g:i a', strtotime($log['created_at'])) }}
                      <hr> 
                      @endforeach       
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Order Products</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($orderDetails['orders_products'] as $product)
                    <tr>
                        <td>
                            <?php $product_image = Product::getProductImage($product['product_id']) ?>
                            <a target="_blank" href="{{ url('/product/'.$product['product_id']) }}"><img style="width: 80px;" src="{{ asset('images/product_images/small/'.$product_image) }}" 
                            alt="{{ $product_image }}"></a>
                        </td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection