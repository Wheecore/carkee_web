<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\LotteryRequestController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;

use Illuminate\Support\Facades\Route;

Route::controller(LotteryRequestController::class)->group(function () {
    Route::get('/checkout','DoCheckout');
    Route::post('/jazzcash-success','paymentStatus');
});
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('social-login', 'social_login');
    Route::post('register', 'register');
    Route::post('delete-user-account', 'delete_user_account');
});
Route::controller(PasswordResetController::class)->group(function () {
    Route::post('password/forget_request', 'forgetRequest');
    Route::post('password/check_code', 'checkCode');
    Route::post('password/confirm_reset', 'confirmReset');
});

Route::middleware('auth:api')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('notifications/{user_id}', 'notifications');
        Route::get('notification-details/{id}', 'notification_details');
        Route::post('update-profile', 'update_profile');
        Route::post('lottery-history', 'lottery_history');
        Route::get('user-data/{id}', 'winner_user_data');
    });

    Route::controller(LotteryRequestController::class)->group(function () {
        Route::post('apply-for-lottery', 'apply_for_lottery');
        Route::post('pick-lottery-winner', 'pick_lottery_winner');
        Route::get('products-lottery-history', 'lottery_history');
        Route::post('product-applied-users', 'product_applied_users');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('get-products', 'get_products');
        Route::post('store-product', 'store');
        Route::get('edit-product/{id}', 'edit');
        Route::post('update-product', 'update');
        Route::post('delete-product', 'destroy');
        Route::get('product-details/{id}', 'details');
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
