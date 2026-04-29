<div>
    {{-- Add Department Form --}}
    <form wire:submit='AddDepartment' class="p-3">
        <div class="row mb-3">
            <div>
                <label class="form-label">Department Name</label>
                <input wire:model='departmentName' type="text" class="form-control bg-white border border-dark-subtle">
                @error('departmentName')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="text-center mt-4">
                @if (session()->has('message'))
                <span class="text-success fw-bold">{{session('message')['message']}}</span>
                @endif
            </div>
        </div>
        <div class="row mb-2 justify-content-end">
            <div class="col-auto">
                <button class="btn btn-success">
                    Add
                </button>
            </div>
        </div>
    </form>
</div>