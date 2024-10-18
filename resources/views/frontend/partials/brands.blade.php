<section class="mb-4">
    {{--<div class="container">--}}
    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
        <div class="d-flex mb-3 align-items-baseline border-bottom">
            <h3 class="h5 fw-700 mb-0">
                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Brands') }}</span>
            </h3>
                            <a href="{{ url('brands') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
        </div>
        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach (\App\Models\Brand::orderBy('id', 'desc')->limit(12)->get() as $key => $brand)
                <div class="carousel-box">

                    <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                        <div class="position-relative">
                            <a href="javascript:void(0)" class="d-block image-hover-scale" style="z-index: 0;">
                                <img
                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($brand->logo) }}"
                                        alt="{{  $brand->getTranslation('name')  }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >
                            </a>
                        </div>

                    </div>


                </div>
            @endforeach
        </div>
    </div>
    {{--</div>--}}
</section>
