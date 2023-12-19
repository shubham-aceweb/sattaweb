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
class LotteryResultDeclareController extends Controller
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

    public function lottery_result_history(Request $request)
    {
        $data['page_title'] = 'Market Result History';
        return view('admin.lottery.lottery-result-history', $data);
    }

    public function lottery_result_history_data(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'lottery_date',
            2 => 'lottery_day',
            3 => 'lottery_name',
            4 => 'open',
            5 => 'open_pana',
            6 => 'jodi',
            7 => 'close_pana',
            8 => 'close',
            9 => 'open_time',
            10 => 'close_time',
            11 => 'date',
            12 => 'status',
            13 => 'created_at',
            14 => 'updated_at',
        ];

        $totalData = DB::table('lottery_result_history_master')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('lottery_result_history_master')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('lottery_result_history_master')
                ->Where('lottery_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('lottery_result_history_master')
                ->Where('lottery_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {

           


            foreach ($posts as $key => $post) {
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['lottery_date'] = $post->lottery_date;
                $nestedData['lottery_day'] = $post->lottery_day;
                $nestedData['lottery_name'] = $post->lottery_name;
                $nestedData['open'] = $post->open;
                $nestedData['open_pana'] = $post->open_pana;
                $nestedData['jodi'] = $post->jodi;
                $nestedData['close_pana'] = $post->close_pana;
                $nestedData['close'] = $post->close;
                $nestedData['open_time'] = $post->open_time;
                $nestedData['close_time'] = $post->close_time;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = $post->created_at; //date('j M Y h:i a', strtotime($post->created_at))
                $nestedData['updated_at'] = $post->created_at; //date('j M Y h:i a', strtotime($post->created_at))
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
}
