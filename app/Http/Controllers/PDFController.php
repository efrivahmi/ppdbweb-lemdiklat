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
     * Get tahun pelajaran berdasarkan tahun siswa mendaftar
     * Contoh: Jika siswa mendaftar tahun 2025 -> Tahun Pelajaran 2026/2027
     * Jika siswa mendaftar tahun 2027 -> Tahun Pelajaran 2028/2029
     * 
     * Ini memastikan setiap siswa mendapat tahun pelajaran berdasarkan 
     * kapan mereka mendaftar, bukan berdasarkan gelombang terbaru
     */
    private function getTahunPelajaran($pendaftaran = null)
    {
        // Gunakan tahun dari tanggal pendaftaran siswa
        if ($pendaftaran && $pendaftaran->created_at) {
            $registrationYear = Carbon::parse($pendaftaran->created_at)->year;
        } else {
            // Fallback ke tahun sekarang jika tidak ada pendaftaran
            $registrationYear = Carbon::now()->year;
        }
        
        // Tahun pelajaran = tahun pendaftaran + 1 / tahun pendaftaran + 2
        return ($registrationYear + 1) . '/' . ($registrationYear + 2);
    }
}