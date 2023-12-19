<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LogActivitiesController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
        $this->created_at = get_date_default_timezone_set();
        $this->updated_at = get_date_default_timezone_set();
    }

    public function log_activities_list(){
        $data['page_title'] = 'Log Activity';
        return view('admin.logactivity.list-index', $data);
    }

    public function log_activities_list_ajax(Request $request){
        
        $columns = array( 
            0 =>'id',
        );

        $totalData = DB::table('log_activity')->count();
            
        $totalFiltered = $totalData; 
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = DB::table('log_activity')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 
            $posts =  DB::table('log_activity')
                        ->where('id','LIKE',"%{$search}%")
                        ->orWhere('description', 'LIKE',"%{$search}%")
                        ->orWhere('url', 'LIKE',"%{$search}%")
                        ->orWhere('method', 'LIKE',"%{$search}%")
                        ->orWhere('ip', 'LIKE',"%{$search}%")
                        ->orWhere('agent', 'LIKE',"%{$search}%")
                        ->orWhere('user_id', 'LIKE',"%{$search}%")                            
                        ->orWhere('email', 'LIKE',"%{$search}%")                            
                        ->orWhere('user', 'LIKE',"%{$search}%")                            
                        ->orWhere('created_at', 'LIKE',"%{$search}%")                            
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = DB::table('log_activity')->where('id','LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->orWhere('url', 'LIKE',"%{$search}%")
                            ->orWhere('method', 'LIKE',"%{$search}%")
                            ->orWhere('ip', 'LIKE',"%{$search}%")
                            ->orWhere('agent', 'LIKE',"%{$search}%")
                            ->orWhere('user_id', 'LIKE',"%{$search}%")                            
                            ->orWhere('email', 'LIKE',"%{$search}%")                            
                            ->orWhere('user', 'LIKE',"%{$search}%")                            
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->count();

        }

        $data = array();
        if(!empty($posts))
        {

            foreach ($posts as $key => $post)
            {

                $nestedData['id'] = $key+1+$start;
                $nestedData['description'] = $post->description;
                $nestedData['url'] = $post->url;
                $nestedData['method'] = $post->method;
                $nestedData['ip'] = $post->ip;
                $nestedData['agent'] = $post->agent;
                $nestedData['user_id'] = $post->user_id;
                $nestedData['email'] = $post->email;
                $nestedData['user'] = $post->user;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['action'] = '<a href="'.url('log-activities-view',['id'=>$post->id]).'" data-id="'.$post->id.'" class="btn btn-info btn-sm">View</a>';
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

    public function log_activities_view(Request $request){
        $data['page_title'] = 'Log Activity';
        $data['record'] = DB::table('log_activity')->where('id',$request->id)->first();
        return view('admin.logactivity.view-index', $data);
    }

}
