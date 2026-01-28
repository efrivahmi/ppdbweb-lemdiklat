<?php

namespace App\Livewire\Siswa\Formulir;

use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\Jurusan;
use App\Models\Pendaftaran\TipeSekolah;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\BuktiPrestasi;
use App\Models\Pendaftaran\BuktiTahfidz;
use App\Models\GelombangPendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Pilih Program Study")]
class FormulirPendaftaranPage extends Component
{
    use WithFileUploads;

    public $jalur_pendaftaran_id;
    public $tipe_sekolah_id;
    public $jurusan_id;
    public $editingId = null;

    // File uploads untuk bukti prestasi (3 slots)
    public $bukti_prestasi_1;
    public $bukti_prestasi_2;
    public $bukti_prestasi_3;
    
    // File uploads untuk bukti tahfidz (3 slots)
    public $bukti_tahfidz_1;
    public $bukti_tahfidz_2;
    public $bukti_tahfidz_3;
    
    public $existing_bukti_prestasi = [];
    public $existing_bukti_tahfidz = [];

    public $jalurs = [];
    public $tipes = [];
    public $jurusans = [];
    public $pendaftaranList;
    public $selectedJalur = null;

    public function mount()
    {
        $this->jalurs = JalurPendaftaran::all();
        $this->tipes = collect();
        $this->jurusans = collect();
        $this->loadPendaftaranList();
    }

    public function loadPendaftaranList()
    {
        $this->pendaftaranList = PendaftaranMurid::with([
                'jalurPendaftaran', 
                'tipeSekolah', 
                'jurusan', 
                'buktiPrestasis',
                'buktiTahfidzs'
            ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Set selected jalur dari data yang sudah ada
        if ($this->pendaftaranList->isNotEmpty()) {
            $this->selectedJalur = $this->pendaftaranList->first()->jalurPendaftaran;
        }
    }

    // Ketika jalur pendaftaran berubah
    public function updatedJalurPendaftaranId($value)
    {
        if ($value) {
            // Cek apakah user sudah punya pendaftaran dengan jalur lain
            $existingJalur = PendaftaranMurid::where('user_id', Auth::id())
                ->where('jalur_pendaftaran_id', '!=', $value)
                ->first();
                
            if ($existingJalur) {
                $this->dispatch('alert', type: 'error', message: 'Anda sudah terdaftar di jalur lain. Tidak bisa mengubah jalur pendaftaran.');
                $this->jalur_pendaftaran_id = $existingJalur->jalur_pendaftaran_id;
                return;
            }
            
            $this->tipes = TipeSekolah::all();
            $this->selectedJalur = JalurPendaftaran::find($value);
        } else {
            $this->tipes = collect();
            $this->selectedJalur = null;
        }
        
        // Reset pilihan yang bergantung
        $this->tipe_sekolah_id = null;
        $this->jurusan_id = null;
        $this->jurusans = collect();
    }

    // Ketika tipe sekolah berubah
    public function updatedTipeSekolahId($value)
    {
        if ($value) {
            $this->jurusans = Jurusan::where('tipe_sekolah_id', $value)->get();
        } else {
            $this->jurusans = collect();
        }
        
        // Reset pilihan jurusan
        $this->jurusan_id = null;
    }

    // Check if current jalur is "Prestasi"
    public function isJalurPrestasi()
    {
        if (!$this->jalur_pendaftaran_id) {
            return false;
        }
        
        $jalur = JalurPendaftaran::find($this->jalur_pendaftaran_id);
        return $jalur && strtolower($jalur->nama) === 'prestasi';
    }

    // Check if current jalur is "Tahfidz Quran"
    public function isJalurTahfidz()
    {
        if (!$this->jalur_pendaftaran_id) {
            return false;
        }
        
        $jalur = JalurPendaftaran::find($this->jalur_pendaftaran_id);
        return $jalur && strtolower($jalur->nama) === 'tahfidz quran';
    }

    // Remove existing bukti prestasi file
    public function removeExistingFile($buktiId)
    {
        $bukti = BuktiPrestasi::find($buktiId);
        
        if ($bukti && $bukti->pendaftaranMurid->user_id == Auth::id()) {
            $bukti->delete();
            $this->loadExistingBuktiPrestasi();
            $this->dispatch('alert', type: 'success', message: 'Bukti prestasi berhasil dihapus.');
        }
    }

    // Remove existing bukti tahfidz file
    public function removeExistingFileTahfidz($buktiId)
    {
        $bukti = BuktiTahfidz::find($buktiId);
        
        if ($bukti && $bukti->pendaftaranMurid->user_id == Auth::id()) {
            $bukti->delete();
            $this->loadExistingBuktiTahfidz();
            $this->dispatch('alert', type: 'success', message: 'Bukti tahfidz berhasil dihapus.');
        }
    }

    // Load existing bukti prestasi when editing
    public function loadExistingBuktiPrestasi()
    {
        if ($this->editingId) {
            $this->existing_bukti_prestasi = BuktiPrestasi::where('pendaftaran_murid_id', $this->editingId)->get();
        } else {
            $this->existing_bukti_prestasi = [];
        }
    }

    // Load existing bukti tahfidz when editing
    public function loadExistingBuktiTahfidz()
    {
        if ($this->editingId) {
            $this->existing_bukti_tahfidz = BuktiTahfidz::where('pendaftaran_murid_id', $this->editingId)->get();
        } else {
            $this->existing_bukti_tahfidz = [];
        }
    }

    // Remove uploaded bukti prestasi file by slot
    public function removeBuktiFile($slot)
    {
        $propertyName = "bukti_prestasi_$slot";
        $this->$propertyName = null;
    }

    // Remove uploaded bukti tahfidz file by slot
    public function removeBuktiFileTahfidz($slot)
    {
        $propertyName = "bukti_tahfidz_$slot";
        $this->$propertyName = null;
    }

    public function submit()
    {
        // Cek gelombang pendaftaran aktif terlebih dahulu
        $gelombangActive = GelombangPendaftaran::pendaftaranAktif()->first();
        
        if (!$gelombangActive || !$gelombangActive->isPendaftaranAktif()) {
            $this->dispatch('alert', type: 'error', message: 'Pendaftaran sudah ditutup atau belum dibuka.');
            return;
        }

        // Cek maksimal 1 program studi - siswa hanya bisa pilih 1 jurusan
        if (!$this->editingId && $this->pendaftaranList->count() >= 1) {
            $this->dispatch("alert", message: "Anda hanya dapat memilih 1 program studi", type: "error");
            return;
        }

        // Validasi dasar
        $rules = [
            'jalur_pendaftaran_id' => 'required|integer|min:1',
            'tipe_sekolah_id' => 'required|integer|min:1',
            'jurusan_id' => 'required|integer|min:1',
        ];

        // Validasi tambahan untuk jalur prestasi
        if ($this->isJalurPrestasi()) {
            $rules['bukti_prestasi_1'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['bukti_prestasi_2'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['bukti_prestasi_3'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        // Validasi tambahan untuk jalur tahfidz
        if ($this->isJalurTahfidz()) {
            $rules['bukti_tahfidz_1'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['bukti_tahfidz_2'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['bukti_tahfidz_3'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $this->validate($rules, [
            'bukti_prestasi_1.mimes' => 'File bukti prestasi 1 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_prestasi_1.max' => 'Ukuran file bukti prestasi 1 maksimal 2MB.',
            'bukti_prestasi_2.mimes' => 'File bukti prestasi 2 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_prestasi_2.max' => 'Ukuran file bukti prestasi 2 maksimal 2MB.',
            'bukti_prestasi_3.mimes' => 'File bukti prestasi 3 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_prestasi_3.max' => 'Ukuran file bukti prestasi 3 maksimal 2MB.',
            'bukti_tahfidz_1.mimes' => 'File bukti tahfidz 1 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_tahfidz_1.max' => 'Ukuran file bukti tahfidz 1 maksimal 2MB.',
            'bukti_tahfidz_2.mimes' => 'File bukti tahfidz 2 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_tahfidz_2.max' => 'Ukuran file bukti tahfidz 2 maksimal 2MB.',
            'bukti_tahfidz_3.mimes' => 'File bukti tahfidz 3 harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_tahfidz_3.max' => 'Ukuran file bukti tahfidz 3 maksimal 2MB.',
        ]);

        // Validasi referensi data
        $jalur = JalurPendaftaran::find($this->jalur_pendaftaran_id);
        $tipe = TipeSekolah::find($this->tipe_sekolah_id);
        $jurusan = Jurusan::find($this->jurusan_id);

        if (!$jalur || !$tipe || !$jurusan) {
            $this->dispatch("alert", message: "Data tidak dapat dipilih", type: "error");
            return;
        }

        // Validasi jurusan sesuai tipe sekolah
        if ($jurusan->tipe_sekolah_id != $this->tipe_sekolah_id) {
            $this->dispatch('alert', type: 'error', message: 'Jurusan tidak sesuai dengan tipe sekolah yang dipilih.');
            return;
        }

        // Cek duplikasi program studi (kecuali jika sedang edit)
        $duplicateQuery = PendaftaranMurid::where('user_id', Auth::id())
            ->where('jurusan_id', $this->jurusan_id);
        
        if ($this->editingId) {
            $duplicateQuery->where('id', '!=', $this->editingId);
        }

        if ($duplicateQuery->exists()) {
            $this->dispatch('alert', type: 'error', message: 'Anda sudah memilih program studi ini sebelumnya.');
            return;
        }

        try {
            if ($this->editingId) {
                // Update pendaftaran yang sudah ada
                $pendaftaran = PendaftaranMurid::find($this->editingId);
                
                if (!$pendaftaran || $pendaftaran->user_id != Auth::id()) {
                    $this->dispatch('alert', type: 'error', message: 'Data tidak ditemukan.');
                    return;
                }

                if ($pendaftaran->status !== 'pending') {
                    $this->dispatch('alert', type: 'error', message: 'Tidak dapat mengedit pendaftaran dengan status ' . $pendaftaran->status);
                    return;
                }

                $pendaftaran->update([
                    'jalur_pendaftaran_id' => $this->jalur_pendaftaran_id,
                    'tipe_sekolah_id' => $this->tipe_sekolah_id,
                    'jurusan_id' => $this->jurusan_id,
                ]);
                
                $message = 'Program studi berhasil diperbarui.';
                
            } else {
                // Buat pendaftaran baru
                $pendaftaran = PendaftaranMurid::create([
                    'user_id' => Auth::id(),
                    'jalur_pendaftaran_id' => $this->jalur_pendaftaran_id,
                    'tipe_sekolah_id' => $this->tipe_sekolah_id,
                    'jurusan_id' => $this->jurusan_id,
                    'status' => 'pending',
                ]);
                
                $message = 'Program studi berhasil ditambahkan.';
            }

            // Upload bukti prestasi jika ada dan jalur adalah Prestasi
            if ($this->isJalurPrestasi()) {
                $files = [
                    $this->bukti_prestasi_1,
                    $this->bukti_prestasi_2,
                    $this->bukti_prestasi_3,
                ];

                foreach ($files as $file) {
                    if ($file) {
                        // Simpan file
                        $path = $file->store('bukti-prestasi', 'public');
                        
                        // Simpan ke database
                        BuktiPrestasi::create([
                            'pendaftaran_murid_id' => $pendaftaran->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientOriginalExtension(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }

            // Upload bukti tahfidz jika ada dan jalur adalah Tahfidz Quran
            if ($this->isJalurTahfidz()) {
                $files = [
                    $this->bukti_tahfidz_1,
                    $this->bukti_tahfidz_2,
                    $this->bukti_tahfidz_3,
                ];

                foreach ($files as $file) {
                    if ($file) {
                        // Simpan file
                        $path = $file->store('bukti-tahfidz', 'public');
                        
                        // Simpan ke database
                        BuktiTahfidz::create([
                            'pendaftaran_murid_id' => $pendaftaran->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientOriginalExtension(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }

            $this->resetForm();
            $this->loadPendaftaranList();
            $this->dispatch('alert', type: 'success', message: $message);
            
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pendaftaran = PendaftaranMurid::find($id);
        
        if ($pendaftaran && $pendaftaran->user_id == Auth::id()) {
            if ($pendaftaran->status !== 'pending') {
                $this->dispatch('alert', type: 'error', message: 'Tidak dapat mengedit pendaftaran dengan status ' . $pendaftaran->status);
                return;
            }

            $this->editingId = $id;
            $this->jalur_pendaftaran_id = $pendaftaran->jalur_pendaftaran_id;
            $this->tipe_sekolah_id = $pendaftaran->tipe_sekolah_id;
            $this->jurusan_id = $pendaftaran->jurusan_id;
            
            // Load dependencies
            $this->tipes = TipeSekolah::all();
            $this->jurusans = Jurusan::where('tipe_sekolah_id', $this->tipe_sekolah_id)->get();
            
            // Load existing bukti
            $this->loadExistingBuktiPrestasi();
            $this->loadExistingBuktiTahfidz();
            
            // Reset new files
            $this->bukti_prestasi_1 = null;
            $this->bukti_prestasi_2 = null;
            $this->bukti_prestasi_3 = null;
            $this->bukti_tahfidz_1 = null;
            $this->bukti_tahfidz_2 = null;
            $this->bukti_tahfidz_3 = null;
        }
    }

    public function delete($id)
    {
        // Cek gelombang pendaftaran aktif terlebih dahulu
        $gelombangActive = GelombangPendaftaran::pendaftaranAktif()->first();
        
        if (!$gelombangActive || !$gelombangActive->isPendaftaranAktif()) {
            $this->dispatch('alert', type: 'error', message: 'Pendaftaran sudah ditutup. Tidak dapat menghapus program studi.');
            return;
        }

        $pendaftaran = PendaftaranMurid::find($id);
        
        if ($pendaftaran && $pendaftaran->user_id == Auth::id()) {
            if ($pendaftaran->status !== 'pending') {
                $this->dispatch('alert', type: 'error', message: 'Tidak dapat menghapus pendaftaran dengan status ' . $pendaftaran->status);
                return;
            }

            $pendaftaran->delete();
            $this->loadPendaftaranList();
            $this->dispatch('alert', type: 'success', message: 'Program studi berhasil dihapus.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'tipe_sekolah_id', 
            'jurusan_id', 
            'editingId', 
            'bukti_prestasi_1',
            'bukti_prestasi_2',
            'bukti_prestasi_3',
            'bukti_tahfidz_1',
            'bukti_tahfidz_2',
            'bukti_tahfidz_3',
            'existing_bukti_prestasi',
            'existing_bukti_tahfidz'
        ]);
        $this->jurusans = collect();
        
        // Jalur tetap dipilih jika sudah ada data
        if ($this->selectedJalur) {
            $this->jalur_pendaftaran_id = $this->selectedJalur->id;
            $this->tipes = TipeSekolah::all();
        }
    }

    public function render()
    {
        // Ambil gelombang yang sedang dalam periode pendaftaran
        $gelombangActive = GelombangPendaftaran::pendaftaranAktif()->first();
        
        return view('livewire.siswa.formulir.formulir-pendaftaran-page', [
            'gelombangActive' => $gelombangActive,
            'isJalurPrestasi' => $this->isJalurPrestasi(),
            'isJalurTahfidz' => $this->isJalurTahfidz()
        ]);
    }
}