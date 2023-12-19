<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Hash;

class DashbordAccessController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->current_date_time = date("Y-m-d H:i:s");
    }
    public function admin_login_view()
    {
        return view('admin.login-register.login');
    }

    public function ndrgames_login_view()
    {
        return view('admin.login-register.ndrgameslogin');
    }

    public function famousonline_login_view()
    {
        return view('admin.login-register.famousonlinelogin');
    }

    public function gsboss_login_view()
    {
        return view('admin.login-register.gsbosslogin');
    }

    public function dhanigames_login_view()
    {
        return view('admin.login-register.dhanigameslogin');
    }

    public function login_request(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $check_user = User::where('email', $request->input('email'))
            ->orWhere('mobile', $request->input('email'))
            ->first();
        if (!empty($check_user)) {
            if (Auth::attempt(['email' => $check_user->email, 'password' => $request->input('password')])) {
                return redirect()
                    ->intended('admin/dashboard')
                    ->withSuccess('Signed Successfully');
            } else {
                return redirect()
                    ->back()
                    ->withErrors('Login details are not valid')
                    ->withInput();
            }
        } else {
            return redirect()
                ->back()
                ->withErrors('Mobile or Email are not found')
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        $user_deatil = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();

        if ($user_deatil->name == "Zakir Ahemad") {
            $logdes = 'User Logout';
            \LogActivity::addToLog($logdes);
            Session::flush();
            Auth::logout();
            return Redirect('admin/');
        }
        if ($user_deatil->name == "Ndr Games") {
            $logdes = 'Sai Games Agent Logout';
            \LogActivity::addToLog($logdes);
            Session::flush();
            Auth::logout();
            return Redirect('agent/ndrgames');
        }
        if ($user_deatil->name == "Famous Online") {
            $logdes = 'Famous Online Agent Logout';
            \LogActivity::addToLog($logdes);
            Session::flush();
            Auth::logout();
            return Redirect('agent/famousonline');
        }

        if ($user_deatil->name == "GS Boss") {
            $logdes = 'GS Boss Agent Logout';
            \LogActivity::addToLog($logdes);
            Session::flush();
            Auth::logout();
            return Redirect('agent/gsboss');
        }
        if ($user_deatil->name == "Dhani Games") {
            $logdes = 'Dhani Games Agent Logout';
            \LogActivity::addToLog($logdes);
            Session::flush();
            Auth::logout();
            return Redirect('agent/dhanigames');
        }
    }

    public function add_dashboard_user()
    {
        $data['page_title'] = 'Add Dashboard User';
        $data['product_list_master'] = DB::table('product_list_master')
            ->where('status', 'Enable')
            ->orderBy('name')
            ->get();
        $data['lottery_list_master'] = DB::table('lottery_name_master')
            ->orderBy('lottery_name')
            ->get();
        return view('admin.login-register.register', $data);
    }

    public function add_dashboard_user_data(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_type' => 'required',
                'product_name' => 'required',
                'commission' => 'required|numeric',
                'name' => 'required|max:120',
                'mobile' => 'required|digits:10|numeric',
                'email' => 'required|email',
                'password' => 'required|min:6|string',
                'status' => 'required',
            ],
            [
                'user_type.required' => 'User Type is Required',
                'product_name.required' => 'Product Name  is Required',
                'commission.required' => 'Commission is Required',
                'name.required' => 'name is Required',
                'mobile.required' => 'mobile is Required',
                'email.required' => 'email is Required',
                'password.required' => 'password is Required',
                'status.required' => 'Status is Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            $checkuser = DB::table('users')
                ->where('mobile', $request->mobile)
                ->orWhere('email', $request->email)
                ->first();

            if (!empty($checkuser)) {
                return redirect()
                    ->back()
                    ->with('error', 'Mobile or Email Already Exist')
                    ->withInput();
            }

            if (str_contains("ALL", $request->lottery_list_master[0])) {
                $lottery_list = DB::table('lottery_name_master')
                    ->orderBy('lottery_name')
                    ->get();
                $temp = [];
                foreach ($lottery_list as $key => $value) {
                    $temp[] = $value->lottery_name;
                }
                $lottery_list = implode(',', $temp);
            } else {
                $lottery_list = implode(',', $request->lottery_list_master);
            }

            $data = [
                'user_type' => $request->user_type,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'product' => $request->product_name,
                'market' => $lottery_list,
                'commission' => $request->commission,
                'mobile_verification_status' => 'YES',
                'email_verification_status' => 'YES',
                'wallet' => '0',
                'status' => $request->status,
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];

            $return_id = DB::table('users')->insertGetId($data);

            if ($return_id) {
                $token = substr(str_shuffle('12345687890abcdefghijklmnopqrstuvwxyz'), 0, 4) . bin2hex(random_bytes(10) . $return_id);
                DB::table('users')
                    ->where('id', $return_id)
                    ->update(['token' => $token]);

                /**Log Activity*/
                $logdes = 'Add New Data ' . $request->email . ' As New User';
                \LogActivity::addToLog($logdes);

                return redirect('admin/dashboard-user-list')->with('success', 'Sucessfully Added');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Whoops something went wrong')
                    ->withInput();
            }
        }
    }

    public function edit_dashboard_user(Request $request)
    {
        $data['page_title'] = 'Edit User';
        $id = $request->id;
        $user_detail = DB::table('users')
            ->where('id', $id)
            ->first();
        $product_list = DB::table('product_list_master')->get();
        $lottery_list = DB::table('lottery_name_master')->get();

        $data['user_detail'] = $user_detail;
        $data['product_list'] = $product_list;
        $data['lottery_list'] = $lottery_list;

        return view('admin.login-register.edit-register', $data);
    }

    public function update_add_dashboard_user(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'commission' => 'required|numeric',
                'name' => 'required',
                'mobile' => 'required|digits:10|numeric',
                'email' => 'required',
                'status' => 'required',
            ],
            [
                'commission.required' => 'Commission is Required',
                'name.required' => 'name is Required',
                'mobile.required' => 'Mobile is Required',
                'email.required' => 'email is Required',
                'status.required' => 'Status is Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            if (str_contains("ALL", $request->lottery_list_master[0])) {
                $lottery_list = DB::table('lottery_name_master')
                    ->orderBy('lottery_name')
                    ->get();
                $temp = [];
                foreach ($lottery_list as $key => $value) {
                    $temp[] = $value->lottery_name;
                }
                $lottery_list = implode(',', $temp);
            } else {
                $lottery_list = implode(',', $request->lottery_list_master);
            }

            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'commission' => $request->commission,
                'status' => $request->status,
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];

            $update = DB::table('users')
                ->Where('id', $request->id)
                ->update($data);

            if ($update) {
                return redirect('admin/dashboard-user-list')->withSuccess('Update Sucessfully Added');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }

    public function dashboard_user_list(Request $request)
    {
        $data['page_title'] = 'Dashboard User';

        return view('admin.login-register.user-list', $data);
    }

    public function dashboard_user_list_data(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'user_type',
            2 => 'name',
            3 => 'mobile',
            4 => 'email',
            5 => 'mobile_verification_status',
            6 => 'email_verification_status',
            7 => 'wallet',
            8 => 'market',
            9 => 'product',
            10 => 'commission',
            11 => 'status',
            12 => 'created_at',
            13 => 'updated_at',
        ];

        $totalData = DB::table('users')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('users')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('users')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('users')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {

            

                $lottery_list = DB::table('lottery_name_master')
                    ->orderBy('lottery_name')
                    ->get();
                $temp = [];
                foreach ($lottery_list as $key => $value) {
                    $temp[] = $value->lottery_name;
                }
                $lottery_list = implode(',', $temp);




            DB::table('users')->where('user_type', 'SuperAdmin')
            ->update(['market' => $lottery_list]);
            DB::table('users')->where('user_type', 'Admin')
            ->update(['market' => $lottery_list]);


            foreach ($posts as $key => $post) {
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['user_type'] = $post->user_type;
                $nestedData['name'] = $post->name;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['email'] = $post->email;
                $nestedData['wallet'] = $post->wallet;
                $nestedData['market'] = '<div class="tooltip">Market<span class="tooltiptext">'.$post->market.'</span></div>';
                $nestedData['product'] = $post->product;
                $nestedData['commission'] = $post->commission;
                $nestedData['mobile_verification_status'] = $post->mobile_verification_status;
                $nestedData['email_verification_status'] = $post->email_verification_status;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->created_at;

                 if ($post->user_type == "SuperAdmin") {
                    $nestedData['action'] =
                    '<a href="' .
                    url('admin/edit-password-user', ['id' => $post->id]) .
                    '" class="btn btn-danger btn-sm">EditPassword</a>';
                } else {
                    $nestedData['action'] =
                    '<a href="' .
                    url('admin/edit-dashboard-user', ['id' => $post->id]) .
                    '" class="btn btn-primary btn-sm">Edit Detail</a>' .
                    '<br>' .
                    '<a href="' .
                    url('admin/edit-password-user', ['id' => $post->id]) .
                    '" class="btn btn-danger btn-sm">EditPassword</a>';
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

    public function edit_password_user(Request $request)
    {
        $data['page_title'] = 'Edit Password User';
        $id = $request->id;
        $user_detail = DB::table('users')
            ->where('id', $id)
            ->first();

        $data['user_detail'] = $user_detail;
        return view('admin.login-register.edit-password', $data);
    }

    public function update_password_dashboard_user(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6|string',
                'repassword' => 'required|min:6|string',
            ],
            [
                'password.required' => 'Enter password',
                'repassword.required' => 'Re-Enter password',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            if ($request->password != $request->repassword) {
                return back()->withError('Password not Match');
            }

            $data = [
                'password' => Hash::make($request->password),
                'updated_at' => $this->current_date_time,
            ];

            $update = DB::table('users')
                ->Where('id', $request->id)
                ->update($data);

            if ($update) {
                return redirect('admin/dashboard-user-list')->withSuccess('Password Updated Sucessfully');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }

    public function dashboard_user_support()
    {
        $data['page_title'] = 'Add Support Number';
        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',', $user_deatil->product);

        $data['product_list_master'] = DB::table('product_list_master')->whereIn('name', $product)
            ->where('status', 'Enable')
            ->orderBy('name')
            ->get();
        return view('admin.support.add-support-mobile', $data);
    }

    public function add_dashboard_user_support_data(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required',
                'mobile' => 'required|digits:10|numeric',
                'status' => 'required',
            ],
            [
                'product_name.required' => 'Product Name is Required',
                'mobile.required' => 'mobile is Required',
                'status.required' => 'Status is Required',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        } else {
            $checkproduct = DB::table('support_contact_master')
                ->where('product', $request->product_name)
                ->first();

            if (!empty($checkproduct)) {
                return redirect()
                    ->back()
                    ->with('error', 'Product Support Contact Already Added')
                    ->withInput();
            }

            $data = [
                'type' => 'WhatsApp',
                'product' => $request->product_name,
                'mobile' => $request->mobile,
                'status' => $request->status,
                'created_at' => $this->current_date_time,
                'updated_at' => $this->current_date_time,
            ];

            $return_id = DB::table('support_contact_master')->insertGetId($data);

            if ($return_id) {
                

                return redirect('admin/dashboard-user-support-list')->with('success', 'Sucessfully Added');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Whoops something went wrong')
                    ->withInput();
            }
        }
    }

    public function dashboard_user_support_list()
    {

        $data['page_title'] = 'Support Number List';
        return view('admin.support.support-list-index', $data);
    }

      public function dashboard_user_support_list_data(Request $request)
    {



        $user_deatil = DB::table('users')->where('id', Auth::user()->id)->first();
        $product = explode(',', $user_deatil->product);
      
        $columns = [
            0 => 'id',
            1 => 'product',
            2 => 'type',
            3 => 'mobile',
            4 => 'status',
            5 => 'created_at',
            6 => 'updated_at',
        ];

        $totalData = DB::table('support_contact_master')->whereIn('product', $product)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('support_contact_master')->whereIn('product', $product)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('support_contact_master')->whereIn('product', $product)
                ->where('product', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('support_contact_master')->whereIn('product', $product)
                ->where('product', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $nestedData['id'] = $key + 1 + $start;
                $nestedData['product'] = $post->product;
                $nestedData['type'] = $post->type;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = $post->created_at;
                $nestedData['updated_at'] = $post->created_at;
                $nestedData['action'] ='<a href="' . url('admin/edit-dashboard-user-support', ['id' => $post->id]) .'" class="btn btn-primary btn-sm">Edit</a>';
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

    public function edit_dashboard_user_support(Request $request)
    {
        $data['page_title'] = 'Edit Support Number';
        $id = $request->id;
        $support_detail = DB::table('support_contact_master')
            ->where('id', $id)
            ->first();

        $data['support_detail'] = $support_detail;
        return view('admin.support.edit-support-detail', $data);
    }

    public function edit_dashboard_user_support_data(Request $request)
    {
        $validator = Validator::make(
             $request->all(),
            [
                
                'mobile' => 'required|digits:10|numeric',
                'status' => 'required',
            ],
            [
                'mobile.required' => 'mobile is Required',
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
                
                'mobile' => $request->mobile,
                'status' => $request->status,
                'updated_at' => $this->current_date_time,
            ];

            $update = DB::table('support_contact_master')
                ->Where('id', $request->id)
                ->update($data);

            if ($update) {
                return redirect('admin/dashboard-user-support-list')->withSuccess('Password Updated Sucessfully');
            } else {
                return back()->withError('Whoops something went wrong');
            }
        }
    }



}
