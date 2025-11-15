<?php

namespace App\Livewire\Admin\Components\SupplierList;

use App\Models\NewAccount;
use App\Models\SupplierAddress;
use App\Models\SupplierContactNumber;
use App\Models\SupplierContactPerson;
use App\Models\SupplierPersonPosition;
use App\Models\User;
use App\Rules\noEmoji;
use Livewire\Component;
use Exception;
use Illuminate\Validation\Rules\Password;

class AddSupplierForm extends Component
{
    public $name, $email, $password, $address;

    public $primaryCpName, $primaryCpPosition, $primaryCpContact;
    public $secondaryCpName, $secondaryCpPosition, $secondaryCpContact;

    protected function rules() {
        return [
            'name' => ['required', 'string', 'unique:users,name', new noEmoji()],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers(), new noEmoji()],
            'address' => ['required', 'string'],
            'primaryCpName' => ['required', 'string', new noEmoji()],
            'primaryCpPosition' => ['required', 'string', new noEmoji()],
            'primaryCpContact' => ['required', 'string'],
            'secondaryCpName' => ['required', 'string', new noEmoji()],
            'secondaryCpPosition' => ['required', 'string', new noEmoji()],
            'secondaryCpContact' => ['required', 'string'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.components.supplier-list.add-supplier-form');
    }

    public function AddSupplier() {
        $this->validate();
        try {
            // Create supplier
            $supplierCreateResult = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]);
            // Create address
            $addressCreateResult = SupplierAddress::create([
                'address' => $this->address,
                'user_id' => $supplierCreateResult->id,
            ]);
            // Create primary contact person
            $primaryCpCreateResult = SupplierContactPerson::create([
                'name' => $this->primaryCpName,
                'level' => 'primary',
                'user_id' => $supplierCreateResult->id,
            ]);
            // Create primary contact person position
            $primaryCpPositionCreateResult = SupplierPersonPosition::create([
                'position' => $this->primaryCpPosition,
                'contact_person_id' => $primaryCpCreateResult->id,
            ]);
            // Create primary contact person contact
            $primaryCpContactCreateResult = SupplierContactNumber::create([
                'contact' => $this->primaryCpContact,
                'contact_person_id' => $primaryCpCreateResult->id,
            ]);
            // Create secondary contact person
            $secondaryCpCreateResult = SupplierContactPerson::create([
                'name' => $this->secondaryCpName,
                'level' => 'secondary',
                'user_id' => $supplierCreateResult->id,
            ]);
            // Create secondary contact person positon
            $secondaryCpPositionCreateResult = SupplierPersonPosition::create([
                'position' => $this->secondaryCpPosition,
                'contact_person_id' => $secondaryCpCreateResult->id,
            ]);
            // Create secondary contact person contact
            $secondaryCpContactCreateResult = SupplierContactNumber::create([
                'contact' => $this->secondaryCpContact,
                'contact_person_id' => $secondaryCpCreateResult->id,
            ]);
            if ($supplierCreateResult && $addressCreateResult && 
            $primaryCpCreateResult && $primaryCpPositionCreateResult && $primaryCpContactCreateResult &&
            $secondaryCpCreateResult && $secondaryCpPositionCreateResult && $secondaryCpContactCreateResult) {
                // Add account to new_accounts table
                $addToNewAccounts = NewAccount::create([
                    'user_id' => $supplierCreateResult->id,
                ]);
                if ($addToNewAccounts) {
                    $msgData = [
                        'message' => 'You added a new supplier ('.$this->name.')',
                        'color' => 'success',
                    ];
                    $this->dispatch('UpdateMessageNotif', $msgData);
                    $this->dispatch('SupplierAdded');
                    $this->reset();
                }
            }
        } catch (Exception $ex) {
            $msgData = [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ];
            $this->dispatch('UpdateMessageNotif', $msgData);
        }
    }


}
