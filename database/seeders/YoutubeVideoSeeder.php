<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YoutubeVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('youtube_videos')->insert([
            [
                'url' => 'https://youtu.be/MsDhoUEa6JE?si=tt-GhhHugFFN1aio',
                'title' => 'Profil SMA Taruna Nusantara',
                'description' => 'Video resmi yang memperkenalkan lingkungan, fasilitas, dan budaya belajar di SMA Taruna Nusantara.',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://youtu.be/buvWBOZTfdc?si=XJBBLNNfVA-TzufL',
                'title' => 'Kegiatan Ekstrakurikuler dan Prestasi Siswa',
                'description' => 'Menampilkan berbagai kegiatan ekstrakurikuler, lomba, dan prestasi siswa SMA Taruna Nusantara.',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://youtu.be/DGwW4EHgV6o?si=MhdeHhnqW_r9-1Ir',
                'title' => 'Testimoni Alumni dan Guru',
                'description' => 'Cerita inspiratif dari para alumni dan tenaga pendidik mengenai pengalaman mereka di SMA Taruna Nusantara.',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
