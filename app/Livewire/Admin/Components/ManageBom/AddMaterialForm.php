<?php

namespace App\Livewire\Admin\Components\ManageBom;

use App\Models\Bom;
use App\Models\BomMaterial;
use App\Models\BomMaterialCategory;
use App\Models\BomTag;
use App\Models\Tag;
use Exception;
use Livewire\Component;

class AddMaterialForm extends Component
{
    protected $listeners = [
        'UpdateAddMaterialForm'
    ];

    public $selectedBomId, $bomDepartmentId;

    public $name, $brand, $unit, $description, $quantity, $category, $categorySelected = false;

    public $showingBrand = false, $showingQuantity = false;

    public $showingUnit = false, $currentUnit;

    public function render()
    {
        return view('livewire.admin.components.manage-bom.add-material-form');
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => ['required', 'numeric'],
            'quantity' => ['required', 'regex:/^[0-9.]+$/']
        ];
    }

    public function UpdateAddMaterialForm($bomId, $bomDepartmentId)
    {
        $this->reset();
        $this->selectedBomId = $bomId;
        $this->bomDepartmentId = $bomDepartmentId;
    }

    public function ShowBrandOrUnit() {
        if (empty($this->category) || $this->category == 'none') {
            $this->showingBrand = false;
            $this->showingUnit = false;
            $this->reset('category', 'categorySelected', 'showingQuantity');
        } else {
            if (!empty(BomMaterialCategory::findOrFail($this->category)->unit)) {
                $this->showingUnit = true;
                $this->currentUnit = BomMaterialCategory::findOrFail($this->category)->unit;
            } else {
                $this->showingUnit = false;
            }
            if (empty($this->category) == false) {
                $this->showingBrand = BomMaterialCategory::findOrFail($this->category)->uses_brand ? true : false;
            }
            $this->showingQuantity = true;
            $this->categorySelected = true;
        }
    }

    public function AddMaterial()
    {
        $this->validate();
        if ($this->showingBrand) {
            $this->validate(['brand' => ['required']]);
        }
        try {
            if (empty($this->selectedBomId) == false) {                
                // Find BOM
                $bom = Bom::findOrFail($this->selectedBomId);

                // Find tag of added material
                $tag = Tag::where('name', BomMaterialCategory::findOrFail($this->category)->name)->firstOrFail();
                $tagAssignResult = false;

                // Check if tag is already assigned to BOM
                if (BomTag::where('tag_id', $tag->id)->where('bom_id', $this->selectedBomId)->count() == 0) {
                    // Assign tag to BOM
                    $tagAssignResult = BomTag::create([
                        'tag_id' => $tag->id,
                        'bom_id' => $this->selectedBomId,
                    ]);
                } else {
                    $tagAssignResult = true;
                }

                // Create BomMaterial
                $materialCreateResult = BomMaterial::create([
                    'quantity' => $this->quantity,
                    'name' => $this->name,
                    'unit' => $this->currentUnit,
                    'description' => $this->description,
                    'category_id' => $this->category,
                    'bom_id' => $bom->id,
                ]);

                // Add brand if showing
                if ($this->showingBrand && !empty($this->brand)) {
                    $materialCreateResult->brand = $this->brand;
                }

                $materialCreateResult->save();

                if ($tagAssignResult && $materialCreateResult) {
                    $this->dispatch('MaterialAdded', $this->selectedBomId);
                    $this->dispatch('UpdatePublishForm', Bom::findOrFail($this->selectedBomId));
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => 'You added a new material "' . $this->name . '" to Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')',
                        'color' => 'success',
                    ]);
                    $this->reset('name', 'brand', 'unit', 'description', 'quantity', 'category', 'showingBrand', 'showingUnit', 'categorySelected');
                }
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'success',
            ]);
        }
    }
}
