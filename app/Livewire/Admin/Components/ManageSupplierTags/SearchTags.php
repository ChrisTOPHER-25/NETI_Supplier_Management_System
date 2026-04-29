<?php

namespace App\Livewire\Admin\Components\ManageSupplierTags;

use App\Models\SupplierTag;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Livewire\Component;

class SearchTags extends Component
{
    public $supplier;

    public $TagsList = [], $searchedTag;

    protected $listeners = [
        'SupplierSelected'
    ];

    public function render()
    {
        return view('livewire.admin.components.manage-supplier-tags.search-tags');
    }

    public function SupplierSelected($supplierId) {
        $this->supplier = User::findOrFail($supplierId);
    }

    public function mount()
    {
        $this->reset('TagsList');
        $this->TagsList = Tag::get();
    }

    public function SearchTag()
    {
        if (empty($this->TagsList) == false) {
            $this->reset('TagsList');
            $this->TagsList = Tag::where('name', 'like', '%' . $this->searchedTag . '%')->get();
            if (count($this->TagsList) == 0) {
                unset($this->TagsList);
            }
        } else {
            $this->mount();
        }
    }
    
    public function AddTag() {
        if (!empty($this->searchedTag)) {
            if (Tag::where('name', $this->searchedTag)->count() == 0) {
                // Create Tag
                $createResult = Tag::create([
                    'name' => $this->searchedTag,
                ]);
                if ($createResult) {
                    // Create supplier-tag relationship
                    SupplierTag::create([
                        'tag_id' => $createResult->id,
                        'user_id' => $this->supplier->id,
                    ]);
                    $msg = 'You assigned the tag "' . $createResult->name . '" to supplier "'.$this->supplier->name.'"';
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => $msg,
                        'color' => 'success',
                    ]);
                    $this->dispatch('TagAdded');
                    $this->reset('searchedTag');
                    $this->mount();
                }
            }
        }
    }

    public function AssignTag($tagId)
    {
        try {
            // Find tag
            $tag = Tag::findOrFail($tagId);
            if (empty($tag) == false) {
                // Check if supplier-tag relationship does not exist
                $checkRelationship = SupplierTag::where('tag_id', $tag->id)->where('user_id', $this->supplier->id)->get();
                if (count($checkRelationship) == 0) {
                    // Create supplier-tag relationship
                    SupplierTag::create([
                        'tag_id' => $tag->id,
                        'user_id' => $this->supplier->id,
                    ]);
                    $msg = 'You assigned the tag "' . $tag->name . '" to supplier "'.$this->supplier->name.'"';
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => $msg,
                        'color' => 'success',
                    ]);
                    $this->dispatch('TagAdded');
                } else {
                    $msg = 'Supplier "' . $this->supplier->name . '" already has the tag name "'.$tag->name.'"';
                    $this->dispatch('UpdateMessageNotif', [
                        'message' => $msg,
                        'color' => 'warning',
                    ]);
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
