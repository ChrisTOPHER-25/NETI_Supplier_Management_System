<div>
    <div class="row justify-content-end">
        <div class="col-auto">
            @if (empty($categoryId) == false)
            <form wire:submit='AddSubcategory'>
                <div class="input-group">
                    <span class="input-group-text shadow-sm border">Subcategory Name</span>
                    <input wire:model='subcategoryName'type="text" class="form-control bg-white border">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
                @error('subcategoryName')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </form>
            @endif
        </div>
    </div>
</div>
