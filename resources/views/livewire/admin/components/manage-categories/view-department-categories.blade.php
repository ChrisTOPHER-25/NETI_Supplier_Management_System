<div>
    <div class="modal-body">
        @inject('BomMaterials', App\Models\BomMaterial::class)
        <div class="row mb-3 justify-content-end">
            <div class='col-auto'>
                <div class="input-group">
                    <form wire:submit='SearchCategory' class="">
                        <input wire:model='searchedCategory' type="text" class="form-control bg-white border-dark-subtle rounded-end-0"
                        placeholder="Enter category name ...">
                    </form>
                    <button wire:click='ResetSearch' class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path
                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive border border-dark-subtle" wire:key='categoriesTable_{{$departmentId}}'
            style="max-height: 60vh; min-height: 60vh;">
            <table class="table table-hover table-borderless">
                <thead class="table-secondary">
                    <tr class="sticky-top">
                        <th class="fw-normal">Id</th>
                        <th class="fw-normal">Name</th>
                        <th class="fw-normal">Unit</th>
                        <th class="fw-normal">Uses Brand</th>
                        <th class="fw-normal">Is currently used?</th>
                        <th class="fw-normal">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr wire:key='categoryRow_{{$category->id}}'>
                        <td class="fw-light">
                            <label for="categoryCheck_{{$category->id}}" class="form-label w-100"
                                style="cursor:pointer;">{{$category->id}}</label>
                        </td>
                        <td class="fw-light">
                            <label for="categoryCheck_{{$category->id}}" class="form-label w-100"
                                style="cursor:pointer;">{{$category->name}}</label>
                        </td>
                        <td>{{$category->unit}}</td>
                        <td>
                            <label for="categoryCheck_{{$category->id}}" class="form-label w-100"
                                style="cursor: pointer;">
                                @if ($category->uses_brand)
                                <span>Yes</span>
                                @else
                                <span>No</span>
                                @endif
                            </label>
                        </td>
                        <td class="fw-light">
                            @if ($BomMaterials::where('category_id', $category->id)->count() > 0)
                            <span class="badge rounded-pill text-bg-warning">Yes</span>
                            @else
                            <span class="badge rounded-pill text-bg-success">No</span>
                            @endif
                        </td>
                        <td>
                            {{-- Delete Category Button --}}
                            <div>
                                @if ($BomMaterials::where('category_id', $category->id)->count() == 0)
                                <form wire:submit='DeleteCategory({{$category->id}})' wire:key='deleteCategoryForm_{{$category->id}}' id="deleteCategoryForm_{{$category->id}}">
                                    <button wire:loading.attr='disabled'
                                        wire:key='deleteCategoryBtn_{{$category->id}}'
                                        id="deleteCategoryBtn_{{$category->id}}" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                        </svg>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-danger" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <table class="table table-sm table-light border border-secondary-subtle border-top-0">
            <tbody>
                <tr>
                    <td>
                        <div>{{$categories->links(data: ['scrollTo' => false])}}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>