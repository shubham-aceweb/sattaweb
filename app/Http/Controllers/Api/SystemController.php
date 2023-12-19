<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Crypt;
use Carbon\Carbon;
use App\Classes\ApiValidationController;
use App\Classes\ApiCrypterController;
use Illuminate\Support\Facades\Storage;

class SystemController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->current_date_time = date("Y-m-d H:i:s");
        $this->today_date = date("Y-m-d");
    }
    public function reste_market_vr1()
    {
        $now = Carbon::now();
        $current_time = $now->format('g:iA');

        $check_any_market_is_open = DB::table('lottery_name_master')
            ->where('status', 'Open')
            ->where('status', '!=', 'Deactive')
            ->get();

        if (count($check_any_market_is_open) == 0) {
            $lottery_list_today_date = DB::table('lottery_name_master')
                ->where('status', '!=', 'Deactive')
                ->get();

            $date = new Carbon($this->today_date);
            if (count($lottery_list_today_date) > 0) {
                foreach ($lottery_list_today_date as $key => $value) {
                    DB::table('lottery_name_master')
                        ->where('status', '!=', 'Deactive')
                        ->where('id', $value->id)
                        ->update([
                            'open_pana' => '***',
                            'close_pana' => '***',
                            'jodi' => '**',
                            'status' => 'Open',
                            'lottery_date' => $this->today_date,
                            'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                            'updated_at' => $this->current_date_time,
                        ]);
                }
                $update = DB::table('today_game_date_master')->update(['date' => $this->today_date]);
                DB::table('cron_job_master')->delete();
                DB::table('log_activity')->delete();
                $date = new Carbon($this->today_date);
                $day = strtoupper($date->shortEnglishDayOfWeek);
                $lottery_list_active = DB::table('lottery_name_master')
                    ->where('status', '!=', 'Deactive')
                    ->orderBy('position', 'ASC')
                    ->get();

                foreach ($lottery_list_active as $key => $value) {
                    $check = DB::table('lottery_name_master')
                        ->where('id', $value->id)
                        ->whereRaw("find_in_set('$day' , lottery_week_day)")
                        ->where('status', '!=', 'Deactive')
                        ->first();
                    if (empty($check)) {
                        DB::table('lottery_name_master')
                            ->where('id', $value->id)
                            ->update([
                                'open_pana' => '***',
                                'close_pana' => '***',
                                'jodi' => '**',
                                'status' => 'Disable',
                                'lottery_date' => $this->today_date,
                                'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                                'updated_at' => $this->current_date_time,
                            ]);
                    } else {
                        DB::table('lottery_name_master')
                            ->where('id', $value->id)
                            ->update([
                                'open_pana' => '***',
                                'close_pana' => '***',
                                'jodi' => '**',
                                'status' => 'Open',
                                'lottery_date' => $this->today_date,
                                'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                                'updated_at' => $this->current_date_time,
                            ]);
                    }
                }

                echo json_encode(['code' => 1, 'msg' => 'Market Reset At ' . $current_time]);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'No Market Found']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => 'Not Reset All Market Is Not Close']);
        }
    }

    public function win_amount_transfer()
    {
        $result_amount_list = DB::table('lottery_result_master')
            ->where('isTransfer', 'YES')
            ->get()
            ->take(100);

        if (count($result_amount_list) <= 0) {
            return response()->json(['code' => 0, 'msg' => 'No Amount Pending For Transfer']);
        } else {
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

    public function delete()
    {
        $reg_no1 = "SM5PPK6LH5";
        $reg_no2 = "SMQEYAS3XX";
        $reg_no3 = "SM59OX4J1E";
        $reg_no4 = "SMN3T2JBHQ";

        DB::table('deposit_history_master')
            ->where('reg_no', $reg_no1)
            ->delete();
        DB::table('withdraw_history_master')
            ->where('reg_no', $reg_no1)
            ->delete();
        DB::table('transaction_master')
            ->where('reg_no', $reg_no1)
            ->delete();
        DB::table('lottery_result_master')
            ->where('reg_no', $reg_no1)
            ->delete();

        DB::table('deposit_history_master')
            ->where('reg_no', $reg_no2)
            ->delete();
        DB::table('withdraw_history_master')
            ->where('reg_no', $reg_no2)
            ->delete();
        DB::table('transaction_master')
            ->where('reg_no', $reg_no2)
            ->delete();
        DB::table('lottery_result_master')
            ->where('reg_no', $reg_no2)
            ->delete();

        DB::table('deposit_history_master')
            ->where('reg_no', $reg_no3)
            ->delete();
        DB::table('withdraw_history_master')
            ->where('reg_no', $reg_no3)
            ->delete();
        DB::table('transaction_master')
            ->where('reg_no', $reg_no3)
            ->delete();
        DB::table('lottery_result_master')
            ->where('reg_no', $reg_no3)
            ->delete();

        DB::table('deposit_history_master')
            ->where('reg_no', $reg_no4)
            ->delete();
        DB::table('withdraw_history_master')
            ->where('reg_no', $reg_no4)
            ->delete();
        DB::table('transaction_master')
            ->where('reg_no', $reg_no4)
            ->delete();
        DB::table('lottery_result_master')
            ->where('reg_no', $reg_no4)
            ->delete();
        DB::table('cron_job_master')->delete();
        DB::table('log_activity')->delete();
        echo json_encode(['code' => 1, 'msg' => 'Clean Data']);
    }

    public function lucky_number()
    {
        $lottery_list_today_list_otc = DB::table('lottery_name_master')
        ->get();
        foreach ($lottery_list_today_list_otc as $key => $value) {
            $lucky_number_otc = $this->lucky_number_otc();
            $checkrepeat = DB::table('lottery_name_master')
                ->where('lucky_number_otc', $lucky_number_otc)
                ->first();
            if (empty($checkrepeat)) {
                DB::table('lottery_name_master')
                    ->where('id', $value->id)
                    ->update([
                        'lucky_number_otc' => $lucky_number_otc,
                        'lucky_number_genratedby' => 'superadmin',
                    ]);
            }
        }

        $lottery_list_today_list_jodi = DB::table('lottery_name_master')->get();
        foreach ($lottery_list_today_list_jodi as $key => $value) {
            $lucky_number_otc_number = explode("=", $value->lucky_number_otc);

            if (count($lucky_number_otc_number) == 4)
            {
                $arrayotc = [$lucky_number_otc_number[0], $lucky_number_otc_number[1], $lucky_number_otc_number[2], $lucky_number_otc_number[3]];
                $arraysingle = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                $lucky_number_jodi_1 = $lucky_number_otc_number[0] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_2 = $lucky_number_otc_number[0] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_3 = $lucky_number_otc_number[1] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_4 = $lucky_number_otc_number[1] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_5 = $lucky_number_otc_number[2] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_6 = $lucky_number_otc_number[2] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_7 = $lucky_number_otc_number[3] . $arraysingle[rand(0, count($arraysingle) - 1)];
                $lucky_number_jodi_8 = $lucky_number_otc_number[3] . $arraysingle[rand(0, count($arraysingle) - 1)];

                $lucky_number_jodi =
                    $lucky_number_jodi_1 . '=' . $lucky_number_jodi_2 . '=' . $lucky_number_jodi_3 . '=' . $lucky_number_jodi_4 . '=' . $lucky_number_jodi_5 . '=' . $lucky_number_jodi_6 . '=' . $lucky_number_jodi_7 . '=' . $lucky_number_jodi_8;
                DB::table('lottery_name_master')
                    ->where('id', $value->id)
                    ->update([
                        'lucky_number_jodi' => $lucky_number_jodi,
                    ]);
            }

            
        }
        echo json_encode(['code' => 1, 'msg' => 'Lucky Number']);
    }

    public function lucky_number_otc()
    {
        $arraysingle = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $lucky_number_otc1 = $arraysingle[rand(0, count($arraysingle) - 1)];
        $lucky_number_otc2 = $arraysingle[rand(0, count($arraysingle) - 1)];
        $lucky_number_otc3 = $arraysingle[rand(0, count($arraysingle) - 1)];
        $lucky_number_otc4 = $arraysingle[rand(0, count($arraysingle) - 1)];
        $lucky_number_otc = $lucky_number_otc1 . '=' . $lucky_number_otc2 . '=' . $lucky_number_otc3 . '=' . $lucky_number_otc4;
        $checkrepeat = DB::table('lottery_name_master')
            ->where('lucky_number_otc', $lucky_number_otc)
            ->first();

        if (empty($checkrepeat)) {
            return $lucky_number_otc;
        } else {
            return $this->lucky_number_otc();
        }
    }
}
