<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\AlurPendaftaran;

class AlurPendaftaranSection extends Component
{
    public $steps = [];

    public function mount()
    {
        $this->loadSteps();
    }

    public function loadSteps()
    {
        $dbSteps = AlurPendaftaran::orderBy('order_num', 'asc')->get();

        if ($dbSteps->isNotEmpty()) {
            $this->steps = $dbSteps->toArray();
        } else {
            // Default fallback if database is empty
            $this->steps = [
                [
                    'title' => 'Daftar Akun',
                    'description' => 'Buat akun pendaftaran Anda untuk memulai perjalanan menjadi Lemdiklat Taruna Nusantara Indonesia.',
                    'icon' => 'user-plus',
                ],
                [
                    'title' => 'Isi Formulir',
                    'description' => 'Lengkapi formulir pendaftaran dengan data pribadi dan dokumen yang diperlukan.',
                    'icon' => 'document-text',
                ],
                [
                    'title' => 'Pilih Sekolah & Jurusan',
                    'description' => 'Tentukan pilihan sekolah dan jurusan yang sesuai dengan minat dan kemampuan Anda.',
                    'icon' => 'academic-cap',
                ],
                [
                    'title' => 'Download Surat Verifikasi',
                    'description' => 'Unduh surat verifikasi sebagai bukti pendaftaran yang telah berhasil diproses.',
                    'icon' => 'arrow-down-tray',
                ],
                [
                    'title' => 'Registrasi Pendaftaran',
                    'description' => 'Lakukan registrasi pendaftaran sesuai dengan ketentuan yang berlaku.',
                    'icon' => 'credit-card',
                ],
                [
                    'title' => 'Test Online',
                    'description' => 'Ikuti serangkaian tes online untuk mengukur kemampuan akademik dan potensi Anda.',
                    'icon' => 'computer-desktop',
                ],
                [
                    'title' => 'Penerimaan',
                    'description' => 'Terima pengumuman hasil seleksi dan bergabunglah dengan keluarga besar Lemdiklat Taruna Nusantara Indonesia.',
                    'icon' => 'check-badge',
                ],
            ];
        }
    }

    public function render()
    {
        return view('livewire.components.landing.alur-pendaftaran-section');
    }
}