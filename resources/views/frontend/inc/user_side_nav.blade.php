<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" target="_blank" class="app-brand-link">
            @php
                $header_logo = get_setting('header_logo');
            @endphp
            @if($header_logo != null)
                <img src="{{ uploaded_asset($header_logo) }}" class="img-fuid" style="width: 100%;" alt="{{ env('APP_NAME') }}">
            @else
                <img src="{{ static_asset('assets/img/logo.png') }}" class="img-fuid" style="width: 100%;" alt="{{ env('APP_NAME') }}">
            @endif
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ areActiveRoutes(['dashboard'])}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ translate('Dashboard') }}">{{ translate('Dashboard') }}</div>
            </a>
        </li>
        @if(Auth::user()->user_type == 'customer')
        <li class="menu-item {{ areActiveRoutes(['affiliate.user.index'])}}">
            <a href="{{ route('affiliate.user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-users"></i>
                <div data-i18n="{{ translate('Referral url') }}">{{ translate('Referral url') }}</div>
            </a>
        </li>
        <li class="menu-item {{ areActiveRoutes(['front.user.coupon', 'near_merchants_vouchers'])}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="{{ translate('Voucher') }}">{{ translate('Voucher') }}</div>
            </a>
            <ul class="menu-sub">
{{--                @if(Auth::user()->user_type == 'customer')--}}
                    <?php
//                    $notify_user = DB::table('orders')->where('user_id', Auth::id())->where('start_installation_status', 1)->first();
                    ?>
{{--                    @if($notify_user)--}}
{{--                        <li class="menu-item {{ areActiveRoutes(['near_merchants_vouchers'])}}">--}}
{{--                            <a href="{{ route('near_merchants_vouchers') }}" class="menu-link">--}}
{{--                                <div data-i18n="{{ translate('Merchants Vouchers') }}">{{ translate('Merchants Vouchers') }}</div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endif--}}
                <li class="menu-item {{ areActiveRoutes(['front.user.coupon'])}}">
                    <a href="{{ route('front.user.coupon') }}" class="menu-link">
                        <div data-i18n="{{ translate('Referral Coupon') }}">{{ translate('Referral Coupon') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ areActiveRoutes(['purchase_history.index'])}}">
            <a href="{{ route('purchase_history.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-file-alt"></i>
                <div data-i18n="{{ translate('Transaction History') }}">{{ translate('Transaction History') }}</div>
            </a>
        </li>
        <li class="menu-item {{ areActiveRoutes(['installation_history'])}}">
            <a href="{{ route('installation_history') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-car"></i>
                <div data-i18n="{{ translate('Installation History') }}">{{ translate('Installation History') }}</div>
            </a>
        </li>
        @endif
        @if(Auth::user()->user_type == 'seller')
            @php
                $shop = \App\Models\Shop::where('user_id', Auth::user()->id)->select('id')->first();
                $orders_count = DB::table('orders')
                ->where('seller_id', $shop->id)
                ->where('viewed', 0)
                ->where('order_type', 'N')
                ->selectRaw("
                COUNT(CASE user_date_update WHEN 1 THEN 1 END) AS reschedule_orders,
                COUNT(CASE WHEN (user_date_update != 1) THEN 1 END) AS other_orders
                ")->first();
            @endphp
             <li class="menu-item {{ areActiveRoutes(['orders.index', 'update_date_workshop_orders', 'all_orders.show'])}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="{{ translate('Orders') }}">{{ translate('Orders') }}</div>
                    @if($orders_count->reschedule_orders > 0 || $orders_count->other_orders > 0)<span class="badge badge-inline badge-success ml-auto">{{ $orders_count->reschedule_orders + $orders_count->other_orders }}</span>@endif
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ areActiveRoutes(['orders.index'])}}">
                        <a href="{{ route('orders.index') }}" class="menu-link">
                            <div data-i18n="{{ translate('Orders') }}">New Orders</div>
                            @if($orders_count->other_orders > 0)<span class="badge badge-inline badge-success ml-auto">{{ $orders_count->other_orders }}</span>@endif
                        </a>
                    </li>
                    <li class="menu-item {{ areActiveRoutes(['update_date_workshop_orders', 'all_orders.show'])}}">
                        <a href="{{ route('update_date_workshop_orders') }}" class="menu-link">
                            <div data-i18n="{{translate('Reschedule Date Orders')}}">{{translate('Reschedule Date Orders')}}</div>
                            @if($orders_count->reschedule_orders > 0)<span class="badge badge-inline badge-success ml-auto">{{ $orders_count->reschedule_orders }}</span>@endif
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->user_type != 'merchant' && Auth::user()->user_type != 'customer')
        <li class="menu-item {{ areActiveRoutes(['orders.installation.list'])}}">
            <a href="{{ route('orders.installation.list') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-plus"></i>
                <div data-i18n="{{ translate('Installation List') }}">{{ translate('Installation List') }}</div>
            </a>
        </li>
    @endif
        @if(Auth::user()->user_type != 'merchant')
            <li class="menu-item {{ areActiveRoutes(['customer.car.condition.list'])}}">
                <a href="{{ route('customer.car.condition.list') }}" class="menu-link">
                    <i class="menu-icon tf-icons las la-save"></i>
                    <div data-i18n="{{ translate('Car Condition List') }}">{{ translate('Car Condition List') }}</div>
                </a>
            </li>
        @endif
        @if(Auth::user()->user_type == 'delivery_boy')
        @else
            @if(Auth::user()->user_type == 'seller')
                <li class="menu-item {{ areActiveRoutes(['workshop.availability.index'])}}">
                    <a href="{{ route('workshop.availability.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons las la-file-alt"></i>
                        <div data-i18n="{{ translate('Availability') }}">{{ translate('Availability') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ areActiveRoutes(['workshop.feedbacks'])}}">
                    <a href="{{ url('workshop/feedbacks') }}" class="menu-link">
                        <i class="menu-icon tf-icons lab la-sketch"></i>
                        <div data-i18n="{{ translate('Feedbacks') }}">{{ translate('Feedbacks') }}</div>
                    </a>
                </li>
            @endif
            @if(get_setting('classified_product') == 1)

            @endif
            @if(Auth::user()->user_type == 'seller')
                <li class="menu-item {{ areActiveRoutes(['shops.index'])}}">
                    <a href="{{ route('shop.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons las la-cog"></i>
                        <div data-i18n="{{ translate('Shop Setting') }}">{{ translate('Shop Setting') }}</div>
                    </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'merchant')
            <li class="menu-item {{ areActiveRoutes(['shops.index'])}}">
                <a href="{{ route('shops.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons las la-cog"></i>
                    <div data-i18n="{{ translate('Shop Setting') }}">{{ translate('Shop Setting') }}</div>
                </a>
            </li>
        @endif
        @endif
          @if(Auth::user()->user_type == 'customer')
            <li class="menu-item {{ areActiveRoutes(['qrcodes_download_history'])}}">
                <a href="{{ route('qrcodes_download_history') }}" class="menu-link">
                    <i class="menu-icon tf-icons las la-save"></i>
                    <div data-i18n="{{ translate('QR Codes Download History') }}">{{ translate('QR Codes Download History') }}</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
