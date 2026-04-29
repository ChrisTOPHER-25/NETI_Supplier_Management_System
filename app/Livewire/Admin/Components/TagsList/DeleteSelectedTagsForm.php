<?php

namespace App\Livewire\Admin\Components\TagsList;

use App\Models\BomMaterialCategory;
use App\Models\BomTag;
use App\Models\SupplierTag;
use Livewire\Component;
use App\Models\Tag;
use Exception;

class DeleteSelectedTagsForm extends Component
{
    public $listeners = [
        'UpdateSelectedTags',
    ];

    public $selectedTags = [];

    public function render()
    {
        return view('livewire.admin.components.tags-list.delete-selected-tags-form');
    }

    public function UpdateSelectedTags($selectedTags)
    {
        $this->selectedTags = [];
        $this->selectedTags = $selectedTags;
    }

    public function DeleteSelectedTags()
    {
        try {
            foreach ($this->selectedTags as $tagId => $tagIsSelected) {
                // Find tag
                $tag = Tag::findOrFail($tagId);
                if ($tag) {
                    // Check for associated materials, suppliers, and BOMs before deleting
                    if (
                        BomMaterialCategory::where('name', $tag->name)->count() == 0 &&
                        SupplierTag::where('tag_id', $tag->id)->count() == 0 &&
                        BomTag::where('tag_id', $tag->id)->count() == 0 && $tagIsSelected
                    ) {
                        // Proceed to delete tag
                        Tag::destroy($tagId);
                        $this->ThrowMessageNotif('You deleted the selected tag(s)', 'success');
                        $this->dispatch('TagDeleted');
                    }
                }
            }
            $this->reset('selectedTags');
        } catch (Exception $ex) {
            $this->ThrowMessageNotif($ex->getMessage(), 'danger');
        }
    }

    private function ThrowMessageNotif($message, $color)
    {
        $msgData = [
            'message' => $message,
            'color' => $color,
        ];
        $this->dispatch('UpdateMessageNotif', $msgData);
    }
}
