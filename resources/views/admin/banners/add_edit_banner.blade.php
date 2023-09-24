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
              <li class="breadcrumb-item active">Banners</li>
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
        <form method="post" name="BannerForm" id="BannerForm" enctype="multipart/form-data"
        @if(empty($bannerData['id']))
        action="{{ url('admin/add-edit-banners') }}" 
        @else
        action="{{ url('admin/add-edit-banners/'.$bannerData['id']) }}" 
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
                    <label for="banner_image">Banner Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="banner_image" name="banner_image">
                        <label class="custom-file-label" for="banner_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="banner_image">Upload</span>
                      </div>
                    </div>
                    @if(!empty($bannerData['image']))
                   <div style="height: 100px;"> <img style="width: 60px;" src="{{ asset('images/front_images/carousel/'. $bannerData['image']) }}" alt="">
                   &nbsp;
                    <a <?php /*href="{{ url('admin/delete-banner-image/'. $bannerData['id']) }}"*/ ?> 
                    class="imageConfirmDelete" href="javascript:void(0)" record="banner-image" recordId="{{ $bannerData['id'] }}">Delete Image</a> 
                    </div>
                   @endif
                  </div>
                  <div class="form-group">
              <label for="banner_link">Banner Link</label>
                    <input type="text" class="form-control" id="banner_link" name="banner_link" placeholder="Enter banner link"
                    @if(!empty($bannerData['link']))
                    value="{{ $bannerData['link'] }}" @else value="{{ old('link') }}" @endif>
              </div>
              <div class="col-md-6">
              <div class="form-group">
              <label for="banner_title">Banner Title</label>
                    <input type="text" class="form-control" id="banner_title" name="banner_title" placeholder="Enter banner title"
                    @if(!empty($bannerData['title']))
                    value="{{ $bannerData['title'] }}" @else value="{{ old('title') }}" @endif>
                </div>
                <div class="form-group">
                    <label for="banner_alt">Banner Alt</label>
                    <input type="text" class="form-control" id="banner_alt" name="banner_alt" placeholder="Enter banner alt"
                    @if(!empty($bannerData['alt']))
                    value="{{ $bannerData['alt'] }}" @else value="{{ old('alt') }}" @endif>
                  </div>
              </div>
              <div class="col-md-6">

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