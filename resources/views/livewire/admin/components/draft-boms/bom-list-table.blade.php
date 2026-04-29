<div>
    <div class="table-responsive">
        <div>
            <div class="p-3 rounded-top-2" style="background: #3e5877;">
                <div class="row justify-content-between">
                    {{-- Search & Reset --}}
                    <div class="col-auto d-flex">
                        <div class="input-group">
                            {{-- Search BOM --}}
                            <form wire:submit='SearchBom'>
                                <input wire:model='searchedBom' type="text"
                                    class="form-control bg-white border-dark-subtle rounded-end-0"
                                    placeholder="Search Bill of Materials ...">
                            </form>
                            {{-- Reset Search Button --}}
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
                    {{-- Buttons --}}
                    <div class="col-auto">
                        <form>
                            <button id="deleteSelectedBoms" class="btn btn-sm btn-danger">Delete All</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover table-borderless mb-0" id="myTable">
            <thead class="tableHeader">
                <tr>
                    <th class="text-center">Id</th>
                    <th>Subject</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @inject('BomDepartment', App\Models\BomDepartment::class)
                @foreach ($draftBoms as $bom)
                <tr wire:key='bomRow_{{$bom->id}}'>
                    <td class="text-center">
                        <label for="bomCheck_{{$bom->id}}" class="form-label w-100"
                            style="cursor:pointer;">{{$bom->id}}</label>
                    </td>
                    <td>
                        <label for="bomCheck_{{$bom->id}}" class="form-label w-100"
                            style="cursor:pointer;">{{$bom->subject}}</label>
                    </td>
                    <td>
                        <label for="bomCheck_{{$bom->id}}" class="form-label w-100" style="cursor:pointer;">
                            {{$BomDepartment::findOrFail($bom->department_id)->name}}
                        </label>
                    </td>
                    <td>
                        <span class="badge rounded-pill text-bg-warning p-2 pt-1 pb-1">
                            {{ucfirst($bom->status)}}
                        </span>
                    </td>
                    <td>
                        <span>
                            {{date_format($bom->created_at, 'm/d/Y')}}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            {{-- Manage Bom Button --}}
                            <form wire:submit='ManageBom({{$bom->id}})' wire:key='manageBom_{{$bom->id}}'>
                                <button class="btn btn-sm btn-success d-flex align-items-center gap-1"
                                    wire:key='manageBomBtn_{{$bom->id}}'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                    Edit
                                </button>
                            </form>
                            {{-- Delete BOM Button --}}
                            <button wire:key='deleteBomBtn_{{$bom->id}}' id="deleteBomBtn_{{$bom->id}}" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteBomModal_{{$bom->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                                Delete
                            </button>
                            <!-- Delete BOM Modal -->
                            <div wire:key='deleteBomModal_{{$bom->id}}' class="modal fade" id="deleteBomModal_{{$bom->id}}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Are you sure?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            You are about to delete Bill of Materials #{{$bom->id}}&nbsp;({{$bom->subject}})
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal" wire:click='DeleteBom({{$bom->id}})'>Confirm</button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table border-start-0 border-end-0 border">
            <tbody>
                <tr class="text-end">
                    <td colspan="5" class="">
                        <div>
                            {{ $draftBoms->links(data: ['scrollTo' => false]) }}
                        </div>
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

    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <style rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    </style>
    <style rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.css"></style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.bootstrap5.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script> --}}
</div>