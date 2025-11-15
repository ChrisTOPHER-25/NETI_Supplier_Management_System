@extends('layouts.admin')

@section('page-title')
Submitted Quotations
@endsection

@section('content-header')
Submitted Quotations
@endsection

@section('content')
<style>
    .navSubmittedQuotations {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('quotationsCollapse');
      cp.classList.add('show');
</script>

<div class="row ps-3 ps-4">
    {{-- Select BOM --}}
    <livewire:admin.components.submitted-quotations.select-bom>
    
    {{-- View Quotation Cards --}}
    <div class="row">
        <div class="col">
            <livewire:admin.components.submitted-quotations.view-quotations>
        </div>
    </div>

    {{-- Display Quotation --}}
    
</div>

@endsection