@extends('admin.comonpart') @section("title", "Lottery Name List") @section("description", "") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css" rel="stylesheet" />

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
                    <p class="btn btn-outline-danger  mr-2 btn-sm">OPEN MARKET ( {{$lottery_open_count}} )</p>
                            <p class="btn btn-outline-success  mr-2 btn-sm">CLOSE MARKET ( {{$lottery_close_count}} )</p>
                            <p class="btn btn-outline-warning  mr-2 btn-sm">HOLIDAY MARKET ( {{$lottery_close_holiday}} )</p>
                            <p class="btn btn-outline-danger  mr-2 btn-sm">DEACTIVE MARKET ( {{$lottery_close_deactive}} )</p>
                 </div>


                <div class="table-responsive p-3">
                    <table class="table table-striped ajaxTable datatable lottery-table">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    <span class="txtwithoutsymble"><span>Id.</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Postion</span></span>
                                </th>

                                <th>
                                    <span class="txtwithoutsymble"><span>LotteryDate</span></span>
                                </th>

                                <th>
                                    <span class="txtwithoutsymble"><span>LotteryName</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>OpenPana</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Jodi</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>ClosePana</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>OpenTime</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>CloseTime</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>LotteryDay</span></span>
                                </th>

                                <th>
                                    <span class="txtwithoutsymble"><span>Status</span></span>
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

        <div class="modal fade" id="contractModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: red; color: white;">
                        <h2 class="modal-title title" id="exampleModalLabel">Lucky Number</h2>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="lottery_name" name="lottery_name" readonly />
                            <label for="exampleInputEmail1">Enter OTC (formate 7=8=6=9)</label>
                            <input type="text" class="form-control" id="otc" name="otc" autocomplete="off" />
                            <label for="exampleInputEmail1">Jodi ( formate 76=70=85=88=61=66=99=97)</label>
                            <input type="text" class="form-control" id="jodi" name="jodi" pautocomplete="off" />
                            <label for="exampleInputEmail1">Patti (formate 359=890=170=369=123=268=135=180)</label>
                            <input type="text" class="form-control" id="patti" name="patti" autocomplete="off" />
                            <label for="exampleInputEmail1">Passing (formate Open=6=Pass Close=9=Pass)</label>
                            <input type="text" class="form-control" id="passing" name="passing" autocomplete="off" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success" id="confirm_btn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>

@endsection @section('specific-page-script')
<script src="{{asset('public/assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
<script>
    $(function () {
        let dtOverrideGlobals = {
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
                url: "{{ url('admin/open-close-lottery-list-data') }}",
                dataType: "json",
                type: "POST",
                data: { _token: "{{csrf_token()}}" },
            },
            columns: [
                { data: "id", name: "id", visible: false, searchable: false },
                { data: "position", name: "position", visible: true, searchable: false },
                { data: "lottery_date" },
                { data: "lottery_name" },
                { data: "open_pana" },
                { data: "jodi" },
                { data: "close_pana" },
                { data: "open_time" },
                { data: "close_time" },
                { data: "lottery_week_day" },
                { data: "status" },
                { data: "action", orderable: false, searchable: false },
            ],
            order: [1, "ASC"],
            pageLength: 50,
            rowReorder: {
                selector: "tr td:not(:first-of-type,:last-of-type)",
                dataSrc: "position",
            },
        };

        let datatable = $(".lottery-table").DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
        datatable.on("row-reorder", function (e, details) {
            if (details.length) {
                console.log(details);

                let rows = [];
                details.forEach((element) => {
                    rows.push({
                        id: datatable.row(element.node).data().id,
                        position: element.newData,
                    });
                });

                $.ajax({
                    method: "POST",
                    url: "{{ url('admin/open-close-lottery-list-data-reorder') }}",
                    data: { rows, _token: "{{csrf_token()}}" },
                }).done(function () {
                    datatable.ajax.reload();
                });
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).on("click", ".contractModal", function () {
        $(".title").text($(this).attr("data-num") + " Lucky Number");
        document.getElementById("lottery_name").value = $(this).attr("data-num");
        document.getElementById("otc").value = $(this).attr("lucky_number_otc");
        document.getElementById("jodi").value = $(this).attr("lucky_number_jodi");
        document.getElementById("patti").value = $(this).attr("lucky_number_patti");
        document.getElementById("passing").value = $(this).attr("lucky_number_passing");
    });

    $(document).on("click", "#confirm_btn", function () {
        var lottery_name = $("#lottery_name").val();
        var otc = $("#otc").val();
        var jodi = $("#jodi").val();
        var patti = $("#patti").val();
        var passing = $("#passing").val();
        if (lottery_name == "") {
            alert("Somthing went to wrong. Please try again.");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: '{{url("admin/generate-lucky-number")}}',
                data: { lottery_name: lottery_name, otc: otc, jodi: jodi, patti: patti, passing: passing, _token: "{{csrf_token()}}" },
                success: function (data) {
                    if (data.code == 1) {
                        alert(data.msg);
                        window.location.href = '{{url("admin/open-close-lottery-list")}}';
                    } else {
                        alert(data.msg);
                    }
                },
            });
        }
    });
</script>



@endsection
