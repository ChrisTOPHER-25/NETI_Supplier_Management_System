<?php

namespace App\Livewire\Admin\Components\Departments;

use App\Models\Department;
use App\Models\UserDepartment;
use Livewire\Component;
use Exception;

class DepartmentsTable extends Component
{
    public $updateDepartmentName = [], $count = 0;

    public $listeners = [
        'DepartmentAdded',
    ];

    public function render()
    {
        return view('livewire.admin.components.departments.departments-table');
    }

    public function DeleteDepartment($id)
    {
        try {
            // Check first if department has users
            $result = UserDepartment::where('department_id', $id)->get();
            if (count($result) > 0) {
                throw new Exception('You cannot delete a department that currently has users');
            } else {
                // Get department
                $department = Department::findOrFail($id);
                Department::destroy($id);
                $msgData = [
                    'message' => 'You deleted the department "'.$department->name.'"',
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

    public function UpdateDepartment($id)
    {
        if (empty($this->updateDepartmentName[$id]) == false) {
            try {
                // Get department
                $department = Department::findOrFail($id);
                $department->name = $this->updateDepartmentName[$id];
                $result = $department->save();
                if ($result) {
                    $msgData = [
                        'message' => 'You updated a department name "'.$department->name.'"',
                        'color' => 'success',
                    ];
                    $this->dispatch('UpdateMessageNotif', $msgData);
                    $this->reset('updateDepartmentName');
                }
            } catch (Exception $ex) {
                $msgData = [
                    'message' => $ex->getMessage(),
                    'color' => 'danger',
                ];
                $this->dispatch('UpdateMessageNotif', $msgData);
                $this->reset('updateDepartmentName');
            }
        }
    }
}
