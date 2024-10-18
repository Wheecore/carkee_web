<?php
Route::get('/browse/history', 'Front\BrowseHistoryController@index')->name('browse.history');
Route::get('/all-merchants', 'NearMerchantsController@frontIndex')->name('all-merchants.index');
Route::resource('subscribers', 'SubscriberController');
Route::post('/cart/nav-cart-items', 'CartController@updateNavCart')->name('cart.nav_cart');
Route::post('/cart/removeFromCart', 'CartController@removeFromCart')->name('cart.removeFromCart');
Route::post('/compare/addToCompare', 'CompareController@addToCompare')->name('compare.addToCompare');
Route::post('/cart/show-cart-modal', 'CartController@showCartModal')->name('cart.showCartModal');
Route::post('/cart/addtocart', 'CartController@addToCart')->name('cart.addToCart');
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/car-list-front/store', 'CarListController@storeFrontSide')->name('carlist.front.store');

// auth routes
Route::group(['middleware' => ['auth', 'unbanned', 'verified']], function () {

    Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');

    Route::resource('messages', 'MessageController');

    //Reports
    Route::get('/voucher-details/{id}', 'NearMerchantsController@voucherDetails')->name('voucher.details');
    Route::resource('shops', 'ShopController');
    Route::get('express/delivery', 'CheckoutController@express_delivery');

    Route::get('/view-notify-user-workshop/{id}', [OrderController::class, 'updateNofityWorkshopOrder']);
    //order review
    Route::get('/order-review/{id}', [OrderController::class, 'review']);
    Route::post('download-user-qrcode/{type}', 'QRController@downloadUserQrcode')->name('qrcode.user.download');
});

Route::get('/update-cart-summary', 'CartController@updateCartSummary')->name('update-cart-summary');
Route::post('get/merchant/vouchers', 'NearMerchantsController@getMerchantVouchers')->name('get.near_merchants_vouchers');
Route::get('vehicle-details/{id}', [VehicleDetailsController::class, 'index'])->name('vehicle.details');

Route::get('/package/details/{id}', 'PackageDetailsController@details')->name('package.details');

Route::get('aboutus', 'IndexController@about_us')->name('aboutus');

Route::post('/checkout/payment_charges/{id}', [OrderController::class, 'payment_charges'])->name('checkout.payment_charges');

Route::get('alert-list-order/{id}', 'Workshop\CarConditionController@alertListOrder');

//Ipay88
Route::get('/ipay88', 'Ipay88Controller@ipay88')->name('ipay88');
Route::post('/ipay88/response', 'Ipay88Controller@response')->name('ipay88.response');
Route::post('/ipay88/backend', 'Ipay88Controller@backend')->name('ipay88.backend');
Route::get('/ipay88/cancel', 'Ipay88Controller@cancel')->name('ipay88.cancel');


Route::get('/order/b/m/d/v/{id}', 'OrderController@bmdv')->name('bmdv');
Route::get('/demo/cron_1', 'DemoController@cron_1');
Route::get('/demo/cron_2', 'DemoController@cron_2');
Route::get('/convert_assets', 'DemoController@convert_assets');
Route::get('/convert_category', 'DemoController@convert_category');
Route::get('/convert_tax', 'DemoController@convertTaxes');
Route::get('/insert_product_variant_forcefully', 'DemoController@insert_product_variant_forcefully');
Route::get('/update_seller_id_in_orders/{id_min}/{id_max}', 'DemoController@update_seller_id_in_orders');

Route::get('get-size-sub-cats', 'SizeController@ajaxsubcategory');
Route::get('get-size-child-cats', 'SizeController@ajaxchildcategory');
Route::get('get-size-products', 'SizeController@products');


Route::get('/get-subchlid-brand', [IndexController::class, 'brandSubChildes']);
Route::get('/searching-brand-products/{id}/{category}/{chk}', [IndexController::class, 'searchingBrandProducts']);
Route::get('/searching-brand-products/{id}/{category}/{chk}/{brand_id}/{model_id}/{details_id}', [IndexController::class, 'searchingBrandProductsResult']);
Route::get('/edit-search-modelsearching-brand-products/{id}/{category}/{chk}/{brand_id}/{model_id}/{details_id}', [IndexController::class, 'searchingBrandProducts']);
Route::get('/searching-brand-packages/{id}/{category}', [IndexController::class, 'searchingBrandPackages']);
Route::get('/get-brand-by-search', [IndexController::class, 'searchingBrands']);
Route::get('/count-brand-childes', [IndexController::class, 'countChildes']);
Route::get('/edit-car-model-list', [IndexController::class, 'editCarModelList']);

//user address
Route::get('/order-user-address/{id}', [QRController::class, 'user_address']);
Route::get('/order-user-notify/{id}', [QRController::class, 'user_notify']);
Route::get('/order-user-notify-carlist/{id}', [QRController::class, 'user_notify_carlist']);
Route::get('/order-user-day-alert/{id}', [QRController::class, 'day_alert']);
Route::get('/order-user-hour-alert/{id}', [QRController::class, 'hour_alert']);


Route::get('/get-ca-models', [CarModelController::class, 'ajax']);
Route::get('/get-ca-details', [CarDetailsController::class, 'ajax']);
Route::get('/get-vehicle-size', [CarDetailsController::class, 'vehicle_size']);
Route::get('/get-alternative-size', [CarDetailsController::class, 'alternative_size']);
Route::get('/get-ca-years', [CarVariantController::class, 'ajax']);

Route::get('/get-user-ca-models', [CarModelController::class, 'ajaxSaveUserModels']);
Route::get('/get-user-ca-details', [CarDetailsController::class, 'ajaxSaveUserDetails']);


Route::get('/get-models', [IndexController::class, 'ajax_models']);
Route::get('/get-car-details', [IndexController::class, 'ajax_car_details']);
Route::get('/get-car-years', [IndexController::class, 'ajax_car_years']);
Route::get('/get-car-types', [IndexController::class, 'ajax_car_types']);

Route::get('/get-p-models', [IndexController::class, 'ajax_p_models']);
Route::get('/get-p-car-details', [IndexController::class, 'ajax_p_car_details']);
Route::get('/get-p-car-years', [IndexController::class, 'ajax_p_car_years']);
Route::get('/get-p-car-types', [IndexController::class, 'ajax_p_car_types']);

////
Route::get('/panic', [IndexController::class, 'panic'])->name('panic');
Route::get('/search/result', [IndexController::class, 'searchResultFun'])->name('search.result');
Route::get('/package/remind/{id}/{user_id}', [IndexController::class, 'package_remind'])->name('package.remind');
Route::get('/package/remind/weekly/{id}/{user_id}', [IndexController::class, 'package_remind_weekly']);


Route::post('/car-list/store', [CarListController::class, 'store'])->name('carlist.store');

//back search
Route::get('/get-back-brands', [IndexController::class, 'back_brands']);
Route::get('/get-tyres', [SizeController::class, 'getTyres']);

Route::get('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/verification-confirmation/{code}', 'Auth\VerificationController@verification_confirmation')->name('email.verification.confirmation');

Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
Route::get('/users/login', 'HomeController@login')->name('user.login');

Route::get('/sitemap.xml', function () {
    return base_path('sitemap.xml');
});

//Route::get('/featured/category/{category_slug}', 'HomeController@listingByFeaturedCategory')->name('products.featured.category');
//Route::get('/featured/sub/category/{category_slug}', 'HomeController@listingByFeaturedSubCategory')->name('products.featured.sub.category');

Route::post('/cart/updateQuantity', 'CartController@updateQuantity')->name('cart.updateQuantity');
Route::post('/remove/all', 'CartController@removeAll')->name('remove.all');

//Checkout Routes
Route::group(['middleware' => ['checkout']], function () {
    Route::post('/checkout', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');
    Route::get('/check-timings', 'CheckoutController@checkTimings')->name('check-timings');
    //    Route::get('/near-by', 'HomeController@nearByStores')->name('nearby-stores');

    Route::any('/checkout/delivery_info', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
    Route::post('/checkout/payment_select', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');
    Route::get('/checkout/payment_select', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');
    Route::get('/get-shop-date-time', 'CheckoutController@getShopDateTime')->name('shop.get-date-time');
});

Route::get('/checkout/order-confirmed', 'CheckoutController@order_confirmed')->name('order_confirmed');
Route::post('/checkout/payment', 'CheckoutController@checkout')->name('payment.checkout');
Route::post('/checkout/payment/charges', 'CheckoutController@checkout_charges')->name('payment.checkout.charges');
Route::get('/checkout/payment-select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
Route::post('/checkout/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
Route::post('/checkout/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');

//Paypal START
Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel');
//Paypal END

//Stipe Start
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('/stripe/create-checkout-session', 'StripePaymentController@create_checkout_session')->name('stripe.get_token');
Route::any('/stripe/payment/callback', 'StripePaymentController@callback')->name('stripe.callback');
Route::get('/stripe/success', 'StripePaymentController@success')->name('stripe.success');
Route::get('/stripe/cancel', 'StripePaymentController@cancel')->name('stripe.cancel');
//Stripe END

Route::get('/compare', 'CompareController@index')->name('compare');
Route::get('/compare/reset', 'CompareController@reset')->name('compare.reset');

Route::post('/addresses/update/{id}', 'AddressController@update')->name('addresses.update');
Route::get('/addresses/destroy/{id}', 'AddressController@destroy')->name('addresses.destroy');
Route::get('/addresses/set_default/{id}', 'AddressController@set_default')->name('addresses.set_default');

//mobile app balnk page for webview
Route::get('/mobile-page/{slug}', 'PageController@mobile_custom_page')->name('mobile.custom-pages');

//View Package
Route::get('/package-details/{id}', [IndexController::class, 'package_details']);
Route::get('/cart/packageToCart/{id}', 'CartController@packageToCart');
Route::get('/package/show/{id}', 'PackageController@show')->name('front.package.show');
Route::post('/package/onebyone', 'PackageController@onebyone')->name('package.onebyone');
