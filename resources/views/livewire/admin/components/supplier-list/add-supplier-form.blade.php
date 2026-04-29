<div>
    <div class="modal-body p-4">
        <form wire:submit='AddSupplier'>
            <div class="row mb-3">
                {{-- Supplier Name, Email, Password, Address --}}
                <div class="col">
                    <div class="row mb-2">
                        <span class="fw-bold fs-6 mb-2">Supplier Information</span>
                        <div>
                            <label for="name" class="form-label">Supplier Name</label>
                            <input wire:model='name' type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                            @error('name')
                            is-invalid    
                            @enderror">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input wire:model='email' type="email" class="form-control form-control-sm bg-white border-dark-subtle 
                            @error('email')
                            is-invalid    
                            @enderror">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="password" class="form-label">Password</label>
                            <input wire:model='password' type="password" class="form-control form-control-sm bg-white border-dark-subtle 
                            @error('password')
                            is-invalid    
                            @enderror">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="address" class="form-label">Address</label>
                            <textarea wire:model='address' name="address" id="address" cols="20" rows="4" class="form-control form-control-sm bg-white border-dark-subtle 
                            @error('address')
                            is-invalid    
                            @enderror"></textarea>
                        </div>
                    </div>
                </div>
                {{-- Primary & Secondary Contact Person, Position, Contact --}}
                <div class="col">
                    <div class="row mb-4">
                        <span class="fw-bold fs-6 mb-2">Primary Contact Person</span>
                        <div class="ps-4">
                            <div class="row mb-1">
                                <div class="col">
                                    <label for="primaryCpName" class="form-label">Name</label>
                                    <input wire:model='primaryCpName' type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('primaryCpName')
                                    is-invalid
                                    @enderror" id="primaryCpName">
                                </div>
                                <div class="col">
                                    <label for="primaryCpContact" class="form-label">Contact Number</label>
                                    <input wire:model='primaryCpContact' oninput="limitToElevenDigits(this)" type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('primaryCpContact')
                                    is-invalid
                                    @enderror" id="primaryCpContact">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="primaryCpPosition" class="form-label">Position</label>
                                    <input wire:model='primaryCpPosition' type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('primaryCpPosition')
                                    is-invalid                                        
                                    @enderror" id="primaryCpPosition">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span class="fw-bold fs-6 mb-2">Secondary Contact Person</span>
                        <div class="ps-4">
                            <div class="row mb-1">
                                <div class="col">
                                    <label for="secondaryCpName" class="form-label">Name</label>
                                    <input wire:model='secondaryCpName' type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('secondaryCpName')
                                    is-invalid
                                    @enderror" id="secondaryCpName">
                                </div>
                                <div class="col">
                                    <label for="secondaryCpContact" class="form-label">Contact Number</label>
                                    <input wire:model='secondaryCpContact' oninput="limitToElevenDigits(this)" type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('secondaryCpContact')
                                    is-invalid
                                    @enderror" id="secondaryCpContact">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="secondaryCpPosition" class="form-label">Position</label>
                                    <input wire:model='secondaryCpPosition' type="text" class="form-control form-control-sm bg-white border-dark-subtle 
                                    @error('secondaryCpPosition')
                                    is-invalid
                                    @enderror" id="secondaryCpPosition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-end">
                <div>
                    <button type="submit" class="btn btn-success">Add</button>
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
    </div>
</div>