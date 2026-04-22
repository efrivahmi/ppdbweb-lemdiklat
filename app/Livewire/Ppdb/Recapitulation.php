<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\User;
use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\Jurusan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Rekapitulasi PPDB')]
class Recapitulation extends Component
{
    public function render()
    {
        // 1. Global Statistic Recap
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

        // 2. Details Recap per Major
        $majorRecap = Jurusan::withCount([
            'pendaftaranMurids as total_applicants',
            'pendaftaranMurids as pending_count' => fn($q) => $q->where('status', 'pending'),
            'pendaftaranMurids as payment_count' => fn($q) => $q->where('status', 'menunggu_pembayaran'),
            'pendaftaranMurids as accepted_count' => fn($q) => $q->where('status', 'acc'),
            'pendaftaranMurids as rejected_count' => fn($q) => $q->where('status', 'ditolak'),
        ])->get();

        return view('livewire.ppdb.recapitulation', [
            'stats' => $stats,
            'majorRecap' => $majorRecap
        ]);
    }
}
