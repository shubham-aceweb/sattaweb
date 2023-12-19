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
use App\Models\Market;
use Illuminate\Support\Str;
use Session;
/**
 *
 * @package App\Http\Controllers
 */
class LotteryController extends Controller
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

    public function add_new_lottery(Request $request)
    {
        $data['page_title'] = 'Register New Lottery';
        $data['today_date'] = $this->current_date;
        return view('admin.lottery.add-new-lottery', $data);
    }

    public function save_lottery_name(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lottery_date' => 'required',
                'lottery_name' => 'required',
                'open_time' => 'required',
                'close_time' => 'required',
            ],
            [
                'lottery_date.required' => 'Lottery Date Required',
                'lottery_name.required' => 'Lottery Name Required',
                'open_time.required' => 'Open Time Required',
                'close_time.required' => 'Close Time Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            $check_game_rate = DB::table('lottery_name_master')
                ->where('lottery_name', $request->lottery_name)
                ->first();
            if (!empty($check_game_rate)) {
                return redirect()
                    ->back()
                    ->with('error', 'Lottery Name already exists.');
            }

            $date = new Carbon($request->lottery_date);

            $data = [
                'position' => 0,
                'lottery_date' => $request->lottery_date,
                'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                'lottery_name' => $request->lottery_name,
                'open_pana' => "***",
                'jodi' => "**",
                'close_pana' => "***",
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'slug' => Str::slug($request->lottery_name),
                'lottery_week_day' => strtoupper($request->lottery_week_day),
                'status' => 'Open',
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];

            $retur_id = DB::table('lottery_name_master')->insertGetId($data);
            if (isset($retur_id)) {
                DB::table('lottery_name_master')
                    ->where('id', $retur_id)
                    ->update(['position' => $retur_id]);
                $user_deatil = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->first();
                $product = explode(',', $user_deatil->product);
                $market = $user_deatil->market . ',' . $request->lottery_name;

                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['market' => $market]);

                return redirect('admin/open-close-lottery-list')->withSuccess('Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }

    public function open_close_lottery_list(Request $request)
    {
        $data['page_title'] = 'Lotery Result Status';
        $data['lottery_open_count'] = DB::table('lottery_name_master')->where('status', 'Open')->count();
        $data['lottery_close_count'] = DB::table('lottery_name_master')->where('status', 'Close')->count();
        $data['lottery_close_holiday'] = DB::table('lottery_name_master')->where('status', 'Disable')->count();
        $data['lottery_close_deactive'] = DB::table('lottery_name_master')->where('status', 'Deactive')->count();
        return view('admin.lottery.open-close-lottery-list', $data);
    }

    public function open_close_lottery_list_data(Request $request)
    {
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $product = explode(',', $user_deatil->product);
        $market = explode(',', $user_deatil->market);
        $columns = [
            0 => 'id',
            1 => 'position',
            2 => 'lottery_date',
            3 => 'lottery_day',
            4 => 'lottery_name',
            5 => 'open_pana',
            6 => 'jodi',
            7 => 'close_pana',
            8 => 'open_time',
            9 => 'close_time',
            10 => 'date',
            11 => 'status',
            12 => 'created_at',
            13 => 'updated_at',
        ];

        $totalData = DB::table('lottery_name_master')
            ->whereIn('lottery_name', $market)
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('lottery_name_master')
                ->whereIn('lottery_name', $market)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('lottery_name_master')
                ->whereIn('lottery_name', $market)
                ->Where('lottery_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('lottery_name_master')
                ->whereIn('lottery_name', $market)
                ->Where('lottery_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $nestedData['id'] = $post->id;
                $nestedData['position'] = $post->position;
                $nestedData['lottery_date'] = $post->lottery_date;
                $nestedData['lottery_day'] = $post->lottery_day;
                $nestedData['lottery_name'] = $post->lottery_name;
                $nestedData['open_pana'] = $post->open_pana;
                $nestedData['jodi'] = $post->jodi;
                $nestedData['close_pana'] = $post->close_pana;
                $nestedData['open_time'] = $post->open_time;
                $nestedData['close_time'] = $post->close_time;
                $nestedData['lottery_week_day'] = $post->lottery_week_day;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = $post->created_at; //date('j M Y h:i a', strtotime($post->created_at))
                $nestedData['updated_at'] = $post->created_at; //date('j M Y h:i a', strtotime($post->created_at))
                if ($user_deatil->user_type == "SuperAdmin") {
                    $nestedData['action'] =

                        '<a href="' .
                        url('admin/edit-lottery', ['id' => $post->id]) .
                        '" class="btn btn-primary btn-sm">Edit</a>'.' '.
                        '<button type="button" class="contractModal btn btn-success btn-sm"  data-num="' .
                        $post->lottery_name .
                        ' "lucky_number_otc="' .
                        $post->lucky_number_otc .
                        '"lucky_number_jodi="' .
                        $post->lucky_number_jodi .
                        '"lucky_number_patti="' .
                        $post->lucky_number_patti .
                        '"lucky_number_passing="' .
                        $post->lucky_number_passing .
                        '"data-toggle="modal"  data-target="#contractModal">Lucky Number</button>';
                } else {
                    $nestedData['action'] = '<a target="_blank" href="' . url('admin/lottery-result-history') . '" class="btn btn-danger btn-sm mb-1" id="withdraw_amount_fail_button">Reuslt History</a>';
                }

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

    public function open_close_lottery_list_data_reorder(Request $request)
    {
        foreach ($request->input('rows', []) as $row) {
            Market::find($row['id'])->update([
                'position' => $row['position'],
            ]);
        }

        return response()->noContent();
    }

    public function wining_lottery_result(Request $request)
    {

        $currentDate = now()->format('Y-m-d');
        DB::table('today_game_date_master')->update([
        'date' => $currentDate,
        ]);

        // dd($dateUpdate);

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        if ($user_deatil->user_type !="SuperAdmin") {
            Session::flush();
            Auth::logout();
            return Redirect('/');
                return redirect()
                    ->back()
                    ->with('error', 'Access Denied');
            
        }

            $data['page_title'] = 'Wining Lottery Result';
            $id = $request->id;
            $today_game_date = DB::table('today_game_date_master')->first();
            $data['today_date'] = $today_game_date->date;
            //$data['today_date'] = date('Y-m-d');
            $data['lottery_list'] = DB::table('lottery_name_master')
                ->where('status', '!=', 'Deactive')
                ->orderBy('lottery_name', 'ASC')
                ->get();


            $data['today_result_history'] = DB::table('lottery_result_history_master')
                ->orderBy('updated_at', 'DESC')
                ->whereDate('lottery_date', $today_game_date->date)
                ->get();
            return view('admin.lottery.wining-lottery', $data);


        
    }
    public function wining_lottery_result_update(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'lottery_date' => 'required',
                'lottery_name' => 'required',
                'open_pana' => 'required',
                'jodi' => 'required',
                'close_pana' => 'required',
            ],
            [
                'lottery_date.required' => 'Lottery Date required',
                'lottery_name.required' => 'Lottery Name required',
                'open_pana.required' => 'Open Pana Number Must be 3 Digit Numbers',
                'jodi.required' => 'Jodi Number Must be 2 Digit Numbers',
                'close_pana.required' => 'Close Pana Number Must be 3 Digit Numbers',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            $lottery_detail = DB::table('lottery_name_master')
                ->where('lottery_name', $request->lottery_name)
                
                ->first();
            if (empty($lottery_detail)) {
                return redirect()
                    ->back()
                    ->with('error', 'Lottery Name not exists.');
            }

            $data = [
                'lottery_date' => $request->lottery_date,
                'open_pana' => $request->open_pana,
                'jodi' => $request->jodi,
                'close_pana' => $request->close_pana,
                'status' => 'Open',
                'updated_at' => $this->current_date_time,
            ];

            if ($request->open_pana != '***' && $request->close_pana != '***') {
                $data = [
                    'lottery_date' => $request->lottery_date,
                    'open_pana' => $request->open_pana,
                    'jodi' => $request->jodi,
                    'close_pana' => $request->close_pana,
                    'status' => 'Close',
                    'updated_at' => $this->current_date_time,
                ];
            }

            $update = DB::table('lottery_name_master')
                ->where('lottery_name', $request->lottery_name)
                ->update($data);

            if ($update) {
                if ($request->open_pana != '***') {
                    $check_history = DB::table('lottery_result_history_master')
                        ->where('lottery_date', $request->lottery_date)
                        ->where('lottery_name', $request->lottery_name)
                        ->first();
                    if (empty($check_history)) {
                        $date = new Carbon($request->lottery_date);
                        $sum_open_pana = array_sum(str_split($request->open_pana));
                        $open = substr($sum_open_pana, -1);
                        $sum_close_pana = array_sum(str_split($request->close_pana));
                        $close = substr($sum_close_pana, -1);

                        $data = [
                            'lottery_date' => $request->lottery_date,
                            'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                            'lottery_name' => $request->lottery_name,
                            'open' => $open,
                            'open_pana' => $request->open_pana,
                            'jodi' => $request->jodi,
                            'close_pana' => $request->close_pana,
                            'close' => $close,
                            'open_time' => $lottery_detail->open_time,
                            'close_time' => $lottery_detail->close_time,
                            'status' => 'Close',
                            'created_at' => $this->current_date_time,
                            'updated_at' => $this->current_date_time,
                        ];

                        DB::table('lottery_result_history_master')->insertGetId($data);
                    } else {
                        $sum_open_pana = array_sum(str_split($request->open_pana));
                        $open = substr($sum_open_pana, -1);
                        $sum_close_pana = array_sum(str_split($request->close_pana));
                        $close = substr($sum_close_pana, -1);

                        $data = [
                            'open' => $open,
                            'open_pana' => $request->open_pana,
                            'jodi' => $request->jodi,
                            'close_pana' => $request->close_pana,
                            'close' => $close,
                            'status' => 'Close',
                            'updated_at' => $this->current_date_time,
                        ];
                        DB::table('lottery_result_history_master')
                            ->where('lottery_date', $request->lottery_date)
                            ->where('lottery_name', $request->lottery_name)
                            ->update($data);
                    }
                }


                

                $this->declarePlayerResult($request->lottery_name, $request->lottery_date);

                return redirect('admin/wining-lottery-result')->withSuccess('Lottery Result Submited Sucessfully');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }

    public function generate_lucky_number(Request $request)
    {
        $lottery_name = $request->lottery_name;
        $otc = $request->otc;
        $jodi = $request->jodi;
        $patti = $request->patti;
        $passing = $request->passing;
        $lottery_detail = DB::table('lottery_name_master')
            ->where('lottery_name', $lottery_name)
            ->first();
        if (empty($lottery_detail)) {
            return response()->json(['code' => 0, 'msg' => 'Lottery Name Not Found']);
        } else {

            if (empty($otc)) {
                $otc="NA";
            }

            if (empty($jodi)) {
                $jodi="NA";
            }

            if (empty($patti)) {
                $patti="NA";
            }

            if (empty($passing)) {
                $passing="NA";
            }


            $data = [
                'lucky_number_otc' => $otc,
                'lucky_number_jodi' => $jodi,
                'lucky_number_patti' => $patti,
                'lucky_number_passing' => $passing,
                'lucky_number_genratedby' => 'superadmin',
                'updated_at' => $this->current_date_time,
            ];
            $update = DB::table('lottery_name_master')
                ->where('lottery_name', $lottery_name)
                ->update($data);

            if ($update) {
                return response()->json(['code' => 1, 'msg' => 'Update Sucessfully']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong. Please try again']);
            }
        }
    }

    public function declarePlayerResult($lottery_name, $lottery_date)
    {
        $lottery_result_history_detail = DB::table('lottery_result_history_master')
            ->where('lottery_name', $lottery_name)
            ->where('lottery_date', $lottery_date)
            ->first();

        if (!empty($lottery_result_history_detail)) {
            $lottery_result_list = DB::table('lottery_result_master')

                ->where('lottery_date', $lottery_result_history_detail->lottery_date)
                ->where('lottery_name', $lottery_result_history_detail->lottery_name)
                ->where('open_time', $lottery_result_history_detail->open_time)
                ->where('close_time', $lottery_result_history_detail->close_time)
                ->where('status', 'PENDING')
                ->get();

            if (count($lottery_result_list) > 0) {
                foreach ($lottery_result_list as $key => $value) {
                    if ($lottery_result_history_detail->open_pana !== "***") {
                        if ($value->lottery_category_type == "Single Digit" && ($value->lottery_game_type = "Open")) {
                            if ($lottery_result_history_detail->open == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Single Pana" && ($value->lottery_game_type = "Open")) {
                            if ($lottery_result_history_detail->open_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Double Pana" && ($value->lottery_game_type = "Open")) {
                            if ($lottery_result_history_detail->open_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Triple Pana" && ($value->lottery_game_type = "Open")) {
                            if ($lottery_result_history_detail->open_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->open_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }
                    }

                    if ($lottery_result_history_detail->open_pana !== "***" && $lottery_result_history_detail->close_pana !== "***") {
                        if ($value->lottery_category_type == "Single Digit" && ($value->lottery_game_type = "Close")) {
                            if ($lottery_result_history_detail->close == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Single Pana" && ($value->lottery_game_type = "Close")) {
                            if ($lottery_result_history_detail->close_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Double Pana" && ($value->lottery_game_type = "Close")) {
                            if ($lottery_result_history_detail->close_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Triple Pana" && ($value->lottery_game_type = "Close")) {
                            if ($lottery_result_history_detail->close_pana == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->close_pana, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }

                        if ($value->lottery_category_type == "Jodi" && ($value->lottery_game_type = "Jodi")) {
                            if ($lottery_result_history_detail->jodi == $value->lottery_numbers) {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->jodi, 'status' => 'WIN', 'isTransfer' => 'YES', 'updated_at' => $this->current_date_time]);
                            } else {
                                DB::table('lottery_result_master')
                                    ->where('id', $value->id)
                                    ->update(['result_number' => $lottery_result_history_detail->jodi, 'status' => 'LOSS', 'isTransfer' => 'NO', 'updated_at' => $this->current_date_time]);
                            }
                        }
                    }
                }
            }
        }

        
    }

    public function wining_lottery_result_last_update(Request $request)
    {
        $lottery_name = $request->lottery_name;
        $lottery_date = $request->lottery_date;
        $lottery_result_history = DB::table('lottery_result_history_master')
            ->where('lottery_name', $lottery_name)
            ->whereDate('lottery_date', $lottery_date)
            ->first();
        if (empty($lottery_result_history)) {
            return response()->json(['open_pana' => '', 'close_pana' => '', 'jodi' => '']);
        } else {
            if ($lottery_result_history->close_pana == "***") {
                return response()->json(['open_pana' => $lottery_result_history->open_pana, 'close_pana' => "", 'jodi' => $lottery_result_history->jodi]);
            } else {
                return response()->json(['open_pana' => $lottery_result_history->open_pana, 'close_pana' => $lottery_result_history->close_pana, 'jodi' => $lottery_result_history->jodi]);
            }
        }
    }

   

    public function edit_lottery(Request $request)
    {
        // dd("fdsfsd");

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        if ($user_deatil->user_type !="SuperAdmin") {
            Session::flush();
            Auth::logout();
            return Redirect('/');
                return redirect()
                    ->back()
                    ->with('error', 'Access Denied');
            
        }
        $data['page_title'] = 'Upadte Lottery Lottery';
        $id=$request->id;
        $data['lottery_detail']= DB::table('lottery_name_master')
            ->where('id', $id)
            ->first();

        return view('admin.lottery.edit-lottery', $data);
    }

    public function edit_winning_lottery(Request $request)
    {
        // dd("fdsfsd");

        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        if ($user_deatil->user_type !="SuperAdmin") {
            Session::flush();
            Auth::logout();
            return Redirect('/');
                return redirect()
                    ->back()
                    ->with('error', 'Access Denied');
            
        }
        $data['page_title'] = 'Upadte Lottery Lottery';
        $id=$request->id;
        
        $data['lottery_detail']= DB::table('lottery_result_history_master')
            ->where('id', $id)
            ->first();
        // dd($data['winning_lottery_detail']);

        return view('admin.lottery.edit-winning-lottery', $data);
    }

    public function lottery_update_data(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'open_time' => 'required',
                'close_time' => 'required',
                'lottery_week_day' => 'required',
                'status' => 'required',
            ],
            [   
                'open_time.required' => 'Open Time Required',
                'close_time.required' => 'Close Time Required',
                'lottery_week_day.required' => 'Week Day Required',
                'status.required' => 'Status is Required',
            ]
        );



        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }else
        {

            

            $lottery_detail = DB::table('lottery_name_master')->Where('id',$request->id)->first();
            // dd($lottery_detail);
            $date = new Carbon($request->lottery_date);

            switch ($request->status) {
                case 'Update':
                    $data = [
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                        'lottery_date' => $this->current_date,
                        'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                        'open_pana' => $lottery_detail->open_pana,
                        'jodi' => $lottery_detail->jodi,
                        'close_pana' => $lottery_detail->close_pana,
                        'lottery_week_day' => $request->lottery_week_day,
                        'status' => $request->status,
                        'updated_at' => $this->current_date_time,
                    ];
                    break;
                
               case 'Close':
                    $data = [
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                        'lottery_date' => $this->current_date,
                        'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                        'open_pana' => $lottery_detail->open_pana,
                        'jodi' => $lottery_detail->jodi,
                        'close_pana' => $lottery_detail->close_pana,
                        'lottery_week_day' => $request->lottery_week_day,
                        'status' => "Close",
                        'updated_at' => $this->current_date_time,
                    ];

                    break;
                 

                 case 'Disable':
                    $data = [
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                        'lottery_week_day' => $request->lottery_week_day,
                        'status' => "Disable",
                    ];
                    break;
                case 'Deactive':
                    $data = [
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                        'lottery_date' => $this->current_date,
                        'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                        'open_pana' => "***",
                        'jodi' => "**",
                        'close_pana' => "***",
                        'lottery_week_day' => $request->lottery_week_day,
                        'status' => "Deactive",
                        'updated_at' => $this->current_date_time,
                    ];
                    
                    break;
                    break;
            }

           

            $update = DB::table('lottery_name_master')->Where('id',$request->id)->update($data);

            if ($update) {
                return redirect('admin/open-close-lottery-list')->withSuccess('Update Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }

    }

    public function winning_lottery_update_data(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'open_time' => 'required',
                'close_time' => 'required',
                // 'open_pana' => 'required',
                // 'status' => 'required',
            ],
            [   
                'open_time.required' => 'Open Time Required',
                'close_time.required' => 'Close Time Required',
                // 'lottery_week_day.required' => 'Week Day Required',
                // 'status.required' => 'Status is Required',
            ]
        );



        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }else
        {
            $lottery_detail = DB::table('lottery_result_history_master')->Where('id',$request->id)->first();
            if ($lottery_detail) {
                $data = [
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                        'lottery_date' => $this->current_date,
                        
                        'open_pana' => $request->open_pana,
                        'jodi' => $request->jodi,
                        'close_pana' => $request->close_pana,
                        'updated_at' => $this->current_date_time,
                    ];
            }
                // dd($data);

            // dd($lottery_detail);
            $date = new Carbon($request->lottery_date);

          
            if (!empty($data)) {
               
            $update = DB::table('lottery_result_history_master')->Where('id',$request->id)->update($data);
            if ($update) {

                return redirect('admin/wining-lottery-result')->withSuccess('Update Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
        }

    }
}
