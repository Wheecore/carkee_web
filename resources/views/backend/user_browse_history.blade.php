@extends('backend.layouts.app')
@section('content')
<style>
    .main-card {
        padding: 10px !important;
        height: 232px;
    }

    .card-area .main-card {
        border-radius: 6px;
        box-shadow: 2px 2px 19px -8px #888888;
    }

    .product_img {
        width: 60px;
        height: 60px;
    }

    .brand_img {
        max-width: 100px;
        max-height: 50px;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 14px;
        width: 33.33%;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
    }
</style>
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">{{ translate('Browse History')}}</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="mb-4">
                    <div class="tab mb-3">
                        <button class="tablinks {{($type == 'service' || $type == null)?'active':''}}" onclick="opentab(event, 'service')">Service Products</button>
                        <button class="tablinks {{($type == 'tyre')?'active':''}}" onclick="opentab(event, 'tyre')">Tyre Products</button>
                        <button class="tablinks {{($type == 'battery')?'active':''}}" onclick="opentab(event, 'battery')">Battery Products</button>
                    </div>

                    <div id="service" class="tabcontent" @if($type == 'service' || $type == null) style="display: block" @endif>
                        <div class="card-area">
                        <div class="row">
                            @forelse($service_products as $product)
                            @php
                            $home_base_price = home_base_price($product);
                            $home_discounted_base_price = home_discounted_base_price($product);
                            @endphp
                            <div class="col-md-3 col-6">
                                <div class="card card-body main-card">
                                    <div class="text-center">
                                        <img class="lazyload product_img" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ $product->thumbnail_image }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" width="100%">
                                        <br>
                                        <img class="lazyload mt-1 brand_img" src="{{ static_asset('logo.png') }}" data-src="{{ api_asset($product->photo) }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('logo.png') }}';" width="100%">
                                    </div>
                                    <a href="javascript:void(0)" class="mt-1" style="color: black"><span class="fw-500">{{ $product->name  }}</span></a>
                                    <div class="row mt-3">
                                        <div class="col-8">
                                            @if ($home_base_price != $home_discounted_base_price)
                                            <del class="fw-600 opacity-50">{{ $home_base_price }}</del>
                                            @endif
                                            <h6 style="color: grey;">{{ $home_discounted_base_price }}</h6>
                                        </div>
                                        <div class="col-4">
                                            <span class="rate rating" style="margin-right: -4px">
                                                <i class="las la-star active"></i>
                                            </span>
                                            <span class="fw-700">{{ $product->rating }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="row pl-15px">
                                <div class="col-md-12">
                                    <span class="fs-14 font-weight-bold">{{ translate('Nothing found') }}...</span>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <br>
                        <div class="text-center">
                            {{ $service_products->appends(['type' => 'service'])->links() }}
                        </div>
                    </div>
                    </div>

                    <div id="tyre" class="tabcontent" @if($type == 'tyre') style="display: block" @endif>
                        <div class="card-area">
                        <div class="row">
                            @forelse($tyre_products as $product)
                            @php
                            $home_base_price = home_base_price($product);
                            $home_discounted_base_price = home_discounted_base_price($product);
                            @endphp
                            <div class="col-md-3 col-6">
                                <div class="card card-body main-card">
                                    <div class="text-center">
                                        <img class="lazyload product_img" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ $product->thumbnail_image }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" width="100%">
                                        <br>
                                        <img class="lazyload mt-1 brand_img" src="{{ static_asset('logo.png') }}" data-src="{{ api_asset($product->photo) }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('logo.png') }}';" width="100%">
                                    </div>
                                    <a href="javascript:void(0)" class="mt-1" style="color: black"><span class="fw-500">{{ $product->name  }}</span></a>
                                    <div class="row mt-3">
                                        <div class="col-8">
                                            @if ($home_base_price != $home_discounted_base_price)
                                            <del class="fw-600 opacity-50">{{ $home_base_price }}</del>
                                            @endif
                                            <h6 style="color: grey;">{{ $home_discounted_base_price }}</h6>
                                        </div>
                                        <div class="col-4">
                                            <span class="rate rating" style="margin-right: -4px">
                                                <i class="las la-star active"></i>
                                            </span>
                                            <span class="fw-700">{{ $product->rating }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="row pl-15px">
                                <div class="col-md-12">
                                    <span class="fs-14 font-weight-bold">{{ translate('Nothing found') }}...</span>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <br>
                        <div class="text-center">
                            {{ $tyre_products->appends(['type' => 'tyre'])->links() }}
                        </div>
                    </div>
                    </div>

                    <div id="battery" class="tabcontent" @if($type == 'battery') style="display: block" @endif>
                        <div class="card-area">
                        <div class="row">
                            @forelse($battery_products as $product)
                            <div class="col-md-3 col-6">
                                <div class="card card-body main-card">
                                    <div class="text-center">
                                        <img class="lazyload product_img" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ $product->attachment }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" width="100%">
                                        <br>
                                        <img class="lazyload mt-1 brand_img" src="{{ static_asset('logo.png') }}" data-src="{{ api_asset($product->battery_brand_img) }}" alt="{{  $product->name  }}" onerror="this.onerror=null;this.src='{{ static_asset('logo.png') }}';" width="100%">
                                    </div>
                                    <a href="javascript:void(0)" class="mt-1" style="color: black"><span class="fw-500">{{ $product->name  }}</span></a>
                                    <div class="row mt-3">
                                        <div class="col-8">
                                            @if ($product->discount > 0)
                                            <del class="fw-600 opacity-50">{{ format_price($product->amount) }}</del>
                                            @endif
                                            <h6 style="color: grey;">{{ format_price($product->amount - $product->discount) }}</h6>
                                        </div>
                                        <div class="col-4">
                                            <span class="rate rating" style="margin-right: -4px">
                                                <i class="las la-star active"></i>
                                            </span>
                                            <span class="fw-700">{{ $product->rating }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="row pl-15px">
                                <div class="col-md-12">
                                    <span class="fs-14 font-weight-bold">{{ translate('Nothing found') }}...</span>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <br>
                        <div class="text-center">
                            {{ $battery_products->appends(['type' => 'battery'])->links() }}
                        </div>
                    </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<script>
    function opentab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

</script>
@endsection
