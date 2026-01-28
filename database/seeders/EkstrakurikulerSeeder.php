<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\Ekstrakurikuler;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'img' => 'assets/ekstra/pramuka.jpg',
                'title' => 'Pramuka',
                'desc' => 'Ekstrakurikuler pramuka yang melatih kemandirian, kedisiplinan, dan jiwa kepemimpinan.',
            ],
            [
                'img' => 'assets/ekstra/futsal.jpg',
                'title' => 'Futsal',
                'desc' => 'Ekstrakurikuler futsal untuk menyalurkan minat olahraga dan kerja sama tim.',
            ],
            [
                'img' => 'assets/ekstra/paduan-suara.jpg',
                'title' => 'Paduan Suara',
                'desc' => 'Ekstrakurikuler paduan suara yang mengembangkan kemampuan vokal dan seni musik.',
            ],
        ];

        foreach ($data as $item) {
            Ekstrakurikuler::create($item);
        }
    }
}
