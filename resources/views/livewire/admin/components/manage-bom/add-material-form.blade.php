<div>    
    @inject('BomMaterialCategories', App\Models\BomMaterialCategory::class)
    <div class="mb-2 d-flex align-items-center gap-2">
        <span class="fs-4 fw-light">Add Material</span>
        <div>
            <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <form wire:submit='AddMaterial'>
        <div class="row mb-3 gy-2">
            <div class="col-auto pe-0">
                {{-- Select Category --}}
                <select wire:change='ShowBrandOrUnit' wire:model='category' name="category" id="category"
                    class="form-select bg-white border border-dark-subtle addForm @error('category')is-invalid @enderror">
                    <option value="">Select a Category</option>
                    @foreach ($BomMaterialCategories::where('department_id', $bomDepartmentId)->get() as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            @if ($categorySelected && $showingBrand)
            {{-- Brand --}}
            <div class="col-2 pe-0">
                <input wire:model='brand' type="text" class="form-control bg-white border border-dark-subtle addForm"
                    placeholder="Brand">
                @error('brand')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            @endif
            @if ($categorySelected)
            {{-- Item Name --}}
            <div class="col-3 pe-0">
                <input wire:model='name' type="text"
                    class="form-control bg-white border border-dark-subtle addForm @error('name')is-invalid @enderror"
                    placeholder="Item Name">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>                
            @endif
            @if ($categorySelected && $showingQuantity)
            {{-- Quantity --}}
            <div class="col-3 pe-0">
                <div class="input-group">
                    <input wire:model='quantity' type="text"
                    class="form-control bg-white border border-dark-subtle addForm @error('quantity')is-invalid @enderror"
                    placeholder="Quantity">
                    <span class="input-group-text text-bg-secondary">{{$currentUnit}}</span>
                </div>
                @error('quantity')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            @endif
            {{-- @if ($categorySelected)
            <div class="col-2 pe-0">
                <div class="input-group">
                    <span class="input-group-text text-bg-secondary">Unit</span>
                    <input type="text" class="form-control bg-white border border-dark-subtle addForm unitField" placeholder="{{$currentUnit}}">                    
                </div>
            </div>                
            @endif --}}
        </div>

        {{-- Specification --}}
        <div class="row mb-3">
            <div>
                <textarea wire:model='description' name="description"
                    class="form-control bg-white border border-dark-subtle addForm @error('description')is-invalid @enderror"
                    id="description" cols="30" rows="4" placeholder="Specification"></textarea>
                @error('description')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-4 text-end">
            <div>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </div>
    </form>
    <style>
        .addForm::placeholder {
            color: gray;
        }
        .unitField::placeholder {
            color: black;
        }
    </style>
</div>