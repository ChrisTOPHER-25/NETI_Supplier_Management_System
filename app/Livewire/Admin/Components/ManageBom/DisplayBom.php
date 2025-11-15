<?php

namespace App\Livewire\Admin\Components\ManageBom;

use App\Models\Bom;
use Livewire\Component;
use App\Models\BomMaterial;
use App\Models\BomMaterialCategory;
use App\Models\BomTag;
use App\Models\PublishedBom;
use App\Models\Tag;
use Exception;

class DisplayBom extends Component
{
    protected $listeners = [
        'BomSelected', 'MaterialAdded', 'TagAdded' => 'UpdateAddMaterialForm', 'TagRemoved' => 'UpdateAddMaterialForm',
        'BomPublished' => 'UpdateBom', 'BomUnpublished' => 'UpdateBom', 'UpdatedBomTitleCategory' => 'BomSelected',
    ];

    public $bom, $newSelectedDepartment, $newSubject;

    public function render()
    {
        return view('livewire.admin.components.manage-bom.display-bom');
    }

    public function UpdateAddMaterialForm()
    {
        $this->dispatch('UpdateAddMaterialForm', $this->bom['id'], $this->bom['department_id']);
    }

    public function BomSelected($bom)
    {
        $this->reset('bom', 'newSelectedDepartment', 'newSubject');
        $this->bom = $bom;
        $this->dispatch('UpdateAddMaterialForm', $bom['id'], $bom['department_id']);
    }

    public function UpdateBom($bom)
    {
        $this->reset('bom');
        $this->bom = $bom;
    }

    public function DeleteMaterial($id)
    {
        try {
            if (empty($id) == false && $id > 0) {
                $result = BomMaterial::findOrfail($id);
                if ($result) {
                    // Prevent delete if bom is already published
                    if ($this->bom['status'] == 'published') {
                        throw new Exception('You cannot delete materials from BOMs that are already published');
                    }
                    // Delete material
                    $destroyResult = BomMaterial::destroy($id);
                    // Unassign tag from BOM
                    $unassignTagResult = false;
                    // Check for materials inside BOM that has similar category
                    if (BomMaterial::where('category_id', $result->category_id)->where('bom_id', $this->bom['id'])->count() > 0) {
                        // Do not unassign tag
                        $unassignTagResult = true;
                    } else {
                        // Remove the tag from BOM if there are no more materials that use the deleted material's category
                        $tag = Tag::where('name', BomMaterialCategory::findOrFail($result->category_id)->name)->firstOrFail();
                        $unassignTagResult = BomTag::destroy(BomTag::where('tag_id', $tag->id)->firstOrFail()->id);
                    }
                    if ($unassignTagResult && $destroyResult) {
                        $this->dispatch('UpdateMessageNotif', [
                            'message' => 'You removed "' . $result->name . '" from Bill of Materials #' . $this->bom['id'] . ' (' . $this->bom['subject'] . ')',
                            'color' => 'success',
                        ]);
                        $this->dispatch('$refresh');
                        $this->dispatch('MaterialRemoved');
                        $this->dispatch('UpdatePublishForm', $this->bom);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }

    public function UpdateSubjectDepartment()
    {
        try {
            $bom = Bom::findOrFail($this->bom['id']);
            if ($bom) {
                // Update subject
                if (empty($this->newSubject) == false) {
                    $bom->subject = $this->newSubject;
                }
                // Update department
                if (empty($this->newSelectedDepartment) == false) {
                    $bom->department_id = $this->newSelectedDepartment;
                }
                $result = $bom->save();
                if ($result) {
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => 'You updated this Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')',
                        'color' => 'success',
                    ]);
                    $this->dispatch('UpdatedBomTitleCategory', $bom);
                }
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }
}
