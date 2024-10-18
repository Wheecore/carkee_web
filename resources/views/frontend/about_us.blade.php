@extends('frontend.layouts.app')
@section('content')
    <section class="mb-4">
    <!-- Hero section -->
    <section id="hero-section">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-1"></div> -->
                <div class="col-md-5 left">
                    <h1>Carkee</h1>
                    <p>Your Professional Car Specialist  <br> </p>
                    <a href="#" class="btn">Contact Us</a>
                    <div class="row">
                        <div class="col-md-12 icons">
                            <div class="row speed-lock">
                                <div class=""><i class="material-icons">lock</i></div>
                                <div class="span"><span>Speed & <br> Secure</span></div>
                            </div>
                            <div class="row speed-lock">
                                <div class=""><i class="material-icons">fit_screen</i></div>
                                <div class="span"><span>Flexibility & <br> Scalability</span></div>
                            </div>
                            <div class="row speed-lock">
                                <div class=""><i class="material-icons">workspaces</i></div>
                                <div class="span"><span>More <br> Efficiency </span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <img src="{{static_asset('front_assets/img/hero.jpg')}}" alt="Check link" class="img-fluid">
                </div>
                <!-- <div class="col-md-1"></div> -->
            </div>
        </div>
    </section>

    <!-- Save money section -->
    <section id="money-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>About  
<br> Triune Autotech Sdn Bhd.</h1>
                </div>
                <div class="col-md-6">
                    <p>Triune Autotech Sdn Bhd, Malaysia’s new, trendy online tyre and auto parts retailer and distributor. The company was founded in 2020, with various frontend expertise across domestic & international auto parts and maintenance industries. 

With our end to end automotive aftermarket platform - carkee.my, we offer a wide range of automotive aftermarket parts and services to our customers, leveraging dynamic e-Commerce advantages, mobility technologies and useful data to provide insightful tools to help our customers make better and more favourable decisions - confidently. 
</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our property section -->
    <section id="property-section">
        <div class="container">
            <h1>Our Professional <br> Services</h1>
            <p>We keep your hand clean</p>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{static_asset('front_assets/img/property 1.jpg')}}" alt="Check link" class="img-fluid">
                    <h2>Car<br>Services</h2>
                    <p>I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{static_asset('front_assets/img/property 2.jpg')}}" alt="Check link" class="img-fluid">
                    <h2>Tyre <br> Installation</h2>
                    <p>I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{static_asset('front_assets/img/property 3.jpg')}}" alt="Check link" class="img-fluid">
                    <h2>Car Inspection</h2>
                    <p>I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                </div>
            </div>
            <div class="row row2">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <img src="{{static_asset('front_assets/img/a1.jpg')}}" alt="Check link" class="img-fluid">
                    <h2>Emergency <br> Service</h2>
                    <p>I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <img src="{{static_asset('front_assets/img/a2.jpg')}}" alt="Check link" class="img-fluid">
                    <h2>Car Accessories </h2>
                    <p>I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </section>

    <!-- Inspection process section -->
    <section id="process-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{static_asset('front_assets/img/picture.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h1>4 Simple Steps Purchase Flow</h1>
                    <h4><i class="material-icons">grid_view</i> 1. Choose Services</h4>
                    <h4><i class="material-icons">folder</i> 2. Follow The Step In Each Services.</h4>
                    <h4><i class="material-icons">edit</i> 3. Choose Workshop, Appointment Date and Time</h4>
                    <h4><i class="material-icons">edit</i> 4. Add to Cart and Make Payment</h4>
                </div>
            </div>
        </div>
    </section>

<style>
    .brands_images img{
        height: 60px;
    }
</style>
    <!-- Industry section -->
    <section id="industry-section">
        <div class="container">
            <h1>Trusted Among Industry Leaders</h1>
            <p> <br></p>
            <div class="row text-center brands_images">
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry1.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry2.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry3.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry4.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry5.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry6.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry7.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry8.jpg')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry9.jpg')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry10.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry11.jpg')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry12.png')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry13.jpeg')}}" alt="Check link" class="img-fluid">
                </div>
                <div class="col-md-3 mb-5">
                    <img src="{{static_asset('front_assets/img/brands/industry14.png')}}" alt="Check link" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Our client section -->
    <section id="client-section">
        <div class="container">
            <h1>What Our Clients Say</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="box">
                        <p><i class="material-icons">more_horiz</i></p>
                        <p class="para">“GOOD PLATFORM”</p>
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{static_asset('front_assets/img/gf.png')}}" alt="Check link" class="img-fluid">
                            </div>
                            <div class="col-md-7">
                                <h5>KAI WEN</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <p><i class="material-icons">more_horiz</i></p>
                        <p class="para">“VERY GOOD PROCESS FLOW”</p>
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{static_asset('front_assets/img/utu.png')}}" alt="Check link" class="img-fluid img2">
                            </div>
                            <div class="col-md-7">
                                <h5>KAI WEN</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <p><i class="material-icons">more_horiz</i></p>
                        <p class="para">“GOOD ONE”</p>
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{static_asset('front_assets/img/utu.png')}}" alt="Check link" class="img-fluid img2">
                            </div>
                            <div class="col-md-7">
                                <h5>KAI WEN</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Choose Us section -->
    <!--<section id="choose-section">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-5">-->
    <!--                <h1>Why Choose Us</h1>-->
    <!--                <p><i class="material-icons">fiber_manual_record</i><b>Peace of Mind</b> - Our professional home inspection will give you confidence and peace of mind in knowing the true condition of your new property.</p>-->
    <!--                <p><i class="material-icons">fiber_manual_record</i> <b>Cost and Time Savings</b> - We use specialized tools to identify high priority and unexpected defects to help save your repair costs in the future</p>-->
    <!--                <p><i class="material-icons">fiber_manual_record</i> <b>Professional Inspectors</b> - Our inspectors are well-trained to thoroughly examine and document priority and common defects in your new property.</p>-->
    <!--                <p><i class="material-icons">fiber_manual_record</i> <b>Time Efficient</b> - We conduct a thorough home inspection in 3-4 hours and provide a comprehensive defect report within 3 days.</p>-->
    <!--                <p><i class="material-icons">fiber_manual_record</i> <b>Personal Briefing</b> - Property Owners are invited to attend the end of the inspection where our inspectors will give a verbal report on identified products.</p>-->
    <!--                <a href="#" class="btn">See More</a>-->
    <!--            </div>-->
    <!--            <div class="col-md-7 right">-->
    <!--                <iframe width="100%" height="315" src="https://www.youtube.com/embed/XmhZBKxeB0U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    <!-- Last section -->
    <section id="last-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Get Ready to Inspection With Our <br> Professional & Trusted Inspectors</h1>
                    <a href="#" class="btn">Get Started</a><br>
                    <img src="{{static_asset('front_assets/img/get ready.png')}}" alt="Check link" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    </section>
@endsection
