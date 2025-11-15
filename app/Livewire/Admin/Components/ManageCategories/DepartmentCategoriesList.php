<?php

namespace App\Livewire\Admin\Components\ManageCategories;

use App\Models\BomDepartment;
use Livewire\Component;

class DepartmentCategoriesList extends Component
{
    protected $listeners = [
        'CategoryAdded', 'CategoryDeleted', 'DepartmentSearched', 'DepartmentSearchCleared' => 'mount'
    ];

    public $bomDepartments = [];
    
    public function render()
    {
        return view('livewire.admin.components.manage-categories.department-categories-list');
    }

    public function mount() {
        if (empty($this->bomDepartments)) {
            $this->bomDepartments = BomDepartment::get();
        }
        if (BomDepartment::count() != count($this->bomDepartments)) {
            $this->reset('bomDepartments');
            $this->bomDepartments = BomDepartment::get();            
        }
    }

    public function DepartmentSearched($searchedDepartment) {
        $this->bomDepartments = BomDepartment::where('name', 'like', '%'.$searchedDepartment.'%')->get();
    }
}
