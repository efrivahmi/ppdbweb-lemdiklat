<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Siswa\BuktiTransfer;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BerkasMurid;
use Livewire\Component;
use Carbon\Carbon;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
#[Layout("layouts.admin")]
#[Title("Dashboard")]
class Dashboard extends Component
{
    public $totalStats = [
        'total_siswa' => 0,
        'total_pendaftaran' => 0,
        'total_jalur' => 0,
        'total_tests' => 0
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

    public $completionStats = [
        'data_murid' => 0,
        'data_orang_tua' => 0,
        'berkas_murid' => 0,
        'pendaftaran' => 0
    ];

    public $jalurPendaftaranData = [];
    public $recentActivities = [];
    public $monthlyRegistrations = [];

    public function mount()
    {
        $this->loadTotalStats();
        $this->loadPendaftaranStats();
        $this->loadBuktiTransferStats();
        $this->loadCompletionStats();
        $this->loadJalurPendaftaranData();
        $this->loadRecentActivities();
        $this->loadMonthlyRegistrations();
    }

    public function loadTotalStats()
    {
        $this->totalStats = [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_pendaftaran' => PendaftaranMurid::count(),
            'total_jalur' => JalurPendaftaran::count(),
            'total_tests' => CustomTest::where('is_active', true)->count()
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


    public function loadCompletionStats()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        
        if ($totalSiswa > 0) {
            // Hitung Data Murid yang LENGKAP (semua field penting terisi)
            $dataMuridLengkap = DataMurid::whereNotNull('tempat_lahir')
                ->whereNotNull('tgl_lahir')
                ->whereNotNull('jenis_kelamin')
                ->whereNotNull('agama')
                ->whereNotNull('whatsapp')
                ->whereNotNull('alamat')
                ->whereNotNull('asal_sekolah')
                ->whereNotNull('berat_badan')
                ->whereNotNull('tinggi_badan')
                ->count();

            // Hitung Data Orang Tua yang LENGKAP (minimal data ayah dan ibu ada)
            $dataOrangTuaLengkap = DataOrangTua::whereNotNull('nama_ayah')
                ->whereNotNull('pekerjaan_ayah')
                ->whereNotNull('telp_ayah')
                ->whereNotNull('alamat_ayah')
                ->whereNotNull('penghasilan_ayah')
                ->whereNotNull('nama_ibu')
                ->whereNotNull('pekerjaan_ibu')
                ->whereNotNull('telp_ibu')
                ->whereNotNull('alamat_ibu')
                ->whereNotNull('penghasilan_ibu')
                ->count();

            // Hitung Berkas Murid yang LENGKAP (semua file sudah diupload)
            $berkasMuridLengkap = BerkasMurid::whereNotNull('kk')
                ->whereNotNull('ktp_ortu')
                ->whereNotNull('akte')
                ->whereNotNull('surat_sehat')
                ->whereNotNull('pas_foto')
                ->where('proses', 1)
                ->count();

            // Hitung siswa yang sudah melakukan pendaftaran
            $pendaftaranLengkap = User::where('role', 'siswa')
                ->whereHas('pendaftaranMurids')
                ->count();

            $this->completionStats = [
                'data_murid' => round(($dataMuridLengkap / $totalSiswa) * 100, 1),
                'data_orang_tua' => round(($dataOrangTuaLengkap / $totalSiswa) * 100, 1),
                'berkas_murid' => round(($berkasMuridLengkap / $totalSiswa) * 100, 1),
                'pendaftaran' => round(($pendaftaranLengkap / $totalSiswa) * 100, 1),
                // Tambahan untuk detail
                'data_murid_count' => $dataMuridLengkap,
                'data_orang_tua_count' => $dataOrangTuaLengkap,
                'berkas_murid_count' => $berkasMuridLengkap,
                'pendaftaran_count' => $pendaftaranLengkap,
                'total_siswa' => $totalSiswa
            ];
        } else {
            $this->completionStats = [
                'data_murid' => 0,
                'data_orang_tua' => 0,
                'berkas_murid' => 0,
                'pendaftaran' => 0,
                'data_murid_count' => 0,
                'data_orang_tua_count' => 0,
                'berkas_murid_count' => 0,
                'pendaftaran_count' => 0,
                'total_siswa' => 0
            ];
        }
    }

    public function loadJalurPendaftaranData()
    {
        $jalurs = JalurPendaftaran::all();

        $this->jalurPendaftaranData = $jalurs->map(function($jalur) {
            // Hitung distinct user per jalur (tidak peduli berapa jurusan yang dipilih)
            $totalPendaftar = PendaftaranMurid::where('jalur_pendaftaran_id', $jalur->id)
                ->distinct('user_id')
                ->count();
            
            // Hitung status berdasarkan distinct user juga
            $pendingUsers = PendaftaranMurid::where('jalur_pendaftaran_id', $jalur->id)
                ->where('status', 'pending')
                ->distinct('user_id')
                ->count();
                
            $diterimaUsers = PendaftaranMurid::where('jalur_pendaftaran_id', $jalur->id)
                ->where('status', 'diterima')
                ->distinct('user_id')
                ->count();
                
            $ditolakUsers = PendaftaranMurid::where('jalur_pendaftaran_id', $jalur->id)
                ->where('status', 'ditolak')
                ->distinct('user_id')
                ->count();
            
            return [
                'jalur' => $jalur,
                'total_pendaftar' => $totalPendaftar,
                'pending' => $pendingUsers,
                'diterima' => $diterimaUsers,
                'ditolak' => $ditolakUsers,
                'biaya_total' => $totalPendaftar * $jalur->biaya
            ];
        })->toArray();
    }

    public function loadRecentActivities()
    {
        // Recent Pendaftaran
        $recentPendaftaran = PendaftaranMurid::with(['user', 'jalurPendaftaran'])
            ->latest()
            ->limit(5)
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
            ->limit(5)
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
        $recentAnswers = CustomTestAnswer::whereHas('customTestQuestion', function($query) {
            $query->where('tipe_soal', 'text');
        })
        ->with(['user', 'customTest'])
        ->latest()
        ->limit(5)
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
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            // Count distinct users per month instead of total PendaftaranMurid records
            $count = PendaftaranMurid::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->distinct('user_id')
                ->count('user_id');

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

    public function getStatusText($status)
    {
        return match($status) {
            'pending' => 'Pending',
            'success' => 'Diterima',
            'decline' => 'Ditolak',
            'reviewed' => 'Direview',
            default => 'Unknown'
        };
    }

    #[On('refresh-dashboard')]
    public function refreshData()
    {
        $this->loadTotalStats();
        $this->loadPendaftaranStats();
        $this->loadBuktiTransferStats();
        $this->loadCompletionStats();
        $this->loadJalurPendaftaranData();
        $this->loadRecentActivities();
        $this->loadMonthlyRegistrations();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}