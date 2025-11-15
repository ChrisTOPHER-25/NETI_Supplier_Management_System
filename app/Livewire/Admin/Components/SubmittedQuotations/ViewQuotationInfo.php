<?php

namespace App\Livewire\Admin\Components\SubmittedQuotations;

use App\Models\Bom;
use App\Models\ClosedBom;
use App\Models\PublishedBom;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use App\Models\SubmittedQuotation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewQuotationInfo extends Component
{
    public $quotationId, $quotation, $quotationStatus;

    public $materials, $totalQty;

    public $viewingMaterialInfo = false, $viewingMaterialId;

    protected $listeners = [
        'OrderChanged', 'CloseMaterialInfo', 'QuotationAccepted',
    ];

    public function render()
    {
        return view('livewire.admin.components.submitted-quotations.view-quotation-info');
    }

    public function mount()
    {
        if (!empty($this->quotationId)) {
            $this->quotation = Quotation::findOrFail($this->quotationId);
            $this->quotationStatus = SubmittedQuotation::where('quotation_id', $this->quotation->id)->firstOrFail()->status;
            $this->materials = QuotationMaterial::where('quotation_id', $this->quotation->id)->get();
            foreach ($this->materials as $material) {
                $this->totalQty += $material->quantity;
            }
        }
    }

    public function CloseMaterialInfo()
    {
        $this->reset('viewingMaterialInfo', 'viewingMaterialId');
    }

    public function ViewMaterialInfo($materialId)
    {
        $quotationMaterial = QuotationMaterial::findOrFail($materialId);
        if ($quotationMaterial) {
            $this->viewingMaterialInfo = true;
            $this->viewingMaterialId = $quotationMaterial->id;
        } else {
            $this->viewingMaterialInfo = false;
        }
    }

    public function AcceptQuotation($quotationId)
    {
        try {
            // Find quotation
            $acceptedQuotation = Quotation::findOrFail($quotationId);
            // Find the accepted quotation's SubmittedQuotation data
            $submittedQuotation = SubmittedQuotation::where('quotation_id', $acceptedQuotation->id)->firstOrFail();
            // Update status to accepted
            $submittedQuotation->status = 'accepted';
            $saveResult = $submittedQuotation->save();
            if ($saveResult) {
                // Find quotation's BOM
                $bom = Bom::findOrFail($acceptedQuotation->bom_id);
                // Decline other quotations
                $quotationsToDecline = Quotation::where('bom_id', $this->quotation->bom_id)->where('id', '!=', $quotationId)->get();
                foreach ($quotationsToDecline as $quotationDecline) {
                    // Find the declined quotation's SubmittedQuotation data
                    $submittedQuotation = SubmittedQuotation::where('quotation_id', $quotationDecline->id)->firstOrFail();
                    $submittedQuotation->status = 'declined';
                    $submittedQuotation->save();
                    $this->SendDeclinedNotif($quotationDecline, $bom);
                }
                // Delete PublishedBom data
                $publishedBom = PublishedBom::where('bom_id', $bom->id)->firstOrFail();
                PublishedBom::destroy($publishedBom->id);
                // Update BOM status to closed
                $bom->status = 'closed';
                $bomSaveResult = $bom->save();
                // Create ClosedBom data
                $bomCloseResult = ClosedBom::create([
                    'bom_id' => $bom->id,
                ]);
                if ($bomSaveResult && $bomCloseResult) {
                    // Send quotation accepted notif
                    $this->SendAcceptedNotif($acceptedQuotation, $bom);
                    $this->dispatch('QuotationAccepted');
                    // return redirect()->to('/admin/published-boms');
                }
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    private function SendAcceptedNotif($quotation, $bom)
    {
        // Recipients
        $recipients = [];
        foreach (User::where('user_type', 'superadmin')->get() as $user) {
            if ($user->id != Auth::user()->id) {
                array_push($recipients, $user->id);
            }
        }
        array_push($recipients, $quotation->user_id);
        array_push($recipients, Auth::user()->id);
        // Notification
        $this->dispatch('CreateNotif', [
            'title' => 'Quotation Accepted',
            'message' => ' accepted Quotation #' . $quotation->id . ' for Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')',
            'url' => '/admin/submitted-quotations',
            'recipients' => $recipients,
        ]);
    }

    private function SendDeclinedNotif($quotation, $bom)
    {
        // Recipients
        $recipients = [];
        array_push($recipients, $quotation->user_id);
        // Notification
        $this->dispatch('CreateNotif', [
            'title' => 'Quotation Declined',
            'message' => ' declined your quotation for Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')',
            'url' => '/admin/submitted-quotations',
            'recipients' => $recipients,
        ]);
    }
}
