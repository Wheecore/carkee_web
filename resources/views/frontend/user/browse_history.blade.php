@extends('frontend.layouts.app')
@section('content')
    <style>
        .card-area .main-card {
            border-radius: 20px;
            border: 1px solid gray;
            overflow: hidden;
        }

        .card-area .main-card .left-side .sun .fa-sun {
            font-size: 30px;
            color: #FFC700;
            float: right;
            margin-top: 10px;
        }

        .card-area .main-card .left-side .tyre {
            margin-top: 30%;
            margin-bottom: 5%;
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

        .card-area .main-card .right-side h3 {
            font-weight: bold;
            color: #016BC1;
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
        }

        .card-area .main-card .right-side .free-delivery-text span {
            float: right;
            font-weight: bold;
            color: white;
            text-shadow: 3px 1px 0 #ee6c28, -1px 1px 0 #ee6c28, 1px -1px 0 #ee6c28, -1px -1px 0 #ee6c28, 0px 1px 0 #ee6c28, 0px -1px 0 #ee6c28, -1px 0px 0 #ee6c28, 1px 0px 0 #ee6c28, 2px 2px 2px #ee6c28, -2px 2px 2px #ee6c28, 2px -2px 2px #ee6c28, -2px -2px 2px #ee6c28, 0px 2px 2px #ee6c28, 0px -2px 2px #ee6c28, -2px 0px 0 #ee6c28, 2px 0px 0 #ee6c28, 1px 2px 0 #ee6c28, -1px 2px 0 #ee6c28, 1px -2px 0 #ee6c28, -1px -2px 0 #ee6c28, 2px 1px 0 #ee6c28, -2px 1px 0 #ee6c28, 2px -1px 0 #ee6c28, -2px -1px 0 #ee6c28;
        }
        .progress-bar{
            background-color: #FFC700;
        }
        .progress {
            height: 12px;
            border-radius: 1.25rem;
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

        .card-area .main-card .last-review-area h5 {
            font-size: 25px;
            color: black;
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
                margin-top: 65%;
            }
        }

        @media (max-width:992px) {
            .card-area .main-card .left-side .tyre {
                margin-top: 130%;
            }
        }

        @media (max-width:767px) {
            .card-area .main-card .left-side .tyre {
                margin-top: 0%;
            }
        }

        @media (max-width:480px) {
            .card-area .main-card .left-side .tyre {
                margin-bottom: 10%;
            }
            .card-area .main-card .left-side .tyre img {
                width: 50%;
            }
        }
    </style>
    <section class="pt-4 mb-4 bg-white">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Browse History')}}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home')}}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('browse.history') }}">
                                "{{ translate('Browse History') }}"
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container card-area">
            @foreach($histories as $history)
                <?php
                $product = \App\Models\Product::where('id', $history->product_id)->first();
                if (!$product)
                    continue;
                ?>
            <div class="row main-card mt-5">
                <div class="col-md-2 left-side">
                    <div class="row sun">
                        <div class="col-md-12">
                            <i class="fa-solid fa-sun"></i>
                        </div>
                    </div>
                    <div class="row tyre">
                        <div class="col-md-12 mt-5" style="text-align: center;">
                            <a href="{{ route('product', $product->slug) }}">
                                <img class="lazyload"
                                 src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                 data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                 alt="{{  $product->getTranslation('name')  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" width="100%">
                            </a>
                        </div>
                    </div>
{{--                    <div class="row check-box-area">--}}
{{--                        <div class="col-md-12" style="text-align: center; position: absolute; bottom: 20px;">--}}
{{--                            <input type="checkbox" id="check1">--}}
{{--                            <label for="">Compare</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div id="triangle-topleft"></div>
                    <h5 style="transform: rotate(-45deg); position: absolute; top: -10px; left: 5px; color: white; line-height: 3; font-size: 16px;"><i class="fa-solid fa-star"></i></h5>
                    <h5 style="transform: rotate(-45deg); position: absolute; top: 6px; left: 21px; color: white; line-height: 3;">DH</h5>
                    <h5 style="transform: rotate(-45deg); position: absolute; top: 20px; left: -15px; color: white; line-height: 3;">Recommends</h5>
                </div>
                <div class="col-md-10 right-side py-2 px-4">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('product', $product->slug) }}"><h3>{{  $product->getTranslation('name')  }}</h3></a>
{{--                            <h5>Pilot Sport 4</h5>--}}
                            <h5 style="font-weight: normal;">{{$product->tyre_size}}</h5>
{{--                            <h5 class="border-label"><i class="fa-solid fa-gas-pump"></i>&nbsp;D | <i class="fa-solid fa-cloud-rain"></i>&nbsp;A | <i class="fa-solid fa-volume-high"></i>&nbsp;B 70dB</h5>--}}

                        </div>
                        <div class="col-6">
                            <h4 class="free-delivery-text">
                                <a class="ml-3 mt-1" style="float:right;color:#016BC1" href="{{ route('browse.history.delete', $product->id) }}" data-toggle="tooltip" data-title="{{ translate('Remove') }}" data-placement="left">
                                    <i class="las la-trash"></i>
                                </a>
                                <span>Free delivery</span>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-6"></div>
                        <div class="col-lg-2 col-md-3 col-6 left-side2 mt-3">
                            <p>Availability:</p>
                            @php
                                $product_current_qty = 0;
                                $purchased_qty = 0;
                                $percent_value = 0;
                                foreach ($product->stocks as $key => $stock) {
                                    $product_current_qty += $stock->qty;
                                }
                                $purchased_qty += \DB::table('order_details')->where('product_id',$product->id)->sum('quantity');
                                $total_qty = $product_current_qty+$purchased_qty;
                                if($total_qty > 0){
                                  $percent_value = ($product_current_qty * 100) / $total_qty;
                                }
                            @endphp
                            <div class="progress" style="width: 70%;">
                                <div class="progress-bar" role="progressbar" style="width: {{$percent_value}}%" aria-valuenow="{{$percent_value}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-6 right-side2">
                            <h3 style="color: black;">{{ home_discounted_base_price($product) }}</h3>
                                @if(home_base_price($product) != home_discounted_base_price($product))
                                <p><del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del></p>
                                @endif
                            <button class="btn" onclick="showAddToCartModal({{ $product->id }})">{{ translate('Add to cart') }}</button>
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
                                    $fstar = \App\Models\Review::where('rating', 5)->where('product_id', $product->id)->get();
                                    $fostar = \App\Models\Review::where('rating', 4)->where('product_id', $product->id)->get();
                                    $tstar = \App\Models\Review::where('rating', 3)->where('product_id', $product->id)->get();
                                    $twstar = \App\Models\Review::where('rating', 2)->where('product_id', $product->id)->get();
                                    $ostar = \App\Models\Review::where('rating', 1)->where('product_id', $product->id)->get();

                                    $sum_fstar = \App\Models\Review::where('rating', 5)->where('product_id', $product->id)->sum('rating');
                                    $sum_fostar = \App\Models\Review::where('rating', 4)->where('product_id', $product->id)->sum('rating');
                                    $sum_tstar = \App\Models\Review::where('rating', 3)->where('product_id', $product->id)->sum('rating');
                                    $sum_twstar = \App\Models\Review::where('rating', 2)->where('product_id', $product->id)->sum('rating');
                                    $sum_ostar = \App\Models\Review::where('rating', 1)->where('product_id', $product->id)->sum('rating');

                                    $total_rating_count = count($fstar)+count($fostar)+count($tstar)+count($twstar)+count($ostar);
                                    $total_rating = $sum_fstar+$sum_fostar+$sum_tstar+$sum_twstar+$sum_ostar;
                                    ?>
                                    @if(isset($total_rating_count) && isset($total_rating) && $total_rating_count > 0 && $total_rating > 0)
                                        {{ number_format($total_rating/$total_rating_count, 1) }}
                                    @else
                                        0.0
                                    @endif
                                </h5>
                                <div class="rate ml-2 mt-1">
                                    @if(isset($product->rating))
                                        @php
                                            $total += $product->reviews->count();
                                        @endphp
                                        <div class="rate rating">
                                            @for ($i=0; $i < $product->rating; $i++)
                                                <i class="las la-star active"></i>
                                            @endfor
                                            @for ($i=0; $i < 5-$product->rating; $i++)
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
        </div>
    </section>
@endsection
