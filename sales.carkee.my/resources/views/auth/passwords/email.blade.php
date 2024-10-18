@extends('layouts.app')
@section('title', 'Forgot password')
@section('content')

    <div class="row h-100">
        <div class="col-lg-5 col-12 mx-auto">
            <div id="auth-left">
                <div class="auth-logo">
                </div>
                <h1 class="display-3 fw-bold">Forgot Password</h1>
                <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror form-control-xl" placeholder="Email"
                            name="email" value="{{ old('email') }}" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary btn-lg fw-bold" type="submit">Reset Password In</button>
                    </div>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="fw-bold">Remembered your password? <a href="{{ route('login') }}" class="fw-bold">Log in</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
