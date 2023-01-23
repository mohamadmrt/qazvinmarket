<?php

use Illuminate\Support\Facades\Artisan;

//sceduler
Route::group(['prefix' => 'scheduler'], function () {
    //send sms queue
    Route::get('/send_sms_scheduler', 'SchedulerController@send_sms_scheduler');
    //sync cargos
    Route::get('/get_products_from_bazara', 'SchedulerController@get_products_from_bazara');
    //send factors
    Route::get('/send_factors_to_bazara', 'SchedulerController@send_factors_to_bazara');
    //process orders
    Route::get('/process_orders', 'SchedulerController@process_orders');
    //process incomplete carts
    Route::get('/process_carts', 'SchedulerController@process_carts');
    //birthday
    Route::get('/birthday_scheduler', 'SchedulerController@birthday_scheduler');
    Route::get('/increase_inventory', 'SchedulerController@increase_inventory');
    Route::get('/unsuccess_orders_sms', 'SchedulerController@unsuccess_orders_sms');
});
//home
Route::group(['namespace' => 'Home'], function () {
    Route::get('/test-mrt', 'HomeController@TestMrt');
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/download-apk', 'HomeController@downloadApk');
    Route::get('/term-and-conditions', 'HomeController@termAndConditions');
    Route::get('/menu/{parentId}', 'MenuController@index')->name('menu.index');
    Route::post('/menu/getCargoOfMenu', 'MenuController@getCargoOfMenu')->name('menu.getCargoOfMenu');
    Route::post('/back/{order:url}', 'PayController@back');
    Route::post('wallet_charge_back/{wallet}', 'PayController@wallet_charge_back');
    Route::get('/track-order/{order:url}', 'PayController@track_order');
    Route::get('/vote/{order:url}', 'PayController@vote')->name('vote');
    Route::get('/cache', function () {
        return Artisan::call('cache:clear');
//            return Artisan::call('dump-autoload');
    });

    Route::get('/pay', 'PayController@index')->name('pay.index');
    Route::get('/contact-us', 'HomeController@contactUs')->name('home.ContactUs');
    Route::get('/rules', 'HomeController@rules')->name('home.rules');
    Route::get('/about-us', 'HomeController@aboutUs')->name('home.aboutUs');
    Route::get('/guide', 'HomeController@guideSite')->name('home.guideSite');
});

//dashboards
Route::group(['namespace' => 'User\Auth'], function () {
    Route::post('userLogin', ['as' => 'user.auth', 'uses' => 'UserLoginController@userAuth']);
    Route::get('logout', 'UserLoginController@logout')->name('user.logout');
});
Route::middleware('auth:user')->namespace('User')->group(function () {
    //user
    Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
    Route::get('/credit', 'UserController@credit')->name('user.credit');
    Route::get('/buyList', 'UserController@buyList')->name('user.buyList');
    Route::post('/buyListSearch', 'UserController@buyListSearch')->name('user.buyListSearch');
    Route::get('/transactionList', 'UserController@transactionList')->name('user.transactionList');
    Route::post('/transactionListSearch', 'UserController@transactionListSearch')->name('user.transactionListSearch');
    Route::get('/point', 'UserController@point')->name('user.point');
    Route::get('/referral', 'UserController@referral')->name('user.referral');
    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::get('/addresses', 'UserController@addresses')->name('user.addresses');
});
//ocms
Route::group(['namespace' => 'Admin\Auth', 'prefix' => 'ocms'], function () {
    Route::get('/login', 'AdminLoginController@getAdminLogin')->name('adminLogin');
    Route::post('/login', ['as' => 'admin.auth', 'uses' => 'AdminLoginController@adminAuth']);
    Route::get('/logout', 'AdminLoginController@logout')->name('ocms.logout');
});

Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'ocms'], function () {
    Route::get('/dashboard', 'Auth\AdminController@dashboard')->name('ocms.dashboard');
    Route::get('/orders', 'OrderController@orders')->name('ocms.orders');
    Route::get('/orderList', 'OrderController@orderList')->name('ocms.orderList');
//ocms cargos management
    Route::get('/cargos', 'CargoController@cargos')->name("ocms.cargos");
    Route::get('/cargoList', 'CargoController@cargoList')->name("ocms.cargoList");
    Route::post('/show_cargo/{cargo}', 'CargoController@show_cargo');
    Route::post('/update_cargo/{cargo}', 'CargoController@update_cargo');

    Route::post('/newest_cargo/{cargo}', 'CargoController@newest_cargo')->name('ocms.newest_cargo');
    Route::post('/edit_cargo/{cargo}', 'CargoController@edit_cargo')->name('ocms.edit_cargo');
    Route::get('/menus', 'MenuController@menus')->name('ocms.menus');
    Route::get('/menuList', 'MenuController@menuList')->name('ocms.menuList');

    //menu management
    Route::post('/add_menu', 'MenuController@add_menu')->name('ocms.add_menu');
    Route::post('/add_sub_menu', 'MenuController@add_sub_menu');
    Route::post('/sort_menu', 'MenuController@sort_menu');
    Route::post('/sort_amazings', 'AmazingController@sort_amazings');
    Route::get('/sortSubCat', 'MenuController@sortSubCat');
    Route::get('/delete_menu/{menu}', 'MenuController@delete_menu');
    Route::post('/menu_edit_modal_content/{menu}', 'MenuController@menu_edit_modal_content');
    Route::post('/editSarfasl', 'MenuController@editSarfasl')->name('ocms.editSarfasl');

    Route::post('/cancelledorderList', 'OrderController@cancelledorderList')->name('ocms.cancelledorderList');
    Route::get('/confirmOrder/{order}', 'OrderController@confirmOrder')->name('ocms.confirmOrder');
    Route::post('/cancelOrder/{order}', 'OrderController@cancelOrder')->name('ocms.cancelOrder');
    Route::get('/resendSms/{id}', 'OrderController@resendSms')->name('ocms.resendSms');
    Route::get('/resend_factor/{order}', 'OrderController@resend_factor')->name('ocms.resend_factor');
    Route::get('/success_order/{order}', 'OrderController@success_order')->name('ocms.success_order');
    Route::get('{market}/factorPrint/{order}', 'OrderController@factorPrint');

    Route::get('/users', 'UserController@users')->name('ocms.users');
    Route::get('/wallets', 'UserController@wallets')->name('ocms.wallets');
    Route::get('/userList', 'UserController@userList')->name('ocms.userList');
    Route::post('/increaseCredit', 'UserController@increaseCredit')->name('ocms.increaseCredit');
    Route::post('/historyIncreaseCredit', 'UserController@historyIncreaseCredit')->name('ocms.historyIncreaseCredit');
    Route::get('/walletsList', 'UserController@walletsList')->name('ocms.walletsList');
    Route::post('/block_user', 'UserController@block_user')->name('ocms.block_user');
    Route::get('/unblock/{id}', 'UserController@unblock')->name('ocms.unblock');

    Route::post('/active_market', 'MarketController@active_market')->name('ocms.active_market');
    Route::get('/setting', 'MarketController@setting')->name('ocms.setting');
    Route::get('/settingData/{market}', 'MarketController@settingData');
    Route::post('/changeTel', 'MarketController@changeTel');
    Route::post('/changeBank', 'MarketController@changeBank');
    Route::post('/changeSupport', 'MarketController@changeSupport');
    Route::post('/changeDelayNum/{market}', 'MarketController@changeDelayNum');
    Route::get('/get_markets', 'MarketController@get_markets');
    Route::post('/change_order_mobiles', 'MarketController@change_order_mobiles');
    Route::post('/change_peyk_discount', 'MarketController@change_peyk_discount');
    Route::post('/change_market_tels', 'MarketController@change_market_tels');
    Route::post('/change_market_address', 'MarketController@change_market_address');
    Route::post('/change_shipping_method', 'MarketController@change_shipping_method');
    Route::get('/get_market_times', 'MarketController@get_market_times');
    Route::post('/market_times', 'MarketController@market_times');
    Route::post('/toggle_market_service', 'MarketController@toggle_market_service');
    Route::post('/toggle_market_cash', 'MarketController@toggle_market_cash');
    Route::post('/market_service_why_off', 'MarketController@market_service_why_off');

    Route::get('/peyks', 'PeykController@peyks')->name('ocms.peyk');
    Route::resource('peyk', 'PeykController');

    Route::get('/comments', 'CommentController@comments')->name('ocms.comments');
    Route::get('/commentList', 'CommentController@commentList')->name('ocms.commentList');
    Route::post('/reply_admin/{comment}', 'CommentController@reply_admin');
    Route::post('/delete_comment/{order}', 'CommentController@delete_comment');
    Route::post('/approve_comment/{comment}', 'CommentController@approve_comment');

    Route::get('/amazing', 'AmazingController@amazing')->name('ocms.amazing');
    Route::post('/amazing_list', 'AmazingController@amazing_list');
    Route::get('/amazing/{amazing}', 'AmazingController@show');
    Route::post('/add_amazing/{cargo}', 'AmazingController@add_amazing');
    Route::get('/delete_amazing/{amazing}', 'AmazingController@delete_amazing');

    Route::post('/advertise_list', 'AdvertiseController@advertise_list');
    Route::resource('advertise', 'AdvertiseController');

    Route::resource('coupon', 'CouponController');
    Route::get('/couponsList', 'CouponController@couponsList');
    Route::get('/get_copons_list', 'CouponController@get_copons_list');
    Route::resource('group', 'GroupController');
    Route::get('/groupsList', 'GroupController@groupsList');
    Route::resource('holiday', 'HolidayController');
    Route::get('/holidaysList', 'HolidayController@holidaysList')->name('ocms.holidaysList');

    Route::get('/reports', 'ReportController@reports')->name('ocms.reports');
    Route::get('/reportList', 'ReportController@reportList')->name('ocms.reportList');
    Route::get('/user_most_purchased_view', 'UserController@mostPurchasedView')->name('ocms.userMostPurchasedView');
    Route::get('/user_most_purchased', 'UserController@mostPurchased')->name('ocms.userMostPurchased');
});

