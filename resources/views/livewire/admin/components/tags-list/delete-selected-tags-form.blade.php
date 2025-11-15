<div>
    <div class="row mb-3 p-1">
        <div class="col">
            <span class="fw-bold">Suppliers</span> and <span class="fw-bold">Bill of Materials</span> will no longer have the selected tag(s). Are you sure?
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-end gap-1">
            <form wire:submit="DeleteSelectedTags">
                <button class="btn btn-success" data-bs-dismiss="modal">Confirm</button>
            </form>
            <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>