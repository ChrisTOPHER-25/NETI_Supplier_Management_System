<div>
    @if (empty($selectedBom) == false)
    @inject('BomTags', App\Models\BomTag::class)
    <div class="row @if(empty($bomTags)==false)mb-3 @endif">
        @if (empty($bomTags))
        <span class="text-center">Please assign tags to this BOM before publishing</span>
        @else
        <span>This BOM will be published to suppliers that use the tag(s):</span>
        @endif
    </div>
    @if(empty($bomTags) == false)
    <div class="row mb-4">
        <div class="d-flex gap-1">
            @foreach ($bomTags as $tag)
            <div class="col-auto p-0">
                {{-- <span>{{$tag['name']}}@if($loop->last == false),@endif</span> --}}
                <span class="badge rounded-pill text-bg-primary fs-6">{{$tag['name']}}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @inject('BomTags', App\Models\BomTag::class)
    @if ($BomTags::where('bom_id', $this->selectedBom['id'])->count() > 0)
    <hr class="mt-3 mb-3">
    <div class="row">
        <span>Do you wish to continue?</span>
        <div class="d-flex gap-1 justify-content-end">
            <form wire:submit='Publish'>
                <button class="btn btn-success btn-sm" data-bs-dismiss="modal">Confirm</button>
            </form>
            <button class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
    </div>
    @endif

    @endif
</div>