<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\Prestasi;
use Illuminate\Support\Facades\Storage;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasi = [
            [
                'title' => 'Juara 1 Olimpiade Matematika Nasional',
                'description' => 'Siswa kelas XII berhasil meraih juara 1 dalam Olimpiade Matematika tingkat nasional yang diselenggarakan oleh Kementerian Pendidikan. Kompetisi ini diikuti oleh lebih dari 500 siswa terbaik dari seluruh Indonesia.',
                'image' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'title' => 'Medali Emas Kompetisi Sains Internasional',
                'description' => 'Tim sains sekolah berhasil meraih medali emas dalam International Science Competition yang diadakan di Singapura. Prestasi ini membanggakan dan mengharumkan nama sekolah di tingkat internasional.',
                'image' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'title' => 'Juara 2 Lomba Debat Bahasa Inggris',
                'description' => 'Siswa kelas XI meraih juara 2 dalam lomba debat bahasa Inggris tingkat provinsi. Kemampuan berbicara dan berargumentasi yang luar biasa membawa prestasi membanggakan ini.',
                'image' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
        ];

        foreach ($prestasi as $item) {
            Prestasi::create($item);
        }

        $this->command->info('Prestasi seeder completed successfully!');
    }
}