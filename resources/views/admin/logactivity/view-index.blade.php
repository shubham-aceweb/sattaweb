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

<!--Excel export-->

<!-- /.excel export-->
   
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
                            <!-- <a href="{{url('/')}}" class="btn btn-primary float-right">Add</a> -->
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <tbody>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>description</span></span></td>
                                <td>{{isset($record->description)?$record->description:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>url</span></span></td>
                                <td>{{isset($record->url)?$record->url:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>method</span></span></td>
                                <td>{{isset($record->method)?$record->method:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>ip</span></span></td>
                                <td>{{isset($record->ip)?$record->ip:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>agent</span></span></td>
                                <td>{{isset($record->agent)?$record->agent:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>user_id</span></span></td>
                                <td>{{isset($record->user_id)?$record->user_id:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>email</span></span></td>
                                <td>{{isset($record->email)?$record->email:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>user</span></span></td>
                                <td>{{isset($record->user)?$record->user:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>created_at</span></span></td>
                                <td>{{isset($record->created_at)?$record->created_at:''}}</td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>updated_at</span></span></td>
                                <td>{{isset($record->updated_at)?$record->updated_at:''}}</td>
                            </tr>
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

</script>
@endsection