<div class="row mt-5 justify-content-center">
    @if (empty($selectedBomId))
    <div class="col-auto">
        {{-- Card --}}
        <div wire:loading.attr='hidden' class="card rounded-1" style="width: 60rem;">
            <div class="card-header rounded-top-1 text-white text-center fw-normal fs-6" style="background: #3e5877;">
                Quotations
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="min-height: 40vh;">
                    <table class="table table-hover table-sm table-borderless mb-0">
                        <thead class="border-bottom border-secondary-subtle">
                            <tr>
                                <th class="fw-normal ps-4">Quotation No.</th>
                                <th class="fw-normal">Bill of Materials</th>
                                <th class="fw-normal">Status</th>
                                <th class="fw-normal">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @inject('Bom', App\Models\Bom::class)
                            @inject('SubmittedQuotations', App\Models\SubmittedQuotation::class)
                            @foreach ($quotations as $quotation)
                            <tr>
                                <td class="ps-4">{{$quotation->id}}</td>
                                <td>{{$Bom::findOrFail($quotation->bom_id)->subject}}</td>
                                <td>
                                    {{-- Status --}}
                                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() > 0)
                                    <span class="badge rounded-pill text-bg-success">
                                        Submitted
                                    </span>
                                    {{-- Accept or Decline Status --}}
                                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->where('status', 'accepted')->count() > 0)
                                    <span class="badge rounded-pill" style="background: rgb(44, 191, 44);">
                                        Accepted
                                    </span>
                                    @elseif ($SubmittedQuotations::where('quotation_id', $quotation->id)->where('status', 'declined')->count() > 0)
                                    <span class="badge rounded-pill" style="background: rgb(230, 53, 53);">
                                        Declined
                                    </span>
                                    @endif
                                    @else
                                    <span class="badge text-bg-warning">
                                        Draft
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($SubmittedQuotations::where('quotation_id', $quotation->id)->count() > 0)
                                    <div>
                                        <a wire:loading.attr='disabled' wire:click='SelectBom({{$quotation->bom_id}})'
                                            class="link-secondary fw-normal" style="cursor: pointer;">View</a>
                                    </div>
                                    @else
                                    <div>
                                        <a wire:loading.attr='disabled' wire:click='SelectBom({{$quotation->bom_id}})'
                                            class="link-success fw-normal" style="cursor: pointer;">Edit</a>
                                    </div>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- Loading --}}
    <div wire:loading class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>