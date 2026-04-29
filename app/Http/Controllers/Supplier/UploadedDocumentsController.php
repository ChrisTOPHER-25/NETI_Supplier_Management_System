<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadedDocumentsController extends Controller
{
    public function download(Request $request, $fileName)
    {
        $document = Document::where('file_name', $fileName)->firstOrFail();

        if ($document->user_id != Auth::id()) {
            abort(404);
        }

        return response()->download(storage_path('app/documents/' . $document->file_name), $document->original_filename);
    }

    public function show(Request $request, $fileName)
    {
        $document = Document::where('file_name', $fileName)->firstOrFail();
    
        if ($document->user_id != Auth::id()) {
            abort(401);
        }

        $path = storage_path('app/documents/' . $document->file_name);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
