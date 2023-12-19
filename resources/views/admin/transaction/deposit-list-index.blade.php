@extends('admin.comonpart') @section("title", "Deposit History") @section("description", "") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<style type="text/css">
    #extract {
        height: calc(1.5em + 0.75rem + 7px);
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
                <div class="card-header py-3 flex-row align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <h6 class="m-0 font-weight-bold text-primary">Deposit List</h6>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <p class="btn btn-outline-danger float-right mr-2 btn-sm">PROCESS ( {{$processcount}} )</p>
                            <p class="btn btn-outline-success float-right mr-2 btn-sm">SUCCESS ( {{$successcount}} )</p>
                            <p class="btn btn-outline-warning float-right mr-2 btn-sm">FAILURE ( {{$failuercount}} )</p>

                        </div>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>

                               
                                <th>
                                    <span class="txtwithoutsymble"><span>Sr</span></span>
                                </th>
                               
                               
                                <th>
                                    <span class="txtwithoutsymble"><span>Merchant Transaction No</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Mode</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Amount</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Status</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Source</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Created At</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Updated At</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Action</span></span>
                                </th>
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
                url: "{{ url('admin/deposit_history_list_data') }}",
                dataType: "json",
                type: "POST",
                data: { _token: "{{csrf_token()}}" },
            },

             
            columns: [
                { data: "id" },
              
                { data: "merchant_transaction_id" },
                { data: "payout_mode" },
                { data: "amount" },
                { data: "status" },
                { data: "source" },
                { data: "created_at" },
                { data: "updated_at" },
                { data: "action", orderable: false, searchable: false },
            ],
        });

    
    });
</script>
<script type="text/javascript">
   
       $('#dataTableHover tbody').on('click', '#deposit_amount_success_button', function () {
           if(confirm("Do you want added amount in user wallet?")){

               let id = $(this).attr('data-id');
               $.ajax({
                   type: "POST",
                   url:"{{url('admin/deposit_amount_success_button')}}",
                   data: { id : id, _token: '{{csrf_token()}}' },
                   success:function(data) {
                       if(data.code==1){
                           alert(data.msg);
                        
                           window.location.href = "{{url('admin/deposit_history_list')}}";
                       }else{
                           alert(data.msg);


                       }
                   }
               });

           }
       });

       $('#dataTableHover tbody').on('click', '#deposit_amount_fail_button', function () {
           if(confirm("Do you want to change status FAILURE ?")){

               let id = $(this).attr('data-id');
               $.ajax({
                   type: "POST",
                   url:"{{url('admin/deposit_amount_fail_button')}}",
                   data: { id : id, _token: '{{csrf_token()}}' },
                   success:function(data) {
                       if(data.code==1){
                           alert(data.msg);
                           $('.tdcol_'+data.regno).text('APPROVED');
                           window.location.href = "{{url('admin/deposit_history_list')}}";
                       }else{
                           alert(data.msg);


                       }
                   }
               });

           }
       });
</script>
@endsection
