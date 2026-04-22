<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\Jurusan;
use App\Models\Pendaftaran\JalurPendaftaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Rekapitulasi PPDB')]
class Recapitulation extends Component
{
    public $filterPeriod = 'all';

    public function updatedFilterPeriod()
    {
        // Component will re-render automatically
    }

    private function applyDateFilter($query)
    {
        $now = now();
        return match($this->filterPeriod) {
            'this_semester' => $query->where('created_at', '>=', $now->copy()->subMonths(6)),
            'last_semester' => $query->whereBetween('created_at', [$now->copy()->subMonths(12), $now->copy()->subMonths(6)]),
            'this_month'    => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
            'last_month'    => $query->whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year),
            default         => $query
        };
    }

    public function render()
    {
        // 1. Global Statistic Recap
        $totalAccounts = $this->applyDateFilter(User::where('role', 'siswa'))->count();
        $totalApplicants = $this->applyDateFilter(PendaftaranMurid::query())->count();
        
        $stats = [
            'account_only' => $this->applyDateFilter(User::where('role', 'siswa')->doesntHave('pendaftaranMurids'))->count(),
            'pending'      => $this->applyDateFilter(PendaftaranMurid::where('status', 'pending'))->count(),
            'accepted'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'diterima'))->count(),
            'rejected'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'ditolak'))->count(),
            'total'        => $totalApplicants,
            'conversion'   => $totalAccounts > 0 ? round(($totalApplicants / $totalAccounts) * 100, 1) : 0,
        ];

        // 2. Details Recap per Major
        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants' => fn($q) => $this->applyDateFilter($q),
            'pendaftaranMurids as pending_count'    => fn($q) => $this->applyDateFilter($q->where('status', 'pending')),
            'pendaftaranMurids as accepted_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'diterima')),
            'pendaftaranMurids as rejected_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'ditolak')),
        ])->get();

        // 3. Details Recap per Jalur Pendaftaran
        $jalurRecap = JalurPendaftaran::withCount([
            'pendaftaranMurids as total_applicants' => fn($q) => $this->applyDateFilter($q),
            'pendaftaranMurids as pending_count'    => fn($q) => $this->applyDateFilter($q->where('status', 'pending')),
            'pendaftaranMurids as accepted_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'diterima')),
            'pendaftaranMurids as rejected_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'ditolak')),
        ])->get();

        // 4. Monthly Chart Data (Last 6 Months Trend)
        $chartData = [
            'labels' => [],
            'pendaftar' => [],
            'akun_only' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartData['labels'][] = $date->format('M Y');
            
            $chartData['pendaftar'][] = PendaftaranMurid::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $chartData['akun_only'][] = User::where('role', 'siswa')
                ->doesntHave('pendaftaranMurids')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // 5. Account Only Users List
        $accountOnlyUsers = $this->applyDateFilter(
            User::where('role', 'siswa')->doesntHave('pendaftaranMurids')
        )->latest()->get();

        // 6. Registered Users List
        $registeredUsers = $this->applyDateFilter(
            PendaftaranMurid::with(['user', 'jurusan', 'jalurPendaftaran'])
        )->latest()->get();

        return view('livewire.ppdb.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap,
            'jalurRecap' => $jalurRecap,
            'chartData' => $chartData,
            'accountOnlyUsers' => $accountOnlyUsers,
            'registeredUsers' => $registeredUsers
        ]);
    }
}
