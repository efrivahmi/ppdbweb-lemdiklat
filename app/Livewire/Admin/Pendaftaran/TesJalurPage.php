<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Pendaftaran\TesJalur;
use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\CustomTest;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Test Jalur")]
class TesJalurPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $jalurFilter = '';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $jalur_pendaftaran_id, $nama_tes, $deskripsi;
    public $selectedCustomTests = [];

    protected function rules()
    {
        return [
            'jalur_pendaftaran_id' => 'required|exists:jalur_pendaftarans,id',
            'nama_tes' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }

    protected $messages = [
        'jalur_pendaftaran_id.required' => 'Jalur pendaftaran wajib dipilih',
        'jalur_pendaftaran_id.exists' => 'Jalur pendaftaran tidak valid',
        'nama_tes.required' => 'Nama tes wajib diisi',
        'nama_tes.max' => 'Nama tes maksimal 255 karakter',
    ];

    // Modal Management Methods
    public function openModal()
    {
        $this->dispatch('open-modal', name: 'tes-jalur');
    }
    
    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'tes-jalur');
        $this->resetForm();
    }

    public function openCustomTestModal()
    {
        $this->dispatch('open-modal', name: 'custom-tests');
    }
    
    public function closeCustomTestModal()
    {
        $this->dispatch('close-modal', name: 'custom-tests');
        $this->selectedCustomTests = [];
    }

    public function resetForm()
    {
        $this->reset([
            'jalur_pendaftaran_id', 
            'nama_tes', 
            'deskripsi', 
            'editMode', 
            'selectedId', 
            'selectedCustomTests'
        ]);
        $this->resetErrorBag();
    }

    // Tes Jalur Methods
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }

    public function edit($id)
    {
        $tes = TesJalur::with('customTests')->findOrFail($id);
        $this->selectedId = $id;
        $this->jalur_pendaftaran_id = $tes->jalur_pendaftaran_id;
        $this->nama_tes = $tes->nama_tes;
        $this->deskripsi = $tes->deskripsi;
        $this->selectedCustomTests = $tes->customTests->pluck('id')->toArray();
        $this->editMode = true;
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $tes = TesJalur::findOrFail($this->selectedId);
                $tes->update([
                    'jalur_pendaftaran_id' => $this->jalur_pendaftaran_id,
                    'nama_tes' => $this->nama_tes,
                    'deskripsi' => $this->deskripsi,
                ]);
                $message = 'Tes jalur berhasil diperbarui';
            } else {
                $tes = TesJalur::create([
                    'jalur_pendaftaran_id' => $this->jalur_pendaftaran_id,
                    'nama_tes' => $this->nama_tes,
                    'deskripsi' => $this->deskripsi,
                ]);
                $message = 'Tes jalur berhasil ditambahkan';
            }

            // Sync custom tests
            $tes->customTests()->sync($this->selectedCustomTests);

            $this->closeModal();
            $this->dispatch("alert", message: $message, type: "success");
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Terjadi kesalahan", type: "error");
        }
    }

    public function delete($id)
    {
        try {
            $tes = TesJalur::findOrFail($id);
            $tes->delete();
            $this->dispatch("alert", message: "Tes jalur berhasil dihapus", type: "success");
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus, test jalur sedang digunakan", type: "error");
        }
    }

    // Custom Tests Management
    public function manageCustomTests($tesJalurId)
    {
        $this->selectedId = $tesJalurId;
        $tes = TesJalur::with('customTests')->findOrFail($tesJalurId);
        $this->selectedCustomTests = $tes->customTests->pluck('id')->toArray();
        $this->openCustomTestModal();
    }

    public function saveCustomTests()
    {
        try {
            $tes = TesJalur::findOrFail($this->selectedId);
            $tes->customTests()->sync($this->selectedCustomTests);
            $this->closeCustomTestModal();
            $this->dispatch("alert", message: "Custom test berhasil di perbarui", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Custom test gagal di perbarui", type: "error");
        }
    }

    // Search and Filter
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJalurFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tesJalurs = TesJalur::with(['jalurPendaftaran', 'customTests'])
            ->when($this->search, function ($query) {
                $query->where('nama_tes', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                      ->orWhereHas('jalurPendaftaran', function ($q) {
                          $q->where('nama_jalur', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->jalurFilter, function ($query) {
                $query->where('jalur_pendaftaran_id', $this->jalurFilter);
            })
            ->latest()
            ->paginate(10);

        $jalurPendaftarans = JalurPendaftaran::all();
        $customTests = CustomTest::where('is_active', true)->get();

        return view('livewire.admin.pendaftaran.tes-jalur-page', [
            'tesJalurs' => $tesJalurs,
            'jalurPendaftarans' => $jalurPendaftarans,
            'customTests' => $customTests
        ]);
    }
}