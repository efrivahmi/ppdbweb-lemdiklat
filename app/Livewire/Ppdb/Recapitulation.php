<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\Jurusan;
use App\Models\Pendaftaran\JalurPendaftaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Rekapitulasi PPDB')]
class Recapitulation extends Component
{
    use WithPagination;

    public $filterPeriod = 'all';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updatedFilterPeriod()
    {
        $this->resetPage('registeredPage');
    }

    public function updatedStartDate() { $this->resetPage('registeredPage'); }
    public function updatedEndDate() { $this->resetPage('registeredPage'); }

    private function applyDateFilter($query)
    {
        $now = now();
        return match($this->filterPeriod) {
            'this_semester' => $query->where('created_at', '>=', $now->copy()->subMonths(6)),
            'last_semester' => $query->whereBetween('created_at', [$now->copy()->subMonths(12), $now->copy()->subMonths(6)]),
            'this_month'    => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
            'last_month'    => $query->whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year),
            'custom'        => $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']),
            default         => $query
        };
    }

    public function render()
    {
        // 1. Global Statistic Recap (Focus ONLY on Applicants)
        $totalApplicants = $this->applyDateFilter(PendaftaranMurid::query())->count();
        
        $stats = [
            'total'        => $totalApplicants,
            'pending'      => $this->applyDateFilter(PendaftaranMurid::where('status', 'pending'))->count(),
            'accepted'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'diterima'))->count(),
            'rejected'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'ditolak'))->count(),
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
            'pendaftar' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartData['labels'][] = $date->format('M Y');
            
            $chartData['pendaftar'][] = PendaftaranMurid::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // 5. Registered Users List
        $registeredUsers = $this->applyDateFilter(
            PendaftaranMurid::with(['user', 'jurusan', 'jalurPendaftaran'])
        )->latest()->paginate(15, ['*'], 'registeredPage');

        return view('livewire.ppdb.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap,
            'jalurRecap' => $jalurRecap,
            'chartData' => $chartData,
            'registeredUsers' => $registeredUsers
        ]);
    }
}
