<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\Jurusan;
use App\Exports\RecapitulationExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function excel()
    {
        return Excel::download(new RecapitulationExport, 'rekapitulasi-ppdb.xlsx');
    }

    public function pdf()
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

        $pdf = Pdf::loadView('exports.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap
        ]);
        
        return $pdf->download('rekapitulasi-ppdb.pdf');
    }
}
