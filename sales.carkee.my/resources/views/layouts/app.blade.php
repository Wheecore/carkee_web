<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Home') | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ my_asset('assets/css//bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ my_asset('assets/css/style.css') }}">
    <style>
        #auth {
            height: 100vh;
            overflow-x: hidden;
        }

        #auth #auth-left .auth-logo {
            margin-bottom: 7rem;
        }

        #auth #auth-left {
            padding: 5rem 8rem;
        }

        #auth #auth-right {
            background: conic-gradient(from 90deg at 50% 50%, #1f005c, #231266, #272170, #2c2e79, #333b82, #3a478a, #425492, #4c6099);
            height: 100%;
        }

        .btn-lg {
            --bs-btn-padding-y: 0.5rem;
            --bs-btn-padding-x: 1rem;
            --bs-btn-font-size: 1.25rem;
            --bs-btn-border-radius: 0.3rem;
        }

        @media screen and (max-width: 576px) {
            #auth #auth-left {
                padding: 5rem 3rem
            }
        }
        .invalid-feedback {display: block !important;}
    </style>
</head>

<body>
    <div id="auth">
        @yield('content')
    </div>
</body>

</html>
