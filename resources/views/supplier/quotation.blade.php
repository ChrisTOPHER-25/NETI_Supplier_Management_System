@extends('layouts.supplier')

@section('page-title')
Bill Of Materials
@endsection

@section('content')


<script>
    const nav = document.getElementById('navQuotation');
    nav.classList.add('border-bottom');
</script>

{{-- Content Header --}}
<div class="row mt-4">
    <div class="col-auto">
        <span class="fs-3 fw-bold">Quotation</span>
    </div>
</div>

<hr class="mt-3 mb-3">

<div>
    
    <table class="table table-danger">

    </table>
</div>

@endsection
