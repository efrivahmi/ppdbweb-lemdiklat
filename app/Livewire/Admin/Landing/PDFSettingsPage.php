<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\PDF;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Setting PDF")]
class PDFSettingsPage extends Component
{
    use WithFileUploads;
    
    public $activeTab = 'verifikasi';
    public $editMode = false;
    public $selectedId = null;

    // Form properties
    public $jenis = 'verifikasi';
    public $nama_sekolah;
    public $alamat_sekolah;
    public $kecamatan;
    public $kabupaten;
    public $provinsi;
    public $kode_pos;
    public $email;
    public $telepon;
    public $website;
    public $logo_kiri;
    public $logo_kanan;
    public $judul_pdf;
    public $pesan_penting;
    public $nama_operator;
    public $jabatan_operator;
    public $catatan_tambahan;
    public $is_active = true;

    // File uploads
    public $newLogoKiri;
    public $newLogoKanan;
    
    // Preview
    public $selectedSiswaId = '';

    protected function rules()
    {
        return [
            'jenis' => 'required|in:verifikasi,penerimaan',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'website' => 'nullable|string|max:255',
            'judul_pdf' => 'required|string|max:255',
            'pesan_penting' => 'nullable|string',
            'nama_operator' => 'required|string|max:255',
            'jabatan_operator' => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string',
            'is_active' => 'required|boolean',
            'newLogoKiri' => 'nullable|image|max:2048',
            'newLogoKanan' => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'nama_sekolah.required' => 'Nama sekolah wajib diisi',
        'alamat_sekolah.required' => 'Alamat sekolah wajib diisi',
        'kecamatan.required' => 'Kecamatan wajib diisi',
        'kabupaten.required' => 'Kabupaten wajib diisi',
        'provinsi.required' => 'Provinsi wajib diisi',
        'kode_pos.required' => 'Kode pos wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'telepon.required' => 'Telepon wajib diisi',
        'judul_pdf.required' => 'Judul PDF wajib diisi',
        'nama_operator.required' => 'Nama operator wajib diisi',
        'jabatan_operator.required' => 'Jabatan operator wajib diisi',
        'newLogoKiri.image' => 'Logo kiri harus berupa gambar',
        'newLogoKiri.max' => 'Logo kiri maksimal 2MB',
        'newLogoKanan.image' => 'Logo kanan harus berupa gambar',
        'newLogoKanan.max' => 'Logo kanan maksimal 2MB',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->jenis = $tab;
        $this->selectedSiswaId = ''; // Reset selected siswa when switching tabs
        $this->loadData();
    }

    public function loadData()
    {
        $pdf = PDF::where('jenis', $this->jenis)->first();
        
        if ($pdf) {
            $this->selectedId = $pdf->id;
            $this->editMode = true;
            $this->nama_sekolah = $pdf->nama_sekolah;
            $this->alamat_sekolah = $pdf->alamat_sekolah;
            $this->kecamatan = $pdf->kecamatan;
            $this->kabupaten = $pdf->kabupaten;
            $this->provinsi = $pdf->provinsi;
            $this->kode_pos = $pdf->kode_pos;
            $this->email = $pdf->email;
            $this->telepon = $pdf->telepon;
            $this->website = $pdf->website;
            $this->logo_kiri = $pdf->logo_kiri;
            $this->logo_kanan = $pdf->logo_kanan;
            $this->judul_pdf = $pdf->judul_pdf;
            $this->pesan_penting = $pdf->pesan_penting;
            $this->nama_operator = $pdf->nama_operator;
            $this->jabatan_operator = $pdf->jabatan_operator;
            $this->catatan_tambahan = $pdf->catatan_tambahan;
            $this->is_active = $pdf->is_active;
        } else {
            $this->resetForm();
            $this->editMode = false;
        }
    }

    public function resetForm()
    {
        $this->selectedId = null;
        $this->nama_sekolah = '';
        $this->alamat_sekolah = '';
        $this->kecamatan = '';
        $this->kabupaten = '';
        $this->provinsi = '';
        $this->kode_pos = '';
        $this->email = '';
        $this->telepon = '';
        $this->website = '';
        $this->logo_kiri = '';
        $this->logo_kanan = '';
        $this->judul_pdf = '';
        $this->pesan_penting = '';
        $this->nama_operator = '';
        $this->jabatan_operator = '';
        $this->catatan_tambahan = '';
        $this->is_active = true;
        $this->newLogoKiri = null;
        $this->newLogoKanan = null;
        $this->selectedSiswaId = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'jenis' => $this->jenis,
                'nama_sekolah' => $this->nama_sekolah,
                'alamat_sekolah' => $this->alamat_sekolah,
                'kecamatan' => $this->kecamatan,
                'kabupaten' => $this->kabupaten,
                'provinsi' => $this->provinsi,
                'kode_pos' => $this->kode_pos,
                'email' => $this->email,
                'telepon' => $this->telepon,
                'website' => $this->website,
                'judul_pdf' => $this->judul_pdf,
                'pesan_penting' => $this->pesan_penting,
                'nama_operator' => $this->nama_operator,
                'jabatan_operator' => $this->jabatan_operator,
                'catatan_tambahan' => $this->catatan_tambahan,
                'is_active' => $this->is_active,
            ];

            // Handle logo kiri upload
            if ($this->newLogoKiri) {
                // Delete old logo if exists
                if ($this->logo_kiri && Storage::disk('public')->exists($this->logo_kiri)) {
                    Storage::disk('public')->delete($this->logo_kiri);
                }
                $data['logo_kiri'] = $this->newLogoKiri->store('pdf/logos', 'public');
            }

            // Handle logo kanan upload
            if ($this->newLogoKanan) {
                // Delete old logo if exists
                if ($this->logo_kanan && Storage::disk('public')->exists($this->logo_kanan)) {
                    Storage::disk('public')->delete($this->logo_kanan);
                }
                $data['logo_kanan'] = $this->newLogoKanan->store('pdf/logos', 'public');
            }

            if ($this->editMode) {
                $pdf = PDF::findOrFail($this->selectedId);
                $pdf->update($data);
                $message = 'Pengaturan PDF ' . ucfirst($this->jenis) . ' berhasil diperbarui';
            } else {
                PDF::create($data);
                $message = 'Pengaturan PDF ' . ucfirst($this->jenis) . ' berhasil disimpan';
            }

            $this->dispatch("alert", message: $message, type: "success");

            $this->loadData();
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "terjadi error.", type: "error");
        }
    }

    public function deleteLogo($type)
    {
        if ($type === 'kiri' && $this->logo_kiri) {
            Storage::disk('public')->delete($this->logo_kiri);
            PDF::where('id', $this->selectedId)->update(['logo_kiri' => null]);
            $this->logo_kiri = null;
        } elseif ($type === 'kanan' && $this->logo_kanan) {
            Storage::disk('public')->delete($this->logo_kanan);
            PDF::where('id', $this->selectedId)->update(['logo_kanan' => null]);
            $this->logo_kanan = null;
        }
        
        $this->dispatch("alert", message: "Logo berhasil dihapus", type: "success");
    }

    public function previewPDF()
    {
        if (empty($this->selectedSiswaId)) {
                        $this->dispatch("alert", message: "Pilih siswa terlebih dahulu", type: "info");

            return;
        }

        // Validasi bahwa siswa tersebut memenuhi kriteria
        $siswa = $this->getSiswaById($this->selectedSiswaId);
        if (!$siswa) {
                        $this->dispatch("alert", message: "Siswa tidak ada atau tidak memenuhi kriteria", type: "warning");

            return;
        }

        // Redirect ke preview URL
        if ($this->activeTab === 'verifikasi') {
            return redirect()->route('admin.pdf.preview.verifikasi', $this->selectedSiswaId);
        } else {
            return redirect()->route('admin.pdf.preview.penerimaan', $this->selectedSiswaId);
        }
    }

    public function getSiswaById($siswaId)
    {
        if ($this->activeTab === 'verifikasi') {
            // Untuk verifikasi, ambil semua siswa yang punya data pendaftaran
            return User::with(['dataMurid', 'dataOrangTua', 'pendaftaranMurids'])
                ->where('role', 'siswa')
                ->where('id', $siswaId)
                ->whereHas('pendaftaranMurids')
                ->first();
        } else {
            // Untuk penerimaan, hanya siswa yang diterima
            return User::with(['dataMurid', 'dataOrangTua', 'pendaftaranMurids'])
                ->where('role', 'siswa')
                ->where('id', $siswaId)
                ->whereHas('pendaftaranMurids', function($query) {
                    $query->where('status', 'diterima');
                })
                ->first();
        }
    }

    public function getAvailableSiswa()
    {
        if ($this->activeTab === 'verifikasi') {
            // Untuk verifikasi, ambil semua siswa yang punya data pendaftaran
            return User::with(['dataMurid', 'dataOrangTua', 'pendaftaranMurids'])
                ->where('role', 'siswa')
                ->whereHas('pendaftaranMurids')
                ->orderBy('name')
                ->get();
        } else {
            // Untuk penerimaan, hanya siswa yang diterima
            return User::with(['dataMurid', 'dataOrangTua', 'pendaftaranMurids'])
                ->where('role', 'siswa')
                ->whereHas('pendaftaranMurids', function($query) {
                    $query->where('status', 'diterima');
                })
                ->orderBy('name')
                ->get();
        }
    }

    public function getCurrentPDFData()
    {
        return PDF::where('jenis', $this->activeTab)->first();
    }

    public function render()
    {
        $currentPDF = $this->getCurrentPDFData();
        $availableSiswa = $this->getAvailableSiswa();
        
        return view('livewire.admin.landing.pdf-settings-page', [
            'currentPDF' => $currentPDF,
            'availableSiswa' => $availableSiswa
        ]);
    }
}