<div wire:key='viewDeptInfo_{{$department->id}}'>
    <div class="modal-header">
        <span class="modal-title fs-5" id="viewDeptLabel_{{$departmentId}}">Department Info</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">
        <div class="row mb-3">
            <div class="col-auto d-flex align-items-center gap-2">
                <form wire:submit='UpdateDepartmentName' id="updateDepartmentNameForm_{{$departmentId}}">
                    <div class="input-group">
                        <span class="input-group-text text-white" style="background: #3e5877;">Department Name</span>
                        <input wire:model='departmentName' type="text" class="newDepartmentNameInput form-control bg-white border-dark-subtle"
                            placeholder="{{$department->name}}">
                        <button class="btn btn-primary" id="updateDepartmentNameBtn_{{$departmentId}}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor">
                                <path
                                    d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H352c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32s-32 14.3-32 32v35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V432c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H160c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z" />
                            </svg>
                        </button>
                    </div>
                </form>
                @error('departmentName')
                <small class="text-danger">{{$message}}</small>
                @enderror
                @if (session()->has('change-success'))
                <small class="text-success">{{session('change-success')}}</small>
                @endif
                <style>
                    .newDepartmentNameInput::placeholder {
                        color: black;
                    }
                </style>
            </div>
        </div>
        <div class="row d-flex justify-content-center p-0">
            {{-- BOMs Table --}}
            <div class="col pe-0">
                <div class="table-responsive border border-dark-subtle border-end-0"
                    style="max-height: 70vh; min-height: 70vh;">
                    <table class="table table-hover table-borderless">
                        <thead class="table-secondary">
                            <tr class="text-center sticky-top">
                                <th class="fw-normal" style="width: 50%;">
                                    <span class="link-primary text-decoration-none">Bill of Materials</span> using this department
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boms as $bom)
                            <tr class="border-bottom">
                                <td>{{$bom->subject}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Categories Table --}}
            <div class="col ps-0">
                <div class="table-responsive border border-dark-subtle"
                    style="max-height: 70vh; min-height: 70vh;">
                    <table class="table table-hover table-borderless">
                        <thead class="table-secondary">
                            <tr class="text-center sticky-top">
                                <th class="fw-normal" style="width: 50%;">
                                    <span class="link-primary text-decoration-none">Categories</span>
                                    under this department
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="border-bottom">
                                <td>{{$category->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>