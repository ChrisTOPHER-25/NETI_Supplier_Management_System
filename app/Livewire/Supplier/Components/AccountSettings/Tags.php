<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use App\Models\SupplierTag;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tags extends Component
{
    // public $newTagName;

    public $SupplierTags = [];

    public function rules()
    {
        return [
            // 'newTagName' => ['required', 'string'],
        ];
    }

    public function render()
    {
        return view('livewire.supplier.components.account-settings.tags');
    }

    public function mount()
    {
        $this->reset('SupplierTags');
        $this->SupplierTags = SupplierTag::where('user_id', Auth::user()->id)->get();
    }

    public function RemoveTag($tagId)
    {
        try {
            // Get supplier's tags
            $supplierTags = SupplierTag::where('user_id', Auth::user()->id)->where('tag_id', $tagId)->get();
            foreach ($supplierTags as $st) {
                SupplierTag::destroy($st->id);
            }
            $this->mount();
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    // public function AddTag()
    // {
    //     $this->validateOnly('newTagName');
    //     try {
    //         // Check if tag name already exists
    //         if (count(Tag::where('name', $this->newTagName)->get()) == 0) {
    //             // Create tag if it does not exist
    //             $result = Tag::create([
    //                 'name' => $this->newTagName,
    //             ]);
    //         }
    //         // Find tag
    //         $tag = Tag::where('name', $this->newTagName)->firstOrFail();
    //         // Check if supplier-tag relationship already exists
    //         if (count(SupplierTag::where('tag_id', $tag->id)->where('user_id', Auth::user()->id)->get()) == 0) {
    //             // Create supplier-tag relationship if it does not exist
    //             $result = SupplierTag::create([
    //                 'tag_id' => $tag->id,
    //                 'user_id' => Auth::user()->id,
    //             ]);
    //             if ($result) {
    //                 $this->mount();
    //                 $this->reset('newTagName');
    //             }
    //         } else {
    //             $this->addError('newTagName', 'You already have the tag "'.$tag->name.'"');
    //         }
    //     } catch (Exception $ex) {
    //         dd($ex->getMessage());
    //     }
    // }

    public function ValidateField($propertyName)
    {
        if ($propertyName == 'newTagName') {
            $this->validateOnly('newTagName');
        }
    }
}
