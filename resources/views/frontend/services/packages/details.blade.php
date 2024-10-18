@extends('frontend.layouts.app')

@section('meta_title')Package Details @stop

@section('content')
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white shadow-sm rounded p-3">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">

                            <div class="col order-1 order-md-2">

                                <img
                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($package->logo) }}"
                                        alt=""
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >

                            </div>


                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <h1 class="mb-2 fs-20 fw-600">
                                {{ $package->getTranslation('name') }}
                            </h1>


                            <hr>


                            <hr>



                                <div class="row no-gutters mt-3">
                                    <div class="col-sm-1">
                                        <div class="opacity-50 my-2">{{ translate('Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="fs-20 opacity-60">

                                                    <span>${{ $package->price }}</span>


                                        </div>
                                    </div>
                                </div>





                            <hr>



                            <div class="mt-3">
                                <a href="{{ url('cart/packageToCart',$package->id) }}" class="btn btn-soft-primary mr-2 fw-600">
                                <i class="las la-shopping-bag"></i>
                                <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                </a>
{{--                                <a href="{{ route('front.package.show', ['id'=>$package->id, 'lang'=>env('DEFAULT_LANGUAGE')]) }}" class="btn btn-success">View Products</a>--}}
                                {{--<button type="button" class="btn btn-soft-primary mr-2 add-to-cart fw-600" onclick="packageToCart()">--}}
                                {{--<i class="las la-shopping-bag"></i>--}}
                                {{--<span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>--}}
                                {{--</button>--}}

                                <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none" disabled>
                                    <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                                </button>
                            </div>







                            {{--<div class="row no-gutters mt-4">--}}
                                {{--<div class="col-sm-2">--}}
                                    {{--<div class="opacity-50 my-2">{{ translate('Share')}}:</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<div class="aiz-share"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </section>
    <div id="section_featured">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Package Products</span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow slick-initialized slick-slider"
                         data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2"
                         data-xs-items="2" data-arrows="true">
                        <div class="slick-list draggable">
                            <h6 class="text-center"><b>Recommended Products</b></h6>
                            <hr>
                            <div class="row"
                                 style="opacity: 1; transform: translate3d(0px, 0px, 0px);">
                                @if($rproducts != null)
                                    @foreach($rproducts as $key=>$item)
                                        @if ($item != "on")
                                            <?php
                                            //                                      $prod_id = $product;

                                            $product = DB::table('products')->where('id', $item)->first();
                                            //                                    dd($product->slug);
                                            $stock = DB::table('product_stocks')->where('product_id', $item)->first(); ?>
                                                <div class="col-2">
                                                <div>
                                                    <div class="carousel-box" style="width: 100%; display: inline-block;">
                                                        <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white"
                                                             >
                                                            <div class="position-relative">
                                                                <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                                    <img
                                                                            class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                            alt=""
                                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                    >
                                                                </a>

                                                            </div>
                                                            <div class="p-md-3 p-2 text-left">
                                                                <div class="fs-15">
                                                                    <span class="fw-700 text-primary">${{ $stock->price }}</span>
                                                                </div>

                                                                <h3 class="fw-400 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                @else
                                    <h4 class="card-title ml-3">No data found!</h4>
                                @endif

                            </div>
                            <h6 class="text-center"><b>Addon Products</b></h6>
                            <hr>
                            <div class="row"
                                 style="opacity: 1; transform: translate3d(0px, 0px, 0px);">
                                @if($aproducts != null)
                                    @foreach($aproducts as $key=>$item)
                                        @if ($item != "on")
                                            <?php
                                            //                                      $prod_id = $product;

                                            $product = DB::table('products')->where('id', $item)->first();
                                            //                                    dd($product->slug);
                                            $stock = DB::table('product_stocks')->where('product_id', $item)->first(); ?>
                                            <div class="col-2">
                                                <div>
                                                    <div class="carousel-box" style="width: 100%; display: inline-block;">
                                                        <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white"
                                                             style="border-radius: 30px !important;">
                                                            <div class="position-relative">
                                                                <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                                    <img
                                                                            class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                            alt=""
                                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                    >
                                                                </a>

                                                            </div>
                                                            <div class="p-md-3 p-2 text-left">
                                                                <div class="fs-15">
                                                                    <span class="fw-700 text-primary">${{ $stock->price }}</span>
                                                                </div>

                                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                @else
                                    <h4 class="card-title ml-3">No data found!</h4>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $package->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $package->name }}" placeholder="{{ translate('Product Name') }}" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $package->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone')}}" name="email" id="email">
                                @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span class="opacity-60">{{  translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password')}}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{  translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?')}}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?')}}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                        </div>
                        @if(get_setting('google_login') == 1 ||
                            get_setting('facebook_login') == 1 ||
                            get_setting('twitter_login') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(get_setting('google_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }
        function show_chat_modal(){
            @if (Auth::check())
            $('#chat_modal').modal('show');
            @else
            $('#login_modal').modal('show');
            @endif
        }

    </script>


    <script>


    </script>

@endsection
