<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Landing\PDF;
use App\Models\Siswa\DataMurid;
use App\Models\Pendaftaran\PendaftaranMurid;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Carbon\Carbon;

class PDFController extends Controller
{
    /**
     * Generate PDF Verifikasi
     */
    public function generateVerifikasiPDF($userId)
    {
        try {
            // Ambil data user dengan relasi
            $user = User::with([
                'dataMurid',
                'dataOrangTua',
                'pendaftaranMurids.jalurPendaftaran',
                'pendaftaranMurids.tipeSekolah',
                'pendaftaranMurids.jurusan'
            ])->findOrFail($userId);

            // Ambil data pendaftaran terbaru
            $pendaftaran = $user->pendaftaranMurids()->latest()->first();
            
            if (!$pendaftaran) {
                return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
            }

            // Ambil pengaturan PDF verifikasi
            $pdfSetting = PDF::getSettingsByJenis('verifikasi');
            
            if (!$pdfSetting) {
                return redirect()->back()->with('error', 'Pengaturan PDF verifikasi belum dikonfigurasi');
            }

            // Data untuk PDF
            $data = [
                'user' => $user,
                'pendaftaran' => $pendaftaran,
                'pdfSetting' => $pdfSetting,
                'tahunPelajaran' => $this->getTahunPelajaran($pendaftaran),
                'tanggalCetak' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            ];

            // Generate PDF
            $pdf = DomPDF::loadView('pdf.verifikasi', $data);
            $pdf->setPaper('A4', 'portrait');

            // Download PDF
            $filename = 'Verifikasi_Pendaftaran_' . $user->name . '_' . date('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF Penerimaan
     */
    public function generatePenerimaanPDF($userId)
    {
        try {
            // Ambil data user dengan relasi
            $user = User::with([
                'dataMurid',
                'dataOrangTua',
                'pendaftaranMurids.jalurPendaftaran',
                'pendaftaranMurids.tipeSekolah',
                'pendaftaranMurids.jurusan'
            ])->findOrFail($userId);

            // Ambil data pendaftaran yang diterima
            $pendaftaran = $user->pendaftaranMurids()->where('status', 'diterima')->latest()->first();
            
            if (!$pendaftaran) {
                return redirect()->back()->with('error', 'Siswa belum diterima atau data pendaftaran tidak ditemukan');
            }

            // Ambil pengaturan PDF penerimaan
            $pdfSetting = PDF::getSettingsByJenis('penerimaan');
            
            if (!$pdfSetting) {
                return redirect()->back()->with('error', 'Pengaturan PDF penerimaan belum dikonfigurasi');
            }

            // Data untuk PDF
            $data = [
                'user' => $user,
                'pendaftaran' => $pendaftaran,
                'pdfSetting' => $pdfSetting,
                'tahunPelajaran' => $this->getTahunPelajaran($pendaftaran),
                'tanggalCetak' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            ];

            // Generate PDF
            $pdf = DomPDF::loadView('pdf.penerimaan', $data);
            $pdf->setPaper('A4', 'portrait');

            // Download PDF
            $filename = 'Surat_Penerimaan_' . $user->name . '_' . date('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview PDF Verifikasi
     */
    public function previewVerifikasiPDF($userId)
    {
        try {
            $user = User::with([
                'dataMurid',
                'dataOrangTua',
                'pendaftaranMurids.jalurPendaftaran',
                'pendaftaranMurids.tipeSekolah',
                'pendaftaranMurids.jurusan'
            ])->findOrFail($userId);

            $pendaftaran = $user->pendaftaranMurids()->latest()->first();
            $pdfSetting = PDF::getSettingsByJenis('verifikasi');

            if (!$pendaftaran || !$pdfSetting) {
                return redirect()->back()->with('error', 'Data tidak lengkap untuk preview PDF');
            }

            $data = [
                'user' => $user,
                'pendaftaran' => $pendaftaran,
                'pdfSetting' => $pdfSetting,
                'tahunPelajaran' => $this->getTahunPelajaran($pendaftaran),
                'tanggalCetak' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            ];

            $pdf = DomPDF::loadView('pdf.verifikasi', $data);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('Preview_Verifikasi.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal preview PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview PDF Penerimaan
     */
    public function previewPenerimaanPDF($userId)
    {
        try {
            $user = User::with([
                'dataMurid',
                'dataOrangTua',
                'pendaftaranMurids.jalurPendaftaran',
                'pendaftaranMurids.tipeSekolah',
                'pendaftaranMurids.jurusan'
            ])->findOrFail($userId);

            $pendaftaran = $user->pendaftaranMurids()->where('status', 'diterima')->latest()->first();
            $pdfSetting = PDF::getSettingsByJenis('penerimaan');

            if (!$pendaftaran || !$pdfSetting) {
                return redirect()->back()->with('error', 'Data tidak lengkap untuk preview PDF');
            }

            $data = [
                'user' => $user,
                'pendaftaran' => $pendaftaran,
                'pdfSetting' => $pdfSetting,
                'tahunPelajaran' => $this->getTahunPelajaran($pendaftaran),
                'tanggalCetak' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            ];

            $pdf = DomPDF::loadView('pdf.penerimaan', $data);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('Preview_Penerimaan.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal preview PDF: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF untuk siswa yang login (self-generate)
     */
    public function generateMyVerifikasiPDF()
    {
        return $this->generateVerifikasiPDF(auth()->id());
    }

    public function generateMyPenerimaanPDF()
    {
        return $this->generatePenerimaanPDF(auth()->id());
    }

    /**
     * Get tahun pelajaran berdasarkan gelombang pendaftaran yang aktif saat siswa mendaftar
     * 
     * Contoh: Gelombang dibuka Juli 2025 s/d Juli 2026
     * - Siswa mendaftar Desember 2025 -> Tahun Pelajaran 2026/2027
     * - Siswa mendaftar Januari 2026 -> Tahun Pelajaran 2026/2027 (sama, sesuai gelombang)
     * 
     * Tahun pelajaran = tahun gelombang dibuka + 1 / tahun gelombang dibuka + 2
     */
    private function getTahunPelajaran($pendaftaran = null)
    {
        $registrationYear = Carbon::now()->year; // default fallback
        
        if ($pendaftaran && $pendaftaran->created_at) {
            $registrationDate = Carbon::parse($pendaftaran->created_at);
            
            // Cari gelombang yang aktif saat siswa mendaftar
            $gelombang = \App\Models\GelombangPendaftaran::where('pendaftaran_mulai', '<=', $registrationDate)
                ->where('pendaftaran_selesai', '>=', $registrationDate)
                ->first();
            
            if ($gelombang) {
                // Gunakan tahun dari tanggal mulai gelombang
                $registrationYear = Carbon::parse($gelombang->pendaftaran_mulai)->year;
            } else {
                // Fallback: cari gelombang terdekat sebelum tanggal pendaftaran
                $gelombang = \App\Models\GelombangPendaftaran::where('pendaftaran_mulai', '<=', $registrationDate)
                    ->orderBy('pendaftaran_mulai', 'desc')
                    ->first();
                
                if ($gelombang) {
                    $registrationYear = Carbon::parse($gelombang->pendaftaran_mulai)->year;
                } else {
                    // Jika tidak ada gelombang, gunakan tahun pendaftaran siswa
                    $registrationYear = $registrationDate->year;
                }
            }
        }
        
        // Tahun pelajaran = tahun gelombang dibuka + 1 / tahun gelombang dibuka + 2
        return ($registrationYear + 1) . '/' . ($registrationYear + 2);
    }
}