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

       <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-bottom: 0;">
                    <div class="card-header">
                        @if(isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    {{$error}}
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6">                                  
                                <form action="{{url('upload_data_by_excel')}}" method="post" enctype="multipart/form-data">  
                                    @csrf
                                    <table>
                                        <tr>
                                            <td><strong>Upoad Data From Excel </strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" if="file" name="import_file" class="form-control" required="required"/>
                                                <p><storng>Note: </storng> Upload only csv file.</p>
                                            </td>
                                            <td style="vertical-align:text-bottom">
                                                <!-- <label> &nbsp;</label> -->
                                                <input type="submit" class="btn btn-success" name="importbtn" value="Import Excel">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{url('/public/formateresult.csv')}}" class="btn btn-success float-right m-4" >Download CSV Formate</a> 
                            </div>
                        </div>
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
