<div class="pt-5 body">

    <div class="fs-2 fw-medium mb-4 d-flex justify-content-center">
        <div class="me-3">
            @livewire('supplier.components.supplier-profile-pic-layout')
        </div>
        <span>Settings</span>
    </div>
    <hr class="ms-3 me-3 my-2">
    
    <ul class="nav ulNav flex-column ">
        <li class="nav-item">
            <a wire:click="selectForm('ProfileInfo')"
                class="navBar ps-5 pe-5 d-flex justify-content-start nav-link @if ($selectedForm == 'ProfileInfo') active @endif">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="me-3">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                  </svg>
                Profile Information
            </a>
        </li>
        <hr class="ms-3 me-3 my-2">
        <li class="nav-item">
            <a wire:click="selectForm('ChangePass')"
                class="navBar ps-5 pe-5 d-flex justify-content-start nav-link @if ($selectedForm == 'ChangePass') active @endif">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class=" me-3">
                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                  </svg>
                Change Password
            </a>
        </li>
        <hr class="ms-3 me-3 my-2">
        <li class="nav-item">
            <a wire:click="selectForm('UploadDocument')"
                class="navBar ps-5 pe-5 d-flex justify-content-start nav-link @if ($selectedForm == 'UploadDocument') active @endif">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-3">
                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                  </svg>
                  
                Upload Documents
            </a>
        </li>
        <hr class="ms-3 me-3 my-2">
        <li class="nav-item">
            <a wire:click="selectForm('SupplierTags')"
                class="navBar ps-5 pe-5  d-flex justify-content-start nav-link @if ($selectedForm == 'SupplierTags') active @endif">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-tags-fill me-3" viewBox="0 0 16 16">
                    <path
                        d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                    <path
                        d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z" />
                </svg>
                Supplier Tags

            </a>
        </li>
    </ul>

    <style>
        .body {
            background: whitesmoke;
        }

        .ulNav {
            min-height: 70vh;
            background: whitesmoke;
        }

        .navBar {
            cursor: pointer;
            color: black;
        }

        .navBar:hover {
            background: #010033;
            color: whitesmoke;
            transition: .5s;
        }

        .active {
            background: #010033;
            color: white;
        }
    </style>

</div>