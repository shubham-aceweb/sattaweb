@extends('admin.comonpart') @section("title", "Market Report") @section("description", "") @section("keyword", "") @section('specific-page-css')
<!-- Select2 -->
<link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
    .box {
        text-align: center;
    }

    .font-1 {
        color: #000000;
        font-weight: 900;
    }
</style>

@endsection @section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <!-- <li class="breadcrumb-item">Form</li> -->
        <li class="breadcrumb-item active" aria-current="page">Market Report</li>
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
            <div class="card mb-4 p-3">
                <div style="text-align: center;">
                    <h2>Market Report</h2>
                </div>

                <div class="row m-3">
                    <div class="col-md-12 col-xl-2">
                        <h6 class="">{{$lotery_name}}</h6>
                    </div>

                    <div class="col-md-12 col-xl-2">
                        <h6 class="">Total : Rs. {{$total_amount}}</h6>
                    </div>

                    <div class="col-md-12 col-xl-3">
                        <h6 class="">Wining No : {{$open_pana}}-{{$jodi}}-{{$close_pana}}</h6>
                    </div>

                    <div class="col-md-12 col-xl-3">
                        <h6 class="">Time : {{$open_time}}-{{$close_time}}</h6>
                    </div>

                    <div class="col-md-12 col-xl-2">
                        <h6 class="">Date : {{$lottery_date}}</h6>
                    </div>
                </div>

                <div class="row mx-3">
                    <div class="col-md-6 col-xl-6">
                        <h6 class="font-1">OPEN</h6>
                        <div class="row" style="background: #f5f5f5; padding: 5px;margin-bottom: 10px">
                            <div class="col-md-4 col-xl-3">



                                <div class="font-1">Sr No</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">Single</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">Jodi</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">Pana</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xl-3">
                               

                                @for ($i = 1; $i <= $maxsr; $i++)
                                

                                <div class="font-1">{{ $i }}</div>
                            @endfor

                            </div>
                            <div class="col-md-4 col-xl-3">
                                <table>
                                    @if(isset($single_record_open_other)) 

                                    @foreach($single_record_open_other as $value)
                                    <tr>
                                        <td>{{$value->lottery_numbers}} = {{$value->lottery_amount}} ({{$value->user_count}})</td>
                                    </tr>
                                    @endforeach 

                                    @endif
                                </table>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <table>
                                    @if(isset($jodi_record_other)) @foreach($jodi_record_other as $value)
                                    <tr>
                                        <td>{{$value->lottery_numbers}} = {{$value->lottery_amount}} ({{$value->user_count}})</td>
                                    </tr>
                                    @endforeach @endif
                                </table>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <table>
                                    @if(isset($pana_record_open_other)) @foreach($pana_record_open_other as $value)
                                    <tr>
                                        <td>{{$value->lottery_numbers}} = {{$value->lottery_amount}} ({{$value->user_count}})</td>
                                    </tr>
                                    @endforeach @endif
                                </table>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-1 col-xl-1"></div>

                    <div class="col-md-5 col-xl-5">
                        <h6 class="font-1">CLOSE</h6>
                        <div class="row" style="background: #f5f5f5; padding: 5px;margin-bottom: 10px">


                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">Single</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">Pana</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xl-3">
                                <table>
                                    @if(isset($single_record_close_other)) @foreach($single_record_close_other as $value)
                                    <tr>
                                        <td>{{$value->lottery_numbers}} = {{$value->lottery_amount}} ({{$value->user_count}})</td>
                                    </tr>
                                    @endforeach @endif
                                </table>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <table>
                                    @if(isset($pana_record_close_other)) @foreach($pana_record_close_other as $value)
                                    <tr>
                                        <td>{{$value->lottery_numbers}} = {{$value->lottery_amount}} ({{$value->user_count}})</td>
                                    </tr>
                                    @endforeach @endif
                                </table>
                            </div>

                            <div class="col-md-4 col-xl-3"></div>

                        </div>

                        
                    </div>
                </div>


                <div class="row mx-3">

                    <div class="col-md-6 col-xl-6">
                        <div class="row" style="background: #f5f5f5; padding: 5px;margin-bottom: 10px">
                            <div class="col-md-4 col-xl-3">



                            <div class="font-1">TOTAL</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">{{$single_record_open_user_count_sum}}</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                              <div class="font-1">{{$jodi_record_user_count_sum}}</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                  <div class="font-1">{{$pana_record_open_user_count_sum}}</div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-xl-1"></div>
                    <div class="col-md-5 col-xl-5">
                        
                         <div class="row" style="background: #f5f5f5; padding: 5px;margin-bottom: 10px">
                            <div class="col-md-4 col-xl-3">



                            <div class="font-1">{{$single_record_close_user_count_sum}}</div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="font-1">{{$pana_record_close_user_count_sum}}</div>
                            </div>
                            
                            
                        </div>
                    </div>

                </div>

                    

                <div>
                    <button type="button" onclick="window.print()" class="btn btn-primary float-right">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('specific-page-script') @endsection
