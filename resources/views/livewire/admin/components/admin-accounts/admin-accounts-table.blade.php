<div>
    @inject('AdminUsers', App\Models\User::class)
    @inject ('DB', Illuminate\Support\Facades\DB::class)
    @inject('UserDepartments', App\Models\UserDepartment::class)
    @inject('Departments', App\Models\Department::class)
    <div class="table-responsive">
        <table class="table table-borderless table-hover shadow-sm">
            <thead class="tableHeader">
                <tr>
                    <th>
                        <div class="text-center">
                            <input type="checkbox" class="form-check-input border border-dark-subtle">
                        </div>
                    </th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    {{-- <th>Phone</th>
                    <th>Department</th> --}}
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody wire:poll>
                @foreach ($AdminUsers::where('user_type', 'admin')->get() as $admin)
                <tr>
                    <td style="width: 5%">
                        <div class="text-center">
                            <input type="checkbox" class="form-check-input border border-dark-subtle">
                        </div>
                    </td>
                    <td>{{$admin->id}}</td>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    {{-- <td>---</td>
                    <td style="width: 30%;">
                        <div>
                            <form wire:submit='UpdateUserDepartment({{$admin->id}})'>
                                <div class="input-group input-group-sm">
                                    <select wire:loading.attr='disabled' wire:model='userDepartments.{{$admin->id}}' class="form-select border-dark-subtle">
                                        @if (count($UserDepartments::where('user_id', $admin->id)->get()) > 0)
                                            @foreach ($UserDepartments::where('user_id', $admin->id)->get() as $userDepartment)
                                                @foreach ($Departments::where('id', $userDepartment->department_id)->get() as $department)
                                                    <option value="{{$department->id}}">{{$department->name}} (Current)</option>
                                                @endforeach
                                            @endforeach
                                        @else
                                        <option value="">---</option>
                                        @endif
                                        @foreach ($Departments::get() as $department)                                        
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" fill="currentColor">
                                            <path
                                                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                        </svg>
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td> --}}
                    <td class="text-center">
                        <div>
                            @if (count($DB::table('sessions')->where('user_id', $admin->id)->get()) > 0)
                            <span class="badge rounded-pill text-white" style="background: #13c242">Online</span>
                            @else
                            <span class="badge rounded-pill text-white" style="background: #f04030">Offline</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }
    </style>
</div>