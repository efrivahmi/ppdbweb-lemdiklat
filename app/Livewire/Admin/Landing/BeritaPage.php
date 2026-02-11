<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Berita;
use App\Models\Landing\BeritaComment;
use App\Models\Landing\KategoriBerita;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Berita")]
class BeritaPage extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $filterKategori = '';
    public $filterStatus = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $title, $description, $content, $kategori_id, $thumbnail, $new_thumbnail;
    public $is_active = true;
    public $is_priority = false;

    // Comment moderation
    public $showComments = null;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:beritas,title' . ($this->editMode ? ',' . $this->selectedId : ''),
            'description' => 'nullable|string|max:500',
            'content' => 'required|string',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'new_thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean',
            'is_priority' => 'boolean',
        ];
    }

    protected $messages = [
        'title.required' => 'Judul berita wajib diisi',
        'title.max' => 'Judul berita maksimal 255 karakter',
        'title.unique' => 'Judul berita sudah ada',
        'description.max' => 'Deskripsi singkat maksimal 500 karakter',
        'content.required' => 'Konten berita wajib diisi',
        'kategori_id.required' => 'Kategori berita wajib dipilih',
        'kategori_id.exists' => 'Kategori berita tidak valid',
        'new_thumbnail.image' => 'File harus berupa gambar',
        'new_thumbnail.max' => 'Ukuran gambar maksimal 2MB',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'filter-changed' => 'updateFilter',
        'search-cleared' => 'clearSearch',
        'filters-reset' => 'resetFilters',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'berita-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'berita-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'content', 'kategori_id', 'thumbnail', 'new_thumbnail', 'is_active', 'is_priority', 'editMode', 'selectedId']);
        $this->is_active = true;
        // is_priority default false is already handled by reset
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $this->selectedId = $id;
        $this->title = $berita->title;
        $this->description = $berita->description;
        $this->content = $berita->content;
        $this->kategori_id = $berita->kategori_id;
        $this->thumbnail = $berita->thumbnail;
        $this->is_active = $berita->is_active;
        $this->is_priority = $berita->is_priority;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate($this->rules());

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'kategori_id' => $this->kategori_id,
            'is_active' => $this->is_active,
            'is_priority' => $this->is_priority,
        ];

        // Handle thumbnail upload
        if ($this->new_thumbnail) {
            $thumbnailPath = $this->new_thumbnail->store('berita', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        if ($this->editMode) {
            $berita = Berita::findOrFail($this->selectedId);
            
            // Delete old thumbnail if new thumbnail uploaded
            if ($this->new_thumbnail && $berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            } elseif (!$this->new_thumbnail && $berita->thumbnail) {
                // Keep existing thumbnail if no new thumbnail uploaded
                $data['thumbnail'] = $berita->thumbnail;
            }
            
            $berita->update($data);
            $message = 'Berita berhasil diperbarui';
        } else {
            Berita::create($data);
            $message = 'Berita berhasil ditambahkan';
        }

        $this->new_thumbnail = null;
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
    }

    public function toggleStatus($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->update(['is_active' => !$berita->is_active]);
        
        $status = $berita->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch("alert", message: "Berita ". $status, type: "success");
    }

    public function delete($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            // Delete thumbnail file
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            
            $berita->delete();
            $this->dispatch("alert", message: "Berhasil berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus berita", type: "error");
        }
    }

    // Comment moderation
    public function toggleComments($id)
    {
        $this->showComments = $this->showComments === $id ? null : $id;
    }

    public function approveComment($commentId)
    {
        $comment = BeritaComment::findOrFail($commentId);
        $comment->update(['is_approved' => true]);
        $this->dispatch("alert", message: "Komentar disetujui", type: "success");
    }

    public function deleteComment($commentId)
    {
        BeritaComment::findOrFail($commentId)->delete();
        $this->dispatch("alert", message: "Komentar dihapus", type: "success");
    }

    // Filter methods
    public function updateSearch($data)
    {
        $this->search = $data['search'] ?? '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterKategori()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritas = Berita::with(['kategori', 'creator'])
            ->withCount('comments')
            ->where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterKategori, function ($query) {
                $query->where('kategori_id', $this->filterKategori);
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus === 'active');
            })
            ->latest()
            ->paginate(10);

        $kategoris = KategoriBerita::where('is_active', true)->get();
            
        return view('livewire.admin.landing.berita-page', [
            'beritas' => $beritas,
            'kategoris' => $kategoris,
            'allKategoris' => KategoriBerita::all()
        ]);
    }
}