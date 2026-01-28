<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Ekstrakurikuler;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Ekstrakurikuler")]
class EkstrakurikulerPage extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $title, $desc, $img, $new_img;

    protected $rules = [
        'title' => 'required|string|max:255',
        'desc' => 'required|string',
        'new_img' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'title.required' => 'Judul ekstrakurikuler wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'desc.required' => 'Deskripsi ekstrakurikuler wajib diisi',
        'new_img.image' => 'File harus berupa gambar',
        'new_img.max' => 'Ukuran gambar maksimal 2MB',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'search-cleared' => 'clearSearch',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'ekstrakurikuler-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'ekstrakurikuler-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['title', 'desc', 'img', 'new_img', 'editMode', 'selectedId']);
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
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $this->selectedId = $id;
        $this->title = $ekstrakurikuler->title;
        $this->desc = $ekstrakurikuler->desc;
        $this->img = $ekstrakurikuler->img;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'desc' => $this->desc,
        ];

        // Handle image upload
        if ($this->new_img) {
            $imagePath = $this->new_img->store('ekstrakurikuler', 'public');
            $data['img'] = $imagePath;
        }

        if ($this->editMode) {
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($this->selectedId);
            
            // Delete old image if new image uploaded
            if ($this->new_img && $ekstrakurikuler->img && Storage::disk('public')->exists($ekstrakurikuler->img)) {
                Storage::disk('public')->delete($ekstrakurikuler->img);
            } elseif (!$this->new_img && $ekstrakurikuler->img) {
                // Keep existing image if no new image uploaded
                $data['img'] = $ekstrakurikuler->img;
            }
            
            $ekstrakurikuler->update($data);
            $message = 'Ekstrakurikuler berhasil diperbarui';
        } else {
            Ekstrakurikuler::create($data);
            $message = 'Ekstrakurikuler berhasil ditambahkan';
        }

        $this->new_img = null;
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
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
            
            // Delete image file
            if ($ekstrakurikuler->img && Storage::disk('public')->exists($ekstrakurikuler->img)) {
                Storage::disk('public')->delete($ekstrakurikuler->img);
            }
            
            $ekstrakurikuler->delete();
            $this->dispatch("alert", message: "Ekstrakurikuler berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Ekstrakurikuler gagal dihapus", type: "error");
        }
    }

    public function deleteImage($id)
    {
        try {
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
            
            if ($ekstrakurikuler->img && Storage::disk('public')->exists($ekstrakurikuler->img)) {
                Storage::disk('public')->delete($ekstrakurikuler->img);
            }
            
            $ekstrakurikuler->update(['img' => null]);
            $this->dispatch("alert", message: "Gambar berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus gambar", type: "error");
        }
    }

    // Filter methods
    public function updateSearch($data)
    {
        $this->search = $data['search'] ?? '';
        $this->resetPage();
    }

    public function clearSearch()
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
        $ekstrakurikulers = Ekstrakurikuler::where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('desc', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.landing.ekstrakurikuler-page', [
            'ekstrakurikulers' => $ekstrakurikulers
        ]);
    }
}