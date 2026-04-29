<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .myBackground {
            background-image: url('/nyk.jpeg');
            background-size: cover;
            z-index: -1;
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100vh;
            background-repeat: no-repeat;
            transform: scale(1.1);
            filter: brightness(50%) blur(1px);
        }

        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            filter: brightness(50%) blur(1px) contrast(150%);
        }

        /* FOR OVERALL FONT */
        * {
            font-family: "Poppins", sans-serif;
        }

        .loginBtn {
            background: #0a66c2;
        }

        .loginBtn:hover {
            background: #003f7f;
        }

        .forgot {
            text-decoration: none;
            border: none;
            border-radius: 2em;
            font-size: 1em;
            background: none;
            
        }

        .forgot:hover {
            text-decoration: underline;
            background: #d0e8ff;
            border-radius: 2em;
            transition: .1s;
            
        }
    </style>
</head>

<body>
    <div class="myBackground"></div>
    {{-- <video autoplay muted loop id="myVideo">
        <source src="/landing_page_video.mp4" type="video/mp4">
    </video> --}}
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <form action="{{route('login')}}" class="bg-white shadow-lg rounded-1 p-5 w-50 d-none d-md-block d-lg-block"
            method="POST">
            @csrf
            <div class="row justify-content-center">
                <img src="/neti-logo.png" alt="neti-logo.png" class="img">
            </div>
            <div class="row mb-4 text-center">
                <span class="fs-5 fw-light text-secondary">Supplier Management System</span>
            </div>
            <div class="row mb-3 justify-content-center">
                <div class="col">
                    <div class="form-floating">
                        <input type="email" id="email" name="email"
                            class="form-control bg-white border-dark-subtle" placeholder="email"
                            value="{{ old('email') }}">
                        <label for="email">Email</label>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-2 justify-content-center">
                <div class="col">
                    <div class="form-floating">
                        <input type="password" id="password" name="password"
                            class="form-control bg-white border-dark-subtle" placeholder="password">
                        <label for="password">Password</label>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-4 justify-content-between">
                <div class="col-auto">
                    <input type="checkbox" id='remember' name='remember' class="form-check-input border-dark-subtle">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>
                <div class="col-auto">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn link-primary forgot">Forgot
                            Password?</a>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div>
                    <button type="submit" class="loginBtn btn btn-lg btn-primary w-100">
                        Login
                    </button>
                </div>
            </div>
        </form>

    </div>
</body>

</html>
