<div class="">
    @if (sizeof($keywords) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary" style="background-color: #EAECEE !important;">{{translate('Popular Suggestions')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($keywords as $key => $keyword)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary" href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($categories) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary" style="background-color: #EAECEE !important;">{{translate('Category Suggestions')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($categories as $key => $category)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($brands) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary" style="background-color: #EAECEE !important;">{{translate('Category Suggestions')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($brands as $key => $brand)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary" href="{{ route('products.brand', $brand->slug) }}">{{ $brand->getTranslation('name') }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($products) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary" style="background-color: #EAECEE !important;">{{translate('Products')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($products as $key => $product)
                <li class="list-group-item">
                    <a class="text-reset" href="{{ route('product', $product->slug) }}">
                        <div class="d-flex search-product align-items-center">
                            <div class="mr-3">
                                <img class="size-40px img-fit rounded" src="{{ uploaded_asset($product->thumbnail_img) }}">
                            </div>
                            <div class="flex-grow-1 overflow--hidden minw-0">
                                <div class="product-name text-truncate fs-14 mb-5px">
                                    {{  $product->getTranslation('name')  }}
                                </div>
                                <div class="">
                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                        <del class="opacity-60 fs-15">{{ home_base_price($product) }}</del>
                                    @endif
                                    <span class="fw-600 fs-16 text-primary">{{ home_discounted_base_price($product) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
{{--@if(get_setting('vendor_system_activation') == 1)--}}
    {{--<div class="">--}}
        {{--@if (count($shops) > 0)--}}
            {{--<div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Shops')}}</div>--}}
            {{--<ul class="list-group list-group-raw">--}}
                {{--@foreach ($shops as $key => $shop)--}}
                    {{--<li class="list-group-item">--}}
                        {{--<a class="text-reset" href="{{ route('shop.visit', $shop->slug) }}">--}}
                            {{--<div class="d-flex search-product align-items-center">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img class="size-40px img-fit rounded" src="{{ uploaded_asset($shop->logo) }}">--}}
                                {{--</div>--}}
                                {{--<div class="flex-grow-1 overflow--hidden">--}}
                                    {{--<div class="product-name text-truncate fs-14 mb-5px">--}}
                                        {{--{{ $shop->name }}--}}
                                    {{--</div>--}}
                                    {{--<div class="opacity-60">--}}
                                        {{--{{ $shop->address }}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--@endif--}}
    {{--</div>--}}
{{--@endif--}}
    <div class="">
        @if (count($shops) > 0)
            <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary" style="background-color: #EAECEE !important;">{{translate('Shops')}}</div>
            <ul class="list-group list-group-raw">
                @foreach ($shops as $key => $shop)
                    <li class="list-group-item">
                        <a class="text-reset" href="#">
                            <div class="d-flex search-product align-items-center">
                                <div class="mr-3">
                                    <img class="size-40px img-fit rounded" src="{{ uploaded_asset($shop->logo) }}">
                                </div>
                                <div class="flex-grow-1 overflow--hidden">
                                    <div class="product-name text-truncate fs-14 mb-5px">
                                        {{ $shop->name }}
                                    </div>
                                    <div class="opacity-60">
                                        {{ $shop->address }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
