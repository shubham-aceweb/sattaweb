<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'Cached events cleared! <br>
            Compiled views cleared! <br>
            Application cache cleared!<br>
            Route cache cleared!<br>
            Configuration cache cleared!<br>
            Compiled services and packages files removed!<br>
            Caches cleared successfully!';
});

Route::get('/', [App\Http\Controllers\Web\WebController::class, 'home'])->name('home');
Route::get('/jodi-records/{slug}', [App\Http\Controllers\Web\WebController::class, 'jodi_records']);
Route::get('/panel-records/{slug}', [App\Http\Controllers\Web\WebController::class, 'panel_records']);
Route::get('/download-app/{appname}', [App\Http\Controllers\Web\WebController::class, 'download_app_view']);


Route::group(['prefix' => 'agent'], function () {


    Route::get('/ndrgames', [App\Http\Controllers\Admin\DashbordAccessController::class, 'ndrgames_login_view'])->name('ndrgames');
    Route::get('/famousonline', [App\Http\Controllers\Admin\DashbordAccessController::class, 'famousonline_login_view'])->name('famousonline');
    Route::get('/gsboss', [App\Http\Controllers\Admin\DashbordAccessController::class, 'gsboss_login_view'])->name('gsboss');
    Route::get('/dhanigames', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dhanigames_login_view'])->name('dhanigames');

});

   Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [App\Http\Controllers\Admin\DashbordAccessController::class, 'admin_login_view'])->name('admin');
    Route::post('login-request', [App\Http\Controllers\Admin\DashbordAccessController::class, 'login_request'])->name('login-request');
    Route::get('logout', [App\Http\Controllers\Admin\DashbordAccessController::class, 'logout'])->name('logout');
    Route::get('add-dashboard-user', [App\Http\Controllers\Admin\DashbordAccessController::class, 'add_dashboard_user']);
    Route::post('add-dashboard-user-data', [App\Http\Controllers\Admin\DashbordAccessController::class, 'add_dashboard_user_data']);
    Route::get('/edit-dashboard-user/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'edit_dashboard_user']);
    Route::post('/update-dashboard-user/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'update_add_dashboard_user']);
    Route::get('/edit-password-user/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'edit_password_user']);
    Route::post('/update-password-user/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'update_password_dashboard_user']);
    Route::get('/dashboard-user-list', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dashboard_user_list']);
    Route::post('/dashboard-user-list-data', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dashboard_user_list_data']);
    Route::get('dashboard-user-support', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dashboard_user_support']);
    Route::post('add-dashboard-user-support-data', [App\Http\Controllers\Admin\DashbordAccessController::class, 'add_dashboard_user_support_data']);
    Route::get('dashboard-user-support-list', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dashboard_user_support_list']);
    Route::post('dashboard-user-support-list-data', [App\Http\Controllers\Admin\DashbordAccessController::class, 'dashboard_user_support_list_data']);
    Route::get('edit-dashboard-user-support/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'edit_dashboard_user_support']);
    Route::post('edit-dashboard-user-support-data/{id}', [App\Http\Controllers\Admin\DashbordAccessController::class, 'edit_dashboard_user_support_data']);


    /* ================== Dashborad================== */

    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard_view'])->name('dashboard');

    /* ================== App Web user ================== */

    Route::get('user-list', [App\Http\Controllers\Admin\UserDetailController::class, 'list_index']);
    Route::get('user-list-play-market-list/{name}/{date}', [App\Http\Controllers\Admin\UserDetailController::class, 'user_ist_play_market_list']);
    Route::post('users_detail_list_data', [App\Http\Controllers\Admin\UserDetailController::class, 'users_detail_list_data']);
    Route::get('user-profile/{regno}', [App\Http\Controllers\Admin\UserDetailController::class, 'user_profile']);

    Route::get('user-transaction/{regno}', [App\Http\Controllers\Admin\UserDetailController::class, 'user_transaction']);
    Route::post('user-transaction-data', [App\Http\Controllers\Admin\UserDetailController::class, 'user_transaction_data']);

    Route::get('user-market/{regno}', [App\Http\Controllers\Admin\UserDetailController::class, 'user_market']);
    Route::post('user-market-play-data', [App\Http\Controllers\Admin\UserDetailController::class, 'user_market_play_data']);

    Route::post('add-money-user-wallet', [App\Http\Controllers\Admin\UserDetailController::class, 'add_money_user_wallet']);
    Route::post('redeem-money-user-wallet', [App\Http\Controllers\Admin\UserDetailController::class, 'redeem_money_user_wallet']);
  
    Route::get('user-blocked/{regno}', [App\Http\Controllers\Admin\UserDetailController::class, 'user_blocked']);
    /* ================== transaction history  ================== */


    Route::get('add_deposit_acc', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'add_deposit_acc']);
    Route::post('save_deposit_acc_data', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'save_deposit_acc_data']);
    Route::get('deposit_acc_list', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'deposit_acc_list']);
    Route::post('deposit_acc_data', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'deposit_acc_data']);
    Route::get('edit_deposit_acc/{id}', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'edit_deposit_acc']);
    Route::post('edit_deposit_acc_data/{id}', [App\Http\Controllers\Admin\PaymentAcceptController::class, 'edit_deposit_acc_data']);
    Route::get('withdraw-history-list', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'withdraw_list_view']);
    Route::post('withdraw_amount_success_button', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'withdraw_amount_success_button']);
    Route::post('withdraw_amount_fail_button', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'withdraw_amount_fail_button']);
    Route::post('withdraw-history-list-data', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'withdraw_history_list_data']);
    Route::get('deposit_history_list', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'deposit_list_view']);
    Route::post('deposit_amount_success_button', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'deposit_amount_success_button']);
    Route::post('deposit_amount_fail_button', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'deposit_amount_fail_button']);
    Route::post('deposit_history_list_data', [App\Http\Controllers\Admin\TransactionHistoryController::class, 'deposit_history_list_data']);

    /* ================== game rate  ================== */
    Route::get('/game-category-rat-list', [App\Http\Controllers\Admin\GameRateController::class, 'game_category_rat_list']);
    Route::post('/game-category-list-data', [App\Http\Controllers\Admin\GameRateController::class, 'game_category_list_data']);
    Route::get('/add-game-category', [App\Http\Controllers\Admin\GameRateController::class, 'add_game_category']);
    Route::post('/save-game-category', [App\Http\Controllers\Admin\GameRateController::class, 'save_game_category']);
    Route::get('/edit-game-category/{id}', [App\Http\Controllers\Admin\GameRateController::class, 'edit_game_category']);
    Route::post('/update-game-category/{id}', [App\Http\Controllers\Admin\GameRateController::class, 'update_game_category']);

    /* ================== new lottery  ================== */
    Route::get('/add-new-lottery', [App\Http\Controllers\Admin\LotteryController::class, 'add_new_lottery']);
    Route::post('/save-lottery-name', [App\Http\Controllers\Admin\LotteryController::class, 'save_lottery_name']);
    /* ================== open / close/ running lottery  ================== */
    Route::get('/open-close-lottery-list', [App\Http\Controllers\Admin\LotteryController::class, 'open_close_lottery_list']);
    Route::post('/open-close-lottery-list-data', [App\Http\Controllers\Admin\LotteryController::class, 'open_close_lottery_list_data']);
    Route::post('/open-close-lottery-list-data-reorder', [App\Http\Controllers\Admin\LotteryController::class, 'open_close_lottery_list_data_reorder']);
    Route::post('/generate-lucky-number', [App\Http\Controllers\Admin\LotteryController::class, 'generate_lucky_number']);
    Route::get('/wining-lottery-result', [App\Http\Controllers\Admin\LotteryController::class, 'wining_lottery_result']);
    Route::post('/wining-lottery-result-update', [App\Http\Controllers\Admin\LotteryController::class, 'wining_lottery_result_update']);
    Route::post('/wining-lottery-result-last-update', [App\Http\Controllers\Admin\LotteryController::class, 'wining_lottery_result_last_update']);
    Route::get('/edit-lottery/{id}', [App\Http\Controllers\Admin\LotteryController::class, 'edit_lottery']);
    Route::post('/lottery-update-data/{id}', [App\Http\Controllers\Admin\LotteryController::class, 'lottery_update_data']);
    // winning lottery edit updated added by anamika
    Route::get('/edit-winning-lottery/{id}', [App\Http\Controllers\Admin\LotteryController::class, 'edit_winning_lottery']);
    Route::post('/winning-lottery-update-data/{id}', [App\Http\Controllers\Admin\LotteryController::class, 'winning_lottery_update_data']);

    Route::get('/lottery-result-history', [App\Http\Controllers\Admin\LotteryResultDeclareController::class, 'lottery_result_history']);

    Route::post('/lottery-result-history-data', [App\Http\Controllers\Admin\LotteryResultDeclareController::class, 'lottery_result_history_data']);


    Route::get('/user-lottery-result-amount', [App\Http\Controllers\Admin\TransferLotteryAmountController::class, 'user_lottery_result_amount']);
    Route::post('/user-lottery-result-amount-data', [App\Http\Controllers\Admin\TransferLotteryAmountController::class, 'user_lottery_result_amount_list_data']);
    Route::get('/user-lottery-result-amount-transfer', [App\Http\Controllers\Admin\TransferLotteryAmountController::class, 'user_lottery_result_amount_transfer']);


    Route::get('/product-list', [App\Http\Controllers\Admin\ProductListController::class, 'product_list']);
    Route::post('/product-list-data', [App\Http\Controllers\Admin\ProductListController::class, 'product_list_data']);



    /* ================== report================== */
    Route::get('/search-product-report', [App\Http\Controllers\Admin\ReportController::class, 'search_product_report']);
    Route::post('/search-product-report-data', [App\Http\Controllers\Admin\ReportController::class, 'search_product_report_data']);
    Route::get('/search-product-report-data-list/{date}/{loteryname}/{product}', [App\Http\Controllers\Admin\ReportController::class, 'search_product_report_data_list']);
    Route::get('/report-user-market-list/{name}/{date}', [App\Http\Controllers\Admin\ReportController::class, 'report_user_market_list']);

    
    Route::get('/search-market-report', [App\Http\Controllers\Admin\ReportController::class, 'search_market_report']);
    Route::post('/search-market-report-data', [App\Http\Controllers\Admin\ReportController::class, 'search_market_report_data']);
    Route::get('/search-market-report-data-list/{date}/{loteryname}/{product}', [App\Http\Controllers\Admin\ReportController::class, 'search_market_report_data_list']);

    Route::get('/upload-result-excel', [App\Http\Controllers\Admin\ExcelImportController::class, 'upload_result_excel']);
    Route::post('/upload-upload-result-excel-data', [App\Http\Controllers\Admin\ExcelImportController::class, 'upload_upload_result_excel_data']);
    Route::get('/download-sample-csv', [App\Http\Controllers\Admin\ExcelImportController::class, 'downloadSampleCSV']);
});



Route::get('app/panel-records/{slug}', [App\Http\Controllers\Web\WebController::class, 'app_panel_records']);

