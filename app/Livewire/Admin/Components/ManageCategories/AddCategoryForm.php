<?php

namespace App\Livewire\Admin\Components\ManageCategories;

use App\Models\BomMaterialCategory;
use App\Models\BomDepartment;
use App\Models\Tag;
use Exception;
use Livewire\Component;

class AddCategoryForm extends Component
{
    public $categoryName, $categories = [];

    public $unit, $categoryUnits = [];

    public $usesBrand = false, $categoriesUsingBrand = [];

    public $selectedDepartment, $departments = [], $checkedDepartments = [];

    public $showAddButton = false;

    protected function rules()
    {
        return [
            'categoryName' => ['required', 'string'],
            'unit' => ['required'],
            'usesBrand' => ['required'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.manage-categories.add-category-form');
    }

    public function ShowAddButton() {
        if (!empty($this->categoryName) && !empty($this->unit)) {
            $this->showAddButton = true;
        } else {
            $this->showAddButton = false;
        }
    }

    public function RemoveCategoryFromList($key) {
        unset($this->categories[$key]);        
        unset($this->categoryUnits[$key]);
        unset($this->categoriesUsingBrand[$key]);
    }

    public function AddCategoryToList() {
        $this->validate();
        if (in_array($this->categoryName, $this->categories) == false) {
            // Push to categories
            array_push($this->categories, $this->categoryName);
            // Push to categories using brand
            if ($this->usesBrand == '1') {
                array_push($this->categoriesUsingBrand, $this->categoryName);
            }
            // Push to categories unit
            array_push($this->categoryUnits, $this->unit);

            $this->resetErrorBag();
            $this->reset('categoryName', 'showAddButton');
        } else {
            $this->addError('categoryName', 'You already added this category');
        }
    }

    public function RemoveDepartmentFromList($key, $selectedDepartment) {
        unset($this->departments[$key]);
        $this->checkedDepartments[$selectedDepartment] = false;
    }

    public function AddDepartmentToList() {
        foreach ($this->checkedDepartments as $departmentId => $departmentCheckStatus) {
            if ($departmentCheckStatus == true) {
                if (in_array($departmentId, $this->departments) == false) {
                    array_push($this->departments, $departmentId);
                }
            } 
            // else {
            //     if (in_array($departmentId, $this->departments)) {
            //         unset($this->departments[$departmentId]);
            //     }
            // }
        }
    }

    public function AddCategory() {
        try {
            if (empty($this->categories)) {
                $this->addError('categoryName', 'Please add a new category');
                return;
            }
            if (empty($this->departments)) {
                $this->addError('selectedDepartment', 'Please choose which departments will use the category');
                return;
            }
            $categoryCreateResult = null;
            foreach ($this->categories as $key => $newCategoryName) {
                foreach ($this->departments as $departmentId) {
                    if (BomMaterialCategory::where('name', $newCategoryName)->where('department_id', $departmentId)->count() == 0) {
                        $categoryCreateResult = BomMaterialCategory::create([
                            'name' => $newCategoryName,
                            'department_id' => $departmentId,
                            'unit' => $this->categoryUnits[$key],
                            'uses_brand' => in_array($newCategoryName, $this->categoriesUsingBrand),
                        ]);
                        if (count(Tag::where('name', $newCategoryName)->get()) == 0) {
                            Tag::create(['name' => $newCategoryName]);
                        }
                    }
                }
            }
            if ($categoryCreateResult) {
                $msg = 'You added a new category to the following departments: ';
                foreach ($this->departments as $key => $departmentId) {
                    $msg .= BomDepartment::findOrFail($departmentId)->name;
                    if ($key != count($this->departments) - 1) {
                        $msg .= ", ";
                    }
                }
                $this->dispatch('UpdateMessageNotif', ['message'=>$msg,'color'=>'success']);
                $this->dispatch('CategoryAdded');
                $this->reset('categoryName' , 'selectedDepartment', 'departments', 'categories', 'checkedDepartments', 
                'categoriesUsingBrand', 'categoryUnits', 'usesBrand');
                $this->resetErrorBag();
            } else {
                $this->dispatch('UpdateMessageNotif', ['message'=>'The selected departments already have the added tag(s)','color'=>'warning']);
                $this->reset('categoryName' , 'selectedDepartment', 'departments', 'categories', 'checkedDepartments');
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', ['message' => $ex->getMessage(), 'color' => 'danger']);
        }
    }
}
