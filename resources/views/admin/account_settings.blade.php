<div>
    <span class="link-primary text-decoration-underline fs-5" style="cursor:pointer;" data-bs-toggle="modal"
        data-bs-target="#accountSettingsModal">
        {{ ucfirst(Auth::user()->user_type) }}
    </span>
    <!-- Modal -->
    <div class="modal fade" id="accountSettingsModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title fs-5">Account Information</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Account Settings --}}
                <livewire:admin.components.account-settings.personal-information>
            </div>
        </div>
    </div>
</div>