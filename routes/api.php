<?php

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    // CATEGORIES
    $api->group(['namespace' => 'App\Http\Controllers\Api\Category'], function ($api) {
        $api->resource('categories', 'CategoryV1Controller');
    });

    // CUSTOMER INFORMATION
    $api->group(['namespace' => 'App\Http\Controllers\Api\CustomerInformation'], function ($api) {
        $api->resource('customer-informations', 'CustomerInformationV1Controller');
    });

    // PAYMENT METHODS
    $api->group(['namespace' => 'App\Http\Controllers\Api\PaymentMethod'], function ($api) {
        $api->resource('payment-methods', 'PaymentMethodV1Controller');
    });

    // STATUS
    $api->group(['namespace' => 'App\Http\Controllers\Api\Status'], function ($api) {
        $api->resource('statuses', 'StatusV1Controller');
    });
});
