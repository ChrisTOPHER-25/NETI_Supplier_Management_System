<div>
    <form wire:submit='AddTag' class="p-3">
        <div class="row mb-4">
            <div class="col">
                <label for="tagName" class="form-label">Name</label>
                <input wire:model='tagName' type="text" class="form-control bg-white border-dark-subtle">
                @error('tagName')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-auto">
                <button class="btn btn-success">Add</button>
            </div>
        </div>
    </form>
</div>
