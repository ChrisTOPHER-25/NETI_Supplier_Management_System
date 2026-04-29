<div>
    <div class="modal-header pb-2 pt-2">
        <span class="fs-5">Submit Quotation</span>
    </div>
    <div class="modal-body">
        <span>Are you sure you want to submit this quotation?</span>
    </div>
    <div class="modal-footer pb-2 pt-2">
        <form wire:submit='SubmitQuotation'>
            <button id="confirmPublishBtn" class="btn btn-sm btn-success" data-bs-dismiss="modal">Confirm</button>
        </form>
        <button class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
