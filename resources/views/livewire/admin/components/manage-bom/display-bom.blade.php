<div>
    @inject('BomDepartments', App\Models\BomDepartment::class)
    @inject('BomMaterialCategories', App\Models\BomMaterialCategory::class)
    @inject('BomMaterial', App\Models\BomMaterial::class)
    @inject('BomTags', App\Models\BomTag::class)
    @inject('Tags', App\Models\Tag::class)

    @if (empty($bom) == false)

    {{-- BOM Id --}}
    <div class="row mb-3">
        <div class="col-auto">
            <div class="d-flex align-items-center gap-5">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-light fs-2">Bill of Materials #{{$bom['id']}}</span>
                    <span
                        class="badge text-bg-@if($bom['status'] == 'published')success @elseif($bom['status'] == 'draft')warning @endif">{{ucfirst($bom['status'])}}</span>
                </div>
                <div class="spinner-border text-primary" role="status" wire:loading>
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    {{-- BOM Tags --}}
    <div class="row mb-3">
        <div class="col-auto d-flex align-items-center gap-1 gy-1">
            <span class="fs-6 fw-bold">Tags:&nbsp;</span>
            @foreach ($BomTags::where('bom_id', $bom['id'])->get() as $bomTag)
            <span class="p-2 pt-1 pb-1 fs-6 badge text-bg-primary">{{$Tags::where('id',
                $bomTag->tag_id)->firstOrfail()->name}}</span>
            @endforeach
        </div>
    </div>

    <hr class="mt-4 mb-4">

    {{-- Subject & Department --}}
    <div class="row">
        <div class="col-auto">
            <div>
                @inject('PublishedBoms', App\Models\PublishedBom::class)
                @if ($PublishedBoms::where('bom_id', $bom['id'])->count() > 0)
                {{-- Readonly --}}
                <div class="input-group">
                    <span class="input-group-text fw-bold text-white" style="background: #3e5877;">Subject</span>
                    <input type="text" class="form-control bg-white border border-dark-subtle" readonly id="subject"
                        name="subject" value="{{$bom['subject']}}">
                    <span class="input-group-text fw-bold text-white" style="background: #3e5877;">Department</span>
                    <input type="text" class="form-control bg-white border border-dark-subtle" readonly id="department"
                        name="department" value="{{$BomDepartments::findOrFail($bom['department_id'])->name}}">
                </div>
                @else
                {{-- Editable --}}
                <form wire:submit='UpdateSubjectDepartment' id="updateSubjectDepartmentForm">
                    <div class="input-group">
                        <span class="input-group-text fw-bold text-white" style="background: #3e5877;">Subject</span>
                        <input wire:model='newSubject' type="text"
                            class="form-control bg-white border border-dark-subtle" id="subject" name="subject"
                            placeholder="{{$bom['subject']}}">
                        @if ($BomMaterial::where('bom_id', $bom['id'])->count() > 0)
                        <span class="input-group-text fw-bold text-white" style="background: #3e5877;">Department</span>
                        <input type="text" class="form-control bg-white border border-dark-subtle" id="department"
                            name="department" readonly
                            value="{{$BomDepartments::findOrFail($bom['department_id'])->name}}">
                        @else
                        <span class="input-group-text fw-bold text-white" style="background: #3e5877;">Department</span>
                        <select wire:model='newSelectedDepartment' name="newSelectedDepartment"
                            id="newSelectedDepartment" class="form-select bg-white border-dark-subtle">
                            <option value="">{{$BomDepartments::findOrFail($bom['department_id'])->name}} (Current)
                            </option>
                            @foreach ($BomDepartments::get() as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                        @endif
                        <button id="updateSubjectDepartmentBtn" class="btn btn-primary">
                            Apply
                        </button>
                    </div>
                    @error('newSelectedDepartment')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </form>
                @endif
            </div>
            <style>
                .form-control::placeholder {
                    color: black;
                }
            </style>
        </div>
    </div>
    {{-- New Title Error Message --}}
    <div class="row mb-3">
        <div class="col-auto">
            @error('newBomTitle')
            <small class="text-danger">{{$message}}</small>
            @enderror
            @error('newBomCategory')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>

    {{-- List of Materials --}}
    <div class="table-responsive" style="max-height: 90vh;">
        <table class="table table-hover border-start border-end border-bottom">
            <thead class="tableHeader">
                <tr>
                    <th colspan="8" class="text-center fw-bold fs-5">Materials</th>
                </tr>
                <tr class="sticky-top">
                    <th class="fw-normal">Qty</th>                    
                    <th class="fw-normal">Unit</th>
                    <th class="fw-normal">Brand</th>
                    <th class="fw-normal">Item Name</th>
                    <th class="fw-normal">Category</th>
                    <th class="fw-normal">Specification</th>
                    @if ($bom['status'] == 'draft')
                    <th class="fw-normal">Action</th>                        
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($BomMaterial::where('bom_id', $bom['id'])->count() == 0)
                <tr>
                    <td colspan="8" class="text-center fs-5 fw-light p-5">No Materials</td>
                </tr>
                @else
                @foreach ($BomMaterial::where('bom_id', $bom['id'])->get() as $material)
                <tr>
                    <td>{{$material->quantity}}</td>                    
                    <td>{{$material->unit}}</td>
                    <td>{{$material->brand}}</td>
                    <td>{{$material->name}}</td>
                    <td>{{$BomMaterialCategories::findOrFail($material->category_id)->name}}</td>
                    <td>
                        <textarea cols="15" rows="2" readonly
                            class="form-control bg-white">{{$material->description}}</textarea>
                    </td>
                    @if ($bom['status'] == 'draft')
                    <td>
                        <div>
                            {{-- Delete Material --}}
                            <form wire:submit='DeleteMaterial({{$material->id}})'>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                    @endif

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <style>
            .tableHeader th {
                background: #3e5877;
                color: white;
                border: none;
            }
        </style>
    </div>

    <hr class="mt-3 mb-3">
    @if (App\Models\PublishedBom::where('bom_id', $bom['id'])->count() == 0 && $bom['status'] == 'draft')
    <livewire:admin.components.manage-bom.add-material-form :selectedBomId="$bom['id']"
        :bomDepartmentId="$bom['department_id']">
        @endif
        @else
        <div class="row mb-4 text-center">
            <span class="fw-light fs-4">Please select a bill of materials</span>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" wire:loading>
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        @endif
</div>