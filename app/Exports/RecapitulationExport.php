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
    protected $startDate;
    protected $endDate;

    public function __construct($period = 'all', $startDate = null, $endDate = null)
    {
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    private function applyDateFilter($query)
    {
        $now = now();
        return match($this->period) {
            'this_semester' => $query->where('created_at', '>=', $now->copy()->subMonths(6)),
            'last_semester' => $query->whereBetween('created_at', [$now->copy()->subMonths(12), $now->copy()->subMonths(6)]),
            'this_month'    => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
            'last_month'    => $query->whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year),
            'custom'        => $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']),
            default         => $query
        };
    }

    public function view(): View
    {
        $totalApplicants = $this->applyDateFilter(PendaftaranMurid::query())->count();
        
        $stats = [
            'total'        => $totalApplicants,
            'pending'      => $this->applyDateFilter(PendaftaranMurid::where('status', 'pending'))->count(),
            'accepted'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'diterima'))->count(),
            'rejected'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'ditolak'))->count(),
        ];

        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants' => fn($q) => $this->applyDateFilter($q),
            'pendaftaranMurids as pending_count'    => fn($q) => $this->applyDateFilter($q->where('status', 'pending')),
            'pendaftaranMurids as accepted_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'diterima')),
            'pendaftaranMurids as rejected_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'ditolak')),
        ])->get();

        $registeredUsers = $this->applyDateFilter(
            PendaftaranMurid::with(['user', 'jurusan', 'jalurPendaftaran'])
        )->latest()->get();

        return view('exports.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap,
            'registeredUsers' => $registeredUsers
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Apply borders to all filled cells
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style the Title Row
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
        ]);

        return [];
    }
}
