<?php

namespace App\Livewire\Admin\Components\SubmittedQuotations;

use App\Models\QuotationMaterial;
use Exception;
use Livewire\Component;

class ViewMaterialInfo extends Component
{
    public $materialId, $material;

    protected $listeners = [
        'QuotationAccepted',
    ];

    public function render()
    {
        return view('livewire.admin.components.submitted-quotations.view-material-info');
    }

    public function mount() {
        if (!empty($this->materialId)) {
            $this->material = QuotationMaterial::findOrFail($this->materialId);
        }
    }

    public function CloseMaterialInfo() {        
        $this->dispatch('CloseMaterialInfo');
        $this->reset();
    }
}
