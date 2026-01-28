<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Prestasi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Prestasi")]
class PrestasiPage extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $title, $description, $image, $new_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'new_image' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'title.required' => 'Judul prestasi wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'description.required' => 'Deskripsi prestasi wajib diisi',
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 2MB',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'filter-changed' => 'updateFilter',
        'search-cleared' => 'clearSearch',
        'filters-reset' => 'resetFilters',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'prestasi-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'prestasi-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'image', 'new_image', 'editMode', 'selectedId']);
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
        $prestasi = Prestasi::findOrFail($id);
        $this->selectedId = $id;
        $this->title = $prestasi->title;
        $this->description = $prestasi->description;
        $this->image = $prestasi->image;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        // Handle image upload
        if ($this->new_image) {
            $imagePath = $this->new_image->store('prestasi', 'public');
            $data['image'] = $imagePath;
        }

        if ($this->editMode) {
            $prestasi = Prestasi::findOrFail($this->selectedId);
            
            // Delete old image if new image uploaded
            if ($this->new_image && $prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
                Storage::disk('public')->delete($prestasi->image);
            } elseif (!$this->new_image && $prestasi->image) {
                // Keep existing image if no new image uploaded
                $data['image'] = $prestasi->image;
            }
            
            $prestasi->update($data);
            $message = 'Prestasi berhasil diperbarui';
        } else {
            Prestasi::create($data);
            $message = 'Prestasi berhasil ditambahkan';
        }

        $this->new_image = null;
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $prestasi = Prestasi::findOrFail($id);
            
            // Delete image file
            if ($prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
                Storage::disk('public')->delete($prestasi->image);
            }
            
            $prestasi->delete();
            $this->dispatch("alert", message: "Prestasi berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat mengapus prestasi", type: "success");
        }
    }

    public function deleteImage($id)
    {
        try {
            $prestasi = Prestasi::findOrFail($id);
            
            if ($prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
                Storage::disk('public')->delete($prestasi->image);
            }
            
            $prestasi->update(['image' => null]);
            $this->dispatch("alert", message: "Gambar berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gambar gagal di hapus", type: "error");
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
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prestasis = Prestasi::where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.landing.prestasi-page', ['prestasis' => $prestasis]);
    }
}