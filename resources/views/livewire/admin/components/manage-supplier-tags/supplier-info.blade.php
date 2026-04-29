<div>
    @inject('Tags', App\Models\Tag::class)
    @inject('SupplierTags', App\Models\SupplierTag::class)
    @if (empty($supplier) == false)
    <div class="row mb-2 d-flex align-items-center">
        {{-- Supplier Name --}}
        <div class="col-auto">
            <span class="fw-light fs-4">{{$supplier->name}}</span>
        </div>
        <div class="col-auto">
            <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    {{-- Assign Tags --}}
    <div class="row">
        <div class="col-auto">
            <div class="row">
                <div class="btn-group">
                    <button class="btn btn-outline-dark border-secondary-subtle text-start d-flex justify-content-between align-items-center bg-white text-dark dropdown-toggle" 
                    type="button" data-bs-toggle="dropdown" data-bs-auto-close="inside" aria-expanded="false">
                        Choose a tag for this supplier
                    </button wire:loading.attr='disabled'>
                    <ul class="dropdown-menu" wire:ignore>
                        <li>
                            <livewire:admin.components.manage-supplier-tags.search-tags :TagsList="$TagsList" :supplier='$supplier'>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 mb-3 border border-secondary-subtle border-top-0"></div>

    {{-- Supplier's Tags --}}
    <div class="row mb-2">
        <div class="col-auto">
            <span class="fs-6">Supplier's current tags:</span>
        </div>
    </div>
    <div class="row d-flex gap-1 ps-3 pe-3">
        @foreach ($SupplierTags::where('user_id', $supplier->id)->get() as $supplierTag)
        <div class="col-auto p-0">
            <h5>
                <span class="removeTagBtn badge text-bg-primary">
                    <span class="d-flex align-items-center gap-1">
                        {{$Tags::findOrFail($supplierTag->tag_id)->name}}
                        {{-- Remove tag from supplier --}}
                        <form wire:submit='RemoveSupplierTag({{$supplierTag}})'>
                            <button wire:loading.attr='disabled' class="btn btn-sm text-dark p-0 border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white"
                                    class="bi bi-x" viewBox="0 0 16 16">
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </button>
                        </form>
                    </span>
                </span>
            </h5>
        </div>
        @endforeach
    </div>
    @else
    <div class="row mb-2 text-start">
        <span class="fs-5 fw-light">Select a Supplier</span>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            <div wire:loading class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @endif
    <style>
        .removeTagBtn:hover {
            transform: scale(1.05);
            transition: transform 0.1s;
        }
    </style>
</div>