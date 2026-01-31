<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BerkasMurid;
use App\Models\Siswa\BuktiTransfer;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Pendaftaran\TesJalur;
use App\Models\BankAccount;
use App\Models\User;
use App\Models\Landing\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout("layouts.siswa")]
#[Title("Dashboard")]
class Dashboard extends Component
{
    use WithFileUploads;

    public $transfer_picture;
    public $atas_nama;
    public $no_rek;
    public $dataMuridProgress = 0;
    public $dataOrangTuaProgress = 0;
    public $berkasMuridProgress = 0;
    public $pendaftaranProgress = 0;
    public $overallProgress = 0;
    public $statusPembayaran = "pending";

    public $jalurData = [];
    public Object $pendaftaranList;
    public $buktiTransfer = null;
    public $canUploadPayment = false;
    public $bankAccounts = [];
    public $adminContacts = [];

    // PDF related properties
    public $canDownloadVerifikasiPDF = false;
    public $canDownloadPenerimaanPDF = false;
    public $verifikasiPDFSettings = null;
    public $penerimaanPDFSettings = null;
    public $hasAcceptedRegistration = false;

    public $registrationStats = [
        'total' => 0,
        'pending' => 0,
        'diterima' => 0,
        'ditolak' => 0
    ];
    public $registrationTotalStat = 0;
    public $availableTests = [];
    public $testsStats = [
        'total' => 0,
        'completed' => 0,
        'pending' => 0
    ];

    // Onboarding Tour
    public $hasSeenTour = true;

    public function mount()
    {
        $this->calculateProgress();
        $this->loadPendaftaranData();
        $this->loadBuktiTransfer();
        $this->checkCanUploadPayment();
        $this->calculateRegistrationStats();
        $this->loadAvailableTests();
        $this->calculateTestsStats();
        $this->loadBankAccounts();
        $this->loadAdminContacts();
        $this->checkPDFDownloadAvailability();
        
        // Check if user has seen the tour
        $this->hasSeenTour = Auth::user()->has_seen_tour ?? false;
    }

    /**
     * Mark tour as complete
     */
    public function markTourComplete()
    {
        $user = Auth::user();
        $user->has_seen_tour = true;
        $user->save();
        $this->hasSeenTour = true;
    }

    public function loadBankAccounts()
    {
        $this->bankAccounts = BankAccount::orderBy('bank_name')->get();
    }

    public function loadAdminContacts()
    {
        $this->adminContacts = User::where('role', 'admin')
            ->select('id', 'name', 'email', 'telp')
            ->orderBy('name')
            ->get();
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

        // Progress Pendaftaran - Update logic
        $pendaftaranCount = PendaftaranMurid::where('user_id', $userId)->count();
        // Minimal 1 pendaftaran untuk 100%, maksimal untuk 2 jalur
        $this->pendaftaranProgress = $pendaftaranCount > 0 ? min(($pendaftaranCount / 1) * 100, 100) : 0;

        // Overall Progress
        $this->overallProgress = ($this->dataMuridProgress + $this->dataOrangTuaProgress +
            $this->berkasMuridProgress + $this->pendaftaranProgress) / 4;
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

            // Tambah ke total biaya (hanya 1x per jalur)
        }
    }

    public function calculateRegistrationStats()
    {
        $this->registrationStats = [
            'total' => $this->pendaftaranList->unique('user_id')->count(),
            'pending' => $this->pendaftaranList->where('status', 'pending')->count(),
            'diterima' => $this->pendaftaranList->where('status', 'diterima')->count(),
            'ditolak' => $this->pendaftaranList->where('status', 'ditolak')->count()
        ];
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

    public function checkCanUploadPayment()
    {
        $this->canUploadPayment = $this->dataMuridProgress >= 100 &&
            $this->dataOrangTuaProgress >= 100 &&
            $this->berkasMuridProgress >= 100 &&
            $this->pendaftaranProgress >= 100;
    }

    public function checkPDFDownloadAvailability()
    {
        // Check verifikasi PDF - bisa download jika:
        // 1. Semua data lengkap (dataMurid, dataOrangTua, berkasMurid, pendaftaran)
        // 2. Semua test jalur sudah dikerjakan (bukan payment)
        $allTestsCompleted = count($this->availableTests) > 0 && 
            collect($this->availableTests)->every(fn($test) => $test['has_completed']);

        $this->canDownloadVerifikasiPDF = $this->dataMuridProgress >= 100 &&
            $this->dataOrangTuaProgress >= 100 &&
            $this->berkasMuridProgress >= 100 &&
            $this->pendaftaranProgress >= 100 &&
            $allTestsCompleted;

        // Check penerimaan PDF - bisa download jika ada status diterima
        $this->canDownloadPenerimaanPDF = $this->hasAcceptedRegistration;

        // Load PDF settings
        $this->verifikasiPDFSettings = PDF::getSettingsByJenis('verifikasi');
        $this->penerimaanPDFSettings = PDF::getSettingsByJenis('penerimaan');
    }

    public function uploadBuktiTransfer()
    {
        $this->validate([
            'transfer_picture' => 'required|image|max:2048',
            'atas_nama' => "required|string",
            "no_rek" => "required|string",
        ]);

        if ($this->buktiTransfer) {
            // Update existing
            if ($this->buktiTransfer->transfer_picture && Storage::disk('public')->exists($this->buktiTransfer->transfer_picture)) {
                Storage::disk('public')->delete($this->buktiTransfer->transfer_picture);
            }

            $path = $this->transfer_picture->store('bukti_transfer', 'public');
            $this->buktiTransfer->update([
                'transfer_picture' => $path,
                'status' => 'pending'
            ]);
        } else {
            // Create new
            $path = $this->transfer_picture->store('bukti_transfer', 'public');
            BuktiTransfer::create([
                'user_id' => Auth::id(),
                'transfer_picture' => $path,
                'atas_nama' => $this->atas_nama,
                'no_rek' => $this->no_rek,
                'status' => 'pending'
            ]);
        }

        $this->loadPendaftaranData(); // Refresh data
        $this->loadBuktiTransfer();
        $this->transfer_picture = null;
        $this->dispatch("alert", message: "Bukti transfer di upload", type: "success");
    }

    public function deleteBuktiTransfer()
    {
        if ($this->buktiTransfer) {
            if (Storage::disk('public')->exists($this->buktiTransfer->transfer_picture)) {
                Storage::disk('public')->delete($this->buktiTransfer->transfer_picture);
            }
            $this->buktiTransfer->delete();
            $this->buktiTransfer = null;
            $this->loadPendaftaranData(); // Refresh data
            $this->dispatch("alert", message: "Bukti transfer di hapus", type: "success");
        }
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'pending' => 'gold',
            'diterima' => 'emerald',
            'ditolak' => 'danger',
            default => 'gray'
        };
    }

    public function getStatusText($status)
    {
        return match ($status) {
            'pending' => 'Menunggu Verifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
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

        // Ambil semua tes jalur untuk jalur pendaftaran user
        $tesJalurs = TesJalur::with(['customTests.questions'])
            ->where('jalur_pendaftaran_id', $userRegistration->jalur_pendaftaran_id)
            ->get();

        $this->availableTests = [];

        foreach ($tesJalurs as $tesJalur) {
            foreach ($tesJalur->customTests as $customTest) {
                if ($customTest->is_active) {
                    // Cek apakah user sudah mengerjakan test ini
                    $hasCompleted = CustomTestAnswer::where('user_id', Auth::id())
                        ->where('custom_test_id', $customTest->id)
                        ->exists();

                    $score = null;
                    if ($hasCompleted) {
                        $allAnswers = CustomTestAnswer::where('user_id', Auth::id())
                            ->where('custom_test_id', $customTest->id)
                            ->with('customTestQuestion')
                            ->get();

                        $totalCorrect = $allAnswers->where('is_correct', true)->count();
                        $totalReviewed = $allAnswers->whereIn('is_correct', [true, false])->count();
                        $essayPending = $allAnswers->filter(function ($answer) {
                            return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct === null;
                        })->count();

                        $score = [
                            'total_correct' => $totalCorrect,
                            'total_reviewed' => $totalReviewed,
                            'essay_pending' => $essayPending,
                            'percentage' => $totalReviewed > 0 ? ($totalCorrect / $totalReviewed) * 100 : 0
                        ];
                    }

                    $this->availableTests[] = [
                        'test' => $customTest,
                        'tes_jalur' => $tesJalur,
                        'has_completed' => $hasCompleted,
                        'score' => $score,
                        'question_count' => $customTest->questions->count()
                    ];
                }
            }
        }
    }

    public function calculateTestsStats()
    {
        $this->testsStats = [
            'total' => count($this->availableTests),
            'completed' => collect($this->availableTests)->where('has_completed', true)->count(),
            'pending' => collect($this->availableTests)->where('has_completed', false)->count()
        ];
    }

    public function getListeners()
    {
        $userId = Auth::id();
        return [
            "echo-private:user.{$userId},.pendaftaran.status.updated" => 'refreshData',
            "echo-private:user.{$userId},.payment.verified" => 'refreshData',
            "refresh-dashboard" => 'refreshData'
        ];
    }

    // Method untuk refresh semua data (dipanggil setelah ada perubahan status)
    #[On('refresh-dashboard')]
    public function refreshData()
    {
        $this->calculateProgress();
        $this->loadPendaftaranData();
        $this->calculateRegistrationStats();
        $this->checkPDFDownloadAvailability();
        $this->checkCanUploadPayment();
        $this->calculateTestsStats();
    }

    public function render()
    {
        return view('livewire.siswa.dashboard');
    }
}
