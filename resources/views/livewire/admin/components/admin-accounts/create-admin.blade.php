<div>
    @inject('Departments', App\Models\Department::class)
    <form wire:submit='CreateAdmin' class="p-3">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <label class="form-label">Admin Name</label>
                    <input wire:model='name' type="text" class="form-control border-dark-subtle">
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <div>
                    <label class="form-label">Email</label>
                    <input wire:model='email' type="email" class="form-control border-dark-subtle">
                    @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div>
                    <label class="form-label">Password</label>
                    <input wire:model='password' type="password" class="form-control border-dark-subtle">
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
        </div>
        {{-- <div class="row mb-2">
            <div class="col">
                <div>
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input wire:model='contactNumber' type="text" class="form-control border-dark-subtle">
                    <small>Ex. 09123456789</small><br>
                    @error('contactNumber')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div>
                    <label for="department" class="form-label">Department</label>
                    <select wire:model='department' class="form-select border-dark-subtle">
                        <option value=""></option>
                        @foreach ($Departments::get() as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> --}}
        <div class="row justify-content-center">
            <div class="col-auto">
                <div>
                    @if (session()->has('adminCreated'))
                    <span class="text-success">Success</span>                        
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-auto">
                <div>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </div>
        </div>
    </form>
</div>