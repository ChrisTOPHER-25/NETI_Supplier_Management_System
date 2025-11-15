<style>
    .custom-bg th{
        background: #3e5877;
        color: white;
    }
</style>

<div>
    <div class="table-responsive">
        <table class="table table-hover table-borderless border border-secondary-subtle">
            <thead class="tableHeader">
                <tr>
                    <th class="fw-normal">Subject</th>
                    <th class="fw-normal">Department</th>
                    <th class="fw-normal">Date Published</th>
                    <th class="fw-normal">Status</th>
                    <th class="fw-normal">Action</th>
                </tr>
            </thead>
            <tbody>
                @inject('BomDepartment', App\Models\BomDepartment::class)
                @inject('SupplierBomStatus', App\Models\SupplierBomStatus::class)
                @inject('Quotations', App\Models\Quotation::class)
                @inject('SubmittedQuotations', App\Models\SubmittedQuotation::class)
                @foreach ($PublishedBoms as $bom)
                <tr>
                    <td>{{$bom->subject}}</td>
                    <td>{{$BomDepartment::findOrFail($bom->department_id)->name}}</td>
                    <td>{{date_format($bom->created_at, 'm/d/Y')}}</td>
                    <td>
                        @if ($bom->status == 'published')
                        <span class="badge rounded-pill text-bg-success">
                            Ongoing
                        </span>
                        @endif
                        @if ($SupplierBomStatus::where('user_id', Auth::user()->id)->count() > 0)
                            @if (!empty($SubmittedQuotationStatuses[$bom->id]) && $SubmittedQuotationStatuses[$bom->id] == 'pending')
                            <span class="badge rounded-pill text-bg-warning">
                                Quotation Submitted
                            </span>
                            @elseif ($SupplierBomStatus::where('bom_id', $bom->id)->
                            where('user_id', Auth::user()->id)->
                            where('status', 'declined')->count() > 0)
                            <span class="badge rounded-pill" style="background: rgb(229, 60, 60);">
                                Declined
                            </span>
                            @endif
                        @endif
                    </td>
                    <td>
                        {{-- View BOM Button --}}
                        <button wire:key='viewBomBtn_{{$bom->id}}' id="viewBomBtn_{{$bom->id}}"
                            class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBomModal_{{$bom->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16"
                                fill="currentColor">
                                <path
                                    d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                            </svg>
                            View
                        </button>
                        <!-- View Bom Modal -->
                        <div wire:key='viewBomModal_{{$bom->id}}' class="modal fade" id="viewBomModal_{{$bom->id}}"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="modal-title fs-4">Bill of Materials
                                            #{{$bom->id}}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4" style="min-height: 80vh;">
                                        {{-- View BOM Info --}}
                                        @livewire('supplier.components.boms.view-bom-info', ['bom' => $bom])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }
    </style>
</div>
