<div>
    <div class="table-responsive">
        <div>
            <div class="p-3 rounded-top-2" style="background: #3e5877;">
                <div class="row">
                    <div class="col-auto">
                        {{-- Search BOM --}}
                        <div class="input-group">
                            <form wire:submit='SearchBom'>
                                <input wire:model='searchedBom' type="text" class="form-control bg-white border-dark-subtle rounded-end-0"
                                placeholder="Search Bill of Materials ...">
                            </form>
                            <button wire:click='ResetSearch' class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16"
                                    fill="currentColor">
                                    <path
                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover table-borderless shadow-sm mb-0">
            <thead class="tableHeader">
                <tr>
                    <th class="text-center" style="width: 6%;">
                        <div wire:click='OrderBy("id")' class="dropdown dropdown-toggle" style="cursor:pointer;">Id</div>
                    </th>
                    <th>
                        <div wire:click='OrderBy("subject")' class="dropdown dropdown-toggle d-flex justify-content-between align-items-center" style="cursor:pointer;">Subject</div>
                    </th>
                    <th>
                        <div wire:click='OrderBy("department_id")' class="dropdown dropdown-toggle d-flex justify-content-between align-items-center" style="cursor:pointer;">Department</div>
                    </th>
                    <th>
                        <div wire:click='OrderBy("status")' class="dropdown dropdown-toggle d-flex justify-content-between align-items-center" style="cursor:pointer;">Status</div>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @inject('BomDepartment', App\Models\BomDepartment::class)
                @foreach ($publishedBoms as $bom)
                <tr wire:key='bomRow_{{$bom->id}}'>
                    <td class="text-center">{{$bom->id}}</td>
                    <td>{{$bom->subject}}</td>
                    <td>{{$BomDepartment::findOrFail($bom->department_id)->name}}</td>
                    <td>
                        <span class="badge rounded-pill p-2 pt-1 pb-1
                        @if ($bom->status == 'published')
                        text-bg-success
                        @elseif ($bom->status == 'closed')
                        text-bg-danger                            
                        @endif">
                            {{ucfirst($bom->status)}}
                        </span>
                    </td>
                    <td>
                        @if ($bom->status == 'published' || $bom->status == 'closed')
                        <div class="d-flex gap-1">
                            {{-- View BOM Info Button --}}
                            <button id="viewBomInfo_{{$bom->id}}" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#viewBomInfoModal_{{$bom->id}}">
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg> --}}
                                View Info
                            </button>
                            {{-- View BOM Info Modal --}}
                            <div wire:ignore wire:key='viewBomInfoModal_{{$bom->id}}' class="modal fade"
                                id="viewBomInfoModal_{{$bom->id}}" tabindex="-1"
                                aria-labelledby="viewBomInfoLabel_{{$bom->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content rounded-2">
                                        {{-- View BOM Info --}}
                                        <livewire:admin.components.published-boms.view-bom-info :bom='$bom'
                                            wire:key='viewBomInfo_{{$bom->id}}'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table border border-start-0 border-end-0">
            <tbody>
                <tr>
                    <td colspan="5">
                        {{ $publishedBoms->links(data: ['scrollTo' => false]) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <style>
        .tableHeader th {
            background: #3e5877;
            color: white;
        }

        .form-label {
            cursor: pointer;
        }
    </style>
</div>