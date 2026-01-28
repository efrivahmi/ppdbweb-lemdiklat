<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Information;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Informasi Sekolah")]
class InformationSection extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $icon, $title, $url, $description, $order, $is_active = true;

    protected $rules = [
        'icon' => 'required|string|max:100',
        'title' => 'required|string|max:255',
        'url' => 'nullable|string|max:500',
        'description' => 'required|string',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'icon.required' => 'Icon wajib dipilih',
        'icon.max' => 'Icon maksimal 100 karakter',
        'title.required' => 'Judul informasi wajib diisi',
        'title.max' => 'Judul maksimal 255 karakter',
        'url.max' => 'URL maksimal 500 karakter',
        'description.required' => 'Deskripsi informasi wajib diisi',
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
        $this->dispatch('open-modal', name: 'information-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'information-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['icon', 'title', 'url', 'description', 'order', 'is_active', 'editMode', 'selectedId']);
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        // Set order ke next number
        $maxOrder = Information::max('order') ?? 0;
        $this->order = $maxOrder + 1;
        $this->openModal();
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);
        $this->selectedId = $id;
        $this->icon = $information->icon;
        $this->title = $information->title;
        $this->url = $information->url;
        $this->description = $information->description;
        $this->order = $information->order;
        $this->is_active = $information->is_active;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'icon' => $this->icon,
            'title' => $this->title,
            'url' => $this->url,
            'description' => $this->description,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            $information = Information::findOrFail($this->selectedId);
            $information->update($data);
            $message = 'Informasi berhasil diperbarui';
        } else {
            Information::create($data);
            $message = 'Informasi berhasil ditambahkan';
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
            $information = Information::findOrFail($id);
            $information->delete();
            $this->dispatch("alert", message: "Informasi berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Informasi gagal dihapus", type: "error");
        }
    }

    public function toggleStatus($id)
    {
        try {
            $information = Information::findOrFail($id);
            $information->update(['is_active' => !$information->is_active]);
            $status = $information->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch("alert", message: "Informasi berhasil {$status}", type: "success");
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
        // Daftar icon yang tersedia - sesuaikan dengan kebutuhan
        return [
            'academic-cap' => 'Academic Cap (Topi Wisuda)',
            'beaker' => 'Beaker (Lab/Sains)',
            'book-open' => 'Book Open (Buku Terbuka)',
            'building-library' => 'Building Library (Perpustakaan)',
            'calculator' => 'Calculator (Kalkulator)',
            'chart-bar' => 'Chart Bar (Grafik)',
            'clipboard-document-list' => 'Clipboard Document (Dokumen)',
            'computer-desktop' => 'Computer Desktop (Komputer)',
            'document-text' => 'Document Text (Dokumen Teks)',
            'globe-alt' => 'Globe (Dunia)',
            'light-bulb' => 'Light Bulb (Lampu/Ide)',
            'megaphone' => 'Megaphone (Pengumuman)',
            'newspaper' => 'Newspaper (Koran/Berita)',
            'trophy' => 'Trophy (Piala/Prestasi)',
            'user-group' => 'User Group (Kelompok)',
            'users' => 'Users (Pengguna)',
            'phone' => 'Phone (Telepon)',
            'envelope' => 'Envelope (Email)',
            'map-pin' => 'Map Pin (Lokasi)',
            'calendar' => 'Calendar (Kalender)',
            'clock' => 'Clock (Jam)',
            'information-circle' => 'Information Circle (Info)',
        ];
    }

    public function render()
    {
        $informations = Information::where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('icon', 'like', '%' . $this->search . '%')
                      ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order', 'asc')
            ->paginate(10);
            
        return view('livewire.admin.landing.information-section', [
            'informations' => $informations
        ]);
    }
}