@extends('admin.comonpart')
@section("title", "Refer Rewards")
@section("description", "")

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
                            <a href="{{url('/refer-reward-list')}}" class="btn btn-primary float-right"> List </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <td><span class="txtwithoutsymble"><span>type</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->type) ? $record->type : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>click_id</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->click_id) ? $record->click_id : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>join_user_reg_no</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->join_user_reg_no) ? $record->join_user_reg_no : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>reg_no</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->reg_no) ? $record->reg_no : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>first_name</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->first_name) ? $record->first_name : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>last_name</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->last_name) ? $record->last_name :''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>amount</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->amount) ? $record->amount : ''}}</span></span></td>
                            </tr>
                            <tr>
                                <td><span class="txtwithoutsymble"><span>status</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->status) ? $record->status : ''}}</span></span></td>
                            </tr>
                             <tr>
                                <td><span class="txtwithoutsymble"><span>created_at</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->created_at) ? $record->created_at : ''}}</span></span></td>
                            </tr>

                            <tr>
                                <td><span class="txtwithoutsymble"><span>updated_at</span></span></td>
                                <td><span class="txtwithoutsymble"><span>{{isset($record->updated_at) ? $record->updated_at : ''}}</span></span></td>
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

@endsection