<?php

namespace App\Livewire\Admin\Components\ManageSupplierTags;

use App\Models\User;
use Livewire\Component;

class SupplierSearch extends Component
{
    public $selectedSupplierId;

    public $supplierList = [], $searchedSupplier;

    public function mount() {
        $this->supplierList = User::where('user_type', 'user')->get();
    }

    public function render()
    {
        return view('livewire.admin.components.manage-supplier-tags.supplier-search');
    }
    
    public function SelectSupplier($supplierId) {
        $this->selectedSupplierId = $supplierId;
        $this->dispatch('SupplierSelected', $supplierId);
    }

    public function SearchSupplier() {
        $this->supplierList = User::where('user_type', 'user')->where('name', 'like', '%'.$this->searchedSupplier.'%')->get();
    }

    public function ResetSearch() {
        $this->reset('searchedSupplier');
        $this->SearchSupplier();
    }
}
