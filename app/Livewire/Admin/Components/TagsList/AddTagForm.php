<?php

namespace App\Livewire\Admin\Components\TagsList;

use Livewire\Component;
use App\Models\Tag;
use Exception;

class AddTagForm extends Component
{
    public $tagName;

    public $rules = [
        'tagName' => ['required', 'unique:tags,name'],
    ];

    public function render()
    {
        return view('livewire.admin.components.tags-list.add-tag-form');
    }

    public function AddTag() {
        $this->validate();
        try {
            // Create tag
            $result = Tag::create([
                'name' => $this->tagName,
            ]);
            if ($result) {
                $this->ThrowMessageNotif('You added a new tag "'.$this->tagName.'"', 'success');
                $this->dispatch('TagAdded');
                $this->reset();
            }
        } catch (Exception $ex) {
            $this->ThrowMessageNotif($ex->getMessage(), 'danger');
        }
    }

    private function ThrowMessageNotif($message, $color) {
        $msgData = [
            'message' => $message,
            'color' => $color,
        ];
        $this->dispatch('UpdateMessageNotif', $msgData);
    }
}
