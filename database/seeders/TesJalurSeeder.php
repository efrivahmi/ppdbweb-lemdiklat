<?php

namespace Database\Seeders;

use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\TesJalur;
use Illuminate\Database\Seeder;

class TesJalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan jalur pendaftaran
        $beasiswa = JalurPendaftaran::where('nama', 'Beasiswa Yayasan')->first();
        $tahfidz = JalurPendaftaran::where('nama', "Tahfidz Qur'an")->first();
        $prestasi = JalurPendaftaran::where('nama', 'Prestasi')->first();

        if ($beasiswa) {
            TesJalur::create([
                'jalur_pendaftaran_id' => $beasiswa->id,
                'nama_tes' => 'Verifikasi Dokumen',
                'deskripsi' => 'Verifikasi kelengkapan dokumen dan persyaratan beasiswa'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $beasiswa->id,
                'nama_tes' => 'Wawancara',
                'deskripsi' => 'Wawancara dengan tim yayasan untuk menilai kelayakan beasiswa'
            ]);
        }

        if ($tahfidz) {
            TesJalur::create([
                'jalur_pendaftaran_id' => $tahfidz->id,
                'nama_tes' => 'Tes Hafalan Al-Qur\'an',
                'deskripsi' => 'Ujian hafalan Al-Qur\'an minimal 15 juz dengan tartil dan tajwid yang benar'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $tahfidz->id,
                'nama_tes' => 'Tes Kemampuan Bahasa Arab',
                'deskripsi' => 'Tes pemahaman bahasa Arab dasar dan kemampuan membaca kitab'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $tahfidz->id,
                'nama_tes' => 'Tes Akademik Umum',
                'deskripsi' => 'Tes akademik mata pelajaran umum (Matematika, IPA, Bahasa Indonesia)'
            ]);
        }

        if ($prestasi) {
            TesJalur::create([
                'jalur_pendaftaran_id' => $prestasi->id,
                'nama_tes' => 'Tes Potensi Akademik',
                'deskripsi' => 'Tes logika, penalaran, dan kemampuan analisis'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $prestasi->id,
                'nama_tes' => 'Tes Matematika',
                'deskripsi' => 'Tes kemampuan matematika dasar hingga tingkat menengah'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $prestasi->id,
                'nama_tes' => 'Tes IPA Terpadu',
                'deskripsi' => 'Tes mata pelajaran IPA (Fisika, Kimia, Biologi)'
            ]);
            
            TesJalur::create([
                'jalur_pendaftaran_id' => $prestasi->id,
                'nama_tes' => 'Tes Bahasa Inggris',
                'deskripsi' => 'Tes kemampuan bahasa Inggris (reading, grammar, vocabulary)'
            ]);
        }
    }
}