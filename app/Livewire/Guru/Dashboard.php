<?php

namespace App\Livewire\Guru;

use App\Models\User;
use App\Models\GuruDocument;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Siswa\BuktiTransfer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.guru")]
#[Title("Dashboard")]
class Dashboard extends Component
{
    use WithFileUploads;
    public $totalStats = [
        'total_siswa' => 0,
        'total_pendaftaran' => 0,
        'total_tests' => 0,
        'total_admin' => 0
    ];

    public $pendaftaranStats = [
        'pending' => 0,
        'diterima' => 0,
        'ditolak' => 0
    ];

    public $buktiTransferStats = [
        'pending' => 0,
        'diterima' => 0,
        'ditolak' => 0
    ];

    public $testReviewStats = [
        'total_answers' => 0,
        'pending_review' => 0,
        'reviewed' => 0
    ];

    public $recentActivities = [];
    public $monthlyRegistrations = [];

    // Document upload properties
    public $document_name;
    public $document_type;
    public $file;
    public $documents = [];
    public $showUploadForm = false;

    protected $rules = [
        'document_name' => 'required|string|max:255',
        'document_type' => 'required|in:cv,sertifikat,surat_lamaran,ijazah,transkrip,lainnya',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ];

    public function mount()
    {
        if (auth()->user()->isGuru()) {
            $this->loadDocuments();
            // Load stats for guru based on their mapel
            if (auth()->user()->mapel_id) {
                $this->loadTestReviewStats();
                $this->loadRecentActivities();
            }
        } else {
            $this->loadTotalStats();
            $this->loadPendaftaranStats();
            $this->loadBuktiTransferStats();
            $this->loadTestReviewStats();
            $this->loadRecentActivities();
            $this->loadMonthlyRegistrations();
        }
    }

    public function loadTotalStats()
    {
        $this->totalStats = [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_pendaftaran' => PendaftaranMurid::count(),
            'total_tests' => CustomTest::where('is_active', true)->count(),
            'total_admin' => User::where('role', 'admin')->count()
        ];
    }

    public function loadPendaftaranStats()
    {
        $this->pendaftaranStats = [
            'pending' => PendaftaranMurid::where('status', 'pending')->count(),
            'diterima' => PendaftaranMurid::where('status', 'diterima')->count(),
            'ditolak' => PendaftaranMurid::where('status', 'ditolak')->count()
        ];
    }

    public function loadBuktiTransferStats()
    {
        $this->buktiTransferStats = [
            'pending' => BuktiTransfer::where('status', 'pending')->count(),
            'diterima' => BuktiTransfer::where('status', 'success')->count(),
            'ditolak' => BuktiTransfer::where('status', 'decline')->count()
        ];
    }

    public function loadTestReviewStats()
    {
        $baseQuery = CustomTestAnswer::whereHas('customTestQuestion', function($query) {
            $query->where('tipe_soal', 'text');
        });

        // Filter by guru's mapel if guru is logged in
        if (auth()->user()->isGuru() && auth()->user()->mapel_id) {
            $baseQuery->whereHas('customTest', function($query) {
                $query->where('mapel_id', auth()->user()->mapel_id);
            });
        }

        $this->testReviewStats = [
            'total_answers' => (clone $baseQuery)->count(),
            'pending_review' => (clone $baseQuery)->whereNull('is_correct')->count(),
            'reviewed' => (clone $baseQuery)->whereNotNull('is_correct')->count()
        ];
    }

    public function loadRecentActivities()
    {
        // Recent Pendaftaran
        $recentPendaftaran = PendaftaranMurid::with(['user', 'jalurPendaftaran'])
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($pendaftaran) {
                return [
                    'type' => 'pendaftaran',
                    'title' => $pendaftaran->user->name . ' mendaftar',
                    'description' => $pendaftaran->jalurPendaftaran->nama,
                    'time' => $pendaftaran->created_at,
                    'status' => $pendaftaran->status
                ];
            });

        // Recent Bukti Transfer
        $recentTransfer = BuktiTransfer::with('user')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($transfer) {
                return [
                    'type' => 'payment',
                    'title' => $transfer->user->name . ' upload bukti transfer',
                    'description' => 'Status: ' . ucfirst($transfer->status),
                    'time' => $transfer->created_at,
                    'status' => $transfer->status
                ];
            });

        // Recent Test Answers
        $recentAnswersQuery = CustomTestAnswer::whereHas('customTestQuestion', function($query) {
            $query->where('tipe_soal', 'text');
        });

        // Filter by guru's mapel if guru is logged in
        if (auth()->user()->isGuru() && auth()->user()->mapel_id) {
            $recentAnswersQuery->whereHas('customTest', function($query) {
                $query->where('mapel_id', auth()->user()->mapel_id);
            });
        }

        $recentAnswers = $recentAnswersQuery
            ->with(['user', 'customTest'])
            ->latest()
            ->limit(4)
            ->get()
            ->map(function($answer) {
                return [
                    'type' => 'test',
                    'title' => $answer->user->name . ' mengerjakan test',
                    'description' => $answer->customTest->nama_test,
                    'time' => $answer->completed_at ?? $answer->created_at,
                    'status' => $answer->is_correct === null ? 'pending' : 'reviewed'
                ];
            });

        $this->recentActivities = $recentPendaftaran
            ->merge($recentTransfer)
            ->merge($recentAnswers)
            ->sortByDesc('time')
            ->take(10)
            ->values()
            ->toArray();
    }

    public function loadMonthlyRegistrations()
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = PendaftaranMurid::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $months->push([
                'month' => $date->format('M Y'),
                'count' => $count
            ]);
        }

        $this->monthlyRegistrations = $months->toArray();
    }

    public function getActivityIcon($type)
    {
        return match($type) {
            'pendaftaran' => 'ri-user-add-line',
            'payment' => 'ri-money-dollar-circle-line',
            'test' => 'ri-file-text-line',
            default => 'ri-information-line'
        };
    }

    public function getActivityColor($type)
    {
        return match($type) {
            'pendaftaran' => 'blue',
            'payment' => 'green',
            'test' => 'purple',
            default => 'gray'
        };
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'gold',
            'diterima' => 'emerald',
            'ditolak' => 'danger',
            'reviewed' => 'sky',
            default => 'gray'
        };
    }

    public function loadDocuments()
    {
        $this->documents = auth()->user()
            ->guru_documents()
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function toggleUploadForm()
    {
        $this->showUploadForm = !$this->showUploadForm;
        if (!$this->showUploadForm) {
            $this->reset(['document_name', 'document_type', 'file']);
        }
    }

    public function uploadDocument()
    {
        $this->validate();

        $filePath = $this->file->store('guru-documents', 'public');

        GuruDocument::create([
            'guru_id' => auth()->id(),
            'document_name' => $this->document_name,
            'document_type' => $this->document_type,
            'file_path' => $filePath,
            'status' => 'pending'
        ]);

        session()->flash('success', 'Dokumen berhasil diupload!');

        $this->reset(['document_name', 'document_type', 'file', 'showUploadForm']);
        $this->loadDocuments();
    }

    public function deleteDocument($id)
    {
        $document = GuruDocument::where('id', $id)
            ->where('guru_id', auth()->id())
            ->first();

        if ($document) {
            \Storage::disk('public')->delete($document->file_path);
            $document->delete();

            session()->flash('success', 'Dokumen berhasil dihapus!');
            $this->loadDocuments();
        }
    }

    public function render()
    {
        return view('livewire.guru.dashboard');
    }
}
