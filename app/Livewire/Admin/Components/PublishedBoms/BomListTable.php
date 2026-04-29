<?php

namespace App\Livewire\Admin\Components\PublishedBoms;

use App\Models\Bom;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BomListTable extends Component
{
    use WithPagination;

    public $searchedBom, $orderBy;

    public function render()
    {
        if (empty($this->searchedBom)) {
            $publishedBoms = 
            empty($this->orderBy) ? Bom::where('status', 'published')->orWhere('status', 'closed')->paginate(10) 
            : Bom::where('status', 'published')->orWhere('status', 'closed')->orderBy($this->orderBy, 'asc')->paginate(10);
            return view('livewire.admin.components.published-boms.bom-list-table', [
                'publishedBoms' => $publishedBoms
            ]);
        } else {
            $publishedBoms = 
            empty($this->orderBy) ? Bom::where('subject', 'like', '%' . $this->searchedBom . '%')->whereIn('status', ['published', 'closed'])->paginate(10)
            : Bom::where('subject', 'like', '%' . $this->searchedBom . '%')->whereIn('status', ['published', 'closed'])->orderBy($this->orderBy, 'asc')->paginate(10);
            return view('livewire.admin.components.published-boms.bom-list-table', [
                'publishedBoms' => $publishedBoms
            ]);
        }
    }

    public function SearchBom()
    {
        $this->resetPage();
    }

    public function ResetSearch()
    {
        $this->reset('searchedBom');
    }

    public function OrderBy($col) {
        $this->orderBy = $col;
        $this->resetPage();
    }
}
