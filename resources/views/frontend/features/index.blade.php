@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4 bg-white">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Promotion Products')}}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        {{--<li class="breadcrumb-item opacity-50">--}}
                            {{--<a class="text-reset" href="{{ route('home') }}">--}}
                                {{--{{ translate('Home')}}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="text-dark fw-600 breadcrumb-item">--}}
                            {{--<a class="text-reset" href="{{ route('flash-deals') }}">--}}
                                {{--Feature Products--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container">
            <div class="text-center my-4 text-black">
                {{--<h1 class="h2 fw-600">{{ $product->title }}</h1>--}}
                {{--<div class="aiz-count-down aiz-count-down-lg ml-3 align-items-center justify-content-center" data-date="{{ date('Y/m/d H:i:s', $product->end_date) }}"></div>--}}
            </div>
            <div class="row gutters-5 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                {{--<section class="mb-4">--}}
                {{--<div class="container">--}}
                {{--<div class="row row-cols-1 row-cols-lg-2 gutters-10">                           --}}
                @foreach($products as $product)
                    {{--<div class="col">--}}
                    {{--<div class="bg-white rounded shadow-sm mb-3">--}}
                    {{--<a href="{{ route('flash-deal-details', $single->slug) }}" class="d-block text-reset">--}}
                    {{--<img--}}
                    {{--src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"--}}
                    {{--data-src="{{ uploaded_asset($single->banner) }}"--}}
                    {{--alt="{{ $single->title }}"--}}
                    {{--class="img-fluid lazyload rounded">--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                            <div class="col mb-2">
                                <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                    <div class="position-relative">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img
                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    alt="{{  $product->getTranslation('name')  }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                        </a>
                                        <div class="absolute-top-right aiz-p-hov-icon">
                                            {{--<a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">--}}
                                            {{--<i class="la la-heart-o"></i>--}}
                                            {{--</a>--}}
                                            {{--<a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">--}}
                                            {{--<i class="las la-sync"></i>--}}
                                            {{--</a>--}}
                                            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                <i class="las la-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-md-3 p-2 text-left">
                                        <div class="fs-15">
                                            @if(home_base_price($product) != home_discounted_base_price($product))
                                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                            @endif
                                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                        </div>
                                        <div class="rating rating-sm mt-1">
                                            {{--{{ renderStarRating($product->rating) }}--}}
                                        </div>
                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset" style="font-size: 14px !important;">{{  $product->getTranslation('name')  }}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                @endforeach
<style>
nav{
    display: contents;
}
</style>
            </div>
              @if(count($products) > 0)
              <div style="text-align:center">
            @if(Auth::user())
            {{ $products->links() }}
             @else
                    <a href="{{ route('user.login') }}" class="btn btn-default">Next Page</a>
             @endif
              </div>
             @endif
        </div>
    </section>
@endsection
