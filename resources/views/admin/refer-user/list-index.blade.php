@extends('admin.comonpart')
@section("title", "Refer User")
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

<!--Excel export-->
<section class="content mb-4" style="display:none;">    
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <form id="filterform" action="#" method="post" style="padding: 10px 0px 10px 10px;">  
      @csrf
          <table>
              <tr>
                  <td><label> &nbsp;</label>
                      <select id="other_option" class="form-control" name="other_option" style="">
                          <option value="">Select Option</option>
                          <option value="today">Today</option>
                          <option value="select_date">Select Date</option>
                          <option value="all_date">All Date</option>
                          <option value="start_end_date">Start-End Date</option>
                      </select>
                  </td>
                  <td id="startdate">
                      <label>Start Date</label>
                      <input type="text" name="start_date" class="dateall form-control" id="start_date">
                  </td>
                  <td id="enddate">
                       <label>End Date</label>
                      <input type="text" name="end_date" class="dateall form-control" id="end_date">
                  </td>
                  <td id="SelectedDatetable">
                       <label>Select Date</label>
                        <input type="text" name="SelectedDate" class="dateall form-control" id="SelectedDate" style="width:100%">
                  </td>
                  <td style="vertical-align: bottom;"><label> &nbsp;</label>
                      <input type="submit" class="btn btn-success" name="extract" id="extract" value="Export to Excel" style="">
                  </td>
              </tr>
          </table>
      </form>
    </div>
  </div>
</div>
</section>
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
                        <thead class="thead-light">
                            <tr>
                                <th><span class="txtwithoutsymble"><span>sr</span></span></th>
                                <th><span class="txtwithoutsymble"><span>reg_no</span></span></th>
                                <th><span class="txtwithoutsymble"><span>first_name</span></span></th>
                                <th><span class="txtwithoutsymble"><span>last_name</span></span></th>
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
                     "url": "{{ url('refer_user_list_ajax') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "reg_no" },
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "status", },
                { "data": "created_at" },
                { "data": "action", "orderable": false, "searchable": false },
            ]   
        });

        $('input.dateall').Zebra_DatePicker({
            format: 'd-m-Y', view: 'days', show_clear_date: 'FALSE'
        });

    });
    </script>
@endsection