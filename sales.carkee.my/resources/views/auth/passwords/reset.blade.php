@extends('layouts.app')
@section('title', 'Forgot password')
@section('content')

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                </div>
                <h1 class="display-3 fw-bold">Forgot Password</h1>
                <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror form-control-xl"
                            placeholder="Password" name="password" required autocomplete="new-password">
                        <div class="form-control-icon">
                            <i class="bi bi-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password-confirm" type="password" class="form-control form-control-xl"
                        name="password_confirmation" placeholder="{{ translate('Confirm Password') }}"
                        required>
                        <div class="form-control-icon">
                            <i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary btn-lg fw-bold" type="submit">Reset Password</button>
                    </div>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="fw-bold">Remembered your password? <a href="{{ route('login') }}" class="fw-bold">Log in</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

@endsection
