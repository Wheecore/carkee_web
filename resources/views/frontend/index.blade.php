@extends('frontend.layouts.app')
@section('content')
    <!-- owl-carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!-- /owl-carousel -->
    @php
        $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
        $featured_categories = \App\Models\Category::where('featured', 1)->get();
        $hsilders = DB::table('sliders')->get();
        $i = 1;
        $j = 1;
        $promotion_products = filter_products(\App\Product::where('published', 1)->where('featured', '1'))->limit(8)->get();
        $best_selling_products = filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(8)->get();
        $top_best_selling_products = filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(2)->get();
        $tyre_products = filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->where('category_id', 1)->limit(8)->get();
        $battery_products = filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->where('category_id', 2)->limit(8)->get();
        $service_products = filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->where('category_id', 3)->limit(8)->get();
        $categories = \App\Models\Category::where('parent_id', 0)->select('name','icon','slug')->limit(4)->get();
    @endphp
    <input type="hidden" id="brand_id" name="brand_id" value="">
    <input type="hidden" id="model_id" name="model_id" value="">
    <input type="hidden" id="details_id" name="details_id" value="">
    <input type="hidden" id="select_value" name="select_value" value="Tyre">
<div class="container-fluid back-color">
    <div class="row">
        <div class="col-lg-8 mt-4">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($hsilders as $key => $value)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="{{($j == 1)?'active':''}}"></li>
                    @php $j++;  @endphp
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($hsilders as $key => $value)
                    <div class="carousel-item {{($i == 1)?'active':''}}">
                        <img class="d-block w-100" src="{{ uploaded_asset($value->photo) }}" alt="{{ env('APP_NAME')}} promo">
                    </div>
                        @php $i++;  @endphp
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- right side  -->
        <div class="col-lg-4 mt-4">
            @if(count($top_best_selling_products) > 0)
                @foreach($top_best_selling_products as $key => $product)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3" style="width: 100%;border-radius: 10px;">
                        <div class="row g-0">
                            <div class="col-md-8 col-6">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('product', $product->slug) }}" style="color:black">{{  $product->getTranslation('name')  }}</a></h5>
                                    <br>
                                    <br>
                                    <p class="card-text"><small class="text-muted">
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})">
                                                <i class="las fa-shopping-cart"></i> {{ translate('Add to cart') }}
                                            </a>
                                        </small></p>
                                    <h3 style="color: #F37539;">{{ home_discounted_base_price($product) }}
                                        @if(home_base_price($product) != home_discounted_base_price($product))
                                        <span style="color: #aaa;font-size:20px;"><del>{{ home_base_price($product) }}</del></span>
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="img-fluid rounded-start mt-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- second portion -->
    <div class="row mt-5 mb-5">
        <div class="col-md-4 col-lg-2 small-box">
            <div class="row">
                <div class="col-md-2 col-2" style="padding-left: 20px;padding-top: 10px;">
                    <i class="fa fa-rocket fs-18"></i>
                </div>
                <div class="col-md-10 col-10">
                    <h6>Free Shipping</h6>
                    <p>For all orders over $2.00</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 small-box">
            <div class="row">
                <div class="col-md-2 col-2" style="padding-left: 20px;padding-top: 10px;">
                    <i class="fa fa-refresh fs-18"></i>
                </div>
                <div class="col-md-10 col-10">
                    <h6>1 & 1 Returns</h6>
                    <p>Concelation after 1 day</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 small-box">
            <div class="row">
                <div class="col-md-2 col-2" style="padding-left: 20px;padding-top: 10px;">
                    <i class="fa fa-check-square-o fs-18"></i>
                </div>
                <div class="col-md-10 col-10">
                    <h6>100% Secure Payment</h6>
                    <p>Grauntee secure payments</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 small-box">
            <div class="row">
                <div class="col-md-2 col-2" style="padding-left: 20px;padding-top: 10px;">
                    <i class="fa fa-camera-rotate fs-18"></i>
                </div>
                <div class="col-md-10 col-10">
                    <h6>24/7 Dedicated Support</h6>
                    <p>Anywhere & anytime</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 small-box">
            <div class="row">
                <div class="col-md-2 col-2" style="padding-left: 20px;padding-top: 10px;">
                    <i class="fa fa-tags fs-18"></i>
                </div>
                <div class="col-md-10 col-10">
                    <h6>Daily Offers</h6>
                    <p>Discount up to 70% OFF</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /second portion -->
</div>
<!-- Browser by category -->
<div class="container-fluid">
    <h4 class="main-hed mt-3 mb-4">Browse by categories</h4>
    <div class="row d-flex align-items-center" style="background-color:#e8ecef">

        @foreach($categories as $category)
        <div class="col-md-3 col-3 top_cards">
        <div class="img">
          <img src="{{ uploaded_asset($category->icon) }}" alt="Avatar">
        </div>
        <h6><a href="{{ route('products.category', $category->slug) }}">{{$category->name}}</a></h6>
        </div>
        @endforeach
        </div>
    </div>
<!-- /Browser by category -->
<!-- Promotion Products -->
<div class="container-fluid promotiom mt-5">
    <div class="row">
        <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10 col-6"><h4 class="main-hed">{{ translate('Promotion Products') }}</h4></div>
                    @if(count($promotion_products) == 8)
                        <div class="col-md-2 col-6">
                            <a href="{{route('all.products','promotion')}}" class="btn-donate">
                                View More
                            </a>
                        </div>
                    @endif
                </div>
                <div class="owl-carousel owl-theme mt-5 products_caresoul_owl promotion">
                @if(count($promotion_products) > 0)
                @foreach($promotion_products as $key => $product)
                        @include('frontend.partials.product_box_1',['product' => $product,])
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /Promotion Products -->
<!-- Best selling -->
<div class="container-fluid promotiom mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10 col-6"><h4 class="main-hed">{{ translate('Best Selling') }}</h4></div>
                @if(count($best_selling_products) == 8)
                <div class="col-md-2 col-6">
                    <a href="{{route('all.products','best_selling')}}" class="btn-donate">
                        View More
                    </a>
                </div>
               @endif
            </div>
            <div class="owl-carousel owl-theme mt-5 products_caresoul_owl promotion">
                @if(count($best_selling_products) > 0)
                    @foreach($best_selling_products as $key => $product)
                        @include('frontend.partials.product_box_1',['product' => $product,])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /Best selling -->
<!-- Tyre products -->
<div class="container-fluid promotiom mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10 col-6"><h4 class="main-hed">{{ translate('Tyre Products') }}</h4></div>
                @if(count($tyre_products) == 8)
                    <div class="col-md-2 col-6">
                        <a href="{{route('all.products','tyre')}}" class="btn-donate">
                            View More
                        </a>
                    </div>
                @endif
            </div>
            <div class="owl-carousel owl-theme mt-5 products_caresoul_owl promotion">
                @if(count($tyre_products) > 0)
                    @foreach($tyre_products as $key => $product)
                        @include('frontend.partials.product_box_1',['product' => $product,])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /Tyre products -->

<!-- Battery products -->
{{--<div class="container-fluid promotiom mt-5">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-10 col-6">--}}
{{--                    <h4 class="main-hed">{{ translate('Battery Products') }}</h4>--}}
{{--                </div>--}}
{{--                @if(count($battery_products) == 8)--}}
{{--                    <div class="col-md-2 col-6">--}}
{{--                        <a href="{{route('all.products','battery')}}" class="btn-donate">--}}
{{--                            View More--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="owl-carousel owl-theme mt-5 products_caresoul_owl promotion">--}}
{{--                @if(count($battery_products) > 0)--}}
{{--                    @foreach($battery_products as $key => $product)--}}
{{--                        @include('frontend.partials.product_box_1',['product' => $product,])--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- /Battery products -->

<!-- Service products -->
{{--<div class="container-fluid promotiom mt-5">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-10 col-6">--}}
{{--                    <h4 class="main-hed">{{ translate('Service Products') }}</h4>--}}
{{--                </div>--}}
{{--                @if(count($service_products) == 8)--}}
{{--                    <div class="col-md-2 col-6">--}}
{{--                        <a href="{{route('all.products','service')}}" class="btn-donate">--}}
{{--                            View More--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--              <div class="owl-carousel owl-theme mt-5 products_caresoul_owl promotion">--}}
{{--                @if(count($service_products) > 0)--}}
{{--                    @foreach($service_products as $key => $product)--}}
{{--                        @include('frontend.partials.product_box_1',['product' => $product,])--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--                </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- /Service products -->

<!-- User feedback  -->
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4 class="main-hed">{{ translate('Feedbacks') }}</h4>
            </div>
        </div>
        <div class="row" style="display: flex; justify-content: center;">
            <div class="col-md-11">
                <div class="testimonial-slider">
                    @foreach(DB::table('rating_orders')->get() as $order)
                        <?php
                        $user = \App\User::where('id', $order->user_id)->first();
                        ?>
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <div class="testimonial-icon">
                                <i class="fa fa-quote-left"></i>
                            </div>
                            <p class="description">{!! $order->description !!}</p>
                        </div>
                        <h3 class="title">
                            @if ($user->avatar_original != null)
                                <img src="{{ uploaded_asset($user->avatar_original) }}" class="image rounded-circle mr-2"
                                     style="height: 40px;width: 40px;">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}"
                                     class="image rounded-circle mr-2"
                                     style="height: 40px;width: 40px;">
                            @endif <span class="mt-2">{{ $user->name }}</span></h3>
                        <span class="post">Customer</span>
                    </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $.post('{{ route('home.section.featured') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var current_fs, next_fs, previous_fs;
            // No BACK button on first screen
            if ($(".show").hasClass("first-screen")) {
                $(".prev").css({'display': 'none'});
            }
            // Next button
            $(".next-button").click(function () {
                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();

                $(".prev").css({'display': 'block'});

                $(current_fs).removeClass("show");
                $(next_fs).addClass("show");

                $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

                current_fs.animate({}, {
                    step: function () {

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });

                        next_fs.css({
                            'display': 'block'
                        });
                    }
                });
            });
            // Previous button
            $(".prev").click(function () {
                current_fs = $(".show");
                previous_fs = $(".show").prev();
                $(current_fs).removeClass("show");
                $(previous_fs).addClass("show");

                $(".prev").css({'display': 'block'});

                if ($(".show").hasClass("first-screen")) {
                    $(".prev").css({'display': 'none'});
                }

                $("#progressbar li").eq($(".card2").index(current_fs)).removeClass("active");

                current_fs.animate({}, {
                    step: function () {

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });

                        previous_fs.css({
                            'display': 'block'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function get_models(key, value) {
            var category = $('#select_value').val();
            $(".step" + key).addClass("active");
            $(".step" + key).addClass("acti");
            $('#brand_id').val(value);
            $.ajax({
                url: "{{ url('get-models') }}",
                type: 'get',
                data: {
                    key: key + 1,
                    id: value,
                    // name : name
                },
                success: function (res) {
                    // $('#count_id').val(count);
                    if (res === 'empty') {
                        if (category == 'Services') {
                            window.location = $(location).attr('href') + 'searching-brand-packages/' + value + '/' + category;
                        }
                        else {
                            window.location = $(location).attr('href') + 'searching-brand-products/' + value + '/' + category + '/' + 1;
                        }
                    }
                    else {
                        $('#brand_res').html(res);
                    }
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
    </script>
    <script>
        function showBrandArea() {
            $('input').blur();
            $('#main_search_area').hide();
            $('#brand_search_area').show();
        }
    </script>
    <script>
        $(document).on('click', '.search-button', function () {
            var brand = $('#search_brand').val();
            $.ajax({
                url: "{{ url('get-brand-by-search') }}",
                type: 'get',
                data: {
                    value: brand,
                },
                success: function (res) {
                    $('#brand_res').html(res);

                },
                error: function () {
                    alert('failed...');

                }
            });
        });
    </script>
    <script>
        function ss_models() {
            var brand_id = $('#ss_brand_id').val();
            $.ajax({
                url: "{{ url('get-ca-models') }}",
                type: 'get',
                data: {
                    id: brand_id
                },
                success: function (res) {
                    $('#ss_model_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_userModels() {
            var user_brand_id = $('#ss_user_brand_id').val();
            $.ajax({
                url: "{{ url('get-user-ca-models') }}",
                type: 'get',
                data: {
                    id: user_brand_id
                },
                success: function (res) {
                    $('#ss_user_model_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_userDetails() {
            var user_model_id = $('#ss_user_model_id').val();
            $.ajax({
                url: "{{ url('get-user-ca-details') }}",
                type: 'get',
                data: {
                    id: user_model_id
                },
                success: function (res) {
                    $('#ss_user_details_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_userYears() {
            var user_details_id = $('#ss_user_details_id').val();
            $.ajax({
                url: "{{ url('get-user-ca-years') }}",
                type: 'get',
                data: {
                    id: user_details_id
                },
                success: function (res) {
                    $('#ss_user_year_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_userTypes() {
            var user_year_id = $('#ss_user_year_id').val();
            $.ajax({
                url: "{{ url('get-user-ca-types') }}",
                type: 'get',
                data: {
                    id: user_year_id
                },
                success: function (res) {
                    $('#ss_user_type_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_details() {
            var model_id = $('#ss_model_id').val();
            $.ajax({
                url: "{{ url('get-ca-details') }}",
                type: 'get',
                data: {
                    id: model_id
                },
                success: function (res) {
                    $('#ss_details_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
        function ss_car_years() {
            var details_id = $('#ss_details_id').val();
            $.ajax({
                url: "{{ url('get-ca-years') }}",
                type: 'get',
                data: {
                    id: details_id
                },
                success: function (res) {
                    $('#ss_year_id').html(res);
                },
                error: function () {
                    alert('failed...');
                }
            });
        }
        function ss_types() {
            var year_id = $('#ss_year_id').val();
            $.ajax({
                url: "{{ url('get-ca-types') }}",
                type: 'get',
                data: {
                    id: year_id
                },
                success: function (res) {
                    $('#ss_type_id').html(res);
                },
                // error: function()
                // {
                //     alert('failed...');
                //
                // }
            });
        }
    </script>
    <!-- owl-carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#second-owl').owlCarousel({
            loop: false,
            margin: 20,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 6
                },
                1000: {
                    items: 7
                }
            }
        });
        $('.products_caresoul_owl').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            smartSpeed :900,
            navText : ['<div class="nav-btn prev-slide"><i class="las la-angle-left"></i></div>','<div class="nav-btn next-slide"><i class="las la-angle-right"></i></div>'],
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
    <script>
        $('.testimonial-slider').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            }, {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    </script>
@endsection
