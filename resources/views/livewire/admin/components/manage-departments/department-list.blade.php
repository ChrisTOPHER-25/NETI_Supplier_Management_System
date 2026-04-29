<div>
    {{-- Buttons --}}
    <div class="row">
        <div class="col">
            <div class="p-3 rounded-top-2 d-flex justify-content-between" style="background: #3e5877;">
                <div class="input-group w-auto">
                    {{-- Search Department --}}
                    <form wire:submit='SearchDepartment' id="searchDepartmentForm">
                        <input wire:model='searchedDepartment' type="text"
                            class="form-control bg-white border-dark-subtle rounded-end-0"
                            placeholder="Search for a department">
                    </form>
                    {{-- Reset Search --}}
                    <button wire:click='ResetSearch' class="btn btn-primary" id="resetSearchBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16"
                            fill="currentColor">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Department List --}}
    <div class="row">
        <div>
            <div class="table-responsive" style="max-height: 80vh;">
                <table class="table table-hover table-borderless shadow-sm mb-0">
                    <thead class="tableHeader">
                        <tr class="sticky-top">
                            <th class="text-center">Id</th>
                            <th>Name</th>
                            <th>No. of BOMs</th>
                            <th>No. of Categories</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @inject('Boms', App\Models\Bom::class)
                        @inject('BomMaterialCategories', App\Models\BomMaterialCategory::class)
                        @foreach ($departments as $department)
                        <tr wire:key='departmentRow_{{$department->id}}'>
                            <td class="text-center">{{$department->id}}</td>
                            <td>
                                <label for="selectDepartment_{{$department->id}}" class="form-label w-100"
                                    style="cursor: pointer;">{{$department->name}}</label>
                            </td>
                            <td>
                                <label for="selectDepartment_{{$department->id}}" class="form-label w-100"
                                    style="cursor: pointer;">
                                    {{$Boms::where('department_id', $department->id)->count()}}
                                </label>
                            </td>
                            <td>
                                <label for="selectDepartment_{{$department->id}}" class="form-label w-100"
                                    style="cursor: pointer;">
                                    {{$BomMaterialCategories::where('department_id', $department->id)->count()}}
                                </label>
                            </td>
                            <td>
                                <div class="d-flex flex-row gap-2">
                                    {{-- View Department Info Button --}}
                                    {{-- <button class="btn btn-sm btn-primary" id="viewDeptBtn_{{$department->id}}"
                                        data-bs-toggle="modal" data-bs-target="#viewDeptModal_{{$department->id}}">
                                        View Info
                                    </button> --}}
                                    {{-- View Department Info Modal --}}
                                    {{-- <div wire:ignore wire:key='viewDeptModal_{{$department->id}}' class="modal fade"
                                        id="viewDeptModal_{{$department->id}}" tabindex="-1"
                                        aria-labelledby="viewDeptLabel_{{$department->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <livewire:admin.components.manage-departments.view-department-info
                                                    :departmentId="$department->id"
                                                    wire:key='viewDeptInfo_{{$department->id}}'>
                                            </div>
                                        </div>
                                    </div> --}}

                                    @if ($BomMaterialCategories::where('department_id', $department->id)->count() == 0 &&
                                    $Boms::where('department_id', $department->id)->count() == 0)
                                    {{-- Delete Department Button --}}
                                    <form wire:submit='DeleteDepartment({{$department->id}})' wire:key='deleteDepartmentForm_{{$department->id}}'
                                        id="deleteDepartmentForm_{{$department->id}}">
                                        <button wire:loading.attr='disabled' wire:key='deleteDepartmentBtn_{{$department->id}}'
                                            id="deleteDepartmentBtn_{{$department->id}}" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-danger" disabled>
                                        Delete
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-borderless border border-start-0 border-end-0 border-bottom-0">
                    <tbody>
                        <tr>
                            <td>{{$departments->links(data: ['scrollTo' => false])}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }
    </style>
</div>