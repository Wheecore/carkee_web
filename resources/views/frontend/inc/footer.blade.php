<style>
    .whatsapp_icon{
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        z-index: 100;
    }
    .my-whatsapp-float {
        margin-top: 16px;
    }
</style>
<div class="fixed-l d-none d-xl-block">
    <a href="https://api.whatsapp.com/send?phone=+60165216766&text=Hello!" class="whatsapp_icon" target="_blank">
       <i class="fa fa-whatsapp my-whatsapp-float"></i>
    </a>
</div>
<footer class="section bg-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="">
                    <a href="{{ route('home') }}" class="d-block footer-heading">
                        @if(get_setting('footer_logo') != null)
                            <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="44">
                        @else
                       <img src="{{static_asset('front_assets/img/mainlogo.png')}}" alt="{{ env('APP_NAME') }}" height="44">
                        @endif
                    </a>
                    <div class="my-3 text-white">
                        @php
                            echo get_setting('about_us_description');
                        @endphp
                    </div>
                    <div class="d-inline-block d-md-block mb-4">
                        <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                            @csrf
                            <div class="form-group mb-0">
                                <input type="email" class="form-control" placeholder="{{ translate('Your Email Address') }}" name="email" required style="border-radius: 0px;">
                            </div>
                            <button type="submit" class="btn btn-sm subscribe_btn">
                                {{ translate('Subscribe') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="">
                    <h6 class="footer-heading text-uppercase text-white">Links</h6>
                    <ul class="list-unstyled footer-link mt-4">
                        <li><a href="{{ route('terms') }}">{{ translate('Terms & conditions') }}</a></li>
                        <li><a href="{{ route('returnpolicy') }}">{{ translate('Return Policy') }}</a></li>
                        <li><a href="{{ route('supportpolicy') }}">{{ translate('Delivery Policy') }}</a></li>
                        <li><a href="{{ route('privacypolicy') }}">{{ translate('Privacy Policy') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="">
                    <h6 class="footer-heading text-uppercase text-white">{{ translate('Contact Info') }}</h6>
                    <p class="contact-info mt-4"><strong>{{ translate('Address') }}:</strong> {{ get_setting('contact_address') }}</p>
                    <p class="contact-info"><strong>{{translate('Phone')}}:</strong> {{ get_setting('contact_phone') }}</p>
                    <p class="contact-info"><strong>{{translate('Email')}}:</strong><a class="text-white" href="mailto:{{ get_setting('contact_email') }}"> {{ get_setting('contact_email')  }}</a></p>
                    <div class="mt-5">
                        <ul class="list-inline">
                            @if ( get_setting('facebook_link') !=  null )
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('facebook_link') }}" target="_blank" class="footer-social-icon facebook"><i class="lab la-facebook-f"></i></a>
                                </li>
                            @endif
                            @if ( get_setting('twitter_link') !=  null )
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('twitter_link') }}" target="_blank" class="footer-social-icon twitter"><i class="lab la-twitter"></i></a>
                                </li>
                            @endif
                            @if ( get_setting('instagram_link') !=  null )
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('instagram_link') }}" target="_blank" class="footer-social-icon instagram"><i class="lab la-instagram"></i></a>
                                </li>
                            @endif
                            @if ( get_setting('youtube_link') !=  null )
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('youtube_link') }}" target="_blank" class="footer-social-icon youtube"><i class="lab la-youtube"></i></a>
                                </li>
                            @endif
                            @if ( get_setting('linkedin_link') !=  null )
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="footer-social-icon linkedin"><i class="lab la-linkedin-in"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="footer-alt mb-0 f-14">Copyright © 2021 Carkee. All rights reserved</p>
    </div>
</footer>
