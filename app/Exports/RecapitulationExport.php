<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\Jurusan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecapitulationExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $period;

    public function __construct($period = 'all')
    {
        $this->period = $period;
    }

    private function applyDateFilter($query)
    {
        $now = now();
        return match($this->period) {
            'this_semester' => $query->where('created_at', '>=', $now->copy()->subMonths(6)),
            'last_semester' => $query->whereBetween('created_at', [$now->copy()->subMonths(12), $now->copy()->subMonths(6)]),
            'this_month'    => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
            'last_month'    => $query->whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year),
            default         => $query
        };
    }

    public function view(): View
    {
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

        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants' => fn($q) => $this->applyDateFilter($q),
            'pendaftaranMurids as pending_count'    => fn($q) => $this->applyDateFilter($q->where('status', 'pending')),
            'pendaftaranMurids as accepted_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'diterima')),
            'pendaftaranMurids as rejected_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'ditolak')),
        ])->get();

        return view('exports.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
