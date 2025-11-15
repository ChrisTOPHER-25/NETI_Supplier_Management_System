@extends('layouts.supplier')

@section('page-title')
Bill Of Materials
@endsection

@section('content')
<script>
    const nav = document.getElementById('navBillOfMaterials');
    nav.classList.add('border-bottom');
</script>

{{-- Content Header --}}
<div class="row mt-4">
    <div class="col-auto">
        <span class="fs-3 fw-bold">Bill of Materials</span>
    </div>
</div>

<hr class="mt-3 mb-3">

{{-- Content --}}
<div class="row justify-content-center">
    <div class="col">
        {{-- Published BOMs Table --}}
        @livewire('supplier.components.boms.published-boms-table')
    </div>
</div>

@endsection