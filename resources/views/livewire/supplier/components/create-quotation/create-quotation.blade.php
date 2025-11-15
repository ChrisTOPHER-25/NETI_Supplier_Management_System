<div>    
    @inject('SubmittedQuotations', App\Models\SubmittedQuotation::class)
    @inject('QuotationMaterials', App\Models\QuotationMaterial::class)
    @inject('QuotationMaterialImages', App\Models\QuotationMaterialImage::class)
    @inject('BomMaterials', App\Models\BomMaterial::class)
    @inject('BomMaterialCategory', App\Models\BomMaterialCategory::class)
    @if (!empty($selectedBomId))
    {{-- Preview BOM --}}
    <div class="row mb-4 bg-white shadow-sm p-0 rounded-3 border border-secondary-subtle">
        <div class="col">
            <div class="row p-5 ps-4 pe-4 pt-4">
                <div class="row mb-2 d-flex align-items-center justify-content-between">
                    <div class="col-auto">
                        <span class="fs-5">Bill of Materials</span>
                    </div>
                    <div class="col-auto p-0">
                        <button wire:click='CloseBom' id="closeBom_{{$selectedBomId}}" class="btn p-0 ps-1 pe-1">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                {{-- Subject & Department --}}
                <div class="row mb-3">
                    @inject('BomDepartment', App\Models\BomDepartment::class)
                    <div class="col-auto pe-0">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text text-bg-secondary fw-light">Subject</span>
                            <input value="{{$bom->subject}}" type="text"
                                class="form-control bg-white border-dark-subtle" readonly>
                        </div>
                    </div>
                    <div class="col-auto pe-0">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text text-bg-secondary fw-light">Department</span>
                            <input value="{{$BomDepartment::findOrFail($bom->department_id)->name}}" type="text"
                                class="form-control bg-white border-dark-subtle" readonly>
                        </div>
                    </div>
                </div>
                {{-- Table --}}
                <div>
                    <div class="table-responsive border border-secondary-subtle">
                        <table class="table table-sm table-hover table-borderless">
                            <thead>
                                <tr class="table-secondary text-center">
                                    <th class="fw-normal">Qty</th>
                                    <th class="fw-normal">Unit</th>
                                    <th class="fw-normal">Brand</th>
                                    <th class="fw-normal">Item Name</th>
                                    <th class="fw-normal">Category</th>
                                    <th class="fw-normal">Specification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($BomMaterials::where('bom_id', $selectedBomId)->get() as $material)
                                <tr class="text-center">
                                    <td class="fw-light">{{$material->quantity}}</td>
                                    <td class="fw-light">{{$material->unit}}</td>
                                    <td class="fw-light">{{$material->brand}}</td>
                                    <td class="fw-light">{{$material->name}}</td>
                                    <td class="fw-light">
                                        {{$BomMaterialCategory::findOrFail($material->category_id)->name}}
                                    </td>                                    
                                    <td class="fw-light">
                                        <textarea name="description_{{$material->id}}"
                                            id="description_{{$material->id}}" cols="15" rows="2"
                                            class="form-control form-control-sm bg-white border-dark-subtle"
                                            readonly>{{$material->description}}</textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Create Quotation --}}
    <div class="row mb-5 bg-white shadow-sm p-0 rounded-3 pt-1 border border-secondary-subtle">
        <div class="col">
            <div class="row p-5 ps-4 pe-4 pt-4">
                <div class="row mb-3 justify-content-between">
                    <div class="col-auto">
                        <span class="fs-5">Create Quotation</span>
                    </div>
                    <div class="col-auto p-0">
                        <div>
                            @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() > 0)
                            <span class="badge rounded-pill text-bg-success">Submitted</span>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Table --}}
                <div class="mb-4">
                    <div class="table-responsive border border-secondary-subtle mb-2">
                        <table class="table table-sm table-hover table-borderless">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th class="fw-normal">Qty</th>
                                    <th class="fw-normal">Unit</th>
                                    <th class="fw-normal">Unit Price</th>
                                    <th class="fw-normal">Brand</th>
                                    <th class="fw-normal">Item Name</th>
                                    <th class="fw-normal">Category</th>
                                    <th class="fw-normal">Images</th>
                                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() == 0)
                                    <th class="fw-normal">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($QuotationMaterials::where('quotation_id', $quotation->id)->get() as $material)
                                <tr>
                                    <td class="fw-light">{{$material->quantity}}</td>
                                    <td class="fw-light">{{$material->unit}}</td>
                                    <td class="fw-light">₱&nbsp;{{number_format($material->unit_price, 2)}}</td>
                                    <td class="fw-light">{{$material->brand}}</td>
                                    <td class="fw-light">{{$material->name}}</td>
                                    <td class="fw-light">{{$BomMaterialCategory::findOrFail($material->category_id)->name}}</td>
                                    <td class="fw-light">
                                        <div>
                                            {{-- View Image Button --}}
                                            <button wire:key='viewMaterialImageBtn_{{$material->id}}'
                                                class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewMaterialImage_{{$material->id}}">View
                                                Images</button>
                                            {{-- View Image Modal --}}
                                            <div wire:key='viewMaterialImage_{{$material->id}}' class="modal fade"
                                                id="viewMaterialImage_{{$material->id}}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-fullscreen">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <span class="modal-title fs-5">Images for
                                                                {{$material->name}}</span>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row p-4 d-flex">
                                                                @foreach ($QuotationMaterialImages::where('material_id',
                                                                $material->id)->get() as $image)
                                                                <img wire:loading.attr='hidden' class="img-thumbnail"
                                                                    style="height: 20%; width:25%;"
                                                                    src="{{route('material_image.show', ['materialImageFileName' => $image->file_name])}}"
                                                                    alt="Material Image">
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() == 0)
                                    <td>
                                        {{-- Delete Material --}}
                                        <div>
                                            <form wire:submit='DeleteMaterial({{$material->id}})'
                                                wire:key='deleteMaterialForm_{{$material->id}}'
                                                id="deleteMaterialForm_{{$material->id}}">
                                                <button wire:key='deleteMaterialBtn_{{$material->id}}'
                                                    id="deleteMaterialBtn_{{$material->id}}"
                                                    class="btn btn-sm btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash-fill"
                                                        viewBox="0 0 16 16">
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
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <small class="fw-bold">Total Price:&nbsp;</small>
                            <small>₱&nbsp;{{number_format($quotation->total_price, 2)}}</small>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end gap-2">
                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() == 0)
                    {{-- Add Material Button --}}
                    <div class="col-auto p-0">
                        <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#addMaterialModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                            </svg>
                            Add Material
                        </button>
                    </div>
                    {{-- Add Material Modal --}}
                    <div class="modal fade" wire:ignore id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                {{-- Add Material Form --}}
                                <livewire:supplier.components.create-quotation.add-material-form :selectedBomId="$selectedBomId">
                            </div>
                        </div>
                    </div> 
                    @endif
                    @if ($QuotationMaterials::where('quotation_id', $quotation->id)->count() > 0 && $SubmittedQuotations::where('quotation_id', $quotation->id)->count() == 0)
                    {{-- Submit Quotation Button --}}
                    <div class="col-auto p-0">
                        <button class="btn btn-secondary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#submitQuotationModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-send-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                                <path
                                    d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                            </svg>
                            Submit
                        </button>
                    </div>
                    {{-- Publish Quotation Modal --}}
                    <div class="modal fade" id="submitQuotationModal" tabindex="-1" aria-labelledby="publishQuotationLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                {{-- Publish Quotation Form --}}
                                <livewire:supplier.components.create-quotation.submit-quotation :quotation='$quotation'>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .tableHeader th {
            background: #042d69;
            color: white;
        }
    </style>
</div>