<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $trafic = DB::table('users_master')
            ->where(
                'created_at',
                '>',
                Carbon::now()
                    ->subHours(1)
                    ->toDateTimeString()
            )
        
            ->count();
        View::share('trafic', $trafic);
        date_default_timezone_set('Asia/Kolkata');
    }

    public function dashboard_view()
    {

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',',$user_deatil->product) ;
        $market = explode(',',$user_deatil->market);
        if (Auth::check()) {

            $data['user_count'] = DB::table('users_master')->whereIn('source', $product)->count();
            
          
            $data['lottery_open_count'] = DB::table('lottery_name_master')->whereIn('lottery_name', $market)->where('status', 'Open')->count();
            $data['lottery_close_count'] = DB::table('lottery_name_master')->whereIn('lottery_name', $market)->where('status', 'Close')->count();
            $data['lottery_close_deactive'] = DB::table('lottery_name_master')->whereIn('lottery_name', $market)->where('status', 'Deactive')->count();
            $data['lottery_win_amount'] = DB::table('lottery_result_master')->whereIn('source', $product)->where('status', 'WIN')->sum('won_lottery_amount');
            $data['lottery_loss_amount'] = DB::table('lottery_result_master')->whereIn('source', $product)->where('status', 'LOSS')->sum('won_lottery_amount');

            
            $data['trans_process_count1'] = DB::table('withdraw_history_master')->where('status', 'PROCESS')->whereIn('source', $product)->count();
            $data['trans_process_amount_sum1'] = DB::table('withdraw_history_master')->where('status', 'PROCESS')->whereIn('source', $product)->sum('amount');
            $data['trans_success_count1'] = DB::table('withdraw_history_master')->where('status', 'SUCCESS')->whereIn('source', $product)->count();
            $data['trans_success_amount_sum1'] = DB::table('withdraw_history_master')->where('status', 'SUCCESS')->whereIn('source', $product)->sum('amount');
             $data['trans_failure_count1'] = DB::table('withdraw_history_master')->where('status', 'FAILURE')->whereIn('source', $product)->count();
            $data['trans_failure_amount_sum1'] = DB::table('withdraw_history_master')->where('status', 'FAILURE')->whereIn('source', $product)->sum('amount');


            $data['trans_process_count2'] = DB::table('deposit_history_master')->where('status', 'PROCESS')->whereIn('source', $product)->count();
            $data['trans_process_amount_sum2'] = DB::table('deposit_history_master')->where('status', 'PROCESS')->whereIn('source', $product)->sum('amount');
            $data['trans_success_count2'] = DB::table('deposit_history_master')->where('status', 'SUCCESS')->whereIn('source', $product)->count();
            $data['trans_success_amount_sum2'] = DB::table('deposit_history_master')->where('status', 'SUCCESS')->whereIn('source', $product)->sum('amount');
             $data['trans_failure_count2'] = DB::table('deposit_history_master')->where('status', 'FAILURE')->whereIn('source', $product)->count();
            $data['trans_failure_amount_sum2'] = DB::table('deposit_history_master')->where('status', 'FAILURE')->whereIn('source', $product)->sum('amount');

          
            return view('admin.dashboard.dashboard_view', $data);
        } else {
            return redirect("/logout")->withSuccess('Access is not permitted');
        }
    }


}
