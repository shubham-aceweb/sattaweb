@extends('admin.comonpart')
@section("title", "Users list")
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
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 flex-row align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Players ( {{$user_deatil->full_name}} / {{$user_deatil->mobile}} )</h6>
                           <input type="hidden" class="form-control" id="reg_no" name="reg_no"  value="{{$user_deatil->reg_no}}" readonly />
                        </div>
                        <div class="col-lg-6 col-md-6">
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                     <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th><span class="txtwithoutsymble"><span>Sr</span></span></th>
                                <th><span class="txtwithoutsymble"><span>RefNo</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Amount</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Status</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Product</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CreatedAt</span></span></th>
                            </tr>
                        </thead>
                       
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

        var reg_no = $("#reg_no").val();
        

        $('#dataTableHover').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "desc" ]],
            "ajax":{
                     "url": "{{ url('admin/user-transaction-data') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{reg_no:reg_no, _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "refno" },
                { "data": "amount" },
                { "data": "type" },
                { "data": "source" },
                { "data": "created_at" },
               
            ]   
        });


   

         });
</script>

@endsection