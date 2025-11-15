@extends('layouts.admin')

@section('content')
<style>
    .navSupplierList {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('suppliersCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Supplier List
@endsection
{{-- Content --}}
<div class="row ps-3">

    {{-- Buttons --}}
    <div class="row mb-4">
        <div class="d-flex gap-2">
            <div>
                {{-- Add Supplier Button --}}
                <button class="btn btn-success shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#addSupplierModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Add Supplier
                </button>
                {{-- Add Supplier Modal --}}
                <div class="modal fade" id="addSupplierModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="addSupplierLabel" aria-hidden="true" data-toggle="modal">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row w-100">
                                    <div class="col">
                                        <span class="modal-title fs-5">Add Supplier</span>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                </div>
                            </div>
                            {{-- Add Supplier Form --}}
                            @livewire('admin.components.supplier-list.add-supplier-form')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Supplier List Table --}}
    <div class="row">
        {{-- Table --}}
        @livewire('admin.components.supplier-list.supplier-list-table')
    </div>

</div>

@endsection