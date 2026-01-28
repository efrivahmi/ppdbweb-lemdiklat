<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Berita;
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
    public $kategoriFilter = '';
    public $statusFilter = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $title, $content, $kategori_id, $thumbnail, $new_thumbnail, $is_active = true;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:beritas,title' . ($this->editMode ? ',' . $this->selectedId : ''),
            'content' => 'required|string',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'new_thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean',
        ];
    }

    protected $messages = [
        'title.required' => 'Judul berita wajib diisi',
        'title.max' => 'Judul berita maksimal 255 karakter',
        'title.unique' => 'Judul berita sudah ada',
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
        $this->reset(['title', 'content', 'kategori_id', 'thumbnail', 'new_thumbnail', 'is_active', 'editMode', 'selectedId']);
        $this->is_active = true;
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
        $this->content = $berita->content;
        $this->kategori_id = $berita->kategori_id;
        $this->thumbnail = $berita->thumbnail;
        $this->is_active = $berita->is_active;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate($this->rules());

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'kategori_id' => $this->kategori_id,
            'is_active' => $this->is_active,
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

    public function deleteThumbnail($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            
            $berita->update(['thumbnail' => null]);
            $this->dispatch("alert", message: "Berhasil menghapus thumbnail", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus thumbnail", type: "error");
        }
    }

    // Filter methods
    public function updateSearch($data)
    {
        $this->search = $data['search'] ?? '';
        $this->resetPage();
    }

    public function updateFilter($data)
    {
        $this->search = $data['search'] ?? $this->search;
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->kategoriFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedKategoriFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritas = Berita::with(['kategori', 'creator'])
            ->where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->kategoriFilter, function ($query) {
                $query->where('kategori_id', $this->kategoriFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
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