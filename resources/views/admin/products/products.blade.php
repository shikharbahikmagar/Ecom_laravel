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
              <li class="breadcrumb-item active">Products</li>
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
              <h3 class="card-title">Products</h3>
              <a href="{{ url('/admin/add-edit-product') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display:inline-block;">
                  Add Product</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="categories" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Product</th>
                  <th>Product Image</th>
                  <th>Section</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
  
                <tr>
                  <td>{{ $product->id }}</td>
                  <td>{{ $product->product_name }}</td>
                  <td>
                    <?php $product_image_path = 'images/product_images/small/'.$product->main_image; ?>
                    @if(!empty($product->main_image) && file_exists($product_image_path))
                      <img style="width: 100px;" src="{{ asset('images/product_images/small/'.$product->main_image) }}" alt="">
                      @else
                      <img style="width: 100px;"   src="{{ asset('images/product_images/dummy_image/dummy_image.png') }}" alt="">
                      @endif
                  </td>
                  <td>{{ $product->section->name }}</td>
                  <td>{{ $product->category->category_name }}</td>
                  <td>
                    @if( $product->status == 1)
    	                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    @else
                    <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="In-Active"></i></a>
                    @endif    
                  </td>
                  <td>
                  <a title="Add/Edit Atribute" href="{{ url('/admin/add-product-attributes/'.$product->id ) }}"><i class="fas fa-plus"></i></a>  &nbsp;&nbsp;
                  <a title="Add/Edit Atribute" href="{{ url('/admin/add-images/'.$product->id ) }}"><i class="fas fa-plus-circle"></i></a>  &nbsp;&nbsp;
                    <a title="Edit Product" href="{{ url('/admin/add-edit-product/'.$product->id ) }}"><i class="fas fa-edit"></i></a>
                    &nbsp;&nbsp;<a title="Delete Product" style="color:red;" href="javascript:void(0)" class="confirmDelete" record="product" recordId="{{  $product->id }}">
                    <i class="fas fa-trash"></i></a>
                    
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