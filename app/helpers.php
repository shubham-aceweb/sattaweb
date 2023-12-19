<?php 

function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function get_date_default_timezone_set(){
	date_default_timezone_set('Asia/Kolkata');
    return date("Y-m-d H:i:s");
}

function get_item_code_ajax(){

	$checkdata=DB::table('product_list_master')->count();
	//$checkdata 0,1
	$aid='';
	if($checkdata==0){
		$aid = 1;
	}else{
		$aid=DB::table('product_list_master')->orderBy('created_at','DESC')->select('id')->first();

		$aid= ++$aid->id;
	}
	$rand_no = rand(100000,999999);
	$auto_item_code = 'ITC'.$rand_no.$aid;
	return $auto_item_code;

}

?>