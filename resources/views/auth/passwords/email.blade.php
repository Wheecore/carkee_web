@extends('backend.layouts.layout')
@section('content')

    <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center"
        style="background-image: url({{ uploaded_asset(get_setting('admin_login_background')) }})">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-4 mx-auto">
                    <div class="card text-left card-r">
                        <div class="card-body">
                            <div class="mb-5 text-center">
                                <img src="{{ uploaded_asset(get_setting('system_logo_black')) }}" class="mw-100 mb-4"
                                    height="40">
                                    <h2 class="animation a1">Forgot Password?</h2>
                                    <p class="mb-4 opacity-60">{{ translate('Enter your email address to recover your password.') }} </p>
                            </div>
                            <form class="form-default" role="form" action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email') }}" required autofocus
                                        placeholder="{{ translate('Email') }}">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        {{ translate('Send Password Reset Link') }}
                                    </button>
                                    <hr>
                                    <p class="text-center">
                                        <a href="{{ route('login') }}">{{ translate('Back to Login') }}</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
