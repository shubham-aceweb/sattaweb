<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





Route::get('ndrgames1/app_setup', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'app_setup']);
Route::post('ndrgames1/otp_un_register', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'otp_un_register']);
Route::post('ndrgames1/otp_register', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'otp_register']);
Route::post('ndrgames1/registration', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'registration']);
Route::post('ndrgames1/login_with_otp', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'login_with_otp']);
Route::post('ndrgames1/home', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'home']);
Route::post('ndrgames1/profile', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'profile']);
Route::post('ndrgames1/update_bank_wallet', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'update_bank_wallet']);
Route::post('ndrgames1/withdraw_amount_screen', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'withdraw_amount_screen']);
Route::post('ndrgames1/withdraw_amount', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'withdraw_amount']);
Route::post('ndrgames1/deposit_amount_screen', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'deposit_amount_screen']);
Route::post('ndrgames1/withdraw_history', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'withdraw_history']);
Route::post('ndrgames1/deposit_amount', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'deposit_amount']);
Route::post('ndrgames1/deposit_history', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'deposit_history']);
Route::post('ndrgames1/lottery_list', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'lottery_list']);
Route::post('ndrgames1/game_rate', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'game_rate']);
Route::post('ndrgames1/filter_game_number', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'filter_game_number']);
Route::post('ndrgames1/submit_game_number', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'submit_game_number']);
Route::post('ndrgames1/lottery_history', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'lottery_history']);
Route::post('ndrgames1/lottery_result_history', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'lottery_result_history']);
Route::post('ndrgames1/user_query', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'user_query']);
Route::post('ndrgames1/user_query_list', [App\Http\Controllers\Api\NdrGamesApi1Controller::class, 'user_query_list']);



Route::get('famousonline1/app_setup', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'app_setup']);
Route::post('famousonline1/otp_un_register', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'otp_un_register']);
Route::post('famousonline1/otp_register', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'otp_register']);
Route::post('famousonline1/registration', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'registration']);
Route::post('famousonline1/login_with_otp', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'login_with_otp']);
Route::post('famousonline1/home', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'home']);
Route::post('famousonline1/profile', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'profile']);
Route::post('famousonline1/update_bank_wallet', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'update_bank_wallet']);
Route::post('famousonline1/withdraw_amount_screen', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'withdraw_amount_screen']);
Route::post('famousonline1/withdraw_amount', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'withdraw_amount']);
Route::post('famousonline1/deposit_amount_screen', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'deposit_amount_screen']);
Route::post('famousonline1/withdraw_history', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'withdraw_history']);
Route::post('famousonline1/deposit_amount', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'deposit_amount']);
Route::post('famousonline1/deposit_history', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'deposit_history']);
Route::post('famousonline1/lottery_list', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'lottery_list']);
Route::post('famousonline1/game_rate', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'game_rate']);
Route::post('famousonline1/filter_game_number', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'filter_game_number']);
Route::post('famousonline1/submit_game_number', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'submit_game_number']);
Route::post('famousonline1/lottery_history', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'lottery_history']);
Route::post('famousonline1/lottery_result_history', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'lottery_result_history']);
Route::post('famousonline1/user_query', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'user_query']);
Route::post('famousonline1/user_query_list', [App\Http\Controllers\Api\FamousonlineApi1Controller::class, 'user_query_list']);


Route::get('gsboss1/app_setup', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'app_setup']);
Route::post('gsboss1/otp_un_register', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'otp_un_register']);
Route::post('gsboss1/otp_register', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'otp_register']);
Route::post('gsboss1/registration', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'registration']);
Route::post('gsboss1/login_with_otp', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'login_with_otp']);
Route::post('gsboss1/home', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'home']);
Route::post('gsboss1/profile', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'profile']);
Route::post('gsboss1/update_bank_wallet', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'update_bank_wallet']);
Route::post('gsboss1/withdraw_amount_screen', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'withdraw_amount_screen']);
Route::post('gsboss1/withdraw_amount', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'withdraw_amount']);
Route::post('gsboss1/deposit_amount_screen', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'deposit_amount_screen']);
Route::post('gsboss1/withdraw_history', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'withdraw_history']);
Route::post('gsboss1/deposit_amount', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'deposit_amount']);
Route::post('gsboss1/deposit_history', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'deposit_history']);
Route::post('gsboss1/lottery_list', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'lottery_list']);
Route::post('gsboss1/game_rate', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'game_rate']);
Route::post('gsboss1/filter_game_number', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'filter_game_number']);
Route::post('gsboss1/submit_game_number', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'submit_game_number']);
Route::post('gsboss1/lottery_history', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'lottery_history']);
Route::post('gsboss1/lottery_result_history', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'lottery_result_history']);
Route::post('gsboss1/user_query', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'user_query']);
Route::post('gsboss1/user_query_list', [App\Http\Controllers\Api\GSbossApi1Controller::class, 'user_query_list']);


Route::get('dhanigames1/app_setup', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'app_setup']);
Route::post('dhanigames1/otp_un_register', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'otp_un_register']);
Route::post('dhanigames1/otp_register', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'otp_register']);
Route::post('dhanigames1/registration', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'registration']);
Route::post('dhanigames1/login_with_otp', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'login_with_otp']);
Route::post('dhanigames1/home', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'home']);
Route::post('dhanigames1/profile', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'profile']);
Route::post('dhanigames1/update_bank_wallet', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'update_bank_wallet']);
Route::post('dhanigames1/withdraw_amount_screen', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'withdraw_amount_screen']);
Route::post('dhanigames1/withdraw_amount', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'withdraw_amount']);
Route::post('dhanigames1/deposit_amount_screen', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'deposit_amount_screen']);
Route::post('dhanigames1/withdraw_history', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'withdraw_history']);
Route::post('dhanigames1/deposit_amount', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'deposit_amount']);
Route::post('dhanigames1/deposit_history', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'deposit_history']);
Route::post('dhanigames1/lottery_list', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'lottery_list']);
Route::post('dhanigames1/game_rate', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'game_rate']);
Route::post('dhanigames1/filter_game_number', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'filter_game_number']);
Route::post('dhanigames1/submit_game_number', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'submit_game_number']);
Route::post('dhanigames1/lottery_history', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'lottery_history']);
Route::post('dhanigames1/lottery_result_history', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'lottery_result_history']);
Route::post('dhanigames1/user_query', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'user_query']);
Route::post('dhanigames1/user_query_list', [App\Http\Controllers\Api\DhaniGamesApi1Controller::class, 'user_query_list']);


Route::get('mumbaigroup1/app_setup', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'app_setup']);
Route::post('mumbaigroup1/otp_un_register', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'otp_un_register']);
Route::post('mumbaigroup1/otp_register', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'otp_register']);
Route::post('mumbaigroup1/registration', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'registration']);
Route::post('mumbaigroup1/login_with_otp', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'login_with_otp']);
Route::post('mumbaigroup1/home', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'home']);
Route::post('mumbaigroup1/profile', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'profile']);
Route::post('mumbaigroup1/update_bank_wallet', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'update_bank_wallet']);
Route::post('mumbaigroup1/withdraw_amount_screen', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'withdraw_amount_screen']);
Route::post('mumbaigroup1/withdraw_amount', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'withdraw_amount']);
Route::post('mumbaigroup1/deposit_amount_screen', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'deposit_amount_screen']);
Route::post('mumbaigroup1/withdraw_history', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'withdraw_history']);
Route::post('mumbaigroup1/deposit_amount', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'deposit_amount']);
Route::post('mumbaigroup1/deposit_history', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'deposit_history']);
Route::post('mumbaigroup1/lottery_list', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'lottery_list']);
Route::post('mumbaigroup1/game_rate', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'game_rate']);
Route::post('mumbaigroup1/filter_game_number', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'filter_game_number']);
Route::post('mumbaigroup1/submit_game_number', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'submit_game_number']);
Route::post('mumbaigroup1/lottery_history', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'lottery_history']);
Route::post('mumbaigroup1/lottery_result_history', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'lottery_result_history']);
Route::post('mumbaigroup1/user_query', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'user_query']);
Route::post('mumbaigroup1/user_query_list', [App\Http\Controllers\Api\MumbaiGroup1Controller::class, 'user_query_list']);




// cron job data upload


Route::get('vr1/reste_market', [App\Http\Controllers\Api\SystemController::class, 'reste_market_vr1']);
Route::get('vr1/win-amount-transfer', [App\Http\Controllers\Api\SystemController::class, 'win_amount_transfer']);
Route::get('vr1/lucky-number', [App\Http\Controllers\Api\SystemController::class, 'lucky_number']);
Route::get('vr1/delete', [App\Http\Controllers\Api\SystemController::class, 'query']);

