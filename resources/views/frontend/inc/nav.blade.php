<!--Zain Goraya Styling-->
<style>
        @media (max-width:1024px){
            .input-col>.input-group>.input-group-prepend{
            width:10%;
            }
            .serach-nav-field{
                padding-left:35%;
            }
        }

        @media (max-width:768px){
            .input-col>.input-group>.input-group-prepend{
            width:19%;
            }
            .serach-nav-field{
                padding-left:11%;
            }
        }

        @media (max-width:480px){
            .input-col>.input-group>.input-group-prepend{
            width:4%;
            }
            .desk-text{
                display: none;
            }
        }
    </style>
<header>
    <div class="container-fluid top-header">
        <div class="row">
            <div class="col-lg-3 col-12 logo-col">
                <a href="{{ route('home') }}">
                    @php
                        $header_logo = get_setting('header_logo');
                    @endphp
                    @if($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                             class="mw-100" height="40" style="height: 52px;">
                    @else
                        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                             class="mw-100 " height="40">
                    @endif
                </a>
            </div>
            <div class="col-lg-5 col-12 input-col">
                <div class="input-group mt-2">
                    <div class="input-group-prepend" style="border-right: 1px solid #ddd;">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="desk-text">All Categories</span></button>
                        <div class="dropdown-menu">
                            @foreach (\App\Models\Category::orderBy('id', 'asc')->get() as $item)
                                @if($item->name != 'Accessories' && $item->name != 'Services' && $item->name != 'Other Products')
                                        <a href="{{ route('products.category', $item->slug) }}"
                                           class="dropdown-item">{{ $item->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <form id="nav-search-bar-form" accept-charset="utf-8" action="{{ route('search') }}"
                          class="nav-searchbar nav-progressive-attribute stop-propagation" method="GET"
                          name="site-search" role="search" style="display: inline-flex">
                        <div class="nav-fill w-300px">
                            <div class="nav-search-field ">
                                <input type="text" id="search" value="" name="q"
                                       autocomplete="off" placeholder="I'm shopping for..." class="form-control nav-input nav-progressive-attribute serach-nav-field"
                                       dir="auto" tabindex="0" aria-label="Search">
                            </div>
                            <div id="nav-iss-attach"></div>
                        </div>
                        <span id="nav-search-submit-text" class="nav-search-submit-text nav-sprite nav-progressive-attribute input-group-text">
                            <button id="nav-search-submit-button" type="submit" class="nav-input nav-progressive-attribute" style="border: none;background: none;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </span>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-12 right-col">

                <div style="display: flex; align-items: center;">
                    <p><i class="fa-solid fa-phone"></i>&nbsp;&nbsp;</p>
                    <div>
                        <p>24/7 SUPPORT</p>
                        <p><strong>{{ get_setting('contact_phone') }}</strong></p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <p><i class="fa-solid fa-user"></i>&nbsp;&nbsp;</p>
                    <div>
                        @auth
                         <p>{{Auth::user()->name}}</p>
                            <a href="{{route('dashboard')}}">
                                <p><strong>My Dashboard</strong></p>
                            </a>
                        @else
                         <p>Account?</p>
                        <a href="{{route('login')}}">
                            <p><strong>Sign in</strong></p>
                        </a>
                        @endauth
                    </div>
                </div>
                <div style="display: flex; align-items: center;" id="cart_items">
                    @include('frontend.partials.cart')
                </div>
            </div>
        </div>
    </div>
    <hr>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100">
            <div class="search-preloader absolute-top-center">
                <div class="dot-loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="search-nothing d-none p-3 text-center fs-16" style="position: relative;z-index: 1000;background-color: #FFFFFF;">
            </div>
            <div id="search-content" class="text-left" style="position: relative;z-index: 10;border: 1px solid #f37539;">
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{(Route::currentRouteName() == 'home')?'active':''}}">
                    <a class="nav-link {{(Route::currentRouteName() == 'home')?'active-link':''}}" href="{{url('/')}}">Home</a>
                </li>
                <li class="nav-item {{(Route::currentRouteName() == 'flash-deals')?'active':''}}">
                    <a class="nav-link {{(Route::currentRouteName() == 'flash-deals')?'active-link':''}}" href="{{ url('flash-deals') }}">Today's Deals</a>
                </li>
                @foreach (\App\Models\Category::orderBy('id', 'asc')->get() as $item)
                    @if($item->name != 'Accessories' && $item->name != 'Services' && $item->name != 'Other Products')
                        <li class="nav-item {{(Request::is('category'.'/'.$item->slug))?'active':''}}">
                        <a href="{{ route('products.category', $item->slug) }}"
                           class="nav-link {{(Request::is('category'.'/'.$item->slug))?'active-link':''}}">{{ $item->name }}</a>
                        </li>
                    @endif
                @endforeach
{{--                @foreach (\App\Models\Category::orderBy('id', 'asc')->where('id', 3)->get() as $item)--}}
{{--                    @if($item->name != 'Accessories')--}}
{{--                        <li class="nav-item {{(Request::is('category'.'/'.$item->slug))?'active':''}}">--}}
{{--                        <a href="{{ route('products.category', $item->slug) }}"--}}
{{--                           class="nav-link {{(Request::is('category'.'/'.$item->slug))?'active-link':''}}">{{ $item->name }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                <li class="nav-item {{(Route::currentRouteName() == 'panic')?'active-link':''}}">--}}
{{--                    <a class="nav-link {{(Route::currentRouteName() == 'panic')?'active-link':''}}" href="{{ route('panic') }}">Emergency Services</a>--}}
{{--                </li>--}}
                <li class="nav-item {{(Route::currentRouteName() == 'aboutus')?'active-link':''}}">
                    <a class="nav-link {{(Route::currentRouteName() == 'aboutus')?'active-link':''}}" href="{{ url('/aboutus') }}">About Us</a>
                </li>
                <li class="nav-item {{(Route::currentRouteName() == 'browse.history')?'active-link':''}}">
                    <a class="nav-link {{(Route::currentRouteName() == 'browse.history')?'active-link':''}}" href="{{ route('browse.history') }}">Browse History</a>
                </li>
                <li class="nav-item {{(Route::currentRouteName() == 'all-merchants.index')?'active-link':''}}">
                    <a class="nav-link {{(Route::currentRouteName() == 'all-merchants.index')?'active-link':''}}" href="{{ route('all-merchants.index') }}">Merchants</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
