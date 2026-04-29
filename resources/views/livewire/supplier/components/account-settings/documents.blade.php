<div>
    <div>
        <!-- Upload Document-->
        <div class="rounded-3 bg-white shadow-sm p-5 mb-4">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label fs-3 fw-strong">Upload Document</label>
                    <hr class="my-1">
                </div>
            </div>
            <form wire:submit.prevent="submit" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control w-50" id="title" placeholder="Enter title"
                        wire:model.defer="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control w-50" id="file" wire:model="file"> @error('file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div wire:loading wire:target="file">Uploading...</div>
                @if (!empty($file))
                    <div class="pt-3">
                        <button type="submit" class="btn btn-success btn-sm pr-3">Upload File</button>
                    </div>
                @endif
            </form>
        </div>
        <!-- Uploaded Document -->
        <div class="rounded-3 shadow-sm p-5 bg-white mt-3 mb-3">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label fs-3 fw-strong">Uploaded Document</label>
                    <hr class="my-1">
                </div>
            </div>
            <table class="table table-hover">
                <thead class="tableHeader">
                    <tr class="text-center">
                        <th>Title</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr class="text-center">
                            <td>{{ $document->title }}</td>
                            <td>
                                @if (pathinfo($document->original_filename, PATHINFO_EXTENSION) == 'pdf')
                                    <button type="button" class="btn btn-link text-primary" data-bs-toggle="modal"
                                        data-bs-target="#pdfModal{{ $document->id }}">
                                        {{ $document->original_filename }}
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="pdfModal{{ $document->id }}"
                                        aria-labelledby="pdfModal{{ $document->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pdfModal{{ $document->id }}Label">
                                                        {{ $document->original_filename }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe
                                                        src="{{ route('document.show', ['fileName' => $document->file_name]) }}"
                                                        width="100%" style="min-height: 70vh;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-primary">{{ $document->original_filename }}</span>
                                @endif
                            </td>
                            <td>
                                <!-- Download Button -->
                                <a href="{{ route('document.download', ['fileName' => $document->file_name]) }}"
                                    class="btn btn-sm btn-primary" title="Download">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <!-- Delete Button -->
                                <button wire:click="deleteDocument({{ $document->id }})" class="btn btn-sm btn-danger"
                                    wire:confirm.prompt="Are you sure you want to delete this document?\n\nType the word &quot;{{ str($project_name)->upper() }}&quot; to confirm|{{ str($project_name)->upper() }}"
                                    title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .tableHeader th {
            background: #3e5877;
            color: whitesmoke;
        }
    </style>
</div>
