<div>
    @inject('BomDepartments', App\Models\BomDepartment::class)
    @inject('BomMaterialCategory', App\Models\BomMaterialCategory::class)
    {{-- Subject & Department --}}
    <div class="row mb-1 d-flex align-items-center justify-content-between">
        <div class="col-auto d-flex gap-3">
            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text text-bg-light fw-normal bg-secondary-subtle border-dark-subtle">Subject</span>
                <input type="text" class="form-control bg-white border border-dark-subtle" readonly value="{{$bom['subject']}}">
            </div>
            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text text-bg-light fw-normal bg-secondary-subtle border-dark-subtle">Department</span>
                <input type="text" class="form-control bg-white border border-dark-subtle" readonly value="{{$BomDepartments::findOrFail($bom['department_id'])->name}}">
            </div>
        </div>
    </div>
    {{-- Tags --}}
    <div class="row mb-2">

    </div>
    <div class="row mb-1">
        <div class="col">
            {{-- Accept & Decline --}}
            <div class="d-flex justify-content-end gap-1 mb-3">
                @inject('SupplierBomStatus', App\Models\SupplierBomStatus::class)
                @if ($SupplierBomStatus::where('bom_id', $bom->id)->where('user_id', Auth::user()->id)->count() == 0)
                <form id="acceptBomForm" wire:submit='AcceptBom({{$bom->id}})'>
                    <button id="acceptBomBtn" class="btn btn-sm btn-success">Accept</button>
                </form>
                <form id="declineBomForm" wire:submit='DeclineBom({{$bom->id}})'>
                    <button id="declineBomBtn" class="btn btn-sm btn-danger">Decline</button>
                </form>
                @endif
            </div>
            {{-- Materials --}}
            <div class="table-responsive border border-dark-subtle" style="min-height: 55vh;">
                <table class="table table-hover table-borderless" >
                    <thead class="table-secondary">
                        <tr>
                            <th class="fw-normal text-center">Qty</th>
                            <th class="fw-normal text-center">Unit</th>
                            <th class="fw-normal text-center">Model/Name</th>
                            <th class="fw-normal text-center">Brand</th>
                            <th class="fw-normal text-center">Category</th>
                            <th class="fw-normal text-center">Description</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($bomMaterials as $material)
                        <tr>
                            <td class="fw-light text-center">{{$material->quantity}}</td>
                            <td class="fw-light text-center">{{$material->unit}}</td>
                            <td class="fw-light text-center">{{$material->name}}</td>
                            <td class="fw-light text-center">{{$material->brand}}</td>
                            <td class="fw-light text-center">{{$BomMaterialCategory::findOrFail($material->category_id)->name}}</td>
                            <td class="fw-light text-center">
                                <textarea name="description_{{$material->id}}" id="description_{{$material->id}}" cols="10" rows="2" 
                                    class="form-control bg-white border-dark-subtle" readonly>{{$material->description}}
                                </textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Accept & Publish Dates --}}
    <div class="row justify-content-end">
        @if ($bomStatus)
        <div class="col-auto">
            <small>
                {{ ucfirst($bomStatus->status) }}&nbsp;on&nbsp;{{ date_format($bomStatus->created_at, "m/d/Y") }}
            </small>
        </div>
        @endif
        <div class="col-auto">
            <small>
                Published on {{ date_format($bom->created_at, "m/d/Y") }}
            </small>
        </div>
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }
        .form-control::placeholder {
            color: black;
        }
    </style>
</div>
