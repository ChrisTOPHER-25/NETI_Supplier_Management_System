<?php

namespace App\Livewire\Admin\Components\ManageDepartments;

use App\Models\BomDepartment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddDepartmentForm extends Component
{
    public $departmentName;

    protected function rules()
    {
        return [
            'departmentName' => ['required', 'string', 'unique:bom_departments,name'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.manage-departments.add-department-form');
    }

    public function AddDepartment()
    {
        $this->validate();
        try {
            $result = BomDepartment::create([
                'name' => $this->departmentName,
            ]);
            if ($result) {
                $message = 'You added the department "' . $result->name . '"';
                $this->dispatch('UpdateMessageNotif', ['message' => $message, 'color' => 'success']);
                // Recipients
                $recipients = [];
                foreach (User::where('user_type', 'superadmin')->get() as $user) {
                    if ($user->id != Auth::user()->id) {
                        array_push($recipients, $user->id);
                    }
                }
                array_push($recipients, Auth::user()->id);
                // Notification
                $this->dispatch('CreateNotif', [
                    'title' => 'BOM Department Created',
                    'message' => ' created the department "' . $result->name .'"',
                    'url' => '/admin/manage-departments',
                    'recipients' => $recipients,
                ]);
                $this->dispatch("DepartmentAdded");
                $this->reset();
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', ['message' => $ex->getMessage(), 'color' => 'danger']);
        }
    }
}
