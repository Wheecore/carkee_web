<!DOCTYPE html>
@if (DB::table('languages')->where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @endif
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="app-url" content="{{ getBaseURL() }}">
            <meta name="file-base-url" content="{{ getFileBaseURL() }}">

            <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="robots" content="index, follow">
            <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
            <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

        @yield('meta')
        @if (!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
            <!-- Schema.org markup for Google+ -->
                <meta itemprop="name" content="{{ get_setting('meta_title') }}">
                <meta itemprop="description" content="{{ get_setting('meta_description') }}">
                <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Twitter Card data -->
                <meta name="twitter:card" content="product">
                <meta name="twitter:site" content="@publisher_handle">
                <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
                <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
                <meta name="twitter:creator" content="@author_handle">
                <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Open Graph data -->
                <meta property="og:title" content="{{ get_setting('meta_title') }}"/>
                <meta property="og:type" content="website"/>
                <meta property="og:url" content="{{ route('home') }}"/>
                <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}"/>
                <meta property="og:description" content="{{ get_setting('meta_description') }}"/>
                <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
                <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
        @endif
        <!-- Favicon -->
            <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
            <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
            <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">
            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com"/>
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
            <link
                href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
                rel="stylesheet"
            />
            <!-- Icons. Uncomment required icon fonts -->
            <link rel="stylesheet" href="{{ static_asset('user_assets/vendor/fonts/boxicons.css') }}"/>
            <!-- Core CSS -->
            <link rel="stylesheet" href="{{ static_asset('user_assets/vendor/css/core.css') }}"
                  class="template-customizer-core-css"/>
            <link rel="stylesheet" href="{{ static_asset('user_assets/vendor/css/theme-default.css') }}"
                  class="template-customizer-theme-css"/>
            <link rel="stylesheet" href="{{ static_asset('user_assets/css/demo.css') }}"/>
            <!-- Vendors CSS -->
            <link rel="stylesheet"
                  href="{{ static_asset('user_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
            <link rel="stylesheet" href="{{ static_asset('user_assets/vendor/libs/apex-charts/apex-charts.css') }}"/>
            <!-- Page CSS -->
            <!-- Helpers -->
            <script src="{{ static_asset('user_assets/vendor/js/helpers.js') }}"></script>
            <script src="{{ static_asset('user_assets/js/config.js') }}"></script>
            <script>
                var AIZ = AIZ || {};
                AIZ.local = {
                    nothing_selected: '{{ translate('Nothing selected') }}',
                    nothing_found: '{{ translate('Nothing found') }}',
                    choose_file: '{{ translate('Choose file') }}',
                    file_selected: '{{ translate('File selected') }}',
                    files_selected: '{{ translate('Files selected') }}',
                    add_more_files: '{{ translate('Add more files') }}',
                    adding_more_files: '{{ translate('Adding more files') }}',
                    drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
                    browse: '{{ translate('Browse') }}',
                    upload_complete: '{{ translate('Upload complete') }}',
                    upload_paused: '{{ translate('Upload paused') }}',
                    resume_upload: '{{ translate('Resume upload') }}',
                    pause_upload: '{{ translate('Pause upload') }}',
                    retry_upload: '{{ translate('Retry upload') }}',
                    cancel_upload: '{{ translate('Cancel upload') }}',
                    uploading: '{{ translate('Uploading') }}',
                    processing: '{{ translate('Processing') }}',
                    complete: '{{ translate('Complete') }}',
                    file: '{{ translate('File') }}',
                    files: '{{ translate('Files') }}',
                }
            </script>
        @if (get_setting('google_analytics') == 1)
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('TRACKING_ID') }}"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];

                    function gtag() {
                        dataLayer.push(arguments);
                    }

                    gtag('js', new Date());
                    gtag('config', '{{ env('TRACKING_ID') }}');
                </script>
        @endif
        @if (get_setting('facebook_pixel') == 1)
            <!-- Facebook Pixel Code -->
                <script>
                    !function (f, b, e, v, n, t, s) {
                        if (f.fbq) return;
                        n = f.fbq = function () {
                            n.callMethod ?
                                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                        };
                        if (!f._fbq) f._fbq = n;
                        n.push = n;
                        n.loaded = !0;
                        n.version = '2.0';
                        n.queue = [];
                        t = b.createElement(e);
                        t.async = !0;
                        t.src = v;
                        s = b.getElementsByTagName(e)[0];
                        s.parentNode.insertBefore(t, s)
                    }(window, document, 'script',
                        'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '{{ env('FACEBOOK_PIXEL_ID') }}');
                    fbq('track', 'PageView');
                </script>
                <noscript>
                    <img height="1" width="1" style="display:none"
                         src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}&ev=PageView&noscript=1"/>
                </noscript>
                <!-- End Facebook Pixel Code -->
            @endif
            @php
                echo get_setting('header_script');
            @endphp
        </head>
        <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->
            @include('frontend.inc.user_side_nav')
            <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    <nav
                        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                        id="layout-navbar">
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>
                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <!-- Search -->
                            <div class="navbar-nav align-items-center">
                                <div class="nav-item d-flex align-items-center">
                                    <i class="bx bx-search fs-4 lh-0"></i>
                                    <input type="text"
                                           class="form-control border-0 shadow-none"
                                           placeholder="Search..."
                                           aria-label="Search..."/>
                                </div>
                            </div>
                            <!-- /Search -->
                            <ul class="navbar-nav flex-row align-items-center ms-auto">
                                <?php
                                $rating_orders = \App\Models\Order::where('done_installation_status', 1)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $address_orders = DB::table('orders')
                                // ->where('notify_address', 1)
                                ->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $user_orders = DB::table('orders')
                                // ->where('notify_user', 1)
                                ->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $shop = DB::table('shops')->where('user_id', Auth::id())->first();
                                $insta_orders = DB::table('orders')->where('start_installation_status', 1)
                                // ->where('start_installation_view_status', 0)
                                ->where('seller_id', $shop ? $shop->id : 0)->orderBy('id', 'desc')->get();
                                // no need this
                                $insta_alert_orders = DB::table('orders')
                                // ->where('installation_alert_status', 1)
                                ->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $r_d_orders = DB::table('orders')->where('reminder_day_status', 1)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $r_h_orders = DB::table('orders')->where('reminder_hour_status', 1)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $reschedule_orders = DB::table('orders')->where('reassign_status', 1)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $reschedule_w_orders = DB::table('orders')->where('reassign_status', 2)->where('old_workshop_id', $shop ? $shop->id : 0)->orderBy('id', 'desc')->get();
                                $notify_workshop_orders = DB::table('orders')->where('notify_user_come_to_workshop_to_review_car', 1)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                $datechange_request_approved = DB::table('availability_requests')->where('request_approved', 1)->where('shop_id', $shop?$shop->id:0)->get();
                                ?>
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                       href="javascript:void(0);">
                                    <span class="btn btn-icon mr-3">
                                        <span class=" position-relative d-inline-block">
                                            <i class="las la-bell fs-19 mr-2" style="color: #df5515;margin-top: 11px;"></i>
                                            <span
                                                class="badge badge-dot badge-circle position-absolute absolute-top-right p-2"
                                                style="background-color: #f26623 !important;border-radius: 10px;">
            {{ count($rating_orders) +  count($address_orders) + count($user_orders) + count($insta_orders) + count($insta_alert_orders) + count($r_d_orders) + count($r_h_orders) + count($reschedule_orders) + count($reschedule_w_orders) + count($notify_workshop_orders) + count($datechange_request_approved) }}
                                             </span>
                                        </span>
                                    </span>
                                  </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg c-scrollbar-light overflow-auto"
                                        style="max-height:300px;">
                                        <div class="p-2 border-bottom">
                                            <h6 class="mb-0">Notifications
                                                <span>
                                                    <a href="{{ url('notifications') }}" class="float-right">view all</a>
                                                </span>
                                            </h6>
                                        </div>
                                        @if(count($rating_orders) > 0 || count($address_orders) > 0 ||
                                        count($user_orders) > 0 || count($insta_orders) > 0 || count($insta_alert_orders) > 0)
                                            <div class="text-center"><b style="color: #f26623">Booking Orders</b></div>
                                        @endif
                                        @if(count($rating_orders) > 0)
                                            @foreach($rating_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('order-review',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            (<span class="la la-star checked"></span>rate it)
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($address_orders)>0)
                                            @foreach($address_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('order-user-address',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class=""> (<span class="la la-home"></span>Order Address)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($notify_workshop_orders)>0)
                                            @foreach($notify_workshop_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('installation_history1', $data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class="">please come to workshop and review your car </span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($user_orders)>0)
                                            @foreach($user_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('order-user-notify',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class=""> (Order Reached to workshop)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($insta_orders)>0)
                                            @foreach($insta_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('view-order',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span
                                                                class="">(Time to Start Installation for this order!)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($insta_alert_orders)>0)
                                            @foreach($insta_alert_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('alert-list-order',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class="">(We are noticing to inform you for alert module in installtion list!)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($r_d_orders)>0 || count($r_h_orders)>0)
                                            <div class="text-center"><b style="color: #f26623">Booking Reminders</b></div>
                                        @endif
                                        @if(count($r_d_orders)>0)
                                            @foreach($r_d_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('order-user-day-alert',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class=""> (1 day left in appointment)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif


                                        @if(count($datechange_request_approved) > 0)
                                            <div class="text-center"><b style="color: #f26623">Date Change Requests Approved</b></div>
                                        @endif
                                        @if(count($datechange_request_approved)>0)
                                            @foreach($datechange_request_approved as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{route('workshop.daterequest.statuschange',$data->id)}}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                                <span class="">Admin approve your request of time change From {{ \Carbon\Carbon::parse($data->previous_from_time)->format('h: i a').'--'.\Carbon\Carbon::parse($data->previous_to_time)->format('h: i a') }}
                                                                    To {{ \Carbon\Carbon::parse($data->from_time)->format('h: i a').'--'.\Carbon\Carbon::parse($data->to_time)->format('h: i a') }} on {{\Carbon\Carbon::parse($data->date)->format('m-d-Y')}}
                                                                    </span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif

                                        @if(count($r_h_orders)>0)
                                            @foreach($r_h_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="{{ url('order-user-hour-alert',$data->id) }}"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span class="">(1 hr left in appointment)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($reschedule_orders)>0 || count($reschedule_w_orders))
                                            <div class="text-center"><b style="color: #f26623">Booking Reschedules</b></div>
                                        @endif
                                        @if(count($reschedule_orders) > 0)
                                            @foreach($reschedule_orders as $data)
                                                @php
                                                    $chk_time = DB::table('availability_requests')->where('date', date('Y/m/d', strtotime($data->workshop_date)))->orderBy('id', 'desc')->first();
                                                @endphp
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="#"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            @if($chk_time && $chk_time->from_time && $chk_time->to_time)
                                                                <span class="">(Shop Time is Changed From {{ \Carbon\Carbon::parse($chk_time->previous_from_time)->format('h: i a').'--'.\Carbon\Carbon::parse($chk_time->previous_to_time)->format('h: i a') }}
                                                                    To {{ \Carbon\Carbon::parse($chk_time->from_time)->format('h: i a').'--'.\Carbon\Carbon::parse($chk_time->to_time)->format('h: i a') }}
                                                                    )</span>
                                                            @else
                                                                <span class="">(Shop Will be Closed on {{ $data->workshop_date }})</span>
                                                            @endif
                                                            <span>
                                                                <form action="{{ route('checkout.reschedule') }}"
                                                                      method="get">
                                                                    <input type="hidden" value="{{ $data->id }}"
                                                                           name="order_id">
                                                                <button class="btn-sm btn-primary mt-2" type="submit">Reassign Shop</button>
                                                                </form>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(count($reschedule_w_orders)>0)
                                            @foreach($reschedule_w_orders as $data)
                                                <li class="list-group-item">
                                                <span class="d-flex align-items-center">
                                                    <a href="#"
                                                       class="text-reset d-flex align-items-center flex-grow-1">
                                                            <i style="color:blue;font-size: x-large;"
                                                               class="las la-envelope-open"></i>
                                                        <span class="minw-0 pl-2 flex-grow-1">
                                                            <span class="fw-600 mb-1 text-truncate-2">
                                                                Order Code: {{ $data->code }}
                                                            </span>
                                                            <span
                                                                class="">Please Return Order Products To Warehouse</span>
                                                            <span>
                                                                <a href="{{ url('return/workshop/orders') }}"
                                                                   class="btn-sm btn-primary mt-2"
                                                                   type="submit">View</a>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </span>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            @if (Auth::user()->avatar_original != null)
                                                <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                                     class="w-px-40 rounded-circle">
                                            @else
                                                <img src="{{ static_asset('assets/img/avatar-place.png') }}"
                                                     class="w-px-40 rounded-circle">
                                            @endif
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            @if (Auth::user()->avatar_original != null)
                                                                <img
                                                                    src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                                                    class="w-px-40 rounded-circle">
                                                            @else
                                                                <img
                                                                    src="{{ static_asset('assets/img/avatar-place.png') }}"
                                                                    class="w-px-40 rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span
                                                            class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                        <small class="text-muted">
                                                            @if(Auth::user()->user_type == 'seller')
                                                                Workshop User
                                                            @elseif(Auth::user()->user_type == 'merchant')
                                                                Merchant Account
                                                            @else
                                                                User Account
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile') }}">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">{{translate('Manage Profile')}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf</form>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->
                            </ul>
                        </div>
                    </nav>
                    <!-- / Navbar -->
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                    @yield('panel_content')
                    <!-- / Content -->
                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div
                                class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                     © Reserved by Carkee
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                </div>
                            </div>
                        </footer>
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->
        @include('frontend.partials.modal')
        @if (get_setting('show_cookies_agreement') == 'on')
            <div class="aiz-cookie-alert shadow-xl">
                <div class="p-3 bg-dark rounded">
                    <div class="text-white mb-3">
                        @php
                            echo get_setting('cookies_agreement_text');
                        @endphp
                    </div>
                    <button class="btn btn-primary aiz-cookie-accept">
                        {{ translate('Ok. I Understood') }}
                    </button>
                </div>
            </div>
        @endif
        @if (get_setting('show_website_popup') == 'on')
            <div class="modal website-popup removable-session d-none" data-key="website-popup" data-value="removed">
                <div class="absolute-full bg-black opacity-60"></div>
                <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-md">
                    <div class="modal-content position-relative border-0 rounded-0">
                        <div class="aiz-editor-data">
                            {!! get_setting('website_popup_content') !!}
                        </div>
                        @if (get_setting('show_subscribe_form') == 'on')
                            <div class="pb-5 pt-4 px-5">
                                <form class="" method="POST" action="{{ route('subscribers.store') }}">
                                    @csrf
                                    <div class="form-group mb-0">
                                        <input type="email" class="form-control"
                                               placeholder="{{ translate('Your Email Address') }}" name="email"
                                               required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block mt-3">
                                        {{ translate('Subscribe Now') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                        <button
                            class="absolute-top-right bg-white shadow-lg btn btn-circle btn-icon mr-n3 mt-n3 set-session"
                            data-key="website-popup" data-value="removed" data-toggle="remove-parent"
                            data-parent=".website-popup">
                            <i class="la la-close fs-20"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @yield('modal')
        <!-- SCRIPTS -->
        <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
        <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ static_asset('user_assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ static_asset('user_assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ static_asset('user_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ static_asset('user_assets/vendor/js/menu.js') }}"></script>
        <!-- endbuild -->
        <!-- Vendors JS -->
        <script src="{{ static_asset('user_assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ static_asset('user_assets/js/main.js') }}"></script>
        <!-- Page JS -->
        <script src="{{ static_asset('user_assets/js/dashboards-analytics.js') }}"></script>
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script type="text/javascript">
            var mainurl = "{{ url('/') }}";
            var currenturl = "{{ Route::currentRouteName() }}";

            function loadingBtn() {
                $('.loading-btn').prop('disabled', true);
                return true;
            }
        </script>
        @if (get_setting('facebook_chat') == 1)
            <script type="text/javascript">
                window.fbAsyncInit = function () {
                    FB.init({
                        xfbml: true,
                        version: 'v3.3'
                    });
                };

                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div id="fb-root"></div>
            <!-- Your customer chat code -->
            <div class="fb-customerchat" attribution=setup_tool page_id="{{ env('FACEBOOK_PAGE_ID') }}">
            </div>
        @endif
        <script>
            @foreach (session('flash_notification', collect())->toArray() as $message)
            AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
            @endforeach
        </script>
        <script>
            function show_purchase_history_details(order_id) {
                $('#order-details-modal-body').html(null);
                if (!$('#modal-size').hasClass('modal-lg')) {
                    $('#modal-size').addClass('modal-lg');
                }
                $.post('{{ route('purchase_history.details') }}', {
                    _token: AIZ.data.csrf,
                    order_id: order_id
                }, function(data) {
                    $('#order-details-modal-body').html(data);
                    $('#order_details').modal('show');
                    $('.c-preloader').hide();
                });
            }
            function show_order_details(order_id) {
                $('#order-details-modal-body').html(null);

                if (!$('#modal-size').hasClass('modal-lg')) {
                    $('#modal-size').addClass('modal-lg');
                }
                $.post('{{ route('orders.details') }}', {
                    _token: AIZ.data.csrf,
                    order_id: order_id
                }, function(data) {
                    $('#order-details-modal-body').html(data);
                    $('#order_details').modal("show");
                    $('.c-preloader').hide();
                });
            }
            let _tooltip = jQuery.fn.tooltip;
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script>
            jQuery.fn.tooltip = _tooltip;
        </script>
        @yield('script')
        @php
            echo get_setting('footer_script');
        @endphp
        </body>
        </html>
