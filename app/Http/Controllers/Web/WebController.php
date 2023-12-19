<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Classes\ApiCrypterController;
use App\Classes\ApiValidationController;
use App\Models\User;
use View;
use Illuminate\Support\Str;
use Carbon\Carbon;
class WebController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->current_date_time = date("Y-m-d H:i:s");
        $this->today = date("Y-m-d");
        $game_rate_master = DB::table('game_rate_master')
            ->where('status', 'Enable')
            ->get();
        View::share('game_rate_master', $game_rate_master);
    }

    public function home()
    {
        $now = Carbon::now();
        $current_time = $now->format('g:iA');
        $lottery_result = DB::table('lottery_name_master')
            ->orderBy('open_time', 'DESC')
            ->where('status', '!=', 'Deactive')
            ->where('status', '!=', 'Close')
            ->get();
        $live_market_list = [];
        foreach ($lottery_result as $key => $value) {
            $temp = [];
            $currenttime = strtotime($current_time);
            if ($value->open_pana != "***") {
                $temp['market_name'] = $value->lottery_name;
                $temp['result'] = $value->open_pana . '-' . $value->jodi . '-' . $value->close_pana;
                $live_market_list[] = $temp;
            } else {
                $temp['market_name'] = $value->lottery_name;
                $open_time = strtotime((new Carbon($value->open_time))->format('g:iA'));

                $loding_time_before_from = strtotime((new Carbon($value->open_time))->subMinutes(10)->format('g:iA'));
                if ($currenttime > $loding_time_before_from) {
                    $temp['result'] = "Loading";
                    $live_market_list[] = $temp;
                }
            }
        }

        $data['live_result'] = $live_market_list;

        $prev_date = Carbon::now()
            ->subDays(1)
            ->format('Y-m-d');
        $today_date = Carbon::now()->format('Y-m-d');
        $lottery_result_live = DB::table('lottery_name_master')
            ->orderBy('position', 'ASC')
            ->where('status', '!=', 'Deactive')
            ->get();
        $old_new_record = [];

        foreach ($lottery_result_live as $key => $value) {
            $temp = [];

            $lottery_result_today = DB::table('lottery_result_history_master')
                ->where('lottery_name', $value->lottery_name)
                ->whereDate('lottery_date', $today_date)
                ->first();
            if (!empty($lottery_result_today)) {
                $temp['trpe'] = "Today";
                $temp['slug'] = $value->slug;
                $temp['lottery_name'] = $lottery_result_today->lottery_name;
                $temp['open_pana'] = $lottery_result_today->open_pana;
                $temp['jodi'] = $lottery_result_today->jodi;
                $temp['close_pana'] = $lottery_result_today->close_pana;
                $temp['open_time'] = $lottery_result_today->open_time;
                $temp['close_time'] = $lottery_result_today->close_time;
                $old_new_record[] = $temp;
            } else {
                $lottery_result_old = DB::table('lottery_result_history_master')
                    ->where('lottery_name', $value->lottery_name)
                    ->orderBy('lottery_date', 'DESC')
                    ->whereDate('lottery_date', '<', $today_date)
                    ->first();
                if (!empty($lottery_result_old)) {
                    $temp['trpe'] = "BackDate";
                    $temp['slug'] = $value->slug;
                    $temp['lottery_name'] = $lottery_result_old->lottery_name;
                    $temp['open_pana'] = $lottery_result_old->open_pana;
                    $temp['jodi'] = $lottery_result_old->jodi;
                    $temp['close_pana'] = $lottery_result_old->close_pana;
                    $temp['open_time'] = $lottery_result_old->open_time;
                    $temp['close_time'] = $lottery_result_old->close_time;
                    $old_new_record[] = $temp;
                } else {
                    $lottery_today = DB::table('lottery_name_master')
                        ->where('lottery_name', $value->lottery_name)
                        ->first();
                    if (!empty($lottery_today)) {
                        $temp['slug'] = $lottery_today->slug;
                        $temp['lottery_name'] = $lottery_today->lottery_name;
                        $temp['open_pana'] = $lottery_today->open_pana;
                        $temp['jodi'] = $lottery_today->jodi;
                        $temp['close_pana'] = $lottery_today->close_pana;
                        $temp['open_time'] = $lottery_today->open_time;
                        $temp['close_time'] = $lottery_today->close_time;
                        $old_new_record[] = $temp;
                    }
                }
            }
        }

        $data['old_new_record'] = $old_new_record;

        $data['today_lucky_number'] = DB::table('lottery_name_master')
            ->where('status', '!=', 'Deactive')
            ->orderBy('position', 'ASC')
            ->get();
        $data['lottery_market'] = DB::table('lottery_name_master')
            ->where('status', '!=', 'Deactive')
            ->orderBy('position', 'ASC')
            ->get();

        return view('web1.home', $data);
    }

    public function jodi_records(Request $request)
    {
        $rednumber = ['11', '16', '22', '27', '33', '38', '44', '49', '55', '66', '61', '77', '72', '88', '99', '94', '00', '05'];
        $slug = $request->slug;
        $game_detail = DB::table('lottery_name_master')
            ->where('slug', $slug)
            ->first();

        if (!empty($game_detail)) {
            $data['gamename'] = $game_detail->lottery_name;
            $lottery_week_day_list = explode(',', $game_detail->lottery_week_day);
            $data['lottery_week_day'] = $lottery_week_day_list;
            $all_panel_record = DB::table('lottery_result_history_master')
                ->where('lottery_name', $game_detail->lottery_name)
                ->whereDate('lottery_date', '>=', '2023-04-19')
                ->orderBy('lottery_date', 'ASC')
                ->get();
            $lottery_week_day_add = count($lottery_week_day_list) - 1;
            $all_panel_record_other = [];
            if (count($all_panel_record) > 0) {
                $to = $all_panel_record[0]->lottery_date;
                foreach ($all_panel_record as $key => $value) {
                    $temp = [];
                    $end = Carbon::parse($to)
                        ->addDays($lottery_week_day_add)
                        ->format('Y-m-d');
                    $temp['range1'] = $to;
                    $temp['range2'] = $end;

                    $record_pana = [];
                    foreach ($lottery_week_day_list as $day) {
                        $temp1 = [];
                        $record = DB::table('lottery_result_history_master')
                            ->select('open_pana', 'jodi', 'close_pana')
                            ->where('lottery_name', $value->lottery_name)
                            ->where('lottery_day', $day)
                            ->whereBetween('lottery_date', [$to, $end])
                            ->first();
                        if (empty($record)) {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = "***";
                            $temp1['jodi'] = "**";
                            $temp1['close_pana'] = "***";
                        } else {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = $record->open_pana;
                            $temp1['jodi'] = $record->jodi;
                            $temp1['close_pana'] = $record->close_pana;
                        }
                        $record_pana[] = $temp1;
                    }

                    $temp['panel'] = $record_pana;
                    $all_panel_record_other[] = $temp;
                    $to = Carbon::parse($end)
                        ->addDays(1)
                        ->format('Y-m-d');

                    if ($to > $this->today) {
                        break;
                    }
                }
                $data['panel_record_list'] = $all_panel_record_other;
                $data['rednumber'] = $rednumber;
                return view('web1.jodi_record', $data);
            }
        } else {
            echo "Market Name Not Found or Weak Day Not Set";
        }
    }

    public function panel_records(Request $request)
    {
        // dd("dasdsad");
        $rednumber = ['11', '16', '22', '27', '33', '38', '44', '49', '55', '66', '61', '77', '72', '88', '99', '94', '00', '05'];
        $slug = $request->slug;
        $game_detail = DB::table('lottery_name_master')
            ->where('slug', $slug)
            ->first();
            // dd($game_detail);

        if (!empty($game_detail)) {
            $data['gamename'] = $game_detail->lottery_name;
            $lottery_week_day_list = explode(',', $game_detail->lottery_week_day);
            $data['lottery_week_day'] = $lottery_week_day_list;
            $all_panel_record = DB::table('lottery_result_history_master')
                ->where('lottery_name', $game_detail->lottery_name)
                ->whereDate('lottery_date', '>=', now())
                ->orderBy('lottery_date', 'ASC')
                ->get();
            // dd($all_panel_record);
            $lottery_week_day_add = count($lottery_week_day_list) - 1;
            $all_panel_record_other = [];
            if (count($all_panel_record) > 0) {
                $to = $all_panel_record[0]->lottery_date;
                foreach ($all_panel_record as $key => $value) {
                    $temp = [];
                    $end = Carbon::parse($to)
                        ->addDays($lottery_week_day_add)
                        ->format('Y-m-d');
                    $temp['range1'] = $to;
                    $temp['range2'] = $end;

                    $record_pana = [];
                    foreach ($lottery_week_day_list as $day) {
                        $temp1 = [];
                        $record = DB::table('lottery_result_history_master')
                            ->select('open_pana', 'jodi', 'close_pana')
                            ->where('lottery_name', $value->lottery_name)
                            ->where('lottery_day', $day)
                            ->whereBetween('lottery_date', [$to, $end])
                            ->first();
                        if (empty($record)) {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = "***";
                            $temp1['jodi'] = "**";
                            $temp1['close_pana'] = "***";
                        } else {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = $record->open_pana;
                            $temp1['jodi'] = $record->jodi;
                            $temp1['close_pana'] = $record->close_pana;
                        }
                        $record_pana[] = $temp1;
                    }

                    $temp['panel'] = $record_pana;
                    $all_panel_record_other[] = $temp;
                    $to = Carbon::parse($end)
                        ->addDays(1)
                        ->format('Y-m-d');

                    if ($to > $this->today) {
                        break;
                    }
                }
                $data['panel_record_list'] = $all_panel_record_other;
                $data['rednumber'] = $rednumber;
                return view('web1.panel_records', $data);
            }
        } else {
            echo "Market Name Not Found or Weak Day Not Set";
        }
    }

    public function app_panel_records(Request $request)
    {
        $rednumber = ['11', '16', '22', '27', '33', '38', '44', '49', '55', '66', '61', '77', '72', '88', '99', '94', '00', '05'];
        $slug = $request->slug;
        $game_detail = DB::table('lottery_name_master')
            ->where('slug', $slug)
            ->first();

        if (!empty($game_detail)) {
            $data['gamename'] = $game_detail->lottery_name;
            $lottery_week_day_list = explode(',', $game_detail->lottery_week_day);
            $data['lottery_week_day'] = $lottery_week_day_list;
            $all_panel_record = DB::table('lottery_result_history_master')
                ->where('lottery_name', $game_detail->lottery_name)
                ->whereDate('lottery_date', '>=', '2023-04-19')
                ->orderBy('lottery_date', 'ASC')
                ->get();
            $lottery_week_day_add = count($lottery_week_day_list) - 1;
            $all_panel_record_other = [];
            if (count($all_panel_record) > 0) {
                $to = $all_panel_record[0]->lottery_date;
                foreach ($all_panel_record as $key => $value) {
                    $temp = [];
                    $end = Carbon::parse($to)
                        ->addDays($lottery_week_day_add)
                        ->format('Y-m-d');
                    $temp['range1'] = $to;
                    $temp['range2'] = $end;

                    $record_pana = [];
                    foreach ($lottery_week_day_list as $day) {
                        $temp1 = [];
                        $record = DB::table('lottery_result_history_master')
                            ->select('open_pana', 'jodi', 'close_pana')
                            ->where('lottery_name', $value->lottery_name)
                            ->where('lottery_day', $day)
                            ->whereBetween('lottery_date', [$to, $end])
                            ->first();
                        if (empty($record)) {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = "***";
                            $temp1['jodi'] = "**";
                            $temp1['close_pana'] = "***";
                        } else {
                            $temp1['day'] = $day;
                            $temp1['open_pana'] = $record->open_pana;
                            $temp1['jodi'] = $record->jodi;
                            $temp1['close_pana'] = $record->close_pana;
                        }
                        $record_pana[] = $temp1;
                    }

                    $temp['panel'] = $record_pana;
                    $all_panel_record_other[] = $temp;
                    $to = Carbon::parse($end)
                        ->addDays(1)
                        ->format('Y-m-d');

                    if ($to > $this->today) {
                        break;
                    }
                }
                $data['panel_record_list'] = $all_panel_record_other;
                $data['rednumber'] = $rednumber;
                return view('web1.panel_records_app', $data);
            }
        } else {
            echo "Market Name Not Found or Weak Day Not Set";
        }
    }

    public function download_app_view(Request $request)
    {
        $appname = $request->appname;

        if ($appname == "com.bestsattamatka.gsboss") {
            $data['title'] = "GS Boss";
            $data['thumicon'] = "thumb1.png";
            $data['screen1'] = "screen1.jpg";
            $data['downloadlink'] = "https://www.bestsattamatka.net/public/apk/gsboss.apk";
            $data[
                'aboutus'
            ] = "All the information provided here and the number provided here are purely based on astrology and numerology & purpose of software is information only qhich are not connected to any illegal gambling. Please visit this app only on
            your risk we do not promote or advertise of any illegal Business. We are not responsible for any economical or any other damages happens due to this app. Please think twice before making any decision.";
            return view('web1.download_app', $data);
        }
        if ($appname == "com.bestsattamatka.dhanigames") {
            $data['title'] = "Dhani Game";
            $data['thumicon'] = "thumb2.png";
            $data['screen1'] = "screen2.jpg";
            $data['downloadlink'] = "https://www.bestsattamatka.net/public/apk/dhanigames.apk";
            $data[
                'aboutus'
            ] = "All the information provided here and the number provided here are purely based on astrology and numerology & purpose of software is information only qhich are not connected to any illegal gambling. Please visit this app only on
            your risk we do not promote or advertise of any illegal Business. We are not responsible for any economical or any other damages happens due to this app. Please think twice before making any decision.";
            return view('web1.download_app', $data);
        }
        if ($appname == "com.bestsattamatka.ndrgames") {
            $data['title'] = "Ndr Games";
            $data['thumicon'] = "thumb3.png";
            $data['screen1'] = "screen3.jpg";
            $data['downloadlink'] = "https://www.bestsattamatka.net/public/apk/ndrgames.apk";
            $data[
                'aboutus'
            ] = "All the information provided here and the number provided here are purely based on astrology and numerology & purpose of software is information only qhich are not connected to any illegal gambling. Please visit this app only on
            your risk we do not promote or advertise of any illegal Business. We are not responsible for any economical or any other damages happens due to this app. Please think twice before making any decision.";
            return view('web1.download_app', $data);
        }

        if ($appname == "com.bestsattamatka.famousonline") {
            $data['title'] = "Famous Online";
            $data['thumicon'] = "thumb4.png";
            $data['screen1'] = "screen4.jpg";
            $data['downloadlink'] = "https://www.bestsattamatka.net/public/apk/famousonline.apk";
            $data[
                'aboutus'
            ] = "All the information provided here and the number provided here are purely based on astrology and numerology & purpose of software is information only qhich are not connected to any illegal gambling. Please visit this app only on
            your risk we do not promote or advertise of any illegal Business. We are not responsible for any economical or any other damages happens due to this app. Please think twice before making any decision.";
            return view('web1.download_app', $data);
        }
    }
}
