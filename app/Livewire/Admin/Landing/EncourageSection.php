<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Advantage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Keunggulan Sekolah")]
class EncourageSection extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $icon, $title, $description, $order, $is_active = true;

    protected $rules = [
        'icon' => 'required|string|max:100',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'icon.required' => 'Icon wajib dipilih',
        'icon.max' => 'Icon maksimal 100 karakter',
        'title.required' => 'Judul keunggulan wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'description.required' => 'Deskripsi keunggulan wajib diisi',
        'order.required' => 'Urutan wajib diisi',
        'order.integer' => 'Urutan harus berupa angka',
        'order.min' => 'Urutan minimal 0',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'search-cleared' => 'clearSearch',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'advantage-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'advantage-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['icon', 'title', 'description', 'order', 'is_active', 'editMode', 'selectedId']);
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        // Set order ke next number
        $maxOrder = Advantage::max('order') ?? 0;
        $this->order = $maxOrder + 1;
        $this->openModal();
    }

    public function edit($id)
    {
        $advantage = Advantage::findOrFail($id);
        $this->selectedId = $id;
        $this->icon = $advantage->icon;
        $this->title = $advantage->title;
        $this->description = $advantage->description;
        $this->order = $advantage->order;
        $this->is_active = $advantage->is_active;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            $advantage = Advantage::findOrFail($this->selectedId);
            $advantage->update($data);
            $message = 'Keunggulan berhasil diperbarui';
        } else {
            Advantage::create($data);
            $message = 'Keunggulan berhasil ditambahkan';
        }

        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
        $this->resetForm();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $advantage = Advantage::findOrFail($id);
            $advantage->delete();
            $this->dispatch("alert", message: "Keunggulan berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Keunggulan gagal dihapus", type: "error");
        }
    }

    public function toggleStatus($id)
    {
        try {
            $advantage = Advantage::findOrFail($id);
            $advantage->update(['is_active' => !$advantage->is_active]);
            $status = $advantage->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch("alert", message: "Keunggulan berhasil {$status}", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengubah status", type: "error");
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

    public function getAvailableIconsProperty()
    {
        return Advantage::getAvailableIcons();
    }

    public function render()
    {
        $advantages = Advantage::where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('icon', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order', 'asc')
            ->paginate(10);
            
        return view('livewire.admin.landing.encourage-section', [
            'advantages' => $advantages
        ]);
    }
}