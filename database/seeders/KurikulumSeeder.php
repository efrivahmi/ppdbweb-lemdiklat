<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\Kurikulum;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        Kurikulum::updateOrCreate(
            ['is_single' => true], // constraint agar hanya ada 1 record
            [
                'badge_text' => 'Kurikulum',
                'title_text' => 'Struktur Kurikulum',
                'title_highlight' => 'Terpadu',
                'title_class' => 'lg:text-5xl font-bold text-gray-900',
                'descriptions' => 'Kurikulum Lemdiklat dirancang untuk mengintegrasikan ilmu pengetahuan, keterampilan, dan pembentukan karakter. 
                Dengan pendekatan berbasis kompetensi, kurikulum ini memastikan peserta didik siap menghadapi tantangan global.',
                
                'image_url' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'image_title' => 'Kegiatan Belajar',
                'image_description' => 'Suasana pembelajaran interaktif dengan fasilitas modern',

                // Empat foto tambahan (wajib)
                'photo_1_url' => asset('images/bela-negara.jpg'),
                'photo_1_title' => 'Bela Negara',

                'photo_2_url' => asset('images/kenusantaraan.jpg'),
                'photo_2_title' => 'Kenusantaraan',

                'photo_3_url' => asset('images/terproyek.jpg'),
                'photo_3_title' => 'Terproyek',

                'is_active' => true,
                'is_single' => true,
            ]
        );
    }
}
