@extends('frontend.layouts.app')

@section('content')

    <style>
        @media(max-width:992px) {
            .wrapper {
                width: 100%
            }
        }

        .panel-heading {
            padding: 0;
            border: 0
        }

        .panel-title>a,
        .panel-title>a:active {
            display: block;
            padding: 15px;
            color: #555;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            word-spacing: 3px;
            text-decoration: none
        }

        .panel-heading a:before {
            font-family: 'Glyphicons Halflings';
            content: "\e114";
            float: right;
            transition: all .5s
        }

        .panel-heading.active a:before {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            transform: rotate(180deg)
        }

        input[type=checkbox] {
            width: 19px;
            height: 19px;
            vertical-align: -2px
        }

        input:checked {
            height: 25px;
            width: 25px
        }

        #info {
            background-color: #eaeaea;
            padding: 8px 15px;
            box-shadow: 0 0 1px #9b9b9b;
            margin: 5px 0 10px -10px;
            color: #000;
            font: 17px Calibri;
            width: 90%
        }

        .tools {
            overflow: auto;
            zoom: 1
        }

        .search-area {
            float: left;
            width: 60%
        }

        .settings {
            display: none;
            float: right;
            width: 40%;
            text-align: right
        }

        #view {
            display: none;
            width: auto;
            height: 47px
        }

        #searchbutton {
            width: 60px;
            height: 47px
        }

        @media screen and (max-width:400px) {
            .search-area {
                width: 100%
            }
        }

        .products {
            width: 100%
        }

        .product {
            display: inline-block;
            width: calc(24% - 13px);
            margin: 10px 10px 30px 10px;
            vertical-align: top
        }

        .product img {
            display: block;
            margin: 0 auto;
            width: auto;
            height: 200px;
            max-width: calc(100% - 20px);
            background-cover: fit;
            box-shadow: 0 0 7px 0 rgba(0, 0, 0, .8);
            border-radius: 2px
        }

        .product-content {
            text-align: center
        }

        .product h3 {
            font-size: 20px;
            font-weight: 600;
            margin: 10px 0 0 0
        }

        .product h3 small {
            display: block;
            font-size: 16px;
            font-weight: 400;
            margin: 7px 0 0 0
        }

        .product .product-text {
            margin: 7px 0 0 0;
            color: #777
        }

        .product .price {
            font-size: 16px;
            font-weight: 700
        }

        .product .genre {
            font-size: 14px
        }

        @media screen and (max-width:1150px) {
            .product {
                width: calc(33% - 23px)
            }
        }

        @media screen and (max-width:700px) {
            .product {
                width: calc(50% - 43px)
            }
        }

        @media screen and (max-width:400px) {
            .product {
                width: 100%
            }
        }

        @media screen and (min-width:401px) {
            .settings {
                display: block
            }

            #view {
                display: inline
            }

            .products-table .product {
                display: block;
                width: auto;
                margin: 10px 10px 30px 10px
            }

            .products-table .product .product-img {
                display: inline-block;
                margin: 0;
                width: 120px;
                height: 120px
            }

            .products-table .product img {
                width: auto;
                height: 120px;
                max-width: 120px
            }

            .products-table .product-content {
                text-align: left;
                display: inline-block;
                margin-left: 20px;
                vertical-align: middle;
                width: calc(100% - 145px)
            }

            .products-table .product h3 {
                margin: 0
            }
        }

        .product img {
            box-shadow: 0 0 0 0 rgb(0 0 0 / 80%)
        }

        h4 {
            color: #fb5531
        }

        .btn-circle.btn-xl {
            width: 35px;
            height: 35px;
            padding: 10px 16px;
            border-radius: 35px;
            font-size: 24px;
            line-height: 1.33
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857
        }
    </style>

    <?php
    if (isset($_GET['r_brand_id'])) {
        Session::put('session_brand_id', $_GET['r_brand_id']);
        Session::put('session_model_id', $_GET['r_model_id']);
        Session::put('session_details_id', $_GET['r_details_id']);
        Session::put('session_year_id', $_GET['r_year_id']);
        Session::put('session_type_id', $_GET['r_type_id']);
    }
    
    ?>
    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="classified-container  flexbox  flexbox--fixed">
                        <div class="flexbox__item">
                            <div class="classified-search  classified-search--malaysia  one-whole">
                                <div class="">
                                    <h1 class="zeta  flush--bottom  weight--semibold"
                                        style="font-family: Montserrat, sans-serif;font-style: normal;font-size: 20px;font-weight: 700;">
                                        Find brand &amp; car models </h1>
                                </div>
                                <div class="classified-search__body  soft-half--bottom">
                                    <form action="{{ route('search.result') }}"
                                        class="classified-form  js-classified-form  js-form-validation mt-2 navsearchform">
                                        @csrf
                                        <input type="hidden" name="category_id" id="category_value"
                                            value="{{ isset($r_category_name) ? $r_category_name : '' }}">
                                        <div class="row mb-3">
                                            <div class="col-md-4 col-sm-12">
                                                <div
                                                    class="classified-input  classified-input--condition  float--left  one-whole">
                                                    <small id="psb" style="color: red;display:none">Please Select
                                                        Brand*</small>
                                                    <select
                                                        class="form-control selectize-input items input-readonly not-full has-options"
                                                        name="brand_id" id="brand_id" data-live-search="true"
                                                        onchange="models()" required>
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
                                            <div class="col-md-4 col-sm-12">
                                                <div
                                                    class="classified-input  classified-input--brand palm--one-whole  classified-input--left">
                                                    <select name="model_id" id="model_id"
                                                        class="form-control selectize-input items input-readonly not-full has-options"
                                                        data-live-search="true" onchange="details()">
                                                        <option value="">Select Model</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="classified-input  classified-input--model palm--one-whole">
                                                    <select name="details_id" id="details_id"
                                                        class="form-control selectize-input items input-readonly not-full has-options"
                                                        onchange="car_years()">
                                                        <option value="">Select Year</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 col-sm-12">
                                                <div
                                                    class="classified-input classified-input--location palm--one-whole  classified-input--left">
                                                    <select name="year_id" id="year_id"
                                                        class="form-control selectize-input items input-readonly not-full has-options"
                                                        onchange="types()">
                                                        <option value="">Select Car CC</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div
                                                    class="classified-input  classified-input--location palm--one-whole  classified-input--left">
                                                    <select name="type_id" id="type_id"
                                                        class="form-control selectize-input items input-readonly not-full has-options">
                                                        <option value="">Select Variant</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="search-button  one-whole">
                                                    @if (!isset($r_category_name))
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button class="btn  btn--primary" type="button"
                                                                    style="background-color: #ffda00; border-color: transparent; color: #242e39 !important;"
                                                                    onclick="showCategory()">Search
                                                                </button>
                                                                <button class="btn  btn-primary" onclick="changeActionUrl()"
                                                                    type="button">Add Vehicle
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group categories"
                                                            style="width: -webkit-fill-available;display:none;background:#E62E04">
                                                            @foreach (\App\Models\Category::orderBy('id', 'asc')->get() as $item)
                                                                @if ($item->name != 'Accessories')
                                                                    <button type="submit" class="btn btn-primary bg-color"
                                                                        onclick="select_type('{{ $item->name }}')">{{ $item->name }}
                                                                    </button>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr class="rule  flush">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="section_featured">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">All
                                    Packages</span>
                            </h3>
                        </div>
                    </div>

                    <div class="mt-2">
                        <h5 style="color: #F37021"><b>Guide: &nbsp;Choose First Mileage> &nbsp;Choose Package> &nbsp;Add To
                                Cart Products</b></h5>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <form class="" id="sort_mileges" action="" method="GET">
                                <input type="hidden" name="category_id" value="Service">
                                @if (isset($cs->brand_id) && $cs->brand_id != 0)
                                    <input type="hidden" name="brand_id"
                                        value="{{ isset($cs->brand_id) ? $cs->brand_id : '' }}">
                                    <input type="hidden" name="model_id"
                                        value="{{ isset($cs->model_id) ? $cs->model_id : '' }}">
                                    <input type="hidden" name="details_id"
                                        value="{{ isset($cs->details_id) ? $cs->details_id : '' }}">
                                    <input type="hidden" name="year_id"
                                        value="{{ isset($cs->year_id) ? $cs->year_id : '' }}">
                                    <input type="hidden" name="type_id"
                                        value="{{ isset($cs->type_id) ? $cs->type_id : '' }}">

                                    <h3 class="h5 fw-700">
                                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0"
                                            id="package_id" name="package_id" onchange="sort_mileges()">
                                            <option value="">{{ translate('Mileages') }}</option>
                                            @if (isset($mpackages) && count($mpackages) > 0)
                                                @foreach ($mpackages as $key => $package)
                                                    <option value="{{ $package->id }}">{{ $package->mileage }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </h3>
                                @elseif(Session::get('session_model_id'))
                                    <input type="hidden" name="brand_id"
                                        value="{{ Session::get('session_brand_id') }}">
                                    <input type="hidden" name="model_id"
                                        value="{{ Session::get('session_model_id') }}">
                                    <input type="hidden" name="details_id"
                                        value="{{ Session::get('session_details_id') }}">
                                    <input type="hidden" name="year_id" value="{{ Session::get('session_year_id') }}">
                                    <input type="hidden" name="type_id" value="{{ Session::get('session_type_id') }}">

                                    <h3 class="h5 fw-700">

                                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0"
                                            id="package_id" name="package_id" onchange="sort_mileges()">
                                            <option value="">{{ translate('Mileages') }}</option>
                                            @if (isset($mpackages) && count($mpackages) > 0)
                                                @foreach ($mpackages as $key => $package)
                                                    <option value="{{ $package->id }}">{{ $package->mileage }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </h3>

                                @endif
                            </form>
                        </div>
                    </div>


                    <?php
                    if (!Auth::user()) {
                        flash(translate('Please Login First for changing group item!'))->error();
                        '<script>location.reload();</script>';
                    }
                    ?>
                    @if (isset($packages) && count($packages) > 0)
                        @foreach ($packages as $key => $package)
                            <?php
                            $ppr = App\PackageProduct::where('package_id', $package->id)
                                ->where('type', 'Recommended')
                                ->first();
                            $ppa = App\PackageProduct::where('package_id', $package->id)
                                ->where('type', 'Addon')
                                ->first();
                            
                            if (Auth::user()) {
                                if (isset($ppr)) {
                                    $pppr = DB::table('cart_package_products')
                                        ->where('product_id', $ppr->id)
                                        ->where('user_id', Auth::id())
                                        ->first();
                                }
                                if (isset($ppa)) {
                                    $pppa = DB::table('cart_package_products')
                                        ->where('product_id', $ppa->id)
                                        ->where('user_id', Auth::id())
                                        ->first();
                                }
                            
                                if (isset($pppr)) {
                                    $rrproducts = json_decode(!empty($pppr->products) ? $pppr->products : '', true);
                                } else {
                                    $rrproducts = json_decode(!empty($ppr->products) ? $ppr->products : '', true);
                                }
                                if (isset($pppa)) {
                                    $aaproducts = json_decode($pppa->products, true);
                                } else {
                                    $aaproducts = json_decode(isset($ppa) ? $ppa->products : '', true);
                                }
                            
                                ////Recommended part
                                if (isset($rrproducts)) {
                                    $numbers = $rrproducts;
                                    if (isset($_GET['old_id']) && $_GET['old_id']) {
                                        //                                    dd($_GET['old_id']);
                                        if (($rkey = array_search($_GET['old_id'], $numbers)) !== false) {
                                            unset($numbers[$rkey]);
                                            $numbers[$rkey] = $_GET['new_id'];
                                            ksort($numbers);
                                            $numbers = array_values($numbers);
                                        }
                                        $rrproducts = $numbers;
                                    }
                                }
                                //dd($aaproducts);
                                //////Addon Part
                                $anumbers = $aaproducts;
                            
                                if (isset($_GET['old_id']) && $_GET['old_id'] && $anumbers) {
                                    if (($akey = array_search($_GET['old_id'], $anumbers)) !== false) {
                                        unset($anumbers[$akey]);
                                        $anumbers[$akey] = $_GET['new_id'];
                                        ksort($anumbers);
                                        $anumbers = array_values($anumbers);
                                    }
                                    $aaproducts = $anumbers;
                                }
                                if (isset($ppr)) {
                                    if (isset($ppr)) {
                                        if ($pppr) {
                                            DB::table('cart_package_products')
                                                ->where('product_id', $ppr->id)
                                                ->where('user_id', Auth::id())
                                                ->update([
                                                    'user_id' => Auth::id(),
                                                    'products' => json_encode(array_unique($rrproducts)),
                                                ]);
                                        } else {
                                            DB::table('cart_package_products')
                                                ->where('product_id', $ppr->id)
                                                ->insert([
                                                    'product_id' => $ppr->id,
                                                    'package_id' => $ppr->package_id,
                                                    'user_id' => Auth::id(),
                                                    'products' => json_encode(array_unique($rrproducts)),
                                                ]);
                                        }
                                    }
                                }
                                if (isset($ppa)) {
                                    if ($pppa) {
                                        DB::table('cart_package_products')
                                            ->where('product_id', $ppa->id)
                                            ->where('user_id', Auth::id())
                                            ->update([
                                                'user_id' => \Auth::id(),
                                                'products' => json_encode(array_unique($aaproducts)),
                                            ]);
                                    } else {
                                        DB::table('cart_package_products')
                                            ->where('product_id', $ppa->id)
                                            ->insert([
                                                'product_id' => $ppa->id,
                                                'package_id' => $ppa->package_id,
                                                'user_id' => Auth::id(),
                                                'products' => json_encode(array_unique($aaproducts)),
                                                'type' => 'Addon',
                                            ]);
                                    }
                                }
                            } else {
                                $rrproducts = json_decode(!empty($ppr->products) ? $ppr->products : '', true);
                                $aaproducts = json_decode(isset($ppa) ? $ppa->products : '', true);
                            }
                            
                            ?>

                            <?php
                            $package = App\Package::where('id', $package->id)->first();
                            $aproducts = [];
                            $ppr = App\PackageProduct::where('package_id', $package->id)
                                ->where('type', 'Recommended')
                                ->first();
                            $ppa = App\PackageProduct::where('package_id', $package->id)
                                ->where('type', 'Addon')
                                ->first();
                            //
                            $rproducts = json_decode(!empty($ppr->products) ? $ppr->products : '', true);
                            if ($ppa) {
                                $aproducts = json_decode($ppa->products, true);
                            }
                            ?>
                            @if ($rrproducts != null)
                                <?php
                                
                                $gproduct = 0;
                                ?>
                                @foreach ($rrproducts as $item)
                                    @if ($item != 'on')
                                        <?php
                                        $tproduct = DB::table('products')
                                            ->where('id', $item)
                                            ->sum('unit_price');
                                        $gproduct = $gproduct + $tproduct;
                                        
                                        ?>
                                    @endif
                                @endforeach
                            @endif

                            @if ($aaproducts != null)
                                @foreach ($aaproducts as $item)
                                    @if ($item != 'on')
                                        <?php
                                        $tproduct = DB::table('products')
                                            ->where('id', $item)
                                            ->sum('unit_price');
                                        $gproduct = $gproduct + $tproduct;
                                        ?>
                                    @endif
                                @endforeach
                            @endif
                            @if ($rrproducts == null && $aaproducts == null)
                                <?php
                                
                                $gproduct = 0;
                                ?>
                            @endif

                            @if (isset($_GET['package_id']))
                                <div class="wrapper center-block">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="" role="tab" id="headingOne">
                                                <h4 class="panel-title">

                                                    <a role="button" class="collapse_action" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapseOne{{ $key }}"
                                                        aria-expanded="true" aria-controls="collapseOne"
                                                        onclick="chkfunc('{{ $key }}')">
                                                        <div id="check_container_div">

                                                            <b>
                                                                <button type="button" class="btn btn-circle btn-xl"
                                                                    id="btn-circle{{ $key }}"
                                                                    style="border: 1px solid"><i class="fa fa-heart"></i>
                                                                </button>
                                                                {{ $package->getTranslation('name') }}
                                                            </b>
                                                            @if (isset($gproduct) && $gproduct != 0)
                                                                <span class="mt-1 ml-2"
                                                                    style="border: 2px solid;padding: 5px;float: right;color: #F37021">{{ single_price($gproduct) }}</span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <hr>
                                            <div id="collapseOne{{ $key }}" class="panel-collapse collapse in"
                                                role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">

                                                    <h6><b>Recommended Products
                                                            <span style="float: right;"><a
                                                                    href="{{ url('cart/packageToCart', $package->id) }}"
                                                                    class="btn btn-soft-primary mr-2 fw-600">
                                                                    <i class="las la-shopping-bag"></i>
                                                                    <span class="d-none d-md-inline-block">
                                                                        {{ translate('Add to cart') }}</span>
                                                                </a></span></b></h6>
                                                    <hr class="mt-5">

                                                    <div class="row">


                                                        @if ($rrproducts != null)
                                                            @foreach ($rrproducts as $item)
                                                                @if ($item != 'on')
                                                                    <?php
                                                                    $product = DB::table('products')
                                                                        ->where('id', $item)
                                                                        ->first();
                                                                    $stock = DB::table('product_stocks')
                                                                        ->where('product_id', $item)
                                                                        ->first();
                                                                    
                                                                    $group_products = DB::table('product_groups')
                                                                        ->whereJsonContains('product_id', $item)
                                                                        ->first();
                                                                    if ($group_products) {
                                                                        $json_groups = json_decode($group_products->product_id);
                                                                    }
                                                                    ?>

                                                                    @if ($product)
                                                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                            <a href="{{ route('product', $product->slug) }}"
                                                                                class="d-block">
                                                                                <img class=""
                                                                                    style="height: 122px;width: 170px;"
                                                                                    src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    alt=""
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                            <div class="clearfix mb-3">
                                                                                <span class="float-end"><a
                                                                                        href="#"><a
                                                                                            href="{{ route('product', $product->slug) }}"
                                                                                            class="d-block text-reset">
                                                                                            {{ $product->name }}
                                                                                        </a></a></span>
                                                                            </div>
                                                                            <h5 class="card-title">{!! Str::limit($product->description, 190) !!}
                                                                            </h5>

                                                                            @if ($group_products)
                                                                                @foreach ($json_groups as $group_id)
                                                                                    <?php
                                                                                    $g_product = DB::table('products')
                                                                                        ->where('id', $group_id)
                                                                                        ->first();
                                                                                    $g_stock = DB::table('product_stocks')
                                                                                        ->where('product_id', $group_id)
                                                                                        ->first();
                                                                                    ?>

                                                                                    <form action="" method="get"
                                                                                        id="sort_ggroup">
                                                                                        <input type="hidden"
                                                                                            value="{{ $product->id }}"
                                                                                            name="old_id">
                                                                                        <input type="hidden"
                                                                                            value="{{ $g_product->id }}"
                                                                                            name="new_id">
                                                                                        <input type="hidden"
                                                                                            name="category_id"
                                                                                            value="Service">
                                                                                        <input type="hidden"
                                                                                            name="key"
                                                                                            value="{{ $key }}">
                                                                                        <input type="hidden"
                                                                                            name="brand_id"
                                                                                            value="{{ isset($_GET['brand_id']) ? $_GET['brand_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="model_id"
                                                                                            value="{{ isset($_GET['model_id']) ? $_GET['model_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="details_id"
                                                                                            value="{{ isset($_GET['details_id']) ? $_GET['details_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="year_id"
                                                                                            value="{{ isset($_GET['year_id']) ? $_GET['year_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="type_id"
                                                                                            value="{{ isset($_GET['type_id']) ? $_GET['type_id'] : '' }}">

                                                                                        <input type="hidden"
                                                                                            name="package_id"
                                                                                            value="{{ $_GET['package_id'] }}">


                                                                                        <div class="row">

                                                                                            <div class="col-2">
                                                                                                <button
                                                                                                    href="javascript:void(0)"
                                                                                                    onclick="callGroupFunc()"
                                                                                                    class="d-block">
                                                                                                    <img class=""
                                                                                                        style="height: 40px;width: 60px;"
                                                                                                        src="{{ uploaded_asset($g_product->thumbnail_img) }}"
                                                                                                        alt=""
                                                                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                                                </button>
                                                                                                <small class=""
                                                                                                    style="color: #E62E04">{{ single_price($g_product->unit_price) }}</small>
                                                                                            </div>
                                                                                            <div class="col-2">
                                                                                                <small class=""
                                                                                                    style="font-weight:600">{{ $g_product->name }}</small>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{-- <input type="submit" value="" id="mysubmit"> --}}
                                                                                    </form>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                            <b class="d-grid gap-2 mt-3 my-4"
                                                                                style="color: #E62E04">{{ single_price($product->unit_price) }}</b>
                                                                        </div>
                                                                    @endif
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <div class="text-center p-3">
                                                                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                                                <h3 class="h6 fw-700">Recommended Products is empty</h3>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <h6><b>Addon Products
                                                        </b></h6>
                                                    <hr>
                                                    <div class="row">
                                                        @if ($aaproducts != null)
                                                            @foreach ($aaproducts as $item)
                                                                @if ($item != 'on')
                                                                    <?php
                                                                    $product = DB::table('products')
                                                                        ->where('id', $item)
                                                                        ->first();
                                                                    $stock = DB::table('product_stocks')
                                                                        ->where('product_id', $item)
                                                                        ->first();
                                                                    
                                                                    $agroup_products = DB::table('product_groups')
                                                                        ->whereJsonContains('product_id', $item)
                                                                        ->first();
                                                                    //                                                                print_r($agroup_products);
                                                                    if ($agroup_products) {
                                                                        $ajson_groups = json_decode($agroup_products->product_id);
                                                                    }
                                                                    ?>



                                                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                        <a href="{{ route('product', $product->slug) }}"
                                                                            class="d-block">
                                                                            <img class=""
                                                                                style="height: 122px;width: 170px;"
                                                                                src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                alt=""
                                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                        <div class="clearfix mb-3">
                                                                            <span class="float-end"><a href="#"><a
                                                                                        href="{{ route('product', $product->slug) }}"
                                                                                        class="d-block text-reset">
                                                                                        {{ $product->name }}
                                                                                    </a></a></span>
                                                                        </div>
                                                                        <h5 class="card-title">{!! Str::limit($product->description, 190) !!}</h5>

                                                                        @if ($agroup_products)
                                                                            <div class="row"
                                                                                style="border: 2px solid #EC2303;padding: 20px;">
                                                                                @foreach ($ajson_groups as $group_id)
                                                                                    <?php
                                                                                    $g_product = DB::table('products')
                                                                                        ->where('id', $group_id)
                                                                                        ->first();
                                                                                    $g_stock = DB::table('product_stocks')
                                                                                        ->where('product_id', $group_id)
                                                                                        ->first();
                                                                                    ?>

                                                                                    <form action="" method="get"
                                                                                        id="sort_ggroup">
                                                                                        <input type="hidden"
                                                                                            value="{{ $product->id }}"
                                                                                            name="old_id">
                                                                                        <input type="hidden"
                                                                                            value="{{ $g_product->id }}"
                                                                                            name="new_id">

                                                                                        <input type="hidden"
                                                                                            name="category_id"
                                                                                            value="Service">
                                                                                        <input type="hidden"
                                                                                            name="key"
                                                                                            value="{{ $key }}">
                                                                                        <input type="hidden"
                                                                                            name="brand_id"
                                                                                            value="{{ isset($_GET['brand_id']) ? $_GET['brand_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="model_id"
                                                                                            value="{{ isset($_GET['model_id']) ? $_GET['model_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="details_id"
                                                                                            value="{{ isset($_GET['details_id']) ? $_GET['details_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="year_id"
                                                                                            value="{{ isset($_GET['year_id']) ? $_GET['year_id'] : '' }}">
                                                                                        <input type="hidden"
                                                                                            name="type_id"
                                                                                            value="{{ isset($_GET['type_id']) ? $_GET['type_id'] : '' }}">

                                                                                        <div class="col-2">
                                                                                            <button
                                                                                                href="javascript:void(0)"
                                                                                                onclick="callGroupFunc()"
                                                                                                class="d-block">
                                                                                                <img class=""
                                                                                                    style="height: 40px;width: 60px;"
                                                                                                    src="{{ uploaded_asset($g_product->thumbnail_img) }}"
                                                                                                    alt=""
                                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                                            </button>
                                                                                            <small
                                                                                                class="d-grid gap-2 mt-3 my-4"
                                                                                                style="color: #E62E04">{{ single_price($g_product->unit_price) }}</small>
                                                                                            <small
                                                                                                class="d-grid gap-2 mt-3 my-4"
                                                                                                style="">{{ $g_product->name }}</small>
                                                                                        </div>
                                                                                        {{-- <input type="submit" value="" id="mysubmit"> --}}
                                                                                    </form>

                                                                                    {{-- @endif --}}
                                                                                @endforeach

                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                        <b class="d-grid gap-2 mt-3 my-4"
                                                                            style="color: #E62E04">{{ single_price($product->unit_price) }}</b>
                                                                    </div>

                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <div class="text-center p-3">
                                                                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                                                <p class="h6 fw-700">Addon Products is empty</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center p-3">
                            <i class="las la-frown la-3x opacity-60 mb-3"></i>
                            <h3 class="h6 fw-700">is empty</h3>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script>
        function sort_mileges(el) {
            $('#sort_mileges').submit();
        }
    </script>
    <script>
        function callGroupFunc() {
            $('#sort_group').submit();
        }
    </script>

    @if (isset($_GET['old_id']) && $_GET['old_id'])
        <?php
        $r_key = isset($_GET['key']) ? $_GET['key'] : '';
        ?>
        <script>
            $('#btn-circle{{ $r_key }}').click();
            $('#btn-circle{{ $r_key }}').addClass("btn-primary");
        </script>
    @else
        <?php
        if (Auth::user()) {
            DB::table('cart_package_products')
                ->where('user_id', Auth::id())
                ->delete();
        }
        ?>
    @endif
@endsection
