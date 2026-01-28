<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisiMisi::truncate();

        $visiData = [
            'title' => 'Visi Sekolah',
            'content' => 'Menjadi sekolah unggulan yang membentuk generasi berkarakter, berdisiplin, berakhlak mulia, dan berjiwa kepemimpinan melalui pendidikan formal, ketarunaan, dan kepesantrenan.',
            'items' => []
        ];

        $misiData = [
            'title' => 'Misi Sekolah',
            'content' => 'Langkah strategis untuk mewujudkan visi sekolah yang unggul dan berkarakter.',
            'items' => [
                [
                    'title' => 'Nilai Keimanan dan Ketakwaan',
                    'description' => 'Menanamkan nilai-nilai keimanan dan ketakwaan kepada Allah SWT melalui pembiasaan ibadah, kajian keislaman, dan pendidikan berbasis akhlakul karimah.'
                ],
                [
                    'title' => 'Kedisiplinan dan Tanggung Jawab',
                    'description' => 'Membangun karakter kedisiplinan dan tanggung jawab melalui sistem ketarunaan yang terarah, tegas, dan mendidik.'
                ],
                [
                    'title' => 'Kepemimpinan dan Nasionalisme',
                    'description' => 'Mengembangkan jiwa kepemimpinan, nasionalisme, dan cinta tanah air agar peserta didik memiliki semangat bela negara dan kepedulian sosial.'
                ],
                [
                    'title' => 'Prestasi Akademik dan Non-Akademik',
                    'description' => 'Meningkatkan kompetensi akademik dan non-akademik melalui pembelajaran aktif, kreatif, dan berorientasi pada prestasi.'
                ],
                [
                    'title' => 'Lingkungan Religius dan Berbudaya',
                    'description' => 'Mewujudkan lingkungan sekolah yang religius, tertib, dan berbudaya, sebagai tempat pembentukan karakter unggul dan integritas moral.'
                ],
                [
                    'title' => 'Kemandirian dan Ketahanan Mental',
                    'description' => 'Menumbuhkan kemandirian dan semangat pantang menyerah dalam menghadapi tantangan kehidupan melalui pembinaan mental dan fisik.'
                ],
            ]
        ];

        VisiMisi::create([
            'type' => 'visi',
            'title' => $visiData['title'],
            'content' => $visiData['content'],
            'item_title' => null,
            'item_description' => null,
            'order' => 0,
            'is_active' => true,
        ]);

        VisiMisi::create([
            'type' => 'misi',
            'title' => $misiData['title'],
            'content' => $misiData['content'],
            'item_title' => null,
            'item_description' => null,
            'order' => 0,
            'is_active' => true,
        ]);

        foreach ($misiData['items'] as $index => $item) {
            VisiMisi::create([
                'type' => 'misi',
                'title' => $misiData['title'],
                'content' => null,
                'item_title' => $item['title'],
                'item_description' => $item['description'],
                'order' => $index + 1,
                'is_active' => true,
            ]);
        }

        $this->command->info('Seeder Visi & Misi Sekolah berhasil dijalankan! Total: ' . VisiMisi::count() . ' data.');
    }
}
