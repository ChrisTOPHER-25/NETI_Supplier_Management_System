<div class="row d-flex align-items-center justify-content-between">
    @inject('SupplierBomStatuses', App\Models\SupplierBomStatus::class)
    @inject ('Bom', App\Models\Bom::class)
    <div class="col-auto">
        <div>
            <div class="input-group">
                <span class="input-group-text border border-dark-subtle fw-bold text-white"
                    style="background: #3e5877;">Select a BOM:</span>
                <select wire:loading.attr='disabled' wire:target='SelectBom' wire:change='SelectBom' wire:model='bomId'
                    class="form-select bg-white border-dark-subtle">
                    <option value=""></option>
                    @foreach ($Bom::where('status', 'draft')->get() as $bom)
                    <option value="{{$bom->id}}">#{{$bom->id}}&nbsp;&nbsp;-&nbsp;&nbsp;{{$bom->subject}}</option>
                    @endforeach
                </select>
                <button wire:loading.attr='disabled' type="button" wire:click='SelectBom'
                    class="btn btn-primary d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" height="18"
                        fill="currentColor">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @if (empty($selectedBom) == false)
    {{-- Buttons --}}
    <div class="col-auto">
        <div class="d-flex align-items-center gap-1">
            @inject('BomMaterials', App\Models\BomMaterial::class)
            @inject('BomTags', App\Models\BomTag::class)
            @if ($selectedBom['status'] == "draft" && $BomMaterials::where('bom_id', $selectedBom['id'])->count() > 0)
            {{-- Publish BOM Button --}}
            <button wire:loading.attr='disabled' id="publishBomBtn"
                class="btn btn-success shadow-sm border border-dark-subtle d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#publishBomModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16"
                    fill="currentColor">
                    <path
                        d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3 192 320c0 17.7 14.3 32 32 32s32-14.3 32-32l0-210.7 73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-64z" />
                </svg>
                Publish
            </button>
            {{-- Publish BOM Modal --}}
            <div wire:loading.attr='hidden' class="modal fade" id="publishBomModal" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="publishBomLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="fs-4 modal-title">Publish BOM</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            {{-- Publish BOM --}}
                            @livewire('admin.components.manage-bom.publish-bom-form', ['selectedBom' => $selectedBom])
                        </div>
                    </div>
                </div>
            </div>
            @elseif ($selectedBom['status'] == 'published')
            {{-- Unpublish BOM Button --}}
            {{-- <button wire:loading.attr='disabled'
                class="btn btn-danger shadow-sm border border-dark-subtle d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#unpublishBomModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                    <path
                        d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708" />
                </svg>
                Unpublish
            </button> --}}
            
            {{-- Unpublish BOM Form --}}
            {{-- <div wire:loading.attr='hidden' class="modal fade" id="unpublishBomModal" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="unpublishBomLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="fs-4 modal-title">Unpublish BOM</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            @if ($SupplierBomStatuses::where('bom_id', $selectedBom['id'])->where('status', 'accepted')->count() == 0)

                            @livewire('admin.components.manage-bom.unpublish-bom-form', ['selectedBom' => $selectedBom])
                            @else
                            <span>You cannot unpublish this BOM as it has already been accepted by some suppliers</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div> --}}
            @endif

        </div>
    </div>
    @endif
</div>