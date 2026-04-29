@extends('layouts.admin')

@section('content')
<style>
    .navDraftBoms {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('billOfMaterialsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Draft BOMs
@endsection
<!-- Content -->
<div class="row ps-3">

    {{-- Buttons --}}
    <div class="row mb-4">
        <div class="d-flex gap-2">
            <div>
                {{-- Add BOM Button --}}
                <button type="button" class="button btn btn-success shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#addBomModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Create BOM
                </button>
                {{-- Add BOM Modal --}}
                <div class="modal fade" id="addBomModal" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="addBomLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-2">
                        {{-- Add BOM Form --}}
                        <livewire:admin.components.draft-boms.add-bom-form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    {{-- Published BOMs --}}
    <div class="row">
        <livewire:admin.components.draft-boms.bom-list-table>
    </div>
</div>

@endsection