<?php

namespace App\Livewire\Supplier\Components;

use App\Models\ProfilePicture;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SupplierProfilePicLayout extends Component
{
    public $profilePicFileName;

    public function render()
    {
        return view('livewire.supplier.components.supplier-profile-pic-layout');
    }

    public function mount() {
        try {
            $profPic = ProfilePicture::where('user_id', Auth::user()->id)->firstOrFail();
            if (empty($profPic) == false) {
                $this->profilePicFileName = $profPic->file_name;
            }
        } catch (Exception $ex) {

        }
    }
}
