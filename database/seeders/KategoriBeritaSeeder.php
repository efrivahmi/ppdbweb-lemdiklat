<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\KategoriBerita;

class KategoriBeritaSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Pendaftaran', 'is_active' => true],
            ['name' => 'Prestasi', 'is_active' => true],
            ['name' => 'Kegiatan', 'is_active' => true],
            ['name' => 'Pengumuman', 'is_active' => true],
            ['name' => 'Akademik', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            KategoriBerita::create($category);
        }
    }
}