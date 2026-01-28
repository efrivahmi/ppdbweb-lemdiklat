<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data existing jika ada
        About::truncate();

        // Create single record - Data utama profil sekolah
        About::create([
            'badge_text' => 'Tentang Kami',
            'title_text' => 'Profil Sekolah',
            'title_highlight' => 'Sekolah',
            'title_class_name' => 'lg:text-5xl',
            'description' => 'Lemdiklat Taruna Nusantara Indonesia adalah sekolah menengah atas yang berkomitmen untuk membentuk generasi muda yang berintegritas, berkarakter, dan siap menghadapi tantangan masa depan. Dengan kurikulum komprehensif dan fasilitas modern, kami memberikan pendidikan terbaik yang menggabungkan akademik dan pengembangan karakter. Didukung oleh tenaga pengajar profesional dan berpengalaman, kami menciptakan lingkungan belajar yang kondusif untuk mengembangkan potensi maksimal setiap siswa.',
            'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'image_title' => 'Gedung Sekolah',
            'image_description' => 'Fasilitas modern untuk mendukung proses pembelajaran',
            'contact_info' => [
                [
                    'icon' => 'MapPinIcon',
                    'text' => 'Jl. Pendidikan No. 123, Jakarta Selatan'
                ],
                [
                    'icon' => 'PhoneIcon',
                    'text' => '(021) 1234-5678'
                ]
            ],
            'is_active' => true,
            'is_single' => true
        ]);
    }
}