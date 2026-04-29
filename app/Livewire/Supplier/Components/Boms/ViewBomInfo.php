<?php

namespace App\Livewire\Supplier\Components\Boms;

use App\Models\Bom;
use App\Models\BomMaterial;
use App\Models\BomTag;
use App\Models\PublishedBom;
use App\Models\Quotation;
use App\Models\SupplierBomStatus;
use App\Models\SupplierTag;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewBomInfo extends Component
{
    public $bom,
        $bomMaterials = [],
        $bomStatus;

    public function render()
    {
        return view('livewire.supplier.components.boms.view-bom-info');
    }

    public function mount()
    {
        try {
            foreach (BomMaterial::where('bom_id', $this->bom->id)->get() as $material) {
                $this->bomMaterials[$material->id] = $material;
            }
            $status = SupplierBomStatus::where('bom_id', $this->bom['id'])->first();
            if ($status) {
                $this->bomStatus = $status;
            }
        } catch (Exception $ex) {
            dd('Error while initiating bomMaterials');
        }
    }

    public function AcceptBom($bomId)
    {
        try {
            // Check if BOM is still published
            if (count(PublishedBom::where('bom_id', $bomId)->get()) == 0) {
                return redirect()->to('supplier/published-boms');
            }
            // Get supplier's tags
            $supplierTags = [];
            foreach (SupplierTag::where('user_id', Auth::user()->id)->get() as $st) {
                $supplierTags[$st->tag_id] = $st;
            }
            // Get BOM
            $bom = Bom::findOrFail($bomId);
            // Get BOM's tags
            $bomTags = [];
            foreach (BomTag::where('bom_id', $bom->id)->get() as $bomTag) {
                // Get specific tag
                $tag = Tag::findOrFail($bomTag->tag_id);
                if ($tag) {
                    $bomTags[$tag->id] = $tag;
                }
            }
            // Check if BOM's tags is same with supplier's tags
            foreach ($bomTags as $tag) {
                if (array_key_exists($tag->id, $supplierTags)) {
                    // Proceed to add data in supplier_bom_statuses table
                    $acceptResult = SupplierBomStatus::create([
                        'bom_id' => $bom->id,
                        'user_id' => Auth::user()->id,
                        'status' => 'accepted',
                    ]);
                    $createQuotationResult = Quotation::create([
                        'bom_id' => $bom->id,
                        'user_id' => Auth::user()->id,
                    ]);
                    if ($acceptResult && $createQuotationResult) {
                        return redirect()->to('/supplier/create-quotation');
                    }
                } else {
                    throw new Exception('BOM does not use the same tag(s) as you');
                }
            }
            toastr()->success('You accepted the Bill of Material succesfully.', [
                'positionClass' => 'toast-bottom-right',
            ]);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function DeclineBom($bomId)
    {
        // Check if BOM is still published
        if (count(PublishedBom::where('bom_id', $bomId)->get()) == 0) {
            return redirect()->to('supplier/published-boms');
        }
        // Find BOM
        $bom = Bom::findOrFail($bomId);
        // Decline BOM
        $declineResult = SupplierBomStatus::create([
            'bom_id' => $bom->id,
            'user_id' => Auth::user()->id,
            'status' => 'declined',
        ]);
        // Send notif
        $this->SendNotification($bom);
        toastr()->success('The bill of materials has been declined.', [
            'positionClass' => 'toast-bottom-right',
        ]);

        if ($declineResult) {
            return redirect()->to('/supplier/published-boms');
        }
        
    }

    private function SendNotification($bom)
    {
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
            'title' => 'BOM Declined',
            'message' => ' declined Bill of Materials #' . $bom->id . ' (' . $bom->subject . ')',
            'url' => '/admin/draft-boms',
            'recipients' => $recipients,
        ]);
    }
}
