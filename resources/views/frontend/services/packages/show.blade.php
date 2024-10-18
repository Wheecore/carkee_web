@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </section>
    <div id="section_featured">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Package Products</span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow slick-initialized slick-slider"
                         data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2"
                         data-xs-items="2" data-arrows="true">
                        <div class="slick-list draggable">
                            <div class="slick-track"
                                 style="opacity: 1; width: 848px; transform: translate3d(0px, 0px, 0px);">
                                @if($array != null)
@foreach($array as $key=>$item)
@if ($item != "on")
                                    <?php
//                                      $prod_id = $product;

                                    $product = DB::table('products')->where('id', $item)->first();
//                                    dd($product->slug);
                                    $stock = DB::table('product_stocks')->where('product_id', $item)->first(); ?>
                                <div class="slick-slide slick-active" data-slick-index="1" aria-hidden="false"
                                     style="width: 224px;">
                                    <div>
                                        <div class="carousel-box" style="width: 100%; display: inline-block;">
                                            <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                                <div class="position-relative">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                    <img
                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    alt=""
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                    </a>

                                                </div>
                                                <div class="p-md-3 p-2 text-left">
                                                    <div class="fs-15">
                                                        <span class="fw-700 text-primary">${{ $stock->price }}</span>
                                                    </div>
                                                    <div class="rating rating-sm mt-1">
                                                        <i class="las la-star"></i><i class="las la-star"></i><i
                                                                class="las la-star"></i><i class="las la-star"></i><i
                                                                class="las la-star"></i>
                                                    </div>
                                                    <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">
                                                        {{ $product->name }}
                                                    </a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
@endforeach

                                @else
                                    <h4 class="card-title">No data found!</h4>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    {{--<section class="pt-4 mb-4">--}}
    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-6 text-center text-lg-left">--}}
    {{--</div>--}}
    {{--<div class="col-lg-6">--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}
    {{--<div id="section_featured">--}}
    {{--<section class="mb-4">--}}
    {{--<div class="container">--}}
    {{--<div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">--}}
    {{--<div class="d-flex mb-3 align-items-baseline border-bottom">--}}
    {{--<h3 class="h5 fw-700 mb-0">--}}
    {{--<span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Package Products</span>--}}
    {{--</h3>--}}
    {{--</div>--}}
    {{--<div class="aiz-carousel gutters-10 half-outside-arrow slick-initialized slick-slider"--}}
    {{--data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2"--}}
    {{--data-xs-items="2" data-arrows="true">--}}
    {{--<div class="slick-list draggable">--}}
    {{--<div class="slick-track"--}}
    {{--style="opacity: 1; width: 848px; transform: translate3d(0px, 0px, 0px);">--}}
    {{--@foreach($products as $product)--}}

    {{--<?php--}}

    {{--$stock = DB::table('product_stocks')->where('product_id', $product->id)->first(); ?>--}}

    {{--<div>--}}
    {{--<div class="carousel-box" style="width: 100%; display: inline-block;">--}}
    {{--<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white" style="border-radius: 30px !important;">--}}
        {{--<div class="position-relative">--}}
            {{--<a href="{{ route('product', $product->slug) }}" class="d-block">--}}
                {{--<img--}}
                        {{--class="img-fit lazyload mx-auto h-140px h-md-210px"--}}
                        {{--src="{{ static_asset('assets/img/placeholder.jpg') }}"--}}
                        {{--data-src="{{ uploaded_asset($product->thumbnail_img) }}"--}}
                        {{--alt=""--}}
                        {{--onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"--}}
                {{-->--}}
            {{--</a>--}}

        {{--</div>--}}
        {{--<div class="p-md-3 p-2 text-left">--}}
            {{--<div class="fs-15">--}}
                {{--<span class="fw-700 text-primary">{{ $stock->price }}</span>--}}
            {{--</div>--}}
            {{--<div class="rating rating-sm mt-1">--}}
              {{--dd--}}
            {{--</div>--}}
            {{--<h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">--}}
                {{--<a href="{{ route('product', $product->slug) }}" class="d-block text-reset">as</a>--}}
            {{--</h3>--}}

        {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}
    {{--</div>--}}
@endsection
