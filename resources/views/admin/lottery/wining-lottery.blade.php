@extends('admin.comonpart') @section("title", "Lottery Result") @section("description", "Description put here") @section("keyword", "Keword put here") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

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
                    <form method="post" action="{{url('admin/wining-lottery-result-update')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label class="col-form-label">Lottery Date<span class="text-danger" title="This field is required">*</span></label>

                                    <input type="text" placeholder="Lottery Date" name="lottery_date" class="calender form-control" id="lottery_date" value="{{$today_date}}" required="required" />
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label class="col-form-label">Select Lottery Name<span class="text-danger" title="This field is required">*</span></label>
                                    <select class="form-control" id="lottery_name" name="lottery_name" required="required">
                                        <option value="">Select One Value Only</option>
                                        @foreach($lottery_list as $value)
                                        <option value="{{$value->lottery_name}}">{{$value->lottery_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label class="col-form-label">Open Pana <span class="text-danger" title="This field is required">*</span></label>

                                    <input type="text" class="form-control" id="open_pana" name="open_pana" value="" required="required" />
                                </div>

                                <div class="col-4">
                                    <label class="col-form-label">Close Pana<span class="text-danger" title="This field is required">*</span></label>

                                    <input type="text" class="form-control" id="close_pana" name="close_pana" value="" required="required" />
                                </div>
                                <div class="col-4">
                                    <label class="col-form-label">Jodi <span class="text-danger" title="This field is required">*</span></label>

                                    <input type="text" class="form-control" id="jodi" name="jodi" value="" required="required" readonly />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-b-0 float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5 class="h5 mb-0 font-weight-bold text-gray-800">Today's Market Result</h5>
                    <div class="card-header-right"></div>
                </div>
                <div class="card-block">
                    <div class="table-responsive p-3">
                        <table class="table table-hover" id="datatable2">
                            <thead>
                                <tr>
                                    <th>Sr</th>

                                    <th>
                                        <span class="txtwithoutsymble">Lottery Date</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Lottery Name</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Open</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Open Pana</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Jodi</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Close Pana</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Close</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Open Time</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Close Time</span>
                                    </th>

                                    <th>
                                        <span class="txtwithoutsymble">LastUpdateAt</span>
                                    </th>
                                    <th>
                                        <span class="txtwithoutsymble">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($today_result_history)) @foreach($today_result_history as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->lottery_date}}</td>
                                    <td>{{$value->lottery_name}}</td>
                                    <td>{{$value->open}}</td>
                                    <td>{{$value->open_pana}}</td>
                                    <td>{{$value->jodi}}</td>
                                    <td>{{$value->close_pana}}</td>
                                    <td>{{$value->close}}</td>
                                    <td>{{$value->open_time}}</td>
                                    <td>{{$value->close_time}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td><a href="{{url('admin/edit-winning-lottery', ['id' => $value->id]) }}" class="btn btn-warning btn-sm mr-1 mb-1">Correction</a></td>
                                    <!-- <td><a target="_blank" href="{{url('/admin/reset-result/'.$value->lottery_name.'/'.$value->lottery_date)}}" class="btn btn-warning btn-sm mr-1 mb-1">Correction</a></td> -->
                                </tr>
                                @endforeach @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection @section('specific-page-script')

    <script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>
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

    <script type="text/javascript">
        $("#open_pana").on("change", function () {
            var open_pana = $("#open_pana").val();
            if (open_pana.toString().length == 3 && open_pana != "***" && !isNaN(open_pana)) {
                var sum_open_pana = sumDigits(open_pana);
                last_digit_sum_open_pana = sum_open_pana % 10;
                document.getElementById("jodi").value = last_digit_sum_open_pana + "*";
                document.getElementById("close_pana").value = "***";
            } else {
                document.getElementById("open_pana").value = "***";
                document.getElementById("jodi").value = "**";
                document.getElementById("close_pana").value = "***";
            }
        });

        $("#close_pana").on("change", function () {
            var open_pana = $("#open_pana").val();
            var close_pana = $("#close_pana").val();
            if (open_pana.toString().length == 3 && open_pana != "***" && !isNaN(open_pana)) {
                if (close_pana.toString().length == 3 && close_pana != "***" && !isNaN(close_pana)) {
                    var sum_open_pana = sumDigits(open_pana);
                    last_digit_sum_open_pana = sum_open_pana % 10;
                    var sum_close_pana = sumDigits(close_pana);
                    last_digit_sum_close_pana = sum_close_pana % 10;
                    document.getElementById("jodi").value = last_digit_sum_open_pana + "" + last_digit_sum_close_pana;
                } else {
                    var sum_open_pana = sumDigits(open_pana);
                    last_digit_sum_open_pana = sum_open_pana % 10;
                    document.getElementById("jodi").value = last_digit_sum_open_pana + "*";

                    document.getElementById("close_pana").value = "***";
                }
            } else {
                document.getElementById("open_pana").value = "***";
                document.getElementById("jodi").value = "**";
                document.getElementById("close_pana").value = "***";
            }
        });

        function sumDigits(num) {
            return num
                .toString()
                .split("")
                .reduce(function (a, b) {
                    return parseInt(a) + parseInt(b);
                });
        }
    </script>
    <script type="text/javascript">
        $("#lottery_name").change(function () {
            var lottery_date = $("#lottery_date").val();
            var lottery_name = $("#lottery_name").val();
            if (lottery_date == "") {
                document.getElementById("lottery_name").value = "";
                alert("Select Lottery Date First");
            } else if (lottery_name == "") {
                alert("Select Lottery Name");
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{url("admin/wining-lottery-result-last-update")}}',
                    data: { lottery_date: lottery_date, lottery_name: lottery_name, _token: "{{csrf_token()}}" },
                    success: function (data) {
                        document.getElementById("open_pana").value = data.open_pana;
                        document.getElementById("close_pana").value = data.close_pana;
                        document.getElementById("jodi").value = data.jodi;
                    },
                });
            }
        });
    </script>

    @endsection
</div>
