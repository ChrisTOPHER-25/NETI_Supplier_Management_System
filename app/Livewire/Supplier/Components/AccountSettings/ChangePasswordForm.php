<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Exception;

class ChangePasswordForm extends Component
{

    public $currentPasswordIsEntered, $currentPassword, $newPassword, $confirmNewPassword;

    public function rules()
    {
        return [
            'currentPassword' => ['required', 'string'],
            'newPassword' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
            'confirmNewPassword' => ['required', 'same:newPassword'],
        ];
    }

    public function render()
    {
        return view('livewire.supplier.components.account-settings.change-password-form');
    }

    public function mount()
    {
        $this->currentPasswordIsEntered = false;
    }

    public function CheckCurrentPassword()
    {
        $this->validateOnly('currentPassword');
        $result = Hash::check($this->currentPassword, Auth::user()->password);
        if ($result) {
            $this->currentPasswordIsEntered = true;
        } else {
            $this->addError('currentPassword', 'The entered current password is incorrect');
        }
    }

    public function ValidateField($fieldName)
    {
        if ($fieldName == 'newPassword') {
            $this->validateOnly('newPassword');
        }
        if ($fieldName == 'confirmNewPassword') {
            $this->validateOnly('confirmNewPassword');
        }
        if ($fieldName == 'newPassword' && $this->newPassword == $this->currentPassword) {
            $this->addError('newPassword', 'New password should now same as current password.');
        }
    }

    public function ChangePassword()
    {
        try {
            $user = User::findOrFail(Auth::user()->id);
            if (empty($user) == false) {
                $user->password = $this->newPassword;
                $result = $user->save();

                if ($result) {
                    // Throw success message (TEMP)
                    session()->flash('success_change', 'change password successfully!');
                    $this->reset('currentPassword', 'newPassword', 'confirmNewPassword');
                    $this->currentPasswordIsEntered = false;
                }
            }
        } catch (Exception $e) {
            $this->addError('newPassword', $e->getMessage());

        }

    }
}