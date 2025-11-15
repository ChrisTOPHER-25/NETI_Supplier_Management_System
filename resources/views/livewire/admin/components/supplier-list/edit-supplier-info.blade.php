<div wire:key='editSupplierInfo_{{$supplier->id}}'>
    <div class="modal-body p-4">
        <div class="row mb-5">
            {{-- Supplier Information --}}
            <div class="col">
                <div class="row mb-1">
                    <div class="col">
                        <span class="fw-bold fs-6">Supplier Information</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto">
                        <label for="name_{{$supplier->id}}" class="form-label">Name</label>
                        <input placeholder="{{$supplier->name}}" type="text" id="name_{{$supplier->id}}"
                            name="name_{{$supplier->id}}"
                            class="editInput form-control form-control-sm bg-white border-dark-subtle">
                    </div>
                    <div class="col">
                        <label for="email_{{$supplier->id}}" class="form-label">Email</label>
                        <input placeholder="{{$supplier->email}}" id="email_{{$supplier->id}}"
                            name="email_{{$supplier->id}}" type="text"
                            class="editInput form-control form-control-sm bg-white border-dark-subtle">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="address_{{$supplier->id}}" class="form-label">Address</label>
                        <textarea placeholder="{{$supplierAddress->address}}" name="address_{{$supplier->id}}"
                            id="address_{{$supplier->id}}" cols="30" rows="4"
                            class="editInput form-control form-control-sm bg-white border-dark-subtle"></textarea>
                    </div>
                </div>
            </div>
            {{-- Contact Persons --}}
            <div class="col">
                {{-- Primary Contact Person --}}
                <div class="row mb-3">
                    <div class="row mb-1">
                        <div class="col">
                            <span class="fw-bold fs-6">Primary Contact Person</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="primaryName_{{$supplier->id}}" class="form-label">Name</label>
                            <input placeholder="{{$primaryName->name}}" type="text" id="primaryName_{{$supplier->id}}"
                                name="primaryName_{{$supplier->id}}"
                                class="editInput form-control form-control-sm bg-white border-dark-subtle" id="primaryName"
                                name="primaryName">
                        </div>
                        <div class="col">
                            <label for="primaryContact_{{$supplier->id}}" class="form-label">Contact</label>
                            <input placeholder="{{$primaryContact->contact}}" id="primaryContact_{{$supplier->id}}"
                                name="primaryContact_{{$supplier->id}}" type="text"
                                class="editInput form-control form-control-sm bg-white border-dark-subtle">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="primaryPosition_{{$supplier->id}}" class="form-label">Position</label>
                            <input placeholder="{{$primaryPosition->position}}" id="primaryPosition_{{$supplier->id}}"
                                name="primaryPosition_{{$supplier->id}}" type="text"
                                class="editInput form-control form-control-sm bg-white border-dark-subtle">
                        </div>
                    </div>
                </div>
                {{-- Secondary Contact Person --}}
                <div class="row">
                    <div class="row mb-1">
                        <div class="col">
                            <span class="fw-bold fs-6">Secondary Contact Person</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="secondaryName_{{$supplier->id}}" class="form-label">Name</label>
                            <input placeholder="{{$secondaryName->name}}" type="text" id="secondaryName_{{$supplier->id}}" name="secondaryName_{{$supplier->id}}" 
                            class="editInput form-control form-control-sm bg-white border-dark-subtle">
                        </div>
                        <div class="col">
                            <label for="secondaryContact_{{$supplier->id}}" class="form-label">Contact</label>
                            <input placeholder="{{$secondaryContact->contact}}" type="text" id="secondaryContact_{{$supplier->id}}" name="secondaryContact_{{$supplier->id}}" class="editInput form-control form-control-sm bg-white border-dark-subtle">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="secondaryPosition_{{$supplier->id}}" class="form-label">Position</label>
                            <input placeholder="{{$secondaryPosition->position}}" type="text" id="secondaryPosition_{{$supplier->id}}" name="secondaryPosition_{{$supplier->id}}" 
                            class="editInput form-control form-control-sm bg-white border-dark-subtle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Update Button --}}
        <div class="row justify-content-end">
            <div class="col-auto">
                <button class="btn btn-primary">Update Info</button>
            </div>
        </div>
    </div>
    <style>
        .editInput::placeholder {
            color: black;
        }
    </style>
</div>