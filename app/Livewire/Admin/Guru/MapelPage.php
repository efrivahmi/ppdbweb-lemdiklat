<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Mata Pelajaran")]
class MapelPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $mapel_name = '';

    protected $rules = [
        'mapel_name' => 'required|string|max:255|unique:mapels,mapel_name',
    ];

    protected $messages = [
        'mapel_name.required' => 'Nama mata pelajaran wajib diisi',
        'mapel_name.max' => 'Nama mata pelajaran maksimal 255 karakter',
        'mapel_name.unique' => 'Nama mata pelajaran sudah ada',
    ];

    protected $listeners = [
        'search-changed' => 'updateSearch',
        'search-cleared' => 'clearSearch',
        'filters-reset' => 'resetFilters',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'mapel-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'mapel-modal');
        $this->resetErrorBag();
    }

    public function resetForm()
    {
        $this->reset(['mapel_name', 'editMode', 'selectedId']);
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
        $mapel = Mapel::findOrFail($id);
        $this->selectedId = $id;
        $this->mapel_name = $mapel->mapel_name;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['mapel_name'] = 'required|string|max:255|unique:mapels,mapel_name,' . $this->selectedId;
        }

        $this->validate();

        $data = [
            'mapel_name' => $this->mapel_name,
        ];

        if ($this->editMode) {
            $mapel = Mapel::findOrFail($this->selectedId);
            $mapel->update($data);
            $message = 'Mata pelajaran berhasil diperbarui';
        } else {
            Mapel::create($data);
            $message = 'Mata pelajaran berhasil ditambahkan';
        }

        $this->resetForm();
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
            $mapel = Mapel::findOrFail($id);
            
            // Check if mapel is being used by users
            if ($mapel->users()->count() > 0) {
                $this->dispatch("alert", message: "Mata pelajaran tidak dapat dihapus karena masih digunakan oleh guru", type: "error");
                return;
            }
            
            $mapel->delete();
            $this->dispatch("alert", message: "Mata pelajaran berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Mata pelajaran gagal dihapus", type: "error");
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
        $mapels = Mapel::where('mapel_name', 'like', '%' . $this->search . '%')
            ->withCount('users')
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.guru.mapel-page', ['mapels' => $mapels]);
    }
}