@extends('admin.comonpart') @section("title", "User List") @section("description", "") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<style type="text/css">
    #extract {
        height: calc(1.5em + 0.75rem + 7px);
    }


.tooltip {
  position: relative;
  display: inline-block;
  opacity: 1!important;
  color: red;
  padding-left: 5px;
  padding-right: 5px;

  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 320px;
  background-color: black;
  color: #000000;
  background-color: #ffffff;
  border: 1px dotted black;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
    

</style>

@endsection @section('content')

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
                 
                 
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th><span class="txtwithoutsymble"><span>Sr.</span></span></th>
                                <th><span class="txtwithoutsymble"><span>UserType</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Name</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Mobile</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Email</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Market</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Product</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Commission</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Status</span></span></th>
                                <th><span class="txtwithoutsymble"><span>UpdatedAt</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Action</span></span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('specific-page-script')
<script src="{{asset('public/assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>


<script>
    $(document).ready(function () {
        $("#dataTableHover").DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: {
                url: "{{ url('admin/dashboard-user-list-data') }}",
                dataType: "json",
                type: "POST",
                data: { _token: "{{csrf_token()}}" },
            },
            columns: [
                { data: "id" },
                { data: "user_type" },
                { data: "name" },
                { data: "mobile" },
                { data: "email" },
                { data: "market" },
                { data: "product" },
                { data: "commission" },
                { data: "status" },
                { data: "updated_at" },
                { data: "action", orderable: false, searchable: false },
            ],
        });



        
        
    });
</script>


@endsection
