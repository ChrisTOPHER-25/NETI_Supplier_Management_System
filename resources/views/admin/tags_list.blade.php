@extends('layouts.admin')

@section('content')
<style>
    .navTagsList {
        background: darkblue;
        color: white;
    }
</style>
<script>
    const cp = document.getElementById('tagsCollapse');
    cp.classList.add('show');
</script>
@section('content-header')
Tags
@endsection

{{-- Content --}}
<div class="row ps-3">
    {{-- Buttons --}}
    <div class="row mb-4">
        <div class="d-flex gap-2">
            <div>
                {{-- Add Tag Button --}}
                <button type="button" class="btn btn-success shadow-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#addTagModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Add Tag
                </button>
                {{-- Add Tag Modal --}}
                <div class="modal fade" id="addTagModal" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="addTagLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-2">
                            <div class="modal-header">
                                <span class="fs-4 modal-title">Add Tag</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Add Tag Form --}}
                                @livewire('admin.components.tags-list.add-tag-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Tags List Table --}}
        @livewire('admin.components.tags-list.tags-list-table')
    </div>
</div>

@endsection