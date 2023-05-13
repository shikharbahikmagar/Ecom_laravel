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
              <li class="breadcrumb-item active">Products Attributes</li>
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
                  @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  @endif
        <form method="post" name="attributeForm" id="attributeForm" action="{{ url('admin/add-images/'.$productdata['id']) }}" 
        enctype="multipart/form-data">@csrf
        <div class="card card-default"> 
        <!-- card  -->
          <div class="card-header">
            <!-- card header -->
            <h3 class="card-title">Products Images</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- card header end -->
          <div class="card-body">
            <!-- card body -->
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                        <label for="product_name">product Name:</label>&nbsp;{{ $productdata['product_name'] }}
                      </div>
                      <div class="form-group">
                        <label for="product_code">product Code:</label>&nbsp;{{ $productdata['product_code'] }}
                      </div>
                      <div class="form-group">
                        <label for="product_color">product Color:</label>&nbsp;{{ $productdata['product_color'] }}
                      </div>
                    </div>  
                    <div class="col-md-6">
                      <div class="form-group">
                        <img style="width: 110px;" src="{{ asset('images/product_images/large/'. $productdata['main_image']) }}" alt="">
                  </div>
                </div>
          
                <div class="col-md-6">
                  <div class="form-group">
                  <div class="field_wrapper">
                    <div>
                        <input multiple="" id="images" name="images[]" name="images[]" required="" type="file" value=""  />
                    </div>
                  </div>
                  </div>
                </div>
              </div> 
            </div>      
          <div class="card-footer">
              <button class="btn btn-primary" type="submit">Add Attribute</button>
          </div>
        </div>
        </form>

        <form action="{{ url('admin/add-images/'.$productdata['id']) }}" id="editForm" name="editForm" method="post"
        enctype="multipart/form-data">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Update Product Attributes</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="categories" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($productdata['images'] as $image)
                  <input style="display: none;" type="text" name="attrId[]" id="attrId" value="{{ $image['id'] }}">
                <tr>
                  <td>{{ $image['id'] }}</td>
                  <td> <img style="width: 110px;" src="{{ asset('images/product_images/small/'.$image['image']) }}" alt="no image"></td>
                  <td>
                    @if( $image['status'] == 1)
    	                <a class="updateProductImagesStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    @else
                    <a class="updateProductImagesStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="In-Active"></i></a>
                    @endif
                    </td>    
                   <td>
                    <a style="color:red;" href="javascript:void(0)" class="confirmImageDelete" record="image" recordId="{{  $image['id'] }}">
                    <i class="fas fa-trash"></i></a>
                    
                  </td>

                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button class="btn btn-primary" type="submit">Update Attribute</button>
          </div>
          </div>
          <!-- /.card -->
        </form>
    </section>
  </div>

@endsection