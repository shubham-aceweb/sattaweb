<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Schema;
use App\Classes\ApiValidationController;
use Session;
class UserDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->created_at = get_date_default_timezone_set();
        $this->updated_at = get_date_default_timezone_set();
    }

    public function list_index()
    {
        $data['page_title'] = 'Players';
        return view('admin.users.list-index', $data);
    }

    public function users_detail_list_data(Request $request)
    {
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);

        $columns = [
            0 => 'id',
            1 => 'reg_no',
            2 => 'full_name',
            3 => 'mobile',
            4 => 'wallet',
            5 => 'refer_code',
            6 => 'refer_by',
            7 => 'created_at',
        ];

        $totalData = DB::table('users_master')
            ->whereIn('source', $product)
            ->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('users_master')
                ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('users_master')
                ->whereIn('source', $product)
                ->where(function ($query) use ($search) {
                    return $query
                        ->where('id', 'LIKE', "%{$search}%")
                        ->orWhere('reg_no', 'LIKE', "%{$search}%")
                        ->orWhere('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%")
                        ->orWhere('refer_code', 'LIKE', "%{$search}%")
                        ->orWhere('created_at', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('users_master')
                ->whereIn('source', $product)
                ->where(function ($query) use ($search) {
                    return $query
                        ->where('id', 'LIKE', "%{$search}%")
                        ->orWhere('reg_no', 'LIKE', "%{$search}%")
                        ->orWhere('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%")
                        ->orWhere('refer_code', 'LIKE', "%{$search}%")
                        ->orWhere('created_at', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['reg_no'] = $post->reg_no;
                $nestedData['full_name'] = $post->full_name;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['wallet'] = $post->wallet;
                $nestedData['refer_code'] = $post->refer_code;
                $nestedData['refer_by'] = $post->refer_by;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;

                $nestedData['action'] =
                    '<a href="' .
                    url('admin/user-profile', ['id' => $post->reg_no]) .
                    '" class="btn btn-primary btn-sm">Profile</a>' .
                    ' ' .
                    '<button type="button" class="contractModal1 btn btn-success btn-sm"  data-num="' .
                    $post->reg_no .
                    '"  data-toggle="modal"  data-target="#contractModal1">Credit Amt.</button>' .
                    ' <button type="button" class="contractModal2 btn btn-danger btn-sm"  data-num="' .
                    $post->reg_no .
                    '"  data-toggle="modal"  data-target="#contractModal2">Debit Amt.</button>' .
                    ' <a href="' .
                    url('admin/user-transaction', ['reg_no' => $post->reg_no]) .
                    '" class="btn btn-warning btn-sm">Transaction</a>' .
                    ' <a href="' .
                    url('admin/user-market', ['reg_no' => $post->reg_no]) .
                    '" class="btn btn-success btn-sm">Market</a>';

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

    public function user_profile(Request $request)
    {
        $data['page_title'] = 'User Details';
        $regno = $request->regno;

        $users_record = DB::table('users_master')
            ->where('reg_no', $regno)
            ->first();

        if (empty($users_record)) {
            return redirect('admin/user-list')->with('error', 'Whoops something went wrong');
        } else {
            $reg_no = $users_record->reg_no;
            $data['users_record'] = $users_record;

            $data['total_withdraw_amount'] = DB::table('withdraw_history_master')
                ->where('reg_no', $reg_no)
                ->where('status', 'SUCCESS')
                ->sum('amount');

            $data['total_deposit_amount'] = DB::table('deposit_history_master')
                ->where('reg_no', $reg_no)
                ->where('status', 'SUCCESS')
                ->sum('amount');

            $data['lottery_win_amount'] = DB::table('lottery_result_master')
                ->where('reg_no', $reg_no)
               ->where('status', 'WIN')
                ->sum('won_lottery_amount');
            $data['lottery_loss_amount'] = DB::table('lottery_result_master')
                ->where('reg_no', $reg_no)
               ->where('status', 'LOSS')
                ->sum('lottery_amount');

         
        }

        return view('admin.users.user-profile', $data);
    }

    public function add_money_user_wallet(Request $request)
    {
        $reg_no = $request->regno;
        $wallet_amount = $request->wallet_amount;
        $utrrefno = $request->utrrefno;
        $validation = new ApiValidationController();
        $user_deatil = DB::table('users_master')
            ->where('reg_no', $reg_no)
            ->first();
        if (empty($user_deatil)) {
            return response()->json(['code' => 0, 'msg' => 'User Not Found']);
        } elseif ($validation->noSpcialCharacterWithoutSpace($reg_no)) {
            return response()->json(['code' => 0, 'msg' => 'Enter Valid Registration number']);
        } elseif ($validation->noSpcialCharacterWithoutSpace($wallet_amount)) {
            return response()->json(['code' => 0, 'msg' => 'Enter Wallet Amount']);
        } elseif ($wallet_amount < 1) {
            return response()->json(['code' => 0, 'msg' => 'Wallet Amount must be grater than zero']);
        } elseif (empty($utrrefno)) {
            return response()->json(['code' => 0, 'msg' => 'Enter UTR/RefNo if any or Just Put  NA.']);
        } else {
            $total = $user_deatil->wallet + $wallet_amount;
            $update = DB::table('users_master')
                ->where('reg_no', $reg_no)
                ->update(['wallet' => $total, 'updated_at' => $this->updated_at]);
            if ($update) {
                $admin_detail = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->first();
                $transaction_id = 'TN' . str_replace(".", "", microtime(true)) . rand(100, 999);
                $create_deposit_history = [
                    'transaction_id' => $transaction_id,
                    'merchant_transaction_id' => $utrrefno . ' | Added By ' . $admin_detail->name,
                    'reg_no' => $reg_no,
                    'full_name' => $user_deatil->full_name,
                    'payout_mode' => 'Other',
                    'amount' => $wallet_amount,
                    'status' => 'SUCCESS',
                    'status_msg' => 'Successful added in Wallet',
                    'source' => $user_deatil->source,
                    'created_at' => $this->updated_at,
                    'updated_at' => $this->updated_at,
                ];
                $return_id = DB::table('deposit_history_master')->insertGetId($create_deposit_history);

                if (isset($return_id)) {
                    DB::table('transaction_master')->insert([
                        'type' => 'Credit',
                        'reg_no' => $reg_no,
                        'mobile' => $user_deatil->mobile,
                        'refno' => $utrrefno . ' | Added By ' . $admin_detail->name,
                        'full_name' => $user_deatil->full_name,
                        'amount' => $wallet_amount,
                        'status' => 'SUCCESS',
                        'source' => $user_deatil->source,
                        'created_at' => $this->updated_at,
                        'updated_at' => $this->updated_at,
                    ]);

                    return response()->json(['code' => 1, 'msg' => 'Wallet Updated SUCCESS']);
                } else {
                    return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
                }
            } else {
                return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
            }
        }
    }

    public function redeem_money_user_wallet(Request $request)
    {
        $reg_no = $request->regno;
        $wallet_amount = $request->wallet_amount;
        $utrrefno = $request->utrrefno;
        $validation = new ApiValidationController();
        $user_deatil = DB::table('users_master')
            ->where('reg_no', $reg_no)
            ->first();
        if (empty($user_deatil)) {
            return response()->json(['code' => 0, 'msg' => 'User Not Found']);
        } elseif ($validation->noSpcialCharacterWithoutSpace($reg_no)) {
            return response()->json(['code' => 0, 'msg' => 'Enter Valid Registration number']);
        } elseif ($validation->noSpcialCharacterWithoutSpace($wallet_amount)) {
            return response()->json(['code' => 0, 'msg' => 'Enter Wallet Amount']);
        } elseif ($wallet_amount < 1) {
            return response()->json(['code' => 0, 'msg' => 'Wallet Amount must be grater than zero']);
        } elseif (empty($utrrefno)) {
            return response()->json(['code' => 0, 'msg' => 'Enter UTR/RefNo if any or Just Put  NA.']);
        } elseif ($wallet_amount > $user_deatil->wallet) {
            return response()->json(['code' => 0, 'msg' => 'Insufficient Funds in User Wallet']);
        } else {
            $total = $user_deatil->wallet - $wallet_amount;
            $update = DB::table('users_master')
                ->where('reg_no', $reg_no)
                ->update(['wallet' => $total, 'updated_at' => $this->updated_at]);

            if ($update) {
                $admin_detail = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->first();

                $transaction_id = 'TN' . str_replace(".", "", microtime(true)) . rand(100, 999);

                $create_withdraw_history = [
                    'transaction_id' => $transaction_id,
                    'reg_no' => $reg_no,
                    'full_name' => $user_deatil->full_name,
                    'transfer_type' => $utrrefno . ' | Reedem By ' . $admin_detail->name,
                    'bank_name' => "NA",
                    'account_no' => "NA",
                    'ifsc' => "NA",
                    'phone_pay_mobile' => $user_deatil->phone_pay_mobile,
                    'google_pay_mobile' => $user_deatil->google_pay_mobile,
                    'paytm_pay_mobile' => $user_deatil->paytm_pay_mobile,
                    'amount' => $wallet_amount,
                    'status' => 'SUCCESS',
                    'status_msg' => 'Successful added in Wallet',
                    'isRollBack' => 'NO',
                    'source' => $user_deatil->source,
                    'created_at' => $this->updated_at,
                    'updated_at' => $this->updated_at,
                ];

                $return_id = DB::table('withdraw_history_master')->insertGetId($create_withdraw_history);

                if (isset($return_id)) {
                    DB::table('transaction_master')->insert([
                        'type' => 'Debit',
                        'reg_no' => $reg_no,
                        'mobile' => $user_deatil->mobile,
                        'refno' => $utrrefno . ' | Reedem By ' . $admin_detail->name,
                        'full_name' => $user_deatil->full_name,
                        'amount' => $wallet_amount,
                        'status' => 'SUCCESS',
                        'source' => $user_deatil->source,
                        'created_at' => $this->updated_at,
                        'updated_at' => $this->updated_at,
                    ]);

                    return response()->json(['code' => 1, 'msg' => 'Wallet Updated SUCCESS']);
                } else {
                    return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
                }
            } else {
                return response()->json(['code' => 0, 'msg' => 'Somting went to wrong please try after some time.']);
            }
        }
    }

    public function user_transaction(Request $request)
    {
        $data['page_title'] = 'Players Transaction Report';
        $data['user_deatil']=DB::table('users_master')->where('reg_no', $request->regno)->first();

        return view('admin.users.transaction-list-index', $data);
    }

    public function user_transaction_data(Request $request)
    {
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);
        $reg_no=$request->reg_no;
     
        $columns = [
            0 => 'id',
            1 => 'type',
            2 => 'refno',
            3 => 'reg_no',
            4 => 'mobile',
            5 => 'full_name',
            6 => 'amount',
            7 => 'status',
            9 => 'source',
            10 => 'created_at',
            11 => 'updated_at',
        ];

        $totalData = DB::table('transaction_master')
            ->where('reg_no',$reg_no)
            ->whereIn('source', $product)
            ->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('transaction_master')
                ->where('reg_no',$reg_no)
                ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('transaction_master')
                ->where('reg_no',$reg_no)
                ->whereIn('source', $product)
                ->where(function ($query) use ($search) {
                    return $query
                        ->where('id', 'LIKE', "%{$search}%")
                        ->orWhere('reg_no', 'LIKE', "%{$search}%")
                        ->orWhere('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%")
                        ->orWhere('amount', 'LIKE', "%{$search}%")
                        ->orWhere('created_at', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('transaction_master')
                ->whereIn('source', $product)
                ->where('reg_no',$reg_no)
                ->where(function ($query) use ($search) {
                    return $query
                        ->where('id', 'LIKE', "%{$search}%")
                        ->orWhere('reg_no', 'LIKE', "%{$search}%")
                        ->orWhere('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%")
                        ->orWhere('amount', 'LIKE', "%{$search}%")
                        ->orWhere('created_at', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
            
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['type'] = $post->type;
                $nestedData['refno'] = $post->refno;
                $nestedData['reg_no'] = $post->reg_no;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['full_name'] = $post->full_name;
                $nestedData['amount'] = $post->amount;
                $nestedData['status'] = $post->status;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at '] = $post->updated_at;
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

    public function user_market(Request $request)
    {
        $data['page_title'] = 'Players Market Report';
        $data['user_deatil']=DB::table('users_master')->where('reg_no', $request->regno)->first();
        return view('admin.users.list-market-play-index', $data);
    }

    public function user_market_play_data(Request $request)
    {
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);
        
        $reg_no=$request->reg_no;
   
        $columns = [
            0 => 'id',
            1 => 'reg_no',
            2 => 'lottery_date',
            3 => 'lottery_day',
            4 => 'lottery_name',
            5 => 'lottery_game_type',
            6 => 'lottery_category_type',
            7 => 'lottery_numbers',
            8 => 'result_number',
            9 => 'lottery_rate',
            10 => 'lottery_amount',
            11 => 'won_lottery_amount',
            12 => 'status',
            13 => 'isTransfer',
            14 => 'source',
            15 => 'created_at',
            16 => 'updated_at',
        ];

        $totalData = DB::table('lottery_result_master')->where('reg_no',$reg_no)->whereIn('source', $product)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('lottery_result_master')
                ->where('reg_no',$reg_no)
                ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('lottery_result_master')
                ->where('reg_no',$reg_no)
                ->whereIn('source', $product)
                ->Where('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('lottery_date', 'LIKE', "%{$search}%")
                ->orWhere('lottery_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('lottery_result_master')
                ->where('reg_no',$reg_no)
                ->whereIn('source', $product)
                ->Where('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('lottery_date', 'LIKE', "%{$search}%")
                ->orWhere('lottery_name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {

                $lottery_game_type="";

                if($post->lottery_game_type =='Jodi')
                {
                    $lottery_game_type="Open";
                }else
                {
                    $lottery_game_type=$post->lottery_game_type;
                }


                $nestedData['id'] = $key + 1 + $start;
                $nestedData['reg_no'] = $post->reg_no;
                $nestedData['lottery_date'] = $post->lottery_date;
                $nestedData['lottery_day'] = $post->lottery_day;
                $nestedData['lottery_name'] = $post->lottery_name;
                $nestedData['lottery_game_type'] = $lottery_game_type;
                $nestedData['lottery_category_type'] = $post->lottery_category_type;
                $nestedData['lottery_numbers'] = $post->lottery_numbers;
                $nestedData['result_number'] = $post->result_number;
                $nestedData['lottery_rate'] = $post->lottery_rate;
                $nestedData['lottery_amount'] = $post->lottery_amount;
                $nestedData['won_lottery_amount'] = $post->won_lottery_amount;
                $nestedData['status'] = $post->status;
                $nestedData['isTransfer'] = $post->isTransfer;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->created_at;
                
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

    public function user_blocked(Request $request)
    {

            $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();

            if ($user_deatil->user_type ="SuperAdmin") {
                 $regno=$request->regno;

                 $user_deatil = DB::table('users_master')
                ->where('reg_no', $regno)
                ->first();

                if(empty($user_deatil))
                {
                     return redirect()
                    ->back()
                    ->with('error', 'User Not Found')
                    ->withInput();

                }else
                {
                    switch ($user_deatil->status) {
                        case 'Enable':
                            DB::table('users_master')->where('reg_no', $regno)
                            ->update(['status' => 'Disable', 'updated_at' => $this->updated_at]);
                            return redirect('admin/user-profile/'.$regno)->with('success', 'User Bloked Successfully');
                            break;
                        
                       case 'Disable':
                             DB::table('users_master')->where('reg_no', $regno)
                            ->update(['status' => 'Enable', 'updated_at' => $this->updated_at]);
                             return redirect('admin/user-profile/'.$regno)->with('success', 'User UnBlocked Successfully');
                            break;
                        
                    }
                }


            }else
            {


                return redirect()
                    ->back()
                    ->with('error', 'Only Super Admin Bloked Users')
                    ->withInput();

            }
        
       
       
        
    }
}
