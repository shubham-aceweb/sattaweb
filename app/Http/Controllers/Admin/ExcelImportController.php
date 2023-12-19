<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\RewardApp;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class ExcelImportController extends Controller
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
    public function downloadSampleCSV()
    {
        $filePath = public_path('formateresult.csv');

        return Response::download($filePath, 'formateresult.csv');
    }

    public function upload_result_excel(Request $request)
    {
        $data['page_title'] = 'Register New Lottery';
       
        return view('admin.excel.excel-import', $data);
    }

    public function upload_upload_result_excel_data(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $extensions = ["csv"];
            $getExtension = [$request->file('import_file')->getClientOriginalExtension()];
            if (in_array($getExtension[0], $extensions)) {
                $path = $request->file('import_file')->getRealPath();
                $sheetData = Excel::toArray('', $path, null, \Maatwebsite\Excel\Excel::TSV)[0];
                

                if (count($sheetData) - 1 <= 1000) {
                    $insertArray = [];
                    for ($i = 1; $i < count($sheetData); $i++) {
                        if (isset($sheetData[$i][0])) {
                        $id = $sheetData[$i][0];
                        $lottery_date = $sheetData[$i][0];
                        $lottery_name = $sheetData[$i][0];
                        $open_pana = $sheetData[$i][0];
                        $close_pana = $sheetData[$i][0];
                        $checklottery= DB::table('lottery_name_master')->where('lottery_name', $lottery_name)->first();

                        // dd("Only For Developer For First Upload Only");

                        if (!empty($checklottery)) {

                            $checkalready= DB::table('lottery_result_history_master')->where('lottery_date', $lottery_date)->where('lottery_name', $lottery_name)->first();
                            if (empty($checkalready))
                            {

                                $sum_open_pana = array_sum(str_split($open_pana));
                                $open = substr($sum_open_pana, -1);
                                $sum_close_pana = array_sum(str_split($close_pana));
                                $close = substr($sum_close_pana, -1);
                                $date = new Carbon($lottery_date);

                                $data = [
                                    'lottery_date' => Carbon::parse($lottery_date)->format('Y-m-d'),
                                    'lottery_day' =>   strtoupper($date->shortEnglishDayOfWeek),
                                    'lottery_name' => $lottery_name,
                                    'open' => $open,
                                    'open_pana' => $open_pana,
                                    'jodi' => $open.$close,
                                    'close_pana' => $close_pana,
                                    'close' => $close,
                                    'open_time' => $checklottery->open_time,
                                    'close_time' => $checklottery->close_time,
                                    'status' => 'Close',
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];
                                DB::table('lottery_result_history_master')->insertGetId($data);
                            }

                        }
                    }

                     return redirect()
                        ->back()
                        ->with('error', 'Uploded Succesfully..!!');

                } 
            }else {
                    return redirect()
                        ->back()
                        ->with('error', 'You can update maximum 100 record at time.');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Extansion not match.');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'Select File.');
        }
    }
}
