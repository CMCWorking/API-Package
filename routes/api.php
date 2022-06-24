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

// AUTHENTICATION
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\Auth', 'as' => 'auth'], function ($api) {
    $api->post('/login', ['as' => 'login', 'uses' => 'AuthV1Controller@login']);
    $api->post('/logout', ['as' => 'logout', 'uses' => 'AuthV1Controller@logout']);
});

$api->version('v1', ['middleware' => 'auth:sanctum'], function ($api) {
    // USERS
    $api->group(['namespace' => 'App\Http\Controllers\Api\User'], function ($api) {
        $api->resource('users', 'UserV1Controller');
    });

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

    // ROLE
    $api->group(['namespace' => 'App\Http\Controllers\Api\Role'], function ($api) {
        $api->resource('roles', 'RoleV1Controller');
    });
});
