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
                                <th><span class="txtwithoutsymble"><span>LotteryName</span></span></th>
                                <th><span class="txtwithoutsymble"><span>OpenTime</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CloseTime</span></span></th>
                                <th><span class="txtwithoutsymble"><span>GameType</span></span></th>
                                <th><span class="txtwithoutsymble"><span>CategoryType</span></span></th>
                                <th><span class="txtwithoutsymble"><span>LotteryNumber</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Amount</span></span></th>
                               <!--  <th><span class="txtwithoutsymble"><span>WinAmount</span></span></th> -->
                               <th><span class="txtwithoutsymble"><span>Product</span></span></th> 
                                  <th><span class="txtwithoutsymble"><span>Status</span></span></th>
                                <th><span class="txtwithoutsymble"><span>Play Time</span></span></th>
                              
                                <th><span class="txtwithoutsymble"><span>Action</span></span></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                                @if(isset($user_play_list)) @foreach($user_play_list as $value)
                                <tr>
                                   <td>{{$loop->iteration}}</td>
                                   <td>{{$value->full_name}}</td>
                                   <td>{{$value->mobile}}</td>
                                   <td>{{$value->lottery_name}}</td>
                                   <td>{{$value->open_time}}</td>
                                   <td>{{$value->close_time}}</td>
                                  
                                   @if($value->lottery_game_type =='Jodi')
                                        <td>Open</td>
                                   @else
                                        <td>{{$value->lottery_game_type}}</td>
                                   @endif
                                   
                                   <td>{{$value->lottery_category_type}}</td>
                                   <td>{{$value->lottery_numbers}}</td>
                                   <td>{{$value->lottery_amount}}</td>
                                  <td>{{$value->source}}</td> 
                                  <td>{{$value->status}}</td>
                                   <td>{{$value->created_at}}</td>
                                  
                                   <td><a href="https://bestsattamatka.net/admin/user-profile/{{$value->reg_no}}" class="btn btn-primary btn-sm">Profile</a></td>
                                    
                                </tr>
                                @endforeach @endif
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



@endsection