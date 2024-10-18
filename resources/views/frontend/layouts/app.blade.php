<!DOCTYPE html>
@if (DB::table('languages')->where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @endif
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="app-url" content="{{ getBaseURL() }}">
            <meta name="file-base-url" content="{{ getFileBaseURL() }}">

            <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="robots" content="index, follow">
            <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
            <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

        @yield('meta')

        @if (!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
            <!-- Schema.org markup for Google+ -->
                <meta itemprop="name" content="{{ get_setting('meta_title') }}">
                <meta itemprop="description" content="{{ get_setting('meta_description') }}">
                <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Twitter Card data -->
                <meta name="twitter:card" content="product">
                <meta name="twitter:site" content="@publisher_handle">
                <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
                <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
                <meta name="twitter:creator" content="@author_handle">
                <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Open Graph data -->
                <meta property="og:title" content="{{ get_setting('meta_title') }}" />
                <meta property="og:type" content="website" />
                <meta property="og:url" content="{{ route('home') }}" />
                <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}" />
                <meta property="og:description" content="{{ get_setting('meta_description') }}" />
                <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
                <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
        @endif
            <!-- Favicon -->
            <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
            <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
            <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="{{static_asset('front_assets/css/bootstrap.min.css')}}">
            <!-- Fontawesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <!-- slickSlider cdn -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer"
            />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer"
            />
            <!-- /slickSlider cdn -->
            <!-- material icons link -->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <!-- Range Slider -->
            <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            <!-- Custom Styling -->
            <link rel="stylesheet" href="{{static_asset('front_assets/css/style.css')}}">
            <script>
                var AIZ = AIZ || {};
                AIZ.local = {
                    nothing_selected: '{{ translate('Nothing selected') }}',
                    nothing_found: '{{ translate('Nothing found') }}',
                    choose_file: '{{ translate('Choose file') }}',
                    file_selected: '{{ translate('File selected') }}',
                    files_selected: '{{ translate('Files selected') }}',
                    add_more_files: '{{ translate('Add more files') }}',
                    adding_more_files: '{{ translate('Adding more files') }}',
                    drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
                    browse: '{{ translate('Browse') }}',
                    upload_complete: '{{ translate('Upload complete') }}',
                    upload_paused: '{{ translate('Upload paused') }}',
                    resume_upload: '{{ translate('Resume upload') }}',
                    pause_upload: '{{ translate('Pause upload') }}',
                    retry_upload: '{{ translate('Retry upload') }}',
                    cancel_upload: '{{ translate('Cancel upload') }}',
                    uploading: '{{ translate('Uploading') }}',
                    processing: '{{ translate('Processing') }}',
                    complete: '{{ translate('Complete') }}',
                    file: '{{ translate('File') }}',
                    files: '{{ translate('Files') }}',
                }
            </script>
            @if (get_setting('google_analytics') == 1)
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('TRACKING_ID') }}"></script>

                <script>
                    window.dataLayer = window.dataLayer || [];

                    function gtag() {
                        dataLayer.push(arguments);
                    }
                    gtag('js', new Date());
                    gtag('config', '{{ env('TRACKING_ID') }}');
                </script>
            @endif

            @if (get_setting('facebook_pixel') == 1)
            <!-- Facebook Pixel Code -->
                <script>
                    ! function(f, b, e, v, n, t, s) {
                        if (f.fbq) return;
                        n = f.fbq = function() {
                            n.callMethod ?
                                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                        };
                        if (!f._fbq) f._fbq = n;
                        n.push = n;
                        n.loaded = !0;
                        n.version = '2.0';
                        n.queue = [];
                        t = b.createElement(e);
                        t.async = !0;
                        t.src = v;
                        s = b.getElementsByTagName(e)[0];
                        s.parentNode.insertBefore(t, s)
                    }(window, document, 'script',
                        'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '{{ env('FACEBOOK_PIXEL_ID') }}');
                    fbq('track', 'PageView');
                </script>
                <noscript>
                    <img height="1" width="1" style="display:none"
                         src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}&ev=PageView&noscript=1" />
                </noscript>
                <!-- End Facebook Pixel Code -->
            @endif
            @php
                echo get_setting('header_script');
            @endphp

            <style>
                #hero-section .icons .speed-lock{
                    align-items: center;
                }
                .rated-sec .people-rating{
                    margin-top: 6%!important;
                    margin-left: 0px!important;
                }
                .top_cards{
                    height: auto!important;
                    display: flex;  
                    flex-direction: column;
                    padding-left: 0px!important;
                    align-items: center;
                }
                .top_cards h6{
                    margin-left: 0px!important;
                    font-size: 12px!important;
                    margin-bottom: 0px!important;
                }
                .top_cards .img{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .top_cards img{
                    margin-top: 0px!important;
                    width: 75%;
                    
                }
                

                    @media (min-width:1439px){
                        .stars .rating{
                        margin-left: 0%;
                    }
                    }

                    @media (min-width:1024px){
                        .stars .rating{
                        margin-left: -10%;
                    }
                    }

                @media (max-width:1024px){
                    #hero-section .left .speed-lock .span{
                        margin-left: 5px;
                    }
                    .card-area .main-card .right-side .right-side2 .btn {
                        padding: 5% 8%!important;
                    }
                    .main-card .right-side .right-side2 h3{
                        font-size: 22px;
                    }
                    .aiz-radio-inline{
                        margin-left: 5%;
                    }
                    
                }

                @media (max-width:768px){
                    .card-area .main-card .express h3{
                        font-size: 24px;
                    }
                    #nearby-merchants-vouchers .alert-info{
                        font-size: 9px!important;
                    }
                    .product-detail-heading{
                        text-align: center;
                    }
                    .card-area .main-card .express h3{
                        font-size: 21px;
                    }
                    .people-rating{
                        margin-left: 0%;
                    }
                    .people-rating ul{
                        margin-top: 15%;
                    }
                    .tab-star i{
                        font-size: 9px!important;
                    }
                    .top_cards .img{
                        height: 150px!important;
                        width: 150px!important;
                    }
                    
                }
                
                @media (max-width:480px){
                    .promotiom .card-img-top{
                        height: 150px;
                    }
                    .promotiom .card{
                        height: 275px;
                    }
                    .owl-carousel .item h6{
                        text-align: left;
                    }
                    #hero-section .left .speed-lock .span{
                        font-size: 12px;
                    }
                    #money-section{
                        padding: 20px;
                    }
                    .card-area .main-card .right-side h3{
                        font-size: 20px;
                    }
                    .merchant-cat{
                        margin-top: 20px;
                    }
                    .product-detail-heading{
                        font-size: 14px!important;
                    }
                    .top-banner{
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .rated-sec .people-rating{
                    margin-top: 0%!important;
                    margin-left: 0px!important;
                    }
                    .top_cards .img{
                        height: 75px!important;
                        width: 75px!important;
                    }
                    
                    
                }

                @media (max-width:390px){
                    .nav-fill.w-300px{
                        width: 232px!important;
                    }
                    .promotiom .card-img-top{
                        height: 130px;
                    }
                    .top_cards h6{
                    font-size: 9px!important;
                }
                }

                @media (max-width:320px){
                    .nav-fill.w-300px{
                        width: 205px!important;
                    }
                    .serach-nav-field{
                        padding-left: 15%!important;
                    }
                    #hero-section .left .speed-lock .span{
                        font-size: 10px;
                        margin-left: 5px;
                    }
                }
            </style>
        </head>
        <body>
            @include('frontend.inc.nav')
            @yield('content')
            @include('frontend.inc.footer')

        @if (get_setting('show_cookies_agreement') == 'on')
            <div class="aiz-cookie-alert shadow-xl">
                <div class="p-3 bg-dark rounded">
                    <div class="text-white mb-3">
                        @php
                            echo get_setting('cookies_agreement_text');
                        @endphp
                    </div>
                    <button class="btn btn-primary aiz-cookie-accept">
                        {{ translate('Ok. I Understood') }}
                    </button>
                </div>
            </div>
        @endif

        @if (get_setting('show_website_popup') == 'on')
            <div class="modal website-popup removable-session d-none" data-key="website-popup" data-value="removed">
                <div class="absolute-full bg-black opacity-60"></div>
                <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-md">
                    <div class="modal-content position-relative border-0 rounded-0">
                        <div class="aiz-editor-data">
                            {!! get_setting('website_popup_content') !!}
                        </div>
                        @if (get_setting('show_subscribe_form') == 'on')
                            <div class="pb-5 pt-4 px-5">
                                <form class="" method="POST" action="{{ route('subscribers.store') }}">
                                    @csrf
                                    <div class="form-group mb-0">
                                        <input type="email" class="form-control"
                                               placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block mt-3">
                                        {{ translate('Subscribe Now') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                        <button
                            class="absolute-top-right bg-white shadow-lg btn btn-circle btn-icon mr-n3 mt-n3 set-session"
                            data-key="website-popup" data-value="removed" data-toggle="remove-parent"
                            data-parent=".website-popup">
                            <i class="la la-close fs-20"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @include('frontend.partials.modal')

        <div class="modal fade" id="addToCart">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
                 role="document">
                <div class="modal-content position-relative">
                    <div class="c-preloader text-center p-3">
                        <i class="las la-spinner la-spin la-3x"></i>
                    </div>
                    <button type="button" class="close absolute-top-right btn-icon close z-1" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true" class="la-2x">&times;</span>
                    </button>
                    <div id="addToCart-modal-body">

                    </div>
                </div>
            </div>
        </div>

        @yield('modal')
        <!-- SCRIPTS -->
        <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
        <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            var mainurl = "{{ url('/') }}";
            var currenturl = "{{ Route::currentRouteName() }}";

            function loadingBtn() {
                $('.loading-btn').prop('disabled', true);
                return true;
            }
        </script>
        @if (get_setting('facebook_chat') == 1)
            <script type="text/javascript">
                window.fbAsyncInit = function() {
                    FB.init({
                        xfbml: true,
                        version: 'v3.3'
                    });
                };

                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div id="fb-root"></div>
            <!-- Your customer chat code -->
            <div class="fb-customerchat" attribution=setup_tool page_id="{{ env('FACEBOOK_PAGE_ID') }}">
            </div>
        @endif
        <script>
            @foreach (session('flash_notification', collect())->toArray() as $message)
            AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
            @endforeach
        </script>
        <script>
            $(document).ready(function() {
                $('.category-nav-element').each(function(i, el) {
                    $(el).on('mouseover', function() {
                        if (!$(el).find('.sub-cat-menu').hasClass('loaded')) {
                            $.post('{{ route('category.elements') }}', {
                                _token: AIZ.data.csrf,
                                id: $(el).data('id')
                            }, function(data) {
                                $(el).find('.sub-cat-menu').addClass('loaded').html(data);
                            });
                        }
                    });
                });
                if ($('#lang-change').length > 0) {
                    $('#lang-change .dropdown-menu a').each(function() {
                        $(this).on('click', function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var locale = $this.data('flag');
                            $.post('{{ route('language.change') }}', {
                                _token: AIZ.data.csrf,
                                locale: locale
                            }, function(data) {
                                location.reload();
                            });

                        });
                    });
                }

                if ($('#currency-change').length > 0) {
                    $('#currency-change .dropdown-menu a').each(function() {
                        $(this).on('click', function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var currency_code = $this.data('currency');
                            $.post('{{ route('currency.change') }}', {
                                _token: AIZ.data.csrf,
                                currency_code: currency_code
                            }, function(data) {
                                location.reload();
                            });

                        });
                    });
                }
            });
            $('#search').on('keyup', function() {
                search();
            });
            $('#search').on('focus', function() {
                search();
            });
            function search() {
                var searchKey = $('#search').val();
                if (searchKey.length > 0) {
                    $('body').addClass("typed-search-box-shown");

                    $('.typed-search-box').removeClass('d-none');
                    $('.search-preloader').removeClass('d-none');
                    $.post('{{ route('search.ajax') }}', {
                        _token: AIZ.data.csrf,
                        search: searchKey
                    }, function(data) {
                        if (data == '0') {
                            // $('.typed-search-box').addClass('d-none');
                            $('#search-content').html(null);
                            $('.typed-search-box .search-nothing').removeClass('d-none').html(
                                'Sorry, nothing found for <strong>"' + searchKey + '"</strong>');
                            $('.search-preloader').addClass('d-none');

                        } else {
                            $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                            $('#search-content').html(data);
                            $('.search-preloader').addClass('d-none');
                        }
                    });
                } else {
                    $('.typed-search-box').addClass('d-none');
                    $('body').removeClass("typed-search-box-shown");
                }
            }
            function updateNavCart() {
                $.post('{{ route('cart.nav_cart') }}', {
                    _token: AIZ.data.csrf
                }, function(data) {
                    $('#cart_items').html(data);
                });
            }
            function removeFromCart(key) {
                $.post('{{ route('cart.removeFromCart') }}', {
                    _token: AIZ.data.csrf,
                    id: key
                }, function(data) {
                    updateNavCart();
                    $('#cart-summary').html(data);
                    AIZ.plugins.notify('success', 'Item has been removed from cart');
                    $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) - 1);
                });
            }
            function addToCompare(id) {
                $.post('{{ route('compare.addToCompare') }}', {
                    _token: AIZ.data.csrf,
                    id: id
                }, function(data) {
                    $('#compare').html(data);
                    AIZ.plugins.notify('success', "{{ translate('Item has been added to compare list') }}");
                    $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html()) + 1);
                });
            }
            function addToWishList(id) {
                @if (Auth::check() && (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'seller'))
                $.post('{{ route('wishlists.store') }}', {_token: AIZ.data.csrf, id:id}, function(data){
                    if(data != 0){
                        $('#wishlist').html(data);
                        AIZ.plugins.notify('success', "{{ translate('Item has been added to wishlist') }}");
                    }
                    else{
                        AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
                    }
                });
                @else
                AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
                @endif
            }
            function showAddToCartModal(id) {
                if (!$('#modal-size').hasClass('modal-lg')) {
                    $('#modal-size').addClass('modal-lg');
                }
                $('#addToCart-modal-body').html(null);
                $('#addToCart').modal();
                $('.c-preloader').show();
                $.post('{{ route('cart.showCartModal') }}', {
                    _token: AIZ.data.csrf,
                    id: id
                }, function(data) {
                    $('.c-preloader').hide();
                    $('#addToCart-modal-body').html(data);
                    AIZ.plugins.slickCarousel();
                    AIZ.plugins.zoom();
                    AIZ.extra.plusMinus();
                    getVariantPrice();
                });
            }
            $('#option-choice-form input').on('change', function() {
                getVariantPrice();
            });
            function getVariantPrice() {
                if ($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('products.variant_price') }}',
                        data: $('#option-choice-form').serializeArray(),
                        success: function(data) {

                            $('.product-gallery-thumb .carousel-box').each(function(i) {
                                if ($(this).data('variation') && data.variation == $(this).data(
                                    'variation')) {
                                    $('.product-gallery-thumb').slick('slickGoTo', i);
                                }
                            })

                            $('#option-choice-form #chosen_price_div').removeClass('d-none');
                            $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                            $('#available-quantity').html(data.quantity);
                            $('.input-number').prop('max', data.max_limit);
                            if (parseInt(data.in_stock) == 0) {
                                $('.buy-now').addClass('d-none');
                                $('.add-to-cart').addClass('d-none');
                                $('.out-of-stock').removeClass('d-none');
                            } else {
                                $('.buy-now').removeClass('d-none');
                                $('.add-to-cart').removeClass('d-none');
                                $('.out-of-stock').addClass('d-none');
                            }
                        }
                    });
                }
            }
            function checkAddToCartValidity() {
                var names = {};
                $('#option-choice-form input:radio').each(function() { // find unique names
                    names[$(this).attr('name')] = true;
                });
                var count = 0;
                $.each(names, function() { // then count them
                    count++;
                });
                if($('#option-choice-form input:radio:checked').length == count) {
                    return true;
                }
                return false;
            }
            function addToCart() {
                if (checkAddToCartValidity()) {
                    $('#addToCart').modal();
                    $('.c-preloader').show();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('cart.addToCart') }}',
                        data: $('#option-choice-form').serializeArray(),
                        success: function(data) {
                            $('#addToCart-modal-body').html(null);
                            $('.c-preloader').hide();
                            $('#modal-size').removeClass('modal-lg');
                            $('#addToCart-modal-body').html(data.view);
                            updateNavCart();
                            $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
                        }
                    });
                } else {
                    AIZ.plugins.notify('warning', 'Please choose all the options');
                }
            }
            function buyNow() {
                if (checkAddToCartValidity()) {
                    $('#addToCart-modal-body').html(null);
                    $('#addToCart').modal();
                    $('.c-preloader').show();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('cart.addToCart') }}',
                        data: $('#option-choice-form').serializeArray(),
                        success: function(data) {
                            if (data.status == 1) {
                                updateNavCart();
                                $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
                                window.location.replace("{{ route('cart') }}");
                            } else {
                                $('#addToCart-modal-body').html(null);
                                $('.c-preloader').hide();
                                $('#modal-size').removeClass('modal-lg');
                                $('#addToCart-modal-body').html(data.view);
                            }
                        }
                    });
                } else {
                    AIZ.plugins.notify('warning', 'Please choose all the options');
                }
            }
            function cartQuantityInitialize() {
                $('.btn-number').click(function(e) {
                    e.preventDefault();

                    fieldName = $(this).attr('data-field');
                    type = $(this).attr('data-type');
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());

                    if (!isNaN(currentVal)) {
                        if (type == 'minus') {

                            if (currentVal > input.attr('min')) {
                                input.val(currentVal - 1).change();
                            }
                            if (parseInt(input.val()) == input.attr('min')) {
                                $(this).attr('disabled', true);
                            }

                        } else if (type == 'plus') {

                            if (currentVal < input.attr('max')) {
                                input.val(currentVal + 1).change();
                            }
                            if (parseInt(input.val()) == input.attr('max')) {
                                $(this).attr('disabled', true);
                            }

                        }
                    } else {
                        input.val(0);
                    }
                });

                $('.input-number').focusin(function() {
                    $(this).data('oldValue', $(this).val());
                });

                $('.input-number').change(function() {
                    minValue = parseInt($(this).attr('min'));
                    maxValue = parseInt($(this).attr('max'));
                    valueCurrent = parseInt($(this).val());

                    name = $(this).attr('name');
                    if (valueCurrent >= minValue) {
                        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        alert('Sorry, the minimum value was reached');
                        $(this).val($(this).data('oldValue'));
                    }
                    if (valueCurrent <= maxValue) {
                        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        alert('Sorry, the maximum value was reached');
                        $(this).val($(this).data('oldValue'));
                    }


                });
                $(".input-number").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            }
            function imageInputInitialize() {
                $('.custom-input-file').each(function() {
                    var $input = $(this),
                        $label = $input.next('label'),
                        labelVal = $label.html();

                    $input.on('change', function(e) {
                        var fileName = '';

                        if (this.files && this.files.length > 1)
                            fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}',
                                this.files.length);
                        else if (e.target.value)
                            fileName = e.target.value.split('\\').pop();

                        if (fileName)
                            $label.find('span').html(fileName);
                        else
                            $label.html(labelVal);
                    });

                    // Firefox bug fix
                    $input
                        .on('focus', function() {
                            $input.addClass('has-focus');
                        })
                        .on('blur', function() {
                            $input.removeClass('has-focus');
                        });
                });
            }
            let _tooltip = jQuery.fn.tooltip;
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script>
            jQuery.fn.tooltip = _tooltip;
            $(document).ready(function() {
                $('.datepicker').datepicker({
                    setDate: '06-27-2016',
                    minDate: 0
                });
            });
        </script>
        <script>
            function models() {
                var brand_id = $('#brand_id').val();
                $.ajax({
                    url: "{{ url('get-ca-models') }}",
                    type: 'get',
                    data: {
                        id: brand_id
                    },
                    success: function(res) {
                        $('#model_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function userModels() {
                var user_brand_id = $('#user_brand_id').val();
                $.ajax({
                    url: "{{ url('get-user-ca-models') }}",
                    type: 'get',
                    data: {
                        id: user_brand_id
                    },
                    success: function(res) {
                        $('#user_model_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function userDetails() {
                var user_model_id = $('#user_model_id').val();
                $.ajax({
                    url: "{{ url('get-user-ca-details') }}",
                    type: 'get',
                    data: {
                        id: user_model_id
                    },
                    success: function(res) {
                        $('#user_details_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function userYears() {
                var user_details_id = $('#user_details_id').val();
                $.ajax({
                    url: "{{ url('get-user-ca-years') }}",
                    type: 'get',
                    data: {
                        id: user_details_id
                    },
                    success: function(res) {
                        $('#user_year_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function userTypes() {
                var user_year_id = $('#user_year_id').val();
                $.ajax({
                    url: "{{ url('get-user-ca-types') }}",
                    type: 'get',
                    data: {
                        id: user_year_id
                    },
                    success: function(res) {
                        $('#user_type_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function details() {
                var model_id = $('#model_id').val();
                $.ajax({
                    url: "{{ url('get-ca-details') }}",
                    type: 'get',
                    data: {
                        id: model_id
                    },
                    success: function(res) {
                        $('#details_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function car_years() {
                var details_id = $('#details_id').val();
                $.ajax({
                    url: "{{ url('get-ca-years') }}",
                    type: 'get',
                    data: {
                        id: details_id
                    },
                    success: function(res) {
                        $('#year_id').html(res);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            function types() {
                var year_id = $('#year_id').val();
                $.ajax({
                    url: "{{ url('get-ca-types') }}",
                    type: 'get',
                    data: {
                        id: year_id
                    },
                    success: function(res) {
                        $('#type_id').html(res);
                    },
                    // error: function()
                    // {
                    //     alert('failed...');
                    
                    // }
                });
            }
        </script>
        <script>
            function selectCategory() {
                // $(".dslbd").css({"display":"block"});
                $(".catreq").css({
                    "display": "block"
                });
            }
            function showCategory() {
                // $(".dslbd").css({"display":"block"});
                $(".categories").css({
                    "display": "inline-flex"
                });
                // $(".btn1").css({"display":"block"});
                $(".btn2").css({
                    "display": "none"
                });
            }
        </script>
        <script>
            $(document).mouseup(function(e) {
                var container = $(".search-carlist-form");
                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $(".search-carlist-form").removeClass("show")
                    $("#nav-flyout-accountList").css({
                        'display': 'none'
                    })
                    $(".smenu__filter").removeClass("smenu__filter--show-myself");
                }
                var hmenucontainer = $("#hmenu-canvas");

                // if the target of the click isn't the container nor a descendant of the container
                if (!hmenucontainer.is(e.target) && hmenucontainer.has(e.target).length === 0) {
                    $("#nav-flyout-accountList").css({
                        'display': 'none'
                    })

                    $("#hmenu-container").removeClass("hmenu-visible");
                    $("#hmenu-canvas-background").addClass("hmenu-transparent");
                    $("#hmenu-canvas-background").removeClass("hmenu-opaque");
                    $(".ulhmenu").removeClass("hmenu-visible");
                    $(".menu2").removeClass("hmenu-visible hmenu-translateX");

                    $(".smenu__filter").removeClass("smenu__filter--show-myself");
                }
            });
        </script>
        <script>
            function openSidebar() {
                $(".ulhmenu").addClass("hmenu-visible");
                $("#hmenu-container").addClass("hmenu-visible");
                $("#hmenu-canvas-background").removeClass("hmenu-transparent");
                $("#hmenu-canvas-background").addClass("hmenu-opaque");
            }
            function closeSiebar() {
                $(".ulhmenu").removeClass("hmenu-visible");
                $("#hmenu-container").removeClass("hmenu-visible");
                $("#hmenu-canvas-background").addClass("hmenu-transparent");
                $("#hmenu-canvas-background").removeClass("hmenu-opaque");
            }
        </script>
        <script>
            function changeActionUrl() {
                var brand_id = $('#brand_id').val();
                var model_id = $('#model_id').val();
                if (brand_id != '' && model_id != '') {
                    $("#psb").css({
                        'display': 'none'
                    })
                    $(".navsearchform").attr("action", "{{ route('carlist.front.store') }}");
                    $(".navsearchform").attr("method", "POST");
                    $(".navsearchform").submit();
                } else {
                    $("#psb").css({
                        'display': 'block'
                    })
                }
            }
        </script>
        <script>
            $('li.tyre_cats').click(function() {
                $(".menu2").removeClass("hmenu-translateX-right");
                $(".menu1").removeClass("hmenu-visible");

                setTimeout(
                    function() {
                        remove_tyre_cat();
                    }, 300);
            });
            $('.hmenu-arrow-prev').click(function() {
                $(".menu1").addClass("hmenu-visible");
                $(".menu2").addClass("hmenu-translateX-right");
                $(".menu1").removeClass("hmenu-translateX-left");
                $(".menu2").removeClass("hmenu-visible hmenu-translateX");
            });

            function remove_tyre_cat() {
                $(".menu1").addClass("hmenu-translateX-left");
                $(".menu2").addClass("hmenu-visible hmenu-translateX");
            }
        </script>
{{--        <script src="{{static_asset('front_assets/js/bootstrap.bundle.min.js')}}"></script>--}}
        <script>
            $(document).on("click",".gallery_image_click", function(){
                var img_src = $(this).attr("src");
                $(".remove").removeClass("orange");
                $(this).closest('div').addClass("orange");
                $(".main_image img").attr("src",img_src);
            });
        </script>
        @yield('script')
        @php
            echo get_setting('footer_script');
        @endphp
        </body>
        </html>
