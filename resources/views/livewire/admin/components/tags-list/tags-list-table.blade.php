<div>
    <div>
        <div class="p-3 pb-0 rounded-top-2" style="background: #3e5877;">
            <div class="row pb-3 justify-content-end">
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteSelectedTags">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                        Delete
                    </button>
                    {{-- Delete Selected Tags Modal --}}
                    <div wire:ignore class="modal fade" id="deleteSelectedTags" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="deleteSelectedTagsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-2">
                                <div class="modal-header">
                                    <span class="fs-4 modal-title">Delete Tags</span>
                                </div>
                                <div class="modal-body">
                                    @livewire('admin.components.tags-list.delete-selected-tags-form')
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive" style="max-height: 60vh;">
        <table class="table table-hover table-borderless shadow-sm">
            <thead class="tableHeader">
                <tr class="sticky-top">
                    <th class="text-center" style="width: 5%;">
                        <input wire:change='ChangeTagsSelectedState' wire:model='selectAll' type="checkbox"
                            class="form-check-input border-secondary" style="cursor: pointer;">
                    </th>
                    <th>Id</th>
                    <th>Name</th>
                    {{-- <th>Info</th> --}}
                    {{-- <th>No. of Suppliers using this tag</th>
                    <th>No. of BOMs using this tag</th> --}}
                    <th>Is a Category?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @inject('Tags', App\Models\Tag::class)
                @inject('SupplierTags', App\Models\SupplierTag::class)
                @inject('Suppliers', App\Models\User::class)
                @inject('BomTags', App\Models\BomTag::class)
                @inject('Boms', App\Models\Bom::class)
                @inject('BomMaterialCategories', App\Models\BomMaterialCategory::class)
                @foreach ($tagsList as $tag)
                <tr wire:key='tagRow_{{$tag->id}}'>
                    <td class="text-center" style="width: 5%;">
                        @if ($SupplierTags::where('tag_id', $tag->id)->count() == 0 && 
                        $BomTags::where('tag_id', $tag->id)->count() == 0 && $BomMaterialCategories::where('name', $tag->name)->count() == 0)
                        <input id="selectTag_{{$tag->id}}" name="selectTag_{{$tag->id}}" type="checkbox" wire:model='selectedTags.{{$tag->id}}' wire:change='UnselectSelectAll({{$tag->id}})' class="form-check-input border-secondary" style="cursor: pointer;">
                        @else
                        <input id="selectTag_{{$tag->id}}" name="selectTag_{{$tag->id}}" type="checkbox" disabled class="form-check-input border-secondary bg-dark" style="cursor: pointer;">
                        @endif
                        
                    </td>
                    <td>
                        <label for="selectTag_{{$tag->id}}" class="form-label w-100" style="cursor: pointer;">
                            {{$tag->id}}
                        </label>
                    </td>
                    <td>
                        <label for="selectTag_{{$tag->id}}" class="form-label w-100" style="cursor: pointer;">
                            {{$tag->name}}
                        </label>
                    </td>
                    {{-- <td>
                        <div class="d-flex flex-column">
                            <small class="fw-bold">No. of Suppliers: <span class="fw-normal">{{$SupplierTags::where('tag_id', $tag->id)->count()}}</span></small>
                            <small class="fw-bold">No. of BOMs: <span class="fw-normal">{{$BomTags::where('tag_id', $tag->id)->count()}}</span></small>
                            <small class="fw-bold">Is a category:&nbsp;
                                <span class="fw-normal">                                    
                                    @if ($BomMaterialCategories::where('name', $tag->name)->count() > 0)
                                    Yes
                                    @else
                                    No                                    
                                    @endif
                                </span>
                            </small>
                        </div>
                    </td> --}}
                    {{-- <td>
                        <label for="selectTag_{{$tag->id}}" class="form-label w-100" style="cursor: pointer;">
                            {{$SupplierTags::where('tag_id', $tag->id)->count()}}
                        </label>
                    </td>
                    <td>
                        <label for="selectTag_{{$tag->id}}" class="form-label w-100" style="cursor: pointer;">
                            {{$BomTags::where('tag_id', $tag->id)->count()}}
                        </label>
                    </td> --}}
                    <td>
                        <label for="selectTag_{{$tag->id}}" class="form-label w-100" style="cursor: pointer;">
                            @if ($BomMaterialCategories::where('name', $tag->name)->count() > 0)
                            Yes
                            @else
                            No                                    
                            @endif
                        </label>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            {{-- View Tag Info Button --}}
                            <button wire:key='viewTagInfoBtn_{{$tag->id}}' id="viewTagInfoBtn_{{$tag->id}}"
                                class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                                data-bs-target="#viewTagInfoModal_{{$tag->id}}">
                                View Info
                            </button>
                            <!-- View Tag Info Modal -->
                            <div wire:key='viewTagInfoModal_{{$tag->id}}' class="modal fade" id="viewTagInfoModal_{{$tag->id}}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewTagLabel_{{$tag->id}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title fs-4" id="viewTagLabel_{{$tag->id}}">Tag
                                                ({{$tag->name}})</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                {{-- List of BOMs & Suppliers using the tag --}}
                                                <div class="table-responsive d-flex" style="max-height: 50vh; min-height: 50vh;">
                                                    <div class="col">
                                                        {{-- Suppliers --}}
                                                        <table class="table table-hover border">
                                                            <thead class="text-center table-secondary">
                                                                <tr>
                                                                    <th class="fw-normal">Suppliers</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($SupplierTags::where('tag_id', $tag->id)->get() as $st)
                                                                <tr class="">
                                                                    <td class="text-center">
                                                                        {{$Suppliers::findOrFail($st->user_id)->name}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col">
                                                        {{-- Bill of Materials --}}
                                                        <table class="table table-hover border">
                                                            <thead class="text-center table-secondary fw-normal">
                                                                <tr class="border-end border-dark-subtle">
                                                                    <th class="fw-normal">Bill of Materials</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($BomTags::where('tag_id', $tag->id)->get() as $bt)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        {{$Boms::findOrFail($bt->bom_id)->subject}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                {{-- <style>
                    .tableHeader th {
                        background: #3e5877;
                        color: white;
                    }
                </style> --}}
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