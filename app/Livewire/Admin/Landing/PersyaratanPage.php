<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Persyaratan;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Persyaratan")]
class PersyaratanPage extends Component
{
    use WithPagination;

    public $search = '';
    public $editMode = false;
    public $persyaratanId;
    public $activeTab = 'physical'; // physical or document

    // Form properties
    public $type = '';
    public $title = '';
    public $description = '';
    public $value = '';
    public $unit = '';
    public $gender = '';
    public $color = '';
    public $is_active = true;
    public $order = 0;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'type' => 'required|in:physical,document',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'value' => 'required|string|max:100',
        'unit' => 'nullable|string|max:50',
        'gender' => 'nullable|in:male,female',
        'color' => 'nullable|string|max:50',
        'is_active' => 'boolean',
        'order' => 'integer|min:0'
    ];

    protected $messages = [
        'type.required' => 'Tipe persyaratan harus dipilih',
        'title.required' => 'Judul persyaratan harus diisi',
        'value.required' => 'Nilai persyaratan harus diisi'
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'persyaratan-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'persyaratan-modal');
        $this->resetErrorBag();
    }

    public function createPhysical()
    {
        $this->resetForm();
        $this->type = 'physical';
        $this->editMode = false;
        $this->openModal();
    }

    public function createDocument()
    {
        $this->resetForm();
        $this->type = 'document';
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        $persyaratan = Persyaratan::findOrFail($id);
        $this->persyaratanId = $id;
        $this->type = $persyaratan->type;
        $this->title = $persyaratan->title;
        $this->description = $persyaratan->description;
        $this->value = $persyaratan->value;
        $this->unit = $persyaratan->unit;
        $this->gender = $persyaratan->gender;
        $this->color = $persyaratan->color;
        $this->is_active = $persyaratan->is_active;
        $this->order = $persyaratan->order;
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'value' => $this->value,
            'unit' => $this->unit,
            'gender' => $this->type === 'physical' ? $this->gender : null,
            'color' => $this->type === 'physical' ? $this->color : null,
            'is_active' => $this->is_active,
            'order' => $this->order
        ];

        if ($this->editMode) {
            $persyaratan = Persyaratan::findOrFail($this->persyaratanId);
            $persyaratan->update($data);
            $message = 'Persyaratan berhasil diperbarui';
        } else {
            Persyaratan::create($data);
            $message = 'Persyaratan berhasil ditambahkan';
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
            Persyaratan::findOrFail($id)->delete();
            $this->dispatch("alert", message: "Persyaratan berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Persyaratan gagal di hapus", type: "error");
        }
    }

    private function resetForm()
    {
        $this->type = '';
        $this->title = '';
        $this->description = '';
        $this->value = '';
        $this->unit = '';
        $this->gender = '';
        $this->color = '';
        $this->is_active = true;
        $this->order = 0;
        $this->persyaratanId = null;
        $this->resetErrorBag();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function getGenderOptionsProperty()
    {
        return [
            ['value' => 'male', 'label' => 'Laki-laki'],
            ['value' => 'female', 'label' => 'Perempuan']
        ];
    }

    public function getColorOptionsProperty()
    {
        return [
            ['value' => 'blue', 'label' => 'Biru'],
            ['value' => 'pink', 'label' => 'Pink']
        ];
    }

    public function render()
    {
        $physicalRequirements = Persyaratan::physical()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'physicalPage');

        $documentRequirements = Persyaratan::document()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'documentPage');

        return view('livewire.admin.landing.persyaratan-page', compact('physicalRequirements', 'documentRequirements'));
    }
}