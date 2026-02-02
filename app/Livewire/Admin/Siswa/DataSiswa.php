<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\User;
use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\TipeSekolah;
use App\Models\Pendaftaran\Jurusan;
use App\Models\Pendaftaran\PendaftaranMurid;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
    
    // Force Register Properties
    public $forceSiswaId;
    public $forceJalurId;
    public $forceTipeId;
    public $forceJurusanId;
    public $forceJurusans = [];
    public $forceJalurs = [];
    public $forceTipes = [];
    public $isEditingRegistration = false;
    public $editingRegistrationId = null;
    
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

    public function openForceRegisterModal($siswaId)
    {
        if (Auth::user()->email !== 'forsake002@gmail.com') {
            $this->dispatch("alert", message: "Akses ditolak!", type: "error");
            return;
        }

        $this->resetForceRegisterForm();
        $this->forceSiswaId = $siswaId;
        
        // Load initial data
        $this->forceJalurs = JalurPendaftaran::all();
        $this->forceTipes = TipeSekolah::all();
        $this->forceJurusans = collect();

        // Check if student already has a registration
        $registration = PendaftaranMurid::where('user_id', $siswaId)->first();
        if ($registration) {
            $this->isEditingRegistration = true;
            $this->editingRegistrationId = $registration->id;
            $this->forceJalurId = $registration->jalur_pendaftaran_id;
            $this->forceTipeId = $registration->tipe_sekolah_id;
            $this->forceJurusanId = $registration->jurusan_id;
            
            // Load jurusans for selected tipe
            $this->forceJurusans = Jurusan::where('tipe_sekolah_id', $this->forceTipeId)->get();
        }

        $this->dispatch('open-modal', name: 'force-register');
    }

    public function updatedForceTipeId($value)
    {
        if ($value) {
            $this->forceJurusans = Jurusan::where('tipe_sekolah_id', $value)->get();
        } else {
            $this->forceJurusans = collect();
        }
        $this->forceJurusanId = null;
    }

    public function forceRegisterSubmit()
    {
        if (Auth::user()->email !== 'forsake002@gmail.com') {
            return;
        }

        $this->validate([
            'forceJalurId' => 'required',
            'forceTipeId' => 'required',
            'forceJurusanId' => 'required',
        ], [
            'required' => 'Wajib dipilih'
        ]);

        try {
            if ($this->isEditingRegistration) {
                // Update
                $registration = PendaftaranMurid::find($this->editingRegistrationId);
                $registration->update([
                    'jalur_pendaftaran_id' => $this->forceJalurId,
                    'tipe_sekolah_id' => $this->forceTipeId,
                    'jurusan_id' => $this->forceJurusanId,
                ]);
                $message = "Registrasi berhasil diperbarui (Force Update)";
            } else {
                // Create New
                 PendaftaranMurid::create([
                    'user_id' => $this->forceSiswaId,
                    'jalur_pendaftaran_id' => $this->forceJalurId,
                    'tipe_sekolah_id' => $this->forceTipeId,
                    'jurusan_id' => $this->forceJurusanId,
                    'status' => 'pending', // Default pending
                ]);
                $message = "Registrasi berhasil dibuat (Force Register)";
            }

            $this->dispatch('close-modal', name: 'force-register');
            $this->dispatch("alert", message: $message, type: "success");
            $this->resetPage(); // Refresh table

        } catch (\Exception $e) {
             $this->dispatch("alert", message: "Error: " . $e->getMessage(), type: "error");
        }
    }

    public function resetForceRegisterForm()
    {
        $this->reset(['forceSiswaId', 'forceJalurId', 'forceTipeId', 'forceJurusanId', 'forceJurusans', 'isEditingRegistration', 'editingRegistrationId']);
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

    // Login as user method
    public function loginAs($userId)
    {
        // STRICT CHECK: Only Super User can use this
        if (Auth::user()->email !== 'forsake002@gmail.com') {
            $this->dispatch("alert", message: "Akses ditolak! Hanya Super Admin yang dapat menggunakan fitur ini.", type: "error");
            return;
        }

        try {
            $user = User::findOrFail($userId);
            
            // Log the action (optional security measure)
            // Log::info('Admin ' . Auth::user()->name . ' logged in as ' . $user->name);

            Auth::loginUsingId($userId);
            
            // Redirect to student dashboard
            return redirect()->route('siswa.dashboard');
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal login sebagai user", type: "error");
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
                        // All data complete: all 7 dataMurid fields, any parent group complete, all 5 berkas, has pendaftaran
                        $query->whereHas('dataMurid', fn($q) => $q
                            ->whereNotNull('tempat_lahir')
                            ->whereNotNull('tgl_lahir')
                            ->whereNotNull('jenis_kelamin')
                            ->whereNotNull('agama')
                            ->whereNotNull('whatsapp')
                            ->whereNotNull('alamat')
                            ->whereNotNull('asal_sekolah')
                        )
                        ->where(function($q) {
                            // Any parent group complete (ayah OR ibu OR wali)
                            $q->whereHas('dataOrangTua', fn($sub) => $sub
                                ->whereNotNull('nama_ayah')
                                ->whereNotNull('pendidikan_ayah')
                                ->whereNotNull('telp_ayah')
                                ->whereNotNull('pekerjaan_ayah')
                                ->whereNotNull('alamat_ayah')
                            )
                            ->orWhereHas('dataOrangTua', fn($sub) => $sub
                                ->whereNotNull('nama_ibu')
                                ->whereNotNull('pendidikan_ibu')
                                ->whereNotNull('telp_ibu')
                                ->whereNotNull('pekerjaan_ibu')
                                ->whereNotNull('alamat_ibu')
                            )
                            ->orWhereHas('dataOrangTua', fn($sub) => $sub
                                ->whereNotNull('nama_wali')
                                ->whereNotNull('pendidikan_wali')
                                ->whereNotNull('telp_wali')
                                ->whereNotNull('pekerjaan_wali')
                                ->whereNotNull('alamat_wali')
                            );
                        })
                        ->whereHas('berkasMurid', fn($q) => $q
                            ->whereNotNull('kk')
                            ->whereNotNull('ktp_ortu')
                            ->whereNotNull('akte')
                            ->whereNotNull('surat_sehat')
                            ->whereNotNull('pas_foto')
                        )
                        ->whereHas('pendaftaranMurids');
                        break;
                    case 'belum_lengkap':
                        // Any data incomplete - inverse of lengkap
                        $query->where(function($q) {
                            // Missing or incomplete dataMurid
                            $q->whereDoesntHave('dataMurid')
                            ->orWhereHas('dataMurid', fn($sub) => $sub
                                ->where(function($s) {
                                    $s->whereNull('tempat_lahir')
                                      ->orWhereNull('tgl_lahir')
                                      ->orWhereNull('jenis_kelamin')
                                      ->orWhereNull('agama')
                                      ->orWhereNull('whatsapp')
                                      ->orWhereNull('alamat')
                                      ->orWhereNull('asal_sekolah');
                                })
                            )
                            // Missing dataOrangTua or no complete parent group
                            ->orWhereDoesntHave('dataOrangTua')
                            // Missing or incomplete berkasMurid
                            ->orWhereDoesntHave('berkasMurid')
                            ->orWhereHas('berkasMurid', fn($sub) => $sub
                                ->where(function($s) {
                                    $s->whereNull('kk')
                                      ->orWhereNull('ktp_ortu')
                                      ->orWhereNull('akte')
                                      ->orWhereNull('surat_sehat')
                                      ->orWhereNull('pas_foto');
                                })
                            )
                            // No pendaftaran
                            ->orWhereDoesntHave('pendaftaranMurids');
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