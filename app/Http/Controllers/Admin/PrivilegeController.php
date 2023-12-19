<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;


class PrivilegeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->created_at = get_date_default_timezone_set();
        $this->updated_at = get_date_default_timezone_set();
    }

    public function list_index() {
        
        $data['page_title'] = 'All Users';
        return view('admin.privilege.user_list', $data);
    }

    public function users_list_ajax(Request $request){
        
        $columns = array( 
            0 =>'id',
            1 =>'first_name',
            2 =>'last_name',
            3 =>'email',
            4 =>'mobile',
            5 =>'user_type',
            6 =>'status',
            7 =>'created_at',
        );

        $totalData = DB::table('users')->where('user_type','SuperAdmin')->count();
            
        $totalFiltered = $totalData; 
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = DB::table('users')->where('user_type','SuperAdmin')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  DB::table('users')->where('id','LIKE',"%{$search}%")->where('user_type','SuperAdmin')
                            ->orWhere('first_name', 'LIKE',"%{$search}%")
                            ->orWhere('last_name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('mobile', 'LIKE',"%{$search}%")
                            ->orWhere('user_type', 'LIKE',"%{$search}%")
                            ->orWhere('status', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('users')->where('id','LIKE',"%{$search}%")->where('user_type','SuperAdmin')
                            ->orWhere('first_name', 'LIKE',"%{$search}%")
                            ->orWhere('last_name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('mobile', 'LIKE',"%{$search}%")
                            ->orWhere('user_type', 'LIKE',"%{$search}%")
                            ->orWhere('status', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {

            foreach ($posts as $key => $post)
            {

                $nestedData['id'] = $key+1+$start;
                $nestedData['first_name'] = $post->first_name;
                $nestedData['last_name'] = $post->last_name;
                $nestedData['email'] = $post->email;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['user_type'] = $post->user_type;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['action'] = '<a href="'.url('privilege-users-edit',['id'=>$post->id]).'" data-id="'.$post->id.'" class="btn btn-info">Edit</a>';
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data); 
        
    }

    // public function view_index(Request $request) {

    //     $data['page_title'] = 'User Details';
    //     $data['result'] = DB::table('users')->where('id', $request->id)->first();
    //     return view('admin.privilege.user_view', $data);
    // }

    public function edit_index(Request $request) {

        $data['page_title'] = 'User Details';
        $data['result'] = DB::table('users')->where('id', $request->id)->first();
        return view('admin.privilege.user_edit', $data);
    }

    public function update_index(Request $request) {

    		$data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
        		'user_type' => $request->user_type,
                'mobile' => isset($request->mobile) ? $request->mobile : '0',
                'email' => $request->email,
                'status' => $request->status,
                'updated_at'=>$this->updated_at,
        	];
        	
        	$result = DB::table('users')
        	->where('id', $request->id)
        	->update($data);

        	if (isset($result) && $result == 1 || $result == 0) {

                /**Log Activity*/
                $logdes = 'Update Data User'.$request->id.' at Privilege Controller';
                \LogActivity::addToLog($logdes);

        		return redirect('privilege-users-list')->with('success', 'Sucessfully Update');
        	}else {

        		return redirect()->back()
        		->with('error', 'Whoops something went wrong');
        	}
    }

    public function add_index(Request $request){
        $data['page_title'] = 'Create User';
        return view('admin.privilege.user_add', $data);
    }

    public function save_index(Request $request){

        $v = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
            'user_type' =>'required',
        ],[
            
            'first_name.required'=> 'First name is Required', 
            'last_name.required'=> 'Laat name is Required', 
            'email.required'=> 'Email is Required', 
            'password.required'=> 'Password is Required',  
            'user_type.required'=> 'User type is Required',
        ]);


        if ($v->fails()) {
            return back()->withInput()->withErrors($v->errors())->withInput();
        }else{

                $created_at = get_date_default_timezone_set();
                $data = [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'user_type' => $request->user_type,
                    'mobile' => isset($request->mobile) ? $request->mobile : '0',
                    'status' => 'Enable',
                    'created_at'=>$this->created_at,
                ];

                $result = DB::table('users')->insert($data);

                if ($result) {

                    /**Log Activity*/
                    $logdes = 'Add New Data '.$request->email.' As New User';
                    \LogActivity::addToLog($logdes);

                    return redirect('privilege-users-list')->with('success', 'Sucessfully Added');
                }else {
                    return redirect()->back()
                                    ->with('error', 'Whoops something went wrong');
                }
        }


    }

    public function update_user_password_index(Request $request){


            $v = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
            ]);

            if($v->fails()) {
                return back()->withErrors($v->errors())->withInput();
            }else{
                
                $updated_at = get_date_default_timezone_set();

                $data=[
                    'password'=>Hash::make($request->password),                 
                    'updated_at'=>$this->updated_at,
                ];

                $result = DB::table('users')->where('id', $request->id)->update($data);

                if (isset($result) && $result == 1 || $result == 0) {

                /**Log Activity*/
                $logdes = 'Update Data Id '.$request->id.' at Users master';
                \LogActivity::addToLog($logdes);    

                return redirect('privilege-users-list')->with('success', 'Sucessfully Update');
                } else {

                    return redirect()->back()
                    ->with('error', 'Whoops something went wrong');
                }

            }

    }

}
