<?php

namespace App\Livewire\Admin\Components\AccountSettings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class PersonalInformation extends Component
{

    public $updatingInfo = false;

    public $name, $email, $currentPassword, $newPassword, $confirmNewPassword;

    protected function rules() {
        return [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users,email,'.Auth::user()->id],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.account-settings.personal-information');
    }

    public function mount() {
        $this->name =  Auth::user()->name;
        $this->email =  Auth::user()->email;
    }

    public function UpdateInfo() {
        $this->updatingInfo = true;
    }

    public function ResetNameEmail($name, $email) {
        $this->name =  $name;
        $this->email =  $email;
    }

    public function ResetUpdatingInfo($name, $email) {
        $this->reset('updatingInfo', 'newPassword', 'confirmNewPassword', 'currentPassword');
        if (!empty($name) && !empty($email)) {
            $this->ResetNameEmail($name, $email);
        }
        $this->resetErrorBag();
    }

    public function SaveChanges() {
        if ($this->ValidateFields()) {
            $user = User::findOrFail(Auth::user()->id);
            $user->name = $this->name;
            $user->email = $this->email;
            if (!empty($this->newPassword)) {
                $user->password = $this->newPassword;
            }
            $updateUserResult = $user->save();
            if ($updateUserResult) {
                $this->dispatch('UpdateMessageNotif', ['message' => 'You successfully updated your account information', 'color' => 'success']);
                $this->ResetUpdatingInfo($this->name, $this->email);
            }        
        }
    }

    private function ValidateFields() {
        $this->validate();
        if (!empty($this->newPassword)) {
            $userCurrentPassword = User::findOrFail(Auth::user()->id)->password;
            if (Hash::check($this->currentPassword, $userCurrentPassword) == false) {
                $this->addError('currentPassword', 'Incorrect current password');
                return false;
            } else {
                $this->validate([
                    'newPassword' => [Password::min(8)->letters()->mixedCase()->numbers()],
                    'confirmNewPassword' => ['same:newPassword'],
                ]);
            }
        }
        return true;
    }
}
