<section class="mb-4">
    {{--<div class="container">--}}
    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
        <div class="d-flex mb-3 align-items-baseline border-bottom">
            <h3 class="h5 fw-700 mb-0">
                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Battery Products') }}</span>
            </h3>
            {{--                <a href="javascript:void(0)" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('Top 12') }}</a>--}}
        </div>
        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach (filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->where('category_id', 2)->limit(12)->get() as $key => $product)
                <div class="carousel-box">
                    @include('frontend.partials.product_box_1',['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
    {{--</div>--}}
</section>
