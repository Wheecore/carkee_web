@extends('frontend.informative-pages.layout')
@section('title', 'Home')
@section('content')

    <header class="header app-landing-2-header section">
        <div class="shapes-container">
            <div class="shape shape-animated" data-aos="fade-down-right" data-aos-duration="1500" data-aos-delay="100"></div>
            <div class="shape shape-animated" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100"></div>
            <div class="shape shape-animated" data-aos="fade-up-left" data-aos-duration="500" data-aos-delay="200"></div>
            <div class="shape shape-animated" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200"></div>
            <div class="animation-shape shape-triangle">
                <div class="animation--rotating"></div>
            </div>
            <div class="animation-shape shape-cross">
                <div class="animation--rotating"></div>
            </div>
            <div class="static-shape shape-ring shape-ring-1">
                <div class="animation animation--rotating"></div>
            </div>
            <div class="static-shape shape-ring shape-ring-2">
                <div class="animation animation--rotating-clockwise"></div>
            </div>
            <div class="static-shape pattern-dots-1"></div>
            <div class="static-shape pattern-dots-2"></div>
            <div class="static-shape background-shape-main"></div>
        </div>
        <div class="container">
            <div class="row align-items-center gap-y">
                <div class="col-md-6">
                    <span class="rounded-pill shadow-sm bg-contrast text-dark bold py-2 px-4">
                        <i class="far fa-lightbulb text-primary me-2"></i> 
                        <span class="text-primary">CAR SERVICING AT YOUR FINGERTIPS.</span>
                    </span>
                    <h1 class="display-4 display-md-2 mt-3 text-logo-blue"><span class="bold">CARKEE.</span></h1>
                    <p class="lead bold text-primary">Your Professional Car Specialist</p>
                    <p class="lead">Speed & secure, Flexibility & Scalability, and More Efficiency.</p>
                    <div class="hero-form shadow-lg rounded-pill border mt-5">
                        <form action="#">
                            <div class="input-group-register">
                                <input type="text" class="form-control rounded-pill" placeholder="Your Email"> 
                                <button type="submit" class="btn btn-primary more-link rounded-pill">
                                    <i data-feather="mail" class="d-inline d-md-none"></i> 
                                    <span class="d-none d-md-inline">Submit Quote</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="device-twin ms-auto align-items-center">
                        <div class="mockup absolute" data-aos="fade-left">
                            <div class="screen">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/splashscreen.png') }}" alt="...">
                            </div>
                            <span class="button"></span>
                        </div>
                        <div class="iphone-x light front me-0">
                            <div class="screen shadow-box">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/home.png') }}" alt="...">
                            </div>
                            <div class="notch"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="partners">
        <div class="container pt-0 pb-5 b-b">
            <div class="swiper-container" data-sw-show-items="5" data-sw-space-between="30" data-sw-autoplay="2500" data-sw-loop="true">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/bridgestone-logo.png') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/continental-logo.png') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/toyo-tire-logo.jpeg') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/goodyear-logo.jpg') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/dunlop-logo.png') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ static_asset('new_front_assets/img/logos/michelin-logo.jpg') }}" class="img-responsive" style="max-height: 60px">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section overflow-hidden">
        <div class="container bring-to-front">
            <div class="row gap-y align-items-center">
                <div class="col-md-6 col-lg-5 me-lg-auto position-relative">
                    <div class="center-xy op-1">
                        <div class="shape shape-background rounded-circle shadow-lg bg-info"
                            style="width: 600px; height: 600px;" data-aos="zoom-in"></div>
                    </div>
                    <div class="device-twin mx-auto align-items-center">
                        <div class="mockup absolute" data-aos="fade-left">
                            <div class="screen">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/user-dashboard.png') }}" alt="...">
                            </div>
                            <span class="button"></span>
                        </div>
                        <div class="iphone-x front me-0">
                            <div class="screen shadow-box">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/details.png') }}" alt="...">
                            </div>
                            <div class="notch"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-start">
                    <div class="section-heading"><i data-feather="star" width="36" height="36" class="stroke-primary"></i></i>
                        <h2 class="bold">Ton of benefits</h2>
                    </div>
                    <div class="row gap-y">
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-start">
                                <div class="mx-auto ms-md-0 me-md-3"><i data-feather="code" width="36" height="36" class="stroke-primary"></i></div>
                                <div class="flex-fill mt-3 mt-md-0">
                                    <h5 class="bold mt-0 mb-1">Car Services</h5>
                                    <p class="m-0 d-md-none d-lg-block">Car services are an essential part of owning a vehicle. They help ensure safety, improve performance, increase lifespan, save money, and maintain the value of the car</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-start">
                                <div class="mx-auto ms-md-0 me-md-3"><i data-feather="star" width="36" height="36" class="stroke-primary"></i></div>
                                <div class="flex-fill mt-3 mt-md-0">
                                    <h5 class="bold mt-0 mb-1">Tyre Installation</h5>
                                    <p class="m-0 d-md-none d-lg-block">Tyre installation is essential for optimal vehicle performance, safety, and comfort. Installing high-quality tires that are suited to the vehicle and driving conditions can provide a range of benefits, including improved safety, fuel efficiency, comfort, lifespan, and performance</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-start">
                                <div class="mx-auto ms-md-0 me-md-3"><i data-feather="wind" width="36" height="36" class="stroke-primary"></i></div>
                                <div class="flex-fill mt-3 mt-md-0">
                                    <h5 class="bold mt-0 mb-1">Car Inspection</h5>
                                    <p class="m-0 d-md-none d-lg-block">Car inspections are an important part of owning a vehicle. They help ensure safety, save money, meet legal requirements, and maintain the value of the car</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-start">
                                <div class="mx-auto ms-md-0 me-md-3"><i data-feather="clock" width="36" height="36" class="stroke-primary"></i></div>
                                <div class="flex-fill mt-3 mt-md-0">
                                    <h5 class="bold mt-0 mb-1">Emergency Service</h5>
                                    <p class="m-0 d-md-none d-lg-block">Car emergency services can provide drivers with a range of benefits, including peace of mind, safety, time and convenience, and cost savings.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-start">
                                <div class="mx-auto ms-md-0 me-md-3"><i data-feather="wind" width="36" height="36" class="stroke-primary"></i></div>
                                <div class="flex-fill mt-3 mt-md-0">
                                    <h5 class="bold mt-0 mb-1">Car Accessories</h5>
                                    <p class="m-0 d-md-none d-lg-block">Car accessories can provide a range of benefits that enhance the ownership experience and improve the functionality, safety, and appearance of a vehicle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section path-success">
        <div class="shapes-container">
            <div class="shape-ring absolute right top" data-aos="fade-up"></div>
        </div>
        <div class="container bring-to-front">
            <div class="row gap-y align-items-center text-center text-lg-start">
                <div class="col-md-6 col-lg-5 ms-lg-auto order-md-2">
                    <div class="device-twin ms-auto align-items-center">
                        <div class="mockup absolute right" data-aos="fade-right">
                            <div class="screen">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/map.png') }}" alt="...">
                            </div>
                            <span class="button"></span>
                        </div>
                        <div class="iphone-x front ms-0">
                            <div class="screen shadow-box">
                                <img src="{{ static_asset('new_front_assets/img/screens/app/emerngency.png') }}" alt="...">
                            </div>
                            <div class="notch"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-start">
                    <div class="section-heading">
                        <div class="d-flex align-items-center mb-3">
                            <i data-feather="wind" width="36" height="36" class="stroke-primary"></i>
                            <span class="badge bg-contrast shadow-sm py-2 px-4 text-primary rounded-pill">4 Simple Steps</span>
                        </div>
                        <h2 class="bold">Purchase Flow</h2>
                    </div>
                    <ul class="list-unstyled">
                        <li class="d-flex flex-column flex-md-row align-items-start">
                            <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-md-3">
                                <i data-feather="bar-chart" width="36" height="36" class="stroke-primary"></i>
                            </div>
                            <div class="media-body mt-3 mt-md-0">
                                <h5 class="bold mt-0 mb-1">Choose Services</h5>
                                <p class="m-0">Select service that you need, tyre, services, emergency or carwash</p>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-md-row align-items-start mt-5">
                            <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-md-3">
                                <i data-feather="bar-chart" width="36" height="36" class="stroke-primary"></i>
                            </div>
                            <div class="media-body mt-3 mt-md-0">
                                <h5 class="bold mt-0 mb-1">Follow The Step In Each Services</h5>
                                <p class="m-0">Each services will have different flow </p>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-md-row align-items-start mt-5">
                            <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-md-3">
                                <i data-feather="bar-chart" width="36" height="36" class="stroke-primary"></i>
                            </div>
                            <div class="media-body mt-3 mt-md-0">
                                <h5 class="bold mt-0 mb-1">Choose Workshop, Appointment Date and Time</h5>
                                <p class="m-0">Choose your nearby workshop and select date and time </p>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-md-row align-items-start mt-5">
                            <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-md-3">
                                <i data-feather="bar-chart" width="36" height="36" class="stroke-primary"></i>
                            </div>
                            <div class="media-body mt-3 mt-md-0">
                                <h5 class="bold mt-0 mb-1">Add to Cart and Make Payment</h5>
                                <p class="m-0">Proceed to cart page, check your item and proceed with different kind of payment method </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section app-safety">
        <div class="shapes-container">
            <div class="shape shape-circle">
                <div data-aos="fade-up-left"></div>
            </div>
            <div class="shape shape-triangle" data-aos="fade-up-right" data-aos-delay="200">
                <div></div>
            </div>
            <div class="shape pattern pattern-dots"></div>
        </div>
        <div class="container">
            <div class="row gap-y align-items-center">
                <div class="col-md-5 order-md-last ms-auto">
                    <div class="section-heading">
                        <p class="text-primary bold">We keep your hands clean</p>
                        <h2 class="bold">Our Professional Services</h2>
                        <p class="lead text-muted">Regular car services can help identify and address potential safety hazards, such as worn brakes or faulty steering components. This can help prevent accidents and ensure the safety of everyone on the road</p>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3"><i data-feather="activity" class="stroke-primary"></i></div>
                        <div class="flex-fill">
                            <h5 class="bold">Car Services</h5>
                            <p class="m-0">Regular car services can help ensure that a vehicle is running smoothly, with optimal engine performance, improved fuel efficiency, and better handling and acceleration</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mt-5">
                        <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3"><i data-feather="upload-cloud" class="stroke-primary"></i></div>
                        <div class="flex-fill">
                            <h5 class="bold">Tyre Installation</h5>
                            <p class="m-0">Properly installed tires are essential for safe driving. The correct tires for a vehicle provide better grip, handling, and braking, which can help prevent accidents</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mt-5">
                        <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3"><i data-feather="package" class="stroke-primary"></i></div>
                        <div class="flex-fill">
                            <h5 class="bold">Car Inspection</h5>
                            <p class="m-0">A car inspection can identify potential safety hazards, such as faulty brakes or tires, that could put the driver and passengers at risk. By identifying and addressing these issues early, car inspections can help prevent accidents and ensure the safety of everyone on the road</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mt-5">
                        <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3"><i data-feather="package" class="stroke-primary"></i></div>
                        <div class="flex-fill">
                            <h5 class="bold">Emergency Service</h5>
                            <p class="m-0">Knowing that help is just a phone call away can provide drivers with peace of mind while on the road. They can feel confident that if they experience an unexpected breakdown or other issue, they will be able to quickly receive assistance</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mt-5">
                        <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3"><i data-feather="package" class="stroke-primary"></i></div>
                        <div class="flex-fill">
                            <h5 class="bold">Car Accessories</h5>
                            <p class="m-0">Car accessories can be used to personalize a vehicle and make it unique to the owner's tastes and preferences. This can include adding custom wheels, decals, or interior accents</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row gap-y align-items-center text-center">
                        <div class="col-md-4 mt-md-6">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/6.png') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/2.png') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mt-md-6">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/3.png') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mt-md-n4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/8.png') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mt-md-n4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/7.png') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mt-md-n4">
                            <div class="figure shadow rounded overflow-hidden border">
                                <img class="img-responsive" src="{{ static_asset('new_front_assets/img/property/4.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-primary">
            <svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path></svg>
        </div>
    </div>

    <section class="section counters bg-primary text-contrast">
        <div class="container pb-9">
            <div class="section-heading text-center">
                <h2 class="bold text-contrast">Carkee Automotive Sdn Bhd</h2>
                <p class="lead">Carkee Automotive Sdn Bhd, Malaysia’s new, trendy online tyre and auto parts retailer and distributor. The company was founded in 2020, with various frontend expertise across domestic & international auto parts and maintenance industries. With our end to end automotive aftermarket platform - carkee.my, we offer a wide range of automotive aftermarket parts and services to our customers, leveraging dynamic e-Commerce advantages, mobility technologies and useful data to provide insightful tools to help our customers make better and more favourable decisions - confidently.</p>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="box" width="36" height="36"></i>
                    <p class="counter bold font-md mt-0">273</p>
                    <p class="m-0">Components</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="download-cloud" width="36" height="36"></i>
                    <p class="counter bold font-md mt-0">654</p>
                    <p class="m-0">Downloads</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="anchor" width="36" height="36"></i>
                    <p class="counter bold font-md mt-0">7941</p>
                    <p class="m-0">Followers</p>
                </div>
                <div class="col-xs-4 col-md-3 text-center"><i data-feather="award" width="36" height="36"></i>
                    <p class="counter bold font-md mt-0">654</p>
                    <p class="m-0">New users</p>
                </div>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast">
            <svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path></svg>
        </div>
    </div>

    <section class="section mt-n6" id="features">
        <div class="container pt-0">
            <div class="bg-contrast shadow rounded p-5">
                <div class="row gap-y justify-content-center">
                    <div class="col-md-4">
                        <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center me-3">
                            <i data-feather="upload-cloud" width="36" height="36" class="stroke-contrast"></i>
                        </div>
                        <h4 class="semi-bold mt-4 text-capitalize">Tyre Installation</h4>
                        <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                        <p class="regular text-muted">Installing the right tires for a vehicle can improve its performance, providing better traction, handling, and responsiveness</p>
                    </div>
                    <div class="col-md-4">
                        <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center me-3">
                            <i data-feather="package" width="36" height="36" class="stroke-contrast"></i>
                        </div>
                        <h4 class="semi-bold mt-4 text-capitalize">Car Inspection</h4>
                        <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                        <p class="regular text-muted">Regular car inspections can help catch small problems before they become larger and more expensive to fix, preventing major repairs or even the need for a new car.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="rounded gradient gradient-primary-light icon-xl shadow d-flex align-items-center justify-content-center me-3">
                            <i data-feather="package" width="36" height="36" class="stroke-contrast"></i>
                        </div>
                        <h4 class="semi-bold mt-4 text-capitalize">Emergency Service</h4>
                        <hr class="w-25 bw-2 border-alternate mt-3 mb-4">
                        <p class="regular text-muted">Save drivers time and inconvenience by providing on-the-spot assistance. They can help drivers avoid the hassle of contacting a reliable mechanic or towing service</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section why-people-love-us">
        <div class="shapes-container overflow-clear">
            <div class="shape shape-circle shape-circle-1">
                <div data-aos="fade-up-left"></div>
            </div>
            <div class="shape shape-circle shape-circle-2">
                <div data-aos="fade-up-right" data-aos-delay="200"></div>
            </div>
            <div class="shape pattern pattern-dots pattern-dots-1"></div>
            <div class="shape shape-triangle shape-animated">
                <div class="animation--rotating"></div>
            </div>
        </div>
        <div class="container">
            <div class="row gap-y">
                <div class="col-md-6 order-md-last">
                    <div class="section-heading">
                        <p class="text-primary bold">Get Ready</p>
                        <h2 class="bold heading-line">Inspection With Our Professional & Trusted Inspectors</h2>
                    </div>
                    <ul class="list-unstyled">
                        <li>
                            <div class="d-flex align-items-start pb-3">
                                <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3">
                                    <i data-feather="package" class="stroke-primary"></i>
                                </div>
                                <div class="flex-fill">
                                    <h5 class="bold">Tyre Installation</h5>
                                    <p>Condition of a vehicle to ensure that it meets safety</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start pb-3">
                                <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3">
                                    <i data-feather="package" class="stroke-primary"></i>
                                </div>
                                <div class="flex-fill">
                                    <h5 class="bold">Car Inspection</h5>
                                    <p>Additional components or features that can be added to a vehicle to enhance its functionality, appearance, or convenience</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start pb-3">
                                <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center me-3">
                                    <i data-feather="bar-chart" class="stroke-primary"></i>
                                </div>
                                <div class="flex-fill">
                                    <h5 class="bold">Emergency Service</h5>
                                    <p>Fitting new or replacement tyres onto a vehicle's rims or wheels</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 position-relative">
                    <div class="bubble bubble-left center-x-md">
                        <figure class="rounded overflow-hidden shadow" data-aos="zoom-in">
                            <img src="{{ static_asset('new_front_assets/img/screens/app/pieces/4.png') }}" class="img-responsive">
                        </figure>
                    </div>
                    <figure class="bubble bubble-right rounded overflow-hidden shadow">
                        <img src="{{ static_asset('new_front_assets/img/screens/app/pieces/5.png') }}" class="img-responsive" data-aos="fade-left">
                    </figure>
                    <div class="iphone-x">
                        <div class="screen shadow-box">
                            <img src="{{ static_asset('new_front_assets/img/screens/app/home.png') }}" alt="...">
                        </div>
                        <div class="notch"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="section bg-light edge bottom-right">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Do you have <span class="bold">questions?</span></h2>
                    <p class="lead">Not sure how this template can help you? Wonder why you need to buy our theme?</p>
                    <p class="text-muted">Here are the answers to some of the most common questions we hear from our
                        appreciated customers</p>
                </div>
                <div class="col-md-8">
                    <div class="accordion accordion-clean" id="faqs-accordion">
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse"
                                    data-bs-target="#v1-q1"><i class="fas fa-angle-down angle"></i> What does the package
                                    include?</a></div>
                            <div id="v1-q1" class="collapse show" data-bs-parent="#faqs-accordion">
                                <div class="card-body">When you buy Carkee, you get all you see in the demo but the images.
                                    We include SASS files for styling, complete JS files with comments, all HTML variations.
                                    Besides we include all mobile PSD mockups.</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#v1-q2"><i
                                        class="fas fa-angle-down angle"></i> What is the typical response time for a
                                    support question?</a></div>
                            <div id="v1-q2" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Since you report us a support question we try to make our best to
                                    find out what is going on, depending on the case it could take more or les time, however
                                    a standard time could be minutes or hours.</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#v1-q3"><i
                                        class="fas fa-angle-down angle"></i> What do I need to know to customize this
                                    template?</a></div>
                            <div id="v1-q3" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Our documentation give you all you need to customize your copy.
                                    However you will need some basic web design knowledge (HTML, Javascript and CSS)</div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header"><a href="#" class="card-title btn collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#v1-q4"><i
                                        class="fas fa-angle-down angle"></i> Can I suggest a new feature?</a></div>
                            <div id="v1-q4" class="collapse" data-bs-parent="#faqs-accordion">
                                <div class="card-body">Definitely <span class="bold">Yes</span>, you can contact us to
                                    let us know your needs. If your suggestion represents any value to both we can include
                                    it as a part of the theme or you can request a custom build by an extra cost. Please
                                    note it could take some time in order for the feature to be implemented.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section app-download">
        <div class="container bring-to-front">
            <div class="shadow-lg bg-primary p-5 rounded">
                <div class="section-heading text-center">
                    <p class="badge bg-contrast text-dark rounded-pill shadow-sm bold py-2 px-4">Start today</p>
                    <h2 class="bold text-contrast">Download the App</h2>
                    <p class="text-contrast">Download the app to access its features and functionality on your mobile device, such as browsing content, creating an account, making purchases, or interacting with other users, depending on the app's specific purpose and design.</p>
                </div>
                <nav class="nav flex-column flex-md-row justify-content-center align-items-center mt-5" id="app-download">
                    <a href="{{ env('APPSTORE_LINK') }}" class="nav-link py-3 px-4 btn btn-rounded btn-download btn-dark text-contrast me-0 me-md-4 mb-4 mb-md-0">
                        <img src="{{ static_asset('new_front_assets/img/svg/apple.svg') }}" class="icon icon-md" alt="...">
                        <p class="ms-2">
                            <span class="small bold">Get it on the</span> 
                            <span class="d-block bold text-contrast">App Store</span>
                        </p>
                    </a>
                    <a href="{{ env('PLAYSTORE_LINK') }}" class="nav-link py-3 px-4 btn btn-rounded btn-download btn-light text-darker">
                        <img src="{{ static_asset('new_front_assets/img/svg/google-play.svg') }}" class="icon icon-md" alt="...">
                        <p class="ms-2">
                            <span class="small bold">Download on</span> 
                            <span class="d-block bold text-darker">Google Play</span>
                        </p>
                    </a>
                </nav>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container pt-5">
            <div class="d-flex align-items-center flex-column flex-md-row">
                <div class="text-center text-md-start">
                    <p class="light mb-0 text-primary lead">Ready to get started?</p>
                    <h2 class="mt-0 bold">Create an account now</h2>
                </div>
                <a href="#" class="btn btn-primary btn-rounded mt-3 mt-md-0 ms-md-auto">Create Carkee account</a>
            </div>
        </div>
    </section>

@endsection
