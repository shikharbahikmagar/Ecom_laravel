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
              <li class="breadcrumb-item active">Products</li>
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
                <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php Session::forget('success_message') ?>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?php Session::forget('error_message') ?>
        @endif
        <form method="post" name="ProductForm" id="ProductForm" enctype="multipart/form-data"
        @if(empty($productdata['id']))
        action="{{ url('admin/add-edit-product') }}" 
        @else
        action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" 
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
              <div class="col-md-6">
              <div class="form-group">
                  <label>Select Category</label>
                  <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($categories as $section)
                    <optgroup label="{{ $section['name'] }}"></optgroup>
                    @foreach($section['categories'] as $category)
                    <option value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id']==@old('category_id')) selected=""
                   @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $category['id']) selected=""    @endif>
                      &nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                    @foreach($category['subcategories'] as $subcategory)
                    <option value="{{ $subcategory['id'] }}" @if(!empty(@old('category_id')) && $subcategory['id'] == @old('category_id'))
                    selected="" @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $subcategory['id'])
                    selected="" @endif>
                    &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                    @endforeach
                    @endforeach
                    @endforeach
                  </select>
                </div>
              <div class="form-group">
                    <label for="product_name">product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name"
                    @if(!empty($productdata['product_name']))
                    value="{{ $productdata['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                    <label for="product_code">product Code</label>
                    <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter product name"
                    @if(!empty($productdata['product_code']))
                    value="{{ $productdata['product_code'] }}" @else value="{{ old('product_code') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_color">product Color</label>
                    <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter product name"
                    @if(!empty($productdata['product_color']))
                    value="{{ $productdata['product_color'] }}" @else value="{{ old('product_color') }}" @endif>
                  </div>
                </div>  
                <div class="col-md-6">
              <div class="form-group">
                    <label for="product_price">product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter product name"
                    @if(!empty($productdata['product_price']))
                    value="{{ $productdata['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_discount">product Discount</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount" placeholder="Enter product name"
                    @if(!empty($productdata['product_discount']))
                    value="{{ $productdata['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                  </div>
                </div>  
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                    <input type="text" class="form-control" id="product_weight" name="product_weight" placeholder="Enter product discount"
                    @if(!empty($productdata['product_weight']))
                    value="{{ $productdata['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="main_image">Product Main Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="main_image" name="main_image">
                        <label class="custom-file-label" for="main_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="main_image">Upload</span>
                      </div>
                    </div><i>Recommended size (width: 1040px, height: 1200px)</i>
                    @if(!empty($productdata['main_image']))
                   <div style="height: 100px;"> <img style="width: 60px;" src="{{ asset('images/product_images/large/'. $productdata['main_image']) }}" alt="">
                    &nbsp;
                    <a <?php /*href="{{ url('admin/delete-category-image/'. $categorydata['id']) }}"*/ ?> 
                    class="imageConfirmDelete" href="javascript:void(0)" record="product-image" recordId="{{ $productdata['id'] }}"
                    style="color:red;">Delete Image</a> 
                    </div>
                   @endif
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                    <label for="wash_care">Wash Care</label>
                    <textarea class="form-control" name="wash_care" id="wash_care" rows="3" placeholder="Enter ...">@if(!empty($productdata['wash_care'])){{ $productdata['wash_care'] }} @else{{ old('wash_care') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea class="form-control" name="meta_description" id="meta_description" rows="3" placeholder="Enter ...">@if(!empty($productdata['meta_description'])){{ $productdata['meta_description'] }} @else{{ old('meta_description') }} @endif</textarea>
                  </div>
                
              </div>
              <div class="col-md-6">
              <div class="form-group">
                    <label for="product_video">Product Video</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_video" name="product_video">
                        <label class="custom-file-label" for="product_video">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="product_video">Upload</span>
                      </div>
                    </div>
                    @if(!empty($productdata['product_video']))
                   <div>
                    <a href="{{ url('videos/product_videos/'.$productdata['product_video']) }}" download>Download</a>
                    &nbsp;|&nbsp;
                    <a class="videoConfirmDelete" href="javascript:void(0)" record="product-video" recordId="{{ $productdata['id'] }}" 
                    style="color:red;">Delete Video</a> 
                    </div>
                   @endif            
                  </div>
                  <div class="form-group">
                  <label for="fabric">Select Fabric</label>
                  <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">            
                    <option value="">Select</option>
                    @foreach($fabricArray as $fabric)
                    <option value="{{ $fabric }}" 
                  @if(!empty($productdata['fabric']) && $productdata['fabric'] == $fabric) selected="" @endif>{{ $fabric }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="brand_id">Select Brand</label>
                  <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">            
                    <option value="">Select</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand['id'] }}" 
                  @if(!empty($productdata['brand_id']) && $productdata['brand_id'] == $brand['id']) selected="" @endif>{{ $brand['name'] }}</option>
                    @endforeach
                  </select>
                </div>

              </div>
      
            <div class="col-md-6">      
                <div class="form-group">
                  <label for="fit">Select Fit</label>
                  <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($fitArray as $fit)
                    <option      @if(!empty($productdata['fit']) && $productdata['fit'] == $fit) selected="" @endif value="{{ $fit }}">{{ $fit }}</option>
                    @endforeach
                  </select>
                </div>
          </div>
            <div class="col-md-6">    
            <div class="form-group">
                  <label for="pattern">Select Pattern</label>
                  <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($patternArray as $pattern)
                    <option      @if(!empty($productdata['pattern']) && $productdata['pattern'] == $pattern) selected="" @endif value="{{ $pattern }}">{{ $pattern }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                  <label for="occasion">Select Occasion</label>
                  <select name="occasion" id="occasion" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($occasionArray as $occasion)
                    <option      @if(!empty($productdata['occasion']) && $productdata['occasion'] == $occasion) selected="" @endif value="{{ $occasion }}">{{ $occasion }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <textarea class="form-control" name="meta_title" id="meta_title" rows="3" placeholder="Enter ...">@if(!empty($productdata['meta_title'])){{ $productdata['meta_title'] }} @else{{ old('meta_title') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3" placeholder="Enter ...">@if(!empty($productdata['meta_keywords'])){{ $productdata['meta_keywords'] }} @else{{ old('meta_keywords') }} @endif</textarea>
                  </div>

  
                
              </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label for="sleeve">Select Sleeve</label>
                  <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($sleeveArray as $sleeve)
                    <option      @if(!empty($productdata['sleeve']) && $productdata['sleeve'] == $sleeve) selected="" @endif value="{{ $sleeve }}">{{ $sleeve }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="description">Description </label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter ...">@if(!empty($productdata['description'])){{ $productdata['description'] }} @else{{ old('description') }} @endif</textarea>
                  </div>    
              </div>
              <div class="col-md-6">
              <div class="form-group">
                    <label for="is_featured">Is Featured</label>
                    <input type="checkbox" @if(!empty($productdata['is_featured']) && $productdata['is_featured'] == "Yes") checked="" @endif 
                    value="Yes" id="is_featured" name="is_featured">
                  </div>
              </div>
          </div>
        </div>
          <div class="card-footer">
          <button class="btn btn-primary" type="submit">{{ $submit }}</button>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>

@endsection