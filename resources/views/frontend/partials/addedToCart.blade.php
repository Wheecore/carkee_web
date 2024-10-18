<div class="modal-body p-4 added-to-cart">
    <div class="text-success mb-4">
        <h3><span>
        <i class="las la-check-circle la-3x" style="font-size: 22px;"></i></span>{{ translate('Item added to your cart!')}}</h3>
    </div>
    <div class="media mb-4">
        <div class="row">
            <div class=col-4>
                    <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($product->thumbnail_img) }}" class="mr-3 lazyload size-100px img-fit rounded" alt="Product Image">
            </div>

            <div class=col-8>
            <div class="media-body pt-3 text-left">
            <h6 class="fw-600">
                {{  $product->getTranslation('name')  }}
            </h6>
            <div class="row mt-3">
                <div class="col-sm-2 opacity-60">
                    <div>{{ translate('Price')}}:</div>
                </div>
                <div class="col-sm-10">
                    <div class="h6 text-primary">
                        <strong class="ml-2">
                            {{ single_price(($data['price'] + $data['tax']) * $data['quantity']) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
            </div>

            </div>


    </div>
    <div class="">
        <button class="btn btn-outline-primary mb-3 mb-sm-0" data-dismiss="modal">{{ translate('Back to shopping')}}</button>
        <a href="{{ route('cart') }}" class="btn btn-primary mb-3 mb-sm-0 text-white">{{ translate('Proceed to Checkout')}}</a>
    </div>
</div>
