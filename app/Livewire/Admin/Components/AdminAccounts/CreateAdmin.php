<?php

namespace App\Livewire\Admin\Components\AdminAccounts;

use Livewire\Component;
use App\Models\User;
use App\Models\UserDepartment;
use Exception;

class CreateAdmin extends Component
{
    
    public $name, $email, $password, $department, $contactNumber;

    public $rules = [
        'name' => ['required', 'string', 'unique:users,name'],
        'email' => ['required', 'string', 'unique:users,email'],
        'password' => ['required', 'min:8'],
        'contactNumber' => ['nullable', 'numeric', 'digits:11'],
    ];

    public function render()
    {
        return view('livewire.admin.components.admin-accounts.create-admin');
    }

    public function CreateAdmin() {
        $this->validate();
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]);
            $user->user_type = 'admin';
            if (empty($this->department) == false) {
                // Create user-department relationship
                UserDepartment::create([
                    'department_id' => $this->department,
                    'user_id' => $user->id,
                ]);
            }
            // TODO: User contact number
            if (empty($this->contactNumber) == false) {
                
            }
            $user->save();
            $msgData = [
                'message' => 'You added a new admin (Name: '.$user->name.' | Email: '.$user->email.')',
                'color' => 'success',
            ];            
            $this->dispatch('UpdateMessageNotif', $msgData);
            $this->dispatch('AdminCreated');
            session()->flash('adminCreated', 'success');
            $this->reset();
        } catch (Exception $ex) {
            $msgData = [
                'message' => $ex->getMessage(),
                'color' => 'success',
            ];
            $this->dispatch('UpdateMessageNotif', $msgData);
        }
    }
}
