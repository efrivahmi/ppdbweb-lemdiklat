<?php

namespace Database\Seeders;

use App\Models\Pendaftaran\JalurPendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JalurPendaftaran::create([
            "nama" => "Beasiswa Yayasan",
            "img" => "",
            "deskripsi" => "Pendaftaran khusus dari yayasan",
        ]);

        JalurPendaftaran::create([
            "nama" => "Tahfidz Quran",
            "img" => "",
            "deskripsi" => "Pendaftaran khusus bagi para tahfidz Qur'an",
        ]);

        JalurPendaftaran::create([
            "nama" => "Prestasi",
            "img" => "",
            "deskripsi" => "Pendaftaran berbasis tes akademik",
        ]);
    }
}