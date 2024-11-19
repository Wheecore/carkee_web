<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Auth::routes(['verify' => true]);

Route::get('/clear-cache', function () {
	Artisan::call('config:cache');
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	return redirect('/');
});

Route::get('/refresh-csrf', function () {
	return csrf_token();
});
Route::get('order-confirmed-view/{order_id}', 'Front\CartController@load_order_confirmed_view');

/*
|--------------------------------------------------------------------------
| Informative pages Routes
|--------------------------------------------------------------------------
|
 */
Route::get('/', 'Front\InformativePagesController@index');
Route::get('/faq', 'Front\InformativePagesController@faq');
Route::get('/contact', 'Front\InformativePagesController@contact');
Route::post('/contact-form-submit', 'Front\InformativePagesController@contact_submit')->name('contact-submit');
Route::get('/about', 'Front\InformativePagesController@about');
Route::get('/team', 'Front\InformativePagesController@team');
Route::get('/privacy-policy', 'Front\InformativePagesController@privacy_policy');
Route::post('/login-user', 'Auth\LoginController@loginUser')->name('login.user');
Route::post('/register-customer', 'Front\InformativePagesController@register_customer')->name('register-customer');

/*
|--------------------------------------------------------------------------
| Workshop Routes
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['seller', 'unbanned', 'verified']], function () {
	Route::get('/home', 'Workshop\HomeController@index')->name('home');
	Route::get('/dashboard', 'Workshop\HomeController@dashboard')->name('dashboard');
	Route::post('/seller/update-profile', 'Workshop\HomeController@seller_update_profile')->name('seller.profile.update');
	Route::group(['prefix' => 'seller'], function () {
		Route::get('shop-settings', 'Workshop\ShopController@index')->name('shop.index');
		Route::post('shop-settings/update/{shop_id}', 'Workshop\ShopController@update')->name('shop.update');

		// workshop availability
		Route::get('workshop-availability', 'Workshop\WorkshopAvailabilityController@index')->name('workshop.availability.index');
		Route::get('request-statuschange/{id}', 'Workshop\WorkshopAvailabilityController@updateRequestStatus')->name('workshop.daterequest.statuschange');
		Route::post('set-workshop-availability', 'Workshop\WorkshopAvailabilityController@store')->name('workshop.availability.store');
		Route::get('get/select_month-timing', 'Workshop\WorkshopAvailabilityController@monthTiming')->name('get.select_month-timing');
		Route::get('get/select_year-timings', 'Workshop\WorkshopAvailabilityController@yearTiming')->name('get.select_year-timings');
		Route::get('get/select_date-timings', 'Workshop\WorkshopAvailabilityController@dateTiming')->name('get.select_date-timings');
	});
	Route::get('updated/date/workshop/orders', 'Workshop\OrderController@update_date_workshop_orders')->name('update_date_workshop_orders');
	Route::get('orders/installation/list', 'Workshop\OrderController@installation_list')->name('orders.installation.list');
	Route::get('workshop/feedbacks', 'Workshop\SellerController@feedbacks')->name('workshop.feedbacks');
	Route::post('/orders/details', 'Workshop\OrderController@order_details')->name('orders.details');
	Route::get('/notification-orders-details/{order_id}/{notification_id}', 'Workshop\OrderController@notification_order_details')->name('notification.orders.details');
	Route::get('updated/date/Workshop\order/approved/{id}', 'Workshop\OrderController@update_date_workshop_order_approved')->name('update_date_workshop_order.approved');
	////notify user come to workshop
	Route::get('/notify-user-come-to-Workshop/{id}', 'Workshop\OrderController@notifyUserComeToWorkshop')->name('notify.user.come.to.workshop');
	Route::get('/scan-qrcode', 'Workshop\QRController@scanQrcode')->name('scan-qrcode');
	Route::get('qrcode-order/{order_id}', 'Workshop\QRController@showOrder');
	Route::get('qrcode-order/{user_id}/{order_id}', 'Workshop\QRController@showUserOrder');
	Route::post('save/car/condition/{id}', 'Workshop\CarConditionController@save')->name('save_car_condition');
	Route::get('/scan-do', 'Workshop\QRController@scanQrcode')->name('scan-do');
	Route::get('/do-order/{order_id}', 'Workshop\QRController@showDO');
	Route::get('/do-order/update/{order_id}', 'Workshop\QRController@updateDO')->name('do-order.update');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['user', 'unbanned', 'verified']], function () {
	Route::post('/customer/update-profile', 'Customer\HomeController@customer_update_profile')->name('customer.profile.update');
	Route::resource('purchase_history', 'Customer\PurchaseHistoryController');
	Route::get('installation_history', 'Customer\PurchaseHistoryController@installation_history')->name('installation_history');
	Route::get('installation_history1/{id}', 'Customer\PurchaseHistoryController@installation_history1')->name('installation_history1');
	Route::post('/purchase_history/details', 'Customer\PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
	Route::get('/purchase_history/destroy/{id}', 'Customer\PurchaseHistoryController@destroy')->name('purchase_history.destroy');

	Route::resource('support_ticket', 'Customer\SupportTicketController');
	Route::post('support_ticket/reply', 'Customer\SupportTicketController@seller_store')->name('support_ticket.seller_store');

	Route::get('/merchants/vouchers', 'Customer\NearMerchantsController@index')->name('near_merchants_vouchers');

	Route::get('/car-list', 'Customer\CarListController@index')->name('carlist');
	Route::get('/car-list-orders/{id}', 'Customer\CarListController@orders')->name('carlist.orders');
	Route::get('/car-list/create', 'Customer\CarListController@create')->name('carlist.create');
	Route::get('/car-list/edit/{id}', 'Customer\CarListController@edit')->name('carlist.edit');
	Route::post('/car-list/update/{id}', 'Customer\CarListController@update')->name('carlist.update');
	Route::get('/car-list/destroy/{id}', 'Customer\CarListController@destroy')->name('carlist.destroy');
	Route::get('qrcodes-download-history', 'Customer\QRController@History')->name('qrcodes_download_history');
	Route::post('view-qrcode-again', 'Customer\QRController@ViewAgain')->name('view-qrcode-again');
	Route::post('download-merchant-voucher-qrcode/{type}', 'Customer\QRController@downloadMerchantVoucherQrcode')->name('qrcode.merchant.voucher');
	Route::get('user/coupons', 'Customer\CouponController@user_coupons')->name('front.user.coupon');
	Route::get('user/order/change/date/{id}', 'Customer\PurchaseHistoryController@ChangeDate')->name('front.user.change.date');
	Route::post('user/order/update/date/{id}', 'Customer\PurchaseHistoryController@updateDate')->name('front.user.update.date');
	Route::post('/submit-order-review', 'Customer\OrderController@submitReview')->name('submit.review');
	Route::get('/reschedule', 'Customer\CheckoutController@reschedule')->name('checkout.reschedule');
	Route::post('/reschedule/update/{id}', 'Customer\CheckoutController@rescheduleUpdate')->name('reschedule.update');
});

// auth routes
Route::group(['middleware' => ['auth', 'unbanned', 'verified']], function () {
	Route::get('/profile', 'Workshop\HomeController@profile')->name('profile');
	Route::post('/new-user-email', 'Workshop\HomeController@update_email')->name('user.change.email');
	Route::resource('addresses', 'Workshop\AddressController');
	Route::resource('orders', 'Workshop\OrderController');
	Route::get('customer-condition-list', 'Workshop\CarConditionController@CustomerList')->name('customer.car.condition.list');
	Route::get('/notifications/{user_id}', 'Workshop\NotificationController@all');
	Route::get('view-order/{order_id}/{notification_id?}', 'Workshop\QRController@viewOrder');
	Route::get('received-order-item/{order_id}', 'Workshop\QRController@receivedOrder');
	Route::get('confirm-order/{order_id}', 'Workshop\QRController@confirmOrder')->name('confirm.order');
	Route::post('reject-order/{order_id}', 'Workshop\QRController@rejectOrder')->name('reject.order');
	Route::get('customer-condition-list-details/{id}', 'Workshop\CarConditionController@CustomerDetails')->name('customer.car.condition.details');
	Route::get('/non-selected-dates', 'Workshop\WorkshopAvailabilityController@getDates')->name('not.set.dates');

	Route::post('/get-city', 'Admin\CityController@get_city')->name('get-city');
	Route::get('/browse/history/delete/{id}', 'Front\BrowseHistoryController@delete')->name('browse.history.delete');
});

/*
|--------------------------------------------------------------------------
| Merchant Routes
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['merchant', 'unbanned', 'verified']], function () {
	Route::post('/merchant/update-profile', 'Merchant\HomeController@merchant_update_profile')->name('merchant.profile.update');
	Route::get('/merchant/vouchers', 'Merchant\HomeController@getMerchantVouchers')->name('merchant.vouchers.index');
	Route::get('/merchant/voucher/check/{voucher_code}/{user_email}', 'Merchant\HomeController@checkMerchantVouchers')->name('merchant.vouchers.check');
	Route::get('/scan-voucher-qrcode', 'Merchant\QRController@scanVoucherQrcode')->name('scan-voucher-qrcode');
});
