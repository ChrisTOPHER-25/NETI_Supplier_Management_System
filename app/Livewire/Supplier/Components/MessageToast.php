<?php

namespace App\Livewire\Supplier\Components;

use Livewire\Component;

class MessageToast extends Component
{

    public $listeners = ['UpdateMessageToastr'];

    public $msgToast = [];
    public function render()
    {
        return view('livewire.supplier.components.message-toast');
    }

    public function UpdateMessageToastr($msgToast)
    {
        $this->msgToast = $msgToast;

        if ($msgToast['color'] == 'danger') {
            toastr()->error($msgToast['message'], ['positionClass' => 'toast-bottom-right']);
        } elseif ($msgToast['color'] == 'warning') {
            toastr()->warning($msgToast['message'], ['positionClass' => 'toast-bottom-right']);
        } elseif ($msgToast['color'] == 'success') {
            toastr()->success($msgToast['message'], ['positionClass' => 'toast-bottom-right']);
        }
    }
}

