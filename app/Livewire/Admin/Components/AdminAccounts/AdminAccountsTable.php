<?php

namespace App\Livewire\Admin\Components\AdminAccounts;

use Livewire\Component;
use App\Models\UserDepartment;
use App\Models\User;
use Exception;

class AdminAccountsTable extends Component
{
    public $listeners = [
        'AdminCreated', 'UserUpdated',
    ];

    public $userDepartments = [];

    public function render()
    {
        return view('livewire.admin.components.admin-accounts.admin-accounts-table');
    }

    public function UpdateUserDepartment($id)
    {
        if (empty($this->userDepartments[$id]) == false) {
            try {
                //Find user
                $user = User::findOrFail($id);
                // Find user's department
                $userDepartment = UserDepartment::where('user_id', $user->id)->get();
                if (count($userDepartment) > 0) {
                    $userDepartment[0]->department_id = $this->userDepartments[$user->id];
                    $userDepartment[0]->save();
                    $this->reset('userDepartments');
                    $msgData = [
                        'message' => 'You updated the department for admin "'.$user->name.'"',
                        'color' => 'success',
                    ];            
                    $this->dispatch('UpdateMessageNotif', $msgData);
                } else if (count($userDepartment) == 0) {
                    // Create a new user-department relationship
                    UserDepartment::create([
                        'user_id' => $id,
                        'department_id' => $this->userDepartments[$id],
                    ]);
                    $this->reset('userDepartments');
                    $msgData = [
                        'message' => 'You updated the department for admin "'.$user->name.'"',
                        'color' => 'success',
                    ];            
                    $this->dispatch('UpdateMessageNotif', $msgData);
                }
            } catch (Exception $ex) {
                $msgData = [
                    'message' => $ex->getMessage(),
                    'color' => 'danger',
                ];
                $this->dispatch('UpdateMessageNotif', $msgData);
            }
        }
    }
}
