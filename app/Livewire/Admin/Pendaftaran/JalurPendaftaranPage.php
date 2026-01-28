<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Pendaftaran\JalurPendaftaran;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout("layouts.admin")]
#[Title("Jalur Pendaftaran")]
class JalurPendaftaranPage extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $editMode = false;
    public $selectedId = null;
    public $nama, $deskripsi, $img;
    public $oldImg = null; // Untuk menyimpan path gambar lama

    protected $rules = [
        'nama' => 'required|string|max:100',
        'deskripsi' => 'nullable|string',
        'img' => 'nullable|image|max:2048', // max 2MB
    ];

    protected $messages = [
        'nama.required' => 'Nama jalur pendaftaran wajib diisi',
        'nama.max' => 'Nama maksimal 100 karakter',
        'img.image' => 'File harus berupa gambar',
        'img.max' => 'Ukuran gambar maksimal 2MB'
    ];

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'jalur-pendaftaran');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'jalur-pendaftaran');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nama', 'deskripsi', 'img', 'oldImg', 'editMode', 'selectedId']);
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
        $jalur = JalurPendaftaran::findOrFail($id);
        
        $this->selectedId = $id;
        $this->nama = $jalur->nama;
        $this->deskripsi = $jalur->deskripsi;
        $this->oldImg = $jalur->img;
        $this->editMode = true;
        
        $this->openModal();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ];

        // Handle upload gambar
        if ($this->img) {
            // Hapus gambar lama jika ada
            if ($this->editMode && $this->oldImg) {
                Storage::disk('public')->delete($this->oldImg);
            }
            
            // Upload gambar baru
            $data['img'] = $this->img->store('jalur-pendaftaran', 'public');
        }

        if ($this->editMode) {
            $jalur = JalurPendaftaran::findOrFail($this->selectedId);
            $jalur->update($data);
            $message = 'Jalur pendaftaran berhasil diperbarui';
        } else {
            JalurPendaftaran::create($data);
            $message = 'Jalur pendaftaran berhasil ditambahkan';
        }

        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $jalur = JalurPendaftaran::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($jalur->img) {
                Storage::disk('public')->delete($jalur->img);
            }
            
            $jalur->delete();
            $this->dispatch("alert", message: "Jalur pendaftaran berhasil dihapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat menghapus jalur pendaftaran yang digunakan.", type: "error");
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jalurs = JalurPendaftaran::where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.pendaftaran.jalur-pendaftaran-page', ['jalurs' => $jalurs]);
    }
}