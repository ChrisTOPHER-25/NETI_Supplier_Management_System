<?php

namespace App\Livewire\Supplier\Components\CreateQuotation;

use App\Models\Bom;
use App\Models\BomMaterialCategory;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use App\Models\QuotationMaterialImage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddMaterialForm extends Component
{
    use WithFileUploads;

    public $selectedBomId, $bom;

    public $category, $name, $brand, $quantity, $price, $description;

    public $images = [];

    public $categorySelected = false, $showingBrand = false, $currentUnit;

    protected function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'images.*' => ['required', 'image'],
            'quantity' => ['required', 'regex:/^[0-9.]+$/'],
        ];
    }

    protected $listeners = [
        'UpdateAddMaterialForm' => 'BomSelected', 'QuotationPublished'
    ];

    public function render()
    {
        return view('livewire.supplier.components.create-quotation.add-material-form');
    }

    public function mount()
    {
        $this->bom = Bom::findOrFail($this->selectedBomId);
    }

    public function ShowBrandOrKilo()
    {
        $this->reset('name', 'brand', 'currentUnit', 'quantity', 'price');
        if (empty($this->category)) {
            $this->showingBrand = false;
            $this->categorySelected = false;
        } else {
            $this->categorySelected = true;
            $this->currentUnit = BomMaterialCategory::findOrFail($this->category)->unit;
            $this->showingBrand = BomMaterialCategory::findOrFail($this->category)->uses_brand ? true : false;
        }
    }

    public function AddMaterial()
    {
        $this->validate();
        try {
            $this->ValidateBrandImages();
            if (!empty($this->bom)) {
                // Find bom
                $bom = Bom::findOrFail($this->bom->id);
                // Find quotation
                $quotation = Quotation::where('bom_id', $bom->id)->where('user_id', Auth::user()->id)->first();
                if ($bom && $quotation) {
                    $materialCreated = false;
                    // Add quotation material
                    $createMaterialResult = QuotationMaterial::create([
                        'quantity' => $this->quantity,
                        'name' => $this->name,
                        'brand' => empty($this->brand) ? null : $this->brand,
                        'unit' => $this->currentUnit,
                        'description' => $this->description,
                        'unit_price' => $this->price,
                        'category_id' => $this->category,
                        'quotation_id' => $quotation->id,
                    ]);
                    if ($createMaterialResult) {
                        // Loop through uploaded images
                        for ($i = 0; $i < count($this->images); $i++) {
                            // Store image
                            $filePath = 'quotation-material-images';
                            $fileName = 'material'.$i.'_' . $createMaterialResult->id . '.' . $this->images[$i]->getClientOriginalExtension();
                            $fileStoreResult = $this->images[$i]->storeAs(path: $filePath, name: $fileName);
                            // Create material image data
                            $imageCreateResult = QuotationMaterialImage::create([
                                'material_id' => $createMaterialResult->id,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                    // Update total price
                    if ($createMaterialResult) {
                        $quotation->total_price += ($createMaterialResult->unit_price * $createMaterialResult->quantity);
                        $saveResult = $quotation->save();
                        if ($saveResult) $materialCreated = true;
                    }
                    if ($materialCreated) {
                        $this->reset('name', 'brand', 'currentUnit', 'quantity', 'price', 'description', 'category', 'categorySelected');
                        unset($this->images);
                        $this->dispatch('MaterialAdded');
                    }
                }
            }
            toastr()->success('The material has been added successfully.', [
                'positionClass' => 'toast-bottom-right',
            ]);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    private function ValidateBrandImages()
    {
        if ($this->showingBrand) {
            if (empty($this->brand)) {
                $this->addError('brand', 'No brand');
            }
        }
        if (count($this->images) > 3) {
            $this->adderror('images.*', 'You can only upload up to three images');
        }
    }
}
