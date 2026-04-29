<div>
    <div class="modal-body p-4">
        <form wire:submit='SaveChanges' id="accountSettingsForm">
            <div class="row mb-3">
                <label for="name" class="col-form-label col-sm-3">Name @if($updatingInfo) <span class="text-danger">*</span> @endif </label>
                <div class="col-sm-6">
                    <input wire:model='name' @if(!$updatingInfo) disabled @endif type="text" id="name" name="name"
                        class="form-control bg-white border-dark-subtle @error('name') is-invalid @enderror">
                    @error('name')
                    <small class="text-danger text-wrap">{{$message}}</small>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="email" class="col-form-label col-sm-3">Email @if($updatingInfo) <span class="text-danger">*</span> @endif </label>
                <div class="col-sm-6">
                    <input wire:model='email' @if(!$updatingInfo) disabled @endif type="email" id="email" name="email"
                        class="form-control bg-white border-dark-subtle @error('email') is-invalid @enderror">
                    @error('email')
                    <small class="text-danger text-wrap">{{$message}}</small>
                    @enderror
                </div>
            </div>
    
            @if($updatingInfo)
            <div class="row mb-3">
                <label for="currentPassword" class="col-form-label col-sm-3">Current Password</label>
                <div class="col-sm-6">
                    <input wire:model='currentPassword' placeholder="Enter current password ..." type="password" id="currentPassword" name="currentPassword" class="form-control bg-white border-dark-subtle">
                    @error('currentPassword')
                    <small class="text-danger text-wrap">{{$message}}</small>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="newPassword" class="col-form-label col-sm-3">New Password</label>
                <div class="col-sm-6">
                    <input wire:model='newPassword' placeholder="Enter new password ..." type="password" id="newPassword" name="newPassword"
                        class="form-control bg-white border-dark-subtle @error('newPassword') is-invalid @enderror">
                    @error('newPassword')
                    <small class="text-danger text-wrap">{{$message}}</small>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-4">
                <label for="confirmPassword" class="col-form-label col-sm-3 @error('confirmNewPassword') is-invalid @enderror">Confirm New Password</label>
                <div class="col-sm-6">
                    <input wire:model='confirmNewPassword' type="password" id="confirmPassword" name="confirmPassword"
                        class="form-control bg-white border-dark-subtle @error('confirmNewPassword') is-invalid @enderror">
                    @error('confirmNewPassword')
                    <small class="text-danger text-wrap">{{$message}}</small>
                    @enderror
                </div>
            </div>
            @endif
    
            <div class="row justify-content-end">
                @if ($updatingInfo == false)
                <div class="col-auto">
                    <button wire:click='UpdateInfo' type="button" class="btn btn-primary">Update</button>
                </div>
                @else
                <div class="col-auto d-flex gap-2">
                    <button type="submit" form="accountSettingsForm" wire:loading.attr='disabled' class="btn btn-success">Save Changes</button>
                    <button wire:click='ResetUpdatingInfo(null, null)' wire:loading.attr='disabled' type="button" class="btn btn-danger">Cancel</button>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>