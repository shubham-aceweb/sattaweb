<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Request;
use DB;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $created_at = get_date_default_timezone_set();
        $updated_at = get_date_default_timezone_set();

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $log = [];
        $log['description'] = 'User Login';
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = $ip;
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['email'] = auth()->check() ? auth()->user()->email : '';
        $log['user'] = auth()->check() ? auth()->user()->first_name : '';
        $log['created_at'] = $created_at;
        $log['updated_at'] = $updated_at;
        DB::table('log_activity')->insert($log);
    }


}
