<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Landing\Persyaratan;

class PersyaratanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Persyaratan::truncate();

        // Physical Requirements - Height
        $physicalHeightData = [
            [
                'type' => 'physical',
                'title' => 'Tinggi Badan Minimal',
                'description' => 'Standar tinggi badan minimal untuk calon siswa laki-laki',
                'value' => '155',
                'unit' => 'cm',
                'gender' => 'male',
                'color' => 'blue',
                'is_active' => true,
                'order' => 1
            ],
            [
                'type' => 'physical',
                'title' => 'Tinggi Badan Minimal',
                'description' => 'Standar tinggi badan minimal untuk calon siswa perempuan',
                'value' => '145',
                'unit' => 'cm',
                'gender' => 'female',
                'color' => 'pink',
                'is_active' => true,
                'order' => 2
            ]
        ];

        // Physical Requirements - Weight
        $physicalWeightData = [
            [
                'type' => 'physical',
                'title' => 'Berat Badan Minimal',
                'description' => 'Standar berat badan minimal untuk calon siswa laki-laki',
                'value' => '45',
                'unit' => 'kg',
                'gender' => 'male',
                'color' => 'blue',
                'is_active' => true,
                'order' => 3
            ],
            [
                'type' => 'physical',
                'title' => 'Berat Badan Minimal',
                'description' => 'Standar berat badan minimal untuk calon siswa perempuan',
                'value' => '35',
                'unit' => 'kg',
                'gender' => 'female',
                'color' => 'pink',
                'is_active' => true,
                'order' => 4
            ]
        ];

        // Document Requirements
        $documentData = [
            [
                'type' => 'document',
                'title' => 'Fotokopi Akta Kelahiran',
                'description' => 'Fotokopi akta kelahiran yang masih berlaku dan jelas terbaca',
                'value' => '15',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 1
            ],
            [
                'type' => 'document',
                'title' => 'Fotokopi Kartu Keluarga',
                'description' => 'Fotokopi kartu keluarga yang masih berlaku dan jelas terbaca',
                'value' => '15',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 2
            ],
            [
                'type' => 'document',
                'title' => 'Fotokopi KTP Ayah dan Ibu',
                'description' => 'Fotokopi KTP kedua orang tua yang masih berlaku',
                'value' => '15',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 3
            ],
            [
                'type' => 'document',
                'title' => 'Fotokopi Ijazah SD',
                'description' => 'Fotokopi ijazah Sekolah Dasar yang sudah dilegalisir',
                'value' => '15',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 4
            ],
            [
                'type' => 'document',
                'title' => 'Fotokopi Ijazah SMP (yang sudah dilegalisir)',
                'description' => 'Fotokopi ijazah SMP/MTs yang sudah dilegalisir oleh sekolah asal',
                'value' => '15',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 5
            ],
            [
                'type' => 'document',
                'title' => 'Pas Foto 3x4 Latar Merah (menggunakan seragam SMP/MTs)',
                'description' => 'Pas foto terbaru dengan latar belakang merah menggunakan seragam SMP/MTs',
                'value' => '5',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 6
            ],
            [
                'type' => 'document',
                'title' => 'Surat Keterangan Kelakuan Baik (1 asli dan 4 fotokopi)',
                'description' => 'Surat keterangan kelakuan baik dari sekolah asal dengan 1 dokumen asli dan 4 fotokopi',
                'value' => '5',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 7
            ],
            [
                'type' => 'document',
                'title' => 'Surat Keterangan Sehat dari dokter (asli)',
                'description' => 'Surat keterangan sehat dari dokter dalam bentuk dokumen asli',
                'value' => '1',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 8
            ],
            [
                'type' => 'document',
                'title' => 'Bukti Pendaftaran Online (sudah ditandatangani)',
                'description' => 'Bukti pendaftaran online yang sudah dicetak dan ditandatangani',
                'value' => '1',
                'unit' => 'lembar',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 9
            ],
            [
                'type' => 'document',
                'title' => 'Materai @ Rp 10.000',
                'description' => 'Materai dengan nominal Rp 10.000 untuk keperluan legalisir dokumen',
                'value' => '3',
                'unit' => 'buah',
                'gender' => null,
                'color' => null,
                'is_active' => true,
                'order' => 10
            ]
        ];

        // Insert all data
        foreach ($physicalHeightData as $data) {
            Persyaratan::create($data);
        }

        foreach ($physicalWeightData as $data) {
            Persyaratan::create($data);
        }

        foreach ($documentData as $data) {
            Persyaratan::create($data);
        }

        $this->command->info('Persyaratan seeder completed successfully!');
        $this->command->info('Created ' . count($physicalHeightData) . ' physical height requirements');
        $this->command->info('Created ' . count($physicalWeightData) . ' physical weight requirements');
        $this->command->info('Created ' . count($documentData) . ' document requirements');
    }
}