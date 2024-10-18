@extends('frontend.layouts.app')
@section('content')
    <style>
        .full-body {
            display: flex;
            height: 100vh;
        }

        .left {
            overflow: hidden;
            display: flex;
            /* flex-wrap: wrap; */
            flex-direction: column;
            justify-content: center;
            -webkit-animation-name: left;
            animation-name: left;
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation-delay: 1s;
            animation-delay: 1s;
        }

        .right {
            flex: 1;
            background-color: black;
            transition: 1s;
            background-image: url({{ static_asset('front_assets/img/abstract-modern-blue-stripes-or-rectangle-layer-overlapping-with-shadow-on-dark-blue-background-vector.jpg') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .header>h2 {
            margin: 0;
            color: #F37539;
            font-weight: bold;
        }

        .header>h4 {
            margin-top: 10px;
            font-weight: normal;
            font-size: 15px;
            color: rgba(0, 0, 0, 0.4);
        }

        .form {
            max-width: 100%;
            display: flex;
            flex-direction: column;
        }

        .form>p {
            text-align: right;
        }

        .form>p>a {
            color: #091D40;
            font-size: 14px;
            text-decoration: none !important;
        }

        .form-field {
            height: 46px;
            padding: 0 16px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-family: "Rubik", sans-serif;
            outline: 0;
            transition: 0.2s;
            margin-top: 20px;
        }

        .form-field:focus {
            border-color: #0F7EF1;
        }

        .form>button {
            padding: 12px 10px;
            border: 0;
            background: #091D40;
            border-radius: 3px;
            margin-top: 10px;
            color: #fff;
            letter-spacing: 1px;
            font-family: "Rubik", sans-serif;
            cursor: pointer;
        }

        .animation {
            -webkit-animation-name: move;
            animation-name: move;
            -webkit-animation-duration: 0.4s;
            animation-duration: 0.4s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation-delay: 2s;
            animation-delay: 2s;
        }

        .a1 {
            -webkit-animation-delay: 2s;
            animation-delay: 2s;
        }

        .a2 {
            -webkit-animation-delay: 2.1s;
            animation-delay: 2.1s;
        }

        .a3 {
            -webkit-animation-delay: 2.2s;
            animation-delay: 2.2s;
        }

        .a4 {
            -webkit-animation-delay: 2.3s;
            animation-delay: 2.3s;
        }

        .a5 {
            -webkit-animation-delay: 2.4s;
            animation-delay: 2.4s;
        }

        .a6 {
            -webkit-animation-delay: 2.5s;
            animation-delay: 2.5s;
        }

        .a7 {
            -webkit-animation-delay: 2.4s;
            animation-delay: 2.6s;
        }

        .a8 {
            -webkit-animation-delay: 2.5s;
            animation-delay: 2.7s;
        }

        @-webkit-keyframes move {
            0% {
                opacity: 0;
                visibility: hidden;
                transform: translateY(-40px);
            }

            100% {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        @keyframes move {
            0% {
                opacity: 0;
                visibility: hidden;
                transform: translateY(-40px);
            }

            100% {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        @-webkit-keyframes left {
            0% {
                opacity: 0;
                width: 0;
            }

            100% {
                opacity: 1;
                padding: 20px 40px;
                width: 440px;
            }
        }

        @keyframes left {
            0% {
                opacity: 0;
                width: 0;
            }

            100% {
                opacity: 1;
                padding: 20px 40px;
                width: 440px;
            }
        }

        .bordert {
            border-top: 1px solid #aaa;
            position: relative
        }

        .bordert:after {
            content: "or ";
            position: absolute;
            top: -13px;
            left: 40%;
            background-color: #fff;
            padding: 0px 8px
        }

        .btn-outline-secondary {
            color: black !important;
        }
    </style>
    <div class="container-fluid full-body" style="padding: 0px;">
        <div class="right"></div>
        <div class="left">
            <div class="header">
                <h2 class="animation a1">{{ translate('Create an account.') }}</h2>
            </div>
            <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form">
                    <input type="text" class="form-field animation a2{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        value="{{ old('name') }}" placeholder="{{ translate('Full Name') }}" name="name">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <input type="email" class="form-field animation a4{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <input type="password"
                        class="form-field animation a5{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="{{ translate('Password') }}" name="password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <input type="password" class="form-field animation a5"
                        placeholder="{{ translate('Confirm Password') }}" name="password_confirmation">
                    @if (get_setting('google_recaptcha') == 1)
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="aiz-checkbox">
                            <input type="checkbox" name="checkbox_example_1" required>
                            <span
                                class=opacity-60>{{ translate('By signing up you agree to our terms and conditions.') }}</span>
                            <span class="aiz-square-check"></span>
                        </label>
                    </div>
                    <button type="submit" class="animation a7">{{ translate('Create Account') }}</button>
                    <small id="emailHelp" class="form-text text-muted animation a8">
                        {{ translate('Already have an account?') }} <a
                            href="{{ route('user.login') }}">{{ translate('Log In') }}</a></small>

                    @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                        <br>
                        <!--  -->
                        <div class="bordert"></div>
                        <br>
                        <ul class="list-inline social colored text-center mb-5">
                            @if (get_setting('facebook_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                        class="animation a7 facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if (get_setting('google_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                        class="animation a7 google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            @endif
                            @if (get_setting('twitter_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                        class="animation a7 twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @if (get_setting('google_recaptcha') == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script type="text/javascript">
        @if (get_setting('google_recaptcha') == 1)
            // making the CAPTCHA  a required field for form submission
            $(document).ready(function() {
                // alert('helloman');
                $("#reg-form").on("submit", function(evt) {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
                        //reCaptcha not verified
                        alert("please verify you are humann!");
                        evt.preventDefault();
                        return false;
                    }
                    //captcha verified
                    //do the rest of your validations here
                    $("#reg-form").submit();
                });
            });
        @endif

        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if (country.iso2 == 'bd') {
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php
                echo json_encode(
                    \App\Country::where('status', 1)
                        ->pluck('code')
                        ->toArray(),
                );
            @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if (selectedCountryData.iso2 == 'bd') {
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });

        function toggleEmailPhone(el) {
            if (isPhoneShown) {
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            } else {
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }
    </script>
@endsection
