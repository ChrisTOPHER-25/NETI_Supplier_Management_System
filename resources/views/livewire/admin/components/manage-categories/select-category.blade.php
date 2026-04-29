<div>
    <div class="row mb-3">
        <div class="col-auto">
            <div class="d-flex align-items-center gap-3">
                <div class="input-group">
                    <span class="input-group-text shadow-sm border">Select a Category</span>
                    <select wire:loading.attr='disabled' wire:model='categoryId' wire:change='SelectCategory' class="form-select bg-white">
                        <option value=""></option>
                        {{-- @foreach ($BomCategory::get() as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach --}}
                    </select>
                    <form wire:submit='DeleteCategory'>
                        <button wire:loading.attr='disabled' class="btn btn-danger rounded-start-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                              </svg>
                        </button>
                    </form>
                </div>
                <div wire:loading>
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
    {{session('message')}}        
    @endif
</div>
