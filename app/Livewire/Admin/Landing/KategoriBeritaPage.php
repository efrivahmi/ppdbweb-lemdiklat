<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\KategoriBerita;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Kategori Berita")]
class KategoriBeritaPage extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $name, $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:kategori_beritas,name' . ($this->editMode ? ',' . $this->selectedId : ''),
            'is_active' => 'required|boolean',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama kategori wajib diisi',
        'name.max' => 'Nama kategori maksimal 255 karakter',
        'name.unique' => 'Nama kategori sudah ada',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'filter-changed' => 'updateFilter',
        'search-cleared' => 'clearSearch',
        'filters-reset' => 'resetFilters',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'kategori-berita-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'kategori-berita-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['name', 'is_active', 'editMode', 'selectedId']);
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
        $kategori = KategoriBerita::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $kategori->name;
        $this->is_active = $kategori->is_active;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate($this->rules());

        $data = [
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            $kategori = KategoriBerita::findOrFail($this->selectedId);
            $kategori->update($data);
            $message = 'Kategori berita berhasil diperbarui';
        } else {
            KategoriBerita::create($data);
            $message = 'Kategori berita berhasil ditambahkan';
        }

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
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->update(['is_active' => !$kategori->is_active]);

        $status = $kategori->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch("alert", message: "Kategori berita " . $status, type: "success");
    }

    public function delete($id)
    {
        try {
            $kategori = KategoriBerita::withCount('beritas')->findOrFail($id);

            if ($kategori->beritas_count > 0) {
                $this->dispatch("alert", message: "kategori masih digunakan.", type: "warning");
                return;
            }

            $kategori->delete();
            $this->dispatch("alert", message: "Kategori berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Kategori gagal dihapus", type: "error");
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
        $kategoris = KategoriBerita::withCount('beritas')
            ->where('name', 'like', '%' . $this->search . '%')
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.landing.kategori-berita-page', ['kategoris' => $kategoris]);
    }
}