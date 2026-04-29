@extends('layouts.admin')

@section('content')
<style>
    .navManageCategories {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('billOfMaterialsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Manage Categories
@endsection
<!-- Content -->
<div class="row ps-3 pe-3">

    {{-- Buttons --}}
    <div class="row mb-4">
        <d class="d-flex justify-content-between">
            <div>
                {{-- Add Category Button --}}
                <button class="button btn btn-success shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#addCategoryModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Add Category
                </button>
                <!-- Add Category Modal -->
                <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="addCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content rounded-2">
                            <div class="modal-header">
                                <span class="fs-5 modal-title">Add Category</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                {{-- Add Category Form --}}
                                <livewire:admin.components.manage-categories.add-category-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{-- Search Department --}}
                <livewire:admin.components.manage-categories.search-department>
            </div>
        </d>
    </div>

    <div class="row">
        <div>
            {{-- Categories List --}}
            @livewire('admin.components.manage-categories.department-categories-list')
        </div>
    </div>
</div>

@endsection