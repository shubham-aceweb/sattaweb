<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
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

    public function withdraw_list_view(Request $request)
    {
        $data['page_title'] = 'Withdraw History';
        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);

        $data['isRollBackCount'] = DB::table('withdraw_history_master')->whereIn('source', $product)
            ->where('isRollBack', 'YES')
            ->where('status', 'FAILURE')
            ->select('tran_history_master.*')
            ->count();
        $data['failurecount'] = DB::table('withdraw_history_master')->whereIn('source', $product)
            ->where('status', 'FAILURE')
            ->select('withdraw_history_master.*')
            ->count();

        $data['successcount'] = DB::table('withdraw_history_master')->whereIn('source', $product)
            ->where('status', 'SUCCESS')
            ->select('withdraw_history_master.*')
            ->count();
        $data['processcount'] = DB::table('withdraw_history_master')->whereIn('source', $product)
            ->where('status', 'PROCESS')
            ->select('withdraw_history_master.*')
            ->count();

        $data['pendingcount'] = DB::table('withdraw_history_master')->whereIn('source', $product)
            ->where('status', 'PENDING')
            ->count();

        return view('admin.transaction.withdraw-list-index', $data);
    }

    public function withdraw_history_list_data(Request $request)
    {
        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);




        $columns = [
            0 => 'id',
            1 => 'transaction_id',
            2 => 'reg_no',
            3 => 'full_name',
            4 => 'transfer_type',
            5 => 'bank_name',
            6 => 'account_no',
            7 => 'ifsc',
            8 => 'phone_pay_mobile',
            9 => 'google_pay_mobile',
            10 => 'paytm_pay_mobile',
            11 => 'amount',
            12 => 'status',
            13 => 'status_msg',
            14 => 'isRollBack',
            15 => 'source',
            16 => 'created_at',
            17 => 'status_msg',
        ];

        $totalData = DB::table('withdraw_history_master')->whereIn('source', $product)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('withdraw_history_master')
            ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = DB::table('withdraw_history_master')
            ->whereIn('source', $product)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('withdraw_history_master')
            ->whereIn('source', $product)
                 ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                switch ($post->status) {
                    case 'PROCESS':
                        $trfBtn1 = '<a href="javascript:void(0);"data-id="' . $post->transaction_id . '" class="btn btn-info btn-sm mb-1" id="withdraw_amount_success_button">SUCCESS</a>';
                        $trfBtn2 = '<a href="javascript:void(0);"data-id="' . $post->transaction_id . '" class="btn btn-danger btn-sm mb-1" id="withdraw_amount_fail_button">FAILURE</a>';
                        $trfBtn = $trfBtn1 . ' ' . $trfBtn2;

                        break;
                    case 'SUCCESS':
                        $trfBtn = '';
                        break;
                }

            

                $nestedData['id'] = $key + 1 + $start;
                $nestedData['transaction_id'] = $post->transaction_id;
                $nestedData['reg_no'] = $post->reg_no;
                $nestedData['full_name'] = $post->full_name;
                $nestedData['transfer_type'] = $post->transfer_type;
                $nestedData['bank_name'] = $post->bank_name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['ifsc'] = $post->ifsc;
                $nestedData['phone_pay_mobile'] = $post->phone_pay_mobile;
                $nestedData['google_pay_mobile'] = $post->google_pay_mobile;
                $nestedData['paytm_pay_mobile'] = $post->paytm_pay_mobile;
                $nestedData['amount'] = $post->amount;
                $nestedData['status'] = $post->status;
                $nestedData['status_msg'] = $post->status_msg;
                $nestedData['isRollBack'] = $post->isRollBack;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->updated_at;
                $nestedData['action'] = '<a target="_blank" href="' . url('admin/user-profile', ['id' => $post->reg_no]) . '" data-reg_no="' . $post->reg_no . '" class="btn btn-primary btn-sm  mr-1 mb-1">Profile</a>' .' '. $trfBtn;
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

    public function deposit_list_view(Request $request)
    {
        $data['page_title'] = 'Deposit History';

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);

        $data['failuercount'] = DB::table('deposit_history_master')
    ->whereIn('source', $product)
            ->where('status', 'FAILURE')
            ->select('tran_history_master.*')
            ->count();

        $data['successcount'] = DB::table('deposit_history_master')
        ->whereIn('source', $product)
            ->where('status', 'SUCCESS')
            ->select('withdraw_history_master.*')
            ->count();
        $data['processcount'] = DB::table('deposit_history_master')
            ->where('status', 'PROCESS')
            ->whereIn('source', $product)
            ->select('withdraw_history_master.*')
            ->count();

    

        return view('admin.transaction.deposit-list-index', $data);
    }

    public function deposit_history_list_data(Request $request)
    {

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);

        $columns = [
            0 => 'id',
            1 => 'reg_no',
            2 => 'transaction_id',
            3 => 'merchant_transaction_id',
            4 => 'full_name',
            5 => 'payout_mode',
            6 => 'amount',
            7 => 'status',
            8 => 'source',
            9 => 'created_at',
            10 => 'updated_at',
        ];

        $totalData = DB::table('deposit_history_master')->whereIn('source', $product)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('deposit_history_master')
                ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = DB::table('deposit_history_master')
                ->whereIn('source', $product)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('deposit_history_master')
                ->whereIn('source', $product)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                switch ($post->status) {
                    case 'PROCESS':
                        $trfBtn1 = '<a href="javascript:void(0);"data-id="' . $post->transaction_id . '" class="btn btn-info btn-sm mb-1" id="deposit_amount_success_button">SUCCESS</a>';
                        $trfBtn2 = '<a href="javascript:void(0);"data-id="' . $post->transaction_id . '" class="btn btn-danger btn-sm mb-1" id="deposit_amount_fail_button">FAILURE</a>';
                        $trfBtn = $trfBtn1 . '<br>' . $trfBtn2;


                        break;
                    case 'SUCCESS':
                        $trfBtn = '';
                        break;
                    case 'FAILURE':
                        $trfBtn = '';
                        
                        break;  
                }

                

                $nestedData['id'] = $key + 1 + $start;
                $nestedData['reg_no'] = $post->reg_no;
                $nestedData['transaction_id'] = $post->transaction_id;
                $nestedData['merchant_transaction_id'] = $post->merchant_transaction_id;
                $nestedData['full_name'] = $post->full_name;
                $nestedData['payout_mode'] = $post->payout_mode;
                $nestedData['amount'] = $post->amount;
                $nestedData['status'] = $post->status;
                $nestedData['status_msg'] = $post->status_msg;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->updated_at;
                $nestedData['action'] = '<a target="_blank" href="' . url('admin/user-profile', ['id' => $post->reg_no]) . '" data-reg_no="' . $post->reg_no . '" class="btn btn-primary btn-sm  mr-1 mb-1">Profile</a>' . $trfBtn;
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

    //transfer now Beneficiary
    public function withdraw_amount_success_button(Request $request)
    {
        $transaction_id = $request->id;
        $update = DB::table('withdraw_history_master')
            ->where('transaction_id', $transaction_id)
            ->update(['status' => 'SUCCESS', 'status_msg' => 'Successful disbursal ', 'updated_at' => $this->current_date_time]);
        if ($update) {
            return response()->json(['code' => 1, 'msg' => 'Status chagne SUCCESS']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
        }
    }
    public function withdraw_amount_fail_button(Request $request)
    {
        $transaction_id = $request->id;
        $update = DB::table('withdraw_history_master')
            ->where('transaction_id', $transaction_id)
            ->update(['status' => 'FAILURE', 'status_msg' => 'Contact Your Bank Service : Amount is Reversed in Few Hours', 'updated_at' => $this->current_date_time]);
        if ($update) {
            return response()->json(['code' => 1, 'msg' => 'Status chagne FAILURE']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
        }
    }
   

    //transfer now Beneficiary
    public function deposit_amount_success_button(Request $request)
    {

        $transaction_id = $request->id;
        $transaction = DB::table('deposit_history_master')
                ->where('transaction_id', $transaction_id)
                ->first();
        
        if (!empty($transaction)) {
            $user = DB::table('users_master')
                ->where('reg_no', $transaction->reg_no)
                ->first();
            if (empty($user)) {
                return response()->json(['code' => 0, 'msg' => 'User not found']);
            } else {

                $update = DB::table('deposit_history_master')
                ->where('transaction_id', $transaction_id)
                ->update(['status' => 'SUCCESS', 'status_msg' => 'Successful added in Wallet', 'updated_at' => $this->current_date_time]);
                $total = $user->wallet + $transaction->amount;
                $upadet_user_wallet = [
                    'wallet' => round($total,2),
                    'updated_at' => $this->current_date_time,
                ];

                DB::table('users_master')
                    ->where('reg_no', $user->reg_no)
                    ->update($upadet_user_wallet);

                return response()->json(['code' => 1, 'msg' => 'Amount added in user wallet successfully, Status - SUCCESS']);
            }
        } else {
            return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
        }
    }
    public function deposit_amount_fail_button(Request $request)
    {
        $transaction_id = $request->id;
        $update = DB::table('deposit_history_master')
            ->where('transaction_id', $transaction_id)
            ->update(['status' => 'FAILURE', 'status_msg' => 'Entered Ref No / UTR No not found ', 'updated_at' => $this->current_date_time]);
        if ($update) {

            return response()->json(['code' => 1, 'msg' => 'Entered Ref No / UTR No not found, Status - FAILURE']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
        }
    }
}
