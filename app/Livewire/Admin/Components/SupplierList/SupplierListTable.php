<?php

namespace App\Livewire\Admin\Components\SupplierList;

use App\Models\ArchivedAccount;
use App\Models\User;
use Livewire\Component;
use Exception;
use Livewire\WithPagination;

class SupplierListTable extends Component
{
    use WithPagination;

    protected $listeners = [
        'SupplierAdded' => 'mount', 'SupplierArchived', 'SupplierRestored',
    ];

    public $searchedSupplier;

    public function render()
    {
        if (empty($this->searchedSupplier)) {
            $suppliers = User::where('user_type', 'user')->paginate(10);
            return view('livewire.admin.components.supplier-list.supplier-list-table', [
                'suppliers' => $suppliers
            ]);
        } else {
            $suppliers = User::where('user_type', 'user')->where('name', 'like', '%' . $this->searchedSupplier . '%')->paginate(10);
            return view('livewire.admin.components.supplier-list.supplier-list-table', [
                'suppliers' => $suppliers
            ]);
        }
    }

    public function SearchSupplier()
    {
        $this->resetPage();
    }

    public function ResetSearch()
    {
        $this->reset('searchedSupplier');
        $this->resetPage();
    }

    public function ArchiveUser($id)
    {
        // Proceed if user_id is not yet archived
        if (count(ArchivedAccount::where('user_id', $id)->get()) == 0) {
            // Get supplier
            $supplier = User::findOrFail($id);
            // Create archived account data
            $result = ArchivedAccount::create([
                'user_id' => $supplier->id,
            ]);
            if ($result) {
                $this->ThrowMessageNotif('You successfully archived supplier "' . $supplier->name . '"', 'success');
                $this->dispatch('SupplierArchived');
            }
        }
        try {
        } catch (Exception $ex) {
            $this->ThrowMessageNotif($ex->getMessage(), 'danger');
        }
    }

    public function UnarchiveUser($id)
    {
        try {
            // Get supplier
            $supplier = User::findOrFail($id);
            // Proceed if user is archived
            $archivedUser = ArchivedAccount::where('user_id', $supplier->id)->first();
            if (empty($archivedUser) == false) {
                $result = ArchivedAccount::destroy($archivedUser->id);
                if ($result) {
                    $this->ThrowMessageNotif('You successfully restored supplier "'.$supplier->name.'"', 'success');
                    $this->dispatch('SupplierRestored');
                }
            }
        } catch (Exception $ex) {
            $this->ThrowMessageNotif($ex->getMessage(), 'danger');
        }
    }

    private function ThrowMessageNotif($message, $color)
    {
        $msgData = [
            'message' => $message,
            'color' => $color,
        ];
        $this->dispatch('UpdateMessageNotif', $msgData);
    }
}
