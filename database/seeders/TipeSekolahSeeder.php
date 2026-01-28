<?php

namespace Database\Seeders;

use App\Models\Pendaftaran\TipeSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeSekolah::create([
            "nama" => "SMA"
        ]);

        TipeSekolah::create([
            "nama" => "SMK"
        ]);
    }

    
}
