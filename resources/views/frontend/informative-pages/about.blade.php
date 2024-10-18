@extends('frontend.informative-pages.layout')
@section('title', 'About us')
@section('content')

    <style>
        .bg-contrast.edge.bottom-right::after {background-image: unset;}
    </style>
    <header class="page header text-contrast bg-primary" style="">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="bold display-md-4 text-contrast mb-4">Carkee Automative Sdn Bhd.</h1>
                    <p class="lead text-contrast">
                        Carkee Automative Sdn Bhd, Malaysia’s new, trendy online tyre and auto parts retailer and distributor. The company was founded in 2020, with various frontend expertise across domestic & international auto parts and maintenance industries.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast">
            <svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
            </svg>
        </div>
    </div>

    <section class="section overview">
        <div class="container">
            <div class="row align-items-center gap-y">
                <div class="col-lg-6 text-center text-md-start">
                    <div class="section-heading"><span
                            class="badge bg-contrast text-primary shadow-sm px-4 py-2 rounded-pill bold mb-2">Succeed with
                            Carkee</span>
                        <h2>Your Professional <br><span class="bold">Car Specialist</span></h2>
                        <p class="lead text-secondary">
                            With our end to end automotive aftermarket platform - carkee.my, we offer a wide range of automotive aftermarket parts and services to our customers, leveraging dynamic e-Commerce advantages, mobility technologies and useful data to provide insightful tools to help our customers make better and more favourable decisions - confidently.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row gap-y">
                        <div class="col-6 col-sm-5 col-md-6 mt-6 ms-lg-auto">
                            <div data-aos="fade-up">
                                <div class="card rounded p-2 p-sm-4 shadow-hover text-center text-md-start">
                                    <i data-feather="code" width="36" height="36" class="stroke-primary"></i>
                                    <p class="bold mb-0">Car Services</p>
                                    <p class="small text-muted">Select service that you need, tyre, services, emergency or carwash</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-5 col-md-6 me-lg-auto">
                            <div data-aos="fade-up">
                                <div class="text-contrast bg-info-gradient card rounded p-2 p-sm-4 shadow-hover text-center text-md-start">
                                    <i data-feather="bar-chart" width="36" height="36" class=""></i>
                                    <p class="bold mb-0">Follow Services</p>
                                    <p class="small text-contrast">Continue with the selected car service and follow the steps of different options selections</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-5 col-md-6 ms-lg-auto">
                            <div data-aos="fade-up">
                                <div class="card rounded p-2 p-sm-4 shadow-hover text-center text-md-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star stroke-primary"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    <p class="bold mb-0">Choose Workshop</p>
                                    <p class="small text-muted">Select workshop in the nearest location</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-5 col-md-6 mt-n6 me-lg-auto">
                            <div data-aos="fade-up">
                                <div class="card rounded p-2 p-sm-4 shadow-hover text-center text-md-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock stroke-primary"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <p class="bold mb-0">Appointment Date and Time</p>
                                    <p class="small text-muted">Select date and time and continue the service and place the order</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container bring-to-front">
            <div class="overflow-hidden shadow rounded text-center overlay overlay-dark alpha-9 p-5 text-contrast image-background cover"
                style="background-image: url(https://picsum.photos/350/200/?random&amp;gravity=south)">
                <div class="content">
                    <div class="section-heading"><i data-feather="cpu" width="36" height="36" stroke-width="2"
                            class="mb-2"></i>
                        <h2 class="bold text-contrast">Discover how Carkee works</h2>
                    </div>
                    <p class="handwritten highlight font-md">Play the video</p><a
                        href="https://www.youtube.com/watch?v=MXghcI8hcWU"
                        class="modal-popup mfp-iframe btn btn-circle btn-lg btn-contrast" data-effect="mfp-fade"><i
                            data-feather="play" width="36" height="36" stroke-width="1" class="ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-light edge top-left">
        <div class="container bring-to-front">
            <div class="section-heading text-center">
                <h2 class="bold">A solution for every need</h2>
                <p class="lead">A car that has been regularly serviced and well-maintained is likely to have a higher resale value than one that has not. This is because buyers are willing to pay more for a car that they know has been well-cared for and is less likely to have hidden problems</p>
            </div>
            <div class="row align-items-center gap-y">
                <div class="col-md-6 col-lg-5">
                    <ul class="list-unstyled">
                        <li class="d-block">
                            <i data-feather="box" width="36" height="36" stroke-width="1" class="stroke-primary me-3"></i>
                            <div class="mt-3 text-center text-md-start">
                                <h5 class="bold text-dark">Choose Services</h5>
                                <p class="mt-0 mb-5">Carkee comes with fully documented HTML, SASS, JS, PHP code, all in a
                                    well organized and structured way.</p>
                            </div>
                        </li>
                        <li class="d-block">
                            <i data-feather="settings" width="36" height="36" stroke-width="1" class="stroke-primary me-3"></i>
                            <div class="mt-3 text-center text-md-start">
                                <h5 class="bold text-dark">Follow The Step In Each Services</h5>
                                <p class="mt-0 mb-5">You&#39;ll get lifetime free updates as we improve or add new
                                    features.</p>
                            </div>
                        </li>
                        <li class="d-block"><i data-feather="award" width="36" height="36" stroke-width="1"
                                class="stroke-primary me-3"></i>
                            <div class="mt-3 text-center text-md-start">
                                <h5 class="bold text-dark">Choose Workshop</h5>
                                <p class="mt-0">In case you need it, We got you covered, with our premium quality fast
                                    support service.</p>
                            </div>
                        </li>
                        <li class="d-block"><i data-feather="award" width="36" height="36" stroke-width="1"
                                class="stroke-primary me-3"></i>
                            <div class="mt-3 text-center text-md-start">
                                <h5 class="bold text-dark">Appointment Date and Time</h5>
                                <p class="mt-0">In case you need it, We got you covered, with our premium quality fast
                                    support service.</p>
                            </div>
                        </li>
                        <li class="d-block"><i data-feather="award" width="36" height="36" stroke-width="1"
                                class="stroke-primary me-3"></i>
                            <div class="mt-3 text-center text-md-start">
                                <h5 class="bold text-dark">Add to Cart and Make Payment</h5>
                                <p class="mt-0">In case you need it, We got you covered, with our premium quality fast
                                    support service.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-5 ms-md-auto">
                    <div class="row gap-y align-items-center text-center">
                        <div class="col-md-4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/2.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-4 mt-md-6">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/3.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mt-md-n4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/8.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mt-md-n4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/7.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-contrast edge top-left">
        <div class="container">
            <div class="row">
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="box" class="stroke-primary" width="36"
                        height="36"></i>
                    <p class="counter bold text-darker font-md mt-0">273</p>
                    <p class="text-secondary m-0">Components</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="download-cloud" class="stroke-primary"
                        width="36" height="36"></i>
                    <p class="counter bold text-darker font-md mt-0">654</p>
                    <p class="text-secondary m-0">Downloads</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="settings" class="stroke-primary"
                        width="36" height="36"></i>
                    <p class="counter bold text-darker font-md mt-0">7941</p>
                    <p class="text-secondary m-0">Followers</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="award" class="stroke-primary" width="36"
                        height="36"></i>
                    <p class="counter bold text-darker font-md mt-0">654</p>
                    <p class="text-secondary m-0">New users</p>
                </div>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-darker">
            <svg viewBox="0 0 2880 48"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
            </svg>
        </div>
    </div>

    <section class="section features bg-darker">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="bold text-contrast">Our features stack</h2>
                <p class="lead text-muted">Take the control of your web with Carkee. You can customize the theme according
                    to your needs or just use the ready-to-use content we made for you</p>
            </div>
            <div class="row gap-y">
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="box" class="stroke-primary" width="36"
                            height="36"></i>
                            <p class="mb-0">Quality</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="settings" class="stroke-primary"
                                width="36" height="36"></i>
                            <p class="mb-0">Reliability</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="award" class="stroke-primary" width="36"
                                height="36"></i>
                            <p class="mb-0">Safety</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="star" class="stroke-primary" width="36"
                                height="36"></i>
                            <p class="mb-0">Innovation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="send" class="stroke-primary" width="36"
                                height="36"></i>
                            <p class="mb-0">Efficiency</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="headphones" class="stroke-primary"
                                width="36" height="36"></i>
                            <p class="mb-0">Customisation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="hard-drive" class="stroke-primary"
                                width="36" height="36"></i>
                            <p class="mb-0">Sustainability</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="shadow-box shadow-hover lift-hover border-0 card bg-dark text-contrast">
                        <div class="card-body text-center"><i data-feather="phone" class="stroke-primary" width="36"
                            height="36"></i>
                            <p class="mb-0">Customer Service</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast">
            <svg viewBox="0 0 2880 48"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
            </svg>
        </div>
    </div>
    
    <section class="section bg-contrast edge bottom-right">
        <div class="container">
            <div class="section-heading text-center"><i data-feather="zap" width="36" height="36"
                    class="mb-2"></i>
                <h2 class="bold">Our Partners</h2>
                <p class="text-secondary lead"></p>
            </div>
            <div class="list-unstyled d-flex flex-wrap justify-content-around">
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-right" data-aos-delay="0" class="mt-6">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/1.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-down-right" data-aos-delay="100" class="mt-4">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/2.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-up-right" data-aos-delay="200" class="mt-5">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/3.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-up" data-aos-delay="300" class="mt-6">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/4.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-down-left" data-aos-delay="400" class="mt-4">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/5.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-up-left" data-aos-delay="0" class="mt-5">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/1.png)"></div>
                </div>
                <div data-aos-easing="ease-in-out-cubic" data-aos="fade-left" data-aos-delay="100" class="mt-6">
                    <div class="shadow-sm shadow-hover lift-hover icon-xxl image-background contain bg-gray-light rounded-circle"
                        style="background-image: url(img/logos/2.png)"></div>
                </div>
            </div>
            {{-- <div class="text-center mt-6">
                <i data-feather="code" width="36" height="36" class="stroke-primary"></i>
            </div> --}}
        </div>
    </section>

    {{-- <section class="section bg-light">
        <div class="container swiper-center-nav bring-to-front pt-0">
            <div class="section-heading text-center">
                <h2 class="bold">Know our team</h2>
                <p class="lead text-secondary">These amazing people have made possible to stay where we are</p>
            </div>
            <div class="swiper-container" data-sw-centered-slides="false" data-sw-show-items="1"
                data-sw-space-between="30"
                data-sw-breakpoints='{"768": {"slidesPerView": 2, "spaceBetween": 30, "slidesPerGroup": 1}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/1.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">Founder &amp; CEO</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">Long time ago, this guy started it all.</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav"><a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a></nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/2.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">Marketing Director</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">The girl that influences our products.</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav"><a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a></nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/3.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">Account Manager</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">The guy that keeps all the numbers in place.</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav">
                                                <a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a>
                                                    </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/4.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">VP of Sales</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">The man that leads the Global Sales team.</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav"><a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a></nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/5.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">Client Support</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">Need any assistance with the product?</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav"><a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a></nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="container-fluid py-0">
                                <div class="row">
                                    <div class="col-md-5 py-9 py-sm-7 overlay overlay-dark alpha-2 image-background cover center-top"
                                        style="background-image: url(img/avatar/team/6.jpg)"></div>
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <h6 class="bold font-l">KAI WEN</h6>
                                            <p class="small mt-0 text-primary text-uppercase mb-5">Lead Developer</p>
                                            <blockquote class="team-quote pt-1"><i class="quote fas fa-quote-left"></i>
                                                <p class="italic ps-4">Geek, manager, and manager of geeks.</p>
                                            </blockquote>
                                            <hr class="w-25 mt-5">
                                            <nav class="nav"><a href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-facebook text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-twitter text-secondary"></i> </a><a
                                                    href="javascript:;" class="nav-item nav-link pb-0"><i
                                                        class="fab fa-dribbble text-secondary"></i></a></nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button swiper-button-next rounded-circle shadow"><i data-feather="arrow-right"></i></div>
            <div class="swiper-button swiper-button-prev rounded-circle shadow"><i data-feather="arrow-left"></i></div>
        </div>
    </section> --}}

    <section class="section bg-light">
        <div class="container">
            <h4 class="bold text-center mb-5">They trust us</h4>
            <div class="row gap-y">
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img
                        src="{{ static_asset('new_front_assets/img/logos/bridgestone-logo.png') }}" alt=""
                        class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img
                        src="{{ static_asset('new_front_assets/img/logos/continental-logo.png') }}" alt=""
                        class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img
                        src="{{ static_asset('new_front_assets/img/logos/toyo-tire-logo.jpeg') }}" alt=""
                        class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
                <div class="col-md-3 col-xs-4 col-6 px-md-5"><img
                        src="{{ static_asset('new_front_assets/img/logos/goodyear-logo.jpg') }}" alt=""
                        class="img-responsive mx-auto op-7" style="max-height: 60px;"></div>
            </div>
        </div>
    </section>

    <section class="section bg-light">
        <div class="container bring-to-front py-0">
            <div class="shadow bg-contrast p-5 rounded">
                <div class="row gap-y align-items-center text-center text-lg-start">
                    <div class="col-12 col-md-12 py-4 px-5"><i data-feather="star" width="36" height="36"
                            class="stroke-primary"></i> <a href="javascript:;"
                            class="mt-4 text-primary d-flex align-items-center">
                            <h4 class="me-3">Join as Professional</h4><i class="fas fa-long-arrow-alt-end"></i>
                        </a>
                        <p class="mt-4">Car service companies typically require a range of professionals with diverse skill sets to design and develop their products and services. This includes designers and developers who work together to create, develop, and maintain the company's offerings</p>
                        <p>To become a designer or developer for a car service company, you will typically need to have the necessary education and training in your field. This may include a degree or certification in graphic design, web design, software engineering, or another related field</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-contrast edge top-left b-b">
        <div class="container">
            <div class="row">
                <div class="col-md-6 b-md-r">
                    <h2>Carkee official <span class="bold">Newsletter</span></h2>
                </div>
                <div class="col-md-5 ms-md-auto">
                    <form action="https://5studios.net/themes/Carkee3/srv/register.php" class="form"
                        data-response-message-animation="slide-in-left">
                        <div class="input-group"><input type="email" name="Subscribe[email]"
                                class="form-control rounded-circle-left" placeholder="Enter your email" required> <button
                                class="btn rounded-circle-right btn-primary" type="submit">Register</button></div>
                    </form>
                    <div class="response-message"><i class="fas fa-envelope font-lg"></i>
                        <p class="font-md m-0">Check your email</p>
                        <p class="response">We sent you an email with a link to get started. You’ll be in your account in
                            no time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
