@extends('admin.comonpart') @section("title", "User Details") @section("description", "") @section("keyword", "") @section('specific-page-css')
<!-- Select2 -->
<link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- //date time picker -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css"> -->
<style type="text/css">
    /*datatable button excel css*/
    div.dt-buttons {
        position: absolute;
        top: -10px;
        right: 0;
    }
    /*datatable button excel css end*/
    button.close.close-cust,
    button.close.close-cust-1,
    button.close.close-cust-2,
    button.close.close-cust-3,
    button.close.close-cust-4,
    button.close.close-cust-5 {
        float: unset;
        margin-top: -1%;
        position: absolute;
    }
    .imageInTab {
        max-height: 300px;
        margin: auto;
        display: block;
    }
    .defaulcursor {
        cursor: default;
    }
    .custom-radio {
        display: inline-block;
    }
</style>
<style type="text/css">
    .member-card .social-links {
        margin-top: 10px;
    }

    .member-card {
        text-align: center;
    }
    .header {
        background: linear-gradient(45deg, #49cdd0, #00bcd4) !important;
        color: #fff !important;
    }

    .member-card .header {
        min-height: 93px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .member-card .member-img {
        position: relative;
        /*margin-top: -80px*/
    }

    .member-card .member-img img {
        width: 82px;
        border: 3px solid #fff;
        box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.3);
        margin-top: 5px;
    }

    .member-card .social-links li a {
        padding: 5px 10px;
    }

    .custom-icon {
        background-color: #fff;
        border-radius: 10%;
        text-align: center;
        padding: 11px;
        font-size: 18px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        -webkit-box-shadow: 0 8px 15px rgb(62 57 107 / 20%);
        box-shadow: 0 8px 15px rgb(62 57 107 / 20%);
    }

    #replayModal .image-block img {
        max-height: 268px;
        margin: auto;
        display: block;
    }

    #modalHtmlSection .form-check {
        width: 20%;
        float: left;
    }
    #modalHtmlSection .form-control {
        width: 10%;
    }
    #modalHtmlSection label {
        padding: 6px 4px;
    }

    .breadcrumb {
        padding: 0;
    }

    /*#modalimg1{max-height:40vh;}*/
</style>

<style type="text/css">
    @media (min-width: 42em) {
        grid-template-columns: repeat(3, 1fr);
    }

    .card:hover {
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.15);
    }

    .radio {
        font-size: inherit;
        margin: 0;
        position: absolute;
        right: calc(1em + 2px);
        top: calc(1em + 2px);
    }

    @supports (-webkit-appearance: none) or (-moz-appearance: none) {
        .radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            background: #fff;
            border: 2px solid #e2ebf6;
            border-radius: 50%;
            cursor: pointer;
            height: 1.5em;
            outline: none;
            transition: background 0.2s ease-out, border-color 0.2s ease-out;
            width: 1.5em;
        }
        .radio::after {
            border: 2px solid #fff;
            border-top: 0;
            border-left: 0;
            content: "";
            display: block;
            height: 0.75rem;
            left: 25%;
            position: absolute;
            top: 50%;
            transform: rotate(45deg) translate(-50%, -50%);
            width: 0.375rem;
        }

        .radio:checked {
            background: #558309;
            border-color: #558309;
        }

        .card:hover .radio {
            border-color: #c4d1e1;
        }

        .card:hover .radio:checked {
            border-color: #558309;
        }
    }
    .plan-details {
        border: 2px solid #e2ebf6;
        border-radius: 0.5em;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        padding: 1em;
        transition: border-color 0.2s ease-out;
    }
    .card:hover .plan-details {
        border-color: #c4d1e1;
    }
    .radio:checked ~ .plan-details {
        border-color: #558309;
    }
    .radio:focus ~ .plan-details {
        box-shadow: 0 0 0 2px #c4d1e1;
    }
    .radio:disabled ~ .plan-details {
        color: #c4d1e1;
        cursor: default;
    }
    .card:hover .radio:disabled ~ .plan-details {
        border-color: #e2ebf6;
        box-shadow: none;
    }
    .card:hover .radio:disabled {
        border-color: #e2ebf6;
    }
</style>
@endsection @section('content')





<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <!-- <li class="breadcrumb-item">Form</li> -->
        <li class="breadcrumb-item active" aria-current="page">{{isset($page_title)?$page_title:$page_title}}</li>
    </ol>
 
       
    @if($errors->any())
    <div class="col-sm-12">
        <div class="form-group">
            <div class="alert alert-danger alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="col-md-12 col-xl-12">
                    <div class="row mb-4">
                        <div class="col-md-12 col-xl-4 mt-4">
                            <div class="card member-card">
                                <div class="col-12 header">
                                    <div class="row">
                                        <div class="col-5 d-flex align-items-center">
                                            <div class="member-img">
                                                <a href="#!" class="">
                                                    <img src="{{asset('public/assets/img/boy.png')}}" class="rounded-circle" alt="profile-image" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div class="">
                                                <h5 class="">{{isset($users_record->full_name)?$users_record->full_name:''}}</h5>

                                                @if((Auth::user()->user_type == 'SuperAdmin') )

                                                @if($users_record->status =='Enable')

                                                    <a href="{{url('admin/user-blocked/')}}/{{$users_record->reg_no}}" class="btn btn-danger btn-sm"> Blocked User</a>
                                                @else

                                                    <a href="{{url('admin/user-blocked/')}}/{{$users_record->reg_no}}" class="btn btn-success btn-sm"> Unblock Blocked User</a>
                                                @endif

                                                 @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="body">
                                    <div class="col-12">
                                        <p class="mb-2 mt-2">Mobile:{{isset($users_record->mobile)?$users_record->mobile:''}}</p>
                                        <p class="mb-2">Mobile verified status : {{isset($users_record->mobile_verification_status)?$users_record->mobile_verification_status:''}}</p>
                                        <p class="mb-2">Refer Code: {{isset($users_record->refer_code)?$users_record->refer_code:''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xl-8 mt-4">
                            <div class="row">
                                <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Wallet</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{isset($users_record->wallet)?$users_record->wallet:''}}</div>
                                                   
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-wallet fa-2x text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Earnings (Annual) Card Example -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toatl Withdraw Amount</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_withdraw_amount}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-rupee-sign fa-2x text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- New User Card Example -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toatl Deposit Amount</div>
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$total_deposit_amount}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-rupee-sign fa-2x text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pending Requests Card Example -->
                                <div class="col-xl-6 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toatl Win Lottery Amount</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{isset($lottery_win_amount)?$lottery_win_amount:0}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-trophy fa-2x text-warning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toatl Loss Lottery Amount</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{isset($lottery_loss_amount)?$lottery_loss_amount:0}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-star fa-2x text-warning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row  m-2">
                        
                         <div class="col"><h6 class="h6 mb-0 font-weight-bold text-gray-800">UPI /WALLET DETAIL</h6></div>
                    
                       <div class="col"><strong>Phonepay :</strong> <span >{{isset($users_record->phone_pay_mobile)?$users_record->phone_pay_mobile:''}}</span></div>
                       <div class="col"><strong>GooglePay :</strong> {{isset($users_record->google_pay_mobile)?$users_record->google_pay_mobile:''}}</div>
                       <div class="col"><strong>PaytmPay :</strong> {{isset($users_record->paytm_pay_mobile)?$users_record->paytm_pay_mobile:''}}</div>
                      
                    </div>

                    



                </div>


                
            </div>
        </div>


       
    </div>
    
   
   

    
</div>

@endsection @section('specific-page-script')
<script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

<script>
        //query table modal view
        $(document).on("click",".replyBtn", function() {
            let dataqueryid = $(this).attr('data-query-id');
            let queryid = $('#queryid').val(dataqueryid);
            $('#modalUpdateBtn').attr(dataqueryid);
            $('#replayModal').modal({
                backdrop: 'static',
                keyboard: false,
                show:true
            });


            
            $.ajax({
                type: "POST",
                url:'{{url("admin/open-query-with-dialog")}}',
                data: { queryid:dataqueryid, _token: '{{csrf_token()}}' },
                success:function(data) {
                    $('#query').val(data.record.query);
                    $('#revert').val(data.record.revert);

                    if(data.record.status=='Open'){

                        $('#modalStatus').val(data.record.status);
                      }else if(data.record.status=='Close'){

                        $('#modalStatus').val(data.record.status);
                      }else{
                          $('#modalStatus').val(data.record.status);
                      }
                }

            });

        });

    // Query modal update
    $(document).on("click",".modalUpdateBtn", function() {
        let modalRevert = $('#revert').val();
        let queryid = $('#queryid').val();
        let modalStatus = $('#modalStatus').children("option:selected").val();
        $.ajax({
            type: "POST",
            url:'{{url("admin/save-query-with-dialog")}}',
            data: { modalRevert:modalRevert, queryid:queryid,modalStatus:modalStatus, _token: '{{csrf_token()}}' },
            success:function(data) {
                if(data.code==1){
                    $('#replayModal').modal('hide');
                    $('#query-table-status-row-'+queryid).text(modalStatus);
                    $('#revert-col-'+queryid).text(modalRevert.substr(0,50)+'...');
                    $('#updateMsgModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show:true
                    });
                }
            }
        });
    });
</script>

@endsection
