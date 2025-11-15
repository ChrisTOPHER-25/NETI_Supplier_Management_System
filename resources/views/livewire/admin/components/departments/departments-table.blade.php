<div>
    @inject('Departments', App\Models\Department::class)
    @inject('UserDepartments', App\Models\UserDepartment::class)
    <div class="table-responsive">
        <table class="table table-hover table-borderless shadow text-center">
            <thead class="tableHeader">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>No. of Users</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <style>
                    .form-control::placeholder {
                        color: black;
                    }
                </style>
                @foreach ($Departments::get() as $department)
                <tr>
                    <td>{{$department->id}}</td>
                    <td class="d-flex justify-content-center">
                        <div style="width: 60%;">
                            <form wire:submit='UpdateDepartment({{$department->id}})'>
                                <div class="input-group input-group-sm">
                                    <input wire:model='updateDepartmentName.{{$department->id}}' type="text"
                                        class="form-control border-dark-subtle" placeholder="{{$department->name}}">
                                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td>
                    <td>
                        {{count($UserDepartments::where('department_id', $department->id)->get())}}
                    </td>
                    <td>
                        <div>
                            <button onclick="Test()" wire:click='DeleteDepartment({{$department->id}})'
                                class="btn btn-sm btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>