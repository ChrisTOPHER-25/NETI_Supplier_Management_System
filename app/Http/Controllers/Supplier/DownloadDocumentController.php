<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DownloadDocumentController extends Controller
{
    //
    public function download(Document $documentFile)
    {
        $filePath = 'public/documents/' . $documentFile->file_name;

        return Storage::download($filePath, $documentFile->original_filename);
    }

    
}
