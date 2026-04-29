<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use App\Models\ProfilePicture;
use App\Models\SupplierAddress;
use App\Models\SupplierContactNumber;
use App\Models\SupplierContactPerson;
use App\Models\SupplierPersonPosition;
use App\Rules\noEmoji;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProfileInformationForm extends Component
{
    public $profilePictureFileName;

    public $updating = false;
    public $supplierAddress, $newSupplierAddress;


    public $pContactPerson, $pContactNum, $pPosition;
    public $newContactPersonPrimary, $newContactNumPrimary, $newPositionPrimary;

    public $sContactPerson, $sContactNum, $sPosition;
    public $newContactPersonSecondary, $newContactNumSecondary, $newPositionSecondary;


    public function rules()
    {
        return [
            'newContactPersonPrimary' => ['required', new noEmoji()],
            'newContactNumPrimary' => ['required'],
            'newPositionPrimary' => ['required', new noEmoji()],
            'newContactPersonSecondary' => ['required', new noEmoji()],
            'newContactNumSecondary' => ['required'],
            'newPositionSecondary' => ['required', new noEmoji()],
            'newSupplierAddress' => ['required', new noEmoji()]
        ];
    }

    public function render()
    {
        return view('livewire.supplier.components.account-settings.profile-information-form');
    }



    public function setUpdating()
    {
        $this->updating = true;
    }

    public function mount()
    {
        try {
            $this->profilePictureFileName = ProfilePicture::where('user_id', Auth::user()->id)->first();
            $this->pContactPerson = SupplierContactPerson::where('user_id', Auth::user()->id)->where('level', 'primary')->firstOrFail();
            $this->pContactNum = SupplierContactNumber::where('contact_person_id', $this->pContactPerson->id)->firstOrFail();
            $this->pPosition = SupplierPersonPosition::where('contact_person_id', $this->pContactPerson->id)->firstOrFail();

            $this->sContactPerson = SupplierContactPerson::where('user_id', Auth::user()->id)->where('level', 'secondary')->firstOrFail();
            $this->sContactNum = SupplierContactNumber::where('contact_person_id', $this->sContactPerson->id)->firstOrFail();
            $this->sPosition = SupplierPersonPosition::where('contact_person_id', $this->sContactPerson->id)->firstOrFail();
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function RemoveProfilePicture()
    {
        $storageDeleteResult = Storage::delete('profile-pictures/' . $this->profilePictureFileName);
        if ($storageDeleteResult) {
            // Proceed to delete profile picture data
            $profPic = ProfilePicture::where('user_id', Auth::user()->id)->firstOrFail();
            if ($profPic) {
                $dataDeleteResult = ProfilePicture::destroy($profPic->id);
                if ($dataDeleteResult) {
                    toastr()->success('Profile picture has been removed.', [
                        'positionClass' => 'toast-bottom-right',
                    ]);
                    return redirect()->to('/supplier/account-settings');
                }
            }
        }
    }

    public function UpdateProfileInformation()
    {
        $this->ValidateFields();
        try {
            $updateResult = $this->UpdateFields();
            $this->reset(
                'newContactPersonPrimary',
                'newContactNumPrimary',
                'newPositionPrimary',
                'newContactPersonSecondary',
                'newContactNumSecondary',
                'newPositionSecondary',
                'newSupplierAddress',
                'pContactPerson', 'pContactNum', 'pPosition',
                'sContactPerson', 'sContactNum', 'sPosition',
            );
            if ($updateResult) {
                toastr()->success('You updated your profile information', [
                    'positionClass' => 'toast-bottom-right',
                ]);
            }
            $this->mount();
        } catch (Exception $ex) {
            toastr()->success($ex->getMessage(), [
                'positionClass' => 'toast-bottom-right',
            ]);
        }
        $this->updating = false;
    }

    private function ValidateFields()
    {
        if (!empty($this->newContactPersonPrimary)) {
            $this->validateOnly('newContactPersonPrimary');
        }
    }

    private function UpdateFields()
    {
        $infoUpdated = false;

        $supplierAddress = SupplierAddress::where('user_id', Auth::user()->id)->firstOrFail();

        $primaryContactPerson = SupplierContactPerson::where('user_id', Auth::user()->id)->where('level', 'primary')->firstOrFail();
        $primaryContactNum = SupplierContactNumber::where('contact_person_id', $primaryContactPerson->id)->firstOrFail();
        $primaryContactPosition = SupplierPersonPosition::where('contact_person_id', $primaryContactPerson->id)->firstOrFail();

        $secondaryContactPerson = SupplierContactPerson::where('user_id', Auth::user()->id)->where('level', 'secondary')->firstOrFail();
        $secondaryContactNum = SupplierContactNumber::where('contact_person_id', $secondaryContactPerson->id)->firstOrFail();
        $secondaryContactPosition = SupplierContactNumber::where('contact_person_id', $secondaryContactPerson->id)->firstOrFail();

        if (!empty($this->newContactPersonPrimary)) {
            $primaryContactPerson->name = $this->newContactPersonPrimary;
            $result = $primaryContactPerson->saveOrFail();
            $infoUpdated = $result ? true : false;
        }
        if (!empty($this->newContactNumPrimary)) {
            $primaryContactNum->contact = $this->newContactNumPrimary;
            $result = $primaryContactNum->saveOrFail();
            $infoUpdated = $result ? true : false;
        }
        if (!empty($this->newPositionPrimary)) {
            $primaryContactPosition->position = $this->newPositionPrimary;
            $result = $primaryContactPosition->saveOrFail();
            $infoUpdated = $result ? true : false;
        }

        if (!empty($this->newContactPersonSecondary)) {
            $secondaryContactPerson->name = $this->newContactPersonSecondary;
            $result = $secondaryContactPerson->saveOrFail();
            $infoUpdated = $result ? true : false;
        }
        if (!empty($this->newContactNumSecondary)) {
            $secondaryContactNum->contact = $this->newContactNumSecondary;
            $result = $secondaryContactNum->saveOrFail();
            $infoUpdated = $result ? true : false;
        }
        if (!empty($this->newPositionSecondary)) {
            $secondaryContactPosition->position = $this->newPositionSecondary;
            $result = $secondaryContactPosition->saveOrFail();
            $infoUpdated = $result ? true : false;
        }
        if (!empty($this->newSupplierAddress)) {
            $supplierAddress->address = $this->newSupplierAddress;
            $result = $supplierAddress->save();
            $infoUpdated = $result ? true : false;
        }
        if ($infoUpdated) {
            return true;
        }
        toastr()->success('Profile information has been updated!', [
            'positionClass' => 'toast-bottom-right',
        ]);
    }
}
