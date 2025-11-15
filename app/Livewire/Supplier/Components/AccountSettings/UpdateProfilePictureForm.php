<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use App\Models\ProfilePicture;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdateProfilePictureForm extends Component
{
    use WithFileUploads;

    public $newProfilePicture, $previewProfilePic;

    public function rules()
    {
        return [
            'newProfilePicture' => ['image', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function render()
    {
        return view('livewire.supplier.components.account-settings.update-profile-picture-form');
    }

    public function mount()
    {
        $this->reset('newProfilePicture');
        $this->previewProfilePic = false;
    }

    public function ValidateNewProfilePicture()
    {
        if ($this->validateOnly('newProfilePicture')) {
            $this->previewProfilePic = true;
        }
    }

    public function UpdateProfilePicture()
    {
        $validationResult = $this->validate();
        if ($this->previewProfilePic == true && $validationResult) {
            $userId = Auth::user()->id;
            $filePath = 'profile-pictures';
            $fileName = 'profile' . $userId . '.' . $this->newProfilePicture->getClientOriginalExtension();
            $fileStoreResult = $this->newProfilePicture->storeAs(path: $filePath, name: $fileName);
            if ($fileStoreResult) {
                $result = false;
                // Create a profile picture data for user if they do not have one yet
                if (count(ProfilePicture::where('user_id', $userId)->get()) == 0) {
                    $createResult = ProfilePicture::create([
                        'file_name' => $fileName,
                        'user_id' => $userId,
                    ]);
                    $result = $createResult ? true : false;
                    toastr()->success(
                        'Your profile picture has been successfully updated!',
                        [
                            'positionClass' => 'toast-bottom-right',
                        ]
                    );
                    
                } else {
                    // Update existing profile picture data
                    $profilePicture = ProfilePicture::where('user_id', $userId)->firstOrFail();
                    $profilePicture->file_name = $fileName;
                    $saveResult = $profilePicture->save();
                    $result = $saveResult ? true : false;
                    toastr()->success(
                        'Profile picture has been updated successfully.',
                        [
                            'positionClass' => 'toast-bottom-right',
                        ]
                    );
                }
                if ($result) {
                    return redirect()->to('/supplier/account-settings');
                }
            }
        }
    }
}
