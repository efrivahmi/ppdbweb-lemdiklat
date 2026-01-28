<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\StrukturSekolah;
use App\Models\Landing\FotoStrukturSekolah;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Struktur Sekolah")]
class StrukturSekolahPage extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $editMode = false;
    public $strukturId;
    
    // Form fields untuk struktur
    public $nama = '';
    public $jabatan = '';
    public $posisi = 1;
    public $img;
    public $existingImg = '';
    public $desc = '';

    // Form fields untuk foto struktur
    public $fotoNama = '';
    public $fotoImg;
    public $existingFotoImg = '';
    public $editFotoMode = false;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'posisi' => 'required|integer|min:1',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'desc' => 'required|string',
        'fotoNama' => 'required|string|max:255',
        'fotoImg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB untuk foto bagan
    ];

    protected $messages = [
        'nama.required' => 'Nama harus diisi',
        'nama.max' => 'Nama maksimal 255 karakter',
        'jabatan.required' => 'Jabatan harus diisi',
        'jabatan.max' => 'Jabatan maksimal 255 karakter',
        'posisi.required' => 'Posisi harus diisi',
        'posisi.integer' => 'Posisi harus berupa angka',
        'posisi.min' => 'Posisi minimal 1',
        'img.image' => 'File harus berupa gambar',
        'img.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
        'img.max' => 'Ukuran gambar maksimal 2MB',
        'desc.required' => 'Deskripsi harus diisi',
        'fotoNama.required' => 'Nama foto struktur harus diisi',
        'fotoNama.max' => 'Nama foto struktur maksimal 255 karakter',
        'fotoImg.image' => 'File harus berupa gambar',
        'fotoImg.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
        'fotoImg.max' => 'Ukuran gambar maksimal 5MB',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // CRUD untuk Struktur Sekolah
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->dispatch('open-modal', name: 'struktur-modal');
    }

    public function edit($id)
    {
        $struktur = StrukturSekolah::findOrFail($id);
        $this->strukturId = $id;
        $this->nama = $struktur->nama;
        $this->jabatan = $struktur->jabatan;
        $this->posisi = $struktur->posisi;
        $this->existingImg = $struktur->img;
        $this->desc = $struktur->desc;
        $this->editMode = true;
        $this->dispatch('open-modal', name: 'struktur-modal');
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'posisi' => 'required|integer|min:1',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required|string',
        ]);

        $data = [
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
            'posisi' => $this->posisi,
            'desc' => $this->desc,
        ];

        if ($this->img) {
            if ($this->editMode && $this->existingImg) {
                Storage::disk('public')->delete($this->existingImg);
            }
            
            $imageName = 'struktur-sekolah/' . time() . '_' . $this->img->getClientOriginalName();
            $this->img->storeAs('', $imageName, 'public');
            $data['img'] = $imageName;
        } elseif ($this->editMode) {
            $data['img'] = $this->existingImg;
        }

        if ($this->editMode) {
            $struktur = StrukturSekolah::findOrFail($this->strukturId);
            $struktur->update($data);
        } else {
            StrukturSekolah::create($data);
        }

        $this->dispatch("alert", message: "Struktur sekolah berhasil di perbarui.", type: "success");
        $this->resetForm();
    }

    public function cancel()
    {
        $this->dispatch('close-modal', name: 'struktur-modal');
        $this->resetForm();
    }

    public function delete($id)
    {
        $struktur = StrukturSekolah::findOrFail($id);
        
        if ($struktur->img) {
            Storage::disk('public')->delete($struktur->img);
        }

        $struktur->delete();
    }

    // CRUD untuk Foto Struktur
    public function editFotoStruktur()
    {
        $fotoStruktur = FotoStrukturSekolah::first();
        
        if ($fotoStruktur) {
            $this->fotoNama = $fotoStruktur->nama;
            $this->existingFotoImg = $fotoStruktur->img;
            $this->editFotoMode = true;
        } else {
            $this->fotoNama = '';
            $this->existingFotoImg = '';
            $this->editFotoMode = false;
        }
        
        $this->fotoImg = null;
        $this->dispatch('open-modal', name: 'foto-struktur-modal');
    }

    public function saveFotoStruktur()
    {
        $this->validate([
            'fotoNama' => 'required|string|max:255',
            'fotoImg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = [
            'nama' => $this->fotoNama,
        ];

        if ($this->fotoImg) {
            if ($this->existingFotoImg) {
                Storage::disk('public')->delete($this->existingFotoImg);
            }
            
            $imageName = 'foto-struktur/' . time() . '_' . $this->fotoImg->getClientOriginalName();
            $this->fotoImg->storeAs('', $imageName, 'public');
            $data['img'] = $imageName;
        } elseif ($this->editFotoMode) {
            $data['img'] = $this->existingFotoImg;
        }

        if ($this->editFotoMode) {
            $fotoStruktur = FotoStrukturSekolah::first();
            $fotoStruktur->update($data);
        } else {
            // Pastikan hanya ada 1 foto struktur
            FotoStrukturSekolah::truncate();
            FotoStrukturSekolah::create($data);
        }

        $this->dispatch('close-modal', name: 'foto-struktur-modal');
        $this->resetFotoForm();
    }

    public function cancelFotoStruktur()
    {
        $this->dispatch('close-modal', name: 'foto-struktur-modal');
        $this->resetFotoForm();
    }

    public function deleteFotoStruktur()
    {
        $fotoStruktur = FotoStrukturSekolah::first();
        
        if ($fotoStruktur) {
            if ($fotoStruktur->img) {
                Storage::disk('public')->delete($fotoStruktur->img);
            }
            $fotoStruktur->delete();
        }
    }

    private function resetForm()
    {
        $this->nama = '';
        $this->jabatan = '';
        $this->posisi = 1;
        $this->img = null;
        $this->existingImg = '';
        $this->desc = '';
        $this->strukturId = null;
        $this->resetErrorBag();
    }

    private function resetFotoForm()
    {
        $this->fotoNama = '';
        $this->fotoImg = null;
        $this->existingFotoImg = '';
        $this->editFotoMode = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        $strukturs = StrukturSekolah::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                      ->orWhere('desc', 'like', '%' . $this->search . '%');
            })
            ->orderBy('posisi', 'asc')
            ->paginate(10);

        $fotoStruktur = FotoStrukturSekolah::first();

        return view('livewire.admin.landing.struktur-sekolah-page', compact('strukturs', 'fotoStruktur'));
    }
}