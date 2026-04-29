<div class="ps-5 pt-3">

    @if ($selectedForm == 'ProfileInfo')
        @livewire('supplier.components.account-settings.profile-information-form')
    @elseif ($selectedForm == 'ChangePass')
        @livewire('supplier.components.account-settings.change-password-form')
    @elseif ($selectedForm == 'UploadDocument')
        @livewire('supplier.components.account-settings.documents')
    @elseif ($selectedForm == 'SupplierTags')
        @livewire('supplier.components.account-settings.tags')
    @endif

</div>