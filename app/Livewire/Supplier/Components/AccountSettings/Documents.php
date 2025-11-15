<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Supplier\Components\MessageToast;

class Documents extends Component
{
    use WithFileUploads;

    public $title, $documents, $file, $project_name = "DELETE";

    protected $rules = [
        'title' => 'required',
        'file' => 'required|mimes:pdf|max:10240',
    ];

    public function render()
    {
        $this->documents = Document::where('user_id', Auth::user()->id)->get();
        return view('livewire.supplier.components.account-settings.documents');
    }

    public function submit()
    {
        $this->validate();

        $userId = Auth::id();
        $filePath = 'documents';
        $filename = 'document_' . $userId . '.' . $this->file->getClientOriginalExtension();
        $this->file->storeAs($filePath, $filename);

        Document::create([
            'title' => $this->title,
            'file_name' => $filename,
            'original_filename' => $this->file->getClientOriginalName(),
            'user_id' => Auth::user()->id,
            'file_url' => $filePath . '/' . $filename,
        ]);

        $this->reset(['title', 'file']);
        // $this->dispatch('UpdateMessageToastr', [
        //     'message' => 'File has been successfully uploaded.',
        //     'color' => 'success'
        // ]);

        toastr()->success('File has been uploaded successfully.', 
        [
            'positionClass' => 'toast-bottom-right',
        ]); 
    }

    public function deleteDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        $filePath = 'documents' . $document->file_name;

        Storage::delete($filePath);
        $document->delete();

        // $this->dispatch('UpdateMessageToastr', [
        //     'message' => 'Document "' . $document->original_filename . '" has been deleted successfully.',
        //     'color' => 'success'
        // ]);

        toastr()->success('Document "' . $document->original_filename . '" has been deleted successfully.', 
        [
            'positionClass' => 'toast-bottom-right',
        ]); 
    }

    public function downloadDocument($documentId)
    {
        
        $document = Document::findOrFail($documentId);
        $filePath = 'documents' . $document->file_name;
        
        // $this->dispatch('UpdateMessageToastr', [
        //     'message' => 'Document "' . $document->original_filename . '" has been downloaded successfully.',
        //     'color' => 'success'
        // ]);
        
        return Storage::download($filePath, $document->original_filename);
        
    }
}
