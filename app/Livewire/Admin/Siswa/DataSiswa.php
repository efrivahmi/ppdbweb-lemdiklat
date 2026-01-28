<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Data Siswa")]
class DataSiswa extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $transferFilter = '';

    // Form properties untuk tambah siswa
    public $name, $email, $nisn, $telp, $password, $password_confirmation;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'nisn' => 'required|digits:10|unique:users',
        'telp' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed',
    ];
    
    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'name.max' => 'Nama maksimal 255 karakter',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'nisn.required' => 'NISN wajib diisi',
        'nisn.digits' => 'NISN harus tepat 10 digit',
        'nisn.unique' => 'NISN sudah digunakan',
        'telp.max' => 'No telepon maksimal 20 karakter',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
    ];

    public function detail($id)
    {
        return redirect()->route('admin.siswa.detail', $id);
    }

    // Modal management methods
    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', name: 'create-siswa');
    }
    
    public function closeCreateModal()
    {
        $this->dispatch('close-modal', name: 'create-siswa');
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->reset(['name', 'email', 'nisn', 'telp', 'password', 'password_confirmation']);
        $this->resetErrorBag();
    }
    
    // Create siswa method
    public function createSiswa()
    {
        $this->validate();
        
        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'nisn' => $this->nisn,
                'telp' => $this->telp,
                'role' => 'siswa',
                'password' => bcrypt($this->password),
            ]);
            
            $this->closeCreateModal();
            $this->dispatch("alert", message: "Siswa berhasil di tambahkan", type: "success");
            $this->resetPage();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menambahkan siswa", type: "error");
        }
    }
    
    // Delete siswa method
    public function deleteSiswa($id)
    {
        try {
            $siswa = User::findOrFail($id);
            
            if ($siswa->role !== 'siswa') {
                $this->dispatch("alert", message: "Hanya dapat menghapus akun siswa", type: "warning");
                return;
            }
            
            $siswa->delete();
            $this->dispatch("alert", message: "Siswa berhasil di hapus", type: "success");
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal menghapus siswa", type: "error");
        }
    }

    // Search and filter methods
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTransferFilter()
    {
        $this->resetPage();
    }

    // Generate random NISN helper
    public function generateNISN()
    {
        do {
            $nisn = date('Y') . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('nisn', $nisn)->exists());
        
        $this->nisn = $nisn;
    }

    // Validate NISN availability
    public function checkNISN()
    {
        if ($this->nisn) {
            $exists = User::where('nisn', $this->nisn)->exists();
            if ($exists) {
                $this->addError('nisn', 'NISN sudah digunakan');
            } else {
                $this->resetErrorBag('nisn');
            }
        }
    }

    public function render()
    {
        $siswas = User::where('role', 'siswa')
            ->with(['dataMurid', 'dataOrangTua', 'berkasMurid', 'buktiTransfer', 'pendaftaranMurids'])
            ->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nisn', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'lengkap':
                        // All data complete: dataMurid.proses='1', dataOrangTua exists with nama_ayah & nama_ibu, berkasMurid.proses='1'
                        $query->whereHas('dataMurid', fn($q) => $q->where('proses', '1'))
                              ->whereHas('dataOrangTua', fn($q) => $q->whereNotNull('nama_ayah')->whereNotNull('nama_ibu'))
                              ->whereHas('berkasMurid', fn($q) => $q->where('proses', '1'));
                        break;
                    case 'belum_lengkap':
                        // Any data incomplete
                        $query->where(function($q) {
                            $q->whereDoesntHave('dataMurid')
                              ->orWhereHas('dataMurid', fn($sub) => $sub->where('proses', '!=', '1'))
                              ->orWhereDoesntHave('dataOrangTua')
                              ->orWhereHas('dataOrangTua', fn($sub) => $sub->whereNull('nama_ayah')->orWhereNull('nama_ibu'))
                              ->orWhereDoesntHave('berkasMurid')
                              ->orWhereHas('berkasMurid', fn($sub) => $sub->where('proses', '!=', '1'));
                        });
                        break;
                    case 'pendaftaran_diterima':
                        $query->whereHas('pendaftaranMurids', fn($q) => $q->where('status', 'diterima'));
                        break;
                }
            })
            ->when($this->transferFilter, function ($query) {
                switch ($this->transferFilter) {
                    case 'pending':
                        $query->whereHas('buktiTransfer', fn($q) => $q->where('status', 'pending'));
                        break;
                    case 'success':
                        $query->whereHas('buktiTransfer', fn($q) => $q->where('status', 'success'));
                        break;
                    case 'decline':
                        $query->whereHas('buktiTransfer', fn($q) => $q->where('status', 'decline'));
                        break;
                    case 'no_transfer':
                        $query->whereDoesntHave('buktiTransfer');
                        break;
                }
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.siswa.data-siswa', ['siswas' => $siswas]);
    }
}