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
    public function view(): View
    {
        $totalAccounts = User::where('role', 'calon_siswa')->count();
        $totalApplicants = PendaftaranMurid::count();
        
        $stats = [
            'account_only' => User::where('role', 'calon_siswa')->doesntHave('pendaftaranMurids')->count(),
            'pending'      => PendaftaranMurid::where('status', 'pending')->count(),
            'payment'      => PendaftaranMurid::where('status', 'menunggu_pembayaran')->count(),
            'accepted'     => PendaftaranMurid::where('status', 'acc')->count(),
            'rejected'     => PendaftaranMurid::where('status', 'ditolak')->count(),
            'total'        => $totalApplicants,
            'conversion'   => $totalAccounts > 0 ? round(($totalApplicants / $totalAccounts) * 100, 1) : 0,
        ];

        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants',
            'pendaftaranMurids as pending_count' => fn($q) => $q->where('status', 'pending'),
            'pendaftaranMurids as payment_count' => fn($q) => $q->where('status', 'menunggu_pembayaran'),
            'pendaftaranMurids as accepted_count' => fn($q) => $q->where('status', 'acc'),
            'pendaftaranMurids as rejected_count' => fn($q) => $q->where('status', 'ditolak'),
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
