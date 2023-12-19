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
                            <h6 class="m-0 font-weight-bold text-primary">Players List</h6>
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
                                <th><span class="txtwithoutsymble"><span>Name</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Mobile</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Wallet</span></span></th>
                                <th><span class="txtwithoutsymble"><span>RefCode</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Product</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CreatedAt</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Action</span></span></th>
                            </tr>
                        </thead>
                       
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contractModal1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: green; color: white;">
                        <h2 class="modal-title sectionno" id="exampleModalLabel1">Credit Amount</h2>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Registration Number</label>
                            <input type="hidden" class="form-control" id="regno1" name="regno1"   readonly />
                            <label for="exampleInputEmail1">Add Wallet Amount</label>
                            <input type="number" class="form-control" id="wallet_amount1" name="wallet_amount1" placeholder="Add Wallet Amount" autocomplete="off" />
                            <label for="exampleInputEmail1">UTR/RefNo if any or Just Put  NA.</label>
                            <input type="text" class="form-control" id="utrrefno1" name="utrrefno1"   placeholder="Add UTR/Ref No or NA " autocomplete="off" />
                        </div>

                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success" id="confirm_btn1">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contractModal2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: red; color: white;">
                        <h2 class="modal-title sectionno" id="exampleModalLabel2">Debit Amount</h2>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Registration Number</label>
                            <input type="hidden" class="form-control" id="regno2" name="regno2"   readonly />
                            <label for="exampleInputEmail1">Add Wallet Amount</label>
                            <input type="number" class="form-control" id="wallet_amount2" name="wallet_amount2" placeholder="Add Wallet Amount" autocomplete="off" />
                            <label for="exampleInputEmail1">Wallet/Upi if any or Just Put  NA.</label>
                            <input type="text" class="form-control" id="utrrefno2" name="utrrefno2"   placeholder="Wallet/Upi Number if any or Just Put  NA." autocomplete="off" />


                        </div>

                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success" id="confirm_btn2">Confirm</button>
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
                     "url": "{{ url('admin/users_detail_list_data') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "full_name" },
                { "data": "mobile" },
                { "data": "wallet" },
                { "data": "refer_code" },
                { "data": "source" },
                { "data": "created_at" },
                { "data": "action" , "orderable": false, "searchable": false },
            ]   
        });


   

         });
</script>
<script type="text/javascript">
    

            $(document).on("click", ".contractModal1", function () {
                var datanum = $(this).attr("data-num");
                console.log(datanum);
                document.getElementById("regno1").value = datanum;
            
            });

            $(document).on("click", "#confirm_btn1", function () {
                var regno = $("#regno1").val();
                var wallet_amount = $("#wallet_amount1").val();
                var utrrefno = $("#utrrefno1").val();
                if (regno == "") {
                    alert("Somthing went to wrong. Please try again.");

                    return false;
                } else if (wallet_amount == "") {
                    alert("Please Enter  Amount");

                    return false;
                }else if (wallet_amount <1) {
                    alert("Amount must be grater than zero");

                    return false;
                }else if (utrrefno == "") {
                    alert("Enter UTR/RefNo if any or Just Put  Other.");

                    return false;
                }else {
                    let id = $(this).attr("data-id");
                     document.getElementById("wallet_amount1").value = "";
                     document.getElementById("utrrefno1").value = "";
                     document.getElementById("exampleModalLabel1").innerHTML = "Please wait..";
                 
                    $.ajax({
                            type: "POST",
                            url: '{{url("admin/add-money-user-wallet")}}',
                            data: { regno: regno, wallet_amount: wallet_amount,utrrefno: utrrefno, _token: "{{csrf_token()}}" },
                            success: function (data) {
                                if (data.code == 1) {
                                    alert(data.msg);
                                    
                                    window.location.href = '{{url("admin/user-profile")}}/'+regno;
                                } else {
                                    alert(data.msg);
                                    
                                }
                            },
                    });
                }

                
            });
        </script>


</script>

<script type="text/javascript">
    

            $(document).on("click", ".contractModal2", function () {
                var datanum = $(this).attr("data-num");
                console.log(datanum);
                document.getElementById("regno2").value = datanum;
            
            });

            $(document).on("click", "#confirm_btn2", function () {
                var regno = $("#regno2").val();
                var wallet_amount = $("#wallet_amount2").val();
                var utrrefno = $("#utrrefno2").val();
                if (regno == "") {
                    alert("Somthing went to wrong. Please try again.");

                    return false;
                } else if (wallet_amount == "") {
                    alert("Please Enter  Amount");

                    return false;
                }else if (wallet_amount <1) {
                    alert("Amount must be grater than zero");

                    return false;
                }else if (utrrefno == "") {
                    alert("Enter UTR/RefNo if any or Just Put  Other.");

                    return false;
                }else {
                    let id = $(this).attr("data-id");

                    document.getElementById("wallet_amount2").value = "";
                    document.getElementById("utrrefno2").value = "";
                    document.getElementById("exampleModalLabel2").innerHTML = "Please wait..";
                    $.ajax({
                        type: "POST",
                        url: '{{url("admin/redeem-money-user-wallet")}}',
                        data: { regno: regno, wallet_amount: wallet_amount,utrrefno: utrrefno, _token: "{{csrf_token()}}" },
                        success: function (data) {
                            if (data.code == 1) {
                                alert(data.msg);
                                window.location.href = '{{url("admin/user-profile")}}/'+regno;
                            } else {
                                alert(data.msg);
                            }
                        },
                    });
                }

                
            });
        </script>


</script>
@endsection