<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BerkasMurid;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\CustomTestAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.siswa")]
#[Title("Panduan Pendaftaran")]
class PanduanPage extends Component
{
    public $steps = [];

    public function mount()
    {
        $this->calculateSteps();
    }

    public function calculateSteps()
    {
        $userId = Auth::id();

        // 4. Pilih Jalur (Pendaftaran) - Check this first for waterfall logic
        $pendaftaran = PendaftaranMurid::where('user_id', $userId)->latest()->first();
        $isRegistered = $pendaftaran != null;

        // 7. Pengumuman
        $isAnnounced = $pendaftaran && ($pendaftaran->status == 'diterima' || $pendaftaran->status == 'ditolak');

        // 6. Tes Seleksi
        $hasTests = CustomTestAnswer::where('user_id', $userId)->exists();
        $isTested = $hasTests || $isAnnounced; // If announced, tests are considered done/passed

        // 1. Data Siswa
        $dataMurid = DataMurid::where('user_id', $userId)->first();
        $step1 = ($dataMurid && !empty($dataMurid->tempat_lahir)) || $isRegistered;

        // 2. Data Orang Tua
        $dataOrangTua = DataOrangTua::where('user_id', $userId)->first();
        $step2 = ($dataOrangTua && !empty($dataOrangTua->nama_ayah)) || $isRegistered;

        // 3. Berkas
        $berkas = BerkasMurid::where('user_id', $userId)->first();
        // Check 'kk' field, not 'file_kk'. 
        $step3 = ($berkas && !empty($berkas->kk)) || $isRegistered;

        $step4 = $isRegistered;
        $step5 = $isTested;
        $step6 = $isAnnounced;

        $this->steps = [
            [
                'title' => 'Buat Akun',
                'desc' => 'Mendaftar akun siswa baru',
                'icon' => 'ri-user-add-line',
                'route' => null, 
                'status' => 'completed',
                'button' => 'Selesai'
            ],
            [
                'title' => 'Lengkapi Data Diri',
                'desc' => 'Isi biodata lengkap siswa',
                'icon' => 'ri-user-settings-line',
                'route' => 'siswa.formulir.data-murid',
                'status' => $step1 ? 'completed' : 'current',
                'button' => $step1 ? 'Lihat Data' : 'Isi Biodata'
            ],
            [
                'title' => 'Data Orang Tua',
                'desc' => 'Lengkapi informasi orang tua/wali',
                'icon' => 'ri-parent-line',
                'route' => 'siswa.formulir.data-orang-tua',
                'status' => $step2 ? 'completed' : ($step1 ? 'current' : 'pending'),
                'button' => $step2 ? 'Lihat Data' : 'Isi Data Ortu'
            ],
            [
                'title' => 'Upload Berkas',
                'desc' => 'Unggah KK, Akta, dan Ijazah',
                'icon' => 'ri-file-upload-line',
                'route' => 'siswa.formulir.berkas-murid',
                'status' => $step3 ? 'completed' : (($step1 && $step2) ? 'current' : 'pending'),
                'button' => $step3 ? 'Lihat Berkas' : 'Upload Berkas'
            ],
            [
                'title' => 'Pilih Jalur & Jurusan',
                'desc' => 'Tentukan jalur masuk dan jurusan',
                'icon' => 'ri-compass-3-line',
                'route' => 'siswa.pendaftaran',
                'status' => $step4 ? 'completed' : ($step3 ? 'current' : 'pending'),
                'button' => $step4 ? 'Lihat Jalur' : 'Pilih Jalur'
            ],
            [
                'title' => 'Tes Seleksi',
                'desc' => 'Kerjakan tes online jika tersedia',
                'icon' => 'ri-pencil-ruler-2-line',
                'route' => 'siswa.tests.index',
                'status' => $step5 ? 'completed' : ($step4 ? 'current' : 'pending'),
                'button' => 'Halaman Tes'
            ],
            [
                'title' => 'Hasil & Daftar Ulang',
                'desc' => 'Cek kelulusan dan cetak bukti',
                'icon' => 'ri-award-line',
                'route' => 'siswa.hasil-seleksi',
                'status' => $step6 ? 'completed' : ($step5 ? 'current' : 'pending'),
                'button' => 'Cek Hasil'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.siswa.panduan-page', [
            'steps' => $this->steps
        ]);
    }
}
