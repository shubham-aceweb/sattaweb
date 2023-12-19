@extends('admin.comonpart') @section("title", "Dashboard") @section("description", "") @section('specific-page-css')
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.css')}}" />
<style type="text/css">
    .breadcrumb {
        padding: 0;
    }
    .displaynone {
        display: none;
    }
    .displayblock {
        display: inline-block;
    }
</style>
@endsection @section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-1">
        <h6 class="h5 mb-0 font-weight-bold text-gray-800">Alert : Bestsattamatka Admin Panel || Traffic User Per Hours is {{isset($trafic)?$trafic:''}} 😎</h6>

        @if((Auth::user()->user_type == 'SuperAdmin') )

        <a href="{{url('#')}}" class="btn btn-danger" style="margin-top: 20px;"> Download APK (Beta 1.0)</a>
        @endif
    </div>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>

<div class="row m-2">
    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">PLAYER (TOTAL)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{isset($user_count)?$user_count:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TOTAL LOTTERY OPEN</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{isset($lottery_open_count)?$lottery_open_count:0}}</div>
                    </div>
                    <div class="col-auto">

                        <i class="fas fa-dice fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TOTAL LOTTERY CLOSE</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{isset($lottery_close_count)?$lottery_close_count:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dice fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TOTAL LOTTERY DEACTIVE</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{isset($lottery_close_deactive)?$lottery_close_deactive:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dice fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
    <p class="h5 mb-0 text-gray-800">LOTTERY</p>
</div>

<div class="row m-2">
    
    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TOTAL LOTTERY WIN AMOUNT</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{isset($lottery_win_amount)?$lottery_win_amount:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TOTAL LOTTERY LOSS AMOUNT</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{isset($lottery_loss_amount)?$lottery_loss_amount:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

    <!-- Pending Requests Card Example -->
</div>



<div class="d-sm-flex align-items-center justify-content-between m-3">
    <p class="h5 mb-0 text-gray-800">WITHDRAWAL HISTORY</p>
</div>

<div class="row m-2">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">IN PROCESS ( {{isset($trans_process_count1) ? $trans_process_count1:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs.{{isset($trans_process_amount_sum1) ? $trans_process_amount_sum1:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">TRANSFERRED SUCCESSFUL ( {{isset($trans_success_count1) ? $trans_success_count1:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs. {{isset($trans_success_amount_sum1) ? $trans_success_amount_sum1:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">WITHDRAWAL FAILURE ( {{isset($trans_failure_count1) ? $trans_failure_count1:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs. {{isset($trans_failure_amount_sum1) ? $trans_failure_amount_sum1:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

   
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
    <p class="h5 mb-0 text-gray-800">DEPOSIT HISTORY</p>
</div>

<div class="row m-2">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">IN PROCESS ( {{isset($trans_process_count2) ? $trans_process_count2:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs.{{isset($trans_process_amount_sum2) ? $trans_process_amount_sum2:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">DEPOSITED SUCCESS ( {{isset($trans_success_count2) ? $trans_success_count2:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs. {{isset($trans_success_amount_sum2) ? $trans_success_amount_sum2:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-1">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">DEPOSIT FAILURE ( {{isset($trans_failure_count2) ? $trans_failure_count2:0}} )</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Rs. {{isset($trans_failure_amount_sum2) ? $trans_failure_amount_sum2:0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Pending Requests Card Example -->
</div>
<!--Row-->

@endsection @section('specific-page-script')
<script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>
<script type="text/javascript">
    $("input.dateall").Zebra_DatePicker({
        format: "d-m-Y",
        view: "days",
        show_clear_date: "FALSE",
    });

    //Zebra_datepicker - Zabra date picker js
    $("#filterform").find(".Zebra_DatePicker_Icon_Wrapper").css("width", "");
</script>
@endsection
