@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
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
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
    @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Orders</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="orders" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Created On</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Ordered Products</th>
                  <th>Order Amount</th>
                  <th>Order Status</th>
                  <th>Payment Method</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                <tr>
                  <td>{{ $order['id'] }}</td>
                  <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
                  <td>{{ $order['name'] }}</td>
                  <td>{{ $order['email'] }}</td>
                  <td>
                        @foreach($order['orders_products'] as $pro)
                        {{ $pro['product_code'] }} ({{ $pro['product_qty'] }}) <br>
                        @endforeach
                    </td>
                  <td>{{ $order['grand_total'] }}</td>
                  <td>{{ $order['order_status'] }}</td>
                    <td>{{ $order['payment_method'] }}</td>
                    <td>
                      <a href="{{ url('/admin/orders/'.$order['id']) }}" title="View Order Details"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                      @if($order['order_status'] == "Shipped" || $order['order_status'] == "Delivered")
                      <a href="{{ url('/admin/view-order-invoice/'.$order['id']) }}" title="View Order Invoice"><i class="fas fa-print"></i></a>
                      &nbsp;&nbsp;
                      <a href="{{ url('/admin/print-pdf-invoice/'.$order['id']) }}" title="Print Pdf Invoice"><i class="fas fa-file-pdf"></i></a>
                      @endif
                    </td>   
                </tr>
                @endforeach
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection