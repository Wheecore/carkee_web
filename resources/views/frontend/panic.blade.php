@extends('frontend.layouts.app')

@section('content')
    <style>
        .topnav {
            border-radius: 15px;
            background-color: #00ACB4;
            overflow: hidden;
        }

        .features {
            border-radius: 15px;
            width: 1024px;
            height: 320px;
            align: center;
            padding: 0px;
            background-color: white;
            padding: 20px
        }

        .Box1 {
            border-radius: 15px;
            width: 1024px;
            height: 320px;
            align: center;
            padding: 0px;
            background-color: white;
            padding: 20px
        }

        .actions {
            width: 130px;
            height: 120px;
            float: left;
            margin-right: 15px;
            margin-left: 55px;

        }

        #action1 {
            color: #393E46;
            background-color: white
        }

        #action2 {
            color: #393E46;
            background-color: white
        }

        #action3 {
            color: #393E46;
            background-color: white
        }

        #action4 {
            color: #393E46;
            background-color: white
        }

        #action5 {
            color: #393E46;
            background-color: white
        }

        .safetyx {
            border-radius: 15px;
            width: 75%;
            height: 260px;
            background-color: #393E46;
            color: white;
            padding: 25px;

        }

        .statsx {
            border-radius: 15px;
            width: 75%;
            height: 175px;
            background-color: #A6A8AB;
            color: white;
        }
    </style>

    <br>
    <div class="container">
        <center>
            <img align="center" src="https://reginadmedia.com/wp-content/uploads/2019/03/rwf-logo.jpg" alt="logo"
                width="250" height="250">

            <!---Box1 - Hand with Phone - Top Section--->

            <div class="">
                <div class="routes"><img align="left"
                        src="https://reginadmedia.com/wp-content/uploads/2019/04/hand-holding-routes-image-x.png"
                        alt="phone" width="325" height="314">
                    <h5>Dirty Hands App</h5>
                    <br>
                    <h4>
                        <font color="393E46">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores atque facilis inventore
                            iusto minima praesentium ratione sit ullam. Hic itaque laborum magnam nostrum, numquam odit
                            perspiciatis quod reprehenderit! Cum, sapiente?
                        </font>
                    </h4>
                </div>
            </div>
            <br><br><br>
            <!--Features-->
            <section id="section1">
                <h5>Features</h5>
            </section>
            <img src="https://reginadmedia.com/wp-content/uploads/2019/04/Routes-4-pic-Image.png" alt="features"
                style="width: -webkit-fill-available;">

            <!---Video---->
            <section id="section4">
                <h2 style="text-align:center"><b>Video</b></h2>
            </section>

            <div class="video">
                <div class="container">
                    <video height="600" style="width: -webkit-fill-available;" controls autoplay loop>
                        <source src="https://reginadmedia.com/wp-content/uploads/2019/04/Run-15748.mp4" type="video/mp4"
                            alt="video">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <!---Download---->
                <h5> Download Now on an iphone or android</h5><br><img align="center"
                    src="https://cdn.shopify.com/s/files/1/0907/4320/files/Disponible-app-storeEN.png" alt="downloads"
                    width="150" height="100" class="mb-4">

                <!-----VERIFIED COMPLIANT---->
            </div>

        </center>
    </div>
@endsection
@section('script')
    <script>
        // Page Scroll
        jQuery(document).ready(function($) {
            $('a[href*=#]:not([href=#])').click(function() {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') ||
                    location.hostname == this.hostname) {

                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 32
                        }, 1000);
                        return false;
                    }
                }
            });
        });

        // Fixed Nav
        jQuery(document).ready(function($) {
            $(window).scroll(function() {
                var scrollTop = 142;
                if ($(window).scrollTop() >= scrollTop) {
                    $('nav').css({
                        position: 'fixed',
                        top: '0'
                    });
                }
                if ($(window).scrollTop() < scrollTop) {
                    $('nav').removeAttr('style');
                }
            })

            // Active Nav Link
            $('nav ul li a').click(function() {
                $('nav ul li a').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
@endsection
