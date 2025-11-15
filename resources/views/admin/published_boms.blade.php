@extends('layouts.admin')

@section('content')
<style>
    .navPublishedBoms {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('billOfMaterialsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Published BOMs
@endsection
<!-- Content -->
<div class="row ps-3">

    {{-- Buttons --}}
    {{-- <div class="row mb-4">
        <div class="d-flex gap-2">

        </div>
    </div> --}}

    {{-- Published BOMs --}}
    <div class="row">
        <livewire:admin.components.published-boms.bom-list-table>
    </div>
</div>

@endsection