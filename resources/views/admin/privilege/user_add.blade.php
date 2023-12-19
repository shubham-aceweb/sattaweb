@extends('admin.comonpart')
@section("title", "Add User") 
@section("description", "Description put here") 
@section("keyword", "Keword put here")

@section('specific-page-css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{isset($page_title)?$page_title:$page_title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <!-- <li class="breadcrumb-item">Form</li> -->
            <li class="breadcrumb-item active" aria-current="page">{{isset($page_title)?$page_title:$page_title}}</li>
        </ol>
    </div>

    @if($errors->any())
    <div class="col-sm-12">
        <div class="form-group">
            <div class="alert alert-danger alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>    
    @endif

    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 flex-row align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Add</h6>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <a href="{{url('privilege-users-list')}}" class="btn btn-primary float-right">List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form role="form" class="form-edit form" method="post" action="{{url('privilege-users-save')}}" enctype="multipart/form-data">
                  {!! csrf_field() !!}
                <div class="card-body">

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="">First Name <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="first_name" value="{{ old('first_name') }}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="">Last Name <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="last_name" value="{{ old('last_name') }}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="email">Email <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="email" class="form-control " name="email" value="{{ old('email') }}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="mobile">Mobile </label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="mobile" value="{{ old('mobile') }}" >
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="password">Password <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="password" class="form-control " name="password" value="{{ old('password') }}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                        <label for="password-confirm" class="col-sm-2 label">Confirm Password <span class="text-danger" title="This field is required">*</span></label>

                        <div class="col-sm-10">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="status">Type <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                        <select class="form-control" id="" required="" name="user_type">
                          <option value="">Please select a Status</option>
                          <option value="Super Admin">Super Admin</option>
                        </select>
                     
                      </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection
   
@section('specific-page-script')

@endsection

