@extends('layouts.supplier')


@section('page-title')
Quotations
@endsection

@section('content')
<script>
    const nav = document.getElementById('navCreateQuotation');
    nav.classList.add('border-bottom');
</script>

{{-- Content --}}
<div class="row">

    {{-- Select Quotation --}}
    <livewire:supplier.components.create-quotation.select-quotation>

    {{-- Create Quotation --}}
    <livewire:supplier.components.create-quotation.create-quotation>
</div>

@endsection