@php
    $permissions = [];
    $user = Auth::user();
    if ($user->staff) {
        $permissions = json_decode($user->staff->role->permissions);
        $permissions = (!is_null($permissions))?$permissions:[];
    }
@endphp
<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @php
                    $header_logo = get_setting('header_logo');
                @endphp
                @if ($header_logo != null)
                    <img src="{{ uploaded_asset($header_logo) }}" alt="{{ get_setting('site_name') }}" class="mw-100 brand-icon">
                @else
                    <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ get_setting('site_name') }}" class="mw-100 brand-icon">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">

                @if ($user->user_type == 'admin' || in_array(1, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="aiz-side-nav-link">
                            <i class="las la-home aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                        </a>
                    </li>
                @endif

                <li class="side-nav-title">{{ translate('Categories') }}</li>
                @if ($user->user_type == 'admin' || in_array(2, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-car-side aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Tyre Size Categories') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(3, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('size.categories') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['size.categories', 'size.category.edit', 'size.category.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Width') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(4, $permissions))
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('size.sub.categories') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['size.sub.categories', 'size.sub.category.edit', 'size.sub.category.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Series') }}</span>
                                </a>
                            </li>
                            @if ($user->user_type == 'admin' || in_array(5, $permissions))
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('size.child.categories') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['size.child.categories', 'size.child.category.edit', 'size.child.category.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Rim Size') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(6, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="lab la-envira aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Featured Category') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(7, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('featured.categories') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['featured.categories', 'featured.category.edit', 'featured.category.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Main Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(8, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('featured.sub.categories') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['featured.sub.categories', 'featured.sub.category.edit', 'featured.sub.category.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Subcategories') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(9, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('vehicle.categories') }}"
                            class="aiz-side-nav-link {{ areActiveRoutesAdmin(['vehicle.categories', 'vehicle.category.edit', 'vehicle.category.edit']) }}">
                            <i class="las la-tractor aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Tyre Vehicle Category') }}</span>
                        </a>
                    </li>
                @endif

                {{--<li class="aiz-side-nav-item">
                    <a href="{{ route('categories.index') }}"
                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['categories.index', 'categories.create', 'categories.edit']) }}">
                        <i class="las la-list aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Products Categories') }}</span>
                    </a>
                </li>--}}

                @if ($user->user_type == 'admin' || in_array(10, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('size_alternative.index') }}" class="aiz-side-nav-link">
                            <i class="las la-expand-arrows-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Size Alternatives') }}</span>
                        </a>
                    </li>
                @endif
                
                <!-- Car Data -->
                <li class="side-nav-title">{{ translate('Brands Data') }}</li>
                @if ($user->user_type == 'admin' || in_array(11, $permissions))
                    @if ($user->user_type == 'admin' || in_array(12, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('brands.data', 'tyre_brands') }}" class="aiz-side-nav-link">
                                <i class="las la-expand-arrows-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Tyre Brands') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(13, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('brands.data', 'service_brands') }}" class="aiz-side-nav-link">
                                <i class="las la-expand-arrows-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Service Brands') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(14, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('brands.data', 'battery_brands') }}" class="aiz-side-nav-link">
                                <i class="las la-expand-arrows-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Battery Brands') }}</span>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- Car Data -->
                <li class="side-nav-title">{{ translate('Car Data') }}</li>
                @if ($user->user_type == 'admin' || in_array(15, $permissions))
                    @if ($user->user_type == 'admin' || in_array(16, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('brands.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutesAdmin(['brands.index', 'brands.create', 'brands.edit']) }}">
                                <i class="las la-tractor aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Car Brand') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(17, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('models.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutesAdmin(['models.index', 'models.create', 'models.edit']) }}">
                                <i class="las la-tractor aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Car Models') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(18, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('years.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutesAdmin(['years.index', 'years.create', 'years.edit']) }}">
                                <i class="las la-tractor aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Car Years') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(19, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('variants.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutesAdmin(['variants.index', 'variants.create', 'variants.edit']) }}">
                                <i class="las la-tractor aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Car Variants') }}</span>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- Product -->
                <li class="side-nav-title">{{ translate('Products Data') }}</li>
                @if ($user->user_type == 'admin' || in_array(20, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-list aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Products') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(21, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{ route('add-tyre-battery') }}">
                                        <span class="aiz-side-nav-text">{{ translate('Add Tyre Battery') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{ route('add-services') }}">
                                    <span class="aiz-side-nav-text">{{ translate('Add Services') }}</span>
                                </a>
                            </li>
                            @if ($user->user_type == 'admin' || in_array(22, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{ route('products.create') }}">
                                        <span class="aiz-side-nav-text">{{ translate('Add New product') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(23, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('products.all') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(24, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('reviews.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['reviews.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Products Reviews') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
        
                @if ($user->user_type == 'admin' || in_array(25, $permissions))
                    @php
                        $orders_count = DB::table('orders')->where('admin_viewed', 0)->where('order_type', 'N')->selectRaw("COUNT(CASE delivery_status WHEN 'Done' THEN 1 END) AS done_orders, COUNT(CASE user_date_update WHEN 1 THEN 1 END) AS reschedule_orders, COUNT(CASE WHEN (reassign_status = 2) THEN 1 END) AS reassign_orders, COUNT(CASE WHEN (reassign_status != 2 AND user_date_update != 1 AND delivery_status != 'Done') THEN 1 END) AS other_orders")->first();
                    @endphp
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Orders') }}</span>
                            @if ($orders_count->done_orders > 0 || $orders_count->reschedule_orders > 0 || $orders_count->reassign_orders > 0 || $orders_count->other_orders > 0)
                                <span class="badge badge-info">{{ $orders_count->done_orders + $orders_count->reschedule_orders + $orders_count->reassign_orders + $orders_count->other_orders }}</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(26, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('all_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['all_orders.index', 'all_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('New Orders') }}</span>
                                        @if ($orders_count->other_orders > 0)
                                            <span class="badge badge-info">{{ $orders_count->other_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(27, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('done.orders.list') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['done.orders.list', 'done.orders.list']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Done Orders list') }}</span>
                                        @if ($orders_count->done_orders > 0)
                                            <span class="badge badge-info">{{ $orders_count->done_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(28, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('update_date_orders') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['update_date_orders', 'all_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Reschedule Date Orders') }}</span>
                                        @if ($orders_count->reschedule_orders > 0)
                                            <span class="badge badge-info">{{ $orders_count->reschedule_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(29, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('re-assign.orders') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['re-assign.orders', 'all_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Reassign Orders') }}</span>
                                        @if ($orders_count->reassign_orders > 0)
                                            <span class="badge badge-info">{{ $orders_count->reassign_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{ route('delivery_orders') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['delivery_orders', 'all_orders.show']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Delivery Orders') }}</span>
                                    @if ($orders_count->delivery_orders > 0)
                                        <span class="badge badge-info">{{ $orders_count->delivery_orders }}</span>
                                    @endif
                                </a>
                            </li> --}}
                            @if ($user->user_type == 'admin' || in_array(30, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('orders-reviews.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['orders-reviews.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Orders Reviews') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(31, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('packages-reviews.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['packages-reviews.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Packages Reviews') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="side-nav-title">{{ translate('Services') }}</li>
                @if ($user->user_type == 'admin' || in_array(32, $permissions))
                    <li class="aiz-side-nav-item {{ areActiveRoutesAdmin(['package.index', 'package.create', 'package.edit', 'package.products.edit', 'package.products.addon.edit']) }}">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Services') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{ route('packages.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['package.index']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Packages') }}</span>
                                </a>
                            </li> --}}
                            @if ($user->user_type == 'admin' || in_array(33, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('service-sub-categories.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['service-sub-categories.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Sub Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(34, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('service-sub-child-categories.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['service-sub-child-categories.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Sub Child Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{ route('packages.create') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['package.create']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Add New Package') }}</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                    
                {{-- <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-list-ul aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Groups') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('products.groups') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('All Groups') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('all.products.groups') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('Make Products Group') }}</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="side-nav-title">{{ translate('Emergency Services') }}</li>
                @if ($user->user_type == 'admin' || in_array(35, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-car-battery aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Batteries') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(35, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('batteries.all') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('All Batteries') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(36, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('battery-sub-categories.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['battery-sub-categories.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Sub Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(37, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('battery-sub-child-categories.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['battery-sub-child-categories.index']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Sub Child Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(38, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{ route('battery.create') }}">
                                        <span class="aiz-side-nav-text">{{ translate('Add New Battery') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(39, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('battery.jumpstart') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Jumpstart') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(40, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-car-side aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Tyres') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('tyres.spare-tyre') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Spare Tyre') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(41, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-oil-can aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Petrols') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('petrol-details') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Petrol Details') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(42, $permissions))
                    @php
                        $emergency_orders_count = DB::table('orders')->where('admin_viewed', 0)->selectRaw("COUNT(CASE order_type WHEN 'B' THEN 1 END) AS battery_orders, COUNT(CASE order_type WHEN 'T' THEN 1 END) AS tyre_orders, COUNT(CASE order_type WHEN 'P' THEN 1 END) AS petrol_orders")->first();
                    @endphp
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Emergency Orders') }}</span>
                            @if ($emergency_orders_count->battery_orders > 0 || $emergency_orders_count->tyre_orders > 0 || $emergency_orders_count->petrol_orders > 0)
                                <span class="badge badge-info">{{ $emergency_orders_count->battery_orders + $emergency_orders_count->tyre_orders + $emergency_orders_count->petrol_orders }}</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(43, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('battery_orders.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['battery_orders.index', 'battery_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Battery Orders') }}</span>
                                        @if ($emergency_orders_count->battery_orders > 0)
                                            <span class="badge badge-info">{{ $emergency_orders_count->battery_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(44, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('tyre_orders.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['tyre_orders.index', 'tyre_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Tyre Orders') }}</span>
                                        @if ($emergency_orders_count->tyre_orders > 0)
                                            <span class="badge badge-info">{{ $emergency_orders_count->tyre_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(45, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('petrol_orders.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['petrol_orders.index', 'petrol_orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Petrol Orders') }}</span>
                                        @if ($emergency_orders_count->petrol_orders > 0)
                                            <span class="badge badge-info">{{ $emergency_orders_count->petrol_orders }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(46, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('emergency_coupon.index') }}" class="aiz-side-nav-link">
                            <i class="las la-coins aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Emergency Coupons') }}</span>
                        </a>
                    </li>
                @endif

                <li class="side-nav-title">{{ translate('Car Wash') }}</li>
                @if ($user->user_type == 'admin' || in_array(47, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-list aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Products') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(48, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-washes-categories.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(49, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-washes.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(50, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-washes.create') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Add New Product') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(52, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-wash.memberships') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Membership') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(53, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-wash-payments') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Payments') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(54, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-wash-usage-logs') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Usage Logs') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(55, $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('car-washes.orders') }}" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Car Wash Orders') }}</span>
                        </a>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(56, $permissions))
                    <li class="aiz-side-nav-item {{ areActiveRoutesAdmin(['car-wash-technicians.index', 'car-wash-technicians.create', 'car-wash-technicians.show', 'car-wash-technicians.edit']) }}">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Car Wash Technicians') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(56, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-wash-technicians.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['car-wash-technicians.index', 'car-wash-technicians.create', 'car-wash-technicians.show', 'car-wash-technicians.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Car Wash Technicians') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(57, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('car-wash-technicians.create') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutesAdmin(['car-wash-technicians.index', 'car-wash-technicians.create', 'car-wash-technicians.show', 'car-wash-technicians.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Add Car Wash Technician') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="side-nav-title">{{ translate('Users') }}</li>
                @if ($user->user_type == 'admin' || in_array(58, $permissions))
                    <!-- Customers -->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-users aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(58, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                    </a>
                                </li>
                            @endif   
                            @if ($user->user_type == 'admin' || in_array(90, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('customers.wallet_transactions') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Customers Wallet Transactions') }}</span>
                                    </a>
                                </li>
                            @endif           
                            @if ($user->user_type == 'admin' || in_array(59, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('customer.car.condition') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Customer Car Condition list') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(60, $permissions))
                    <!-- Sellers -->
                    @php
                        $sellers = \App\Models\Seller::where('verification_status', 0)->count();
                        $requests = \DB::table('availability_requests')->where('viewed', 0)->count();
                    @endphp
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Workshops') }}</span>
                            @if ($requests > 0 || $sellers > 0)
                                <span class="badge badge-info mr-2">{{ $requests + $sellers }}</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(60, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('sellers.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.approved', 'sellers.profile_modal']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('All Workshops') }}</span>
                                        @if ($sellers > 0)
                                            <span class="badge badge-info">{{ $sellers }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(61, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('sellers.availability-requests') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['sellers.availability-requests']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Workshops Availability Requests') }}</span>
                                        @if ($requests > 0)
                                            <span class="badge badge-info">{{ $requests }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(62, $permissions))
                    <!-- merchants -->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Merchants') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(63, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('merchant.categories') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['merchant.categories', 'merchant.categories.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Merchant Categories') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(64, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('merchants.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['merchants.index', 'merchants.create', 'merchants.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('All Merchants') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(65, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('merchants-vouchers.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['merchants-vouchers.index', 'merchants-vouchers.create', 'merchants-vouchers.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Merchants Vouchers') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(66, $permissions))
                    <!-- Staffs -->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Staffs') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(66, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['staffs.index', 'staffs.create', 'staffs.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('All staffs') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(68, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('roles.index') }}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['roles.index', 'roles.create', 'roles.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Staff permissions') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="side-nav-title">{{ translate('Payments') }}</li>
                    @if ($user->user_type == 'admin' || in_array(69, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('reschedule.payments') }}" class="aiz-side-nav-link {{ areActiveRoutes(['reschedule.payments']) }}">
                                <i class="las la-folder-open aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Reschedule Payments') }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->user_type == 'admin' || in_array(88, $permissions))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('wallet-amount.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wallet-amount.index']) }}">
                                <i class="las la-folder-open aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Wallet Amount') }}</span>
                            </a>
                        </li>
                    @endif

                <li class="side-nav-title">{{ translate('Others') }}</li>
                @if ($user->user_type == 'admin' || in_array(91, $permissions))
                    <!-- Uploads Files -->
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('message-to-customers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['message-to-customers.index']) }}">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Message To Customers') }}</span>
                        </a>
                    </li>
                @endif
                @if ($user->user_type == 'admin' || in_array(70, $permissions))
                    <!-- Uploads Files -->
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('uploaded-files.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create']) }}">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                        </a>
                    </li>
                @endif

                @if ($user->user_type == 'admin' || in_array(71, $permissions))
                    <!-- Affiliate Addon -->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-link aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Referral System') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if ($user->user_type == 'admin' || in_array(71, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('affiliate.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Referral Configurations') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(72, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('refferals.users') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Referral Users') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($user->user_type == 'admin' || in_array(73, $permissions))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('refferals.coupons') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Referral Coupons') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Marketing -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-bullhorn aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @if ($user->user_type == 'admin' || in_array(75, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('deals.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['deals.index', 'deals.create', 'deals.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Deals') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(76, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('newsletters.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(77, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(78, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('coupon.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['coupon.index', 'coupon.create', 'coupon.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(74, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('gift-codes.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['gift-codes.index', 'gift-codes.create', 'gift-codes.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Gift Codes') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(89, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('gift-codes-history.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['gift-codes-history.index', 'gift-codes-history.create', 'gift-codes-history.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Gift Codes History') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-desktop aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Website Setup') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @if ($user->user_type == 'admin' || in_array(79, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('slider.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Slider') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(80, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('video') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Video') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(81, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.header') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Header') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(82, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.footer') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Footer') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(83, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.pages') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutesAdmin(['website.pages', 'custom-pages.create', 'custom-pages.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Pages') }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->user_type == 'admin' || in_array(84, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Appearance') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Setup & Configurations -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Setup & Configurations') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @if ($user->user_type == 'admin' || in_array(85, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('general_setting.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('General Settings') }}</span>
                                </a>
                            </li>
                        @endif

                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('activation.index')}}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Features activation')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('languages.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Languages')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}

                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('currency.index')}}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Currency')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('tax.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit'])}}"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Vat & TAX')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        @if ($user->user_type == 'admin' || in_array(86, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('SMTP Settings') }}</span>
                                </a>
                            </li>
                        @endif
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('payment_method.index') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('File System Configuration')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        @if ($user->user_type == 'admin' || in_array(87, $permissions))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Social media Logins') }}</span>
                                </a>
                            </li>
                        @endif
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}

                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="javascript:void(0);" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Facebook')}}</span> --}}
                        {{-- <span class="aiz-side-nav-arrow"></span> --}}
                        {{-- </a> --}}
                        {{-- <ul class="aiz-side-nav-list level-3"> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('facebook-comment') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- </ul> --}}
                        {{-- </li> --}}

                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}

                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="javascript:void(0);" class="aiz-side-nav-link"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Shipping')}}</span> --}}
                        {{-- <span class="aiz-side-nav-arrow"></span> --}}
                        {{-- </a> --}}
                        {{-- <ul class="aiz-side-nav-list level-3"> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('shipping_configuration.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])}}"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('countries.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['countries.index','countries.edit','countries.update'])}}"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- <li class="aiz-side-nav-item"> --}}
                        {{-- <a href="{{route('cities.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['cities.index','cities.edit','cities.update'])}}"> --}}
                        {{-- <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span> --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- </ul> --}}
                        {{-- </li> --}}

                    </ul>
                </li>

                {{-- @if ($user->user_type == 'admin' || in_array('24', $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('System')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('system_update') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Update')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif --}}

                <!-- Addon Manager -->
                {{-- @if ($user->user_type == 'admin' || in_array('21', $permissions))
                    <li class="aiz-side-nav-item">
                        <a href="{{route('addons.index')}}" class="aiz-side-nav-link {{ areActiveRoutesAdmin(['addons.index', 'addons.create'])}}">
                            <i class="las la-wrench aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endif --}}
            </ul>
        </div>
    </div>
    <div class="aiz-sidebar-overlay"></div>
</div>
