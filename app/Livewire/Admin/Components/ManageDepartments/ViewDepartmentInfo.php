<?php

namespace App\Livewire\Admin\Components\ManageDepartments;

use App\Models\Bom;
use App\Models\BomDepartment;
use App\Models\BomMaterialCategory;
use Livewire\Component;

class ViewDepartmentInfo extends Component
{

    public $departmentId, $department;

    public $categories, $boms;

    public $departmentName;

    protected $listeners = [
        'DepartmentSearched'
    ];

    protected function rules() {
        return [
            'departmentName' => ['required', 'unique:bom_departments,name'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.manage-departments.view-department-info');
    }

    public function mount() {
        $this->department = BomDepartment::findOrFail($this->departmentId);
        $this->categories = BomMaterialCategory::where('department_id', $this->departmentId)->get();
        $this->boms = Bom::where('department_id', $this->departmentId)->get();
    }

    public function UpdateDepartmentName() {
        $this->validateOnly('departmentName');
        $currentDepartmentName = $this->department->name;
        $this->department->name = $this->departmentName;
        $result = $this->department->save();
        if ($result) {
            $this->reset('departmentName');
            session()->flash('change-success', 'You successfully updated this department\'s name');
            $this->dispatch('DepartmentNameUpdated');
            $this->dispatch('UpdateMessageNotif', [
                'message' => 'You updated the department name "'.$currentDepartmentName.'" to "'.$this->department->name.'"',
                'color' => 'success',
            ]);
        }

    }
}
