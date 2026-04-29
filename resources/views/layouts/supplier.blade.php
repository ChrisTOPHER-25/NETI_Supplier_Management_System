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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
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

    body {
        background: #ebebeb;
    }

    .nav-link:hover {
        background: #02427e;
        transition: background;
        transition-delay: 0.1s;
    }

    .dropdown-item:hover {
        background: whitesmoke;
        color: black;
    }

    /* JED */
    .navBar .navCustom {
        position: relative;
        font-size: 12px;
        color: whitesmoke;
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
        background: whitesmoke;
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

<body>
    @inject('Auth', Illuminate\Support\Facades\Auth::class)
    <div id="app" class="container-fluid d-flex flex-column min-vh-100">
        <div class="row">
            {{-- Layout Header --}}
            <div class="row-100 pt-3 pb-3 text-white shadow-sm border z-0" style="background: #fcfcff;">
                <div class="col">
                    <span class="d-flex align-items-center ps-0 text-black">
                        {{-- Logo --}}
                        <span class="ps-2 fs-5 text-white" style="width: 15rem;">
                            {{-- NYK FIL --}}
                            <img src="/neti-logo.png" class="img-fluid" alt="">
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="row flex-grow-1">
            <div class="col">
                {{-- Navigation --}}
                <div class="navBar row d-flex align-items-center justify-content-between text-white pt-2 pb-2 ps-5 pe-5 shadow border-bottom border-dark-subtle"
                    style="background: #010033;">
                    <div class="col-auto">
                        <ul class="nav gap-2">
                            {{-- @if (Route::has('supplier.dashboard'))
                            <li class="nav-item">
                                <a href="{{route('supplier.dashboard')}}"
                                    class="navCustom nav-link link-light ps-3 pe-3 fw-bold"
                                    id="navDashboard">Dashboard</a>
                            </li>                                
                            @endif --}}
                            @if (Route::has('supplier.published_boms'))
                            <li class="nav-item">
                                <a href="{{route('supplier.published_boms')}}" class="navCustom nav-link link-light ps-3 pe-3 fw-bold"
                                    id="navBillOfMaterials">Bill of Materials</a>
                            </li>
                            @endif
                            @if (Route::has('supplier.create_quotation'))
                            <li class="nav-item">
                                <a href="{{route('supplier.create_quotation')}}" class="navCustom nav-link link-light ps-3 pe-3 fw-bold"
                                    id="navCreateQuotation">Quotations</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-auto d-flex align-items-center gap-1">
                        {{-- Notification Button --}}
                        <livewire:supplier.components.notifications.notification-button>
                        {{-- Notification Offcanvas --}}
                        <livewire:supplier.components.notifications.notification-offcanvas>

                        {{-- Supplier Profile Picture --}}
                        @livewire('supplier.components.supplier-profile-pic-layout')
                        <div class="dropdown">
                            <a class="link-light text-decoration-none dropdown-toggle ps-2 pe-2 fs-6 fw-light"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{Auth::user()->name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{route('supplier.account_settings')}}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill me-2" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                          </svg>
                                        Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"
                                        class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left me-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                                          </svg>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- Logout Modal --}}
                    <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content text-black">
                                <div class="modal-header">
                                    <span class="modal-title fs-4" id="logoutModalLabel">Confirm Logout</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to log out?
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex justify-content-end gap-1">
                                        <form class="dropdown-item" action="{{route('logout')}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Confirm</button>
                                        </form>
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Main Content --}}
                <div class="row ps-5 pe-5 d-flex justify-content-center">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>