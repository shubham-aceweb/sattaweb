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
class ReportController extends Controller
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
        $this->current_date = date("Y-m-d");
    }

    public function search_product_report(Request $request)
    {
        $data['page_title'] = 'Genrate Agent Report';
        

        $today_game_date = DB::table('today_game_date_master')->first();
        $data['today_date'] = $today_game_date->date;



        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);
        $data['lottery_list'] = DB::table('lottery_name_master')
            ->orderBy('lottery_name', 'ASC')
            ->get();
        $data['product_list_master'] = DB::table('product_list_master')
            ->where('status', 'Enable')
            ->whereIn('name', $product)
            ->orderBy('name')
            ->get();
        return view('admin.report.search-product-report', $data);
    }
    public function search_product_report_data(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lottery_date' => 'required',
                'product_name' => 'required',
                'lottery_name' => 'required',
            ],
            [
                'lottery_date.required' => 'Lottery Date Required',
                'product_name.required' => 'Product name  Required',
                'lottery_name.required' => 'Lottery Name Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {

            $lottery_result=DB::table('lottery_result_history_master')->whereDate('lottery_date', $request->lottery_date)->first();
            if (empty($lottery_result)) {
                return redirect()
                    ->back()
                    ->with('error', 'No Record Found in Lottery History');
            }else
            {
                return redirect('admin/search-product-report-data-list/' . $request->lottery_date . '/' . $request->lottery_name . '/' . $request->product_name);
            }

            
            
        }
    }

    public function search_product_report_data_list(Request $request)
    {
        $totalcommission = 0;
        if ($request->product == "All") {
            $totalcommission = 10;
        } else {
            $user_deatil = DB::table('users')
                ->where('product', $request->product)
                ->first();
            $totalcommission = $user_deatil->commission;
        }

        $date = new Carbon($request->date);
        $lottery_day = strtoupper($date->shortEnglishDayOfWeek);
        $data['lottery_date'] = $request->date;
        $data['lottery_day'] = $date;
        $data['lotery_name'] = $request->loteryname;
        $data['product'] = $request->product;

        if ($request->loteryname == "All") {

            $lottery_list = DB::table('lottery_name_master')
                ->orderBy('position', 'ASC')
                ->get();

        } else {


            $lottery_list = DB::table('lottery_name_master')
                ->where('lottery_name', $request->loteryname)
                ->orderBy('position', 'ASC')
                ->get();
        }



        $lottery_list_other = [];
        $grand_total = 0;
        $grand_commission = 0;
        $grand_won_amount = 0;
        $grand_amount = 0;
        $grand_cr = 0;
        $grand_dr = 0;


        foreach ($lottery_list as $key => $value) {

            $value->report_date = $request->date;

            $lottery_result=DB::table('lottery_result_history_master')->where('lottery_name',$value->lottery_name)->whereDate('lottery_date', $request->date)->first();

            if (empty($lottery_result)) {
                $lotery_detail = DB::table('lottery_name_master')
                ->where('lottery_name', $value->lottery_name)
                ->whereDate('lottery_date', $request->date)
                ->first();
                if (!empty($lotery_detail)) {
                    $value->open_pana = $lotery_detail->open_pana;
                    $value->jodi = $lotery_detail->jodi;
                    $value->close_pana = $lotery_detail->close_pana;
                }else
                {
                    $value->open_pana = "***";
                    $value->jodi = "**";
                    $value->close_pana = "***";
                }
                
            }else
            {

                $value->open_pana = $lottery_result->open_pana;
                $value->jodi = $lottery_result->jodi;
                $value->close_pana = $lottery_result->close_pana;

            }


            if ($request->product == "All") {

                $amount = DB::table('lottery_result_master')
                    ->where('lottery_name', $value->lottery_name)
                    ->whereDate('lottery_date', $request->date)
                    ->sum('lottery_amount');
                $won_lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_name', $value->lottery_name)
                    ->whereDate('lottery_date', $request->date)
                    ->where('status','WIN')
                    ->sum('won_lottery_amount');
            } else {
                $amount = DB::table('lottery_result_master')
                    ->where('lottery_name', $value->lottery_name)
                    ->whereDate('lottery_date', $request->date)
                    ->where('source', $request->product)
                    ->sum('lottery_amount');

                $won_lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_name', $value->lottery_name)
                    ->whereDate('lottery_date', $request->date)
                    ->where('status','WIN')
                    ->where('source', $request->product)
                    ->sum('won_lottery_amount');
            }

            $value->amount = $amount;
            $value->won_lottery_amount = $won_lottery_amount;
            $commission = ($amount * $totalcommission) / 100;
            $value->commission = round($commission, 0);
            $total = $amount + round($commission, 0);
            $value->total = $total;
            $grand_amount = $grand_amount + $amount;
            $grand_won_amount = $grand_won_amount + $won_lottery_amount;
            $grand_total = $grand_total + $total;
            $grand_commission = $grand_commission + $commission;
            $dr =$amount -($won_lottery_amount + round($commission, 0));

            $cr =$amount -($won_lottery_amount + round($commission, 0));

            if ($dr < 0)
            {
                $value->dr=$dr;
                $grand_dr=$grand_dr+$dr;
            }else
            {
                $value->dr="-";
            }

            if ($cr > 0)
            {
                $value->cr=$cr;
                $grand_cr= $grand_cr+$cr; 
            }else
            {
                $value->cr="-";
            }

            $lottery_list_other[] = $value;
        }

        $data['lottery_history_list'] = $lottery_list_other;
        $data['grand_amount'] = $grand_amount;
        $data['grand_won_amount'] = $grand_won_amount;
        $data['grand_commission'] = $grand_commission;
        $data['grand_total'] = $data['grand_amount'] -($data['grand_won_amount']+$data['grand_commission']);
        $data['grand_cr'] = $grand_cr;
        $data['grand_dr'] = $grand_dr;
        return view('admin.report.agent-profile', $data);
    }

    public function search_market_report(Request $request)
    {
        $data['page_title'] = 'Genrate Market Report';
        $today_game_date = DB::table('today_game_date_master')->first();
        $data['today_date'] = $today_game_date->date;
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);
        $data['lottery_list'] = DB::table('lottery_name_master')
            ->orderBy('lottery_name', 'ASC')
            ->get();

        $data['product_list_master'] = DB::table('product_list_master')
            ->where('status', 'Enable')
            ->orderBy('name')
            ->get();
        return view('admin.report.search-market-report', $data);
    }

    public function search_market_report_data(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lottery_date' => 'required',
                'product_name' => 'required',
                'lottery_name' => 'required',
            ],
            [
                'lottery_date.required' => 'Lottery Date Required',
                'product_name.required' => 'Product name  Required',
                'lottery_name.required' => 'Lottery Name Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {




            $check_history = DB::table('lottery_name_master')
                ->where('lottery_name', $request->lottery_name)
                ->first();

            if (empty($check_history)) {
                return redirect()
                    ->back()
                    ->with('error', 'Lottery History Not Found for This Product.');
            } else {
                return redirect('admin/search-market-report-data-list/' . $request->lottery_date . '/' . $request->lottery_name . '/' . $request->product_name);
            }
        }
    }
     public function search_market_report_data_list(Request $request)
    {
        $date = new Carbon($request->date);
        $lottery_day = strtoupper($date->shortEnglishDayOfWeek);
        $data['lottery_date'] = $request->date;
        $data['lottery_day'] = $lottery_day;
        $data['lotery_name'] = $request->loteryname;
        $data['product'] = $request->product;



      
        $lottery_result=DB::table('lottery_result_history_master')->where('lottery_name',$request->loteryname)->whereDate('lottery_date', $request->date)->first();

            if (empty($lottery_result)) {
                $lotery_detail = DB::table('lottery_name_master')
                ->where('lottery_name', $request->loteryname)

                ->first();

                $data['open_pana']=$lotery_detail->open_pana;
                $data['jodi']=$lotery_detail->jodi;
                $data['close_pana']=$lotery_detail->close_pana;
                $data['open_time']=$lotery_detail->open_time;
                $data['close_time']=$lotery_detail->close_time;
                
            }else
            {

                $data['open_pana']=$lottery_result->open_pana;
                $data['jodi']=$lottery_result->jodi;
                $data['close_pana']=$lottery_result->close_pana;
                $data['open_time']=$lottery_result->open_time;
                $data['close_time']=$lottery_result->close_time;
                

                

            }


        


       
        
        if ($request->product == "All") {


            $single_record_open = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', 'Single Digit')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        } else {
            $single_record_open = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->where('source', $request->product)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', 'Single Digit')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        }

        

        $single_record_open_user_count_sum = 0;
        $single_record_open_other = [];


        foreach ($single_record_open as $key => $value) {


             if ($request->product == "All")
             {
                $value->lottery_numbers = $value->lottery_numbers;
                $lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Open')
                    ->whereDate('lottery_date', $request->date)
                    ->sum('lottery_amount');
                $value->lottery_amount =$lottery_amount;
                $value->user_count = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Open')
                    ->whereDate('lottery_date', $request->date)
                    ->count();
                $single_record_open_other[] = $value;
                $single_record_open_user_count_sum = $single_record_open_user_count_sum + $lottery_amount;
            }else
            {
                $value->lottery_numbers = $value->lottery_numbers;
                $lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->where('source', $request->product)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Open')
                    ->whereDate('lottery_date', $request->date)
                    ->sum('lottery_amount');
                $value->lottery_amount =$lottery_amount;
                $value->user_count = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->where('source', $request->product)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Open')
                    ->whereDate('lottery_date', $request->date)
                    ->count();
                $single_record_open_other[] = $value;
                $single_record_open_user_count_sum = $single_record_open_user_count_sum + $lottery_amount;
            }



            
        }

        $data['single_record_open_other'] = $single_record_open_other;
        $data['single_record_open_user_count_sum'] = $single_record_open_user_count_sum;



        if ($request->product == "All") {
            $pana_record_open = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', '!=', 'Jodi')
                ->where('lottery_category_type', '!=', 'Single Digit')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        } else {
            $pana_record_open = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('source', $request->product)
                ->where('lottery_category_type', '!=', 'Jodi')
                ->where('lottery_category_type', '!=', 'Single Digit')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        }

        $pana_record_open_user_count_sum = 0;
        $pana_record_open_other = [];
        foreach ($pana_record_open as $key => $value) {

            if ($request->product == "All")
             {


                    $value->lottery_numbers = $value->lottery_numbers;
                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->where('lottery_game_type', 'Open')
                        ->whereDate('lottery_date', $request->date)
                        ->sum('lottery_amount');

                    $value->lottery_amount =$lottery_amount;
                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->where('lottery_game_type', 'Open')
                        ->whereDate('lottery_date', $request->date)
                        ->count();
                    $pana_record_open_other[] = $value;

                    $pana_record_open_user_count_sum = $pana_record_open_user_count_sum + $lottery_amount;


             }else
             {
                    $value->lottery_numbers = $value->lottery_numbers;
                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('source', $request->product)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->where('lottery_game_type', 'Open')
                        ->whereDate('lottery_date', $request->date)
                        ->sum('lottery_amount');

                         $value->lottery_amount =$lottery_amount;
                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('source', $request->product)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->where('lottery_game_type', 'Open')
                        ->whereDate('lottery_date', $request->date)
                        ->count();
                    $pana_record_open_other[] = $value;

                    $pana_record_open_user_count_sum = $pana_record_open_user_count_sum + $lottery_amount;

             }


        }

        $data['pana_record_open_other'] = $pana_record_open_other;
        $data['pana_record_open_user_count_sum'] = $pana_record_open_user_count_sum;

        if ($request->product == "All") {
            $jodi_record = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', 'Jodi')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        } else {
            $jodi_record = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('source', $request->product)
                ->where('lottery_category_type', 'Jodi')
                ->where('lottery_game_type', 'Open')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        }

        $jodi_record_user_count_sum = 0;
        $jodi_record_other = [];
        foreach ($jodi_record as $key => $value) {

            if ($request->product == "All")
             {

                    $value->lottery_numbers = $value->lottery_numbers;
                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', 'Jodi')
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_game_type', 'Open')
                        ->sum('lottery_amount');

                    $value->lottery_amount= $lottery_amount;
                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_category_type', 'Jodi')
                        ->where('lottery_game_type', 'Open')
                        ->count();

                    $jodi_record_other[] = $value;
                    $jodi_record_user_count_sum = $jodi_record_user_count_sum + $lottery_amount;
             }else
             {

                $value->lottery_numbers = $value->lottery_numbers;
                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', 'Jodi')
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_game_type', 'Open')
                        ->where('source', $request->product)
                        ->sum('lottery_amount');

                    $value->lottery_amount= $lottery_amount;
                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_category_type', 'Jodi')
                        ->where('source', $request->product)
                        ->where('lottery_game_type', 'Open')
                        ->count();

                    $jodi_record_other[] = $value;
                    $jodi_record_user_count_sum = $jodi_record_user_count_sum + $lottery_amount;

             }

        }

        $data['jodi_record_other'] = $jodi_record_other;
        $data['jodi_record_user_count_sum'] = $jodi_record_user_count_sum;

        $single_record_close_user_count_sum = 0;

        if ($request->product == "All") {
            $single_record_close = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', 'Single Digit')
                ->where('lottery_game_type', 'Close')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        } else {
            $single_record_close = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('source', $request->product)
                ->where('lottery_category_type', 'Single Digit')
                ->where('lottery_game_type', 'Close')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        }

        $single_record_close_other = [];
        foreach ($single_record_close as $key => $value) {

            if ($request->product == "All")
             {

                $value->lottery_numbers = $value->lottery_numbers;
                $lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->whereDate('lottery_date', $request->date)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Close')
                    ->sum('lottery_amount');

                $value->lottery_amount= $lottery_amount;
                $value->user_count = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->whereDate('lottery_date', $request->date)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Close')
                    ->count();
                $single_record_close_other[] = $value;
                $single_record_close_user_count_sum = $single_record_close_user_count_sum + $lottery_amount;
             }else
             {

                $value->lottery_numbers = $value->lottery_numbers;
                $lottery_amount = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->whereDate('lottery_date', $request->date)
                    ->where('source', $request->product)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Close')
                    ->sum('lottery_amount');

                $value->lottery_amount= $lottery_amount;
                $value->user_count = DB::table('lottery_result_master')
                    ->where('lottery_numbers', $value->lottery_numbers)
                    ->where('lottery_name', $request->loteryname)
                    ->whereDate('lottery_date', $request->date)
                    ->where('source', $request->product)
                    ->where('lottery_category_type', 'Single Digit')
                    ->where('lottery_game_type', 'Close')
                    ->count();
                $single_record_close_other[] = $value;
                $single_record_close_user_count_sum = $single_record_close_user_count_sum + $lottery_amount;

             }



            
        }

        $data['single_record_close_other'] = $single_record_close_other;
        $data['single_record_close_user_count_sum'] = $single_record_close_user_count_sum;

        if ($request->product == "All") {
            $pana_record_close = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('lottery_category_type', '!=', 'Jodi')
                ->where('lottery_category_type', '!=', 'Single Digit')
                ->where('lottery_game_type', 'Close')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        } else {
            $pana_record_close = DB::table('lottery_result_master')
                ->select('lottery_numbers')
                ->where('lottery_name', $request->loteryname)
                ->whereDate('lottery_date', $request->date)
                ->where('source', $request->product)
                ->where('lottery_category_type', '!=', 'Jodi')
                ->where('lottery_category_type', '!=', 'Single Digit')
                ->where('lottery_game_type', 'Close')
                ->orderBy('lottery_numbers', 'ASC')
                ->groupBy('lottery_numbers')
                ->get();
        }

        $pana_record_close_user_count_sum = 0;
        $pana_record_close_other = [];
        foreach ($pana_record_close as $key => $value) {

               if ($request->product == "All")
             {

                    $value->lottery_numbers = $value->lottery_numbers;


                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_game_type', 'Close')
                        ->sum('lottery_amount');
                    $value->lottery_amount= $lottery_amount;

                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_game_type', 'Close')
                        ->count();
                    $pana_record_close_other[] = $value;
                    $pana_record_close_user_count_sum = $pana_record_close_user_count_sum + $lottery_amount;


             }else
                 {
                    $value->lottery_numbers = $value->lottery_numbers;


                    $lottery_amount = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->whereDate('lottery_date', $request->date)
                         ->where('source', $request->product)
                        ->where('lottery_game_type', 'Close')
                        ->sum('lottery_amount');
                    $value->lottery_amount= $lottery_amount;

                    $value->user_count = DB::table('lottery_result_master')
                        ->where('lottery_numbers', $value->lottery_numbers)
                        ->where('lottery_name', $request->loteryname)
                        ->where('lottery_category_type', '!=', 'Jodi')
                        ->where('lottery_category_type', '!=', 'Single Digit')
                        ->whereDate('lottery_date', $request->date)
                        ->where('lottery_game_type', 'Close')
                         ->where('source', $request->product)
                        ->count();
                    $pana_record_close_other[] = $value;
                    $pana_record_close_user_count_sum = $pana_record_close_user_count_sum + $lottery_amount;

                 }

        }

        $data['pana_record_close_other'] = $pana_record_close_other;
        $data['pana_record_close_user_count_sum'] = $pana_record_close_user_count_sum;
        $data['total_amount'] =$single_record_open_user_count_sum+$pana_record_open_user_count_sum+$jodi_record_user_count_sum+$single_record_close_user_count_sum+$pana_record_close_user_count_sum;
        $srcountarray = [];
        $srcountarray[] = count($single_record_open_other);
        $srcountarray[] = count($pana_record_open_other);
        $srcountarray[] = count($jodi_record_other);
        $srcountarray[] = count($single_record_close_other);
        $srcountarray[] = count($pana_record_close_other);
        $maxsrno = max($srcountarray);
        $data['maxsr'] = $maxsrno;

        return view('admin.report.market-profile', $data);
    }

    

    public function report_user_market_list(Request $request)
    {

        $data['page_title'] = 'User Market Play List';

       
    
        if ($request->product=="All") {
          $lottery_result = DB::table('lottery_result_master')->where('lottery_name', $request->name)->where('lottery_date', $request->date)->get();
        }else
        {
            $lottery_result = DB::table('lottery_result_master')->where('lottery_name', $request->name)->where('source', $request->product)->where('lottery_date', $request->date)->get();
        }

        
        $user_deatil = [];
        foreach ($lottery_result as $key => $value) {

            $userdetail=DB::table('users_master')->where('reg_no', $value->reg_no)->first();
            $value->full_name =   $userdetail->full_name;
            $value->mobile =   $userdetail->mobile;
            $value->wallet =   $userdetail->wallet;
            $value->source =   $userdetail->source;
            $user_deatil[] = $value;

        }
       $data['user_play_list']=$user_deatil;
       return view('admin.report.list-market-play-index', $data);
    }
}
