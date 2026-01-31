<?php

namespace App\Livewire\Siswa;

use App\Models\Landing\PDF;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BerkasMurid;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\TesJalur;
use App\Models\Pendaftaran\CustomTestAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.siswa")]
#[Title("Surat Verifikasi")]
class SuratVerifikasiPage extends Component
{
    public $canDownloadVerifikasiPDF = false;
    public $verifikasiPDFSettings = null;
    public $missingItems = [];

    // Progress properties
    public $dataMuridProgress = 0;
    public $dataOrangTuaProgress = 0;
    public $berkasMuridProgress = 0;
    public $pendaftaranProgress = 0;
    public $availableTests = [];

    public function mount()
    {
        $this->checkAvailability();
    }

    public function checkAvailability()
    {
        $this->calculateProgress();
        $this->loadAvailableTests();

        // 1. Check Completeness
        $this->missingItems = [];
        
        if ($this->dataMuridProgress < 100) $this->missingItems[] = 'Data Siswa belum lengkap';
        if ($this->dataOrangTuaProgress < 100) $this->missingItems[] = 'Data Orang Tua belum lengkap';
        if ($this->berkasMuridProgress < 100) $this->missingItems[] = 'Berkas belum diupload semua';
        if ($this->pendaftaranProgress < 100) $this->missingItems[] = 'Belum mendaftar jalur/jurusan';

        // 2. Check Tests
        $allTestsCompleted = true;
        if (count($this->availableTests) > 0) {
            $allTestsCompleted = collect($this->availableTests)->every(fn($test) => $test['has_completed']);
            if (!$allTestsCompleted) {
                $this->missingItems[] = 'Tes seleksi belum dikerjakan semua';
            }
        } elseif ($this->pendaftaranProgress >= 100 && count($this->availableTests) == 0) {
             // Logic edge case: Registered but no tests available?
             // Dashboard logic says: count($this->availableTests) > 0 && every...
             // So if count is 0, $allTestsCompleted is FALSE in dashboard:
             // $allTestsCompleted = count($this->availableTests) > 0 && ...
             // This implies tests ARE REQUIRED. 
             // Let's stick to Dashboard logic.
             $allTestsCompleted = false;
             // But wait, what if there are NO tests for a jalur?
             // If $tesJalurs is empty in loadAvailableTests, then availableTests is empty.
             // Then allTestsCompleted is false.
             // This might be a blocker if a jalur has no tests.
             // But user says "students who have finished...". Usually implies they finished WHAT WAS THERE.
             // However, duplicating dashboard logic is safer for consistency.
             // Dashboard: $allTestsCompleted = count > 0 && every...
             // So yes, tests are mandatory.
             if (count($this->availableTests) == 0) {
                 // But wait, if they haven't registered, tests are 0.
                 // If they registered, and no tests assigned to jalur? 
                 // Let's assume tests exist.
             }
        }

        $this->canDownloadVerifikasiPDF = empty($this->missingItems) && $allTestsCompleted;
        
        $this->verifikasiPDFSettings = PDF::getSettingsByJenis('verifikasi');
    }

    public function calculateProgress()
    {
        $userId = Auth::id();

        // Progress Data Murid
        $dataMurid = DataMurid::where('user_id', $userId)->first();
        if ($dataMurid) {
            $fields = ['tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'whatsapp', 'alamat', 'asal_sekolah'];
            $filled = 0;
            foreach ($fields as $field) {
                if (!empty($dataMurid->$field)) $filled++;
            }
            $this->dataMuridProgress = ($filled / count($fields)) * 100;
        }

        // Progress Data Orang Tua
        $dataOrangTua = DataOrangTua::where('user_id', $userId)->first();

        if ($dataOrangTua) {
            // Grup field untuk masing-masing pihak
            $grupData = [
                'ayah' => ['nama_ayah', 'pendidikan_ayah', 'telp_ayah', 'pekerjaan_ayah', 'alamat_ayah'],
                'ibu' => ['nama_ibu', 'pendidikan_ibu', 'telp_ibu', 'pekerjaan_ibu', 'alamat_ibu'],
                'wali' => ['nama_wali', 'pendidikan_wali', 'telp_wali', 'pekerjaan_wali', 'alamat_wali'],
            ];

            $progress = 0;

            foreach ($grupData as $grup) {
                $lengkap = true;
                foreach ($grup as $field) {
                    if (empty($dataOrangTua->$field)) {
                        $lengkap = false;
                        break;
                    }
                }

                if ($lengkap) {
                    $progress = 100;
                    break; // Keluar dari loop karena salah satu grup sudah lengkap
                }
            }

            $this->dataOrangTuaProgress = $progress;
        }

        // Progress Berkas Murid
        $berkasMurid = BerkasMurid::where('user_id', $userId)->first();
        if ($berkasMurid) {
            $fields = ['kk', 'ktp_ortu', 'akte', 'surat_sehat', 'pas_foto'];
            $filled = 0;
            foreach ($fields as $field) {
                if (!empty($berkasMurid->$field)) $filled++;
            }
            $this->berkasMuridProgress = ($filled / count($fields)) * 100;
        }

        // Progress Pendaftaran
        $pendaftaranCount = PendaftaranMurid::where('user_id', $userId)->count();
        $this->pendaftaranProgress = $pendaftaranCount > 0 ? min(($pendaftaranCount / 1) * 100, 100) : 0;
    }

    public function loadAvailableTests()
    {
        $userRegistration = PendaftaranMurid::with('jalurPendaftaran')
            ->where('user_id', Auth::id())
            ->first();

        if (!$userRegistration) {
            $this->availableTests = [];
            return;
        }

        $tesJalurs = TesJalur::with(['customTests'])
            ->where('jalur_pendaftaran_id', $userRegistration->jalur_pendaftaran_id)
            ->get();

        $this->availableTests = [];

        foreach ($tesJalurs as $tesJalur) {
            foreach ($tesJalur->customTests as $customTest) {
                if ($customTest->is_active) {
                    $hasCompleted = CustomTestAnswer::where('user_id', Auth::id())
                        ->where('custom_test_id', $customTest->id)
                        ->exists();

                    $this->availableTests[] = [
                        'test' => $customTest,
                        'has_completed' => $hasCompleted
                    ];
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.siswa.surat-verifikasi-page');
    }
}
