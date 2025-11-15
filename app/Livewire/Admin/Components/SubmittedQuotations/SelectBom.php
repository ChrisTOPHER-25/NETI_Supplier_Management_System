<?php

namespace App\Livewire\Admin\Components\SubmittedQuotations;

use Livewire\Component;

class SelectBom extends Component
{
    public $selectedBomId, $orderBy = 'asc';

    protected $listeners = [
        'QuotationAccepted',
    ];

    public function render()
    {
        return view('livewire.admin.components.submitted-quotations.select-bom');
    }

    public function ViewQuotations() {
        $this->dispatch('BomSelected', $this->selectedBomId);
    }

    public function ChangeOrderBy() {
        $this->dispatch('ChangeOrderBy', $this->orderBy);
    }
}
