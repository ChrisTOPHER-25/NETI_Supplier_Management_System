@extends('layouts.admin')

@section('content-header')
Supplier Tags
@endsection

@section('content')
<style>
    .navManageSupplierTags {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('suppliersCollapse');
    cp.classList.add('show');
</script>
{{-- Content --}}
<div class="row ps-3">

    <div class="row mb-4">
        <div>
            <div class="p-3 rounded-top-2" style="background: #3e5877;"></div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-light shadow-sm">
                <thead class="tableHeader">
                    {{-- <tr>
                        <th class="text-center" style="width: 25%">Suppliers</th>
                        <th></th>
                    </tr> --}}
                    <tr class="fs-6 fw-bold text-center">
                        <th style="width: 25%">Supplier List</th>
                        <th class="text-center">Supplier</th>
                    </tr>
                </thead>
                <tbody class="table-bordered">
                    <tr>
                        <td class="p-2 pt-3 min-vh-100" style="width: 25%;">
                            {{-- Suppliers Search --}}
                            @livewire('admin.components.manage-supplier-tags.supplier-search')
                        </td>
                        <td class="p-3">
                            {{-- Supplier Info --}}
                            @livewire('admin.components.manage-supplier-tags.supplier-info')
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <style>
            .tableHeader th {
                background: #3e5877;
                color: white;
            }
        </style>
    </div>

</div>

@endsection