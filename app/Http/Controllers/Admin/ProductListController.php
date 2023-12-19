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
class ProductListController extends Controller
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

   

    public function product_list(Request $request)
    {
        $data['page_title'] = 'Product List';
    
        return view('admin.productlist.list-index', $data);
    }

    public function product_list_data(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'isTransfer',
            4 => 'created_at',
            5 => 'updated_at',
        ];

        $totalData = DB::table('product_list_master')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('product_list_master')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('product_list_master')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('product_list_master')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['name'] = $post->name;
                $nestedData['status'] = $post->status;
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
    
}
