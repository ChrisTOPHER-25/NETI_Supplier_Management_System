<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(Route::currentRouteName() == 'admin.home')
        Home
        @else
        @yield('content-header')
        @endif
    </title>

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
    .headerContent {
        box-shadow: 1px 5px 5px 1px rgba(0, 0, 0, 0.29);
        -webkit-box-shadow: 1px 5px 5px 1px rgba(0, 0, 0, 0.29);
        -moz-box-shadow: 1px 5px 5px 1px rgba(0, 0, 0, 0.29);
    }

    .nav-item:hover,
    .nav-link:hover {
        background: darkblue;
        color: white;
    }

    .nav-item:focus,
    .nav-link:focus {
        color: black;
    }

    .nav-link,
    #sideBar,
    .navBillOfMaterials,
    .navSuppliers,
    .navAdminManagement,
    .navTagsCollapse {
        background: #f9f9f9;
        color: black;
        font-size: 14px;
    }

    .signOut {
        text-decoration: none;
        border: none;
        border-radius: 2em;
        font-size: 1em;
        background: none;
    }

    .signOut:hover {
        text-decoration: underline;
        background: #d0e8ff;
        border-radius: 2em;
        transition: .1s;

    }

    /* FOR OVERALL FONT */
    * {
        font-family: "Poppins", sans-serif;
    }
</style>

<body style="background: #ebebeb">
    @inject('Auth', Illuminate\Support\Facades\Auth::class)
    <div id="app" class="container-fluid">
        <div class="row">
            {{-- Layout Header --}}
            <div class="row-100 text-white shadow-sm border z-0" style="background: #fcfcff;">
                <div class="col">
                    <span class="d-flex align-items-center ps-3 pt-2 pb-2 text-black">
                        <!-- Toggle Side Bar Button -->
                        <a href="#" onclick="toggleSideBar()" class="btn text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                            </svg>
                        </a>
                        {{-- Logo --}}
                        <a href="{{route('admin.home')}}" class="ps-2 fs-5 text-white" style="width: 20%;">
                            {{-- NYK FIL --}}
                            <img src="/neti-logo.png" class="img-fluid" alt="">
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Admin Sidebar --}}
            <div id="sideBar" class="col-auto pe-0 ps-0 pb-5 shadow">
                <!-- Welcome + Buttons -->
                <div class="row-auto pt-4">
                    <!-- Welcome Message -->
                    <div class="ps-4 pe-5">
                        <div class="row d-flex align-items-top">
                            <div class="col-auto pe-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#010040"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            </div>
                            <div class="col-auto">
                                <div class="row d-flex align-items-center">
                                    {{-- Account Settings --}}
                                    <div class="col-auto pe-0">
                                        {{ view('admin.account_settings') }}
                                    </div>
                                    {{-- Notification Button --}}
                                    <livewire:admin.components.notifications.notification-button>
                                    {{-- Notification Offcanvas --}}
                                    <livewire:admin.components.notifications.notification-offcanvas>
                                </div>
                                {{-- User Department --}}
                                {{-- <div class="row">
                                    <small class="text-secondary-emphasis">
                                        @livewire('admin.components.user-department-label')
                                    </small>
                                </div> --}}
                                <div class="row mt-2">
                                    <div class="col-auto">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"
                                            class="btn  link-primary signOut">Sign Out</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Buttons -->
                    <ul class="navbar-nav">

                        <!-- Account Settings -->
                        {{-- <li class="nav-item">
                            <a href="{{route('admin.account')}}"
                                class="nav-link ps-4 pe-5 d-flex align-items-center navAccountSettings">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                </svg>
                                <span>&nbsp;&nbsp;Account Settings<span>
                            </a>
                        </li> --}}

                        <!-- LINE BREAK -->
                        <hr class="ms-3 me-3 mb-2">

                        @if ($Auth::user()->user_type == 'superadmin')
                        <!-- Admin Management Collapse -->
                        <button
                            class="nav-item nav-link rounded-0 text-start ps-4 d-flex align-items-center navAdminManagementCollapse fw-light d-flex justify-content-between dropdown-toggle pe-4"
                            type="button" data-bs-toggle="collapse" data-bs-target="#adminManagementCollapse"
                            aria-expanded="false" aria-controls="adminManagementCollapse">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20" height="20"
                                    fill="currentColor">
                                    <path
                                        d="M144 160A80 80 0 1 0 144 0a80 80 0 1 0 0 160zm368 0A80 80 0 1 0 512 0a80 80 0 1 0 0 160zM0 298.7C0 310.4 9.6 320 21.3 320H234.7c.2 0 .4 0 .7 0c-26.6-23.5-43.3-57.8-43.3-96c0-7.6 .7-15 1.9-22.3c-13.6-6.3-28.7-9.7-44.6-9.7H106.7C47.8 192 0 239.8 0 298.7zM320 320c24 0 45.9-8.8 62.7-23.3c2.5-3.7 5.2-7.3 8-10.7c2.7-3.3 5.7-6.1 9-8.3C410 262.3 416 243.9 416 224c0-53-43-96-96-96s-96 43-96 96s43 96 96 96zm65.4 60.2c-10.3-5.9-18.1-16.2-20.8-28.2H261.3C187.7 352 128 411.7 128 485.3c0 14.7 11.9 26.7 26.7 26.7H455.2c-2.1-5.2-3.2-10.9-3.2-16.4v-3c-1.3-.7-2.7-1.5-4-2.3l-2.6 1.5c-16.8 9.7-40.5 8-54.7-9.7c-4.5-5.6-8.6-11.5-12.4-17.6l-.1-.2-.1-.2-2.4-4.1-.1-.2-.1-.2c-3.4-6.2-6.4-12.6-9-19.3c-8.2-21.2 2.2-42.6 19-52.3l2.7-1.5c0-.8 0-1.5 0-2.3s0-1.5 0-2.3l-2.7-1.5zM533.3 192H490.7c-15.9 0-31 3.5-44.6 9.7c1.3 7.2 1.9 14.7 1.9 22.3c0 17.4-3.5 33.9-9.7 49c2.5 .9 4.9 2 7.1 3.3l2.6 1.5c1.3-.8 2.6-1.6 4-2.3v-3c0-19.4 13.3-39.1 35.8-42.6c7.9-1.2 16-1.9 24.2-1.9s16.3 .6 24.2 1.9c22.5 3.5 35.8 23.2 35.8 42.6v3c1.3 .7 2.7 1.5 4 2.3l2.6-1.5c16.8-9.7 40.5-8 54.7 9.7c2.3 2.8 4.5 5.8 6.6 8.7c-2.1-57.1-49-102.7-106.6-102.7zm91.3 163.9c6.3-3.6 9.5-11.1 6.8-18c-2.1-5.5-4.6-10.8-7.4-15.9l-2.3-4c-3.1-5.1-6.5-9.9-10.2-14.5c-4.6-5.7-12.7-6.7-19-3l-2.9 1.7c-9.2 5.3-20.4 4-29.6-1.3s-16.1-14.5-16.1-25.1v-3.4c0-7.3-4.9-13.8-12.1-14.9c-6.5-1-13.1-1.5-19.9-1.5s-13.4 .5-19.9 1.5c-7.2 1.1-12.1 7.6-12.1 14.9v3.4c0 10.6-6.9 19.8-16.1 25.1s-20.4 6.6-29.6 1.3l-2.9-1.7c-6.3-3.6-14.4-2.6-19 3c-3.7 4.6-7.1 9.5-10.2 14.6l-2.3 3.9c-2.8 5.1-5.3 10.4-7.4 15.9c-2.6 6.8 .5 14.3 6.8 17.9l2.9 1.7c9.2 5.3 13.7 15.8 13.7 26.4s-4.5 21.1-13.7 26.4l-3 1.7c-6.3 3.6-9.5 11.1-6.8 17.9c2.1 5.5 4.6 10.7 7.4 15.8l2.4 4.1c3 5.1 6.4 9.9 10.1 14.5c4.6 5.7 12.7 6.7 19 3l2.9-1.7c9.2-5.3 20.4-4 29.6 1.3s16.1 14.5 16.1 25.1v3.4c0 7.3 4.9 13.8 12.1 14.9c6.5 1 13.1 1.5 19.9 1.5s13.4-.5 19.9-1.5c7.2-1.1 12.1-7.6 12.1-14.9v-3.4c0-10.6 6.9-19.8 16.1-25.1s20.4-6.6 29.6-1.3l2.9 1.7c6.3 3.6 14.4 2.6 19-3c3.7-4.6 7.1-9.4 10.1-14.5l2.4-4.2c2.8-5.1 5.3-10.3 7.4-15.8c2.6-6.8-.5-14.3-6.8-17.9l-3-1.7c-9.2-5.3-13.7-15.8-13.7-26.4s4.5-21.1 13.7-26.4l3-1.7zM472 384a40 40 0 1 1 80 0 40 40 0 1 1 -80 0z" />
                                </svg>
                                <span class="pe-5">&nbsp;&nbsp;Admin Management</span>
                            </span>
                        </button>
                        <!-- Admin Management Items -->
                        <li class="nav-item">
                            <div class="collapse" id="adminManagementCollapse">
                                <!-- Admin Accounts -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.admin_accounts')}}"
                                        class="nav-link ps-5 d-flex align-items-center navAdminAccounts fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                                        </svg>
                                        <span class="pe-5">&nbsp;&nbsp;Admin Accounts</span>
                                    </a>
                                </div>
                                <!-- User Departments -->
                                {{-- <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.departments')}}"
                                        class="nav-link ps-5 d-flex align-items-center navUserDepartments fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M256 64H384v64H256V64zM240 0c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h48v32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h96v32H80c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48H240c26.5 0 48-21.5 48-48V368c0-26.5-21.5-48-48-48H192V288H448v32H400c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48H560c26.5 0 48-21.5 48-48V368c0-26.5-21.5-48-48-48H512V288h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H352V192h48c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H240zM96 448V384H224v64H96zm320-64H544v64H416V384z" />
                                        </svg>
                                        <span class="pe-5">&nbsp;&nbsp;User Departments</span>
                                    </a>
                                </div> --}}
                            </div>
                        </li>
                        <!-- LINE BREAK -->
                        <hr class="ms-3 me-3 mt-2 mb-2">
                        @endif

                        <!-- Bill of Materials Collapse -->
                        <button
                            class="nav-item nav-link rounded-0 text-start ps-4 d-flex align-items-center navBillOfMaterialsCollapse fw-light d-flex justify-content-between dropdown-toggle pe-4"
                            type="button" data-bs-toggle="collapse" data-bs-target="#billOfMaterialsCollapse"
                            aria-expanded="false" aria-controls="billOfMaterialsCollapse">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-receipt" viewBox="0 0 16 16">
                                    <path
                                        d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z" />
                                    <path
                                        d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                                </svg>
                                <span class="pe-5">&nbsp;&nbsp;Bill of Materials</span>
                            </span>
                        </button>

                        <!-- Bill of Materials Items -->
                        <li class="nav-item">
                            <div class="collapse" id="billOfMaterialsCollapse">
                                <!-- BOM List -->
                                {{-- <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.boms')}}"
                                        class="nav-link ps-5 d-flex align-items-center navBomList fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                        <span class="pe-5">&nbsp;&nbsp;BOM List</span>
                                    </a>
                                </div> --}}
                                {{-- Draft BOMs --}}
                                @if (Route::has('admin.draft_boms'))
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.draft_boms')}}"
                                        class="nav-link ps-5 d-flex align-items-center navDraftBoms fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                        </svg>
                                        <span class="pe-5">&nbsp;&nbsp;Create BOM</span>
                                    </a>
                                </div>
                                @endif
                                <!-- Published BOMs -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.published_boms')}}"
                                        class="nav-link ps-5 d-flex align-items-center navPublishedBoms fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM288 368a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm211.3-43.3c-6.2-6.2-16.4-6.2-22.6 0L416 385.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40 40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z" />
                                        </svg>
                                        <span class="pe-5">&nbsp;&nbsp;Published BOMs</span>
                                    </a>
                                </div>
                                <!-- Edit Materials -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.manage_bom')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navManageBom fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Edit BOM</span>
                                    </a>
                                </div>
                                <!-- Manage Categories -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.manage_categories')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navManageCategories fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Material Categories</span>
                                    </a>
                                </div>
                                {{-- Manage Departments --}}
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.manage_departments')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navManageDepartments fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M256 64H384v64H256V64zM240 0c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h48v32H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h96v32H80c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48H240c26.5 0 48-21.5 48-48V368c0-26.5-21.5-48-48-48H192V288H448v32H400c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48H560c26.5 0 48-21.5 48-48V368c0-26.5-21.5-48-48-48H512V288h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H352V192h48c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H240zM96 448V384H224v64H96zm320-64H544v64H416V384z">
                                            </path>
                                        </svg>
                                        <span>&nbsp;&nbsp;BOM Departments</span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- LINE BREAK -->
                        <hr class="ms-3 me-3 mt-2 mb-2">

                        <!-- Quotations Collapse -->
                        <button
                            class="nav-item nav-link rounded-0 text-start ps-4 d-flex align-items-center navQuotationsCollapse fw-light d-flex justify-content-between dropdown-toggle pe-4"
                            type="button" data-bs-toggle="collapse" data-bs-target="#quotationsCollapse"
                            aria-expanded="false" aria-controls="quotationsCollapse">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20" height="20"
                                    fill="currentColor">
                                    <path
                                        d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z" />
                                </svg>
                                <span class="pe-5">&nbsp;&nbsp;Quotations</span>
                            </span>
                        </button>

                        {{-- Quotations Items --}}
                        <li class="nav-item">
                            <div class="collapse" id="quotationsCollapse">
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.submitted_quotations')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navSubmittedQuotations fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M448 464H192c-8.8 0-16-7.2-16-16V368H128v80c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L402.7 18.7C390.7 6.7 374.5 0 357.5 0H192c-35.3 0-64 28.7-64 64V256h48V64c0-8.8 7.2-16 16-16H352v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16zM297 215c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H302.1l-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80z" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Submitted Quotations</span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- LINE BREAK -->
                        <hr class="ms-3 me-3 mt-2 mb-2">

                        <!-- Suppliers Collapse -->
                        <button
                            class="nav-item nav-link rounded-0 text-start ps-4 d-flex align-items-center navSuppliersCollapse fw-light d-flex justify-content-between dropdown-toggle pe-4"
                            type="button" data-bs-toggle="collapse" data-bs-target="#suppliersCollapse"
                            aria-expanded="false" aria-controls="suppliersCollapse">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-boxes" viewBox="0 0 16 16">
                                    <path
                                        d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z" />
                                </svg>
                                <span>&nbsp;&nbsp;Suppliers</span>
                            </span>
                        </button>
                        <!-- Suppliers Items -->
                        <li class="nav-item">
                            <div class="collapse" id="suppliersCollapse">
                                <!-- Suppliers List -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.suppliers')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navSupplierList fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Supplier List</span>
                                    </a>
                                </div>
                                <!-- Supplier Tags -->
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.manage_supplier_tags')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navManageSupplierTags fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20"
                                            height="20" fill="currentColor">
                                            <path
                                                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c10 0 18.8-4.9 24.2-12.5l-99.2-99.2c-14.9-14.9-23.3-35.1-23.3-56.1v-33c-15.9-4.7-32.8-7.2-50.3-7.2H178.3zM384 224c-17.7 0-32 14.3-32 32v82.7c0 17 6.7 33.3 18.7 45.3L478.1 491.3c18.7 18.7 49.1 18.7 67.9 0l73.4-73.4c18.7-18.7 18.7-49.1 0-67.9L512 242.7c-12-12-28.3-18.7-45.3-18.7H384zm24 80a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Manage Supplier Tags</span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- LINE BREAK -->
                        <hr class="ms-3 me-3 mt-2 mb-2">

                        <!-- Tags Collapse -->
                        <button
                            class="nav-item nav-link rounded-0 text-start ps-4 d-flex align-items-center navTagsCollapse fw-light d-flex justify-content-between dropdown-toggle pe-4"
                            type="button" data-bs-toggle="collapse" data-bs-target="#tagsCollapse" aria-expanded="false"
                            aria-controls="tagsCollapse">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-tags" viewBox="0 0 16 16">
                                    <path
                                        d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
                                    <path
                                        d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
                                </svg>
                                <span>&nbsp;&nbsp;Tags</span>
                            </span>
                        </button>
                        {{-- Tags Items --}}
                        <li class="nav-item">
                            <div class="collapse" id="tagsCollapse">
                                {{-- Tags List --}}
                                <div class="p-0 rounded-0 text-white" style="background: #191e2e;">
                                    <a href="{{route('admin.tags_list')}}"
                                        class="nav-link ps-5 pe-3 d-flex align-items-center navTagsList fw-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                        <span>&nbsp;&nbsp;Tags List</span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- LINE BREAK -->
                        {{--
                        <hr class="ms-3 me-3"> --}}

                        <!-- Logout -->
                        <li class="nav-item">
                            {{-- <a href="#" class="nav-link ps-4 pe-5 d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd"
                                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                <span>&nbsp;&nbsp;Logout</span>
                            </a> --}}
                            <div class="modal modal-sm fade text-black" id="logoutModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticLogoutModal"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title fs-4">Confirm Logout</span>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to logout?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Confirm
                                            </button>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                            </form>
                                            <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col d-flex flex-column">
                {{-- Content Header --}}
                <div class="row mb-5">
                    <div class="headerContent pt-3 pb-3 ps-5 text-white" style="background: #010033;">
                        <span class="fw-bold fs-5">@yield('content-header')</span>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="row">
                    <div class="min-vh-100">
                        @yield('content')
                    </div>
                </div>

                {{-- Message --}}
                <div
                    class="row sticky-bottom ps-2 pt-2 pb-2 pe-4 bg-light-subtle border border-1 border-secondary-subtle">
                    @livewire('admin.components.message-notif')
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>

{{-- Sidebar Scripts --}}
<script>
    const sideBar = document.getElementById("sideBar");
    const suppCollapse = document.getElementById('supplierCollapse');
    function toggleSideBar() {
        if (sideBar.style.display == "none") {
            sideBar.style.display = "";
        } else {
            sideBar.style.display = "none";
        }
    }
</script>