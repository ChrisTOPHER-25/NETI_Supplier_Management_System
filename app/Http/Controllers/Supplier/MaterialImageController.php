<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use App\Models\QuotationMaterialImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialImageController extends Controller
{
    public function show(Request $request) {
        // Get material image
        $materialImage = QuotationMaterialImage::where('file_name', $request->materialImageFileName)->firstOrFail();
        // Get material
        $material = QuotationMaterial::findOrFail($materialImage->material_id);
        // Get quotation
        $quotation = Quotation::findOrFail($material->quotation_id);
        // Get supplier who owns the quotation
        $supplier = User::findOrFail($quotation->user_id);
        // Proceed if user is the owner of the request profile picture
        if ($supplier->id == Auth::user()->id || Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'superadmin') {
            $path = storage_path("app/quotation-material-images/{$request->materialImageFileName}");
            if (!Storage::exists("quotation-material-images/{$request->materialImageFileName}")) {
                abort(404);
            }
            return response()->file($path);
        // Otherwise, block user
        } else {
            abort(401);
        }
    }
}
