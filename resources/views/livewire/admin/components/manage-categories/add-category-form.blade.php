<div>
    <div class="row mb-3 d-flex align-items-end">

        <form wire:submit='AddCategoryToList'>
            {{-- Category Name --}}
            <div class="row mb-1">
                <label for="categoryName" class="col-sm-4 col-form-label">Category Name</label>
                <div class="col-sm-5">
                    <div class="input-group input-group-sm">
                        <input wire:keydown='ShowAddButton' wire:model='categoryName' type="text"
                            class="form-control form-control-sm bg-white border-dark-subtle @error('categoryName')is-invalid @enderror"
                            id="categoryName" name="categoryName" autocomplete="false">
                        @if ($showAddButton)
                        {{-- Add to Category Button --}}
                        <button class="btn btn-primary rounded-start-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                            </svg>
                            Add Category
                        </button>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Unit --}}
            <div class="row mb-1">
                <label for="unit" class="col-sm-4 col-form-label">Unit</label>
                <div class="col-sm-2">
                    <input wire:keydown='ShowAddButton' wire:model='unit' id='unit' name='unit' type="text"
                        class="form-control form-control-sm bg-white border-dark-subtle @error('unit')is-invalid @enderror"
                        placeholder="E.g. k, kg, g, pcs">
                </div>
            </div>
            {{-- Uses Brand --}}
            <div class="row mb-4">
                <label for="uses_brand" class="col-sm-4 col-form-label">Uses Brand?</label>
                <div class="col-sm-2">
                    <select wire:model='usesBrand' name="usesBrand" id="usesBrand"
                        class="form-select form-select-sm bg-white border-dark-subtle">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </form>


        {{-- Choose Departments --}}
        <div class="row mb-2">
            <label class="col-sm-4 col-form-label">Choose department(s) for the category/ies</label>
            <div class="col-sm-5">
                @inject('BomDepartments', App\Models\BomDepartment::class)
                <div class="input-group">
                    <button class="btn dropdown-toggle text-black border-secondary-subtle bg-white" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Select Department
                    </button>
                    <ul class="dropdown-menu" wire:ignore>
                        <li>
                            <div class="table-responsive" style="max-height: 45vh;">
                                <table class="table table-borderless table-hover">
                                    <tbody>
                                        @foreach ($BomDepartments::get() as $department)
                                        <tr wire:key='departmentBtnRow_{{$department->id}}'>
                                            <td class="d-flex gap-3">
                                                <input wire:change='AddDepartmentToList'
                                                    wire:model='checkedDepartments.{{$department->id}}'
                                                    value={{$department->id}}
                                                id="departmentChk_{{$department->id}}" type="checkbox"
                                                class="form-check-input
                                                border-dark-subtle">
                                                <label for="departmentChk_{{$department->id}}" class="from-label w-100"
                                                    style="cursor: pointer;">{{$department->name}}</label>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Table --}}
    <div class="row mb-3">
        <div class="col pe-0">
            {{-- Categories --}}
            <div class="table-responsive border border-secondary-subtle border-end-0"
                style="min-height: 50vh; max-height: 50vh;">
                <table
                    class="table table-hover table-borderless border border-secondary-subtle border-start-0 border-end-0 border-top-0">
                    <thead class="table-secondary table-borderless">
                        <tr>
                            <th colspan="4" class="text-center fw-normal">New Categories</th>
                        </tr>
                        <tr class="table-light border-bottom border-secondary-subtle">
                            <th class="fw-normal text-center small">Name</th>
                            <th class="fw-normal text-center small" style="width: 20%;">Uses brand</th>
                            <th class="fw-normal text-center small" style="width: 20%;">Unit</th>
                            <th class="fw-normal text-center small" style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $categoryName)
                        <tr>
                            <td class="text-center">{{$categoryName}}</td>
                            <td class="text-center">
                                @if (in_array($categoryName, $categoriesUsingBrand))
                                <span>Yes</span>
                                @else
                                <span>No</span>
                                @endif

                            </td>
                            <td class="text-center">
                                {{$categoryUnits[$key]}}
                            </td>
                            <td class="text-center">
                                <form wire:submit='RemoveCategoryFromList({{$key}})'>
                                    <button class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Departments --}}
        <div class="col ps-0">
            <div class="table-responsive border border-secondary-subtle" style="min-height: 50vh; max-height: 50vh;">
                <table
                    class="table table-hover table-borderless border border-secondary-subtle border-start-0 border-end-0 border-top-0">
                    <thead class="table-secondary">
                        <tr>
                            <th colspan="2" class="text-center fw-normal fs-6 text-nowrap">Department(s) that will use
                                the category</th>
                        </tr>
                        <tr class="table-light border-bottom border-secondary-subtle">
                            <th class="fw-normal text-center small">Name</th>
                            <th class="fw-normal text-center small" style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @inject('BomDepartments', App\Models\BomDepartment::class)
                        @foreach ($departments as $key => $selectedDepartment)
                        <tr wire:key='selectedDepartmentRow_{{$key}}'>
                            <td class="text-center">{{$BomDepartments::findOrFail($selectedDepartment)->name}}</td>
                            <td class="text-center">
                                <form wire:key='removeSelectedDepartmentForm_{{$key}}'
                                    wire:submit='RemoveDepartmentFromList({{$key}}, {{$selectedDepartment}})'
                                    id="removeSelectedDepartmentForm_{{$key}}">
                                    <button wire:key='removeSelectedDepartment_{{$key}}'
                                        id="removeSelectedDepartment_{{$key}}"
                                        class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="d-flex justify-content-end align-items-center gap-3">
            @error('categoryName')
            <small class="text-danger">{{$message}}</small>
            @enderror
            @error('usesBrand')
            <small class="text-danger">{{$message}}</small>
            @enderror
            @error('usesKilo')
            <small class="text-danger">{{$message}}</small>
            @enderror
            @error('selectedDepartment')
            <small class="text-danger">{{$message}}</small>
            @enderror
            <button wire:click='AddCategory' wire:loading.attr='disabled' class="btn btn-success">Apply Changes</button>
        </div>
    </div>
    <style>
        .categoryBadge:hover,
        .departmentBadge:hover {
            transform: scale(1.05);
            transition: transform 0.1s;
            cursor: pointer;
        }
    </style>
</div>