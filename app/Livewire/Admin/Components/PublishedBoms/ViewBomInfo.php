<?php

namespace App\Livewire\Admin\Components\PublishedBoms;

use App\Models\Bom;
use Livewire\Component;

class ViewBomInfo extends Component
{
    public $bom;

    public function render()
    {
        return view('livewire.admin.components.published-boms.view-bom-info');
    }
}
