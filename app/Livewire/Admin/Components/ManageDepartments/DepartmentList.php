<?php

namespace App\Livewire\Admin\Components\ManageDepartments;

use App\Models\Bom;
use App\Models\BomDepartment;
use App\Models\BomMaterialCategory;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentList extends Component
{
    use WithPagination;

    protected $listeners = [
        'DepartmentAdded' => 'mount', 'DepartmentDeleted', 'DepartmentNameUpdated'
    ];

    public $searchedDepartment;

    public function render()
    {
        if (empty($this->searchedDepartment)) {
            $departments = BomDepartment::paginate(10);
            return view('livewire.admin.components.manage-departments.department-list', [
                'departments' => $departments
            ]);
        } else {
            $departments = BomDepartment::where('name', 'like', '%' . $this->searchedDepartment . '%')->paginate(10);
            return view('livewire.admin.components.manage-departments.department-list', [
                'departments' => $departments
            ]);
        }
    }

    public function SearchDepartment()
    {
        $this->resetPage();
    }

    public function ResetSearch()
    {
        $this->reset('searchedDepartment');
        $this->resetPage();
    }

    public function DeleteDepartment($id)
    {
        try {
            $department = BomDepartment::findOrFail($id);
            $result = BomDepartment::destroy($department->id);
            if ($result) {
                // Recipients
                $recipients = [];
                foreach (User::where('user_type', 'superadmin')->get() as $user) {
                    if ($user->id != Auth::user()->id) {
                        array_push($recipients, $user->id);
                    }
                }
                array_push($recipients, Auth::user()->id);
                // Notification
                $this->dispatch('CreateNotif', [
                    'title' => 'BOM Department Deleted',
                    'message' => ' deleted the department "' . $department->name . '"',
                    'url' => '/admin/manage-departments',
                    'recipients' => $recipients,
                ]);
                // Message Notif
                $this->dispatch('UpdateMessageNotif', [
                    'message' => ' You deleted the department "'.$department->name.'"',
                    'color' => 'success',
                ]);
                $this->dispatch('DepartmentDeleted');
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }
}
