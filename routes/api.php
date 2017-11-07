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

Route::group([
    'prefix' => 'customer',
    'middleware' => [ 'api_response'],
], function () {

    Route::post('login', 'Customer\Auth\LoginController@login');

    Route::post('register', 'Customer\Auth\RegisterController@register');

    Route::get('logout', 'Customer\Auth\LoginController@logout');

    Route::post('purchase/{orderId}/process/{channelKey}', "Customer\Order\PurchaseController@process");



    Route::group(['middleware' => ['auth:customer', 'check_role:customer']], function () {

        // Authentication Routes...

        Route::get('logout', 'Customer\Auth\LoginController@logout');

        Route::get('test', function(){
            return "oke";
        });

        Route::post('order', 'Customer\Order\OrderController@make');
        Route::get('order', 'Customer\Order\OrderController@all');

        // cart
        Route::post('cart/product', 'Customer\Cart\CartController@setProduct');
        Route::post('cart/location', 'Customer\Cart\CartController@setLocation');
        Route::post('cart/booking_date', 'Customer\Cart\CartController@setBookingdate');
        Route::post('cart/voucher', 'Customer\Cart\CartController@setVoucher');
        Route::get('cart', 'Customer\Cart\CartController@cart');
        Route::post('cart/checkout', 'Customer\Cart\CartController@checkout');


        // purchase
        Route::get('purchase/{orderId}/params', "Customer\Order\PurchaseController@getParams");
        Route::get('purchase/{orderId}/detail', "Customer\Order\PurchaseController@detail");
//        Route::get('purchase/{orderId}/process', "Customer\Order\PurchaseController@process");


        // product
        Route::get('products', 'Customer\Product\ProductController@index');
        Route::get('products/{sku}', 'Customer\Product\ProductController@show');


        // home


    });

    Route::get('home', 'Customer\HomeController');


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


Route::post('pn/reg', 'PushNotification\PushNotificationController@register');



Route::group([
    'prefix' => 'therapist',
    'middleware' => ['api_response'],
], function () {
    // Authentication Routes...

    Route::post('login', 'Therapist\Auth\LoginController@login');

    Route::post('register', 'Therapist\Auth\RegisterController@register');

    Route::get('logout', 'Therapist\Auth\LoginController@logout');

    Route::post('order/response', 'Therapist\Auth\RegisterController@register');

    Route::group(['middleware' => ['auth:customer', 'check_role:customer']], function () {


        Route::post('order/accept_reject', 'Therapist\OrderController@acceptReject');
        Route::get('order/detail', 'Therapist\OrderController@detail');


        Route::post('settings/order', 'Therapist\SettingsController@setOrder');
        Route::get('settings/order/{invoiceNumber}', 'Therapist\SettingsController@getOrder');

        Route::post('current_location', 'Therapist\CurrentLocationController');



        // isi wallet
        Route::post('wallet/debit', 'Therapist\WalletController@debit');

    });


    Route::get('test', function(){
        $b = new \App\Models\Bidding\BiddingTherapist(null, new \App\Models\Bidding\Offer(), new \App\Models\Therapist\Therapist());


        $t = $b->getTherapist();

//        $b->assign($t);

        print_r($t->toArray());
        $t->notify(new \App\Notifications\BiddingOrder((new \App\Models\Order())->find(44)));
//
//        Notification::send($t, new InvoicePaid($invoice));

        return $t;

    });

    Route::get('reset', function(){
        $b = new \App\Models\Bidding\BiddingTherapist(null, new \App\Models\Bidding\Offer(), new \App\Models\Therapist\Therapist());

        $b->reset();

    });

});