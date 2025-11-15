@extends('layouts.supplier')

@section('page-title')
Account Settings
@endsection

@section('content')
{{-- Content --}}
<!-- <div class="row p-5 pt-1 flex-grow-1 gy-4">
    {{-- Profile Information Form --}}
    
    {{-- Profile Document Form --}}
    
    {{-- Change Password Form --}}
    
    {{-- Tags --}}
    
</div> -->
<div class="container-fluid ps-0">
    <div class="row">
        <div class="col-auto pe-0 ps-0 pb-5 shadow" style="background: whitesmoke;">

            @livewire('supplier.components.account-settings.account-settings-nav')
        </div>
        <div class="col">
            @livewire('supplier.components.account-settings.account-settings-view')
        </div>
    </div>
</div>

@endsection