<?php

namespace App\Livewire\Supplier\Components\Boms;

use App\Models\Bom;
use App\Models\BomTag;
use App\Models\PublishedBom;
use App\Models\Quotation;
use App\Models\SubmittedQuotation;
use App\Models\SupplierTag;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PublishedBomsTable extends Component
{

    public $SubmittedQuotationStatuses = [];
    public $PublishedBoms = [];
    public $SupplierTags = [];

    public function render()
    {
        return view('livewire.supplier.components.boms.published-boms-table');
    }
    
    public function mount() {
        try {
            // Get supplier's tags
            foreach (SupplierTag::where('user_id', Auth::user()->id)->get() as $supplierTag) {
                // Get specific tag name
                $tag = Tag::findOrFail($supplierTag->tag_id);
                if (empty($tag) == false) {
                    $this->SupplierTags[$tag->id] = $tag;
                }
            }
            // Get published BOMs that uses supplier's tags
            $this->reset('PublishedBoms');
            foreach (PublishedBom::get() as $pb) {
                // Find BOM
                $bom = Bom::findOrFail($pb->bom_id);
                // Loop through BOM's tags
                foreach (BomTag::where('bom_id', $bom->id)->get() as $bomTag) {
                    // Loop through Supplier's tags
                    foreach ($this->SupplierTags as $tag) {
                        // Check if bom & supplier uses the same tag
                        if ($bomTag->tag_id == $tag->id) {
                            $this->PublishedBoms[$bom->id] = $bom;
                        }

                        // Check if BOM has a submitted quotation
                        $quotation = Quotation::where('bom_id', $bom->id)->where('user_id', Auth::user()->id)->first();
                        if ($quotation) {
                            // Check if quotation is submitted
                            $submittedQuotation = SubmittedQuotation::where('quotation_id', $quotation->id)->first();
                            if ($submittedQuotation) {
                                $this->SubmittedQuotationStatuses[$bom->id] = $submittedQuotation->status;
                            }
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            dd('Error while initiating PublishedBoms & SupplierTags');
        }
    }
}
