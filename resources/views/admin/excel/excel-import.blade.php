@extends('admin.comonpart')
@section("title", "Excel Import")
@section("description", "")

@section('specific-page-css')
  <!-- <link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css">
  <style type="text/css">
  #extract{height: calc(1.5em + .75rem + 7px);}
  </style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EXCEL UPLOAD</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <!-- <li class="breadcrumb-item">Tables</li> -->
            <li class="breadcrumb-item active" aria-current="page">{{isset($page_title)?$page_title:''}}</li>
        </ol>
    </div>

    <section class="content mb-4" style="display:block;"> 
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-bottom: 0;">
                   <label style="padding: 10px 0px 10px 10px;"> <strong>UPLOAD MARKET RESULT ( Market name should be same as given in all lottery list section )</strong></label>
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
                                <form id="filterform" action="{{url('admin/upload-upload-result-excel-data')}}" method="post" enctype="multipart/form-data">  
                                    @csrf
                                    <table>
                                        <tr>
                                            <td><strong>Import Excel</strong></td>
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
                                <a href="{{asset('public/formateresult.csv')}}" class="btn btn-success float-right">Download CSV Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   


</div>

@endsection

@section('specific-page-script')
<!-- <script src="{{asset('public/assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script> -->
<script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>

<script>

    $(document).ready(function () {

        $('input.dateall').Zebra_DatePicker({
            format: 'd-m-Y', view: 'days', show_clear_date: 'FALSE'
        });

    });
</script>
@endsection