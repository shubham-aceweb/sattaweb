@extends('admin.comonpart') 
@section("title", "Add Lottery Name") 
@section("description", "NO") 
@section("keyword", "NO")

@section('specific-page-css')
<!-- Select2 -->
  <link href="{{asset('public/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.css')}}" />
 <!-- ClockPicker -->
  <link href="{{asset('public/assets/vendor/clock-picker/clockpicker.css')}}" rel="stylesheet">

 
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
                <ul style="list-style: none; padding: 0;">
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
                  <form method="post" action="{{url('admin/save_deposit_acc_data')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                     
                    
                    <div class="form-group row">

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
                             <label>Ac/Type<span class="text-danger" title="This field is required">*</span></label>
                            <select class="select2-single form-control" name="type" required="required">
                                <option value="">Select</option>
                                <option value="UPI" {{ old('type') == 'UPI' ? 'selected' : '' }}>UPI</option>
                                <option value="Wallet" {{ old('type') == 'Wallet' ? 'selected' : '' }}>Wallet</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="name">UPI/Wallet/Bank Name <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" placeholder="Bank Name" name="bank_name" class="form-control" id="bank_name" value="" />
                            
                            
                        </div>

                        
                        
                        <div class="col">
                            <label for="name">UPI/Wallet Number <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" placeholder="Enter UPI/Wallet Number" name="upi_or_account" class="form-control" id="upi_or_account" value="" />
                            
                            
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
<!-- Select2 -->
  <script src="{{asset('public/vendor/select2/dist/js/select2.min.js')}}"></script>
  <script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>
   <!-- ClockPicker -->
  <script src="{{asset('public/assets/vendor/clock-picker/clockpicker.js')}}"></script>
    <script>

        //show image name in file field 
        $('.customFile').on('change', function(){ 
            files = $(this)[0].files; name = ''; 
            for(var i = 0; i < files.length; i++){ 
                name += files[i].name + (i != files.length-1 ? ", " : ""); 
            } 
            $(".custom-file-label").html(name); 
        });


        //date time picker
         $("input.calender").Zebra_DatePicker({
            format: "d-m-Y",
            view: "days",
            show_clear_date: "FALSE",
        });
   
   $('#clockPicker1').clockpicker({
        donetext: 'Done',
        autoclose: true,
        twelvehour: true
      });

 $('#clockPicker2').clockpicker({
        donetext: 'Done',
        autoclose: true,
        twelvehour: true
      });





    </script>

@endsection

