<?php

namespace App\Livewire\Admin\Components\ManageCategories;

use App\Models\BomDepartment;
use App\Models\BomMaterial;
use App\Models\BomMaterialCategory;
use Exception;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ViewDepartmentCategories extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'CategoryAdded' => 'mount', 'CategoryDeleted',
    ];

    public $departmentId;

    public $selectedCategories = [], $searchedCategory;

    public function render()
    {
        if (empty($this->searchedCategory)) {
            $categories = BomMaterialCategory::where('department_id', $this->departmentId)->paginate(15);
            return view('livewire.admin.components.manage-categories.view-department-categories', [
                'categories' => $categories
            ]);
        } else {
            $categories = BomMaterialCategory::where('department_id', $this->departmentId)->where('name', 'like', '%' . $this->searchedCategory .'%')->paginate(15);
            return view('livewire.admin.components.manage-categories.view-department-categories', [
                'categories' => $categories
            ]);
        }
    }

    public function DeleteCategory($id) {
        try {
            if (BomMaterial::where('category_id', $id)->count() == 0) {
                $category = BomMaterialCategory::findOrFail($id);
                $result = BomMaterialCategory::destroy($category->id);
                if ($result) {
                    $this->dispatch('CategoryDeleted');
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => 'You deleted the category "'.$category->name.'" from the department "'.BomDepartment::findOrFail($this->departmentId)->name.'"',
                        'color' => 'success',
                    ]);
                }
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function SearchCategory() {
        $this->resetPage();
    }

    public function ResetSearch() {
        $this->reset('searchedCategory');
        $this->resetPage();
    }
}
