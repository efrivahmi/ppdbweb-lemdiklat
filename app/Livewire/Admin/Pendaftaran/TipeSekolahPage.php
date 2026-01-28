<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Pendaftaran\TipeSekolah;
use App\Models\Pendaftaran\Jurusan;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Tipe Sekolah dan Jurusan")]
class TipeSekolahPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;

    // Tipe Sekolah form
    public $tipeName;

    // Jurusan form
    public $tipe_sekolah_id, $jurusanName, $deskripsi;

    protected function rules()
    {
        return [
            'tipeName' => 'required|string|max:100|unique:tipe_sekolahs,nama' . ($this->editMode && $this->selectedId ? ',' . $this->selectedId : ''),
            'tipe_sekolah_id' => 'required|exists:tipe_sekolahs,id',
            'jurusanName' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'tipeName.required' => 'Nama tipe sekolah wajib diisi',
        'tipeName.unique' => 'Nama tipe sekolah sudah ada',
        'tipe_sekolah_id.required' => 'Tipe sekolah wajib dipilih',
        'jurusanName.required' => 'Nama jurusan wajib diisi',
    ];

    // Modal Management Methods
    public function openTipeModal()
    {
        $this->dispatch('open-modal', name: 'tipe-sekolah');
    }
    
    public function closeTipeModal()
    {
        $this->dispatch('close-modal', name: 'tipe-sekolah');
        $this->resetTipeForm();
    }
    
    public function openJurusanModal()
    {
        $this->dispatch('open-modal', name: 'jurusan');
    }
    
    public function closeJurusanModal()
    {
        $this->dispatch('close-modal', name: 'jurusan');
        $this->resetJurusanForm();
    }

    public function resetTipeForm()
    {
        $this->reset(['tipeName', 'editMode', 'selectedId']);
        $this->resetErrorBag(['tipeName']);
    }
    
    public function resetJurusanForm()
    {
        $this->reset(['tipe_sekolah_id', 'jurusanName', 'deskripsi', 'editMode', 'selectedId']);
        $this->resetErrorBag(['tipe_sekolah_id', 'jurusanName', 'deskripsi']);
    }

    // Tipe Sekolah Methods
    public function createTipe()
    {
        $this->resetTipeForm();
        $this->editMode = false;
        $this->openTipeModal();
    }

    public function editTipe($id)
    {
        $tipe = TipeSekolah::findOrFail($id);
        $this->selectedId = $id;
        $this->tipeName = $tipe->nama;
        $this->editMode = true;
        $this->openTipeModal();
    }

    public function saveTipe()
    {
        $this->validate(['tipeName' => $this->rules()['tipeName']]);

        if ($this->editMode) {
            $tipe = TipeSekolah::findOrFail($this->selectedId);
            $tipe->update(['nama' => $this->tipeName]);
            $message = 'Tipe sekolah berhasil diperbarui';
        } else {
            TipeSekolah::create(['nama' => $this->tipeName]);
            $message = 'Tipe sekolah berhasil ditambahkan';
        }

        $this->closeTipeModal();
        $this->dispatch("alert", message: $message, type: "success");
        $this->resetPage();
    }

    public function deleteTipe($id)
    {
        try {
            $tipe = TipeSekolah::findOrFail($id);
            $tipe->delete();
            $this->dispatch("alert", message: "Tipe sekolah berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tipe sekolah gagal di hapus", type: "error");
        }
    }

    // Jurusan Methods
    public function createJurusan($tipeId = null)
    {
        $this->resetJurusanForm();
        $this->editMode = false;
        if ($tipeId) {
            $this->tipe_sekolah_id = $tipeId;
        }
        $this->openJurusanModal();
    }

    public function editJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $this->selectedId = $id;
        $this->tipe_sekolah_id = $jurusan->tipe_sekolah_id;
        $this->jurusanName = $jurusan->nama;
        $this->deskripsi = $jurusan->deskripsi;
        $this->editMode = true;
        $this->openJurusanModal();
    }

    public function saveJurusan()
    {
        $this->validate([
            'tipe_sekolah_id' => $this->rules()['tipe_sekolah_id'],
            'jurusanName' => $this->rules()['jurusanName'],
            'deskripsi' => $this->rules()['deskripsi'],
        ]);

        if ($this->editMode) {
            $jurusan = Jurusan::findOrFail($this->selectedId);
            $jurusan->update([
                'tipe_sekolah_id' => $this->tipe_sekolah_id,
                'nama' => $this->jurusanName,
                'deskripsi' => $this->deskripsi,
            ]);
            $message = 'Jurusan berhasil diperbarui';
        } else {
            Jurusan::create([
                'tipe_sekolah_id' => $this->tipe_sekolah_id,
                'nama' => $this->jurusanName,
                'deskripsi' => $this->deskripsi,
            ]);
            $message = 'Jurusan berhasil ditambahkan';
        }

        $this->closeJurusanModal();
        $this->dispatch("alert", message: $message, type: "success");
        $this->resetPage();
    }

    public function deleteJurusan($id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->delete();
            $this->dispatch("alert", message: "Jurusan berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat menghapus jurusan", type: "error");
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tipeSekolahs = TipeSekolah::withCount('jurusans')
            ->with(['jurusans' => function ($query) {
                $query->when($this->search, function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                });
            }])
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhereHas('jurusans', function ($q) {
                          $q->where('nama', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(10);

        $allTipeSekolahs = TipeSekolah::all();
            
        return view('livewire.admin.pendaftaran.tipe-sekolah-page', [
            'tipeSekolahs' => $tipeSekolahs,
            'allTipeSekolahs' => $allTipeSekolahs
        ]);
    }
}