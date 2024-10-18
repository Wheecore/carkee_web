@extends('frontend.layouts.app')
<?php
if (isset($category_id)) {
    $var = DB::table('categories')
        ->select('meta_title', 'meta_description')
        ->where('id', $category_id)
        ->first();
    $meta_title = $var->meta_title;
    $meta_description = $var->meta_description;
} elseif (isset($brand_id)) {
    $var = DB::table('brands')
        ->select('meta_title', 'meta_description')
        ->where('id', $brand_id)
        ->first();
    $meta_title = $var->meta_title;
    $meta_description = $var->meta_description;
} else {
    $meta_title = get_setting('meta_title');
    $meta_description = get_setting('meta_description');
}
?>
@section('meta_title') {{ 'Tyre' }} @stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">
    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">
    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection
@php
    $featured_filters = \App\FeaturedCategory::all();
    $featured_sub_filters = \App\FeaturedSubCategory::all();
    $lists = \App\CarList::orderBy('id', 'desc')
        ->where('user_id', Auth::id())
        ->limit(8)
        ->get();
    $brand_s = \App\Models\Brand::where('id', Session::get('session_brand_id'))->first();
    $model_s = \App\CarModel::where('id', Session::get('session_model_id'))->first();
    $detail_s = \App\CarDetail::where('id', Session::get('session_details_id'))->first();
    $year_s = \App\CarYear::where('id', Session::get('session_year_id'))->first();
    $type_s = \App\CarType::where('id', Session::get('session_type_id'))->first();
    if (isset($model_id)) {
        $alternatives = \App\SizeAlternative::where('model_id', $model_id)->get();
    }
@endphp
@section('content')
    <style>
        .pagination .page-link:hover {
            background-color: #333 !important;
        }

        .pagination .active .page-link {
            background-color: #333 !important;
        }

        @media (max-width:768px) {
            .card .content .right .buy_content button {
                width: 60%;
            }

            .card .content .right .d_time h6.d_t {
                padding-right: 115px;
            }

            .card .content .right .buy_content h2 {
                font-size: 24px;
            }

            .right {
                text-align: center;
            }
        }

        @media only screen and (min-width: 769px) and (max-width: 1024px) {
            label {
                font-size: 10px;
            }
        }

        /* Card Styling */

        .card-area .main-card {
            border-radius: 20px;
            border: 1px solid gray;
            overflow: hidden;
        }

        .card-area .main-card h1 {
            background-color: transparent !important;
        }

        .card-area .main-card .left-side {
            background-color: white;
        }

        .card-area .main-card .right-side h3 {
            font-weight: bold;
            color: #016BC1;
        }

        .card-area .main-card .left-side .sun .fa-sun {
            font-size: 30px;
            color: #FFC700;
            float: right;
            margin-top: 26px;
        }

        .card-area .main-card .left-side .tyre {
            margin-top: 45%;
            margin-bottom: 10%;
        }

        .card-area .main-card .left-side .check-box-area label {
            font-weight: bold;
            margin-bottom: 0px;
        }

        .card-area .main-card .left-side #triangle-topleft {
            width: 0;
            height: 0;
            border-top: 130px solid #f37539;
            border-right: 130px solid transparent;
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .card-area .main-card .right-side {
            background-color: #FEF1D8;
        }

        .card-area .main-card .right-side h1 {
            font-weight: bold;
            color: blue;
        }

        .card-area .main-card .right-side h5 {
            font-weight: bold;
            font-size: 20px;
            color: #016BC1;
        }

        .card-area .main-card .right-side .border-label {
            font-weight: normal;
            border: 2px solid #016BC1;
            width: 50%;
            border-radius: 5px;
            padding: 1%;
            font-size: 15px;
            color: #016BC1;
        }

        .card-area .main-card .right-side .free-delivery-text {
            float: right;
            font-weight: bold;
            color: white;
            text-shadow: 3px 1px 0 #ee6c28, -1px 1px 0 #ee6c28, 1px -1px 0 #ee6c28, -1px -1px 0 #ee6c28, 0px 1px 0 #ee6c28, 0px -1px 0 #ee6c28, -1px 0px 0 #ee6c28, 1px 0px 0 #ee6c28, 2px 2px 2px #ee6c28, -2px 2px 2px #ee6c28, 2px -2px 2px #ee6c28, -2px -2px 2px #ee6c28, 0px 2px 2px #ee6c28, 0px -2px 2px #ee6c28, -2px 0px 0 #ee6c28, 2px 0px 0 #ee6c28, 1px 2px 0 #ee6c28, -1px 2px 0 #ee6c28, 1px -2px 0 #ee6c28, -1px -2px 0 #ee6c28, 2px 1px 0 #ee6c28, -2px 1px 0 #ee6c28, 2px -1px 0 #ee6c28, -2px -1px 0 #ee6c28;
        }

        .card-area .main-card .right-side .left-side2 p {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 0px;
        }

        .card-area .main-card .right-side .left-side2 select {
            width: 60%;
            height: 30px;
            border: none;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .card-area .main-card .right-side .right-side2 h1 span {
            font-size: 20px;
        }

        .card-area .main-card .right-side .right-side2 .btn {
            padding: 5% 20%;
            font-weight: bold;
            background-color: #f37539;
            color: white;
        }

        .progress-bar {
            background-color: #FFC700;
        }

        .progress {
            height: 12px;
            border-radius: 1.25rem;
        }

        .card-area .main-card .last-review-area h5 {
            font-size: 25px;
            color: black;
        }

        .label_top b {
            font-size: 14px;
        }

        .card-area .main-card .last-review-area p {
            margin-bottom: 0px;
            color: black;
            font-weight: 500;
        }

        /* Ratings widget */

        .card-area .main-card .last-review-area .rate {
            display: inline-block;
            border: 0;
        }

        /* Hide radio */

        .card-area .main-card .last-review-area .rate>input {
            display: none;
        }

        /* Order correctly by floating highest to the right */

        .card-area .main-card .last-review-area .rate>label {
            float: right;
        }

        /* The star of the show */

        .card-area .main-card .last-review-area .rate>label:before {
            display: inline-block;
            font-size: 1rem;
            padding: .3rem .2rem;
            margin: 0;
            cursor: pointer;
            font-family: FontAwesome;
            content: "\f005 ";
            /* full star */
        }

        /* Half star trick */

        .card-area .main-card .last-review-area .rate .half:before {
            content: "\f089 ";
            /* half star no outline */
            position: absolute;
            padding-right: 0;
        }

        /* Click + hover color */

        .card-area .main-card .last-review-area input:checked~label,
        /* color current and previous stars on checked */

        .card-area .main-card .last-review-area label:hover,
        .card-area .main-card .last-review-area label:hover~label {
            color: yellow;
        }

        /* color previous stars on hover */
        /* Hover highlights */

        .card-area .main-card .last-review-area input:checked+label:hover,
        .card-area .main-card .last-review-area input:checked~label:hover,
        /* highlight current and previous stars */

        .card-area .main-card .last-review-area input:checked~label:hover~label,
        /* highlight previous selected stars for new rating */

        .card-area .main-card .last-review-area label:hover~input:checked~label
        /* highlight previous selected stars */

            {
            color: yellow;
        }

        .card-area .main-card .express {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .card-area .main-card .express p {
            font-size: 18px;
        }

        .card-area .main-card .express h3 {
            color: #008D03;
            font-weight: bold;
        }

        @media (max-width:1024px) {
            .card-area .main-card .left-side .tyre {
                margin-top: 150%;
            }
        }

        @media (max-width:900px) {
            .pagination_box {
                overflow: scroll;
            }
        }

        @media (max-width:768px) {
            .card-area .main-card {
                text-align: left;
            }

            .card-area .main-card .left-side .tyre {
                margin-top: 0%;
                margin-bottom: 10%;
            }

            .card-area .main-card .left-side .tyre img {
                width: 50%;
            }
        }

        @media (max-width:480px) {
            .card-area .main-card .right-side .border-label {
                width: 100%;
            }

            .card-area .main-card .left-side .tyre {
                margin-bottom: 15%;
            }
        }
    </style>
    <!-- header -->
    <section class="mt-4" id="header-section1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 left">
                    <form id="vehform" action=""
                        class="veh_size_form js-classified-form  js-form-validation navsearchform @if (isset($_GET['size_cat_id'])) @else hidden @endif">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Width</b></label>
                                    <select class="form-control pq vehsize" name="size_cat_id" id="size_cat_id"
                                        onchange="size_subcats_ajax()" required>
                                        <option value="">Width</option>
                                        @foreach (\App\SizeCategory::all() as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Height</b></label>
                                    <select class="form-control pq vehsize" name="sub_cat_id" id="sub_cat_id"
                                        onchange="size_childcats_ajax()">
                                        <option value="">Height</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Diameter</b></label>
                                    <select class="form-control pq vehsize" name="child_cat_id" id="child_cat_id"
                                        onchange="size_products_ajax()">
                                        <option value="">Wheel Dimension</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn2" type="submit"
                                    style="margin-top: 32px;">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="image text-center" style="margin-left: -116px;">
                        <img src="{{ static_asset('front_assets/img/Capture.PNG') }}" alt="Check link" class="img-fluid">
                        <h5><b>Not sure?: </b> Select your vehicle</h5>
                    </div>
                </div>
                <div class="col-md-7 right">
                    <form id="model_form" action=""
                        class="js-classified-form js-form-validation navsearchform @if ($category_id && $brand_id && $model_id) @else hidden @endif">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="category_id" id="category_value" value="tyre">
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>{{ translate('Select Brand') }}</b></label>
                                    <select class="form-control pq items input-readonly not-full has-options"
                                        name="brand_id" id="brand_id" data-live-search="true" onchange="models()" required>
                                        <option value="">{{ translate('Select Brand') }}
                                        </option>
                                        @foreach (\App\Models\Brand::all() as $brand)
                                            <option value="{{ $brand->id }}">
                                                {{ $brand->getTranslation('name') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Select Model</b></label>
                                    <select name="model_id" id="model_id"
                                        class="form-control pq items input-readonly not-full has-options"
                                        data-live-search="true" onchange="details()" required>
                                        <option value="">Select Model</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Select Year</b></label>
                                    <select name="details_id" id="details_id"
                                        class="form-control pq items input-readonly not-full has-options"
                                        onchange="car_years()">
                                        <option value="">Select Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Select Car CC</b></label>
                                    <select name="year_id" id="year_id"
                                        class="form-control pq items input-readonly not-full has-options"
                                        onchange="types()">
                                        <option value="">Select Car CC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label class="label_top" for=""><b>Select Variant</b></label>
                                    <select name="type_id" id="type_id"
                                        class="form-control pq items input-readonly not-full has-options">
                                        <option value="">Select Variant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-0">
                            <button class="btn  btn-primary btn2" type="submit">Search
                            </button>
                            <button class="btn btn-success ml-2" onclick="changeActionUrl()">+
                                Add To My Vehicle</button>
                        </div>
                    </form>
                    <hr style="border-color:#f37539 !important">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($category_id && $brand_id && $model_id)
                                <div class="pr_list">
                                    <div class="p-3">
                                        <form action="" id="search-form1" method="get">
                                            <input type="hidden" name="sort_by" class="sort_by" value="">
                                            <input type="hidden" name="category_id" value="tyre">
                                            <input type="hidden" name="brand_id" value="{{ $brand_id }}">
                                            <input type="hidden" name="model_id" value="{{ $model_id }}">
                                            <input type="hidden" name="details_id" value="{{ $details_id }}">
                                            <input type="hidden" name="year_id" value="{{ $year_id }}">
                                            <input type="hidden" name="type_id" value="{{ $type_id }}">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-4">
                                                    <span style="font-weight: 700">Your Vehicle</span>: <span
                                                        style="font-weight: 600">{{ $brand_s->name }}
                                                        {{ $model_s ? ', ' . $model_s->name : '' }}{{ $detail_s ? ', ' . $detail_s->name : '' }}{{ $year_s ? ', ' . $year_s->name : '' }}{{ $type_s ? ', ' . $type_s->name : '' }}</span>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_brand"
                                                            data-live-search="true" onchange="filter1()">
                                                            <option value="">{{ translate('Brand: All') }}</option>
                                                            @foreach ($featured_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_brand']) && $_GET['filter_by_brand'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_products"
                                                            data-live-search="true" onchange="filter1()">
                                                            <option value="">{{ translate('Product: All') }}
                                                            </option>
                                                            @foreach ($featured_sub_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_products']) && $_GET['filter_by_products'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-6 col-md-6 col-sm-4">
                                                    <span style="font-weight: 700">Size Alternatives</span>: <span
                                                        style="font-weight: 600"></span>
                                                    @if (count($alternatives) > 0)
                                                        @foreach ($alternatives as $alternative)
                                                            <span
                                                                style="padding: 2px 11px 2px 11px; border: 2px solid gray;">{{ $alternative->name }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif(isset($_GET['size_cat_id']))
                                <?php
                                if (isset($_GET['size_cat_id'])) {
                                    $main_cat = \App\SizeCategory::where('id', $_GET['size_cat_id'])->first();
                                }
                                if (isset($_GET['sub_cat_id'])) {
                                    $sub_cat = \App\SizeSubCategory::where('id', $_GET['sub_cat_id'])->first();
                                }
                                if (isset($_GET['child_cat_id'])) {
                                    $child_cat = \App\SizeChildCategory::where('id', $_GET['child_cat_id'])->first();
                                }
                                ?>
                                <div class="pr_list">
                                    <div class="p-3">
                                        <form action="" id="search-form2" method="get">
                                            <input type="hidden" name="sort_by" class="sort_by" value="">
                                            <input type="hidden"
                                                value="{{ isset($_GET['size_cat_id']) ? $_GET['size_cat_id'] : '' }}"
                                                name="size_cat_id">
                                            <input type="hidden"
                                                value="{{ isset($_GET['sub_cat_id']) ? $_GET['sub_cat_id'] : '' }}"
                                                name="sub_cat_id">
                                            <input type="hidden"
                                                value="{{ isset($_GET['child_cat_id']) ? $_GET['child_cat_id'] : '' }}"
                                                name="child_cat_id">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-4">
                                                    <span style="font-weight: 700">Selected Size</span>: <span
                                                        style="font-weight: 600">{{ isset($main_cat) ? $main_cat->name : '' }}{{ isset($sub_cat) ? ', ' . $sub_cat->name : '' }}{{ isset($child_cat) ? ', ' . $child_cat->name : '' }}</span>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_brand"
                                                            data-live-search="true" onchange="filter2()">
                                                            <option value="">{{ translate('Brand: All') }}</option>
                                                            @foreach ($featured_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_brand']) && $_GET['filter_by_brand'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_products"
                                                            data-live-search="true" onchange="filter2()">
                                                            <option value="">{{ translate('Product: All') }}
                                                            </option>
                                                            @foreach ($featured_sub_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_products']) && $_GET['filter_by_products'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-6 col-md-6 col-sm-4">
                                                    <span style="font-weight: 700">Size Alternative</span>: <span
                                                        style="font-weight: 600"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="all_list">
                                    <div class="p-3">
                                        <form action="" id="search-form3" method="get">
                                            <input type="hidden" name="sort_by" class="sort_by" value="">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-4">
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_front_rear"
                                                            data-live-search="true" onchange="filter3()">
                                                            <option value="">{{ translate('Front/Rear: All') }}
                                                            </option>
                                                            <option value="">All</option>
                                                            <option value="front"
                                                                {{ isset($_GET['filter_by_front_rear']) && $_GET['filter_by_front_rear'] == 'front' ? 'selected' : '' }}>
                                                                Front</option>
                                                            <option value="rear"
                                                                {{ isset($_GET['filter_by_front_rear']) && $_GET['filter_by_front_rear'] == 'rear' ? 'selected' : '' }}>
                                                                Rear</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_brand"
                                                            data-live-search="true" onchange="filter3()">
                                                            <option value="">{{ translate('Brand: All') }}</option>
                                                            @foreach ($featured_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_brand']) && $_GET['filter_by_brand'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control" name="filter_by_products"
                                                            data-live-search="true" onchange="filter3()">
                                                            <option value="">{{ translate('Product: All') }}
                                                            </option>
                                                            @foreach ($featured_sub_filters as $filter)
                                                                <option value="{{ $filter->id }}"
                                                                    {{ isset($_GET['filter_by_products']) && $_GET['filter_by_products'] == $filter->id ? 'selected' : '' }}>
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-6 col-md-6 col-sm-4"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row" id="" style="padding: 17px 17px 27px 7px;">
                                <div class="col-lg-3 col-md-12">
                                    <form action="" method="GET">
                                        <input type="hidden" name="tyre_item" value="all_items">
                                        <button type="submit" class="btn btn-block btn-primary btn-search">
                                            All Tyre</button>
                                    </form>
                                </div>
                                <div class="col-lg-9 col-md-12">
                                    <div class="row">
                                        @if (Auth::user())
                                            @if (count($lists) > 0)
                                                @foreach ($lists as $key => $list)
                                                    <?php
                                                    $category = \App\Models\Category::where('id', $list->category_id)->first();
                                                    $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                                    $model = \App\CarModel::where('id', $list->model_id)->first();
                                                    $details = \App\CarDetail::where('id', $list->details_id)->first();
                                                    $year = \App\CarYear::where('id', $list->year_id)->first();
                                                    $type = \App\CarType::where('id', $list->type_id)->first();
                                                    
                                                    if ($model) {
                                                        $carlist = \App\CarList::where('model_id', $model->id)->first();
                                                    }
                                                    ?>
                                                    <div class="col-md-5 mr-3 mt-1">
                                                        <form action="" method="get">
                                                            <input type="hidden" name="category_id" value="tyre">
                                                            <input type="hidden" name="brand_id"
                                                                value="{{ $list->brand_id }}">
                                                            <input type="hidden" name="model_id"
                                                                value="{{ $list->model_id }}">
                                                            <input type="hidden" name="details_id"
                                                                value="{{ $list->details_id }}">
                                                            <input type="hidden" name="year_id"
                                                                value="{{ $list->year_id }}">
                                                            <input type="hidden" name="type_id"
                                                                value="{{ $list->type_id }}">
                                                            <button style="border: 2px solid;" type="submit"
                                                                class="btn btn-default">
                                                                {{ $brand ? $brand->name : '' }}
                                                                , {{ $model ? $model->name : '' }} @if (isset($list->car_plate))
                                                                    ,
                                                                @endif {{ $list->car_plate }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products section -->
    <section class="mb-4" id="hero-section1" style="background-color: gray;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 left mt-2">
                    <h3 class="ml-4 mt-3">Featured Brand</h3>
                    <hr>
                    <?php
                    $featured_categories = \App\FeaturedCategory::all();
                    $vehicle_categories = \App\VehicleCategory::all();
                    ?>
                    <ul class="menu2 hmenu hmenu-translateX-right" data-menu-id="2" data-parent-menu-id="1"
                        id="accordion">
                        @if (count($featured_categories))
                            @foreach ($featured_categories as $featured_category)
                                <?php
                                $featured_sub_categories = \App\FeaturedSubCategory::where('featured_category_id', $featured_category->id)->get();
                                ?>
                                <li>
                                    {{--                                    <form action="{{ url('category/demo-category-1') }}" method="get" style="margin-bottom: 0px;"> --}}
                                    {{--                                        <input type="hidden" name="featured_category_id" value="{{ $featured_category->id }}"> --}}
                                    <button type="button" data-toggle="collapse"
                                        href="#collapse_{{ $featured_category->id }}" aria-expanded="true"
                                        aria-controls="collapse_{{ $featured_category->id }}" class="btn btn-default"
                                        style="height: 30px;font-weight: 700;font-size: 18px;">
                                        {{ $featured_category->name }}
                                    </button>
                                    {{--                                    </form> --}}
                                    <ul class="collapse {{ $loop->first ? 'show' : '' }}"
                                        id="collapse_{{ $featured_category->id }}" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        @if (count($featured_sub_categories) > 0)
                                            @foreach ($featured_sub_categories as $featured_sub_category)
                                                <form action="{{ url('category/tyres') }}" method="get"
                                                    style="margin-bottom: 0px;">
                                                    <input type="hidden" name="featured_category_id"
                                                        value="{{ $featured_category->id }}">
                                                    <input type="hidden" name="featured_sub_category_id"
                                                        value="{{ $featured_sub_category->id }}">
                                                    <li>
                                                        <button type="submit" class="btn btn-default"
                                                            style="font-size: 17px;">
                                                            {{ $featured_sub_category->name }}
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <hr>
                    <h3 class="ml-4 mt-3">By Vehicle</h3>
                    <hr>
                    <ul class="menu2 hmenu hmenu-translateX-right" data-menu-id="2" data-parent-menu-id="1">
                        @foreach ($vehicle_categories as $vehicle_category)
                            <li>
                                <form action="{{ url('category/tyres') }}" method="get" style="margin-bottom: 0px;">
                                    <input type="hidden" name="vehicle_category_id"
                                        value="{{ $vehicle_category->id }}">
                                    <button type="submit" class="btn btn-default"
                                        style="font-weight: 700;font-size: 18px;">
                                        {{ $vehicle_category->name }}
                                    </button>
                                </form>
                            </li>
                            <br>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 right">
                    <div class="row">
                        <div class="col-md-7 pagination_box">
                            @if (count($products) > 0)
                                <center class="link_pagi mt-4">
                                    {{ $products->links() }}
                                </center>
                            @endif
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <div class="form-group mt-2">
                                @if ($category_id && $brand_id && $model_id)
                                    <select class="form-control form-control-sm aiz-selectpicker card-r" name="sort_by"
                                        onchange="sortfilter1(this)" data-live-search="true">
                                        <option value="">Sort By</option>
                                        <option value="newest" @if (isset($sort_by) && $sort_by == 'newest') selected @endif>
                                            {{ translate('Newest') }}</option>
                                        <option value="oldest" @if (isset($sort_by) && $sort_by == 'oldest') selected @endif>
                                            {{ translate('Oldest') }}</option>
                                        <option value="price-asc" @if (isset($sort_by) && $sort_by == 'price-asc') selected @endif>
                                            {{ translate('Price low to high') }}</option>
                                        <option value="price-desc" @if (isset($sort_by) && $sort_by == 'price-desc') selected @endif>
                                            {{ translate('Price high to low') }}</option>
                                    </select>
                                @elseif(isset($_GET['size_cat_id']))
                                    <select class="form-control form-control-sm aiz-selectpicker card-r" name="sort_by"
                                        onchange="sortfilter2(this)" data-live-search="true">
                                        <option value="">Sort By</option>
                                        <option value="newest" @if (isset($sort_by) && $sort_by == 'newest') selected @endif>
                                            {{ translate('Newest') }}</option>
                                        <option value="oldest" @if (isset($sort_by) && $sort_by == 'oldest') selected @endif>
                                            {{ translate('Oldest') }}</option>
                                        <option value="price-asc" @if (isset($sort_by) && $sort_by == 'price-asc') selected @endif>
                                            {{ translate('Price low to high') }}</option>
                                        <option value="price-desc" @if (isset($sort_by) && $sort_by == 'price-desc') selected @endif>
                                            {{ translate('Price high to low') }}</option>
                                    </select>
                                @else
                                    <select class="form-control form-control-sm aiz-selectpicker card-r" name="sort_by"
                                        onchange="sortfilter3(this)">
                                        <option value="">Sort By</option>
                                        <option value="newest" @if (isset($sort_by) && $sort_by == 'newest') selected @endif>
                                            {{ translate('Newest') }}</option>
                                        <option value="oldest" @if (isset($sort_by) && $sort_by == 'oldest') selected @endif>
                                            {{ translate('Oldest') }}</option>
                                        <option value="price-asc" @if (isset($sort_by) && $sort_by == 'price-asc') selected @endif>
                                            {{ translate('Price low to high') }}</option>
                                        <option value="price-desc" @if (isset($sort_by) && $sort_by == 'price-desc') selected @endif>
                                            {{ translate('Price high to low') }}</option>
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="container card-area">
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <div class="row main-card mt-5">
                                    <div class="col-lg-2 left-side">
                                        <div class="row sun">
                                            <div class="col-md-12">
                                                <i class="fa-solid fa-sun"></i>
                                            </div>
                                        </div>
                                        <div class="row tyre">
                                            <div class="col-md-12" style="text-align: center;">
                                                <a href="{{ route('product', $product->slug) }}">
                                                    <img class="lazyload mt-3" width="100%"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                        alt="{{ $product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                        </div>
                                        {{--                                    <div class="row check-box-area"> --}}
                                        {{--                                        <div class="col-md-12" style="text-align: center; position: absolute; bottom: 20px;"> --}}
                                        {{--                                            <input type="checkbox" id="check1"> --}}
                                        {{--                                            <label for="">Compare</label> --}}
                                        {{--                                        </div> --}}
                                        {{--                                    </div> --}}
                                        <div id="triangle-topleft"></div>
                                        <h5
                                            style="transform: rotate(-45deg); position: absolute; top: -10px; left: 5px; color: white; line-height: 3; font-size: 16px;">
                                            <i class="fa-solid fa-star"></i></h5>
                                        <h5
                                            style="transform: rotate(-45deg); position: absolute; top: 6px; left: 21px; color: white; line-height: 3;">
                                            DH</h5>
                                        <h5
                                            style="transform: rotate(-45deg); position: absolute; top: 20px; left: -15px; color: white; line-height: 3;">
                                            Recommends</h5>
                                    </div>
                                    <div class="col-lg-10 right-side py-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="{{ route('product', $product->slug) }}">
                                                    <h3 style="padding-top: 0px; padding-left: 0px;">
                                                        {{ $product->getTranslation('name') }}</h3>
                                                </a>
                                                {{--                                            <h5>Pilot Sport 4</h5> --}}
                                                <h5 style="font-weight: normal;">{{ $product->tyre_size }}</h5>
                                                {{--                                            <h6 class="border-label"><i class="fa-solid fa-gas-pump"></i>&nbsp;D | <i class="fa-solid fa-cloud-rain"></i>&nbsp;A | <i class="fa-solid fa-volume-high"></i>&nbsp;B 70dB</h6> --}}

                                            </div>
                                            <div class="col-6">
                                                <h4 class="free-delivery-text">Free delivery</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-6"></div>
                                            <div class="col-lg-2 col-md-3 col-6 left-side2 mt-3">
                                                <p>Availability:</p>
                                                @php
                                                    $product_current_qty = 0;
                                                    $purchased_qty = 0;
                                                    $percent_value = 0;
                                                    foreach ($product->stocks as $key => $stock) {
                                                        $product_current_qty += $stock->qty;
                                                    }
                                                    $purchased_qty += \DB::table('order_details')
                                                        ->where('product_id', $product->id)
                                                        ->sum('quantity');
                                                    $total_qty = $product_current_qty + $purchased_qty;
                                                    if ($total_qty > 0) {
                                                        $percent_value = ($product_current_qty * 100) / $total_qty;
                                                    }
                                                @endphp
                                                <div class="progress" style="width: 70%;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $percent_value }}%"
                                                        aria-valuenow="{{ $percent_value }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-6 right-side2">
                                                <h3 style="color: black; padding-top:0px; padding-left:0px;">
                                                    {{ home_discounted_base_price($product) }}
                                                </h3>
                                                @if (home_base_price($product) != home_discounted_base_price($product))
                                                    <p><del
                                                            class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                                    </p>
                                                @endif
                                                <button class="btn"
                                                    onclick="showAddToCartModal({{ $product->id }})">Add to
                                                    cart</button>
                                            </div>
                                        </div>
                                        <div class="row last-review-area">
                                            <div class="col-md-6">
                                                <div class="star-sec" style="display: flex;">
                                                    <h5>
                                                        <?php
                                                        $total = 0;
                                                        $total_rating_count = 0;
                                                        $total_rating = 0;
                                                        $fstar = \App\Review::where('rating', 5)
                                                            ->where('product_id', $product->id)
                                                            ->get();
                                                        $fostar = \App\Review::where('rating', 4)
                                                            ->where('product_id', $product->id)
                                                            ->get();
                                                        $tstar = \App\Review::where('rating', 3)
                                                            ->where('product_id', $product->id)
                                                            ->get();
                                                        $twstar = \App\Review::where('rating', 2)
                                                            ->where('product_id', $product->id)
                                                            ->get();
                                                        $ostar = \App\Review::where('rating', 1)
                                                            ->where('product_id', $product->id)
                                                            ->get();
                                                        
                                                        $sum_fstar = \App\Review::where('rating', 5)
                                                            ->where('product_id', $product->id)
                                                            ->sum('rating');
                                                        $sum_fostar = \App\Review::where('rating', 4)
                                                            ->where('product_id', $product->id)
                                                            ->sum('rating');
                                                        $sum_tstar = \App\Review::where('rating', 3)
                                                            ->where('product_id', $product->id)
                                                            ->sum('rating');
                                                        $sum_twstar = \App\Review::where('rating', 2)
                                                            ->where('product_id', $product->id)
                                                            ->sum('rating');
                                                        $sum_ostar = \App\Review::where('rating', 1)
                                                            ->where('product_id', $product->id)
                                                            ->sum('rating');
                                                        
                                                        $total_rating_count = count($fstar) + count($fostar) + count($tstar) + count($twstar) + count($ostar);
                                                        $total_rating = $sum_fstar + $sum_fostar + $sum_tstar + $sum_twstar + $sum_ostar;                                                        ?>
                                                        @if (isset($total_rating_count) && isset($total_rating) && $total_rating_count > 0 && $total_rating > 0)
                                                            {{ number_format($total_rating / $total_rating_count, 1) }}
                                                        @else
                                                            0.0
                                                        @endif
                                                    </h5>
                                                    <div class="rate ml-2 mt-1">
                                                        @if ($product->rating)
                                                            @php
                                                                $total += $product->reviews->count();
                                                            @endphp
                                                            <div class="rate rating">
                                                                @for ($i = 0; $i < $product->rating; $i++)
                                                                    <i class="las la-star active"></i>
                                                                @endfor
                                                                @for ($i = 0; $i < 5 - $product->rating; $i++)
                                                                    <i class="las la-star"></i>
                                                                @endfor
                                                            </div>
                                                        @else
                                                            <div class="rate">
                                                                <i class="las la-star active active-unsold"></i>
                                                                <i class="las la-star active active-unsold"></i>
                                                                <i class="las la-star active active-unsold"></i>
                                                                <i class="las la-star active active-unsold"></i>
                                                                <i class="las la-star active active-unsold"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p>{{ $total }} reviews</p>
                                            </div>
                                            <div class="col-md-6 express">
                                                <p>Delivery Time:&nbsp;&nbsp;</p>
                                                <h3><i class="fa-solid fa-van-shuttle"></i>&nbsp;Express</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No record found.</p>
                        @endif
                    </div>
                    <!-- /Card -->
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" value="{{ isset($brand_id) ? $brand_id : '' }}" id="brand">
    <input type="hidden" value="{{ isset($model_id) ? $model_id : '' }}" id="model">
    <input type="hidden" value="{{ isset($details_id) ? $details_id : '' }}" id="detail">
    <input type="hidden" value="{{ isset($year_id) ? $year_id : '' }}" id="year">
    <input type="hidden" value="{{ isset($type_id) ? $type_id : '' }}" id="type">
    <input type="hidden" value="{{ isset($_GET['size_cat_id']) ? $_GET['size_cat_id'] : '' }}" id="get_size_cat_id">
    <input type="hidden" value="{{ isset($_GET['sub_cat_id']) ? $_GET['sub_cat_id'] : '' }}" id="get_sub_cat_id">
    <input type="hidden" value="{{ isset($_GET['child_cat_id']) ? $_GET['child_cat_id'] : '' }}"
        id="get_child_cat_id">
@endsection
@section('script')
    <script type="text/javascript">
        function filter1() {
            $('#search-form1').submit();
        }

        function filter2() {
            $('#search-form2').submit();
        }

        function filter3() {
            $('#search-form3').submit();
        }

        function sortfilter1(el) {
            $(".sort_by").val($(el).val());
            $('#search-form1').submit();
        }

        function sortfilter2(el) {
            $(".sort_by").val($(el).val());
            $('#search-form2').submit();
        }

        function sortfilter3(el) {
            $(".sort_by").val($(el).val());
            $('#search-form3').submit();
        }

        function filter() {
            $('#search-form').submit();
        }

        function size_subcats_ajax() {
            var cat_id = $('#size_cat_id').val();
            $.ajax({
                url: "{{ url('get-size-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('#sub_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');
                }
            });
        }

        function size_childcats_ajax() {
            var cat_id = $('#sub_cat_id').val();
            $.ajax({
                url: "{{ url('get-size-child-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('#child_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');
                }
            });
        }
    </script>

@endsection
