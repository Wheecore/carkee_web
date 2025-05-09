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
            background-image: url({{static_asset('front_assets/img/abstract-modern-blue-stripes-or-rectangle-layer-overlapping-with-shadow-on-dark-blue-background-vector.jpg')}});
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
            text-decoration: none!important;
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
            color: black!important;
        }
    </style>
    <div class="container-fluid full-body" style="padding: 0px;">
        <div class="right"></div>
        <div class="left">
            <div class="header">
                <h2 class="animation a1">{{ translate('Reset Password')}}</h2>
                <p class="mb-4 opacity-60">{{translate('Enter your email address and new password and confirm password.')}} </p>
            </div>
            <form id="reg-form" class="form-default" role="form" action="{{ route('password.update') }}" method="POST">
            @csrf
            <div class="form">
                 <input id="email" type="email" class="form-field animation a2{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ translate('Email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                     <input id="code" type="text" class="form-field animation a2{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="{{ $email ?? old('code') }}" placeholder="Code" required autofocus>
                            @if ($errors->has('code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                     <input id="password" type="password" class="form-field animation a2{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ translate('New Password') }}" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <input id="password-confirm" type="password" class="form-field animation a2" name="password_confirmation" placeholder="{{ translate('Confirm Password') }}" required>
                 <button type="submit" class="animation a7">{{  translate('Reset Password') }}</button>
            </div>
            </form>
        </div>
    </div>
@endsection
