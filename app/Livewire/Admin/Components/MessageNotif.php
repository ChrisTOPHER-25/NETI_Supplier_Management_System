<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class MessageNotif extends Component
{
    public $listeners = [
        'UpdateMessageNotif',
    ];

    public $msgData = [];

    public function render()
    {
        return view('livewire.admin.components.message-notif');
    }

    public function UpdateMessageNotif($msgData) {
        $this->msgData = $msgData;
        if ($msgData['color'] == 'danger') {
            toastr()->error($msgData['message'], [
                'positionClass' => 'toast-bottom-right',
            ]); 
        } else if ($msgData['color'] == 'warning') {
            toastr()->warning($msgData['message'], [
                'positionClass' => 'toast-bottom-right',
            ]); 
        } else if ($msgData['color'] = 'success') {
            toastr()->success($msgData['message'], [
                'positionClass' => 'toast-bottom-right',
            ]); 
        }
    }
    
}
