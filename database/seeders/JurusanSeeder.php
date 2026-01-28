<?php

namespace Database\Seeders;

use App\Models\Pendaftaran\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            "tipe_sekolah_id" => 1,
            "nama" => "MIPA"
        ]);

        Jurusan::create([
            "tipe_sekolah_id" => 2,
            "nama" => "TKJT",
        ]);

        Jurusan::create([
            "tipe_sekolah_id" => 2,
            "nama" => "MPLB",
        ]);

        Jurusan::create([
            "tipe_sekolah_id" => 2,
            "nama" => "TKR",
        ]);
    }
}
