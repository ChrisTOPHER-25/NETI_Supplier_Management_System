<div wire:key='quotationInfo_{{$quotationId}}' style="min-height: 70vh;">
    @inject('BomMaterialCategory', App\Models\BomMaterialCategory::class)
    @inject('User', App\Models\User::class)
    <div class="modal-header pt-3 pb-3">
        <span class="modal-title fs-5">View Quotation</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            wire:click='CloseMaterialInfo'></button>
    </div>
    <div class="modal-body p-4">
        {{-- If view info is clicked, show material info --}}
        @if ($viewingMaterialInfo)
        <livewire:admin.components.submitted-quotations.view-material-info :materialId='$viewingMaterialId'>
            {{-- Show quotation materials --}}
            @else
            <div class="row gap-2">
                <div class="col-auto">
                    <small class="fw-bold">Supplier Name:&nbsp;<span
                        class="fw-normal">{{$User::findOrFail($quotation->user_id)->name}}</span></small>
                </div>
                <div class="col-auto">
                    <small class="fw-bold">Date Submitted:&nbsp;<span
                            class="fw-normal">{{date_format($quotation->created_at, 'm/d/Y')}}</span></small>
                </div>
                <div class="col-auto">
                    <small class="fw-bold">Status:&nbsp;<span
                            class="fw-normal">{{ucfirst($quotationStatus)}}</span></small>
                </div>
            </div>
            <div class="row p-2">
                <div class="table-responsive border border-secondary-subtle p-0"
                    style="min-height: 50vh; max-height: 50vh;">
                    <table class="table table-hover table-sm table-borderless text-center">
                        <thead class="tableHeader">
                            <tr>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                                <th>Brand</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                            <tr class="border-bottom border-secondary-subtle">
                                <td>{{$material->quantity}}</td>
                                <td>{{$material->unit}}</td>
                                <td>₱&nbsp;{{number_format($material->unit_price, 2)}}</td>
                                <td>@if(empty($material->brand)) <span>N/A</span> @else {{$material->brand}} @endif</td>
                                <td>{{$material->name}}</td>
                                <td>{{$BomMaterialCategory::findOrFail($material->category_id)->name}}</td>
                                <td>
                                    <div>
                                        {{-- View Material Info Button --}}
                                        <form wire:submit='ViewMaterialInfo({{$material->id}})'
                                            id="viewMaterialInfoForm_{{$material->id}}">
                                            <button id="viewMaterialInfo_{{$material->id}}"
                                                class="btn btn-sm btn-secondary">View Info</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <table class="table table-borderless table-secondary border border-secondary-subtle border-top-0">
                    <tbody>
                        <tr>
                            <td colspan="7">
                                <div class="row d-flex flex-row justify-content-end gap-1">
                                    <div class="col-auto">
                                        <small class="fw-bold">
                                            Total Qty:&nbsp;<span class="fw-normal">{{$totalQty}}</span>
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <small class="fw-bold">
                                            Total Price:&nbsp;<span
                                                class="fw-normal">₱&nbsp;{{number_format($quotation->total_price,
                                                2)}}</span>
                                        </small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($quotationStatus == 'pending')
            <div class="row justify-content-end">
                <div class="col-auto">
                    <form wire:submit='AcceptQuotation({{$quotation->id}})' wire:key='acceptQuotationForm_{{$quotation->id}}' id="acceptQuotationForm_{{$quotation->id}}">
                        <button data-bs-dismiss="modal" wire:key='acceptQuotationBtn_{{$quotation->id}}' id="acceptQuotationBtn_{{$quotation->id}}" class="btn btn-sm btn-success">Accept</button>
                    </form>
                </div>
            </div>
            @endif
            @endif
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }
    </style>
</div>