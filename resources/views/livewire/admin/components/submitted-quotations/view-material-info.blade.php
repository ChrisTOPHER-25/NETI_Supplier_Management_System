<div style="min-height: 70vh;">
    {{-- Spinner --}}
    <div class="row justify-content-center">
        <div class="col-auto">
            <div wire:loading class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @if ($material)
    @inject('QuotationMaterialImages', App\Models\QuotationMaterialImage::class)
    {{-- Go Back --}}
    <div class="row mb-4">
        <div wire:loading.attr='hidden' class="col-auto">
            <a wire:click='CloseMaterialInfo' class="link-secondary d-flex align-items-center gap-1"
                style="cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                </svg>
                Go Back
            </a>
        </div>
    </div>
    {{-- Brand & Item Name --}}
    <div class="row mb-3 d-flex gap-1">
        <div class="col-auto pe-0">
            <div wire:loading.attr='hidden' class="input-group input-group-sm">
                <span class="input-group-text text-white fw-bold" style="background: #3e5877;">Brand</span>
                <input 
                value="@if(empty($material->brand))N/A @else {{$material->brand}} @endif" 
                readonly type="text" class="form-control bg-white border-dark-subtle">
            </div>
        </div>
        <div class="col-auto pe-0">            
            <div wire:loading.attr='hidden' class="input-group input-group-sm">
                <span class="input-group-text text-white fw-bold" style="background: #3e5877;">Item Name</span>
                <input value="{{$material->name}}" readonly type="text" class="form-control bg-white border-dark-subtle">
            </div>
        </div>
    </div>
    {{-- Images --}}
    {{-- <div wire:loading.attr='hidden' class="row mb-2">
        <div class="col">
            <span class="fs-6">Images</span>
        </div>
    </div> --}}
    <div wire:loading.attr='hidden' class="row ps-2 d-flex mb-1 gap-2">
        @foreach ($QuotationMaterialImages::where('material_id', $materialId)->get() as $image)
        <img wire:loading.attr='hidden' class="img-thumbnail" style="height: 20%; width:25%;"
            src="{{route('admin.material_image.show', ['materialImageFileName' => $image->file_name])}}"
            alt="Material Image">
        @endforeach
    </div>
    <hr wire:loading.attr='hidden' class="mt-4 mb-3">
    {{-- Specification --}}
    <div wire:loading.attr='hidden' class="row mb-2">
        <div class="col">
            <label for="materialSpecification_{{$material->id}}" class="form-label fs-6">Specification</label>
            <textarea name="materialSpecification_{{$material->id}}" 
                id="materialSpecification_{{$material->id}}" 
                class="form-control bg-white border-dark-subtle" cols="10" rows="10" readonly
                >{{$material->description}}</textarea>
        </div>
    </div>
    @endif
</div>