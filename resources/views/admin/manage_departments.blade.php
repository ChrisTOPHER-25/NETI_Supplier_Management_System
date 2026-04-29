@extends('layouts.admin')

@section('content')
<style>
    .navManageDepartments {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('billOfMaterialsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Manage Departments
@endsection
<!-- Content -->
<div class="row ps-3">

    {{-- Buttons --}}
    <div class="row mb-4">
        <d class="flex gap-2">
            <div>
                {{-- Add Department Button --}}
                <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#addDepartmentModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z">
                        </path>
                    </svg>
                    Add Department
                </button>
                <!-- Add Department Modal -->
                <div class="modal fade" id="addDepartmentModal" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="addDepartmentLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="modal-title fs-5">Add Department</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3">
                                {{-- Add Department Form --}}
                                @livewire('admin.components.manage-departments.add-department-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </d>
    </div>
    <div class="row">
        {{-- Department List --}}
        @livewire('admin.components.manage-departments.department-list')
    </div>
</div>
@endsection