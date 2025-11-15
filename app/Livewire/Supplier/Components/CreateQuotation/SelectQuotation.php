<?php

namespace App\Livewire\Supplier\Components\CreateQuotation;

use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectQuotation extends Component
{

    public $quotations = [];

    public $selectedBomId;

    protected $listeners = [
        'CloseBom',
    ];

    public function render()
    {
        return view('livewire.supplier.components.create-quotation.select-quotation');
    }

    public function mount() {
        $this->quotations = Quotation::where('user_id', Auth::user()->id)->get();
    }

    public function SelectBom($bomId) {
        $this->dispatch('BomSelected', $bomId);
        $this->selectedBomId = $bomId;
    }

    public function CloseBom() {
        $this->reset('selectedBomId');
    }
}
