@extends('admin.comonpart')
@section("title", "Edit User") 
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
                  <form role="form" class="form-edit form" method="post" action="{{url('privilege-users-update')}}/{{$result->id}}" enctype="multipart/form-data" novalidate>
              {!! csrf_field() !!}
                <div class="card-body">

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="">First Name <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="first_name" value="{{$result->first_name}}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="">Last Name <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="last_name" value="{{$result->last_name}}" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="email">Email </label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="email" value="{{$result->email}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="mobile">Mobile </label>
                      </div>
                      <div class="col-sm-10">
                          <input id="" type="text" class="form-control " name="mobile" value="{{$result->mobile}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="">Type <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                        <select class="form-control" id="" required="" name="user_type">
                          <option value="">Please select a type</option>
                          <option value="Super Admin" @if($result->user_type == 'Super Admin') selected @endif>Super Admin</option>
                        </select>
                     
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-2 label">
                          <label for="status">Status <span class="text-danger" title="This field is required">*</span></label>
                      </div>
                      <div class="col-sm-10">
                        <select class="form-control" required="" name="status">
                          <option value="">Please select a Status</option>
                          <option value="Enable" @if($result->status == 'Enable') selected @endif>Enable</option>
                          <option value="Disable" @if($result->status == 'Disable') selected @endif>Disable</option>
                        </select>
                     
                      </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
                </div>
            </div>
        </div>


        <!--card 2-->
        @if(Auth::user()->email=='SUMIT.KAPOOR@CREDITCODE.IN' || Auth::user()->email=='AKASH.SHARMA@CREDITCODE.IN')
        <div class="col-md-12 mb-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Change Password</h3>
            </div>
            
            <form role="form" class="form-one" method="post" action="{{url('user-update-password-details')}}/{{$result->id}}" enctype="multipart/form-data" novalidate>
              {!! csrf_field() !!}
              <div class="card-body">

                <div class="form-group row">
                  <div class="col-sm-2 label">
                    <label for="product_type">Password<span class="text-danger" title="This field is required">*</span></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="password" id="" title="Password" required="" class="form-control" name="password">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-2 label">
                    <label for="product_type">Password Confirmation<span class="text-danger" title="This field is required">*</span></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="password" id="" title="Confirm Password" required="" class="form-control" name="password_confirmation">
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        @endif
        <!--card 2-->

    </div>
    
</div>

@endsection
   
@section('specific-page-script')

@endsection

