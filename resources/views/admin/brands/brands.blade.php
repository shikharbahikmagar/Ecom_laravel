@extends('layouts.admin_layout.admin_layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Brands</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Brands</li>
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
              <h3 class="card-title">Brands</h3>
              <a href="{{ url('/admin/add-edit-brand') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display:inline-block;">
                  Add Brand</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="sections" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($brandData as $brand)
                <tr>
                  <td>{{ $brand->id }}</td>
                  <td>{{ $brand->name }}</td>
                  <td>
                    @if( $brand->status == 1)
    	                <a class="updateBrandStatus" id="brand-{{ $brand->id }}" brand_id="{{ $brand->id }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    @else
                    <a class="updateBrandStatus" id="brand-{{ $brand->id }}" brand_id="{{ $brand->id }}"
                        href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="In-Active"></i></a>
                    @endif    &nbsp;&nbsp;
                    <a href="{{ url('/admin/add-edit-brand/'.$brand->id ) }}"><i class="fas fa-edit"></i></a>
                    &nbsp;&nbsp;<a style="color:red;" href="javascript:void(0)" class="confirmBrandDelete" record="brand" recordId="{{  $brand->id }}">
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