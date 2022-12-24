<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//user register process
Route::prefix("v1")->namespace('api\v1')->middleware('api')->group( function () {
    Route::post('login', 'AuthController@login');
//        Route::post('logout', 'AuthController@logout');
    Route::post('register', 'UserController@register');
    Route::post('verify_activation_code', 'UserController@verify_activation_code');
    Route::post('logout', 'UserController@logout');
});
//without authentication
Route::prefix("v1")->namespace('api\v1')->group( function () {
    Route::get('test-mrt','CartController@TestMrt');
    Route::get('vote/{order:url}',"CartController@vote");
    Route::get('get_products_from_bazara','SchedulerController@get_products_from_bazara');
    Route::resource('cargo', 'CargoController');
    Route::get('get_post_area','PeykController@get_post_area');
    Route::get('pre_order','PeykController@pre_order');
    Route::get('verbal_order','PeykController@verbal_order');
    Route::post('verify_order','CartController@verify_order');
    Route::get('calculateShipment','PeykController@calculateShipment');
    //index page
    Route::get('android' , 'HomeController@android');
    Route::get('index' , 'HomeController@index');
    Route::get('market_info' , 'HomeController@market_info');
    Route::get('comments' , 'HomeController@comments');
    Route::get('search' , 'HomeController@search');
    Route::resource('menu' , 'MenuController');
    //cart
    Route::post('add_to_cart','CartController@add_to_cart');
    Route::post('remove_from_cart','CartController@remove_from_cart');
    Route::post('checkout','CartController@checkout');
    Route::post('checkInventory','CartController@checkInventory');
    Route::delete('empty_cart' , 'CartController@destroy');
    //sync cart
    Route::post('/sync_cart','CartController@sync_cart');
    Route::post('coupon/{coupon}','CouponController@coupon');
});
Route::prefix('v1')->namespace('api\v1')->middleware("auth:api")->group(function() {
    Route::resource('address','AddressController');
    Route::resource('favorite','FavoriteController');

    //user
    Route::post('update_user_info' , 'UserController@update_user_info');
    Route::post('comment' , 'CommentController@store');

    //wallet pay
    Route::post('walletCharge' , 'WalletController@walletCharge');
    Route::get('walletList' , 'WalletController@walletList');

    //profile
    Route::get('profile','UserController@profile');
    Route::get('/orderList','UserController@orderList');
    Route::get('/total_transactions','UserController@total_transactions');

    //cargo
    Route::resource('comment' , 'CommentController');
    //result of payment

    Route::post('set_vote/{order:url}',"CartController@set_vote");
    Route::post('is_delayed/{order:url}',"CartController@is_delayed");

});



