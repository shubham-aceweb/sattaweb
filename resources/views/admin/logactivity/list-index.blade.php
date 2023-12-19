@extends('admin.comonpart')
@section("title", "Log Activity")
@section("description", "")

@section('specific-page-css')
  <link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
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
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th><span class="txtwithoutsymble"><span>sr</span></span></th>
                                <th><span class="txtwithoutsymble"><span>description</span></span></th>
                                <th><span class="txtwithoutsymble"><span>url</span></span></th>
                                <th><span class="txtwithoutsymble"><span>method</span></span></th>
                                <th><span class="txtwithoutsymble"><span>ip</span></span></th>
                                <th><span class="txtwithoutsymble"><span>agent</span></span></th>
                                <th><span class="txtwithoutsymble"><span>user_id</span></span></th>
                                <th><span class="txtwithoutsymble"><span>email</span></span></th>
                                <th><span class="txtwithoutsymble"><span>user</span></span></th>
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

<script>

    $(document).ready(function () {

        $('#dataTableHover').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "desc" ]],
            "ajax":{
                     "url": "{{ url('log_activities_list_ajax') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "description" },
                { "data": "url" },
                { "data": "method" },
                { "data": "ip" },
                { "data": "agent" },
                { "data": "user_id" },
                { "data": "email" },
                { "data": "user" },
                { "data": "created_at" },
                { "data": "action" , "orderable": false, "searchable": false },
            ]   
        });

    });
    </script>
@endsection