<?php

namespace App\Http\Middleware;

use App\Models\GelombangPendaftaran;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkHariPengumuman
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil gelombang terbaru yang sudah mulai pendaftaran
        $gelombang = GelombangPendaftaran::where('pendaftaran_mulai', '<=', now())
                                        ->orderBy('created_at', 'desc')
                                        ->first();

        // Izinkan akses sejak tanggal pengumuman dan seterusnya
        if (!$gelombang || !$gelombang->isPengumumanTerbuka()) {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Halaman Status Penerimaan akan tersedia pada tanggal pengumuman.');
        }

        return $next($request);
    }
}