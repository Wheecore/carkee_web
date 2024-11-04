<?php
Route::prefix('v2/auth')->group(function () {
    Route::get('/', function() {
        return response()->json([
            'status'  => TRUE,
            'message' => 'Connected successfully!',
            'data'    => [],
        ]);
    });
    Route::post('login', 'Api\V2\AuthController@login');
    Route::post('signup', 'Api\V2\AuthController@signup');
    Route::post('social-login', 'Api\V2\AuthController@socialLogin');
    Route::post('password/forget_request', 'Api\V2\PasswordResetController@forgetRequest');
    Route::post('password/confirm_reset', 'Api\V2\PasswordResetController@confirmReset');
    Route::post('password/resend_code', 'Api\V2\PasswordResetController@resendCode');
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'Api\V2\AuthController@logout');
        Route::get('user', 'Api\V2\AuthController@user');
    });
    Route::post('resend_code', 'Api\V2\AuthController@resendCode');
    Route::post('confirm_code', 'Api\V2\AuthController@confirmCode');
});

Route::prefix('v2')->group(function () {

    Route::get('invoice/download/{order_id}', 'Api\V2\CheckoutController@invoice_download');
    Route::get('emergency-order-invoice/download/{order_id}/{type?}', 'Api\V2\EmergencyOrdersController@invoice_download');
    Route::post('/ipay-webview/{order_id}/{reschedule?}', 'Api\V2\Ipay88Controller@ipayWebView');
    Route::post('/wallet-webview', 'Api\V2\Ipay88Controller@wallet_webview');
    Route::post('/carwash-success-webview/{order_id}', 'Api\V2\CarWashesController@carwash_success_view');
    Route::post('api/ipay88/response', 'Api\V2\Ipay88Controller@response');
    Route::post('api/ipay88/backend', 'Api\V2\Ipay88Controller@backend');
    Route::get('all-feedbacks', 'Api\V2\HomeCategoryController@allFeedbacks');
    Route::get('view-all-products/{type}', 'Api\V2\HomeCategoryController@viewAllProducts');

    Route::post('/check-battery-specifications', 'Api\V2\EmergencyServicesController@check_battery_specifications');
    Route::get('/show-deal-products/{deal_id}', 'Api\V2\HomeCategoryController@show_deal_products');

    // Shops
    Route::post('/shops', 'Api\V2\ShopsController@shops');
    Route::post('/shop-details', 'Api\V2\ShopsController@shop_details');
    Route::post('/show-all_reviews', 'Api\V2\ProductController@all_reviews');

    Route::middleware('auth:api')->group(function () {
        // Car List Routes
        Route::post('/select-your-car-list', 'Api\V2\EmergencyServicesController@select_your_carlist');
        Route::post('/delete-select-your-car-list', 'Api\V2\EmergencyServicesController@delete_select_your_carlist');

        // Emergency Batteries Routes
        Route::post('/list-selected-battery-products', 'Api\V2\EmergencyServicesController@list_selected_battery_products');
        Route::post('/jumpstart-battery', 'Api\V2\EmergencyServicesController@jumpstart_battery');
        Route::post('/battery-add-to-cart', 'Api\V2\EmergencyServicesController@battery_add_to_cart');
        Route::post('/update-battery-qty-in-cart', 'Api\V2\EmergencyServicesController@update_battery_qty_in_cart');
        Route::post('/review-battery', 'Api\V2\EmergencyServicesController@review_battery');

        // Emergency Tyre Route
        Route::get('/emergency-spare-tyre-change', 'Api\V2\EmergencyServicesController@spareTyreChange');

        // Emergency Petrol Route
        Route::get('/emergency-petrol', 'Api\V2\EmergencyServicesController@emergencyPetrol');

        // Emergency Routes
        Route::get('/emergency-order-confirm-and-check', 'Api\V2\EmergencyServicesController@emergencyConfirmAndCheck');
        Route::post('/confirm-emergency-order', 'Api\V2\EmergencyServicesController@confirmEmergencyOrder');

        // Car Wash Api
        Route::get('/car-wash-technician-dashboard/{id}', 'Api\V2\CarWashesController@dashboard');
        Route::get('/car-wash-technician-profile', 'Api\V2\CarWashesController@car_wash_profile_data');
        Route::post('/car-wash-technician-profile', 'Api\V2\CarWashesController@car_wash_profile');
        Route::post('/car-wash-technician-usage-details', 'Api\V2\CarWashesController@usage_detail');
        Route::post('/car-wash-technician-usage-review', 'Api\V2\CarWashesController@usage_review');
        Route::post('/car-wash-checkout-membership', 'Api\V2\CarWashesController@carwash_checkout_membership');
        Route::post('/car-wash-membership-screen', 'Api\V2\CarWashesController@carwash_membership_screen');

        // Services Api
        Route::post('/services-page', 'Api\V2\ServicesController@services_page');
        Route::post('/services', 'Api\V2\ServicesController@all_services');
        Route::post('/services-package-products', 'Api\V2\ServicesController@services_package_products');
        Route::post('/service-package-overview', 'Api\V2\ServicesController@service_package_overview');
        Route::post('/services-package-product-group', 'Api\V2\ServicesController@services_package_product_group');
        Route::post('/services-package-add-to-cart', 'Api\V2\ServicesController@services_package_add_to_cart');
        Route::post('remove-cart-items', 'Api\V2\CartController@remove_cart_items');

        Route::post('carts/get-shipping-info', 'Api\V2\CartController@get_shipping_info');
        Route::post('set_geolocation', 'Api\V2\CartController@setGeolocation');
        Route::get('/check-timings', 'Api\V2\CartController@checkTimings');
        Route::post('/store-delivery_info', 'Api\V2\CheckoutController@store_delivery_info');
        Route::post('/checkout/payment', 'Api\V2\CheckoutController@checkout');
        Route::get('notifications/{user_id}', 'Api\V2\CustomerController@notifications');
        Route::get('notification-seen/{id}', 'Api\V2\CustomerController@notification_seen');
        Route::get('/order-user-address/{order_id}', 'Api\V2\CustomerController@user_address');
        Route::get('/remain-days-order-details/{order_id}', 'Api\V2\CustomerController@remainDaysOrderDetails');
        Route::get('/remain-hours-order-details/{order_id}', 'Api\V2\CustomerController@remainHourAlert');
        Route::get('/update-Request-Status/{availability_id}', 'Api\V2\CustomerController@updateRequestStatus');
        Route::get('profile-view/{user_id}', 'Api\V2\ProfileController@profilePage');
        Route::post('profile-update/{user_id}', 'Api\V2\ProfileController@profileUpdate');
        Route::get('shop-data/{user_id}', 'Api\V2\MerchantController@shopData');
        Route::post('shop-data-update/{shop_id}/{user_id}', 'Api\V2\MerchantController@updateShopInfo');

        // coupon routes
        Route::post('coupon-apply', 'Api\V2\CheckoutController@apply_coupon_code');
        Route::post('coupon-remove', 'Api\V2\CheckoutController@remove_coupon_code');

        // Emergency coupon routes
        Route::post('emergency-coupons', 'Api\V2\EmergencyServicesController@allCoupons');

        // Workshop Routes
        Route::prefix('workshop')->group(function () {
            Route::get('dashboard/{user_id}', 'Api\V2\WorkshopController@dashboard');
            Route::get('orders/{user_id}', 'Api\V2\WorkshopController@orders');
            Route::get('order-details/{order_id}', 'Api\V2\WorkshopController@orderDetails');
            Route::get('car-condition-list/{user_id}', 'Api\V2\WorkshopController@CarConditionList');
            Route::get('installation-list/{user_id}', 'Api\V2\WorkshopController@installationList');
            Route::get('notify-user-come-to-workshop/{order_id}', 'Api\V2\WorkshopController@notifyUserComeToWorkshop');
            Route::get('qrcode-order/{order_id}/{type?}', 'Api\V2\WorkshopController@showOrderAfterQRScan');
            Route::get('received-order-item/{order_id}/{user_id}', 'Api\V2\WorkshopController@receivedOrder');
            Route::get('confirm-order/{order_id}', 'Api\V2\WorkshopController@confirmOrder');
            Route::post('reject-order/{order_id}', 'Api\V2\WorkshopController@rejectOrder');
            Route::get('qrcode-order/{customer_id}/{order_id}/{user_id}', 'Api\V2\WorkshopController@showUserOrder');
            Route::post('save/car/condition/{order_id}/{user_id}', 'Api\V2\WorkshopController@saveCarCondition');
            Route::post('profile-update/{user_id}', 'Api\V2\WorkshopController@profileUpdate');
            Route::get('feedbacks/{user_id}', 'Api\V2\WorkshopController@feedbacks');
            Route::get('delete/feedback/{feedback_id}', 'Api\V2\WorkshopController@deleteCustomerFeedback');
            Route::get('updated-date-orders/{user_id}', 'Api\V2\WorkshopController@updatedDateOrders');
            Route::get('updated-date-order-status-approve/{order_id}', 'Api\V2\WorkshopController@approveDateStatus');
        });

        // customer routes
        Route::prefix('customer')->group(function () {
            Route::get('dashboard/{user_id}', 'Api\V2\CustomerController@dashboard');
            Route::get('vehicle-data/{vehicle_id}', 'Api\V2\CustomerController@get_vehicle_data');
            Route::get('car-list/create', 'Api\V2\CustomerController@createCarlist');
            Route::post('car-list/store/{user_id}', 'Api\V2\CustomerController@storeCarlist');
            Route::get('car-list/edit/{list_id}', 'Api\V2\CustomerController@editList');
            Route::post('car-list/update/{list_id}', 'Api\V2\CustomerController@updateList');
            Route::get('car-list/delete/{list_id}', 'Api\V2\CustomerController@deleteList');
            Route::get('carwash-orders-history/{user_id}', 'Api\V2\CustomerController@carwash_orders_history');
            Route::get('transaction-history/{user_id}/{type}', 'Api\V2\CustomerController@transactionHistory');
            Route::get('reschedule-date/{order_id}', 'Api\V2\CustomerController@rescheduleDate');
            Route::post('reschedule-date-submit', 'Api\V2\CustomerController@rescheduleDateSubmit');
            Route::post('reschedule-payment-submit', 'Api\V2\CustomerController@rescheduleDatePaymentSubmit');
            Route::get('purchase_history/details/{order_id}/{type?}', 'Api\V2\CustomerController@transaction_history_details');
            Route::get('installation_history/{user_id}/{order_id?}', 'Api\V2\CustomerController@installation_history');
            Route::get('reschedule_payment_history/{user_id}', 'Api\V2\CustomerController@reschedule_payment_history');
            Route::get('order-review/{order_id}/{user_id}', 'Api\V2\CustomerController@reviewPage');
            Route::post('submit-order-review', 'Api\V2\CustomerController@submitOrderReview');
            Route::post('submit-package-review', 'Api\V2\CustomerController@submitPackageReview');
            Route::post('submit-product-review', 'Api\V2\CustomerController@storeProductReview');
            Route::post('customer-condition-list', 'Api\V2\CustomerController@carConditionList');
            Route::get('view-again-qr-code/{qrcode_id}', 'Api\V2\CustomerController@ViewAgain');
            Route::get('referral-Url/{user_id}', 'Api\V2\CustomerController@referralUrl');
            Route::get('user-coupons/{user_id}', 'Api\V2\CustomerController@userCoupons');
            Route::post('carlist-orders', 'Api\V2\CustomerController@carlistOrders');
            Route::post('/reassign-workshop', 'Api\V2\CustomerController@orderReAssign');
            Route::get('/complete-order/{order_id}', 'Api\V2\CustomerController@completeUserOrder');
            Route::get('/track-order/{order_id}', 'Api\V2\CustomerController@track_order');

            // Emergency Battery orders
            Route::get('battery_orders', 'Api\V2\EmergencyOrdersController@customerBatteryOrders');
            Route::get('/battery_orders/show/{id}', 'Api\V2\EmergencyOrdersController@customerBatteryOrderDetails');

            // Emergency Tyre orders
            Route::get('/tyre_orders', 'Api\V2\EmergencyOrdersController@customerTyreOrders');
            Route::get('/emergency_order/details', 'Api\V2\EmergencyOrdersController@customerEmergencyOrderShow');

            // Emergency Petrol orders
            Route::get('/petrol_orders', 'Api\V2\EmergencyOrdersController@customerPetrolOrders');

            // Car Wash Api
            Route::get('/car-wash-technician-dashboard/{id}', 'Api\V2\CarWashesController@dashboard');
            Route::post('/car-wash-list-products', 'Api\V2\CarWashesController@list_car_wash_products');
            Route::post('/car-wash-deal-products', 'Api\V2\CarWashesController@show_carwash_deal_products');
            Route::post('/car-wash-product-details', 'Api\V2\CarWashesController@car_wash_product_details');
            Route::post('/car-wash-checkout', 'Api\V2\CarWashesController@car_wash_checkout');
            Route::post('/car-wash-order-summary', 'Api\V2\CarWashesController@car_wash_order_summary');
            Route::post('/car-wash-active-subscriptions', 'Api\V2\CarWashesController@carWashActiveSubscriptions');
            Route::post('/car-wash-active-subscription-details', 'Api\V2\CarWashesController@carWashActiveSubscriptionDetails');
            Route::post('/car-wash-active-subscription-validated', 'Api\V2\CarWashesController@carWashActiveSubscriptionValidated');
            Route::get('/car-wash-order-details/{order_id}', 'Api\V2\CustomerController@carwash_order_details');

            // battery warranty rewards
            Route::post('scan-battery-warranty/qrcode', 'Api\V2\CustomerController@scanBatteryWarrantyQR');
            Route::get('claim-battery-warranty/reward', 'Api\V2\CustomerController@claimBatteryWarrantyReward');
            Route::get('/battery-warranties/{user_id}', 'Api\V2\CustomerController@battery_warranties');
            Route::get('/cancel-order/{order_id}', 'Api\V2\CustomerController@cancel_order');

            // membership and wallet
            Route::post('check-family-member', 'Api\V2\MembershipController@check_family_member');
            Route::post('add-family-member', 'Api\V2\MembershipController@add_family_member');
            Route::post('family-members', 'Api\V2\MembershipController@family_members');
            Route::post('vehicles-data', 'Api\V2\WalletController@vehicles_data');
            Route::post('wallet-transaction-history', 'Api\V2\WalletController@transaction_history');
            Route::get('wallet-screen/{user_id}', 'Api\V2\WalletController@wallet_screen');
            Route::post('add-money-to-wallet', 'Api\V2\WalletController@add_money_to_wallet');
            Route::post('get-user-vehicles', 'Api\V2\CarWashesController@get_user_vehicles');
            Route::post('wallet-notification-details', 'Api\V2\WalletController@notification_details');
            Route::post('verify-gift-code', 'Api\V2\CarWashesController@verify_gift_code');
            Route::post('gift-code-notification-details', 'Api\V2\CarWashesController@gift_code_notification_details');

            Route::post('message-notification-details', 'Api\V2\CustomerController@show_message_content');
        });

        // merchant routes
        Route::prefix('merchant')->group(function () {
            Route::get('dashboard/{user_id}', 'Api\V2\MerchantController@dashboard');
            Route::get('voucher/check/{merchant_id}/{voucher_code}/{user_email}', 'Api\V2\MerchantController@checkVoucher');
        });
        Route::post('referrals', 'Api\V2\HomeCategoryController@referrals');

        Route::get('delete-user-account/{user_id}', 'Api\V2\AuthController@delete_user_account');
        Route::get('car-condition-list-details/{list_id}/{order_id?}', 'Api\V2\CustomerController@carConditionListDetails');
    });

    Route::post('get/merchant', 'Api\V2\MerchantController@frontMerchants');
    Route::get('get/browsehistory/{user_id}', 'Api\V2\HomeCategoryController@browsehistory_index');
    Route::post('browsehistory-delete', 'Api\V2\HomeCategoryController@browsehistory_delete');
    Route::get('browsehistory-delete-all/{user_id}', 'Api\V2\HomeCategoryController@browsehistory_delete_all');
    Route::post('get/merchant/vouchers/{user_id?}', 'Api\V2\MerchantController@getMerchantVouchers');
    Route::get('/voucher-details/{voucher_id}/{user_email}', 'Api\V2\MerchantController@voucherDetails')->middleware('auth:api');
    Route::post('download/voucher-qr-code/{user_id}', 'Api\V2\MerchantController@merchantVoucherQRcodeDownload');
    Route::get('aboutus/webview', 'Api\V2\HomeCategoryController@aboutUsWebView');
    Route::get('terms/webview', 'Api\V2\HomeCategoryController@termsWebView');
    Route::get('returnpolicy/webview', 'Api\V2\HomeCategoryController@returnpolicyWebView');
    Route::get('privacypolicy/webview', 'Api\V2\HomeCategoryController@privacypolicyWebView');
    Route::get('delivery-policy/webview', 'Api\V2\HomeCategoryController@delivery_policy_webview');
    Route::get('contact_us/webview', 'Api\V2\HomeCategoryController@contactus_webview');

    Route::get('category/{category_id}/{user_id?}', 'Api\V2\CartController@tyrePageData');
    Route::get('categories/{category_name}/{user_id?}', 'Api\V2\CartController@categoryPageData');

    // width
    Route::get('get-size-sub-cats/{size_cat_id}', 'Api\V2\CartController@getSizeSubCats');
    // height
    Route::get('get-size-child-cats/{cat_id}', 'Api\V2\CartController@getSizeChildCats');
    // models
    Route::get('get-ca-models/{brand_id}', 'Api\V2\CartController@getModels');
    // years
    Route::get('get-ca-years/{model_id}', 'Api\V2\CartController@getYears');
    // variants
    Route::get('get-ca-variants/{year_id}', 'Api\V2\CartController@getVariants');

    Route::apiResource('colors', 'Api\V2\ColorController')->only('index');

    Route::get('products/related/{product_id}', 'Api\V2\ProductController@related')->name('products.related');
    Route::post('products/search', 'Api\V2\ProductController@search');
    Route::get('search-first-page/{user_id}', 'Api\V2\ProductController@search_first_page');
    Route::get('delete-search-history/{user_id}', 'Api\V2\ProductController@delete_search_history');
    Route::apiResource('products', 'Api\V2\ProductController')->except(['store', 'update', 'destroy']);

    Route::post('carts/add', 'Api\V2\CartController@add')->middleware('auth:api');
    Route::post('carts/change-quantity', 'Api\V2\CartController@changeQuantity')->middleware('auth:api');
    Route::get('carts/delete/{cart_id}', 'Api\V2\CartController@destroy')->middleware('auth:api');
    Route::post('carts', 'Api\V2\CartController@getList')->middleware('auth:api');
    Route::post('carts/remove-all/products', 'Api\V2\CartController@removeAll')->middleware('auth:api');

    Route::post('get-user-by-access_token', 'Api\V2\UserController@getUserInfoByAccessToken');

    Route::any('stripe', 'Api\V2\StripeController@stripe');
    Route::any('/stripe/create-checkout-session', 'Api\V2\StripeController@create_checkout_session')->name('api.stripe.get_token');
    Route::any('/stripe/payment/callback', 'Api\V2\StripeController@callback')->name('api.stripe.callback');
    Route::any('/stripe/success', 'Api\V2\StripeController@success')->name('api.stripe.success');
    Route::any('/stripe/cancel', 'Api\V2\StripeController@cancel')->name('api.stripe.cancel');

    Route::get('profile/counters/{user_id}', 'Api\V2\ProfileController@counters')->middleware('auth:api');

    Route::get('/{user_id?}', 'Api\V2\HomeCategoryController@homePageData');
});

Route::fallback(function () {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
