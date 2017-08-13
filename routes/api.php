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

/** Customer  */

Route::post('customer/login', 'Customer\Auth\LoginController@login');

Route::post('customer/register', 'Customer\Auth\RegisterController@register');

Route::get('customer/logout', 'Customer\Auth\LoginController@logout');



Route::group([
    'prefix' => 'customer',
    'middleware' => ['auth:customer', 'check_role:customer', 'api_response'],
], function () {
    // Authentication Routes...

    Route::get('logout', 'Customer\Auth\LoginController@logout');

    Route::get('test', function(){
       return "oke";
    });

    Route::post('order', 'Customer\Order\OrderController@make');
    Route::get('order', 'Customer\Order\OrderController@all');

});


/** Admin Area */

Route::post('admin/login', 'Admin\Auth\LoginController@login');

Route::post('admin/register', 'Admin\Auth\RegisterController@register');

Route::get('admin/logout', 'Admin\Auth\LoginController@logout');



Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:admin', 'check_role:admin'],
], function () {
    // Authentication Routes...

    Route::get('logout', 'Admin\Auth\LoginController@logout');
    Route::get('test', function(){
        return "oke";
    });

    Route::resource('product', 'Admin\Product\ProductController');

});
