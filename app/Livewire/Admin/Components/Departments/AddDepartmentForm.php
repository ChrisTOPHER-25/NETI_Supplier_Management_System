<?php

namespace App\Livewire\Admin\Components\Departments;

use Livewire\Component;
use App\Models\Department;
use Exception;

class AddDepartmentForm extends Component
{
    public $departmentName;

    public $rules = [
        'departmentName' => ['required', 'string', 'unique:departments,name'],
    ];

    public function render()
    {
        return view('livewire.admin.components.departments.add-department-form');
    }

    public function AddDepartment() {        
        $this->validate();
        try {
            $result = Department::create([
                'name' => $this->departmentName,
            ]);
            if ($result) {
                $this->dispatch('DepartmentAdded');
                $msgData = [
                    'message' => 'You added a new department "'.$this->departmentName.'"',
                    'color' => 'success',
                ];
                $this->dispatch('UpdateMessageNotif', $msgData);
                $this->reset();
                session()->flash('message', $msgData);
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
