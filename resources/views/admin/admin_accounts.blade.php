@extends('layouts.admin')

@section('content')
<style>
    .navAdminAccounts {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('adminManagementCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Admin Accounts
@endsection
<!-- Content -->
<div class="row ps-3">

    {{-- Buttons --}}
    <div class="row mb-4">
        <div class="d-flex gap-2">
            <div>
                {{-- Create Admin Button --}}
                <button class="btn btn-success d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createAdminModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Create Admin
                </button>
                {{-- Create Admin Modal --}}
                <div class="modal fade" id="createAdminModal" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="createAdminLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-2">
                            <div class="modal-header">
                                <span class="fs-4 modal-title">Create Admin</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Create Admin Form --}}
                                @livewire('admin.components.admin-accounts.create-admin')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Accounts Table --}}
    <div class="row">
        <div><div class="p-3 pb-0 rounded-top-2" style="background: #3e5877;"></div></div>
        {{-- Table --}}
        @livewire('admin.components.admin-accounts.admin-accounts-table')
    </div>

</div>
@endsection