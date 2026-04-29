<div>
    <div class="row mb-4 d-flex align-items-end justify-content-between">
        <div class="col-auto">
            <label for="upload_profile" class="form-label">Upload a new profile picture</label>
            <div class="input-group">
                <input wire:model='newProfilePicture' type="file" accept=".jpg,.jpeg,.png" id="upload_profile" name="upload_profile"
                    class="form-control bg-white border-dark-subtle">
                    @if (empty($newProfilePicture) == false)
                    <button wire:click='ValidateNewProfilePicture' class="btn btn-secondary">Preview</button>                        
                    @endif
            </div>
            <div wire:loading wire:target="newProfilePicture">Uploading profile photo...</div>
            @error('newProfilePicture')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        
        <div class="col-auto">
            <form wire:submit='UpdateProfilePicture' enctype="multipart/form-data">
                <button type="submit" class="btn btn-primary"
                @if($errors->has('newProfilePicture') || $previewProfilePic == false || empty($newProfilePicture)) disabled hidden @endif>Update</button>
            </form>
        </div>
    </div>
    {{-- Preview Uploaded File --}}
    @if ($newProfilePicture && $previewProfilePic == true)
    <div class="row d-flex align-items-center justify-content-center m-1" style="min-height: 40vh;">
        <div class="col-auto">
            <img src="{{ $newProfilePicture->temporaryUrl() }}" class="img rounded-circle border border-dark-subtle" style="height: 250px; width: 250px;">
        </div>
    </div>
    @else
    <div class="row d-flex align-items-center justify-content-center border border-dark-subtle rounded-3 m-1"
        style="min-height: 40vh;">
        <div class="col-auto">
            <span class="fw-light d-flex flex-column gap-2 align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="50" height="50" fill="currentColor">
                    <path
                        d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm152 32c5.3 0 10.2 2.6 13.2 6.9l88 128c3.4 4.9 3.7 11.3 1 16.5s-8.2 8.6-14.2 8.6H216 176 128 80c-5.8 0-11.1-3.1-13.9-8.1s-2.8-11.2 .2-16.1l48-80c2.9-4.8 8.1-7.8 13.7-7.8s10.8 2.9 13.7 7.8l12.8 21.4 48.3-70.2c3-4.3 7.9-6.9 13.2-6.9z" />
                </svg>
            </span>
        </div>
    </div>
    @endif
</div>