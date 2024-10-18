@extends('frontend.layouts.app')
@section('meta_title'){{ $detailedProduct->meta_title }}@stop
@section('meta_description'){{ $detailedProduct->meta_description }}@stop
@section('meta_keywords'){{ $detailedProduct->tags }}@stop
@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator"
        content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    <!-- owl-carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!-- /owl-carousel -->
    <style>
        div.product-gallery-thumb>.slick-list>.slick-track{
            height: unset !important;
        }
        div.aiz-carousel>.slick-list{
            height: unset !important;
        }
        .popup-youtube{
            font-size: 1rem !important;
            text-decoration: none !important;
        }
        div.product-gallery-thumb>.slick-list>.slick-track>.slick-slide{
            width: 80px !important;
        }
        .active-unsold {
            color: gray !important;
        }
    </style>
    <style>
        html,
        body {
            overflow-x: hidden;
        }
            /* Second Code */
        .img-zoom{
            width: 334px !important;
        }
        .user-hed h1 {
            font-weight: bold;
        }
        .progress-bar{
            background-color: #FFC700 !important;
        }
        .custom-progress {
            height: 12px !important;
            border-radius: 1.25rem !important;
            display: flex;
            overflow: hidden;
            width: 200px;
            color: grey;
            position: relative;
            background: white;
            text-align: center;
            line-height: 200px;
        }
        .rated-sec {
            border-right: 1px solid grey;
        }

        .rated-sec h6 {
            text-align: center;
        }

        .progress-sec h6 {
            text-align: center;
            color: grey;
        }
        .progress-sec strong {
            color: black;
        }
        .miles-line {
            background-color: lightgray;
        }

        .miles-line h6 {
            text-align: center;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .popup-youtube{
            color:white !important;
            background-color: #F37539 !important;
            border-color: #F37539 !important;
        }
        .popup-youtube:hover{
            color:white !important;
            background-color: #F37539 !important;
            border-color: #F37539 !important;
        }
        .miles-line span {
            color: #F37539;
            font-weight: bold;
        }

        .miles-content p {
            color: black;
        }

        .miles-content span {
            color: #F37539;
            font-weight: bold;
        }

        .count-li ul li {
            list-style-type: none;
            font-weight: bold;
        }

        .people-rating ul li {
            color: lightgray;
            list-style-type: none;
        }

        .people-rating ul li span {
            color: black;
            font-weight: 600;
        }

        .like,
        .dislike {
            display: inline-block;
            margin-bottom: 0;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background: #F37539;
            color: white!important;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.428571429;
            border-radius: 4px;
        }

        .qty1,
        .qty2 {
            border: none;
            width: 30px;
            background: transparent;
            color: white;
            cursor: pointer;
            border: none;
        }

        .rate {
            float: left;
            height: 23px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 20px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .summary-sec {
            border-right: 1px solid grey;
            text-align: center;
        }

        .summary-sec p {
            font-size: 14px;
            font-weight: bold;
        }

        .summary-sec p span {
            font-size: 35px;
        }

        .summary-sec h3 {
            font-weight: bold;
            color: #F37539;
            font-size: 19px;
        }
        /*//////////////////////////////////// product detail //////////////////////////////// */
        /* /////////////////////////////////////////media query ///////////////////////////////////////// */

        @media (max-width:825px) {
            .promotiom .card p span {
                float: none;
            }
            .btn-donate {
                margin-top: 197px;
                margin-left: -23px;
            }
        }

        @media (max-width:768px) {
            .carousel-item img {
                height: auto;
            }
            .promotiom .card p span {
                float: none;
            }
        }

        @media (max-width:767px) {
            .promotiom .card p span {
                float: right;
            }
            .btn-donate {
                margin-top: 50px;
                margin-left: 20px;
            }
        }
        /* /Second Code */

        .top-banner {
            background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, rgba(205, 205, 205, 1) 100%);
            padding: 3% 0;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        .top-banner h1 {
            color: #F37539;
            font-weight: 700;
        }

        .main-card-area .right-area {
            text-align: center;
        }

        .main-card-area .right-area p {
            font-size: 10pt;
            color: #666;
        }

        .main-card-area .right-area strong {
            color: black;
            font-size: 100%;
        }

        .main-card-area .right-area .btn-primary {
            padding: 2% 8%;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 3%;
            background-color: #F37539;
            border-color: #F37539;
        }

        .main-card-area .right-area a {
            font-weight: bold;
            font-size: 15px;
            text-decoration: underline;
            color: #F37539;
        }

        .main-card-area .right-area a:hover {
            color: #F37539;
        }

        .main-card-area .right-area .img-area {
            display: flex;
            justify-content: center;
            padding-top: 10%;
        }

        .main-card-area .right-area .img-area h2 {
            font-size: 40px;
            font-weight: bold;
            margin-top: 49%;
            float: right;
        }

        .main-card-area .right-area .downarea {
            margin-top: 25%;
        }

        .main-card-area .right-area .downarea a {
            float: left;
            font-size: 16px;
            font-weight: 500;
        }

        .main-card-area .right-area .downarea .label {
            display: flex;
            flex-wrap: wrap;
        }

        .main-card-area .right-area .downarea .label span {
            color: black;
            border: 1px solid gray;
            padding: 2% 5%;
            font-size: 16px;
            font-weight: bold;
        }

        .main-card-area .left-area {
            background-color: lightgrey;
            position: relative;
        }

        .main-card-area .left-area h2 {
            color: #269429;
            font-weight: 700;
            margin-bottom: 9%;
            margin-top: 4%;
            font-size: 17px;
        }

        .main-card-area .left-area .availability-area {
            font-size: 25px;
            font-weight: bold;
        }
        .main-card-area .left-area .quantity-area select {
            width: 50%;
            height: 50px;
            border-radius: 5px;
            margin-top: 2%;
        }

        .main-card-area .left-area .quantity-area button {
            background: #F37539;
            border-color: #F37539;
            font-size: 13px;
            color: white;
            border: none;
            border-radius: 18px;
            cursor: pointer;
        }

        .main-card-area .right-area .downarea .rate {
            float: left;
            height: 24px;
            padding: 0 4px;
        }

        .main-card-area .right-area .downarea .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .main-card-area .right-area .downarea .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .main-card-area .right-area .downarea .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .main-card-area .right-area .downarea .rate>input:checked~label {
            color: #ffc700;
        }

        .main-card-area .right-area .downarea .rate:not(:checked)>label:hover,
        .main-card-area .right-area .downarea .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .main-card-area .right-area .downarea .rate>input:checked+label:hover,
        .main-card-area .right-area .downarea .rate>input:checked+label:hover~label,
        .main-card-area .right-area .downarea .rate>input:checked~label:hover,
        .main-card-area .right-area .downarea .rate>input:checked~label:hover~label,
        .main-card-area .right-area .downarea .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .last-area h3 {
            color: #F37539;
            text-align: center;
        }
        /* ========= Media Query ============ */
        /* Mobile */
        @media only screen and (min-width: 320px) and (max-width: 480px) {
            .top-banner h1 {
                font-size: 16px;
                text-align: center;
            }
            }
            .main-card-area .right-area p {
                font-size: 16px;
            }
            .main-card-area .right-area .downarea {
                padding: 0 5%;
            }
            .main-card-area .left-area .quantity-area .btn-col {
                text-align: center;
            }
            .main-card-area .left-area .availability-area .price-col {
                text-align: center;
            }
            .rate {
                margin-left: 35%;
            }
            .main-card-area .right-area .downarea .rate {
                margin-left: 0px;
            }
            .people-rating {
                margin-left: 35%;
                margin-top: 5%!important;
            }
            .hundred-user {
                text-align: center;
            }
            .sec-headings {
                text-align: center;
            }
        }
        /* Ipad */

        @media only screen and (min-width: 481px) and (max-width: 768px) {
            .top-banner h1 {
                font-size: 24px;
                text-align: center;
            }
            .main-card-area .right-area p {
                font-size: 16px;
            }
            .main-card-area .right-area strong {
                font-size: 18px;
            }
            .main-card-area .right-area .downarea {
                margin-left: 27%;
            }
            .main-card-area .right-area .img-area h2 {
                font-size: 40px;
            }
            .main-card-area .right-area .downarea a {
                font-size: 16px;
            }
            .main-card-area .left-area .quantity-area button {
                margin-top: 11%;
            }
            .main-card-area .left-area .quantity-area .btn-col {
                text-align: center;
            }
            .main-card-area .left-area .availability-area .price-col {
                text-align: center;
            }
            .rate {
                margin-left: 25%;
            }
            .main-card-area .right-area .downarea .rate {
                margin-left: 0px;
            }
            .people-rating {
                margin-left: 25%;
                margin-top: 5%;
            }
        }
        /* Small Laptop */

        @media only screen and (min-width: 769px) and (max-width: 1024px) {
            .top-banner h1 {
                font-size: 33px;
                text-align: center;
            }
            .main-card-area .right-area p {
                font-size: 16px;
            }
            .main-card-area .right-area strong {
                font-size: 18px;
            }
            .main-card-area .right-area .img-area h2 {
                font-size: 40px;
            }
            .main-card-area .left-area .quantity-area button {
                margin-top: 28%;
            }
            .main-card-area .right-area .downarea .rate {
                width: 125%;
            }
            .summary-sec p {
                font-size: 14px;
                font-weight: bold;
            }
            .main-card-area .left-area .fa-van-shuttle {
                margin-left: 10%;
            }
        }
        /* Desktop */

        @media only screen and (min-width: 1025px) and (max-width: 1200px) {
            .top-banner h1 {
                font-size: 39px;
                text-align: center;
            }
            .main-card-area .right-area p {
                font-size: 16px;
            }
            .main-card-area .right-area .img-area h2 {
                font-size: 40px;
            }
        }
        /* TV */

        @media only screen and (min-width: 1201px) {
            .top-banner h1 {
                font-size: 39px;
                text-align: center;
            }
        }
        #triangle-topleft {
            width: 0;
            height: 0;
            border-top: 121px solid #f37539;
            border-right: 118px solid transparent;
            position: absolute;
            top: 0px;
            left: 0px;
        }
        .details-tab .nav-item a{
            color: #f37539;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <?php
    $coupon = \App\Coupon::whereJsonContains('product_ids', json_encode($detailedProduct->id))
        ->orderBy('id', 'desc')
        ->first();
    $flash_deal_product = \App\Models\DealProduct::where('product_id', $detailedProduct->id)->first();
    if ($flash_deal_product) {
        $flash_deal = \App\Models\Deal::where('id', $flash_deal_product->deal_id)->first();
    }
    ?>
    <?php
    $fstar = \App\Review::where('rating', 5)
        ->where('product_id', $detailedProduct->id)
        ->get();
    $fostar = \App\Review::where('rating', 4)
        ->where('product_id', $detailedProduct->id)
        ->get();
    $tstar = \App\Review::where('rating', 3)
        ->where('product_id', $detailedProduct->id)
        ->get();
    $twstar = \App\Review::where('rating', 2)
        ->where('product_id', $detailedProduct->id)
        ->get();
    $ostar = \App\Review::where('rating', 1)
        ->where('product_id', $detailedProduct->id)
        ->get();
    
    $sum_fstar = \App\Review::where('rating', 5)
        ->where('product_id', $detailedProduct->id)
        ->sum('rating');
    $sum_fostar = \App\Review::where('rating', 4)
        ->where('product_id', $detailedProduct->id)
        ->sum('rating');
    $sum_tstar = \App\Review::where('rating', 3)
        ->where('product_id', $detailedProduct->id)
        ->sum('rating');
    $sum_twstar = \App\Review::where('rating', 2)
        ->where('product_id', $detailedProduct->id)
        ->sum('rating');
    $sum_ostar = \App\Review::where('rating', 1)
        ->where('product_id', $detailedProduct->id)
        ->sum('rating');
    
    $total_ratings_products = \App\Review::where('product_id', $detailedProduct->id)->get();
    $total_ratings_cal = \App\Review::where('product_id', $detailedProduct->id)->sum('rating');
    
    if ($total_ratings_cal) {
        $rating_by_prod = round($total_ratings_cal / count($total_ratings_products));
    }
    
    if (count($total_ratings_products) > 0) {
        $total_rating_count = count($fstar) + count($fostar) + count($tstar) + count($twstar) + count($ostar);
        $total_rating = $sum_fstar + $sum_fostar + $sum_tstar + $sum_twstar + $sum_ostar;
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 top-banner" style="height: 122px;">
                <div class="container">
                    <div class="row">
                        <div id="triangle-topleft"></div>
                        <h5 style="transform: rotate(-45deg); position: absolute; top: -3px; left: 9px; color: white; line-height: 3; font-size: 16px;"><i class="fa-solid fa-star"></i></h5>
                        <h5 style="transform: rotate(-45deg); position: absolute; top: 6px; left: 19px; color: white; line-height: 3;">DH</h5>
                        <h5 style="transform: rotate(-45deg); position: absolute; top: 19px; left: -12px; color: white; line-height: 3;">Recommends</h5>
                        <div class="col-md-12">
                            <h3 class="ml-5 font-weight-bold product-detail-heading" style="color: black;font-size: 20px;">{{ $detailedProduct->getTranslation('name') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $photos = explode(',', $detailedProduct->photos);
        @endphp
        <div class="row main-card-area">
            <div class="col-lg-8 col-md-12 right-area">
                <div class="row">
                    <div class="col-md-6" style="padding-top: 5%; padding-bottom: 5%;">
{{--                        <button class="btn btn-primary">Compare</button><br> --}}
                        <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i>&nbsp;Back to <br> product list</a>
                        <div class="img-area mb-3">
                                    <div class="img-zoom rounded main_image">
                                        <img width="100%"
                                             class="lazyload"
                                             src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                             data-src="{{ uploaded_asset($detailedProduct->thumbnail_img) }}"
                                             onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                        >
                                    </div>
                            <h2>
                            @if (isset($total_rating_count) && isset($total_rating))
                            {{ number_format($total_rating / $total_rating_count, 1) }}
                            @else
                            0.0
                            @endif
                            </h2>
                        </div>
                         <div class="product_gallery_imagess mb-4">
                                <div class="carousel-box c-pointer custom p-1 remove orange">
                                <img
                                     class="lazyload mw-100 size-50px mx-auto gallery_image_click"
                                     src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                     data-src="{{ uploaded_asset($detailedProduct->thumbnail_img) }}"
                                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >
                                </div>
                                @foreach ($detailedProduct->stocks as $key => $stock)
                                    @if ($stock->image != null)
                                        <div class="carousel-box c-pointer custom p-1 remove">
                                            <img
                                                class="lazyload mw-100 size-50px mx-auto gallery_image_click"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($stock->image) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                        </div>
                                    @endif
                                @endforeach
                                @if (isset($detailedProduct->photos) && count($photos) > 0)
                                @foreach ($photos as $key => $photo)
                                    <div class="carousel-box c-pointer custom p-1 remove">
                                        <img
                                            class="lazyload mw-100 size-50px mx-auto gallery_image_click"
                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($photo) }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            <a class="btn btn-danger popup-youtube fw-600" href="{{ $detailedProduct->video_link }}"><i class="la la-youtube"></i>Play Video</a>
                        </div>
                    <?php
                    $featured_category = \App\FeaturedCategory::where('id', $detailedProduct->featured_cat_id)->first();
                    $featured_sub_category = \App\FeaturedSubCategory::where('id', $detailedProduct->featured_sub_cat_id)->first();
                    ?>
                    <div class="col-md-6" style="padding-top: 5%; padding-bottom: 5%;">
                        @if ($detailedProduct->category_id == 1)
                        <div class="row">
                            <div class="col-5" style="text-align: right;">
                                <p>Brand:</p>
                            </div>
                            <div class="col-7" style="text-align: left;">
                                <strong>
                                    @if ($featured_category)
                                        {{ $featured_category->name }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5" style="text-align: right;">
                                <p>Tyre Size:</p>
                            </div>
                            <div class="col-7" style="text-align: left;">
                                <p><strong>{{ $detailedProduct->tyre_size }}</strong></p>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Speed Index:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <p><strong>{{ $detailedProduct->speed_index }}</strong></p>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-5" style="text-align: right;">
                                <p>Load index:</p>
                            </div>
                            <div class="col-7" style="text-align: left;">
                                <p><strong>{{ $detailedProduct->load_index }}</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5" style="text-align: right;">
                                <p>Vehicle type:</p>
                            </div>
                            <div class="col-7" style="text-align: left;">
                                <strong>{{ $detailedProduct->vehicle_type }}</strong>
                            </div>
                        </div>
                        @elseif($detailedProduct->category_id == 3)
                            <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Brand:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <strong>
                                        @if ($featured_category)
                                            {{ $featured_category->name }}
                                        @endif
                                    </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Viscosity:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <p><strong>{{ $detailedProduct->viscosity }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Packaging:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <p><strong>{{ $detailedProduct->packaging }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Service Interval:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <p><strong>{{ $detailedProduct->service_interval }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5" style="text-align: right;">
                                    <p>Vehicle type:</p>
                                </div>
                                <div class="col-7" style="text-align: left;">
                                    <strong>{{ $detailedProduct->vehicle_type }}</strong>
                                </div>
                            </div>
                        @endif
                        <div class="row downarea">
                            <div class="col-lg-6 col-md-12" style="text-align: left;">
                                <p>Rating: <strong>Worth recommending</strong></p>
                                @if (isset($rating_by_prod))
                                            @php
                                                $total = 0;
                                                $total += $detailedProduct->reviews->count();
                                            @endphp
                                            <div class="rate rating">
                                                @for ($i = 0; $i < $rating_by_prod; $i++)
                                                    <i class="las la-star active"></i>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $rating_by_prod; $i++)
                                                    <i class="las la-star"></i>
                                                @endfor
                                            </div>
                                <br>
                                            <a class="ml-2" href="javascript:void(0)">{{ $total }} reviews</a>
                                @else
                                            <div class="rate">
                                                <i class="las la-star active active-unsold"></i>
                                                <i class="las la-star active active-unsold"></i>
                                                <i class="las la-star active active-unsold"></i>
                                                <i class="las la-star active active-unsold"></i>
                                                <i class="las la-star active active-unsold"></i>
                                            </div>
                                <br>
                                    <a class="ml-2" href="javascript:void(0)">0 reviews</a>
                                @endif
                            </div>

                            <div class="col-lg-6 col-md-12" style="text-align: left;">
                                @php
                                    $labels = $detailedProduct->label;
                                    $label_arr = [];
                                    if($labels){
                                     $label_arr = explode(',',$labels);
                                    }
                                @endphp
                                @if ($labels && count($label_arr) > 0)
                                <p style="color: black;">Label:</p>
                                <p class="label">
                                    @foreach ($label_arr as $arr)
                                    <span>{{ $arr }}</span>
                                    @endforeach
                                </p>
                                @endif
{{--                                <a href="" style="float: none;">More Information</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 left-area" style="padding: 3% 0;">
                <div class="row">
                    <div class="col-4 ml-4">
                        <i class="fa-solid fa-van-shuttle" style="font-size: 65px; color: #308C31;"></i>
                    </div>
                    <div class="col-7">
                        <h2>Free delivery</h2>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-4 ml-4">
                        <i class="fa-solid fa-clock" style="font-size: 65px; color: #308C31; margin-top: 7%;"></i>
                    </div>
                    <div class="col-7">
                        <h6>Delivery time:</h6>
                        <h2 style="text-align: left;">Express&nbsp;&nbsp;<i class="fa-solid fa-van-shuttle" style="font-size: 30px; color: #308C31; margin-left: 0px;"></i></h2>
                    </div>
                </div>
                <hr>
                <?php
                $date = date('F d Y', $detailedProduct->discount_start_date);
                $month = date('M', $detailedProduct->discount_start_date);
                $start_time = date('H:i A', $detailedProduct->discount_start_date);
                $end_time = date('H:i A', $detailedProduct->discount_end_date);
                ?>
                @if (strtotime(date('Y-m-d H:i:s', $detailedProduct->discount_end_date)) > strtotime(date('Y-m-d H:i:s')))
                    <div class="align-items-center mt-4" style="background: #0000ff82;padding: 8px;color: white;">
                        <!--<div class="col-sm-2">-->
                        <!--    <span class="fs-16"><span class="fw-800">{{ $month }}:</span> | {{ $date }}</span>-->
                        <!--</div>-->
                        <div class="col-sm-12">
                                        <span class="fs-15">
                                            Get this at {{ home_discounted_price($detailedProduct) }} from {{ $date }}-{{ $start_time }} to {{ date('F d Y', $detailedProduct->discount_end_date) }}-{{ $end_time }}!
                                        </span>
                        </div>
                    </div>
                    <hr>
                @endif
                <div class="row availability-area mt-4">
                    <div class="col-md-5 col-5 ml-4" style="display: flex; flex-direction: column">
                        <h6>Availability:</h6>
                        @php
                            $product_current_qty = 0;
                            $purchased_qty = 0;
                            $percent_value = 0;
                            foreach ($detailedProduct->stocks as $key => $stock) {
                                $product_current_qty += $stock->qty;
                            }
                            $purchased_qty += \DB::table('order_details')->where('product_id',$detailedProduct->id)->sum('quantity');
                            $total_qty = $product_current_qty+$purchased_qty;
                             if($total_qty > 0){
                                  $percent_value = ($product_current_qty * 100) / $total_qty;
                                }
                        @endphp
                        <div class="custom-progress" style="width: 53%;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent_value }}%" aria-valuenow="{{ $percent_value }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                    <div class="col-md-6 col-6 price-col" style="position: relative;text-align:center">
                        <span>
                                 @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
                                        <small><del class="fs-16">{{ home_price($detailedProduct) }}</del></small>
                                        <span style="font-size: 21px; color: #F37539;">{{ home_discounted_price($detailedProduct) }}</span>
                                        @if ($detailedProduct->discount_type == 'amount')
                                        <br>
                                         <small>Discount:&nbsp;&nbsp;{{ single_price($detailedProduct->discount) }}</small>
                                        @else
                                        <br>
                                        <small class="fs-16">Discount:&nbsp;&nbsp;</small><small style="background: #ed6422; padding: 4px;color: white;border-radius: 7px;">{{ $detailedProduct->discount }}% OFF</small>
                                        @endif
                                @else
                                <strong style="font-size: 22px; color: #ed6422 !important;">{{ home_discounted_price($detailedProduct) }}</strong>
                                @endif
                        </span>
                    </div>
                </div>
                @if (isset($flash_deal->end_date))
                <hr>
                    <div class="row mt-4">
                        <div class="col-sm-5 col-5 ml-4">
                            <h6>{{ translate('Shocking Sale') }}:</h6>
                        </div>
                        <div class="col-sm-6 col-6">
                                        <span class="">
                                            <div class="aiz-count-down ml-auto pb-15 ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                                        </span>
                        </div>
                    </div>
                    <hr>
                @endif
                <form id="option-choice-form">
                    @csrf
                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
                    @if (isset($coupon->limit) && $coupon->limit > 0)
                        @if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date)
                            <div class="row mt-4">
                                <div class="col-md-5 col-5 ml-4">
                                    <h6>{{ translate('Coupon') }} </h6>
                                </div>
                                <div class="col-md-6 col-6">
                                    <span class=" opacity-50" id="coupon_code_copy"> {{ $coupon->code }}</span>&nbsp;<span>-</span>
                                    @if ($coupon->discount_type == 'amount')
                                        <span style="color: #C82333">{{ single_price($coupon->discount) }}</span>
                                    @else
                                        <span style="color: #C82333">{{ $coupon->discount }}% </span>
                                    @endif
                                    <span style="color: #C82333"> ({{ $coupon->limit . 'qty' }})</span>
                                </div>
                            </div>
                            <hr>
                        @endif
                    @endif
                    @if ($detailedProduct->choice_options != null)
                        @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                            <div class="row mt-4 ml-4 no-gutters">
                                <div class="col-sm-2">
                                    <h6 class="mt-2">{{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</h6>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-radio-inline">
                                        @foreach ($choice->values as $key => $value)
                                            <label class="aiz-megabox pl-0 mr-2">
                                                <input
                                                    type="radio"
                                                    name="attribute_id_{{ $choice->attribute_id }}"
                                                    value="{{ $value }}"
                                                    @if ($key == 0) checked @endif
                                                >
                                                <span class="aiz-megabox-elem d-flex align-items-center justify-content-center py-2 px-3 mb-2 fs-14">
                                                        {{ $value }}
                                                    </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <hr>
                    @endif
                    @if ($detailedProduct->label_status == 1 ||
                        $detailedProduct->return_status == 1 ||
                        $detailedProduct->shipping_status == 1)
                        <div class="row align-items-center mt-4 ml-4">
                            <div class="col-md-3 col-sm-3">
                            </div>
                            @if ($detailedProduct->label_status == 1)
                                <div class="col-md-2 col-sm-2">
                                    <img class="lazyload" style="height: 50px;"
                                         src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                         data-src="{{ uploaded_asset($detailedProduct->label_img) }}"
                                         alt="{{ $detailedProduct->getTranslation('name') }}"
                                         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                            @endif
                            @if ($detailedProduct->return_status == 1)
                                <div class="col-md-2 col-sm-2">
                                    <img class="lazyload" style="height: 50px;"
                                         src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                         data-src="{{ uploaded_asset($detailedProduct->return_days_img) }}"
                                         alt="{{ $detailedProduct->getTranslation('name') }}"
                                         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                            @endif
                            @if ($detailedProduct->shipping_status == 1)
                                <div class="col-md-2 col-sm-2">
                                    <img class="lazyload" style="height: 50px;"
                                         src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                         data-src="{{ uploaded_asset($detailedProduct->shipping_img) }}"
                                         alt="{{ $detailedProduct->getTranslation('name') }}"
                                         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                            @endif
                        </div>
                    @endif
                <div class="row quantity-area mt-4">
                    <div class="col-md-6 col-7">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                 <h6 style="margin-left: 60px;">{{ translate('Quantity') }}</h6>
                                 <div class="no-gutters align-items-center aiz-plus-minus mr-3 ml-4">
                                                    <button class="btn-sm" type="button" data-type="minus" data-field="quantity" disabled="">
                                                        <i class="las la-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" class="text-center input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10" style="width: 70px;">
                                                    <button class="btn-sm" type="button" data-type="plus" data-field="quantity">
                                                        <i class="las la-plus"></i>
                                                    </button>
                                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12 col-12">
                                  @php
                                                    $qty = 0;
                                                    foreach ($detailedProduct->stocks as $key => $stock) {
                                                        $qty += $stock->qty;
                                                    }
                                                @endphp
                                                <div class="avialable-amount mt-2" style="margin-left: 48px;">
                                                    @if ($detailedProduct->stock_visibility_state == 'quantity')
                                                        (<span id="available-quantity">{{ $qty }}</span> {{ translate('available') }})
                                                    @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
                                                        (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                                    @endif
                                                </div>
                            </div>
                        </div>
                       

                                              
                                          </div>
                    <div class="col-md-6 col-5 d-none pl-lg-5 pl-md-5" id="chosen_price_div">
                                        <h6>{{ translate('Total Price') }}:</h6>
                                        <div class="product-price">
                                            <strong id="chosen_price" class="fs-20 fw-600" style="color: #f37539"></strong>
                                        </div>
                                    </div>
               </div>
                </form>
                <div class="row mt-4 justify-content-center">
                    <button type="button" class="btn btn-success mr-2 add-to-cart fw-600" onclick="addToCart()">
                        <i class="las la-shopping-bag"></i>
                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart') }}</span>
                    </button>
                    <button type="button" class="btn buy-now fw-600" style="background: #f37539;color:white" onclick="buyNow()">
                        <i class="la la-shopping-cart"></i> {{ translate('Buy Now') }}
                    </button>
                    <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none" disabled>
                        <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock') }}
                    </button>
                </div>
                 </div>
           </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs details-tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#description">{{ translate('Description') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#product_specification">{{ translate('Product Specification') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#reviews">{{ translate('Reviews') }}</a>
                    </li>
                    @if ($detailedProduct->term_conditions != null)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#terms">{{ translate('Term & Conditions') }}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane container active" id="description" style="margin-top: 50px;">
            <p style="color: #588080;">
                <?php echo $detailedProduct->getTranslation('description'); ?>
            </p>
        </div>
        <div class="tab-pane container fade" id="product_specification" style="margin-top: 50px;">
          @if ($detailedProduct->category_id == 1)
            <div class="row">
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Brand:</span> <span>
                                    @if ($featured_category)
                                {{ $featured_category->name }}
                            @endif
                        </span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Product:</span> <span>
                                    @if ($featured_sub_category)
                                {{ $featured_sub_category->name }}
                            @endif
                         </span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Tyre Size:</span> <span>
                                     {{ $detailedProduct->tyre_size }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Speed Index:</span> <span> {{ $detailedProduct->speed_index }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Load Index:</span> <span>{{ $detailedProduct->load_index }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Vehicle Type:</span> <span>{{ $detailedProduct->vehicle_type }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Product Of:</span> <span>{{ $detailedProduct->product_of }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Warranty Type:</span> <span>{{ $detailedProduct->warranty_type }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Warranty Period:</span> <span>{{ $detailedProduct->warranty_period }}</span>
                    </div>
                </div>
            </div>
        @elseif($detailedProduct->category_id == 3)
            <div class="row" style="padding: 20px;">
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Brand:</span> <span>
                                    @if ($featured_category)
                                {{ $featured_category->name }}
                            @endif
                        </span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Product:</span> <span>
                                    @if ($featured_sub_category)
                                {{ $featured_sub_category->name }}
                            @endif
                        </span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Viscosity:</span> <span>
                                     {{ $detailedProduct->viscosity }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Packaging:</span> <span> {{ $detailedProduct->packaging }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Service Interval:</span> <span>{{ $detailedProduct->service_interval }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Vehicle Type:</span> <span>{{ $detailedProduct->vehicle_type }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-1">
                        <span style="font-weight: 700">Product Of:</span> <span>{{ $detailedProduct->product_of }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Warranty Type:</span> <span>{{ $detailedProduct->warranty_type }}</span>
                    </div>
                    <div class="p-1">
                        <span style="font-weight: 700">Warranty Period:</span> <span>{{ $detailedProduct->warranty_period }}</span>
                    </div>
                </div>
            </div>
          @endif
            </div>
        <div class="tab-pane container fade" id="reviews" style="margin-top: 50px;">
            @if (count($detailedProduct->reviews) > 0)
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12 user-hed">
                        <h2 class="sec-headings font-weight-bold" style="font-size: 30px;">User Reviews</h2>
                        <hr>
                        <!--  -->
                        <style>
                            .progress {
                                width: 150px;
                                height: 150px;
                                background: none;
                                position: relative;
                            }
                            .progress::after {
                                content: "";
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                                border: 18px solid #eee;
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
                                border-width: 18px;
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
                        </style>
                        <div class="row">
                            <div class="col-md-4 col-12 summary-sec">
                                <p style="margin-bottom: 0px;">Summary: <span>
                                         @if (isset($total_rating_count) && isset($total_rating))
                                            {{ number_format($total_rating / $total_rating_count, 1) }}
                                         @else
                                            0.0
                                         @endif
                                    </span></p>
                                @if (isset($rating_by_prod))
                                    @php
                                        $total = 0;
                                        $total += $detailedProduct->reviews->count();
                                    @endphp
                                    <p style="color:#f3815a">{{ $total }} reviews</p>
                                @else
                                    <p style="color:#f3815a">0 reviews</p>
                                @endif
                                <h3>Worth Recommending</h3>
                                <div class="stars">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <p>Costs: <i class="fa-regular fa-circle-question"></i> </p>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            @if (isset($rating_by_prod))
                                                <div class="rate rating">
                                                    @for ($i = 0; $i < $rating_by_prod; $i++)
                                                        <i class="las la-star active"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $rating_by_prod; $i++)
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
                                                @if (isset($total_rating_count) && isset($total_rating))
                                                    {{ number_format($total_rating / $total_rating_count, 1) }}
                                                @else
                                                    0.0
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="stars">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <p>Comfort: <i class="fa-regular fa-circle-question"></i> </p>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            @if (isset($rating_by_prod))
                                                <div class="rate rating">
                                                    @for ($i = 0; $i < $rating_by_prod; $i++)
                                                        <i class="las la-star active"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $rating_by_prod; $i++)
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
                                                @if (isset($total_rating_count) && isset($total_rating))
                                                    {{ number_format($total_rating / $total_rating_count, 1) }}
                                                @else
                                                    0.0
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="stars">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <p>Drivability: <i class="fa-regular fa-circle-question"></i> </p>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            @if (isset($rating_by_prod))
                                                <div class="rate rating">
                                                    @for ($i = 0; $i < $rating_by_prod; $i++)
                                                        <i class="las la-star active"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $rating_by_prod; $i++)
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
                                                @if (isset($total_rating_count) && isset($total_rating))
                                                    {{ number_format($total_rating / $total_rating_count, 1) }}
                                                @else
                                                    0.0
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 rated-sec">
                                <h6><strong>
                                        @if (isset($rating_by_prod))
                                        @php
                                            $total = 0;
                                            $total += $detailedProduct->reviews->count();
                                        @endphp
                                        {{ $total }}
                                        @else
                                        0
                                        @endif
                                    </strong> customers have rated <br> this product</h6>
                                <div class="row mt-5">
                                    <div class="col-lg-6 col-6 mt-1" style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
                                        <div class="stars">
                                                <span class="rating rating-sm tab-star">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fonti las la-star active"></i>
                                                    @endfor
                                                 </span>
                                        </div>
                                        <div class="stars">
                                           <span class="rating rating-sm tab-star">
                                               @for ($i = 0; $i < 4; $i++)
                                                   <i class="fonti las la-star active"></i>
                                               @endfor
                                               @for ($i = 0; $i < 1; $i++)
                                                   <i class="fonti las la-star"></i>
                                               @endfor
                                           </span>
                                        </div>
                                        <div class="stars">
                                            <span class="rating rating-sm tab-star">
                                                @for ($i = 0; $i < 3; $i++)
                                                    <i class="fonti las la-star active"></i>
                                                @endfor
                                                @for ($i = 0; $i < 2; $i++)
                                                    <i class="fonti las la-star"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <div class="stars">
                                            <span class="rating rating-sm tab-star">
                                                @for ($i = 0; $i < 2; $i++)
                                                    <i class="fonti las la-star active"></i>
                                                @endfor
                                                @for ($i = 0; $i < 3; $i++)
                                                    <i class="fonti las la-star"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <div class="stars">
                                              <span class="rating rating-sm tab-star">
                                                  @for ($i = 0; $i < 1; $i++)
                                                      <i class="fonti las la-star active"></i>
                                                  @endfor
                                                  @for ($i = 0; $i < 4; $i++)
                                                      <i class="fonti las la-star"></i>
                                                  @endfor
                                              </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6  people-rating mt-1">
                                        <ul style="padding-left: 0px">
                                            <li><span>{{ count($fstar) }}</span>&nbsp; people</li>
                                            <li><span>{{ count($fostar) }}</span>&nbsp; people</li>
                                            <li><span>{{ count($tstar) }}</span>&nbsp; people</li>
                                            <li><span>{{ count($twstar) }}</span>&nbsp; people</li>
                                            <li><span>{{ count($ostar) }}</span>&nbsp; people</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @php
                                if(isset($total_rating_count) && isset($total_rating))
                                    {
                                    $percent_rating = ($total_rating/($total_rating_count*5)) * 100;
                                    }
                                else{
                                    $percent_rating = 0;
                                }
                            @endphp
                            <div class="col-md-4 col-12 progress-sec">
                                <h6 class="hundred-user"><strong>{{ $percent_rating }}%</strong> of user recomended <br> this product</h6>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <div class="progress mx-auto mt-4" data-value='{{ $percent_rating }}'>
                                         <span class="progress-left">
                                           <span class="progress-bar" style="background-color: transparent !important;border-color: #FBD25D"></span>
                                         </span>
                                            <span class="progress-right">
                                             <span class="progress-bar" style="background-color: transparent !important;border-color: #FBD25D"></span>
                                            </span>
                                            <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                <div class="h2 font-weight-bold">{{ $percent_rating }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>
            <br>
            <!-- reviews -->
            <div class="container-fluid mb-5">
                <div class="row">
                    <div class="col-12">
                        <h2 class="sec-headings font-weight-bold" style="font-size: 22px;">Latest Reviews:
                                <form action="" method="get" id="rating_form" style="float: right">
                                    <select name="rating_filter" id="rating_filter" class="form-control" onchange="rate_by()">
                                        <option value="">Filter By Ratings</option>
                                        <option value="">Filter All</option>
                                        <option value="5" {{ isset($_GET['rating_filter']) && $_GET['rating_filter'] == 5 ? 'selected' : '' }}>5 Star Rating</option>
                                        <option value="4" {{ isset($_GET['rating_filter']) && $_GET['rating_filter'] == 4 ? 'selected' : '' }}>4 Star Rating</option>
                                        <option value="3" {{ isset($_GET['rating_filter']) && $_GET['rating_filter'] == 3 ? 'selected' : '' }}>3 Star Rating</option>
                                        <option value="2" {{ isset($_GET['rating_filter']) && $_GET['rating_filter'] == 2 ? 'selected' : '' }}>2 Star Rating</option>
                                        <option value="1" {{ isset($_GET['rating_filter']) && $_GET['rating_filter'] == 1 ? 'selected' : '' }}>1 Star Rating</option>
                                    </select>
                                </form>
                        </h2>
                    </div>
                </div>
                <?php
                if (isset($_GET['rating_filter']) && !empty($_GET['rating_filter'])) {
                    $prod_reviews = $detailedProduct->reviews->where('rating', $_GET['rating_filter']);
                } else {
                    $prod_reviews = $detailedProduct->reviews;
                }
                ?>
                @if (count($prod_reviews) > 0)
                    @foreach ($prod_reviews as $key => $review)
                        @if ($review->user != null)
                <div class="row mt-5">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <h6>
                            <span class="avatar avatar-sm mr-3" style="display: inline-block">
                            <img
                                class="lazyload"
                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                @if ($review->user->avatar_original != null)
                                data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                @else
                                data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    @endif
                            >
                            </span>
                            <span>{{ $review->user->name }}</span>
                        </h6>
                        <p>Rating: <strong>{{ number_format($review->rating, 1) }} </strong>
                        <span class="rating rating-sm" style="float: none">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="las la-star active"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $review->rating; $i++)
                                    <i class="las la-star"></i>
                                @endfor
                        </span>
                        </p>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $review->comment }}</p>
                        <p><strong>Is this review helpfull?</strong></p>
                        <a class="like"><i class="fa fa-thumbs-o-up"></i>
                            <input class="qty1" name="qty1" readonly="readonly" type="text" value="0" />
                        </a>
                        <a class="like"><i class="fa fa-thumbs-o-down"></i>
                            <input class="qty1" name="qty1" readonly="readonly" type="text" value="0" />
                        </a>
                    </div>
                </div>
                 @if (!$loop->last)
                 <hr>
                 @endif
                 @endif
                 @endforeach
                 @else
                    <b class="text-center"><p class="mt-4">Not found!</p></b>
                 @endif
                @if (Auth::check())
                    @php
                        $commentable = false;
                    @endphp
                    @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                        @if ($orderDetail->order != null &&
                            $orderDetail->order->user_id == Auth::user()->id &&
                            \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                            @php
                                $commentable = true;
                            @endphp
                        @endif
                    @endforeach
                @endif
            </div>
            @else
                <div class="text-center fs-18 opacity-70">
                {{ translate('There has been no reviews for this product yet.') }}
                </div>
            @endif
        </div>
        <div class="tab-pane container fade" id="terms" style="margin-top: 50px;">
            <div class="text-center">
                {!! $detailedProduct->term_conditions !!}
            </div>
        </div>
    </div>
    <div class="container-fluid promotiom mb-5 mt-5">
        <div class="bg-white shadow-sm card-r">
            <div class="border-bottom p-3">
             <h3 class="main-hed">{{ translate('Related products') }}</h3>
            </div>
                <div class="owl-carousel owl-theme mt-3 products_caresoul_owl">
                    @foreach (filter_products(\App\Product::where('category_id', $detailedProduct->category_id)->where('id', '!=', $detailedProduct->id))->where('size_category_id', $detailedProduct->size_category_id)->limit(10)->get() as $key => $related_product)
                            <div class="item">
                            @if ($loop->iteration % 2 == 0)
                                <div class="card">
                                        <a href="{{ route('product', $related_product->slug) }}">
                                            <img class="card-img-top lazyload"
                                             src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                             data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                             alt="{{ $related_product->getTranslation('name') }}"
                                             onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                    <div class="card-body mt-1">
                                        <div class="row">
                                            <div class="col-md-12 cart_div">
                                                <button type="button" class="btn btn-light">New</button>
                                                <a href="javascript:void(0)" onclick="showAddToCartModal({{ $related_product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                    <i class="las fa-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <h6 class="card-subtitle mb-2"><a href="{{ route('product', $related_product->slug) }}">{{ $related_product->getTranslation('name') }}</a></h6>
                                        <fieldset class="rating">
                                            {{ renderStarRating($related_product->rating) }}
                                        </fieldset>
                                        <br>
                                        <br>
                                        <p>{{ home_discounted_base_price($related_product) }}
                                            @if (home_base_price($related_product) != home_discounted_base_price($related_product))
                                                <span>
                                                <del>{{ home_base_price($related_product) }}</del>
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                             <div class="card" style="background-color: #F2A53F;">
                                 <a href="{{ route('product', $related_product->slug) }}">
                                     <img class="card-img-top lazyload"
                                                 src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                 data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                                 alt="{{ $related_product->getTranslation('name') }}"
                                                 onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                 </a>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 cart_div">
                                            <button type="button" class="btn btn-light">New</button>
                                            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $related_product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                <i class="las fa-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <h6 class="card-subtitle mb-2"><a href="{{ route('product', $related_product->slug) }}">{{ $related_product->getTranslation('name') }}</a></h6>
                                    <fieldset class="rating">
                                        {{ renderStarRating($related_product->rating) }}
                                    </fieldset>
                                    <br>
                                    <br>
                                    <p>{{ home_discounted_base_price($related_product) }}
                                        @if (home_base_price($related_product) != home_discounted_base_price($related_product))
                                            <span>
                                    <del>{{ home_base_price($related_product) }}</del>
                                    </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                        </div>
                        @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('google_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="product_id" id="product_id" value="{{ $detailedProduct->id }}">
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
        }
        function show_chat_modal(){
            @if (Auth::check())
            $('#chat_modal').modal('show');
            @else
            $('#login_modal').modal('show'); @endif
        }
    </script>
    <script>
        function showAlert() {
            AIZ.plugins.notify('danger', '{{ translate('Please Login First!') }}');
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <script>
        $(function() {
            $('.popup-youtube, .popup-vimeo').magnificPopup({
                // disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        });
    </script>
    <script>
        function myVariants(value) {
            var my_variant = $('#my_variant' + value).val();
            var variant = $('#variant').val(my_variant);
        }
    </script>
    <script>
        const span = document.querySelector("#coupon_code_copy");
        span.onclick = function() {
            document.execCommand("copy");
        }
        span.addEventListener("copy", function(event) {
            event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData("text/plain", span.textContent);
                console.log(event.clipboardData.getData("text"));
                AIZ.plugins.notify('success', '{{ translate('Copied Successfully!') }}');
            }
        });
    </script>
    <script>
        function rate_by() {
            $('#rating_form').submit();
        }
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
    </script>
    <script>
        $('.product_gallery_imagess').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 3,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }]
        });
    </script>
    <!-- owl-carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.products_caresoul_owl').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            smartSpeed: 900,
            navText: ['<div class="nav-btn prev-slide"><i class="las la-angle-left"></i></div>',
                '<div class="nav-btn next-slide"><i class="las la-angle-right"></i></div>'
            ],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
    </script>
@endsection
