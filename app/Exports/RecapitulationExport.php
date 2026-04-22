<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecapitulationExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        $totalAccounts = User::where('role', 'calon_siswa')->count();
        $totalApplicants = Pendaftaran::count();
        
        $stats = [
            'account_only' => User::where('role', 'calon_siswa')->doesntHave('pendaftaran')->count(),
            'pending'      => Pendaftaran::where('status', 'pending')->count(),
            'payment'      => Pendaftaran::where('status', 'menunggu_pembayaran')->count(),
            'accepted'     => Pendaftaran::where('status', 'acc')->count(),
            'rejected'     => Pendaftaran::where('status', 'ditolak')->count(),
            'total'        => $totalApplicants,
            'conversion'   => $totalAccounts > 0 ? round(($totalApplicants / $totalAccounts) * 100, 1) : 0,
        ];

        $majorRecap = Jurusan::withCount([
            'pendaftaran as total_applicants',
            'pendaftaran as pending_count' => fn($q) => $q->where('status', 'pending'),
            'pendaftaran as payment_count' => fn($q) => $q->where('status', 'menunggu_pembayaran'),
            'pendaftaran as accepted_count' => fn($q) => $q->where('status', 'acc'),
            'pendaftaran as rejected_count' => fn($q) => $q->where('status', 'ditolak'),
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
