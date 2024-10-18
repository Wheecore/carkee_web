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
                              <a class="btn btn-sm btn-outline-primary" href="{{ route('profile') }}">{{translate('Manage Profile')}}</a>
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
                    <div class="card h-170px">
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
                            <span>Orders</span>
                            <h3 class="card-title mb-2">{{\App\Models\Order::where('user_id',Auth::id())->count()}}</h3>
                            <a href="{{ route('purchase_history.index') }}" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card h-170px">
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
                            <span>Car Lists</span>
                            <h3 class="card-title text-nowrap mb-1">{{\App\CarList::where('user_id', Auth::id())->count()}}</h3>
                             <a href="#car_lists" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .progress {
            width: 80px;
            height: 80px;
            background: none;
            position: relative;
        }
        .progress .progress-bar:last-child {
            border-top-right-radius: 0rem;
            border-bottom-right-radius: 0rem;
        }
        .progress .progress-bar:first-child {
            border-top-left-radius: 0rem;
            border-bottom-left-radius: 0rem;
        }
        .progress::after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 5px solid #eee;
            position: absolute;
            top: 0;
            left: 0;
        }
        .progress>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }
        .progress .progress-left {
            left: 0;
        }
        .progress .progress-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 5px;
            border-style: solid;
            position: absolute;
            top: 0;
        }
        .progress .progress-left .progress-bar {
            left: 100%;
            border-top-right-radius: 80px;
            border-bottom-right-radius: 80px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }
        .progress .progress-right {
            right: 0;
        }
        .progress .progress-right .progress-bar {
            left: -100%;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
        }
        .progress .progress-value {
            position: absolute;
            top: 0;
            left: 0;
        }
        .progress-bar {
            box-shadow: none;
        }
        .mapouter {
            position: relative;
            text-align: right;
            height: 266px;
            width: 100%;
        }
        .gmap_canvas {
            overflow: hidden;
            background: none!important;
            height: 240px;
            width: 100%;
        }
        .chart {
            width: 100%;
            border-radius: 15px;
        }

        .reminder .first-row {
            border-left: 5px solid #0069B6;
        }

        .reminder .first-row h5 {
            color: #0069B6;
            font-weight: bold;
            padding-left: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .reminder .first-row p {
            color: grey;
            padding-left: 15px;
        }

        .reminder .second-row {
            border-left: 5px solid #0069B6;
        }

        .reminder .second-row h5 {
            color: #0069B6;
            font-weight: bold;
            padding-left: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .reminder .second-row p {
            color: lightgray;
            padding-left: 15px;
        }

        .map-inner p {
            margin-bottom: 7px;
            color: grey;
        }

        .map-inner span {
            color: rgba(0, 0, 0, 0.692);
            font-weight: bold;
        }
        @keyframes loading-1 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }

        @keyframes loading-2 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }

        @keyframes loading-3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }
        }

        @keyframes loading-4 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }
        .car-inner span {
            float: right;
        }

        .car-inner h5 {
            color: rgba(0, 0, 0, 0.692);
            font-weight: 700;
        }

        .car-inner p {
            margin-bottom: 0px;
            color: lightgray;
        }

        .car-area-main-hed {
            font-weight: bold;
            color: rgba(0, 0, 0, 0.692);
        }

        .car-area-main-hed span {
            font-weight: bold;
            color: lightgray;
        }
        @media (max-width:1024px) {
            .map-inner p {
                margin-bottom: 7px;
                color: grey;
            }
            .map-inner span {
                color: rgba(0, 0, 0, 0.692);
                font-weight: bold;
            }
            .car-inner h5 {
                color: rgba(0, 0, 0, 0.692);
                font-weight: 700;
                font-size: 13px;
            }
            .car-inner p {
                margin-bottom: 0px;
                color: lightgray;
                font-size: 13px;
            }
            .chart {
                width: 100%;
                height: 300px;
                border-radius: 15px;
                overflow: scroll;
            }
        }
    </style>
    <script src="https://www.google.com/jsapi"></script>
    <div class="row mb-2">
        <div class="col-md-10 col-6">
            <h5>{{ translate('Car List') }}</h5>
        </div>
        <div class="col-md-2 col-6">
            <a href="{{ route('carlist.create') }}" class="btn btn-primary" style="float: right">Add Car list</a>
        </div>
    </div>
    <div class="row" id="car_lists">
            <div class="col-lg-12">
                <div class="car-area" style="background-color: white;border-radius: 15px">
                    <div class="row">
                        <div class="col-md-7">
                            <?php
                            $lists = \App\CarList::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
                            ?>
                            <div class="row">
                                <div class="col-md-8 col-6">
                                    <select class="ml-3 mb-3 mt-2 form-control" id="modal_change" style="border: 1px solid #f37539;">
                                        @if(count($lists) > 0)
                                        @foreach ($lists as $key => $list)
                                            <?php
                                            $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                            $model = \App\CarModel::where('id', $list->model_id)->first();
                                            ?>
                                            <option value="{{ $list->id }}">{{ $brand?$brand->name:'' }} {{ $model?$model->name:'' }}</option>
                                        @endforeach
                                        @else
                                        <option value="">No list found</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 mt-2" style="text-align: center">
                                    <a id="edit_btn" href="" class="btn btn-primary btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a id="view_btn" href="" class="ml-2 btn btn-primary btn-icon btn-circle btn-sm" title="{{ translate('view') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a id="delete_btn" href="javascript:void(0)" class="ml-2 btn btn-danger btn-icon btn-circle btn-sm confirm-delete" data-href="" title="{{ translate('Cancel') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-4 mt-3">
                                <div class="col-md-4">
                                    <div class="progress mx-auto" data-value='100'>
                                         <span class="progress-left">
                                           <span class="progress-bar" style="background-color: transparent !important;border-color: #FF0000"></span>
                                         </span>
                                        <span class="progress-right">
                                             <span class="progress-bar" style="background-color: transparent !important;border-color: #FF0000"></span>
                                            </span>
                                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold mt-3 text-center">
                                                <span style="color: #FF0000" id="red">0</span>
                                                <br>
                                                <span style="line-height: 30px;color: #FF0000">Red</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="progress mx-auto" data-value='100'>
                                         <span class="progress-left">
                                           <span class="progress-bar" style="background-color: transparent !important;border-color: #FFFF00"></span>
                                         </span>
                                        <span class="progress-right">
                                             <span class="progress-bar" style="background-color: transparent !important;border-color: #FFFF00"></span>
                                            </span>
                                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold mt-3 text-center">
                                            <span style="color: #bbbb4f" id="yellow">0</span>
                                            <br>
                                            <span style="line-height: 30px;color: #bbbb4f">Yellow</span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="progress mx-auto" data-value='100'>
                                         <span class="progress-left">
                                           <span class="progress-bar" style="background-color: transparent !important;border-color: #008000"></span>
                                         </span>
                                        <span class="progress-right">
                                             <span class="progress-bar" style="background-color: transparent !important;border-color: #008000"></span>
                                            </span>
                                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold mt-3 text-center">
                                                <span style="color: #008000" id="green">0</span>
                                                <br>
                                                <span style="line-height: 30px;color: #008000">Green</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="text-center">
                                <img src="{{static_asset('front_assets/img/testt2.jpg')}}" class="img-fluid" style="height: 226px;">
                            </div>
{{--                            <div class="row car-inner">--}}
{{--                                <div class="col-md-2"></div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <p>Left <span>Right</span></p>--}}
{{--                                    <h6>25 psi <span>26 psi</span></h6>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-1"></div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <p>Left <span>Right</span></p>--}}
{{--                                    <h6>23 psi <span>13 psi</span></h6>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-1"></div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="col-md-5">
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="mapouter">--}}
{{--                                        <div class="gmap_canvas">--}}
{{--                                            <iframe width="100%" height="240" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <!-- second row -->
                            <div class="row">
                                <div class="col-md-12 map-inner mt-2">
                                    <p>{{ translate('Car Plate')}}: <span class="ml-1" id="car_plate"></span></p>
                                    <p>{{ translate('Mileage')}}: <span class="ml-1" id="mileage"></span></p>
                                    <p>{{ translate('Chassis Number')}}: <span class="ml-1" id="chassis_number"></span></p>
                                    <p>{{ translate('Vehicle Size')}}: <span class="ml-1" id="vehicle_size"></span></p>
                                    <p>{{ translate('Insurance')}}: <span class="ml-1" id="insurance"></span></p>
                                    <p>{{ translate('Brand')}}: <span class="ml-1" id="brand"></span></p>
                                    <p>{{ translate('Model')}}: <span class="ml-1" id="model"></span></p>
                                    <p>{{ translate('Year')}}: <span class="ml-1" id="details"></span></p>
                                    <p>{{ translate('Details')}}: <span class="ml-1" id="year"></span></p>
                                    <p>{{ translate('Varients')}}: <span class="ml-1" id="varients"></span></p>
                                    <p>{{ translate('Size Alternative')}}: <span class="ml-1" id="size_alternative"></span></p>
                                </div>
                            </div>
                          <hr>
                          <div class="row reminder mt-4" id="reminder">
                             <h5 class="font-weight-bold">Reminders (0)</h5>
                         </div>
                        </div>
                    </div>
                </div>

            </div>
{{--            <div class="col-lg-4">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="card chart-card" style="border-radius: 15px;height: 317px;">--}}
{{--                            <div id="chart_div2" class="chart"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--  -->
{{--                <div class="row mt-4">--}}
{{--                    <div class="col-md-12 ">--}}
{{--                        <div class="card" style="border-radius: 15px;">--}}
{{--                            <div class="row reminder" style="padding: 10%;">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="first-row">--}}
{{--                                        <h5>155 000km</h5>--}}
{{--                                        <p>01/01/2021</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6 ">--}}
{{--                                    <div class="second-row">--}}
{{--                                        <h5>165 000km</h5>--}}
{{--                                        <p>01/01/2021</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!--  -->--}}
{{--                            <div class="row reminder " style="padding-left: 10%;">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="first-row">--}}
{{--                                        <h5>175 000km</h5>--}}
{{--                                        <p>01/01/2021</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6 ">--}}
{{--                                    <div class="second-row">--}}
{{--                                        <h5>185 000km</h5>--}}
{{--                                        <p>01/01/2021</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

    <div class="row mt-4">
        <!--/ Total Revenue -->
        <div class="col-12 col-md-12 order-3 order-md-2">
            <div class="row">
                 <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title">
                                        <h5 class="text-nowrap mb-2">Installations</h5>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <h3 class="mb-0">{{\App\Models\Order::where('user_id', Auth::user()->id)->where('start_installation_status', 1)->count()}}</h3>
                                        <a href="{{ route('installation_history') }}" class="btn btn-primary btn-sm mt-2">View</a>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
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
                                        <h3 class="mb-0">{{\DB::table('user_car_conditions')->where('customer_id', Auth::id())->count()}}</h3>
                                        <a href="{{ route('customer.car.condition.list') }}" class="btn btn-primary btn-sm mt-2">View</a>
                                    </div>
                                </div>
                                <div id="profileReportChart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="row mt-3">-->
    <!--    <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">-->
    <!--    <div class="card">-->
    <!--        <div class="row row-bordered g-0">-->
    <!--            <div class="col-md-8">-->
    <!--                <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>-->
    <!--                <div id="totalRevenueChart" class="px-2"></div>-->
    <!--            </div>-->
    <!--            <div class="col-md-4">-->
    <!--                <div class="card-body">-->
    <!--                    <div class="text-center">-->
    <!--                        <div class="dropdown">-->
    <!--                            <button-->
    <!--                                class="btn btn-sm btn-outline-primary dropdown-toggle"-->
    <!--                                type="button"-->
    <!--                                id="growthReportId"-->
    <!--                                data-bs-toggle="dropdown"-->
    <!--                                aria-haspopup="true"-->
    <!--                                aria-expanded="false"-->
    <!--                            >-->
    <!--                                2022-->
    <!--                            </button>-->
    <!--                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">-->
    <!--                                <a class="dropdown-item" href="javascript:void(0);">2021</a>-->
    <!--                                <a class="dropdown-item" href="javascript:void(0);">2020</a>-->
    <!--                                <a class="dropdown-item" href="javascript:void(0);">2019</a>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div id="growthChart"></div>-->
    <!--                <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>-->

    <!--                <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">-->
    <!--                    <div class="d-flex">-->
    <!--                        <div class="me-2">-->
    <!--                            <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex flex-column">-->
    <!--                            <small>2022</small>-->
    <!--                            <h6 class="mb-0">$32.5k</h6>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="d-flex">-->
    <!--                        <div class="me-2">-->
    <!--                            <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex flex-column">-->
    <!--                            <small>2021</small>-->
    <!--                            <h6 class="mb-0">$41.2k</h6>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!--<div class="row">-->
        <!-- Order Statistics -->
    <!--    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">-->
    <!--        <div class="card h-100">-->
    <!--            <div class="card-header d-flex align-items-center justify-content-between pb-0">-->
    <!--                <div class="card-title mb-0">-->
    <!--                    <h5 class="m-0 me-2">Order Statistics</h5>-->
    <!--                    <small class="text-muted">42.82k Total Sales</small>-->
    <!--                </div>-->
    <!--                <div class="dropdown">-->
    <!--                    <button-->
    <!--                        class="btn p-0"-->
    <!--                        type="button"-->
    <!--                        id="orederStatistics"-->
    <!--                        data-bs-toggle="dropdown"-->
    <!--                        aria-haspopup="true"-->
    <!--                        aria-expanded="false"-->
    <!--                    >-->
    <!--                        <i class="bx bx-dots-vertical-rounded"></i>-->
    <!--                    </button>-->
    <!--                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Share</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="card-body">-->
    <!--                <div class="d-flex justify-content-between align-items-center mb-3">-->
    <!--                    <div class="d-flex flex-column align-items-center gap-1">-->
    <!--                        <h2 class="mb-2">8,258</h2>-->
    <!--                        <span>Total Orders</span>-->
    <!--                    </div>-->
    <!--                    <div id="orderStatisticsChart"></div>-->
    <!--                </div>-->
    <!--                <ul class="p-0 m-0">-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                        <span class="avatar-initial rounded bg-label-primary"-->
    <!--                        ><i class="bx bx-mobile-alt"></i-->
    <!--                            ></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <h6 class="mb-0">Electronic</h6>-->
    <!--                                <small class="text-muted">Mobile, Earbuds, TV</small>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress">-->
    <!--                                <small class="fw-semibold">82.5k</small>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <h6 class="mb-0">Fashion</h6>-->
    <!--                                <small class="text-muted">T-shirt, Jeans, Shoes</small>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress">-->
    <!--                                <small class="fw-semibold">23.8k</small>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <h6 class="mb-0">Decor</h6>-->
    <!--                                <small class="text-muted">Fine Art, Dining</small>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress">-->
    <!--                                <small class="fw-semibold">849k</small>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                        <span class="avatar-initial rounded bg-label-secondary"-->
    <!--                        ><i class="bx bx-football"></i-->
    <!--                            ></span>-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <h6 class="mb-0">Sports</h6>-->
    <!--                                <small class="text-muted">Football, Cricket Kit</small>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress">-->
    <!--                                <small class="fw-semibold">99</small>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
        <!--/ Order Statistics -->

        <!-- Expense Overview -->
    <!--    <div class="col-md-6 col-lg-4 order-1 mb-4">-->
    <!--        <div class="card h-100">-->
    <!--            <div class="card-header">-->
    <!--                <ul class="nav nav-pills" role="tablist">-->
    <!--                    <li class="nav-item">-->
    <!--                        <button-->
    <!--                            type="button"-->
    <!--                            class="nav-link active"-->
    <!--                            role="tab"-->
    <!--                            data-bs-toggle="tab"-->
    <!--                            data-bs-target="#navs-tabs-line-card-income"-->
    <!--                            aria-controls="navs-tabs-line-card-income"-->
    <!--                            aria-selected="true"-->
    <!--                        >-->
    <!--                            Income-->
    <!--                        </button>-->
    <!--                    </li>-->
    <!--                    <li class="nav-item">-->
    <!--                        <button type="button" class="nav-link" role="tab">Expenses</button>-->
    <!--                    </li>-->
    <!--                    <li class="nav-item">-->
    <!--                        <button type="button" class="nav-link" role="tab">Profit</button>-->
    <!--                    </li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--            <div class="card-body px-0">-->
    <!--                <div class="tab-content p-0">-->
    <!--                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">-->
    <!--                        <div class="d-flex p-4 pt-3">-->
    <!--                            <div class="avatar flex-shrink-0 me-3">-->
    <!--                                <img src="{{ static_asset('user_assets/img/icons/unicons/wallet.png') }}" alt="User" />-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div id="incomeChart"></div>-->
    <!--                        <div class="d-flex justify-content-center pt-4 gap-2">-->
    <!--                            <div class="flex-shrink-0">-->
    <!--                                <div id="expensesOfWeek"></div>-->
    <!--                            </div>-->
    <!--                            <div>-->
    <!--                                <p class="mb-n1 mt-1">Expenses This Week</p>-->
    <!--                                <small class="text-muted">$39 less than last week</small>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
        <!--/ Expense Overview -->

        <!-- Transactions -->
    <!--    <div class="col-md-6 col-lg-4 order-2 mb-4">-->
    <!--        <div class="card h-100">-->
    <!--            <div class="card-header d-flex align-items-center justify-content-between">-->
    <!--                <h5 class="card-title m-0 me-2">Transactions</h5>-->
    <!--                <div class="dropdown">-->
    <!--                    <button-->
    <!--                        class="btn p-0"-->
    <!--                        type="button"-->
    <!--                        id="transactionID"-->
    <!--                        data-bs-toggle="dropdown"-->
    <!--                        aria-haspopup="true"-->
    <!--                        aria-expanded="false"-->
    <!--                    >-->
    <!--                        <i class="bx bx-dots-vertical-rounded"></i>-->
    <!--                    </button>-->
    <!--                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>-->
    <!--                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="card-body">-->
    <!--                <ul class="p-0 m-0">-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/paypal.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Paypal</small>-->
    <!--                                <h6 class="mb-0">Send money</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">+82.6</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Wallet</small>-->
    <!--                                <h6 class="mb-0">Mac'D</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">+270.69</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/chart.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Transfer</small>-->
    <!--                                <h6 class="mb-0">Refund</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">+637.91</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/cc-success.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Credit Card</small>-->
    <!--                                <h6 class="mb-0">Ordered Food</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">-838.71</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex mb-4 pb-1">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Wallet</small>-->
    <!--                                <h6 class="mb-0">Starbucks</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">+203.33</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li class="d-flex">-->
    <!--                        <div class="avatar flex-shrink-0 me-3">-->
    <!--                            <img src="{{ static_asset('user_assets/img/icons/unicons/cc-warning.png') }}" alt="User" class="rounded" />-->
    <!--                        </div>-->
    <!--                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
    <!--                            <div class="me-2">-->
    <!--                                <small class="text-muted d-block mb-1">Mastercard</small>-->
    <!--                                <h6 class="mb-0">Ordered Food</h6>-->
    <!--                            </div>-->
    <!--                            <div class="user-progress d-flex align-items-center gap-1">-->
    <!--                                <h6 class="mb-0">-92.45</h6>-->
    <!--                                <span class="text-muted">USD</span>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
        <!--/ Transactions -->
    <!--</div>-->

</div>
@endsection
@section('modal')
    @include('modals.carlist_delete_model')
@endsection
@section('script')
    <script>
        $(function() {
            $(".progress").each(function() {
                var value = $(this).attr('data-value');
                var left = $(this).find('.progress-left .progress-bar');
                var right = $(this).find('.progress-right .progress-bar');
                if (value > 0) {
                    if (value <= 50) {
                        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                    } else {
                        right.css('transform', 'rotate(180deg)')
                        left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                    }
                }
            });
            function percentageToDegrees(percentage) {
                return percentage / 100 * 360
            }
        });
        // google.load("visualization", "1", {
        //     packages: ["corechart"]
        // });
        // google.setOnLoadCallback(drawChart2);
        // function drawChart2() {
        //     var data = google.visualization.arrayToDataTable([
        //         ['Year', 'Sales', 'Expenses'],
        //         ['2013', 1000, 400],
        //         ['2014', 1170, 460],
        //         ['2015', 660, 1120],
        //         ['2016', 1030, 540]
        //     ]);
        //     var options = {
        //         title: 'Activity',
        //         hAxis: {
        //             title: 'Year',
        //             titleTextStyle: {
        //                 color: '#333'
        //             }
        //         },
        //         vAxis: {
        //             minValue: 0
        //         }
        //     };
        //     var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        //     chart.draw(data, options);
        // }
        // $(window).resize(function() {
        //     drawChart2();
        // });
    </script>
    <script>
        $(document).ready(function(){
                var select_value = $("#modal_change").val();
                if(select_value != ''){
                    $.get('{{ route('calist.get') }}',{_token:'{{ csrf_token() }}', id:select_value}, function(data){
                        $("#car_plate").html((data['list'].car_plate)?data['list'].car_plate:'--');
                        $("#mileage").html((data['list'].mileage)?data['list'].mileage:'--');
                        $("#chassis_number").html((data['list'].chassis_number)?data['list'].chassis_number:'--');
                        $("#vehicle_size").html((data['list'].vehicle_size)?data['list'].vehicle_size:'--');
                        $("#insurance").html((data['list'].insurance)?data['list'].insurance:'--');
                        $("#brand").html((data['brand'])?data['brand'].name:'--');
                        $("#model").html((data['model'])?data['model'].name:'--');
                        $("#details").html((data['details'])?data['details'].name:'--');
                        $("#year").html((data['year'])?data['year'].name:'--');
                        $("#varients").html((data['type'])?data['type'].name:'--');
                        $("#size_alternative").html((data['alternative'])?data['alternative'].name:'--');
                        $("#edit_btn").attr("href",data['edit_route']);
                        $("#view_btn").attr("href",data['view_route']);
                        $("#delete_btn").attr("data-href",data['delete_route']);
                        $("#red").html(data['red']);
                        $("#yellow").html(data['yellow']);
                        $("#green").html(data['green']);

                        $("#reminder").html('<h5 class="font-weight-bold">Reminders ('+data['warrenty_period_arr'].length+')</h5>');
                        if(data['warrenty_period_arr'].length){
                        $.each(data['warrenty_period_arr'], function(index, item) {
                        var result = item.split(',');
                        $("#reminder").append('<div class="col-md-6 mb-3">'+
                        '<div class="first-row">'+
                        '<h5>'+result[1]+'</h5>'+
                        '<p>'+result[0]+'</p>'+
                        '</div></div>');
                        });
                        }
                    });
                }
        });
        $("#modal_change").change(function(){
           var select_value = $(this).val();
           if(select_value != ''){
               $.get('{{ route('calist.get') }}',{_token:'{{ csrf_token() }}', id:select_value}, function(data){
                   $("#car_plate").html((data['list'].car_plate)?data['list'].car_plate:'--');
                   $("#mileage").html((data['list'].mileage)?data['list'].mileage:'--');
                   $("#chassis_number").html((data['list'].chassis_number)?data['list'].chassis_number:'--');
                   $("#vehicle_size").html((data['list'].vehicle_size)?data['list'].vehicle_size:'--');
                   $("#insurance").html((data['list'].insurance)?data['list'].insurance:'--');
                   $("#brand").html((data['brand'])?data['brand'].name:'--');
                   $("#model").html((data['model'])?data['model'].name:'--');
                   $("#details").html((data['details'])?data['details'].name:'--');
                   $("#year").html((data['year'])?data['year'].name:'--');
                   $("#varients").html((data['type'])?data['type'].name:'--');
                   $("#size_alternative").html((data['alternative'])?data['alternative'].name:'--');
                   $("#edit_btn").attr("href",data['edit_route']);
                   $("#view_btn").attr("href",data['view_route']);
                   $("#delete_btn").attr("data-href",data['delete_route']);
                   $("#red").html(data['red']);
                   $("#yellow").html(data['yellow']);
                   $("#green").html(data['green']);

                    $("#reminder").html('<h5 class="font-weight-bold">Reminders ('+data['warrenty_period_arr'].length+')</h5>');
                    if(data['warrenty_period_arr'].length){
                    $.each(data['warrenty_period_arr'], function(index, item) {
                    var result = item.split(',');
                    $("#reminder").append('<div class="col-md-6 mb-3">'+
                    '<div class="first-row">'+
                    '<h5>'+result[1]+'</h5>'+
                    '<p>'+result[0]+'</p>'+
                    '</div></div>');
                    });
                    }
               });
           }
        });
    </script>
@endsection
