<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\leadExport;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Auth;
use DB;
use App\Models\User;

class ExcelExportController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Excel export users.
     */
    public function user_excel_export_csv(Request $request) {

            $fields = array('user_type','reg_no','full_name','mobile','email','refer_code','refer_by','wallet','mobile_verification_status','email_verification_status','version','status','source','created_at','updated_at');

            $format = 'd-m-Y';
            $df = $request->start_date;
            $dt = $request->end_date;

            if (!empty($request->other_option)) {

                if($request->other_option == 'start_end_date') {

                    if(!empty($request->start_date) && !empty($request->end_date)) {
                        $date_from = \Carbon\Carbon::parse($df)->format('Y-m-d');
                        $date_to = \Carbon\Carbon::parse($dt)->format('Y-m-d');
                        // $date_from = \Carbon\Carbon::parse($df)->format('d-m-Y');
                        // $date_to = \Carbon\Carbon::parse($dt)->format('d-m-Y');
                        $items = DB::table('users_master')->select($fields)->whereBetween(DB::raw('DATE(created_at)'), array($date_from, $date_to))->where('user_type','User')->orderBy('created_at', 'ASC')->get();

                    }else{
                        return redirect()->back()->with('error', 'Please Select Start Date and End Date.');
                    }

                }else if($request->other_option == 'select_date'){

                        if(!empty($request->SelectedDate)){

                            $myDate = new Carbon($request->SelectedDate);
                            //$sdate = Carbon::createFromFormat($format, $request->SelectedDate);
                            $items = DB::table('users_master')->select($fields)->whereDate('created_at', '=', $myDate->format('Y-m-d'))->where('user_type','User')->get();
                        }else{
                            return redirect()->back()->with('error', 'Please Fillup Select Date.');
                        }          

                }else if($request->other_option == 'today'){

                    $items = DB::table('users_master')->select($fields)->whereRaw('date(created_at) = ?', [Carbon::today()])->where('user_type','User')->get();

                }else{
                    $items = DB::table('users_master')->select($fields)->where('user_type','User')->get();
                }   
        
            }else{
                    return redirect()->back()->with('error', 'Please Select Option.');
            }

            //$data = []; //array with size 65345
            $itemsArray = json_decode(json_encode($items), true);
            //dd($itemsArray);
            //$header = [];
            $header = array($fields); //headers
            $excel = Excel::download(new leadExport($itemsArray,$header), "users.xlsx");
            return $excel;

    }

   



}
