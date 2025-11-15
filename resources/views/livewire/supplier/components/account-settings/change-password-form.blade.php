<div>
    <div class="rounded-3 bg-white shadow-sm p-5">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label fs-3 fw-strong">Change Password</label>
                <hr class="my-1">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4">
                {{-- Enter current password --}}
                @if ($currentPasswordIsEntered == false)
                <form wire:submit='CheckCurrentPassword'>
                    <label for="currentPassword" class="form-label">Please enter your current password</label>
                    <div class="input-group">
                        <input wire:model='currentPassword' type="password"
                            class="form-control bg-white border-dark-subtle 
                        @if($errors->has('currentPassword'))is-invalid @elseif(!empty($currentPassword) && !$errors->has('currentPassword')) is-valid @endif"
                            id="currentPassword" name="currentPassword">
                        <button id="submitCurrentPassword" class="btn btn-primary">Submit</button>
                    </div>
                    @error('currentPassword')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </form>
                {{-- Enter new password --}}
                @elseif ($currentPasswordIsEntered)
                <form wire:submit='ChangePassword'>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="newPassword" class="form-label">Enter a new password</label>
                            <input wire:keydown='ValidateField("newPassword")' wire:model.lazy='newPassword'
                                type="password"
                                class="form-control bg-white border-dark-subtle 
                            @if($errors->has('newPassword'))is-invalid @elseif(!empty($newPassword) && !$errors->has('newPassword')) is-valid @endif"
                                id="newPassword" name="newPassword">
                            @error('newPassword')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                            <input wire:keydown='ValidateField("confirmNewPassword")'
                                wire:model.lazy='confirmNewPassword' type="password"
                                class="form-control bg-white border-dark-subtle 
                            @if($errors->has('confirmNewPassword'))is-invalid @elseif(!empty($confirmNewPassword) && !$errors->has('confirmNewPassword')) is-valid @endif"
                                id="confirmNewPassword" name="confirmNewPassword">
                            @error('confirmNewPassword')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button id="submitNewPassword" class="btn btn-primary" @if(empty($newPassword) ||
                                empty($confirmNewPassword) || $errors->any()) disabled @endif>Submit</button>
                        </div>
                    </div>
                </form>
                @endif
                {{-- TEMPORARY --}}
                @if(session()->has('success_change'))
                <strong class="text-success">{{session('success_change')}}</strong>
                @endif
            </div>
        </div>
    </div>
</div>