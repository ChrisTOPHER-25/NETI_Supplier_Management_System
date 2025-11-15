<?php

namespace App\Livewire\Supplier\Components\CreateQuotation;

use App\Models\Bom;
use App\Models\Quotation;
use App\Models\SubmittedQuotation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubmitQuotation extends Component
{
    public $quotation;

    protected $listeners = [
        'CreateNotif',
    ];

    public function render()
    {
        return view('livewire.supplier.components.create-quotation.submit-quotation');
    }

    public function SubmitQuotation()
    {
        try {
            // Add to submitted_quotations
            $publishResult = SubmittedQuotation::create([
                'quotation_id' => $this->quotation->id,
            ]);
            // Find submitted quotation's BOM
            $bom = Bom::findOrFail(Quotation::findOrFail($publishResult->quotation_id)->bom_id);
            if ($publishResult) {
                $this->dispatch('QuotationPublished');
                // Recipients
                $recipients = [];
                foreach (User::where('user_type', 'superadmin')->orWhere('user_type', 'admin')->get() as $user) {
                    if ($user->id != Auth::user()->id) {
                        array_push($recipients, $user->id);
                    }
                }
                array_push($recipients, Auth::user()->id);
                // Notification
                $this->dispatch('CreateNotif', [
                    'title' => 'Quotation Submitted',
                    'message' => ' submitted a quotation for Bill of Materials #' . $bom->id .' ('.$bom->subject.')',
                    'url' => '/admin/submitted-quotations',
                    'recipients' => $recipients,
                ]);
            }
            toastr()->success('Your quotation has been submitted successfully!', [
                'positionClass' => 'toast-bottom-right',
            ]);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
