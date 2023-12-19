@extends('admin.comonpart') @section("title", "Lottery Result") @section("description", "Description put here") @section("keyword", "Keword put here") @section('specific-page-css')


<link rel="stylesheet" type="text/css" href="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.css')}}" />
  <link href="{{asset('public/assets/vendor/clock-picker/clockpicker.css')}}" rel="stylesheet">
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
                    <form method="post" action="{{url('admin/search-market-report-data')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">

                                <label class="col-form-label">Lottery Date<span class="text-danger" title="This field is required">*</span></label>

                                <input type="text" placeholder="Lottery Date" name="lottery_date" class="calender form-control" id="lottery_date" value="{{$today_date}}" required="required"/>


                               
                            </div>
                           


                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                              
                               <label class="col-form-label">Select Product Name<span class="text-danger" title="This field is required">*</span></label>

                               <select class="form-control" name="product_name" required="required">

                                    <option value="">Select One Value Only</option>
                                     <option value="All">All</option>
                                        @foreach($product_list_master as $value)
                                    <option value="{{$value->name}}"
                                            {{ old('name') == $value->name ? 'selected' : '' }}>{{$value->name}}</option>
                                        @endforeach
                               
                                </select>


                               
                               
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                               
                               
                               
                            <label class="col-form-label">Select Lottery Name<span class="text-danger" title="This field is required">*</span></label>
                               <select class="form-control" name="lottery_name" required="required">
                                    <option value="">Select One Value Only</option>
                                        @foreach($lottery_list as $value)
                                    <option value="{{$value->lottery_name}}">{{$value->lottery_name}}</option>
                                        @endforeach
                               
                                </select>
                            </div>
                            
                        </div>
                       

                        
                       

                   
                        <button type="submit" class="btn btn-primary m-b-0 float-right">Generate Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection @section('specific-page-script')

<script src="{{asset('public/vendor/select2/dist/js/select2.min.js')}}"></script>
  <script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>
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
            format: "Y-m-d",
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
