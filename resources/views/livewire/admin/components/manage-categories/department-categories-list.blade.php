<div>
    @inject('BomMaterialCategories', App\Models\BomMaterialCategory::class)
    <div class="row mb-5 gap-2 gy-3">
        @foreach ($bomDepartments as $department)
        <div class="col-auto pe-0" id="col_{{$department->id}}">
            <div class="card rounded-1 shadow-sm" style="width: 16rem;" id="card_{{$department->id}}">
                <div class="card-header rounded-top-1 text-white" style="background: #3e5877;">
                    <span class="fw-bold fs-6">{{mb_strimwidth($department->name, 0, 22, '...')}}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3 d-flex align-items-center justify-content-between">
                        <div class="col-auto">
                            <span class="fw-normal fs-6">No. of Categories</span><br>
                            <span class="fs-3 fw-light">{{$BomMaterialCategories::where('department_id',
                                $department->id)->count()}}</span>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="55" height="55"
                                fill="#2e4259">
                                <path
                                    d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto p-0">
                            {{-- View Department Categories Button --}}
                            <button wire:key='viewDepartmentCategories_{{$department->id}}' class="btn btn-sm"
                                id="viewDepartmentCategories_{{$department->id}}" data-bs-toggle="modal"
                                data-bs-target="#viewDepartmentCategoriesModal_{{$department->id}}">
                                View Categories&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>
                            </button>
                            {{-- View Department Categories Modal --}}
                            <div wire:ignore wire:key='viewDepartmentCategoriesModal_{{$department->id}}' class="modal fade"
                                id="viewDepartmentCategoriesModal_{{$department->id}}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="viewDepartmentCategoriesLabel_{{$department->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title fs-5"
                                                id="viewDepartmentCategoriesLabel_{{$department->id}}">Categories for
                                                {{$department->name}}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        {{-- View Department Categories --}}
                                        <livewire:admin.components.manage-categories.view-department-categories
                                                :departmentId="$department->id"
                                                wire:key='categoriesTable_{{$department->id}}'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>