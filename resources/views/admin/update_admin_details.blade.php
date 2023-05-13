@extends('layouts.admin_layout.admin_layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Admin Details</h3>
              </div>
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
                  @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ url('/admin/update-admin-details') }}" enctype="multipart/form-data" method="post">@csrf
                <div class="card-body">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" readonly class="form-control"  value="{{ $adminDetails->email }} " id="email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="admin_type">Admin type</label>
                    <input type="text" class="form-control" readonly value = "{{ $adminDetails->type }}" id="admin_type" name="admin_type" >
                  </div>
                <div class="form-group">
                    <label for="admin_name">Admin Name</label>
                    <input type="admin_name" class="form-control" value="{{ $adminDetails->name }} " id="admin_name" name="admin_name">
                  </div>
                  <div class="form-group">
                    <label for="admin_mobile">Mobile</label>
                    <input type="text" class="form-control" value="{{ $adminDetails->mobile}}" id="admin_mobile" name="admin_mobile">
                    <span id="Mobile"></span>
                  </div>
                  <div class="form-group">
                    <label for="admin_image">Image</label>
                  
                    <input type="file" class="form-control" id="admin_image" name="admin_image">
                    <a target="_blank" href="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                    @if(!empty( Auth::guard('admin')->user()->image ))
                      <input type="hidden" name="current_admin_image" 
                        value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection