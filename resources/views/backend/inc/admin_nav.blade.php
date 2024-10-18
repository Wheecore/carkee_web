<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3"
            data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
        <div class="aiz-topbar-logo-wrap d-xl-none d-flex align-items-center justify-content-start">
            @php
                $logo = get_setting('header_logo');
            @endphp
            <a href="{{ route('admin.dashboard') }}" class="d-block">
                @if ($logo != null)
                    <img src="{{ uploaded_asset($logo) }}" class="brand-icon" alt="{{ get_setting('website_name') }}">
                @else
                    {{-- <img src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon" alt="{{ get_setting('website_name') }}"> --}}
                @endif
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-none d-md-flex justify-content-around align-items-center align-items-stretch">
            <div class="justify-content-around align-items-center align-items-stretch d-none">
                <div class="aiz-topbar-item">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-icon btn-circle btn-light" href="{{ route('home') }}" target="_blank"
                            title="{{ translate('Browse Website') }}">
                            <i class="las la-globe"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            @php
                $notifications = DB::table('notifications')
                    ->leftJoin('orders', 'orders.id', '=', 'notifications.order_id')
                    ->select('notifications.body', 'notifications.created_at', 'orders.id', 'orders.order_type','notifications.id as notification_id')
                    ->where('notifications.is_admin', 1)
                    ->where('notifications.is_viewed', 0)
                    ->whereIn('notifications.type', ['order','wallet_recharge','wallet_deduct'])
                    ->orderBy('notifications.id', 'DESC')
                    ->get()
                    ->toArray();
            @endphp

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-1">
                            <span class=" position-relative d-inline-block">
                                <i class="las la-bell la-2x"></i>
                                @if (count($notifications))
                                    <span class="badge badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                @endif
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">
                                {{ translate('Notifications') }}
                                <small>
                                    <a href="{{ route('admin.notifications') }}" class="float-right">View all</a>
                                </small>
                            </h6>
                        </div>
                        <ul class="list-group c-scrollbar-light overflow-auto" style="max-height:300px;">
                            @forelse ($notifications as $notification)
                            @php
                            $show_route = route('wallet.recharge-details', encrypt($notification->notification_id));
                            if($notification->order_type == 'B'){
                                $show_route = route('battery_orders.show', encrypt($notification->id));
                            }
                            if($notification->order_type == 'P'){
                                $show_route = route('petrol_orders.show', encrypt($notification->id));
                            }
                            if($notification->order_type == 'T'){
                                $show_route = route('tyre_orders.show', encrypt($notification->id));
                            }
                            if($notification->order_type == 'CW'){
                                $show_route = route('car-washes.orders.show', encrypt($notification->id));
                            }
                            if($notification->order_type == 'N'){
                            $show_route = route('all_orders.show', encrypt($notification->id));
                            }
                            @endphp
                                <a href="{{ $show_route }}" class="text-reset">
                                    <li class="list-group-item p-3 pb-4">
                                        <span class="">{{ $notification->body }}</span><br>
                                        <small class="float-right">{{ convert_datetime_to_local_timezone($notification->created_at, user_timezone(Auth::id())) }}</small>
                                    </li>
                                </a>
                            @empty
                                <li class="list-group-item p-3">
                                    <a href="javascript:void(0)" class="text-reset">
                                        <span class="ml-2">{{ translate('Nothing found') }}</span>
                                    </a>
                                </li> 
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- language --}}
            @php
                if (Session::has('locale')) {
                    $locale = Session::get('locale', Config::get('app.locale'));
                } else {
                    $locale = env('DEFAULT_LANGUAGE');
                }
                $user = Auth::user();
            @endphp
            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown " id="lang-change">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon">
                            <img src="{{ static_asset('assets/img/flags/' . $locale . '.png') }}" height="11">
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">

                        @foreach (get_all_languages() as $key => $language)
                            <li>
                                <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                    class="dropdown-item @if ($locale == $language->code) active @endif">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        class="mr-2">
                                    <span class="language">{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2">
                                <img src="{{ uploaded_asset($user->avatar_original) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{ $user->name }}</span>
                                <span class="d-block small opacity-60">{{ $user->user_type }}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{ translate('Profile') }}</span>
                        </a>

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{ translate('Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
