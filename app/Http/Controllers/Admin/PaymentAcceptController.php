<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Redirect;
use Illuminate\Support\Facades\Auth;

class PaymentAcceptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Asia/Kolkata');
        $this->current_date_time = date("Y-m-d H:i:s");
    }

    public function add_deposit_acc(Request $request)
    {
        $data['page_title'] = 'Add Deposit A/C';
        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $data['product_list_master'] = DB::table('product_list_master')->where('status','Enable')->orderBy('name')->whereIn('name', $product)->get();
        return view('admin.paymentaccept.add-payment_account', $data);
    }
    public function save_deposit_acc_data(Request $request)
    {
        
        $id = $request->id;
        $v = Validator::make($request->all(),
            [
                'product_name' => 'required',
                'type' => 'required',
                'bank_name' => 'required',
                'upi_or_account' => 'required',
                'status' => 'required',
                
            ],
            [
                'product_name.required' => 'Product Name is required',
                'type.required' => 'Type is required',
                'bank_name.required' => 'Bank Name is required',
                'upi_or_account.required' => 'UPI or Account Number is required',
                'status.required' => 'Status is required',
            ]
        );

        if ($v->fails()) {
            return back()
                ->withErrors($v->errors())
                ->withInput();
        } else {
            $data = [
                'product' => $request->product_name,
                'type' => $request->type,
                'bank_name' => $request->bank_name,
                'upi_or_account' => $request->upi_or_account,
                'status' => $request->status,
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];




            $retur_id = DB::table('payment_recive_acc_master')->insertGetId($data);

            if (isset($retur_id)) {
                return redirect('admin/deposit_acc_list')->withSuccess('Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        

           
        }
    }


    public function deposit_acc_list(Request $request)
    {
        $data['page_title'] = 'Deposit A/C List';
        return view('admin.paymentaccept.payment-recive-list-index', $data);
    }

     public function deposit_acc_data(Request $request)
    {

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);
        $columns = [
            0 => 'id',
            1 => 'type',
            2 => 'bank_name',
            3 => 'upi_or_account',
            4 => 'product',
            5 => 'status',
            6 => 'created_at',
            7 => 'updated_at',
        ];

        $totalData = DB::table('payment_recive_acc_master')->whereIn('product', $product)
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('payment_recive_acc_master')->whereIn('product', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('payment_recive_acc_master')->whereIn('product', $product)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('type', 'LIKE', "%{$search}%")
                ->orWhere('bank_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('payment_recive_acc_master')->whereIn('product', $product)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('type', 'LIKE', "%{$search}%")
                ->orWhere('bank_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {


                $nestedData['id'] = $key + 1 + $start;
                $nestedData['type'] = $post->type;
                $nestedData['bank_name'] = $post->bank_name;
                $nestedData['upi_or_account'] = $post->upi_or_account;
                $nestedData['status'] = $post->status;
                $nestedData['product'] = $post->product;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->updated_at;
                $nestedData['action'] = '<a target="_blank" href="' . url('admin/edit_deposit_acc', ['id' => $post->id]) . '" class="btn btn-primary btn-sm  mr-1 mb-1">Edit</a>';
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        echo json_encode($json_data);
    }


    public function edit_deposit_acc(Request $request)
    {
        $id = $request->id;

        $data['page_title'] = 'Edit Deposit A/c Detail';

        $data['result'] = DB::table('payment_recive_acc_master')
            ->where('id', $id)
            ->select('payment_recive_acc_master.*')
            ->first();

        return view('admin.paymentaccept.edit-payment-recive-index', $data);
    }
    public function edit_deposit_acc_data(Request $request)
    {
        
        $id = $request->id;
        $v = Validator::make($request->all(),
            [
                
                'type' => 'required',
                'bank_name' => 'required',
                'upi_or_account' => 'required',
                'status' => 'required',
                
            ],
            [
                
                'type.required' => 'Type is required',
                'bank_name.required' => 'Bank Name is required',
                'upi_or_account.required' => 'UPI or Account Number is required',
                'status.required' => 'Status is required',
            ]
        );

        if ($v->fails()) {
            return back()
                ->withErrors($v->errors())
                ->withInput();
        } else {
            $data = [
                
                'bank_name' => $request->bank_name,
                'upi_or_account' => $request->upi_or_account,
                'status' => $request->status,
                'updated_at' => $this->current_date_time,
            ];

            try {
                $result = DB::table('payment_recive_acc_master')
                    ->where('id', $id)
                    ->update($data);
                if ((isset($result) && $result == 1) || $result == 0) {
                    return redirect('admin/deposit_acc_list')->with('success', 'Sucessfully Update');
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Whoops something went wrong');
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                //print_r(get_class($ex));
                //dd($ex->getMessage());
                return redirect()
                    ->back()
                    ->withErrors($ex->getMessage())
                    ->withInput();
            }
        }
    }

    



}
