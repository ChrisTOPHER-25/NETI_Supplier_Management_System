<div>
    @inject('BomMaterialCategory', App\Models\BomMaterialCategory::class)
    <div class="modal-header">
        <span class="modal-title fs-5">Add Material</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" style="min-height: 60vh;">
        <form wire:submit='AddMaterial'>
            <div class="row">
                <div class="col">
                    {{-- Category, Name, Brand, Kilo, Quantity, Price --}}
                    <div class="row mb-1">
                        <div class="col">
                            {{-- Category --}}
                            <div class="row mb-2">
                                <label for="category" class="col-sm-4 col-form-label">
                                    Category
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-7">
                                    <select wire:change='ShowBrandOrKilo' wire:model='category' name="category" id="category"
                                        class="@error('category')is-invalid @enderror form-select form-select-sm bg-white border-dark-subtle">
                                        <option value=""></option>
                                        @foreach($BomMaterialCategory::where('department_id', $bom->department_id)->get() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($categorySelected)
                            @if ($showingBrand)
                            {{-- Brand --}}
                            <div class="row mb-2">
                                <label for="brand" class="col-sm-4 col-form-label">
                                    Brand
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-7">
                                    <input wire:model='brand' id="brand" name="brand" type="text"
                                        class="@error('brand')is-invalid @enderror form-control form-control-sm bg-white border-dark-subtle">
                                </div>
                            </div>
                            @endif
                            {{-- Model/Name --}}
                            <div class="row mb-2">
                                <label for="name" class="col-sm-4 col-form-label">
                                    Item Name
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-7">
                                    <input wire:model='name' id="name" name="name" type="text"
                                        class="@error('name')is-invalid @enderror form-control form-control-sm bg-white border-dark-subtle">
                                </div>
                            </div>
                            {{-- Quantity --}}
                            <div class="row mb-2">
                                <label for="quantity" class="col-sm-4 col-form-label">
                                    Quantity
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input wire:model='quantity' id="quantity" name="quantity" type="text"
                                        class="@error('quantity')is-invalid @enderror form-control form-control-sm form-control-sm bg-white border-dark-subtle">
                                        <span class="input-group-text text-bg-secondary">{{$currentUnit}}</span>
                                    </div>
                                </div>
                            </div>  
                            {{-- Unit Price --}}
                            <div class="row mb-2">
                                <label for="price" class="col-sm-4 col-form-label">
                                    Unit Price
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text text-bg-secondary">₱</span>
                                        <input wire:model='price' id="price" name="price" type="text" min="1"
                                        class="@error('price')is-invalid @enderror form-control form-control-sm bg-white border-dark-subtle">
                                    </div>
                                </div>
                            </div>                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Upload Image 1 --}}
                    <div class="row mb-1">
                        <label for="images" class="col-sm-3 col-form-label">
                            Images
                            <small class="text-danger">*</small>
                        </label>
                        <div class="col-sm-7 d-flex align-items-center text-primary gap-3">
                            <input multiple wire:model='images' id="images" name="images" type="file"
                                class="@error('images')is-invalid @enderror form-control form-control-sm bg-white border-dark-subtle">
                            <div>
                                <div wire:loading wire:target="images" class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        @error('images.*')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- Description --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="description" class="form-label">
                        Specification
                        <small class="text-danger">*</small>
                    </label>
                    <textarea wire:model='description' name="description" id="description" cols="15" rows="8"
                        class="@error('description')is-invalid @enderror form-control form-control-sm bg-white border-dark-subtle"></textarea>
                </div>
            </div>
            <div class="row justify-content-end gap-1">
                <div class="col-auto d-flex align-items-center">
                    @if($errors->any())
                    <small class="text-danger">Please fill the required fields</small>
                    @endif
                </div>
                <div class="col-auto d-flex align-items-center gap-1">
                    <small wire:loading>Validating fields ...</small>
                    @if (!empty($category) && !empty($name) 
                    && !empty($description) && !empty($price) && !empty($images))
                        <button class="btn btn-success btn-sm">
                            Add Material
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>