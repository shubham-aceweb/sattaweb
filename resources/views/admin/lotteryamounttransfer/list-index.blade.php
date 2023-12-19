@extends('admin.comonpart') @section("title", "Lottery Name List") @section("description", "") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<style type="text/css">
    
    .blink_me {
           border: 2px dashed #bf9a3e;
    padding: 0px 0px 0px 0px;
    text-align: center;
    background: #000000;
    max-width: 42px;
    border-radius: 5px;
    color: #ffffff;
    animation: blinker 1s linear infinite;
        
        }

    .alert {
        border: 1px dashed #000000;
        padding: 5px;
        text-align: left;
        background: #ffffff;
        border-radius: 3px;
        color: #000000 !important;
       
        
        }

    @keyframes  blinker {
      50% {
        opacity: 0;
      }
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
                        <div class="col-lg-9 col-md-9">
                           
                            <p class="alert">{{$pending_result_market}}</p>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            
                            <button class="btn btn-danger float-right mr-2 btn-sm" id="bulk_payout_btn">Transfer ( Rs. {{$result_win_amount}}) to Wallet</button> 
                            
                      <!--      <button class="btn btn-danger float-right mr-2 btn-sm" >Win Ammount Rs. {{$result_win_amount}}</button> 
 -->
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>

                            

                                <th><span class="txtwithoutsymble"><span>Sr.</span></span></th>

                                <th><span class="txtwithoutsymble"><span>LotteryDate</span></span></th>
                                <th><span class="txtwithoutsymble"><span>LotteryName</span></span></th>
                                <th><span class="txtwithoutsymble"><span>GameType</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CategoryType</span></span></th>
                                <th><span class="txtwithoutsymble"><span>UserPlay</span></span></th>
                                <th><span class="txtwithoutsymble"><span>LotteryNo.</span></span></th>
                                <th><span class="txtwithoutsymble"><span>ResultNo.</span></span></th>
                                <th><span class="txtwithoutsymble"><span>LotteryAmount</span></span></th>
                               <!--  <th><span class="txtwithoutsymble"><span>WonAmount</span></span></th> -->
                                <th><span class="txtwithoutsymble"><span>Status</span></span></th>
                                <th><span class="txtwithoutsymble"><span>isTransfer</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Action</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Product</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CreatedAt</span></span></th>
                                
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
                url: "{{ url('admin/user-lottery-result-amount-data') }}",
                dataType: "json",
                type: "POST",
                data: { _token: "{{csrf_token()}}" },
            },
            
            columns: [
                { data: "id" },
                { data: "lottery_date" },
                { data: "lottery_name" },
                { data: "lottery_game_type" },
                { data: "lottery_category_type" },
                { data: "lottery_numbers_user"},
                { data: "lottery_numbers" },
                { data: "result_number" },
                { data: "lottery_amount" },
               /* { data: "won_lottery_amount" },*/
                { data: "status" },
                { data: "isTransfer" },
                { data: "action" },
                { data: "source" },
                { data: "created_at" },
                
                
            ],
        });



        
        
    });
</script>

<script type="text/javascript">
    $("#bulk_payout_btn").click(function(event){
            event.preventDefault();
            $('#bulk_payout_btn').prop("disabled", true);
            if(confirm("Do you want transfer in player wallet?")){
                $.ajax({
                    type: "GET",
                    url:"{{url('admin/user-lottery-result-amount-transfer')}}", 
                    success:function(data) {
                        if(data.code==1){
                            alert(data.msg);
                            $('#bulk_payout_btn').prop("disabled", false);
                            window.location.href = "{{url('admin/user-lottery-result-amount')}}";
                        }else{
                            alert(data.msg);
                            $('#bulk_payout_btn').prop("disabled", false);
                            //window.location.href = '{{url('trans-history-list')}}';
                        }
                    }
                });
            }else{
                $('#bulk_payout_btn').prop("disabled", false);
            }
        });
</script>

@endsection
