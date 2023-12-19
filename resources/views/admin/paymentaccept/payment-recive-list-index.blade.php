@extends('admin.comonpart') @section("title", "Bet Distribution List") @section("description", "") @section('specific-page-css')
<link href="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css" />
<style type="text/css">
    #extract {
        height: calc(1.5em + 0.75rem + 7px);
    }

    
#customers {
  
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #bf9a3e;
  color: white;
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





                <div class="table-responsive p-3 " >
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>

                               
                                <th>
                                    <span class="txtwithoutsymble"><span>Sr</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Type</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>BankName</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>UPI/Wallet</span></span>
                                </th>
                                <th>
                                    <span class="txtwithoutsymble"><span>Product</span></span>
                                </th>
                               
                                <th>
                                    <span class="txtwithoutsymble"><span>Status</span></span>
                                </th>
                                  <th>
                                    <span class="txtwithoutsymble"><span>CreatedAt</span></span>
                                </th>

                                <th>
                                    <span class="txtwithoutsymble"><span>UpdatedAt</span></span>
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
    </div>
</div>

@endsection @section('specific-page-script')
<script src="{{asset('public/assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/Zebra_datepicker/1.9.12/zebra_datepicker.min.js')}}"></script>


<script>
    $(document).ready(function () {
        $("#dataTableHover").DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: {
                url: "{{ url('admin/deposit_acc_data') }}",
                dataType: "json",
                type: "POST",
                data: { _token: "{{csrf_token()}}" },
            },

           
    
            columns: [
                { data: "id" },
                { data: "type" },
                { data: "bank_name" },
                { data: "upi_or_account" },
                { data: "status" },
                { data: "product" },
                { data: "created_at" },
                { data: "updated_at" },
                { data: "action" },
    
            ],
        });

        $("input.dateall").Zebra_DatePicker({
            format: "d-m-Y",
            view: "days",
            show_clear_date: "FALSE",
        });
    });
</script>

@endsection
