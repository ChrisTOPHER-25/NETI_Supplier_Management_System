<div>
    <div class="rounded-3 bg-white shadow-sm p-5 mb-4">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label fs-3 fw-strong">Profile Information</label>
                <hr class="my-1">
            </div>
        </div>

        <div class="row mb-1 gap-5">
            @inject('SupplierAddress', App\Models\SupplierAddress::class)
            @inject('SupplierContactNumber', App\Models\SupplierContactNumber::class)
            @inject('SupplierContactPerson', App\Models\SupplierContactPerson::class)

            {{-- Profile Info --}}
            <div class="row">
                <form wire:submit='UpdateProfileInformation' autocomplete="off" class="col p-4 border-end">
                    <div class="col d-flex justify-content-end">
                        <div class="col-auto">
                            @if(!$updating)
                            <button type="submit" class="btn btn-primary btn-sm" wire:click.prevent="setUpdating">Update
                                Info</button>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control border-dark-subtle" style="background: rgb(235, 235, 235);"
                                value="{{Auth::user()->name}}" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control border-dark-subtle" style="background: rgb(235, 235, 235);"
                                value="{{Auth::user()->email}}" readonly>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">
                            <label for="address" class="form-label">Address</label>
                            <input wire:model='newSupplierAddress' class="form-control bg-white border border-dark-subtle"
                                name="newSupplierAddress" id="newSupplierAddress" cols="30" rows="5" @if(!$updating) readonly @endif
                                @if(count($SupplierAddress::where('user_id', Auth::user()->id)->get()) > 0)
                            placeholder="{{$SupplierAddress::where('user_id',
                            Auth::user()->id)->firstOrFail()->address}}"
                            @endif></input>
                            @error('supplierAddress')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- Primary Contact Person --}}
                    <div class="row mb-2">
                        <h5>Primary contact Person</h5>
                        <div class="col">
                            <label for="contactPerson" class="form-label">Name</label>
                            <input wire:model='newContactPersonPrimary' type="text" id="pContactPerson"
                                name="pContactPerson" class="form-control bg-white border-dark-subtle"
                                @if(!$updating) readonly @endif placeholder="{{$pContactPerson->name}}">
                            @error('supplierContactPerson')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="contactNumber" class="form-label">Contact Number</label>
                            <input wire:model='supplierContactNum' type="text" id="contactNumber" name="contactNumber"
                                oninput="limitToElevenDigits(this)" class="form-control bg-white border-dark-subtle"
                                @if(!$updating) readonly @endif placeholder="{{$pContactNum->contact}}">
                            @error('supplierContactNum')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email" class="form-label">Position</label>
                            <input type="text" id="email" name="email" @if(!$updating) readonly @endif
                            class="form-control bg-white border-dark-subtle" placeholder="{{$pPosition->position}}">
                        </div>
                    </div>
                    {{-- Secondary Contact Person --}}
                    <h5>Secondary Contact Person</h5>
                    <div class="row mb-2">
                        <div class="col">

                            <label for="contactPerson" class="form-label">Name</label>
                            <input wire:model='sContactPerson' type="text" id="sContactPerson" name="sContactPerson"
                                class="form-control bg-white border-dark-subtle" @if(!$updating) readonly @endif
                                placeholder="{{$sContactPerson->name}}">
                            @error('supplierContactPerson')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="contactNumber" class="form-label">Contact Number</label>
                            <input wire:model='supplierContactNum' type="text" id="contactNumber" name="contactNumber"
                                oninput="limitToElevenDigits(this)" class="form-control bg-white border-dark-subtle"
                                @if(!$updating) readonly @endif placeholder="{{$sContactNum->contact}}">
                            @error('supplierContactNum')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="email" class="form-label">Position</label>
                            <input type="text" id="email" name="email" @if(!$updating) readonly @endif
                            class="form-control bg-white border-dark-subtle" placeholder="{{$sPosition->position}}">
                        </div>
                    </div>

                    <div class="col d-flex justify-content-end">
                        <div class="col-auto">
                            @if($updating)
                            <button type="submit" class="btn btn-success btn-sm">Save Changes</button>
                            @endif
                        </div>
                    </div>

                    <script>
                        function limitToElevenDigits(inputElement) {
                            const inputValue = inputElement.value;
                            const cleanedValue = inputValue.replace(/\D/g, ''); // Remove non-digit characters
                            const truncatedValue = cleanedValue.slice(0, 11); // Keep only the first 11 digits
                            inputElement.value = truncatedValue;
                        }
                    </script>
                </form>

                {{-- Profile Picture --}}
                <div class="col p-4">
                    <div class="row mb-3 justify-content-center">

                        <div class="col-auto ">
                            <div class="d-flex justify-content-start">
                                <label for="profile_pic" class="form-label mb-2 fw-semibold ">Profile Picture</label><br>
                            </div>

                            @if (!empty($profilePictureFileName))
                            <img src=" {{ route('profile_picture.show', ['profilePictureFileName' => $profilePictureFileName->file_name]) }}"
                                id="profile_pic" name="profile_pic" class="img rounded-circle border border-dark-subtle"
                                alt="profile_picture" style="height: 250px; width: 250px;" data-bs-toggle="modal"
                                data-bs-target="#updateProfilePicModal">
                            @else
                            <span class="text-secondary">
                                You currently do not have a profile picture. Click
                                <span class="link-primary fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#updateProfilePicModal" style="cursor:pointer;">here</span>
                                to update.
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto d-flex gap-1">
                            {{-- Update Profile Picture Modal --}}
                            <div wire:ignore class="modal fade" id="updateProfilePicModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfilePicLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title fs-4" id="updateProfilePicLabel">Update Profile
                                                Picture</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            {{-- Update Profile Picture Form --}}
                                            @livewire('supplier.components.account-settings.update-profile-picture-form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($profilePictureFileName)
                            <form wire:submit='RemoveProfilePicture'>
                                <button class="btn btn-danger btn-sm" id="removeProfilePictureBtn">Remove Profile
                                    Picture</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <style>
                #profile_pic:hover {
                    cursor: pointer;
                }

                .form-control::placeholder {
                    color: black;
                }
            </style>
        </div>
    </div>
</div>