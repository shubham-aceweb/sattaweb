<?php
namespace App\Helpers;
use Request;
use DB;
use App\Models\LogActivity as LogActivityModel;
//use App\LogActivity as LogActivityModel;
use Auth;

class LogActivity
{


    public static function addToLog($description)
    {
        $created_at = get_date_default_timezone_set();

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
    	$log = [];
    	$log['description'] = $description;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = $ip;
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 0;
        $log['email'] = auth()->check() ? auth()->user()->email : '';
        $log['user'] = auth()->check() ? auth()->user()->first_name : '';
        $log['created_at'] = $created_at;
        //DB::table('log_activity')->insert($log);
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}