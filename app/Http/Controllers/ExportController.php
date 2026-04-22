<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
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

        $pdf = Pdf::loadView('exports.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap
        ]);
        
        return $pdf->download('rekapitulasi-ppdb.pdf');
    }
}
