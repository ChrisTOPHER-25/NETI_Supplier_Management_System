<?php

namespace App\Livewire\Admin\Components\DraftBoms;

use App\Models\Bom;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BomListTable extends Component
{
    use WithPagination;

    protected $listeners = [
        'BomAdded'
    ];

    public $searchedBom;

    public function render()
    {
        if (empty($this->searchedBom)) {
            return view('livewire.admin.components.draft-boms.bom-list-table', [
                'draftBoms' => Bom::where('status', 'draft')->orderBy('created_at', 'desc')->paginate(10)
            ]);
        } else {
            return view('livewire.admin.components.draft-boms.bom-list-table', [
                'draftBoms' => Bom::where('status', 'draft')->where('subject', 'like', '%' . $this->searchedBom . '%')->orderBy('created_at', 'desc')->paginate(10)
            ]);
        }
    }

    public function SearchBom()
    {
        $this->resetPage();
    }

    public function ResetSearch()
    {
        $this->reset('searchedBom');
    }

    public function DeleteBom($id) {
        $bom = Bom::findOrFail($id);
        $result = Bom::destroy($id);
        if ($result) {
            $msg = 'You deleted Bill of Materials #'.$bom->id.' ('.$bom->subject.')';
                // Message Notif
                $this->dispatch('UpdateMessageNotif', [
                    'message' => $msg,
                    'color' => 'success',
                ]);
                // Notif Recipients
                $recipients = [];
                foreach (User::where('user_type', 'superadmin')->get() as $user) {
                    if ($user->id != Auth::user()->id) {
                        array_push($recipients, $user->id);
                    }
                }
                array_push($recipients, Auth::user()->id);
                // Create Notif
                $this->dispatch('CreateNotif', [
                    'title' => 'BOM Deleted',
                    'message' => ' deleted the Bill of Materials #'.$bom->id.' ('.$bom->subject.')',
                    'url' => '/admin/draft-boms',
                    'recipients' => $recipients,
                ]);
            $this->resetPage();
        }
    }

    public function ManageBom($bomId)
    {
        $this->redirectRoute('admin.manage_bom', ['bom_id' => $bomId]);
    }
}
