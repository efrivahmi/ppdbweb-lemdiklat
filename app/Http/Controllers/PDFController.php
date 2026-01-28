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
                'tahunPelajaran' => $this->getTahunPelajaran(),
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
                'tahunPelajaran' => $this->getTahunPelajaran(),
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
                'tahunPelajaran' => $this->getTahunPelajaran(),
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
                'tahunPelajaran' => $this->getTahunPelajaran(),
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
     * Get tahun pelajaran berdasarkan tanggal sekarang
     */
    private function getTahunPelajaran()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        
        // Jika bulan Juli-Desember, tahun pelajaran dimulai dari tahun ini
        // Jika bulan Januari-Juni, tahun pelajaran dimulai dari tahun lalu
        if ($month >= 7) {
            return $year . '/' . ($year + 1);
        } else {
            return ($year - 1) . '/' . $year;
        }
    }
}