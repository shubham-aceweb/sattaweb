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
class GameRateController extends Controller
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

    public function game_category_rat_list(Request $request)
    {

        $data['page_title'] = 'Game Category Rate List';
        return view('admin.gamerate.list-index', $data);
    }

    public function game_category_list_data(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'game_name',
            2 => 'game_rate',
            3 => 'xrate',
            4 => 'game_icon',
            5 => 'product',
            6 => 'status',
            7 => 'created_at',
            8 => 'updated_at',
        ];

        $totalData = DB::table('game_rate_master')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('game_rate_master')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('game_rate_master')
                ->Where('game_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('game_rate_master')
                ->Where('game_name', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {


                


                $nestedData['id'] = $key + 1 + $start;
                $nestedData['game_name'] = $post->game_name;
                $nestedData['game_rate'] = $post->game_rate;
                $nestedData['xrate'] = $post->xrate;
                $nestedData['game_icon'] ='<img src="' . url('/') . '/storage/assets/gamerate/' . $post->game_icon . '?v=1" width="50">';
                $nestedData['product'] = $post->product;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = $post->created_at ;//date('j M Y h:i a', strtotime($post->created_at))
                $nestedData['updated_at'] = $post->updated_at ;//date('j M Y h:i a', strtotime($post->created_at))
                $nestedData['action'] = '<a href="' . url('admin/edit-game-category', ['id' => $post->id]) .'" class="btn btn-primary btn-sm">Edit</a>';;
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

    public function add_game_category(Request $request)
    {
        $data['page_title'] = 'Add Game Category Rate';


        return view('admin.gamerate.add-index', $data);
    }

    public function save_game_category(Request $request)
    {

      

        $validator = Validator::make(
            $request->all(),
            [
                'game_name' => 'required',
                'game_rate' => 'required',
                'xrate' => 'required',
                'image' => 'required|image|mimes:png|max:1024|dimensions:width=128,height=128',
                'status' => 'required',
            ],
            [
                'game_name.required' => 'Select game type is Required',
                'game_rate.required' => 'Game Name is Required',
                'xrate.required' => 'x Rate is Required',
                'image.required' => 'Image is Required',
                'image.dimensions' => 'dimensions used 128*128',
                'status.required' => 'Status is Required',
            ]
        );



        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            $check_game_name = DB::table('game_rate_master')
                ->where('game_name', $request->game_name)
                ->first();
            if (!empty($check_game_name)) {
                return redirect()
                    ->back()
                    ->with('error', 'Game Name Name already exists.');
            }

            $add_image = new FileUpload();
            $image = $add_image->upload_image($request->image, 'GR_', 'assets/gamerate', 'NA');

            $data = [
                'game_name' => $request->game_name,
                'game_rate' => $request->game_rate,
                'xrate' => $request->xrate,
                'game_icon' => $image,
                'status' => $request->status,
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];

            $retur_id = DB::table('game_rate_master')->insertGetId($data);

            if (isset($retur_id)) {
                return redirect('admin/game-category-rat-list')->withSuccess('Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }

    public function edit_game_category(Request $request)
    {
        $data['page_title'] = 'Edit Game Category Rate';
        $id=$request->id;
        $data['game_category']= DB::table('game_rate_master')->Where('id', $id)->first();
        return view('admin.gamerate.edit-index', $data);
    }
    public function update_game_category(Request $request)
    {


         $validator = Validator::make(
            $request->all(),
            [
                
                'game_rate' => 'required',
                'xrate' => 'required',
                'status' => 'required',
            ],
            [
                
                'game_rate.required' => 'Game Name is Required',
                'xrate.required' => 'x Rate is Required',
                'status.required' => 'Status is Required',
            ]
        );



        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
          
            $data = [
                
                'game_rate' => $request->game_rate,
                'xrate' => $request->xrate,
                'status' => $request->status,
                'updated_at' => $this->current_date_time,
            ];

            $update = DB::table('game_rate_master')->Where('id',$request->id)->update($data);

            if ($update) {
                return redirect('admin/game-category-rat-list')->withSuccess('Update Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
        
    }

   

}
