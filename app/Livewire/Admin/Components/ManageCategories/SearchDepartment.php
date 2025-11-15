<?php

namespace App\Livewire\Admin\Components\ManageCategories;

use Livewire\Component;

class SearchDepartment extends Component
{

    public $searchedDepartment;

    public function render()
    {
        return view('livewire.admin.components.manage-categories.search-department');
    }

    public function SearchDepartment() {
        if (empty($this->searchedDepartment) == false) {
            $this->dispatch('DepartmentSearched', $this->searchedDepartment);
        } else {
            $this->ClearSearch();
        }
    }

    public function ClearSearch() {
        $this->reset();
        $this->dispatch('DepartmentSearchCleared');
    }
}
