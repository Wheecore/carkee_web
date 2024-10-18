@extends('layouts.app')
@section('title', 'Login')
@section('content')

    <div class="row h-100 ">
        <div class="col-lg-5 col-12 mx-auto">
            <div id="auth-left">
                <div class="auth-logo"></div>
                <h1 class="display-3 fw-bold">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control @error('email') is-invalid @enderror form-control-xl"
                            placeholder="Email Address" name="email" value="{{ old('email') }}">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror form-control-xl"
                            placeholder="Password" name="password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary btn-lg fw-bold" type="submit">Log In</button>
                    </div>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    {{-- <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="fw-bold">Sign
                            up</a>.</p> --}}
                    <p><a class="fw-bold" href="{{ route('password.request') }}">Forgot password?</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection
