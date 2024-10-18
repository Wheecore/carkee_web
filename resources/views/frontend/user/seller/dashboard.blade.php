@extends('frontend.layouts.user_panel')
@section('panel_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{Auth::user()->name}}! 🎉</h5>
                                <p class="mb-4">
                                    You are here in your panel so please try to manage the things good.
                                </p>
                                <a href="{{ route('scan-qrcode') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="las la-qrcode aiz-side-nav-icon" style="font-size: 45px;"></i>
                                    <span class="aiz-side-nav-text">{{ translate('') }}</span>
                                </a>
                                <a href="{{ route('scan-do') }}" class="btn btn-sm btn-outline-primary ml-3">
                                  <i class="las la-file-invoice aiz-side-nav-icon" style="font-size: 45px;"></i>
                                  <span class="aiz-side-nav-text">{{ translate('') }}</span>
                              </a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="{{ static_asset('user_assets/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        @php
                        $shop = DB::table('shops')->where('user_id', Auth::user()->id)->first();
                        $orders_count = DB::table('orders')->where('order_type', 'N')->where('seller_id', $shop->id)->selectRaw("
                        COUNT(*) AS all_orders,
                        COUNT(CASE start_installation_status WHEN 1 THEN 1 END) AS start_installation_orders,
                        COUNT(CASE user_date_update WHEN 1 THEN 1 END) AS updated_date_orders
                        ")->first();
                        @endphp
                        <div class="card h-200px">
                            <div class="card-body">
                                 <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img
                                        src="{{ static_asset('user_assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success"
                                        class="rounded"
                                    />
                                </div>
                            </div>
                                <span>{{ translate('Total Order(s)') }}</span>
                                <h3 class="card-title mb-2">{{ $orders_count->all_orders }}</h3>
                                <a href="{{ url('orders') }}" class="btn btn-primary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-200px">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img
                                        src="{{ static_asset('user_assets/img/icons/unicons/wallet-info.png') }}"
                                        alt="Credit Card"
                                        class="rounded"
                                    />
                                </div>
                            </div>
                                <span>{{ translate('Installation List(s)') }}</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $orders_count->start_installation_orders }}</h3>
                                <a href="{{ url('orders/installation/list') }}" class="btn btn-primary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            <div class="col-12 col-md-12 order-3 order-md-2">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <span class="d-block mb-1">Updated Date Orders</span>
                                <h3 class="card-title text-nowrap mb-2 mt-3">{{ $orders_count->updated_date_orders }}</h3>
                                <a href="{{ route('update_date_workshop_orders') }}" class="btn btn-primary btn-sm mt-1">View</a>
                            </div>
                        </div>
                    </div>
                    <!-- </div>
    <div class="row"> -->
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Car Condition Lists</h5>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0">{{\DB::table('user_car_conditions')->where('user_id', Auth::id())->count()}}</h3>
                                            <a href="{{ route('customer.car.condition.list') }}" class="btn btn-primary btn-sm mt-1">View</a>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
