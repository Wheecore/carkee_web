<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::group(['prefix' => 'admin'], function () {
        Route::controller(AdminController::class)->group(function () {
            // dashboard
            Route::post('dashboard', 'dashboard');
            Route::post('update-profile', 'update_profile');
            Route::post('change-password', 'change_password');
            // users
            Route::post('users/store', 'user_store');
            Route::post('users/show', 'user_show');
            Route::post('users/update', 'user_update');
            Route::post('users/delete', 'user_delete');
            Route::post('get-users', 'get_users');
            // products
            Route::post('sync-products', 'sync_products');
            Route::post('update-product', 'update_product');
            Route::post('get-products', 'get_products');
            // credit notes
            Route::post('credit-notes', 'get_credit_notes');
            Route::post('credit-notes/update', 'update_credit_notes');
            Route::post('credit-notes/transaction-histrory', 'get_transaction_histrory');
            // orders
            Route::post('get-orders', 'get_orders');
            Route::post('orders/update', 'order_update');
        });
    });
    
    Route::controller(HomeController::class)->group(function () {
        // dashboard
        Route::post('dashboard', 'dashboard');
        Route::post('update-profile', 'update_profile');
        Route::post('change-password', 'change_password');
        // orders
        Route::post('orders/store', 'order_store');
        Route::post('orders/show', 'order_show');
        Route::post('orders/delete', 'order_delete');
        Route::post('get-orders', 'get_orders');
        Route::post('get-products', 'get_products');
        // customers
        Route::post('customers/store', 'customer_store');
        Route::post('customers/show', 'customer_show');
        Route::post('customers/check-due', 'check_customer_due');
        Route::post('customers/update', 'customer_update');
        Route::post('customers/delete', 'customer_delete');
        Route::post('get-customers', 'get_customers');
        Route::post('get-order-customers', 'get_order_customers');
    });
});