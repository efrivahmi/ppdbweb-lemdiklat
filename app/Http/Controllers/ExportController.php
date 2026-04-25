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
    private function applyDateFilter($query, $period)
    {
        $now = now();
        $startDate = request()->query('startDate');
        $endDate = request()->query('endDate');

        return match($period) {
            'this_semester' => $query->where('created_at', '>=', $now->copy()->subMonths(6)),
            'last_semester' => $query->whereBetween('created_at', [$now->copy()->subMonths(12), $now->copy()->subMonths(6)]),
            'this_month'    => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
            'last_month'    => $query->whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year),
            'custom'        => $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']),
            default         => $query
        };
    }

    public function excel(Request $request)
    {
        return Excel::download(new RecapitulationExport(
            $request->query('period', 'all'),
            $request->query('startDate'),
            $request->query('endDate')
        ), 'rekapitulasi-ppdb.xlsx');
    }

    public function pdf(Request $request)
    {
        $period = $request->query('period', 'all');

        $totalApplicants = $this->applyDateFilter(PendaftaranMurid::query(), $period)->count();
        
        $stats = [
            'total'        => $totalApplicants,
            'pending'      => $this->applyDateFilter(PendaftaranMurid::where('status', 'pending'), $period)->count(),
            'accepted'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'diterima'), $period)->count(),
            'rejected'     => $this->applyDateFilter(PendaftaranMurid::where('status', 'ditolak'), $period)->count(),
        ];

        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants' => fn($q) => $this->applyDateFilter($q, $period),
            'pendaftaranMurids as pending_count'    => fn($q) => $this->applyDateFilter($q->where('status', 'pending'), $period),
            'pendaftaranMurids as accepted_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'diterima'), $period),
            'pendaftaranMurids as rejected_count'   => fn($q) => $this->applyDateFilter($q->where('status', 'ditolak'), $period),
        ])->get();

        $registeredUsers = $this->applyDateFilter(
            PendaftaranMurid::with(['user', 'jurusan', 'jalurPendaftaran']), $period
        )->latest()->get();

        $pdf = Pdf::loadView('exports.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap,
            'registeredUsers' => $registeredUsers
        ])->setPaper('A4', 'landscape');
        
        return $pdf->download('rekapitulasi-ppdb.pdf');
    }
}
