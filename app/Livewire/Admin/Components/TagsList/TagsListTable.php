<?php

namespace App\Livewire\Admin\Components\TagsList;

use App\Models\BomMaterialCategory;
use App\Models\SupplierTag;
use App\Models\Tag;
use Livewire\Component;
use Exception;

class TagsListTable extends Component
{
    public $listeners = [
        'TagAdded', 'TagDeleted',
    ];
    public $selectedTags = [], $selectAll;

    public $tagsList = [];

    public function mount() {
        $this->reset('selectedTags');
        $this->tagsList = Tag::get();
        $this->RefreshSelectedTags();
    }

    public function render()
    {
        return view('livewire.admin.components.tags-list.tags-list-table');
    }

    public function TagAdded() {
        $this->mount();
        $this->RefreshSelectedTags();
    }

    public function TagDeleted() {
        $this->mount();
        $this->RefreshSelectedTags();
    }

    public function ChangeTagsSelectedState() {
        foreach ($this->selectedTags as $tagId => $tagIsSelected) {
            $this->selectedTags[$tagId] = $this->selectAll ? true : false;
        }
        $this->DispatchSelectedTags();
    }

    private function RefreshSelectedTags() {
        foreach ($this->tagsList as $tag) {
            $this->selectedTags[$tag->id] = false;
        }
        $this->selectAll = false;
        $this->dispatch('UpdateSelectedTags', $this->selectedTags);
    }

    public function UnselectSelectAll($tagId) {
        if ($this->selectedTags[$tagId] == false) {
            $this->selectAll = false;
        }
        $this->DispatchSelectedTags();
    }

    public function DispatchSelectedTags() {
        $this->dispatch('UpdateSelectedTags', $this->selectedTags);
    }
}
