<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Classes\FileUpload;


/**
 *
 * @package App\Http\Controllers
 */
class TransferLotteryAmountController extends Controller
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
        $this->today = date("Y-m-d");
    }

  

    public function user_lottery_result_amount(Request $request)
    {
         $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);
        $data['page_title'] = 'Player Result/Win Amount';
        $data['result_win_amount'] = DB::table('lottery_result_master')->whereIn('source', $product)
            ->where('isTransfer', 'YES')
            ->sum('won_lottery_amount');
        $market_list="";

       $pending_result_market = DB::table('lottery_result_master')->select('lottery_name')->whereIn('source', $product)->where('status', 'PENDING')->groupBy('lottery_name')->get();

       if (count($pending_result_market) > 0 ) {
          foreach ($pending_result_market as $key => $value) {
           $market_list = $market_list .' | '. $value->lottery_name;
        }

        $market_list = "Some Result Pending : ".$market_list;

       }else
       {
          $market_list  ="No Result Pending";
       }
       
        $data['pending_result_market']=$market_list;
        return view('admin.lotteryamounttransfer.list-index', $data);
    }

    public function user_lottery_result_amount_list_data(Request $request)
    {

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);
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

        $totalData = DB::table('lottery_result_master')->whereIn('source', $product)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('lottery_result_master')
                ->whereIn('source', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('lottery_result_master')
                ->whereIn('source', $product)
                ->Where('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('lottery_date', 'LIKE', "%{$search}%")
                ->orWhere('lottery_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('lottery_result_master')
                ->whereIn('source', $product)
                ->Where('reg_no', 'LIKE', "%{$search}%")
                ->orWhere('lottery_date', 'LIKE', "%{$search}%")
                ->orWhere('lottery_name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {

                $lottery_numbers_user=DB::table('lottery_result_master')->where('lottery_numbers', $post->lottery_numbers)->where('lottery_date',  $post->lottery_date)->whereIn('source', $product)->count();

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
                $nestedData['lottery_numbers_user'] = '<div class="blink_me">' .$lottery_numbers_user . '</div>';
                $nestedData['result_number'] = $post->result_number;
                $nestedData['lottery_rate'] = $post->lottery_rate;
                $nestedData['lottery_amount'] = $post->lottery_amount;
                $nestedData['won_lottery_amount'] = $post->won_lottery_amount;
                $nestedData['status'] = $post->status;
                $nestedData['isTransfer'] = $post->isTransfer;
                $nestedData['source'] = $post->source;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->created_at;
                $nestedData['action'] = '<a target="_blank" href="' . url('admin/user-profile', ['reg_no' => $post->reg_no]) . '" class="btn btn-danger btn-sm mb-1" id="withdraw_amount_fail_button">Profile</a>';
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
    public function user_lottery_result_amount_transfer(Request $request)
    {
        $result_amount_list = DB::table('lottery_result_master')
            ->where('isTransfer', 'YES')
            ->get()
            ->take(100);

        if(count($result_amount_list) <= 0)
        {
            return response()->json(['code' => 0, 'msg' => 'No Amount Pending For Transfer']);

        }else
        {
            foreach ($result_amount_list as $key => $value) {
            $player_detail = DB::table('users_master')
                ->where('reg_no', $value->reg_no)
                ->first();
            if (!empty($player_detail)) {
                $total = $player_detail->wallet + $value->won_lottery_amount;
                DB::table('users_master')
                    ->where('reg_no', $value->reg_no)
                    ->update(['wallet' => $total, 'updated_at' => $this->current_date_time]);
                DB::table('lottery_result_master')
                    ->where('id', $value->id)
                    ->update(['isTransfer' => 'DONE', 'updated_at' => $this->current_date_time]);
                }
            }
            return response()->json(['code' => 1, 'msg' => 'Lottery Wining Amount Transfer Sucessfully']);
        }
        
    }

   
}
