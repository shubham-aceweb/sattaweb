@extends('admin.comonpart') @section("title", "Lottery Result") @section("description", "Description put here") @section("keyword", "Keword put here") @section('specific-page-css')
  <link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

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
                
                <div class="card-body">
                    <form method="post" action="{{url('admin/update-password-user')}}/{{$user_detail->id}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                     
                            

            
                         
                        <div class="form-group row">
                          

                            <div class="col">
                                <label class="col-form-label">Password <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" name="password" value="" placeholder="Enter  Password" required="required">
                            </div>

                          
                            <div class="col">
                                <label class="col-form-label">Re Enter Password <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" name="repassword" value="" placeholder="Re Enter  Password" required="required">
                            </div>
                          
                            
                        </div>

                        
                   
                        <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 

@section('specific-page-script') 

 <script src="{{asset('public/assets/vendor/select2/dist/js/select2.min.js')}}"></script>

<script type="text/javascript">
     $(".js-example-placeholder-multiple").select2();
</script>



@endsection
