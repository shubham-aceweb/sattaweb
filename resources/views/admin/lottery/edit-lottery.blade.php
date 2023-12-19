@extends('admin.comonpart') @section("title", "Lottery Result") @section("description", "Description put here") @section("keyword", "Keword put here") @section('specific-page-css')
<!-- Select2 -->
<!-- <link href="{{asset('public/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"> -->
<!-- summernote -->
<!-- <link rel="stylesheet" href="{{asset('public/vendor/summernote/summernote-bs4.css')}}"> -->
<!-- //date time picker -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css"> -->

<link rel="stylesheet" type="text/css" href="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.css')}}" />
<link href="{{asset('public/assets/vendor/clock-picker/clockpicker.css')}}" rel="stylesheet" />
@endsection @section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$page_title}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <!-- <li class="breadcrumb-item">Form</li> -->
            <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
        </ol>
    </div>

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
                <div class="card-body">
                    <form method="post" action="{{url('admin/lottery-update-data')}}/{{$lottery_detail->id}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="name">Open Time (Formate 00 : 00PM) <span class="text-danger" title="This field is required">*</span></label>

                                <div class="input-group clockpicker" id="clockPicker1">
                                    <input type="text" class="form-control" name="open_time" placeholder="Enter Open Time" value="{{$lottery_detail->open_time}}" required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="name">Close Time (Formate 00 : 00AM)<span class="text-danger" title="This field is required">*</span></label>

                                <div class="input-group clockpicker" id="clockPicker2">
                                    <input type="text" class="form-control" name="close_time" placeholder="Enter Close Time" value="{{$lottery_detail->close_time}}" required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="col-form-label">Operating Day <span class="text-danger" title="This field is required">*</span></label>
                                <select name="lottery_week_day" class="form-control">
                                    <option value="">Select from list</option>
                                    <option value="MON,TUE,WED,THU,FRI,SAT,SUN" {{ $lottery_detail->lottery_week_day == 'MON,TUE,WED,THU,FRI,SAT,SUN' ? 'selected' : '' }}>(7 DAYS) MON,TUE,WED,THU,FRI,SAT,SUN</option>
                                    <option value="MON,TUE,WED,THU,FRI,SAT" {{ $lottery_detail->lottery_week_day == 'MON,TUE,WED,THU,FRI,SAT' ? 'selected' : '' }}>(6 DAYS) MON,TUE,WED,THU,FRI,SAT</option>
                                    <option value="MON,TUE,WED,THU,FRI" {{ $lottery_detail->lottery_week_day == 'MON,TUE,WED,THU,FRI' ? 'selected' : '' }}>(5 DAYS) MON,TUE,WED,THU,FRI</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="col-form-label">Status <span class="text-danger" title="This field is required">*</span></label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Open" {{ $lottery_detail->status == 'Open' ? 'selected' : '' }}>Update</option>
                                    <option value="Disable" {{ $lottery_detail->status == 'Disable' ? 'selected' : '' }}>Holiday</option>
                                    <option value="Deactive" {{ $lottery_detail->status == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                                    <option value="Close" {{ $lottery_detail->status == 'Close' ? 'selected' : '' }}>Close</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('specific-page-script')

<script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>
<!-- ClockPicker -->
<script src="{{asset('public/assets/vendor/clock-picker/clockpicker.js')}}"></script>
<script>
    //show image name in file field
    $(".customFile").on("change", function () {
        files = $(this)[0].files;
        name = "";
        for (var i = 0; i < files.length; i++) {
            name += files[i].name + (i != files.length - 1 ? ", " : "");
        }
        $(".custom-file-label").html(name);
    });

    //date time picker
    $("input.calender").Zebra_DatePicker({
        format: "Y-m-d",
        view: "days",
        show_clear_date: "FALSE",
    });

    $("#clockPicker1").clockpicker({
        donetext: "Done",
        autoclose: true,
        twelvehour: true,
    });

    $("#clockPicker2").clockpicker({
        donetext: "Done",
        autoclose: true,
        twelvehour: true,
    });
</script>

@endsection
