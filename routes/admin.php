<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
*/

use App\Http\Controllers\Admin\AffiliateController;

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'unbanned']], function () {
    Route::get('/', 'Admin\HomeController@admin_dashboard')->name('admin.dashboard');
    Route::get('/get-year-sales', 'Admin\HomeController@get_sales_data_by_year')->name('admin.show_year_sales_data');
    Route::get('/get-year-wallet-topup', 'Admin\HomeController@get_wallet_topup_data_by_year')->name('admin.show_year_wallet_data');
    Route::get('/reschedule-payments', 'Admin\HomeController@reschedule_payments')->name('reschedule.payments');
    Route::get('/reschedule-payments-destroy/{id}', 'Admin\HomeController@reschedule_payment_delete')->name('reschedule.payment.destroy');

    Route::resource('size_alternative', 'Admin\SizeAlternativeController');

    Route::get('brands-data/{brand_type}', 'Admin\BrandsDataController@brands')->name('brands.data');
    Route::post('brands-data/store', 'Admin\BrandsDataController@brands_store')->name('brands.data.store');
    Route::get('brands-data/edit/{id}', 'Admin\BrandsDataController@brands_edit')->name('brands.data.edit');
    Route::post('brands-data/update/{id}', 'Admin\BrandsDataController@brands_update')->name('brands.data.update');
    Route::get('/brands-data/destroy/{id}', 'Admin\BrandsDataController@brand_destroy')->name('brands.data.destroy');

    Route::resource('vehicle_size', 'Admin\VehicleSizeController');

    Route::resource('categories', 'Admin\CategoryController');
    Route::get('/categories/edit/{id}', 'Admin\CategoryController@edit')->name('categories.edit');
    Route::get('/categories/destroy/{id}', 'Admin\CategoryController@destroy')->name('categories.destroy');

    Route::resource('brands', 'Admin\CarBrandController');
    Route::get('/brands/edit/{id}', 'Admin\CarBrandController@edit')->name('brands.edit');
    Route::get('/brands/destroy/{id}', 'Admin\CarBrandController@destroy')->name('brands.destroy');

    ///models
    Route::resource('models', 'Admin\CarModelController');
    Route::get('/models/edit/{id}', 'Admin\CarModelController@edit')->name('models.edit');
    Route::get('/models/destroy/{id}', 'Admin\CarModelController@destroy')->name('models.destroy');

    ///years
    Route::resource('years', 'Admin\CarYearController');
    Route::get('/years/edit/{id}', 'Admin\CarYearController@edit')->name('years.edit');
    Route::get('/years/destroy/{id}', 'Admin\CarYearController@destroy')->name('years.destroy');

    ///variants
    Route::resource('variants', 'Admin\CarVariantController');
    Route::get('/variants/edit/{id}', 'Admin\CarVariantController@edit')->name('variants.edit');
    Route::get('/variants/destroy/{id}', 'Admin\CarVariantController@destroy')->name('variants.destroy');

    ///Sizes

    Route::get('size-categories', 'Admin\SizeController@categories')->name('size.categories');
    Route::post('size-category/store', 'Admin\SizeController@categoryStore')->name('size.category.store');
    Route::get('/size-category/edit/{id}', 'Admin\SizeController@categoryEdit')->name('size.category.edit');
    Route::patch('size-category/update/{id}', 'Admin\SizeController@categoryUpdate')->name('size.category.update');
    Route::get('/size-category/destroy/{id}', 'Admin\SizeController@categoryDestroy')->name('size.category.destroy');

    Route::get('size-sub-categories', 'Admin\SizeController@subCategories')->name('size.sub.categories');
    Route::post('size-sub-category/store', 'Admin\SizeController@subCategoryStore')->name('size.sub.category.store');
    Route::get('/size-sub-category/edit/{id}', 'Admin\SizeController@subCategoryEdit')->name('size.sub.category.edit');
    Route::patch('size-sub-category/update/{id}', 'Admin\SizeController@subcategoryUpdate')->name('size.sub.category.update');
    Route::get('/size-sub-category/destroy/{id}', 'Admin\SizeController@subCategoryDestroy')->name('size.sub.category.destroy');

    Route::get('size-child-categories', 'Admin\SizeController@childCategories')->name('size.child.categories');
    Route::post('size-child-category/store', 'Admin\SizeController@childCategoryStore')->name('size.child.category.store');
    Route::get('/size-child-category/edit/{id}', 'Admin\SizeController@childCategoryEdit')->name('size.child.category.edit');
    Route::patch('size-child-category/update/{id}', 'Admin\SizeController@childCategoryUpdate')->name('size.child.category.update');
    Route::get('/size-child-category/destroy/{id}', 'Admin\SizeController@childCategoryDestroy')->name('size.child.category.destroy');
    Route::get('/get-size-sub-cats', 'Admin\SizeController@ajaxsubcategory');


    //////featured category

    Route::get('featured-categories', 'Admin\FeaturedCategoryController@categories')->name('featured.categories');
    Route::post('featured-category/store', 'Admin\FeaturedCategoryController@categoryStore')->name('featured.category.store');
    Route::get('/featured-category/edit/{id}', 'Admin\FeaturedCategoryController@categoryEdit')->name('featured.category.edit');
    Route::patch('featured-category/update/{id}', 'Admin\FeaturedCategoryController@categoryUpdate')->name('featured.category.update');
    Route::get('/featured-category/destroy/{id}', 'Admin\FeaturedCategoryController@categoryDestroy')->name('featured.category.destroy');

    Route::get('featured-sub-categories', 'Admin\FeaturedCategoryController@subCategories')->name('featured.sub.categories');
    Route::post('featured-sub-category/store', 'Admin\FeaturedCategoryController@subCategoryStore')->name('featured.sub.category.store');
    Route::get('/featured-sub-category/edit/{id}', 'Admin\FeaturedCategoryController@subCategoryEdit')->name('featured.sub.category.edit');
    Route::patch('featured-sub-category/update/{id}', 'Admin\FeaturedCategoryController@subcategoryUpdate')->name('featured.sub.category.update');
    Route::get('/featured-sub-category/destroy/{id}', 'Admin\FeaturedCategoryController@subCategoryDestroy')->name('featured.sub.category.destroy');
    Route::get('/get-featured-sub-cats', 'Admin\FeaturedCategoryController@ajaxsubcategory');

    //////vehicle category

    Route::get('vehicle-categories', 'Admin\VehicleCategoryController@categories')->name('vehicle.categories');
    Route::post('vehicle-category/store', 'Admin\VehicleCategoryController@categoryStore')->name('vehicle.category.store');
    Route::get('/vehicle-category/edit/{id}', 'Admin\VehicleCategoryController@categoryEdit')->name('vehicle.category.edit');
    Route::patch('vehicle-category/update/{id}', 'Admin\VehicleCategoryController@categoryUpdate')->name('vehicle.category.update');
    Route::get('/vehicle-category/destroy/{id}', 'Admin\VehicleCategoryController@categoryDestroy')->name('vehicle.category.destroy');

    //82821
    Route::get('/get-size-child-cats', 'Admin\SizeController@ajaxchildcategory');

    ///Services
    ///create package
    Route::resource('packages', 'Admin\PackageController');
    Route::get('/package/products/{id}', 'Admin\PackageController@rocommendEdit')->name('package.products.recommend.edit');
    Route::get('/package/products/addon/{id}', 'Admin\PackageController@addonEdit')->name('package.products.addon.edit');
    Route::get('/package/edit/{id}', 'Admin\PackageController@edit')->name('package.edit');
    Route::get('/package/destroy/{id}', 'Admin\PackageController@destroy')->name('package.destroy');
    Route::post('/package-products-addorupdate', 'Admin\PackageController@packageProductsAddOrUpdate')->name('addorupdate.package.products');

    // Category and Subcategory Routes
    Route::post('car-brand/save-nested-categories', 'Admin\CarBrandController@saveNestedCategories')->name('car-brand.save-nested-categories');

    //car model
    //    Route::get('/car-models', [Admin\CarModelController::class,'index']);
    //    Route::get('/car-model/create', [Admin\CarModelController::class,'create']);
    //    Route::post('/car-model/store', [Admin\CarModelController::class,'store']);
    //    Route::get('/car-model/edit/{id}', [Admin\CarModelController::class,'edit']);
    //    Route::post('/car-model/update/{id}', [Admin\CarModelController::class,'update']);
    //    Route::get('/car-model/delete/{id}', [Admin\CarModelController::class,'delete']);
    //
    Route::post('/get-car-models', 'Admin\CarModelController@ajax');
    Route::post('/get-car-years', 'Admin\CarYearController@ajax');

    Route::post('/p-get-car-models', 'Admin\ProductController@ajaxm');
    Route::post('/p-get-car-years', 'Admin\ProductController@ajaxy');
    Route::post('/p-get-car-variants', 'Admin\ProductController@ajaxv');

    Route::get('/products/all', 'Admin\ProductController@all_products')->name('products.all');
    Route::post('/clear-product', 'Admin\ProductController@clear_product')->name('clear-product');

    Route::get('/products/groups', 'Admin\ProductController@products_groups')->name('products.groups');
    Route::get('all/products/groups', 'Admin\ProductController@all_products_groups')->name('all.products.groups');
    Route::get('/products/create', 'Admin\ProductController@create')->name('products.create');
    Route::get('/products/admin/{id}/edit', 'Admin\ProductController@admin_product_edit')->name('products.admin.edit');
    Route::post('/products/featured', 'Admin\ProductController@updateFeatured')->name('products.featured');
    Route::post('/products/get_products_by_subcategory', 'Admin\ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');
    Route::post('/bulk-product-delete', 'Admin\ProductController@bulk_product_delete')->name('bulk-product-delete');

    // Products Bulk Upload
    Route::get('/product-bulk-upload/index/{product_type}', 'Admin\ProductBulkUploadController@index')->name('product_bulk_upload.index');
    Route::post('/bulk-product-upload/{product_type}', 'Admin\ProductBulkUploadController@bulk_upload')->name('bulk_product_upload');
    Route::group(['prefix' => 'bulk-upload/download'], function () {
        Route::get('/category', 'Admin\ProductBulkUploadController@pdf_download_category')->name('pdf.download_category');
        Route::get('/tyre-brands', 'Admin\ProductBulkUploadController@pdf_download_tyre_brand')->name('pdf.download_tyre_brands');
        Route::get('/battery-brands', 'Admin\ProductBulkUploadController@pdf_download_battery_brand')->name('pdf.download_battery_brands');
        Route::get('/download-battery-subcategories', 'Admin\ProductBulkUploadController@pdf_download_battery_subcategories')->name('pdf.download_battery_subcategories');
        Route::get('/download-battery-childcategories', 'Admin\ProductBulkUploadController@pdf_download_battery_childcategories')->name('pdf.download_battery_childcategories');
        Route::get('/service-brands', 'Admin\ProductBulkUploadController@pdf_download_service_brand')->name('pdf.download_service_brands');
        Route::get('/download-service-subcategories', 'Admin\ProductBulkUploadController@pdf_download_service_subcategories')->name('pdf.download_service_subcategories');
        Route::get('/download-service-subchildcategories', 'Admin\ProductBulkUploadController@pdf_download_service_subchildcategories')->name('pdf.download_service_subchildcategories');
    });

    Route::resource('sellers', 'Admin\SellerController');
    Route::get('sellers_availability-requests', 'Admin\SellerController@availabilityRequests')->name('sellers.availability-requests');
    Route::post('/bulk-requests-delete', 'Admin\SellerController@bulk_requests_delete')->name('bulk-requests-delete');
    Route::get('/bulk-request-delete/{id}', 'Admin\SellerController@destroyRequest')->name('bulk-request-delete');
    Route::post('/request-approval', 'Admin\SellerController@approveRequest')->name('request-approval');
    Route::get('sellers_ban/{id}', 'Admin\SellerController@ban')->name('sellers.ban');
    Route::get('/sellers/destroy/{id}', 'Admin\SellerController@destroy')->name('sellers.destroy');
    Route::post('/bulk-seller-delete', 'Admin\SellerController@bulk_seller_delete')->name('bulk-seller-delete');
    Route::get('/sellers/approve/{id}', 'Admin\SellerController@approve_seller')->name('sellers.approve');
    Route::get('/sellers/reject/{id}', 'Admin\SellerController@reject_seller')->name('sellers.reject');
    Route::get('/sellers/login/{id}', 'Admin\SellerController@login')->name('sellers.login');
    // Sub Sellers
    Route::get('sub_sellers/{seller_id}', 'Admin\SubSellerController@index')->name('sub_sellers.index');
    Route::get('sub_sellers-create/{seller_id}', 'Admin\SubSellerController@create')->name('sub_sellers.create');
    Route::post('sub_sellers-store', 'Admin\SubSellerController@store')->name('sub_sellers.store');
    Route::get('sub_sellers-edit/{id}', 'Admin\SubSellerController@edit')->name('sub_sellers.edit');
    Route::post('sub_sellers-update/{id}', 'Admin\SubSellerController@update')->name('sub_sellers.update');
    Route::get('sub_sellers-delete/{id}', 'Admin\SubSellerController@destroy')->name('sub_sellers.destroy');
    Route::get('sub_sellers_ban/{id}', 'Admin\SubSellerController@ban')->name('sub_sellers.ban');
    Route::post('/bulk-sub_seller-delete', 'Admin\SubSellerController@bulk_seller_delete')->name('bulk-sub_seller-delete');

    Route::resource('merchants', 'Admin\MerchantController');
    Route::get('/merchant/categories', 'Admin\MerchantCategoryController@index')->name('merchant.categories');
    Route::post('/merchant/category/store', 'Admin\MerchantCategoryController@store')->name('merchant.category.store');
    Route::post('/merchant/category/update/{id}', 'Admin\MerchantCategoryController@update')->name('merchant.category.update');
    Route::get('/merchant/category/{id}', 'Admin\MerchantCategoryController@edit')->name('merchant.categories.edit');
    Route::get('/merchant/category/delete/{id}', 'Admin\MerchantCategoryController@destroy')->name('merchant.categories.destroy');
    Route::get('/merchants/destroy/{id}', 'Admin\MerchantController@destroy')->name('merchants.destroy');
    Route::post('/bulk-merchant-delete', 'Admin\MerchantController@bulk_merchant_delete')->name('bulk-merchant-delete');
    Route::get('/merchants/login/{id}', 'Admin\MerchantController@login')->name('merchants.login');
    Route::post('/merchants/profile_modal', 'Admin\MerchantController@profile_modal')->name('merchants.profile_modal');

    Route::resource('merchants-vouchers', 'Admin\MerchantVouchersController');
    Route::get('/merchants-vouchers/destroy/{id}', 'Admin\MerchantVouchersController@destroy')->name('merchants-vouchers.destroy');
    Route::post('/bulk-merchant-vouchers-delete', 'Admin\MerchantVouchersController@bulk_merchant_voucher_delete')->name('bulk-merchant-vouchers-delete');

    Route::resource('customers', 'Admin\CustomerController');
    Route::get('customers_ban/{customer}', 'Admin\CustomerController@ban')->name('customers.ban');
    Route::get('/customers/login/{id}', 'Admin\CustomerController@login')->name('customers.login');
    Route::get('/customers/destroy/{id}', 'Admin\CustomerController@destroy')->name('customers.destroy');
    Route::post('/bulk-customer-delete', 'Admin\CustomerController@bulk_customer_delete')->name('bulk-customer-delete');
    Route::get('/customers-wallet/{user_id}', 'Admin\CustomerController@wallet_history')->name('customers.wallet_history');
    Route::get('/customers-family-members/{user_id}', 'Admin\CustomerController@family_members')->name('customers.family_members');
    Route::post('/customers-wallet-adjustment', 'Admin\CustomerController@wallet_adjustment')->name('customers.wallet_adjust');
    Route::get('/customers-wallet-transactions', 'Admin\CustomerController@wallet_transactions')->name('customers.wallet_transactions');
    Route::get('/customers-car-lists/{user_id}', 'Admin\CustomerController@car_lists')->name('customers.car_lists');
    Route::get('/customers-car_list-destroy/{id}', 'Admin\CustomerController@car_list_delete')->name('customers.car_list.destroy');
    Route::post('/customers-car_list-bulk-destroy', 'Admin\CustomerController@bulk_carlist_delete')->name('customers.bulk_carlist.destroy');
    Route::get('/buy-car_list-membership/{car_id}', 'Admin\CustomerController@buy_carlist_membership')->name('buy-car_list-membership');
    Route::post('/show-user-emails', 'Admin\CustomerController@show_user_emails')->name('customers.show_user_emails');
    Route::post('/add-member', 'Admin\CustomerController@add_member')->name('customers.add_member');
    Route::get('/remove-member/{user_id}', 'Admin\CustomerController@remove_member')->name('customers.remove_member');
    Route::post('/bulk-remove-member', 'Admin\CustomerController@bulk_remove_member')->name('customers.bulk_remove_member');

    Route::get('/newsletter', 'Admin\NewsletterController@index')->name('newsletters.index');
    Route::post('/newsletter/send', 'Admin\NewsletterController@send')->name('newsletters.send');
    Route::post('/newsletter/test/smtp', 'Admin\NewsletterController@testEmail')->name('test.smtp');

    Route::resource('profile', 'Admin\ProfileController');

    Route::post('/business-settings/update', 'Admin\BusinessSettingsController@update')->name('business_settings.update');
    Route::post('/business-settings/update/activation', 'Admin\BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
    Route::get('/general-setting', 'Admin\BusinessSettingsController@general_setting')->name('general_setting.index');
    Route::get('/activation', 'Admin\BusinessSettingsController@activation')->name('activation.index');
    Route::get('/payment-method', 'Admin\BusinessSettingsController@payment_method')->name('payment_method.index');
    Route::get('/file_system', 'Admin\BusinessSettingsController@file_system')->name('file_system.index');
    Route::get('/social-login', 'Admin\BusinessSettingsController@social_login')->name('social_login.index');
    Route::get('/smtp-settings', 'Admin\BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
    Route::get('/google-analytics', 'Admin\BusinessSettingsController@google_analytics')->name('google_analytics.index');
    Route::get('/google-recaptcha', 'Admin\BusinessSettingsController@google_recaptcha')->name('google_recaptcha.index');

    //Facebook Settings
    Route::get('/facebook-chat', 'Admin\BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
    Route::post('/facebook_chat', 'Admin\BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
    Route::get('/facebook-comment', 'Admin\BusinessSettingsController@facebook_comment')->name('facebook-comment');
    Route::post('/facebook-comment', 'Admin\BusinessSettingsController@facebook_comment_update')->name('facebook-comment.update');
    Route::post('/facebook_pixel', 'Admin\BusinessSettingsController@facebook_pixel_update')->name('facebook_pixel.update');

    Route::post('/env_key_update', 'Admin\BusinessSettingsController@env_key_update')->name('env_key_update.update');
    Route::post('/payment_method_update', 'Admin\BusinessSettingsController@payment_method_update')->name('payment_method.update');
    Route::post('/google_analytics', 'Admin\BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
    Route::post('/google_recaptcha', 'Admin\BusinessSettingsController@google_recaptcha_update')->name('google_recaptcha.update');
    //Currency
    Route::get('/currency', 'Admin\CurrencyController@currency')->name('currency.index');
    Route::post('/currency/update', 'Admin\CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'Admin\CurrencyController@updateYourCurrency')->name('your_currency.update');
    Route::get('/currency/create', 'Admin\CurrencyController@create')->name('currency.create');
    Route::post('/currency/store', 'Admin\CurrencyController@store')->name('currency.store');
    Route::post('/currency/currency_edit', 'Admin\CurrencyController@edit')->name('currency.edit');
    Route::post('/currency/update_status', 'Admin\CurrencyController@update_status')->name('currency.update_status');

    //Tax
    Route::resource('tax', 'Admin\TaxController');
    Route::get('/tax/edit/{id}', 'Admin\TaxController@edit')->name('tax.edit');
    Route::get('/tax/destroy/{id}', 'Admin\TaxController@destroy')->name('tax.destroy');
    Route::post('tax-status', 'Admin\TaxController@change_tax_status')->name('taxes.tax-status');

    Route::resource('/languages', 'Admin\LanguageController');
    Route::post('/languages/{id}/update', 'Admin\LanguageController@update')->name('languages.update');
    Route::get('/languages/destroy/{id}', 'Admin\LanguageController@destroy')->name('languages.destroy');
    Route::post('/languages/update_rtl_status', 'Admin\LanguageController@update_rtl_status')->name('languages.update_rtl_status');
    Route::post('/languages/key_value_store', 'Admin\LanguageController@key_value_store')->name('languages.key_value_store');

    // website setting
    Route::group(['prefix' => 'website'], function () {
        Route::view('/header', 'backend.website_settings.header')->name('website.header');
        Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
        Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
        Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
        Route::resource('custom-pages', 'Admin\PageController');
        Route::get('/custom-pages/edit/{id}', 'Admin\PageController@edit')->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', 'Admin\PageController@destroy')->name('custom-pages.destroy');
    });

    Route::resource('roles', 'Admin\RoleController');
    Route::get('/roles/edit/{id}', 'Admin\RoleController@edit')->name('roles.edit');
    Route::get('/roles/destroy/{id}', 'Admin\RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs', 'Admin\StaffController');
    Route::get('/staffs/destroy/{id}', 'Admin\StaffController@destroy')->name('staffs.destroy');

    // Deals
    Route::resource('deals', 'Admin\DealController');
    Route::get('/deals/edit/{id}', 'Admin\DealController@edit')->name('deals.edit');
    Route::get('/deals/destroy/{id}', 'Admin\DealController@destroy')->name('deals.destroy');
    Route::post('/deals/update_status', 'Admin\DealController@update_status')->name('deals.update_status');
    Route::post('/deals/product_discount', 'Admin\DealController@product_discount')->name('deals.product_discount');
    Route::post('/deals/product_discount_edit', 'Admin\DealController@product_discount_edit')->name('deals.product_discount_edit');

    //Subscribers
    Route::get('/subscribers', 'Admin\SubscriberController@index')->name('subscribers.index');
    Route::get('/subscribers/destroy/{id}', 'Admin\SubscriberController@destroy')->name('subscriber.destroy');

    // All Orders
    Route::get('/all_orders', 'Admin\OrderController@all_orders')->name('all_orders.index');
    Route::get('/done/orders/list', 'Admin\OrderController@done_orders')->name('done.orders.list');

    Route::get('/delivery_orders', 'Admin\OrderController@delivery_orders')->name('delivery_orders');
    Route::get('/all_orders/{id}/show', 'Admin\OrderController@all_orders_show')->name('all_orders.show');
    Route::get('/wallet-recharges-details/{id}', 'Admin\OrderController@wallet_recharge_details')->name('wallet.recharge-details');

    Route::get('/all/notifications', 'Admin\HomeController@notifications')->name('admin.notifications');

    Route::post('/bulk-order-status', 'Admin\OrderController@bulk_order_status')->name('bulk-order-status');

    Route::get('/orders/destroy/{id}', 'Admin\OrderController@destroy')->name('orders.destroy');
    Route::post('/bulk-order-delete', 'Admin\OrderController@bulk_order_delete')->name('bulk-order-delete');
    Route::post('/pay_to_seller', 'Admin\CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

    // Emergency Battery orders
    Route::get('/battery_orders', 'Admin\OrderController@batteryOrders')->name('battery_orders.index');
    Route::get('/battery_orders/show/{id}', 'Admin\OrderController@batteryOrderShow')->name('battery_orders.show');

    // Emergency Tyre orders
    Route::get('/tyre_orders', 'Admin\OrderController@tyreOrders')->name('tyre_orders.index');
    Route::get('/tyre_orders/show/{id}', 'Admin\OrderController@tyreOrderShow')->name('tyre_orders.show');

    // Emergency Petrol orders
    Route::get('/petrol_orders', 'Admin\OrderController@petrolOrders')->name('petrol_orders.index');
    Route::get('/petrol_orders/show/{id}', 'Admin\OrderController@petrolOrderShow')->name('petrol_orders.show');

    //Reports
    Route::get('/stock_report', 'Admin\ReportController@stock_report')->name('stock_report.index');
    Route::get('/in_house_sale_report', 'Admin\ReportController@in_house_sale_report')->name('in_house_sale_report.index');
    Route::get('/seller_sale_report', 'Admin\ReportController@seller_sale_report')->name('seller_sale_report.index');
    Route::get('/wish_report', 'Admin\ReportController@wish_report')->name('wish_report.index');

    //Coupons
    Route::resource('coupon', 'Admin\CouponController');
    Route::post('/coupon/get_form', 'Admin\CouponController@get_coupon_form')->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', 'Admin\CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
    Route::get('/coupon/destroy/{id}', 'Admin\CouponController@destroy')->name('coupon.destroy');

    //Emergency Coupons
    Route::get('emergency-coupons', 'Admin\CouponController@emergency_coupons')->name('emergency_coupon.index');
    Route::get('emergency-coupons/create', 'Admin\CouponController@emergency_coupon_create')->name('emergency_coupon.create');
    Route::post('/emergency-coupon/store', 'Admin\CouponController@emergency_coupon_store')->name('emergency_coupon.store');
    Route::get('emergency-coupons/edit/{id}', 'Admin\CouponController@emergency_coupon_edit')->name('emergency_coupon.edit');
    Route::post('/emergency-coupon/update/{id}', 'Admin\CouponController@emergency_coupon_update')->name('emergency_coupon.update');
    Route::get('emergency-coupons/destroy/{id}', 'Admin\CouponController@emergency_coupon_destroy')->name('emergency_coupon.destroy');

    //Gift codes coupons
    Route::resource('gift-codes', 'Admin\GiftCodesController');
    Route::get('/gift-codes-destroy/{id}', 'Admin\GiftCodesController@destroy')->name('gift-codes.destroy');
    Route::get('/export-gift-codes', 'Admin\GiftCodesController@export');

    //Gift codes coupons history
    Route::get('gift-codes-history', 'Admin\GiftCodesHistoryController@index')->name('gift-codes-history.index');
    Route::post('gift-code-assign', 'Admin\GiftCodesHistoryController@assign')->name('gift-code.assign');
    Route::get('/gift-codes-history-destroy/{id}', 'Admin\GiftCodesHistoryController@destroy')->name('gift-codes-history.destroy');

    //Reviews
    Route::get('/reviews', 'Admin\ReviewController@index')->name('reviews.index');
    Route::get('/orders-reviews', 'Admin\ReviewController@orders_reviews')->name('orders-reviews.index');
    Route::get('/packages-reviews', 'Admin\ReviewController@packages_reviews')->name('packages-reviews.index');
    Route::get('/reviews/destroy/{id}', 'Admin\ReviewController@destroy')->name('reviews.destroy');
    Route::get('/order-review/destroy/{id}', 'Admin\ReviewController@orders_review_destroy')->name('order-review.destroy');
    Route::get('/package-review/destroy/{id}', 'Admin\ReviewController@package_review_destroy')->name('package-review.destroy');

    //Support_Ticket
    Route::get('support_ticket/', 'Admin\SupportTicketController@admin_index')->name('support_ticket.admin_index');
    Route::get('support_ticket/{id}/show', 'Admin\SupportTicketController@admin_show')->name('support_ticket.admin_show');
    Route::post('support_ticket/reply', 'Admin\SupportTicketController@admin_store')->name('support_ticket.admin_store');

    //conversation of seller customer
    Route::get('conversations', 'Admin\ConversationController@admin_index')->name('conversations.admin_index');
    Route::get('conversations/{id}/show', 'Admin\ConversationController@admin_show')->name('conversations.admin_show');

    Route::post('/sellers/profile_modal', 'Admin\SellerController@profile_modal')->name('sellers.profile_modal');
    Route::post('/sellers/approved', 'Admin\SellerController@updateApproved')->name('sellers.approved');

    //Colors
    Route::get('/colors', 'Admin\AttributeController@colors')->name('colors');
    Route::post('/colors/store', 'Admin\AttributeController@store_color')->name('colors.store');
    Route::get('/colors/edit/{id}', 'Admin\AttributeController@edit_color')->name('colors.edit');
    Route::post('/colors/update/{id}', 'Admin\AttributeController@update_color')->name('colors.update');
    Route::get('/colors/destroy/{id}', 'Admin\AttributeController@destroy_color')->name('colors.destroy');

    //Shipping Configuration
    Route::get('/shipping_configuration', 'Admin\BusinessSettingsController@shipping_configuration')->name('shipping_configuration.index');
    Route::post('/shipping_configuration/update', 'Admin\BusinessSettingsController@shipping_configuration_update')->name('shipping_configuration.update');

    // Route::resource('pages', 'Admin\PageController');
    // Route::get('/pages/destroy/{id}', 'Admin\PageController@destroy')->name('pages.destroy');

    Route::resource('countries', 'Admin\CountryController');
    Route::post('/countries/status', 'Admin\CountryController@updateStatus')->name('countries.status');

    Route::resource('cities', 'Admin\CityController');
    Route::get('/cities/edit/{id}', 'Admin\CityController@edit')->name('cities.edit');
    Route::get('/cities/destroy/{id}', 'Admin\CityController@destroy')->name('cities.destroy');

    Route::view('/system/update', 'backend.system.update')->name('system_update');
    Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

    // uploaded files
    Route::any('/uploaded-files/file-info', 'Admin\AizUploadController@file_info')->name('uploaded-files.info');
    Route::resource('/uploaded-files', 'Admin\AizUploadController');
    Route::get('/uploaded-files/destroy/{id}', 'Admin\AizUploadController@destroy')->name('uploaded-files.destroy');

    Route::resource('slider', 'Admin\SliderController');
    Route::get('edit/video', 'Admin\VideoController@edit')->name('video');
    Route::put('update/video/{id}', 'Admin\VideoController@update')->name('video.update');
    //    Route::get('slider-delete/{id}', 'Admin\SliderController@destroy');

    // Export normal products
    Route::get('/export-excel/{product_type}', 'Admin\ProductController@export')->name('export_csv');

    //Export battery products
    Route::get('/battery-export-excel', 'Admin\BatteryController@export')->name('battery_export_csv');
    //Battery products Bulk Upload
    Route::get('/battery-product-bulk-upload/index', 'Admin\BatteryController@importIndex')->name('battery_product_bulk_upload.index');
    Route::post('/battery-bulk-product-upload', 'Admin\BatteryController@bulk_upload')->name('battery_bulk_product_upload');

    // user browse history
    Route::get('user/browse/history/{user_id}', 'Admin\AdminUserBrowseHistory@index')->name('admin.user.browse.history');

    // Affiliate system
    Route::controller(AffiliateController::class)->group(function () {
        Route::get('/affiliate', 'index')->name('affiliate.index');
        Route::post('/affiliate/affiliate_config_store', 'affiliate_config_store')->name('affiliate.store');
        Route::get('/refferal/users', 'refferal_users')->name('refferals.users');
        Route::get('/refferal/coupons', 'refferal_coupons')->name('refferals.coupons');
    });

    Route::resource('/service-sub-categories', 'Admin\ServiceSubCategoriesController');
    Route::resource('/service-sub-child-categories', 'Admin\ServiceSubChildCategoriesController');
    Route::resource('/battery-sub-categories', 'Admin\BatterySubCategoriesController');
    Route::resource('/battery-sub-child-categories', 'Admin\BatterySubChildCategoriesController');

    Route::post('/battery-get-sub-child-categories', 'Admin\BatterySubCategoriesController@battery_get_sub_child_categories');
    Route::post('/get-sub-child-categories', 'Admin\ServiceSubChildCategoriesController@get_sub_child_categories');
    
    Route::get('/add-tyre-battery', 'Admin\ProductV2Controller@add_tyre_battery')->name('add-tyre-battery');
    Route::post('/add-tyre-battery', 'Admin\ProductV2Controller@add_tyre_battery_store')->name('add-tyre-battery.store');
    Route::get('/add-services', 'Admin\ProductV2Controller@add_services')->name('add-services');
    Route::post('/add-services', 'Admin\ProductV2Controller@add_services_store')->name('add-services.store');
    Route::post('/get-all-tyres', 'Admin\ProductV2Controller@get_all_tyres');
    Route::post('/get-all-batteries', 'Admin\ProductV2Controller@get_all_batteries');
    Route::post('/get-all-services', 'Admin\ProductV2Controller@get_all_services');
    Route::post('/get-all-mileages', 'Admin\ProductV2Controller@get_all_mileages');
});

Route::group(['middleware' => ['auth', 'unbanned']], function () {
    Route::get('/product/{slug}', 'Admin\HomeController@product')->name('product');
    Route::get('updated/date/orders', 'Admin\OrderController@update_date_orders')->name('update_date_orders');
    Route::get('reassign/orders', 'Admin\OrderController@reassign_orders')->name('re-assign.orders');
    Route::get('car/condition/list', 'Admin\CarConditionController@adminlist')->name('customer.car.condition');
    Route::get('car/condition/details/{list_id}', 'Admin\CarConditionController@details')->name('customer.car.condition.details');
    Route::post('/language', 'Admin\LanguageController@changeLanguage')->name('language.change');
    Route::post('/currency', 'Admin\CurrencyController@changeCurrency')->name('currency.change');

    Route::post('/products/store/', 'Admin\ProductController@store')->name('products.store');
    Route::post('/products/update/{id}', 'Admin\ProductController@update')->name('products.update');
    Route::get('/products/destroy/{id}', 'Admin\ProductController@destroy')->name('products.destroy');
    Route::get('/products/duplicate/{id}', 'Admin\ProductController@duplicate')->name('products.duplicate');
    Route::post('/products/published', 'Admin\ProductController@updatePublished')->name('products.published');
    Route::post('/products-image/upload', 'Admin\ProductController@updateImage')->name('products.image-upload');

    // Batteries products for emergency services
    Route::get('/batteries/all', 'Admin\BatteryController@all_batteries')->name('batteries.all');
    Route::get('/batteries/create', 'Admin\BatteryController@create')->name('battery.create');
    Route::post('/batteries/store', 'Admin\BatteryController@store')->name('battery.store');
    Route::get('/batteries/edit/{id}', 'Admin\BatteryController@edit')->name('battery.edit');
    Route::post('/batteries/update/{id}', 'Admin\BatteryController@update')->name('battery.update');
    Route::get('/batteries/duplicate/{id}', 'Admin\BatteryController@duplicate')->name('battery.duplicate');
    Route::get('/batteries/destroy/{id}', 'Admin\BatteryController@destroy')->name('battery.destroy');
    Route::post('/batteries/bulk-delete', 'Admin\BatteryController@bulk_battery_delete')->name('battery.bulk_delete');
    Route::get('/batteries/jump-start', 'Admin\BatteryController@jumpstartView')->name('battery.jumpstart');
    Route::post('/batteries/jump-start/saveOrUpdate', 'Admin\BatteryController@saveOrUpdateJumpstart')->name('battery.saveOrUpdate');

    //Tyres for emergency services 
    Route::get('/tyres/spare-tyre', 'Admin\TyreController@index')->name('tyres.spare-tyre');
    Route::post('/tyres/spare-tyre/saveorupdate', 'Admin\TyreController@saveOrUpdateTyre')->name('tyres.spare-tyre.saveorupdate');

    //Petrol for emergency services 
    Route::get('/petrol-details', 'Admin\PetrolController@index')->name('petrol-details');
    Route::post('/petrol-details/saveOrUpdate', 'Admin\PetrolController@saveOrUpdatePetrol')->name('petrol.saveorupdate');

    Route::post('/products-group', 'Admin\GroupController@makeGroup')->name('products.group');
    Route::post('/products-group-update', 'Admin\GroupController@updateGroup')->name('products.group.update');
    Route::get('/products/group/details/{id}', 'Admin\GroupController@products_group_details')->name('products.group.details');
    Route::get('/products/group/delete/{id}', 'Admin\GroupController@products_group_delete')->name('products.group.delete');
    Route::get('/group/products/edit/{id}', 'Admin\GroupController@groupEdit')->name('group.products.edit');

    Route::resource('conversations', 'Admin\ConversationController');
    Route::get('/conversations/destroy/{id}', 'Admin\ConversationController@destroy')->name('conversations.destroy');
    Route::post('conversations/refresh', 'Admin\ConversationController@refresh')->name('conversations.refresh');

    Route::post('/aiz-uploader', 'Admin\AizUploadController@show_uploader');
    Route::post('/aiz-uploader/upload', 'Admin\AizUploadController@upload');
    Route::get('/aiz-uploader/get_uploaded_files', 'Admin\AizUploadController@get_uploaded_files');
    Route::post('/aiz-uploader/get_file_by_ids', 'Admin\AizUploadController@get_preview_files');
    Route::get('/aiz-uploader/download/{id}', 'Admin\AizUploadController@attachment_download')->name('download_attachment');

    Route::get('invoice/{order_id}', 'Admin\InvoiceController@invoice_download')->name('invoice.download');
    Route::get('invoice/emergency-order/{order_id}/{type}', 'Admin\InvoiceController@emergencyOrderInvoice')->name('invoice.emergency-order');

    Route::post('download-qr-code/{type}', 'Admin\QRController@downloadQRCode')->name('qrcode.download');
    Route::get('download-battery-qr-code/{type}/{order_id}', 'Admin\QRController@downloadBatteryQRCode')->name('battery.qrcode.download');

    Route::post('/orders/delivery-boy-assign', 'Admin\OrderController@assign_delivery_boy')->name('orders.delivery-boy-assign');
    Route::post('/orders/update_delivery_status', 'Admin\OrderController@update_delivery_status')->name('orders.update_delivery_status');
    Route::post('/orders/update_payment_status', 'Admin\OrderController@update_payment_status')->name('orders.update_payment_status');
    Route::post('/orders/delivery_type', 'Admin\OrderController@delivery_type')->name('orders.delivery_type');

    Route::get('/admin/user/browse/history/{id}', 'Admin\AdminUserBrowseHistory@index')->name('admin.user.browse.history');

    Route::resource('/wallet-amount', 'Admin\WalletAmountController');

    // Car Wash
    Route::resource('/car-washes-categories', 'Admin\CarWashCategoriesController');
    Route::resource('/car-washes', 'Admin\CarWashesController');
    Route::get('/car-wash-memberships', 'Admin\CarWashesController@memberships')->name('car-wash.memberships');
    Route::get('/car-wash-payments', 'Admin\CarWashesController@payments')->name('car-wash-payments');
    Route::get('/car-wash-warranty-card/{id}', 'Admin\CarWashesController@warranty_card')->name('car-wash-warranty-card');
    Route::get('/car-wash-usage-logs', 'Admin\CarWashesController@usages')->name('car-wash-usage-logs');
    Route::get('/car-wash-orders', 'Admin\CarWashesController@orders')->name('car-washes.orders');
    Route::get('/car-wash-orders/{order_id}', 'Admin\CarWashesController@ordersShow')->name('car-washes.orders.show');
    Route::get('/car-wash-membership/{id}', 'Admin\CarWashesController@membership_details')->name('car-washes.membership.details');
    Route::get('/add-car-wash-order', 'Admin\CarWashesController@add_order')->name('add-car-washes-order');
    Route::post('/store-car-wash-order', 'Admin\CarWashesController@store_order')->name('store-car-washes-order');
    Route::post('/get-user-carlist', 'Admin\CarWashesController@get_user_carlist');
    Route::post('/get-carwash-products-on-carlist', 'Admin\CarWashesController@get_carwash_products_on_carlist');
    Route::post('/car-washes-usage-update', 'Admin\CarWashesController@get_carwash_usage_update')->name('car-washes-usage.update');
    // Message to customers
    Route::get('/message-to-customers', 'Admin\NewsletterController@message_to_customers_index')->name('message-to-customers.index');
    Route::post('/message-to-customers/send', 'Admin\NewsletterController@message_to_customers_send')->name('message-to-customers.send');

    // Car Wash Technicians
    Route::get('/car-wash-technicians', 'Admin\CarWashTechniciansController@index')->name('car-wash-technicians.index');
    Route::get('/car-wash-technicians-create', 'Admin\CarWashTechniciansController@create')->name('car-wash-technicians.create');
    Route::post('/car-wash-technicians', 'Admin\CarWashTechniciansController@store')->name('car-wash-technicians.store');
    Route::get('/car-wash-technicians/{id}', 'Admin\CarWashTechniciansController@show')->name('car-wash-technicians.show');
    Route::get('/car-wash-technicians/{id}/edit', 'Admin\CarWashTechniciansController@edit')->name('car-wash-technicians.edit');
    Route::post('/car-wash-technicians-update/{id}', 'Admin\CarWashTechniciansController@update')->name('car-wash-technicians.update');
    Route::get('/car-wash-technicians-ban/{id}', 'Admin\CarWashTechniciansController@ban')->name('car-wash-technicians.ban');
    Route::get('/car-wash-technicians-destroy/{id}', 'Admin\CarWashTechniciansController@destroy')->name('car-wash-technicians.destroy');
    Route::post('/bulk-car-wash-technicians-delete', 'Admin\CarWashTechniciansController@bulk_technicians_delete')->name('bulk-car-wash-technicians-delete');
});
Route::get('/{slug}', 'Admin\PageController@show_custom_page')->name('custom-pages.show_custom_page');
