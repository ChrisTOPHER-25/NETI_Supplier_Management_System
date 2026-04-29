<?php

namespace App\Livewire\Admin\Components\ManageBom;

use App\Models\Bom;
use App\Models\PublishedBom;
use App\Models\SupplierBomStatus;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UnpublishBomForm extends Component
{
    public $selectedBom;

    public function render()
    {
        return view('livewire.admin.components.manage-bom.unpublish-bom-form');
    }

    public function UnpublishBom()
    {
        try {
            // Prevent unpublish if suppliers already accepted the BOM
            if (SupplierBomStatus::where('bom_id', $this->selectedBom->id)->where('status', 'accepted')->count() > 0) {
                throw new Exception('You cannot unpublish this BOM as it has already been accepted by some suppliers');
            }
            // Find bom
            $bom = Bom::findOrFail($this->selectedBom->id);
            //Check if bom has been accepted by any supplier
            if (count(SupplierBomStatus::where('bom_id', $bom->id)->where('status', 'accepted')->get()) > 0) {
                throw new Exception('You cannot unpublish this BOM because some suppliers have already accepted it.');
            }
            if (empty($bom) == false) {
                $bom->status = 'draft';
                $result = $bom->save();
                if ($result) {
                    // Remove from published_boms table
                    $publishedBom = PublishedBom::where('bom_id', $bom->id)->firstOrFail();
                    $destroyResult = PublishedBom::destroy($publishedBom->id);
                    if ($destroyResult) {
                        $this->ThrowMessageNotif('You unpublished Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')', 'success');
                        // Recipients
                        $recipients = [];
                        // Push notif to superadmins
                        foreach (User::where('user_type', 'superadmin')->get() as $superadmin) {
                            array_push($recipients, $superadmin->id);
                        }
                        // Notification
                        $this->dispatch('CreateNotif', [
                            'title' => 'BOM Published',
                            'message' => Auth::user()->name . ' published Bill of Materials #' . $bom->id . '(' . $bom->subject . ')',
                            'url' => '/admin/published-boms',
                            'recipients' => $recipients,
                        ]);
                        $this->dispatch('BomUnpublished', $bom);
                    }
                }
            }
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
