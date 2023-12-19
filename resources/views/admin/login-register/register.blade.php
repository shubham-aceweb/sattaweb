@extends('admin.comonpart') 
@section("title", "Add User") 
@section("description", "NO") 
@section("keyword", "NO")

@section('specific-page-css')

  <link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">


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
                
                <div class="card-body">
                  <form method="post" action="{{url('admin/add-dashboard-user-data')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}


                    

                     
                    
                        <div class="form-group row">

                              <div class="col">
                                    <label>Select User Type<span class="text-danger" title="This field is required">*</span></label>

                                        <select class="form-control" name="user_type" required="required">
                                            <option value="">Select One Value Only</option>
                                                <option value="Agent" {{ old('status') == 'Agent' ? 'selected' : '' }}>Agent</option>
                                       
                                        </select>
                                </div>

                      
                        
                           


                             <div class="col">
                               <label>Select Product Name<span class="text-danger" title="This field is required">*</span></label>

                               <select class="form-control" name="product_name" required="required">
                                    <option value="">Select One Value Only</option>
                                        @foreach($product_list_master as $value)
                                    <option value="{{$value->name}}"
                                            {{ old('name') == $value->name ? 'selected' : '' }}>{{$value->name}}</option>
                                        @endforeach
                               
                                </select>


                               
                               
                        </div>


                       <div class="col">
                            <label for="name">Commission <span class="text-danger" title="This field is required">*</span></label>
                            <input type="number" class="form-control" name="commission" value="{{old('commission')}}" placeholder="Enter  Commission" required="required">
                            
                            
                        </div>

                       
                         
                        
                    </div>

                    <div class="form-group row">

                      <div class="col">
                            <label for="name">Full Name <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter  Name" required="required">
                            
                            
                        </div>

                        
                        <div class="col">
                            <label for="name">Mobile<span class="text-danger" title="This field is required">*</span></label>
                            <input type="number" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="Enter Mobile" required="required">
                        </div>

                         <div class="col">
                            <label for="name">Email<span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Enter Email" required="required">
                        </div>

                        <div class="col">
                            <label for="name">Password<span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="password" value="{{old('password')}}" placeholder="Enter Password" required="required">
                        </div>
                       
                         
                        
                    </div>

                    <div class="form-group row">

                     
                      

                        <div class="col">
                               <label>Select Market Name<span class="text-danger" title="This field is required">*</span></label>
                               
                                <select name="lottery_list_master[]" class="js-example-placeholder-multiple form-control form-control"   size="1" multiple="multiple">

                                       <option value="">Select One Value Only</option>
                                       <option value="">ALL</option>
                                        @foreach($lottery_list_master as $value)
                                        <option value="{{$value->lottery_name}}" > {{$value->lottery_name}}</option>
                                        @endforeach

                                </select>
                        </div>

                          
                         
                        
                    </div>

                    <div class="form-group row">

                          <div class="col">
                             <label>Status<span class="text-danger" title="This field is required">*</span></label>
                            <select class="select2-single form-control" name="status" required="required">
                                <option value="">Select</option>
                                <option value="Enable" {{ old('status') == 'Enable' ? 'selected' : '' }}>Enable</option>
                                <option value="Disable" {{ old('status') == 'Disable' ? 'selected' : '' }}>Disable</option>
                                </select>
                          </div>
                        
                         
                        
                    </div>
                   
                
                   

                   

                    <button type="submit" class="btn btn-primary float-right">Submit</button>
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
     $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
      $(".js-example-placeholder-multiple").select2();
 </script>

@endsection

