<div>
    @inject('Users', App\Models\User::class)
    @inject('ArchivedAccounts', App\Models\ArchivedAccount::class)
    <div>
        <div class="p-3 pb-0 rounded-top-2" style="background: #3e5877;">
            <div class="row pb-2 justify-content-between">
                {{-- Search Supplier --}}
                <div class="col-auto">
                    <div class="input-group">
                        <form wire:submit='SearchSupplier'>
                            <input wire:model='searchedSupplier' type="text" class="form-control bg-white border-dark-subtle rounded-end-0"
                            placeholder="Enter supplier name ...">
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
    <div class="table-responsive">
        <table class="table table-hover table-borderless shadow-sm mb-0">
            <thead class="tableHeader">
                <tr>
                    <th class="text-center">Id</th>
                    <th>Supplier Name</th>
                    <th>Email</th>
                    <th>Account Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                <tr wire:key='supplierRow_{{$supplier->id}}'>
                    <td class="text-center">{{$supplier->id}}</td>
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->email}}</td>
                    <td>
                        @if ($ArchivedAccounts::where('user_id', $supplier->id)->count() > 0)
                        <span class="badge rounded-pill text-bg-danger">Archived</span>
                        @else
                        <span class="badge rounded-pill text-bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            {{-- View Supplier Info Button --}}
                            <button wire:key='editSupplierInfoBtn_{{$supplier->id}}'
                                id="editSupplierInfoBtn_{{$supplier->id}}"
                                class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal"
                                data-bs-target="#editSupplierInfo_{{$supplier->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                                Edit Info
                            </button>

                            @if ($ArchivedAccounts::where('user_id', $supplier->id)->count() > 0)
                            {{-- Unarchive Button --}}
                            <form wire:submit='UnarchiveUser({{$supplier->id}})' wire:key="unarchiveUserForm_{{$supplier->id}}" id="unarchiveUserForm_{{$supplier->id}}">
                                <button wire:key='unarchiveUserBtn_{{$supplier->id}}' id="unarchiveUserBtn_{{$supplier->id}}" class="btn btn-sm btn-success shadow-sm d-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16"
                                        fill="currentColor">
                                        <path
                                            d="M272 416c17.7 0 32-14.3 32-32s-14.3-32-32-32H160c-17.7 0-32-14.3-32-32V192h32c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-64-64c-12.5-12.5-32.8-12.5-45.3 0l-64 64c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8l32 0 0 128c0 53 43 96 96 96H272zM304 96c-17.7 0-32 14.3-32 32s14.3 32 32 32l112 0c17.7 0 32 14.3 32 32l0 128H416c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l64 64c12.5 12.5 32.8 12.5 45.3 0l64-64c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8l-32 0V192c0-53-43-96-96-96L304 96z" />
                                    </svg>
                                    Unarchive
                                </button>
                            </form>
                            @else
                            {{-- Archive Button --}}
                            <form wire:submit='ArchiveUser({{$supplier->id}})' wire:key='archiveUserForm_{{$supplier->id}}' id="archiveUserForm_{{$supplier->id}}">
                                <button wire:key='archiveUserBtn_{{$supplier->id}}' id="archiveUserBtn_{{$supplier->id}}" class="btn btn-sm btn-danger shadow-sm d-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-archive-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z" />
                                    </svg>
                                    Archive
                                </button>
                            </form>
                            @endif


                        </div>

                        {{-- Edit Supplier Info Modal --}}
                        <div wire:ignore wire:key='editSupplierInfo_{{$supplier->id}}' class="modal fade"
                            id="editSupplierInfo_{{$supplier->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="modal-title fs-5" id="staticBackdropLabel">Edit Supplier
                                            Info</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <livewire:admin.components.supplier-list.edit-supplier-info :supplier='$supplier'
                                        wire:key='editSupplierInfo_{{$supplier->id}}'>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table border-top">
            <tbody>
                <tr>
                    <td>
                        {{$suppliers->links(data: ['scrollTo' => false])}}
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
    </style>
</div>