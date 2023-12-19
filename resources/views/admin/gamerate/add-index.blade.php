@extends('admin.comonpart') 
@section("title", "Game Rate") 
@section("description", "NO") 
@section("keyword", "NO")

@section('specific-page-css')
<!-- Select2 -->
  <link href="{{asset('public/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

 <!-- //date time picker -->
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css">
 <style type="text/css">
        button.close.close-cust,
        button.close.close-cust-1, 
        button.close.close-cust-2,
        button.close.close-cust-3,
        button.close.close-cust-4,
        button.close.close-cust-5 {
            float: unset;
            margin-top: -1%;
            position: absolute;
        }
 </style>
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
                  <form method="post" action="{{url('admin/save-game-category')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                     
                    
                    <div class="form-group row">
                         <div class="col">
                            
                            <label for="name">Game Name<span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="game_name" value="{{old('game_name')}}" placeholder="Enter Game Name" required="required">
                                
                        </div>
                        <div class="col">
                            <label for="name">Game Rate<span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="game_rate" value="{{old('game_rate')}}" placeholder="Enter Game Rate" required="required">
                        </div>

                        <div class="col">
                            <label for="name">x Rate ( Number Only )<span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" class="form-control" name="xrate" value="{{old('xrate')}}" placeholder="Enter Game Name" required="required">
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

<!-- //date time picker -->
<script type="text/javascript" src="{{asset('public/Zebra_datepicker')}}/1.9.12/zebra_datepicker.min.js"></script>
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
        $('input.dateall').Zebra_DatePicker({
          format: 'Y-m-d H:i:s', view: 'days', show_clear_date: 'FALSE'
        });
   
    </script>

@endsection

