<div>
    <form wire:submit='AddDepartment'>
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Department Name</label>
                <input wire:model.lazy='departmentName' type="text" class="form-control bg-white border border-dark-subtle @error('departmentName')is-invalid @enderror" id="name" name="name">
                @error('departmentName')
                <small class="text-danger">{{$message}}</small>                    
                @enderror
            </div>
        </div>
        <div class="row mb-2 justify-content-end">
            <div class="col-auto">
                <button class="btn btn-success">Add</button>
            </div>
        </div>
    </form>
</div>
