@extends('admin.comonpart')
@section("title", "Users list")
@section("description", "Description put here")

@section('specific-page-css')
  <link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css">
  <style type="text/css">
  #extract{height: calc(1.5em + .75rem + 7px);}
  </style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{isset($page_title)?$page_title:$page_title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <!-- <li class="breadcrumb-item">Tables</li> -->
            <li class="breadcrumb-item active" aria-current="page">{{isset($page_title)?$page_title:$page_title}}</li>
        </ol>
    </div>
      
    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 flex-row align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">List</h6>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <a href="{{url('privilege-users-add')}}" class="btn btn-primary float-right">Add</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th><span class="txtwithoutsymble"><span>sr</span></span></th>
                                <th><span class="txtwithoutsymble"><span>first_name</span></span></th>
                                <th><span class="txtwithoutsymble"><span>last_name</span></span></th>
                                <th><span class="txtwithoutsymble"><span>email</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Mobile</span></span></th>
                                <th><span class="txtwithoutsymble"><span>user_type</span></span></th>
                                <th><span class="txtwithoutsymble"><span>status</span></span></th>
                                <th><span class="txtwithoutsymble"><span>created_at</span></span></th>
                                <th><span class="txtwithoutsymble"><span>action</span></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('specific-page-script')
<script src="{{asset('public/assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>

<script>

    $(document).ready(function () {

        $('#dataTableHover').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "desc" ]],
            "ajax":{
                     "url": "{{ url('users_list_ajax') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "email" },
                { "data": "mobile" },
                { "data": "user_type" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "action" },
            ]   
        });

        $('input.dateall').Zebra_DatePicker({
            format: 'd-m-Y', view: 'years', show_clear_date: 'FALSE'
        });

    });
    </script>
@endsection