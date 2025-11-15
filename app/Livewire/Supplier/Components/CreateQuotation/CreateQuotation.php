<?php

namespace App\Livewire\Supplier\Components\CreateQuotation;

use App\Models\Bom;
use App\Models\BomMaterial;
use App\Models\BomMaterialCategory;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use App\Models\QuotationMaterialImage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CreateQuotation extends Component
{

    public $selectedBomId, $bom, $quotation;

    protected $listeners = [
        'BomSelected', 'MaterialAdded', 'MaterialRemoved', 'QuotationPublished'
    ];

    public function render()
    {
        return view('livewire.supplier.components.create-quotation.create-quotation');
    }

    public function BomSelected($bomId)
    {
        $this->selectedBomId = $bomId;
        $this->bom = Bom::findOrFail($this->selectedBomId);
        $this->quotation = Quotation::where('bom_id', $this->bom->id)->where('user_id', Auth::user()->id)->first();
    }

    public function CloseBom()
    {
        $this->reset('selectedBomId', 'bom');
        $this->dispatch('CloseBom');
    }

    public function DeleteMaterial($id)
    {
        if (!empty($this->quotation)) {
            // Find material images
            foreach (QuotationMaterialImage::where('material_id', $id)->get() as $image) {
                // Delete image
                Storage::delete('quotation-material-images/' . $image->file_name);
            }

            // Find material
            $quotationMaterial = QuotationMaterial::findOrFail($id);
            // Deduct total price
            $this->quotation->total_price -= ($quotationMaterial->unit_price * $quotationMaterial->quantity);
            $result = $this->quotation->save();
            if ($result) {
                $destroyResult = QuotationMaterial::destroy($id);
                if ($destroyResult) {
                    $this->BomSelected($this->selectedBomId);
                    $this->dispatch('MaterialRemoved');
                }
            }
        }
        toastr()->success('Your quotation has been deleted successfully.', [
            'positionClass' => 'toast-bottom-right',
        ]);
        try {
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
