<?php

namespace App\Livewire\Admin\Components\ManageSupplierTags;

use App\Models\SupplierTag;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;
use Exception;

class SupplierInfo extends Component
{
    public $listeners = [
        'SupplierSelected', 'TagAdded',
    ];

    public $supplier, $tagName, $TagsList = [], $selectedTagId;

    public $rules = [
        'tagName' => ['required', 'string'],
    ];

    public function render()
    {
        return view('livewire.admin.components.manage-supplier-tags.supplier-info');
    }

    public function mount()
    {
        $this->reset('TagsList');
        $this->TagsList = Tag::get();
    }

    public function SupplierSelected($supplierId)
    {
        $this->supplier = User::findOrFail($supplierId);
    }

    // public function AssignTag()
    // {
    //     try {
    //         // Find tag
    //         $tag = Tag::findOrFail($this->selectedTagId);
    //         if (empty($tag) == false) {
    //             // Check if supplier-tag relationship does not exist
    //             $checkRelationship = SupplierTag::where('tag_id', $tag->id)->where('user_id', $this->supplier->id)->get();
    //             if (count($checkRelationship) == 0) {
    //                 // Create tag relationship to supplier
    //                 SupplierTag::create([
    //                     'tag_id' => $tag->id,
    //                     'user_id' => $this->supplier->id,
    //                 ]);
    //                 $this->ThrowMessageNotif('You assigned the tag "' . $tag->name . '" to supplier "' . $this->supplier->name . '"', 'success');
    //                 $this->reset('tagName');
    //             } else {
    //                 $this->ThrowMessageNotif('Supplier "' . $this->supplier->name . '" already has the tag name "' . $tag->name . '"', 'warning');
    //             }
    //         }
    //     } catch (Exception $ex) {
    //         $this->ThrowMessageNotif($ex->getMessage(), 'danger');
    //     }
    // }

    public function RemoveSupplierTag($supplierTag)
    {
        try {
            // Find supplier tag
            $sp = SupplierTag::where('tag_id', $supplierTag['tag_id'])
                ->where('user_id', $supplierTag['user_id'])->firstOrFail();
            // Find tag
            $tag = Tag::findOrFail($supplierTag['tag_id']);
            // Find supplier
            $supplier = User::findOrFail($supplierTag['user_id']);
            if (empty($sp) == false) {
                $result = SupplierTag::destroy($sp->id);
                if ($result) {
                    $this->ThrowMessageNotif('You removed the tag "' . $tag->name . '" from supplier "' . $supplier->name . '"', 'success');
                }
            }
        } catch (Exception $ex) {
            $this->ThrowMessageNotif($ex->getMessage(), 'danger');
        }
    }

    public function ThrowMessageNotif($message, $color)
    {
        $msgData = [
            'message' => $message,
            'color' => $color,
        ];
        $this->dispatch('UpdateMessageNotif', $msgData);
        $this->mount();
    }
}
