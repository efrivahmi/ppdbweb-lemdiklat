<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Fasilitas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Fasilitas")]
class FasilitasPage extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $statusFilter = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $name, $description, $image, $new_image, $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'new_image' => 'nullable|image|max:2048',
        'is_active' => 'required|boolean',
    ];

    protected $messages = [
        'name.required' => 'Nama fasilitas wajib diisi',
        'name.max' => 'Nama maksimal 255 karakter',
        'description.required' => 'Deskripsi fasilitas wajib diisi',
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
        $this->dispatch('open-modal', name: 'fasilitas-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'fasilitas-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'image', 'new_image', 'is_active', 'editMode', 'selectedId']);
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
        $fasilitas = Fasilitas::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $fasilitas->name;
        $this->description = $fasilitas->description;
        $this->image = $fasilitas->image;
        $this->is_active = $fasilitas->is_active;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        // Handle image upload
        if ($this->new_image) {
            $imagePath = $this->new_image->store('fasilitas', 'public');
            $data['image'] = $imagePath;
        }

        if ($this->editMode) {
            $fasilitas = Fasilitas::findOrFail($this->selectedId);
            
            // Delete old image if new image uploaded
            if ($this->new_image && $fasilitas->image && Storage::disk('public')->exists($fasilitas->image)) {
                Storage::disk('public')->delete($fasilitas->image);
            } elseif (!$this->new_image && $fasilitas->image) {
                // Keep existing image if no new image uploaded
                $data['image'] = $fasilitas->image;
            }
            
            $fasilitas->update($data);
            $message = 'Fasilitas berhasil diperbarui';
        } else {
            Fasilitas::create($data);
            $message = 'Fasilitas berhasil ditambahkan';
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

    public function toggleStatus($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update(['is_active' => !$fasilitas->is_active]);
        
        $status = $fasilitas->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch("alert", message: "Fasilitas " . $status, type: "success");
    }

    public function delete($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);
            
            // Delete image file
            if ($fasilitas->image && Storage::disk('public')->exists($fasilitas->image)) {
                Storage::disk('public')->delete($fasilitas->image);
            }
            
            $fasilitas->delete();
            $this->dispatch("alert", message: "Fasilitas berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Fasilitas gagal di hapus", type: "error");
        }
    }

    public function deleteImage($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);
            
            if ($fasilitas->image && Storage::disk('public')->exists($fasilitas->image)) {
                Storage::disk('public')->delete($fasilitas->image);
            }
            
            $fasilitas->update(['image' => null]);
            $this->dispatch("alert", message: "Gambar berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus gambar.", type: "error");
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
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $fasilitas = Fasilitas::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.landing.fasilitas-page', ['fasilitas' => $fasilitas]);
    }
}