<?php

namespace App\Livewire\Admin\Components\ManageBom;

use App\Models\BomTag;
use App\Models\Tag;
use App\Models\Bom;
use App\Models\BomMaterial;
use App\Models\PublishedBom;
use App\Models\SupplierTag;
use App\Models\User;
use Livewire\Component;
use Exception;
use Illuminate\Support\Facades\Auth;

class PublishBomForm extends Component
{
    public $listeners = [
        'BomSelected', 'TagAdded', 'TagRemoved', 'UpdatedBomTitleCategory' => 'BomSelected',
        'UpdatePublishForm' => 'BomSelected', 'MaterialRemoved'
    ];


    public $selectedBom, $bomTags = [];

    public function render()
    {
        return view('livewire.admin.components.manage-bom.publish-bom-form');
    }

    public function mount()
    {
        try {
            if (empty($this->selectedBom) == false) {
                $this->reset('bomTags');
                // Get BOM's tags
                foreach (BomTag::where('bom_id', $this->selectedBom['id'])->get() as $bomTag) {
                    // Get tag
                    $tag = Tag::where('id', $bomTag->tag_id)->firstOrFail();
                    if (empty($tag) == false) {
                        $this->bomTags[$tag->id] = $tag;
                    }
                }
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }

    public function Publish()
    {
        try {
            // Throw error if BOM has no tag(s)
            if (BomTag::where('bom_id', $this->selectedBom['id'])->count() == 0 || BomMaterial::where('bom_id', $this->selectedBom['id'])->count() == 0) {
                throw new Exception('BOMs must contain materials before they can be published');
            }
            // Find BOM to publish
            $bom = Bom::where('id', $this->selectedBom['id'])->firstOrFail();
            if (empty($bom) == false) {
                // Update BOM status
                $bom->status = 'published';
                $saveResult = $bom->save();
                if ($saveResult) {
                    // Add BOM to published_boms
                    if (PublishedBom::where('bom_id', $bom->id)->count() == 0) {
                        $dbResult = PublishedBom::create([
                            'bom_id' => $bom->id,
                        ]);
                        if ($dbResult) {
                            $this->dispatch('BomPublished', $bom);
                            $this->dispatch('UpdateMessageNotif', [
                                'message' => 'You published Bill of Materials #' . $this->selectedBom['id'] . ' (' . $this->selectedBom['subject'] . ')',
                                'color' => 'success',
                            ]);
                            // Recipients
                            $recipients = [];
                            foreach (BomTag::where('bom_id', $bom->id)->get() as $bomTag) {
                                // Push notif to suppliers
                                foreach (SupplierTag::where('tag_id', $bomTag->tag_id)->get() as $supplierTag) {
                                    array_push($recipients, $supplierTag->user_id);
                                }
                            }
                            // Push notif to superadmins
                            foreach (User::where('user_type', 'superadmin')->get() as $user) {
                                if  ($user->id != Auth::user()->id) {
                                    array_push($recipients, $user->id);
                                }
                            }
                            array_push($recipients, Auth::user()->id);
                            // Notification
                            $this->dispatch('CreateNotif', [
                                'title' => 'BOM Published',
                                'message' => ' published Bill of Materials #' . $bom->id .' ('.$bom->subject.')',
                                'url' => '/admin/published-boms',
                                'recipients' => $recipients,
                            ]);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->dispatch('UpdateMessageNotif', [
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }

    public function TagAdded()
    {
        $this->mount();
    }

    public function TagRemoved()
    {
        $this->mount();
    }

    public function BomSelected($bom)
    {
        $this->reset('selectedBom');
        $this->selectedBom = $bom;
        $this->mount();
    }
}
