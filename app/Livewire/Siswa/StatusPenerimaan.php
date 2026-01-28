<?php

namespace App\Livewire\Siswa;

use App\Models\Landing\PDF;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Siswa\BuktiTransfer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.siswa")]
#[Title("Status Penerimaan")]
class StatusPenerimaan extends Component
{
    public $jalurData = [];
    public $pendaftaranList; // PENTING: Jangan gunakan type hint Object di Livewire
    public $hasAcceptedRegistration = false;
    public $buktiTransfer = null;
    public $canDownloadPenerimaanPDF = false;
    public $penerimaanPDFSettings = null;

    public $registrationStats = [
        'total' => 0,
        'pending' => 0,
        'diterima' => 0,
        'ditolak' => 0
    ];

    public function mount()
    {
        $this->loadPendaftaranData();
        $this->loadBuktiTransfer();
        $this->calculateRegistrationStats();
        $this->checkPDFDownloadAvailability();
    }

    public function loadBuktiTransfer()
    {
        $this->buktiTransfer = BuktiTransfer::where('user_id', Auth::id())->latest()->first();
    }

    public function getBuktiTransferStatus()
    {
        if (!$this->buktiTransfer) return 'belum_upload';
        
        return $this->buktiTransfer->status; // pending, diterima, ditolak
    }

    public function checkPDFDownloadAvailability()
    {
        // Check penerimaan PDF - bisa download jika ada status diterima
        $this->canDownloadPenerimaanPDF = $this->hasAcceptedRegistration;

        // Load PDF settings
        $this->penerimaanPDFSettings = PDF::getSettingsByJenis('penerimaan');
    }

    public function loadPendaftaranData()
    {
        // Ambil semua pendaftaran dengan detail
        $this->pendaftaranList = PendaftaranMurid::with(['jalurPendaftaran', 'tipeSekolah', 'jurusan'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Check if user has accepted registration
        $this->hasAcceptedRegistration = $this->pendaftaranList->where('status', 'diterima')->count() > 0;

        // Group by jalur pendaftaran untuk biaya
        $groupedByJalur = $this->pendaftaranList->groupBy('jalur_pendaftaran_id');

        $this->jalurData = [];

        foreach ($groupedByJalur as $jalurId => $pendaftaranGroup) {
            $firstPendaftaran = $pendaftaranGroup->first();
            
            // Format program studi
            $programStudi = [];
            foreach ($pendaftaranGroup as $pendaftaran) {
                $programStudi[] = [
                    'nama' => $pendaftaran->tipeSekolah->nama . ' - ' . $pendaftaran->jurusan->nama,
                    'status' => $pendaftaran->status,
                    'created_at' => $pendaftaran->created_at
                ];
            }

            $jalurBiaya = $firstPendaftaran->jalurPendaftaran->biaya;

            $this->jalurData[] = [
                'jalur' => $firstPendaftaran->jalurPendaftaran,
                'program_studi' => $programStudi,
                'biaya' => $jalurBiaya,
                'status_pembayaran' => $this->getBuktiTransferStatus()
            ];
        }
    }

    public function calculateRegistrationStats()
    {
        $this->registrationStats = [
            'total' => $this->pendaftaranList->unique("user_id")->count(),
            'pending' => $this->pendaftaranList->where('status', 'pending')->count(),
            'diterima' => $this->pendaftaranList->where('status', 'diterima')->count(),
            'ditolak' => $this->pendaftaranList->where('status', 'ditolak')->count()
        ];
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'gold',
            'diterima' => 'emerald',
            'ditolak' => 'danger',
            default => 'gray'
        };
    }

    public function getStatusText($status)
    {
        return match($status) {
            'pending' => 'Menunggu Verifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    // Method untuk refresh data (opsional, jika diperlukan)
    public function refreshData()
    {
        $this->loadPendaftaranData();
        $this->loadBuktiTransfer();
        $this->calculateRegistrationStats();
        $this->checkPDFDownloadAvailability();
        
        $this->dispatch('success', message: 'Data berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.siswa.status-penerimaan');
    }
}