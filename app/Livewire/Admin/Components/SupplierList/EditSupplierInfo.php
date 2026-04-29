<?php

namespace App\Livewire\Admin\Components\SupplierList;

use App\Models\SupplierAddress;
use App\Models\SupplierContactNumber;
use App\Models\SupplierContactPerson;
use App\Models\SupplierPersonPosition;
use Livewire\Component;

class EditSupplierInfo extends Component
{

    public $supplier;

    public $supplierAddress;

    public $primaryName, $primaryPosition, $primaryContact;
    public $secondaryName, $secondaryPosition, $secondaryContact;

    public function render()
    {
        return view('livewire.admin.components.supplier-list.edit-supplier-info');
    }

    public function mount() {
        $this->supplierAddress = SupplierAddress::where('user_id', $this->supplier->id)->firstOrFail();
        // Primary Contact Person
        $this->primaryName = SupplierContactPerson::where('user_id', $this->supplier->id)->where('level', 'primary')->firstOrFail();
        $this->primaryPosition = SupplierPersonPosition::where('contact_person_id', $this->primaryName->id)->firstOrFail();
        $this->primaryContact = SupplierContactNumber::where('contact_person_id', $this->primaryName->id)->firstOrFail();
        // Secondary Contact Person
        $this->secondaryName = SupplierContactPerson::where('user_id', $this->supplier->id)->where('level', 'secondary')->firstOrFail();
        $this->secondaryPosition = SupplierPersonPosition::where('contact_person_id', $this->secondaryName->id)->firstOrFail();
        $this->secondaryContact = SupplierContactNumber::Where('contact_person_id', $this->secondaryName->id)->firstOrFail();

    }
}
