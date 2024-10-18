@extends('frontend.layouts.app')
@section('content')
    <div class="container-fluid promotiom mt-5">
        <div class="row">
            <div class="col-md-12">
                <h4 class="main-hed">{{ $category_name }}</h4>
                <hr>
                <div class="row mt-5 promotion">
                    @if (count($products) > 0)
                        @foreach ($products as $key => $product)
                            <div class="col-lg-3 col-md-3 col-6">
                                @if ($loop->iteration % 2 == 0)
                                    <div class="card" style="width: 100%;">
                                        @if ($product->category_id == 1)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload" src="{{ static_asset('assets/img/tyre.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @elseif($product->category_id == 2)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/car-battery.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @elseif($product->category_id == 3)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/repairing-service.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @else
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        @endif
                                        <div class="card-body mt-1">
                                            <div class="row">
                                                <div class="col-md-12 cart_div">
                                                    <button type="button" class="btn btn-light">New</button>
                                                    <a href="javascript:void(0)"
                                                        onclick="showAddToCartModal({{ $product->id }})"
                                                        data-toggle="tooltip" data-title="{{ translate('Add to cart') }}"
                                                        data-placement="left">
                                                        <i class="las fa-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <h6 class="card-subtitle mb-2"><a
                                                    href="{{ route('product', $product->slug) }}">{{ $product->getTranslation('name') }}</a>
                                            </h6>
                                            <!-- ////////////////////stars//////////////////// -->
                                            <fieldset class="rating">
                                                {{ renderStarRating($product->rating) }}
                                            </fieldset>
                                            <!-- //////////////////////stars////////////////// -->
                                            <br>
                                            <br>
                                            <p>{{ home_discounted_base_price($product) }}
                                                @if (home_base_price($product) != home_discounted_base_price($product))
                                                    <span>
                                                        <del>{{ home_base_price($product) }}</del>
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="card" style="width: 100%;background-color: #F2A53F;">
                                        @if ($product->category_id == 1)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/tyre.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @elseif($product->category_id == 2)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/car-battery.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @elseif($product->category_id == 3)
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/repairing-service.png') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}">
                                        @else
                                            <img onclick="window.location='{{ route('product', $product->slug) }}'"
                                                class="card-img-top lazyload"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        @endif
                                        <div class="card-body mt-1">
                                            <div class="row">
                                                <div class="col-md-12 cart_div">
                                                    <button type="button" class="btn btn-light">New</button>
                                                    <a href="javascript:void(0)"
                                                        onclick="showAddToCartModal({{ $product->id }})"
                                                        data-toggle="tooltip" data-title="{{ translate('Add to cart') }}"
                                                        data-placement="left">
                                                        <i class="las fa-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <h6 class="card-subtitle mb-2"><a
                                                    href="{{ route('product', $product->slug) }}">{{ $product->getTranslation('name') }}</a>
                                            </h6>
                                            <!-- ////////////////////stars//////////////////// -->
                                            <fieldset class="rating">
                                                {{ renderStarRating($product->rating) }}
                                            </fieldset>
                                            <!-- //////////////////////stars////////////////// -->
                                            <br>
                                            <br>
                                            <p>{{ home_discounted_base_price($product) }}
                                                @if (home_base_price($product) != home_discounted_base_price($product))
                                                    <span>
                                                        <del>{{ home_base_price($product) }}</del>
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center">
                            <table class="table aiz-table footable footable-1 breakpoint-xl">
                                <tbody>
                                    <tr class="footable-empty">
                                        <td colspan="8">
                                            Nothing found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (count($products) >= 20)
            <div class="d-flex justify-content-center">
                {!! $products->links() !!}
            </div>
        @endif
    </div>

@endsection
