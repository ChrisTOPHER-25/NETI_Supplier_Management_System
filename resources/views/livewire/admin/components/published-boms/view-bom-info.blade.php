<div wire:key='viewBomInfo_{{$bom->id}}'>
    <div class="modal-header">
        <span class="modal-title fs-5">Bill of Materials #{{$bom->id}}</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">
        {{-- Subject & Department --}}
        <div class="row mb-3">
            <div class="col-auto d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text text-white" style="background: #3e5877;">Subject</span>
                    <input type="text" class="form-control bg-white border-dark-subtle" readonly value="{{$bom->subject}}">
                </div>
                @inject('BomDepartment', App\Models\BomDepartment::class)
                <div class="input-group">
                    <span class="input-group-text text-white" style="background: #3e5877;">Department</span>
                    <input type="text" class="form-control bg-white border-dark-subtle" readonly value="{{$BomDepartment::findOrfail($bom->department_id)->name}}">
                </div>
            </div>
        </div>
        {{-- Date Created & Published & No. of Suppliers Accepted & Declined --}}
        @inject('PublishedBom', App\Models\PublishedBom::class)
        @inject('SupplierBomStatus', App\Models\SupplierBomStatus::class)
        @inject('ClosedBoms', App\Models\ClosedBom::class)
        <div class="row mb-1 justify-content-between">
            <div class="col d-flex gap-5">
                <div class="col-auto">
                    <small class="fw-bold">Date Created:&nbsp;</small>
                    <small>{{date_format($bom->created_at, 'm/d/Y')}}</small>
                </div>
                @if ($bom->status == 'published')
                <div class="col-auto">
                    <small class="fw-bold">Date Published:&nbsp;</small>
                    <small>
                        {{date_format($PublishedBom::where('bom_id', $bom->id)->firstOrfail()->created_at, 'm/d/Y')}}
                    </small>
                </div>
                @elseif ($bom->status == 'closed')
                <div class="col-auto">
                    <small class="fw-bold">Date Closed:&nbsp;</small>
                    <small>
                        {{date_format($ClosedBoms::where('bom_id', $bom->id)->firstOrFail()->created_at, 'm/d/Y')}}
                    </small>
                </div>   
                @endif
            </div>
            @if ($bom->status == 'published')
            <div class="col-auto">
                <small class="fw-bold">No. of Suppliers Accepted:</small>
                <small>{{$SupplierBomStatus::where('bom_id', $bom->id)->where('status', 'accepted')->count()}}</small>
            </div>
            @elseif ($bom->status == 'closed')
            <div class="col-auto">
                <small class="fw-bold">Quotation ID:</small>
                <small>&nbsp;TEMP</small>
            </div>
            @endif
        </div>
        {{-- Materials Table --}}
        <div class="row">
            <div class="col">
                <div class="table-responsive border border-dark-subtle" style="min-height: 60vh; max-height: 60vh;">
                    <table class="table table-hover table-borderless">
                        <thead class="table-secondary">
                            <tr>
                                <th class="fw-normal">Id</th>
                                <th class="fw-normal">Qty</th>
                                <th class="fw-normal">Brand</th>
                                <th class="fw-normal">Item Name</th>
                                <th class="fw-normal">Category</th>
                                <th class="fw-normal">Specification</th>
                            </th>
                        </thead>
                        <tbody>
                            @inject('BomMaterials', App\Models\BomMaterial::class)
                            @inject('BomMaterialCategory', App\Models\BomMaterialCategory::class)
                            @foreach ($BomMaterials::where('bom_id', $bom->id)->get() as $material)
                            <tr class="border-bottom">
                                <td>{{$material->id}}</td>
                                <td>{{$material->quantity}}</td>
                                <td>{{$material->brand}}</td>
                                <td>{{$material->name}}</td>
                                <td>{{$BomMaterialCategory::findOrfail($material->category_id)->name}}</td>
                                <td>
                                    <textarea name="description_{{$bom->id}}{{$material->id}}" id="description_{{$bom->id}}{{$material->id}}" 
                                        cols="20" rows="2" class="form-control bg-white border-dark-subtle" readonly>{{$material->description}}</textarea>
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
