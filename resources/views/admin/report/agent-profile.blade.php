@extends('admin.comonpart') @section("title", "Agent Report") @section("description", "") @section("keyword", "") @section('specific-page-css')
<!-- Select2 -->
<link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />



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


@endsection @section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <!-- <li class="breadcrumb-item">Form</li> -->
        <li class="breadcrumb-item active" aria-current="page">Agent</li>
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

    <div id="print-content">
        
    </div>

    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
           
        </div>

        

       
    </div>
    <div class="row mb-4" >
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header">

                    <div style="text-align: center;">
                         <h5 class="h5 mb-0 font-weight-bold text-gray-800">AGENT REPORT ( {{$product}} )</h5>

            
                         <h6 class="h5 mb-0 text-gray-800">Date -{{$lottery_date}} </h6>
                   
                    </div>
                   
                </div>
                <div class="card-block">
                    <div class="table-responsive p-3">
                        <table class="table table-hover" id="datatable2">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>LotteryDate</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>LotteryName</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>OpenPatti</span></span>
                                    </th>
                                     <th>
                                        <span class="txtwithoutsymble"><span>Jodi</span></span>
                                    </th>
                                    
                                    <th>
                                        <span class="txtwithoutsymble"><span>ClosePatti</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>Amount</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>WinningAmount</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>Commission</span></span>
                                    </th>
                                    
                                    <th>
                                        <span class="txtwithoutsymble"><span>Cr</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>Dr</span></span>
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($lottery_history_list)) @foreach($lottery_history_list as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->report_date}}</td>
                                    <td>{{$value->lottery_name}}</td>
                                    <td>{{$value->open_pana}}</td>
                                     <td>{{$value->jodi}}</td>
                                    <td>{{$value->close_pana}}</td>
                                    <td><a style="color : black;" href="{{url('/admin/report-user-market-list/'.$value->lottery_name.'/'.$value->report_date.'?product='.$product)}}"><strong>{{$value->amount}}</strong></a></td>

                                    <td>{{$value->won_lottery_amount}}</td>
                                    <td>{{$value->commission}}</td>
                                    <td>{{$value->cr}}</td>
                                    <td>{{$value->dr}}</td>

                                    
                                    
                                </tr>
                                @endforeach @endif
                            </tbody>
                            <thead style="background: #e6f2fe;">
                                <tr>
                                    <th></th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                     <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                   
                                    <th>
                                        <span class="txtwithoutsymble"><span>Total</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_amount}}</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_won_amount}}</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_commission}}</span></span>
                                    </th>
                                     
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_cr}}</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_dr}}</span></span>
                                    </th>
                                   
                                </tr>

                                    <th></th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                     <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                   
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span>Grand Total</span></span>
                                    </th>
                                     
                                    <th>
                                        <span class="txtwithoutsymble"><span>{{$grand_total}}</span></span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble"><span></span></span>
                                    </th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

   
    
   

    
</div>


@endsection @section('specific-page-script')


@endsection
