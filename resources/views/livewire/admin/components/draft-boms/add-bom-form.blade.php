<div>
    <div class="modal-header">
        <span class="modal-title fs-5">Create BOM</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">
        <form wire:submit='AddBom'>
            <div class="row mb-2">
                <div class="col">
                    <label for="subject" class="form-label">Subject</label>
                    <input wire:model='subject' type="text" id="subject" name="subject" class="form-control bg-white border-dark-subtle @error('subject')is-invalid @enderror">
                    @error('subject')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <label for="department" class="form-label">Department</label>
                    <select wire:model='department' name="department" id="department" class="form-select bg-white border-dark-subtle @error('department')is-invalid @enderror">
                        <option value=""></option>
                        @inject('BomDepartments', App\Models\BomDepartment::class)
                        @foreach ($BomDepartments::get() as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>                        
                        @endforeach
                    </select>
                    @error('department')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
