<?php

namespace Database\Seeders;

use App\Models\Landing\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        Footer::truncate();

        Footer::create([
            'site_title' => 'Lemdiklat Taruna Nusantara Indonesia',
            'site_description' => 'Membentuk karakter bangsa melalui pendidikan yang berkualitas dan berintegritas — menciptakan generasi pemimpin yang berjiwa nasionalis, religius, dan berwawasan global.',
            'copyright_text' => '© {year} Lemdiklat Taruna Nusantara Indonesia. All rights reserved.',
            'social_icons' => [
                [
                    'icon' => 'twitter',
                    'href' => 'https://twitter.com/tarunanusantara',
                    'label' => 'Twitter'
                ],
                [
                    'icon' => 'instagram', 
                    'href' => 'https://instagram.com/tarunanusantara',
                    'label' => 'Instagram'
                ],
                [
                    'icon' => 'youtube',
                    'href' => 'https://youtube.com/tarunanusantara', 
                    'label' => 'YouTube'
                ],
                [
                    'icon' => 'facebook',
                    'href' => 'https://facebook.com/tarunanusantara',
                    'label' => 'Facebook'
                ]
            ],
            'footer_links' => [
                [
                    'title' => 'Informasi',
                    'links' => [
                        ['text' => 'Berita', 'href' => '/news'],
                        ['text' => 'Prestasi', 'href' => '/achievement'], 
                        ['text' => 'Persyaratan', 'href' => '/requirement']
                    ]
                ],
                [
                    'title' => 'Akademik',
                    'links' => [
                        ['text' => 'Fasilitas', 'href' => '/facility'],
                        ['text' => 'Program Studi', 'href' => '/program-studi'],
                        ['text' => 'Kurikulum', 'href' => '/kurikulum'],
                        ['text' => 'Ekstrakurikuler', 'href' => '/ekstrakurikuler']
                    ]
                ],
                [
                    'title' => 'Kontak', 
                    'links' => [
                        ['text' => 'Alamat Sekolah', 'href' => '/kontak'],
                        ['text' => 'Telepon', 'href' => '/kontak'],
                        ['text' => 'Email', 'href' => '/kontak']
                    ]
                ]
            ],
            'legal_links' => [
                ['text' => 'Kebijakan Privasi', 'href' => '/privacy'],
                ['text' => 'Syarat & Ketentuan', 'href' => '/terms']
            ],
            'is_active' => true
        ]);
    }
}