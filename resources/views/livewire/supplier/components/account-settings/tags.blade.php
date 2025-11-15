<div>
    @inject('Tags', App\Models\Tag::class)
    <div class="rounded-3 bg-white shadow-sm p-5">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label fs-3 fw-strong">Supplier Tags</label>
                <hr class="my-1">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <label class="form-label">Your current tags are:</label>
            </div>
        </div>
        <div class="row">
            <div class="row gap-1 gy-1 m-0">
                @foreach ($SupplierTags as $st)
                <div class="col-auto p-0">
                    {{-- <form wire:submit='RemoveTag({{$st->tag_id}})'>
                        <span class="tagBtn badge rounded-pill text-bg-primary fs-6 d-flex align-items-center gap-2">
                            {{$Tags::findOrFail($st->tag_id)->name}}
                            <button type="submit" class="btn p-0 tagRemoveBtn border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16"
                                    fill="white">
                                    <path
                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                </svg>
                            </button>
                        </span>
                    </form> --}}
                    <div>
                        <span class="tagBtn badge rounded-pill text-bg-primary fs-6 d-flex align-items-center gap-2">
                            {{$Tags::findOrFail($st->tag_id)->name}}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{--
        <hr class="mt-4 mb-4">
        <div class="row">
            <div class="col-4">
                <label for="newTag" class="form-label">Add a new tag</label>
                <form wire:submit='AddTag'>
                    <div class="input-group">
                        <input wire:keydown='ValidateField("newTagName")' wire:model='newTagName' type="text"
                            class="form-control bg-white border-dark-subtle @error('newTagName')is-invalid @enderror"
                            id="newTag" name="newTag">
                        <button class="btn btn-success d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                            </svg>
                            Add
                        </button>
                    </div>
                    @error('newTagName')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </form>
            </div>
        </div> --}}
    </div>
    <style>
        .tagBtn:hover {
            transform: scale(1.05);
            transition: transform 0.1s;
        }
    </style>
</div>