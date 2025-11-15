<?php

namespace App\Livewire\Admin\Components\SubmittedQuotations;

use App\Models\Bom;
use App\Models\Quotation;
use App\Models\SubmittedQuotation;
use Livewire\Component;

class ViewQuotations extends Component
{
    public $selectedBom;

    public $submittedQuotations = [];

    protected $listeners = [
        'BomSelected', 'ChangeOrderBy', 'QuotationAccepted',
    ];

    public function render()
    {
        return view('livewire.admin.components.submitted-quotations.view-quotations');
    }

    public function mount() {
        $this->reset('submittedQuotations');
        if (!empty($this->selectedBom)) {
            foreach (Quotation::orderBy('total_price', 'asc')->get() as $quotation) {
                if (SubmittedQuotation::where('quotation_id', $quotation->id)->count() > 0 && $quotation->bom_id == $this->selectedBom['id']) {
                    array_push($this->submittedQuotations, $quotation);
                }
            }
        }
    }

    public function BomSelected($bomId) {
        $this->reset('submittedQuotations');
        $this->selectedBom = empty($bomId) ? null : Bom::findOrFail($bomId);
        $this->mount();
    }

    public function ChangeOrderBy($order) {
        if (!empty($this->selectedBom)) {
            $this->reset('submittedQuotations');
            if ($order == 'asc') {
                foreach (Quotation::orderBy('total_price', 'asc')->get() as $quotation) {
                    if (SubmittedQuotation::where('quotation_id', $quotation->id)->count() > 0 && $quotation->bom_id == $this->selectedBom['id']) {
                        array_push($this->submittedQuotations, $quotation);
                    }
                }
            } else if ($order == 'desc') {
                foreach (Quotation::orderBy('total_price', 'desc')->get() as $quotation) {
                    if (SubmittedQuotation::where('quotation_id', $quotation->id)->count() > 0 && $quotation->bom_id == $this->selectedBom['id']) {
                        array_push($this->submittedQuotations, $quotation);
                    }
                }
            }
            $this->dispatch('OrderChanged');
        }
    }
}
