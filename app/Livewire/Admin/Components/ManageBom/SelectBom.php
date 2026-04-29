<?php

namespace App\Livewire\Admin\Components\ManageBom;

use Livewire\Component;
use App\Models\Bom;
use App\Models\PublishedBom;
use App\Models\SupplierBomStatus;
use Exception;

class SelectBom extends Component
{

    public $listeners = [
        'MaterialAdded', 'MaterialRemoved', 'BomPublished', 'BomUnpublished', 'UpdatedBomTitleCategory',
    ];

    public $bomId;

    public $selectedBom;

    public function render()
    {
        return view('livewire.admin.components.manage-bom.select-bom');
    }

    public function SelectBom()
    {
        if (empty($this->bomId) == false) {
            $result = Bom::findOrFail($this->bomId);
            if ($result) {
                $this->selectedBom = $result;
                // $this->dispatch('UpdateMessageNotif', [
                //     'message' => 'You opened Bill of Materials #' . $result->id . ' (' . $result->subject . ')',
                //     'color' => 'success',
                // ]);
                $this->dispatch('BomSelected', $this->selectedBom);
            }
        }
    }
}
