@extends('admin.comonpart') @section("title", "Edit Notification") @section("description", "Description put here") @section("keyword", "Keword put here") @section('specific-page-css')
<!-- Select2 -->
<!-- <link href="{{asset('public/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"> -->
<!-- summernote -->
<!-- <link rel="stylesheet" href="{{asset('public/vendor/summernote/summernote-bs4.css')}}"> -->
<!-- //date time picker -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css"> -->

<link rel="stylesheet" type="text/css" href="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.css')}}" />

@endsection @section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$page_title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <!-- <li class="breadcrumb-item">Form</li> -->
            <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
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
                    
                </div>
                <div class="card-body">
                    <form method="post" action="{{url('admin/edit-dashboard-user-support-data')}}/{{$support_detail->id}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group row">
                            <div class="col-4">
                                <label class="col-form-label">Type  <span class="text-danger" title="This field is required">*</span></label>
                               
                                <input type="text" class="form-control" name="type" value="{{$support_detail->type}}" required="required" readonly />
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">Mobile<span class="text-danger" title="This field is required">*</span></label>
                                <input type="Number" class="form-control" name="mobile" value="{{$support_detail->mobile}}" required="required" />
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">Status <span class="text-danger" title="This field is required">*</span></label>
                                <select name="status" class="form-control">
                                    <option value="">Select from list</option>
                                    <option value="Enable" {{ $support_detail->status == 'Enable' ? 'selected' : '' }}>Enable</option>
                                    <option value="Disable" {{ $support_detail->status == 'Disable' ? 'selected' : '' }}>Disable</option> 
                                </select>
                            </div>
                             
                        </div>

                        

                   
                        <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('specific-page-script') @endsection
