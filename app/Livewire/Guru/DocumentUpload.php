<?php

namespace App\Livewire\Guru;

use App\Models\GuruDocument;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.guru")]
#[Title("Upload Dokumen")]
class DocumentUpload extends Component
{
    use WithFileUploads;

    public $document_name;
    public $document_type;
    public $file;
    public $documents = [];

    protected $rules = [
        'document_name' => 'required|string|max:255',
        'document_type' => 'required|in:cv,sertifikat,surat_lamaran,ijazah,transkrip,lainnya',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
    ];

    public function mount()
    {
        $this->loadDocuments();
    }

    public function loadDocuments()
    {
        $this->documents = Auth::user()->guru_documents()->orderBy('created_at', 'desc')->get()->toArray();
    }

    public function upload()
    {
        $this->validate();

        $filePath = $this->file->store('guru-documents', 'public');

        GuruDocument::create([
            'guru_id' => auth()->id(),
            'document_name' => $this->document_name,
            'document_type' => $this->document_type,
            'file_path' => $filePath,
            'status' => 'pending'
        ]);

        session()->flash('success', 'Dokumen berhasil diupload!');

        $this->reset(['document_name', 'document_type', 'file']);
        $this->loadDocuments();
    }

    public function deleteDocument($id)
    {
        $document = GuruDocument::where('id', $id)
            ->where('guru_id', auth()->id())
            ->first();

        if ($document) {
            // Delete file from storage
            \Storage::disk('public')->delete($document->file_path);
            $document->delete();

            session()->flash('success', 'Dokumen berhasil dihapus!');
            $this->loadDocuments();
        }
    }

    public function render()
    {
        return view('livewire.guru.document-upload');
    }
}
