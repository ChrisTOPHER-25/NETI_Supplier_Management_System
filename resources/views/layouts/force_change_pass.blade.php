<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>

<!-- Styles -->
<style>
    /* FOR OVERALL FONT */
    * {
        font-family: "Poppins", sans-serif;
    }

    .nav-link:hover {
        background: #0300a7;
        transition: background;
        transition-delay: 0.1s;
    }

    .dropdown-item:hover {
        background: rgb(230, 230, 230);
        color: black;
    }

    /* JED */
    .navBar .navCustom {
        position: relative;
        font-size: 14px;
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        margin-left: 20px;
    }

    .navBar .navCustom::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 100%;
        height: 3px;
        background: #fff;
        border-radius: 5px;
        transform-origin: right;
        transform: scaleX(0);
        transition: transform .5s;

    }

    .navBar .navCustom:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }
</style>

<body style="background: #ebebeb">
    @inject('Auth', Illuminate\Support\Facades\Auth::class)
    <div id="app" class="container-fluid d-flex flex-column min-vh-100">
        {{-- Main Content --}}
        <div class="row ps-5 pe-5 d-flex justify-content-center">
            @yield('content')
        </div>
    </div>
    @livewireScripts
</body>

</html>