<?php

namespace App\Livewire\Admin\Components\DraftBoms;

use App\Models\Bom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddBomForm extends Component
{
    public $subject, $department;

    protected function rules() {
        return [
            'subject' => ['required', 'string'],
            'department' => ['required' , 'numeric'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.draft-boms.add-bom-form');
    }

    public function AddBom() {
        $this->validate();
        $result = Bom::create([
            'subject' => $this->subject,
            'department_id' => $this->department,
        ]);
        if ($result) {
            $this->dispatch('BomAdded');
            $this->dispatch('UpdateMessageNotif', ['message' => 'You added a bill of materials "'.$result->subject.'"', 'color' => 'success']);

            // Recipients
            $recipients = [];
            foreach (User::where('user_type', 'superadmin')->get() as $user) {
                if ($user->id != Auth::user()->id) {
                    array_push($recipients, $user->id);
                }
            }
            array_push($recipients, Auth::user()->id);
            // Notification
            $this->dispatch('CreateNotif', [
                'title' => 'BOM Created',
                'message' => ' created Bill of Materials #' . $result->id . ' ('.$result->subject.')',
                'url' => '/admin/draft-boms',
                'recipients' => $recipients,
            ]);


            $this->reset();
        }
    }
}
