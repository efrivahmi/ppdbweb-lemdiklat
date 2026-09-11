<?php

namespace App\Livewire\Admin\Settings;

use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("layouts.admin")]
#[Title("Tahun Ajaran")]
class TahunAjaranPage extends Component
{
    use WithPagination;

    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    public $nama_tahun, $is_active = true;

    protected $rules = [
        'nama_tahun' => 'required|string|max:50',
        'is_active' => 'boolean'
    ];

    protected $messages = [
        'nama_tahun.required' => 'Tahun Ajaran wajib diisi',
        'nama_tahun.max' => 'Tahun Ajaran maksimal 50 karakter',
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'tahun-ajaran-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'tahun-ajaran-modal');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nama_tahun', 'is_active', 'editMode', 'selectedId']);
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
        $ta = TahunAjaran::findOrFail($id);
        $this->selectedId = $id;
        $this->nama_tahun = $ta->nama_tahun;
        $this->is_active = $ta->is_active;

        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_tahun' => $this->nama_tahun,
            'is_active' => $this->is_active
        ];

        if ($this->editMode) {
            $ta = TahunAjaran::findOrFail($this->selectedId);
            $ta->update($data);
            $message = 'Tahun Ajaran berhasil diperbarui';
        } else {
            TahunAjaran::create($data);
            $message = 'Tahun Ajaran berhasil ditambahkan';
        }

        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function delete($id)
    {
        try {
            $ta = TahunAjaran::findOrFail($id);
            if ($ta->gelombangPendaftarans()->count() > 0) {
                $this->dispatch("alert", message: "Tidak dapat menghapus Tahun Ajaran yang sudah memiliki Gelombang Pendaftaran", type: "error");
                return;
            }
            $ta->delete();
            $this->dispatch("alert", message: "Tahun Ajaran berhasil dihapus.", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus Tahun Ajaran", type: "error");
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tahunAjarans = TahunAjaran::where('nama_tahun', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.settings.tahun-ajaran-page', [
            'tahunAjarans' => $tahunAjarans
        ]);
    }
}
