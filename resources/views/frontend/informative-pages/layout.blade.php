<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    <link rel="icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/lib.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/main.min.css') }}">
     <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
</head>

<body>

    <nav class="st-nav navbar main-nav navigation fixed-top" id="main-nav">
        <div class="container">
            <ul class="st-nav-menu nav navbar-nav">
                <li class="st-nav-section nav-item">
                    @php
                        $header_logo = get_setting('header_logo');
                    @endphp
                    <a href="{{ url('/') }}" class="navbar-brand">
                    @if($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="logo logo-sticky">
                    @else
                       <img src="{{ static_asset('new_front_assets/img/logo.png') }}" alt="Carkee" class="logo logo-sticky">
                    @endif
                    </a>
                </li>
                <li class="st-nav-section st-nav-primary stick-right nav-item">
                    <a class="st-root-link nav-link" href="{{ url('/') }}">Home</a>
                    <a class="st-root-link nav-link" href="{{ url('about') }}">About</a>
                    {{-- <a class="st-root-link nav-link" href="{{ url('team') }}">Team</a> --}}
                    <a class="st-root-link nav-link" href="{{ url('faq') }}">FAQ</a>
                    <a class="st-root-link nav-link" href="{{ url('contact') }}">Contact</a>
                </li>
                <li class="st-nav-section st-nav-secondary nav-item">
                    @if (Auth::check())
                        @if (Auth::user()->user_type == 'admin')
                            <a class="btn btn-rounded btn-outline me-3 px-3" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-sign-in-alt d-none d-md-inline me-md-0 me-lg-2"></i>
                                <span class="d-md-none d-lg-inline">Dashboard</span>
                            </a>
                        @else
                            <a class="btn btn-rounded btn-outline me-3 px-3" href="{{ route('dashboard') }}">
                                <i class="fas fa-sign-in-alt d-none d-md-inline me-md-0 me-lg-2"></i>
                                <span class="d-md-none d-lg-inline">Home</span>
                            </a>
                        @endif
                    @else
                        <a class="btn btn-rounded btn-outline me-3 px-3" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt d-none d-md-inline me-md-0 me-lg-2"></i>
                            <span class="d-md-none d-lg-inline">Sign in</span>
                        </a>
                    @endif
                </li><!-- Mobile Navigation -->
                <li class="st-nav-section st-nav-mobile nav-item">
                    <button class="st-root-link navbar-toggler" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="st-popup">
                        <div class="st-popup-container">
                            <a class="st-popup-close-button">Close</a>
                            <div class="st-dropdown-content-group">
                                <a class="regular text-primary" href="{{ url('/') }}"><i
                                        class="far fa-building me-2"></i> Home </a>
                                <a class="regular text-success" href="{{ url('about') }}"><i
                                        class="far fa-envelope me-2"></i> About </a>
                                {{-- <a class="regular text-warning" href="{{ url('team') }}"><i
                                        class="fas fa-hand-holding-usd me-2"></i> Team </a> --}}
                                <a class="regular text-info" href="{{ url('faq') }}"><i
                                        class="far fa-question-circle me-2"></i> FAQ</a>
                                <a class="regular text-info" href="{{ url('contact') }}"><i
                                        class="far fa-question-circle me-2"></i> Contact</a>
                            </div>
                            <div class="st-dropdown-content-group bg-light b-t"><a href="{{ route('login') }}">Sign in
                                    <i class="fas fa-arrow-right"></i></a></div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main class="overflow-hidden">
        @yield('content')
    </main>
    <footer class="site-footer section bg-darker text-contrast text-center bg-contrast">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="container py-4">
                    @if($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="logo">
                    @else
                        <img src="{{ static_asset('new_front_assets/img/logo.png') }}" alt="Carkee" class="logo">
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="container py-4">
                    <p class="lead">Don't wait - <span class="bold">Get Services</span> NOW!</p>
                    <p class="copyright my-5">© {{ date('Y') }} <em>by</em> <span class="brand bold"> Carkee Automative Sdn Bhd. (1498396-V)</span></p>
                    <hr class="mt-5 bg-secondary op-5">
                    <nav class="nav social-icons justify-content-center mt-4">
                        <a href="#" class="btn text-contrast btn-circle btn-sm brand-facebook me-3"><i
                                class="fab fa-facebook"></i></a>
                        <a href="#" class="btn text-contrast btn-circle btn-sm brand-twitter me-3"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="btn text-contrast btn-circle btn-sm brand-youtube me-3"><i
                                class="fab fa-youtube"></i></a>
                        <a href="#" class="btn text-contrast btn-circle btn-sm brand-pinterest"><i
                                class="fab fa-pinterest"></i></a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="container py-4">
                <h4 class="text-uppercase text-white" style="text-decoration: underline;text-decoration-color: #feaa02;text-decoration-style: double;">Links</h4>
                    <ul class="list-unstyled footer-link mt-4">
                        @foreach (\App\Models\Page::all() as $key => $page)
                            @if ($page->type == 'home_page' || $page->slug == 'aboutus' || $page->slug == 'sellerpolicy')
                               @php continue; @endphp
                            @endif
                            <li class="mb-2 fs-6">
                            <a href="{{ route('custom-pages.show_custom_page', $page->slug) }}" class="text-reset">{{ $page->title }}</a>
                            </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ static_asset('new_front_assets/js/core.min.js') }}"></script>
    <script src="{{ static_asset('new_front_assets/js/lib.min.js') }}"></script>
    <script src="{{ asset('new_front_assets/js/main.min.js') }}"></script>
    <script>
        $('.navbar-toggler').click(function() {
            $(".st-nav-mobile").addClass('st-popup-active');
        });
        $('.st-popup-close-button').click(function() {
            $(".st-nav-mobile").removeClass('st-popup-active');
        });
    </script>
    @yield('script')
</body>

</html>
