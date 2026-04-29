@extends('layouts.admin')

@section('content')
<style>
  .navManageBom {
    background: darkblue;
    color: white;
  }
</style>
<script>
  const cp = document.getElementById('billOfMaterialsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Edit Bill of Materials
@endsection
<!-- Content -->
<div class="row ps-3 pe-4">
  <div class="mb-3">
    <livewire:admin.components.manage-bom.select-bom :bomId='$bom_id'>
  </div>
  <div>
    <div class="p-5 shadow-sm border bg-white rounded-3 mb-4">
      <livewire:admin.components.manage-bom.display-bom @BomSelected="$refresh" @MaterialAdded="$refresh">
    </div>
  </div>
</div>
@endsection