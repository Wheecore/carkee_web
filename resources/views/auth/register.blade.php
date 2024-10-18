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
    <title>Carkee | {{ translate('Register') }}</title>
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/lib.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/main.min.css') }}">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7 fullscreen-md d-flex justify-content-center align-items-center overlay overlay-primary alpha-8 image-background cover"
                    style="background-image:url(https://picsum.photos/1920/1200/?random&amp;gravity=south)">
                    <div class="content">
                        <h2 class="display-4 display-md-3 display-lg-2 text-contrast mt-5 mt-md-0">
                            {{ translate('Welcome to') }} <span class="bold d-block">{{ env('APP_NAME') }}</span></h2>
                        <p class="lead text-contrast">{{ translate('Create a new account') }}</p>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ env('PLAYSTORE_LINK') }}" target="_blank">
                                    <img src="{{ asset('assets/img/play.png') }}" style="height: 40px; width: 134px" alt="">
                                </a>
                                <a href="{{ env('APPSTORE_LINK') }}" target="_blank">
                                    <img src="{{ asset('assets/img/app.png') }}" style="height: 40px; width: 134px" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mx-auto">
                    <div class="login-form mt-5 mt-md-0">
                        @php
                           $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                           <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="logo img-responsive mb-4 mb-md-6">
                        @else
                           <img src="{{ static_asset('new_front_assets/img/logo.png') }}" alt="Carkee" class="logo img-responsive mb-4 mb-md-6">
                        @endif
                        <h1 class="text-darker bold">{{ translate('Register') }}</h1>
                        @if (session('warning'))
                            <div class="alert alert-danger">{{ session('warning') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (request()->has('referral_code') && !is_null(request()->referral_code))
                            @php
                                $referred_by_user = DB::table('users')
                                    ->select('id')
                                    ->where('referral_code', request()->referral_code)
                                    ->first();
                            @endphp
                            @if ($referred_by_user)
                                <form class="form cozy" action="{{ route('register-customer') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="referral_code" value="{{ request()->referral_code }}">
                                    <label class="form-label">{{ translate('Name') }}</label>
                                    <div class="form-group has-icon">
                                        <input type="text" id="name" value="{{ old('name') }}" name="name"
                                            class="form-control form-control-rounded {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ translate('Name') }}" required autofocus> <i
                                            class="icon fas fa-user"></i>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label class="form-label">{{ translate('Email') }}</label>
                                    <div class="form-group has-icon">
                                        <input type="email" id="email" value="{{ old('email') }}" name="email"
                                            class="form-control form-control-rounded {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            placeholder="{{ translate('Email') }}" required autofocus> <i
                                            class="icon fas fa-envelope"></i>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label class="form-label">{{ translate('Password') }}</label>
                                    <div class="form-group has-icon">
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-rounded {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            placeholder="{{ translate('Password') }}" required> <i
                                            class="icon fas fa-lock"></i>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <label class="form-label">{{ translate('Confirm Password') }}</label>
                                    <div class="form-group has-icon">
                                        <input type="password" id="password-confirmation" name="password_confirmation"
                                            class="form-control form-control-rounded"
                                            placeholder="{{ translate('Confirm Password') }}" required> <i
                                            class="icon fas fa-lock"></i>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <input type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <span>{{ translate('I agree with the Terms and Conditions') }}</span>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between">
                                        <div class="ajax-button">
                                            <button type="submit" class="btn btn-primary btn-rounded">
                                                {{ translate('Register') }} <i
                                                    class="fas fa-long-arrow-alt-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-danger">
                                    {{ translate('There is no referral user found in our records try again with correct referral code') }}
                                </div>
                            @endif
                        @elseif (!session('success'))
                            <div class="alert alert-danger">
                                {{ translate('You do not have any referral code try again with correct referral url') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
