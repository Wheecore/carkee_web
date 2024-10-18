@foreach($products as $product)
    <div class="col-lg-3 col-md-3 col-sm-4">
        <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
            <div class="position-relative">
                <a href="{{ route('product', $product->slug) }}" class="d-block">
                    <img
                            class="lazyload mx-auto h-100px h-md-100px"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt="{{  $product->getTranslation('name')  }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                    >
                </a>
                <div class="absolute-top-right aiz-p-hov-icon">

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
                </div>
                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset" style="font-size: 14px !important;">{{  $product->getTranslation('name')  }}</a>
                </h3>
            </div>
        </div>
    </div>
@endforeach
