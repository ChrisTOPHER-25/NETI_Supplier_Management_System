<div>
    @inject('SupplierBomStatus', App\Models\SupplierBomStatus::class)
    @if (count($SupplierBomStatus::where('bom_id', $selectedBom['id'])->where('status', 'accepted')->get()) > 0)
    <span class="text-center">You cannot unpublish this BOM because some suppliers have already accepted it.</span>
    @else
    <div class="row mb-2">
        <span>The <span class="fw-bold">Bill of Materials #{{$selectedBom['id']}}
                ({{$selectedBom['subject']}})</span> will be unpublished.</span>
    </div>
    <hr class="mt-3 mb-3">
    <div class="row">
        <span>Do you wish to continue?</span>
    </div>
    <div class="row">
        <div class="d-flex gap-1 justify-content-end">
            <form wire:submit='UnpublishBom'>
                <button type="submit" id="unpublishBomBtn" class="btn btn-success btn-sm"
                    data-bs-dismiss="modal">Confirm</button>
            </form>
            <button class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
    </div>
    @endif
</div>
