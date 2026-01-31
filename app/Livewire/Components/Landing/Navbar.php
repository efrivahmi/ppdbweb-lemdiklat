<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

class Navbar extends Component
{
    public $navLinks = [
        [
            'id' => 'home',
            'name' => 'Beranda',
            'url' => '/',
            'icon' => 'home',
            'isDropdown' => false,
        ],
        [
            'id' => 'spmb',
            'name' => 'SPMB',
            'url' => '/spmb',
            'icon' => 'academic-cap',
            'isDropdown' => false,
        ],
        [
            'id' => 'tentang',
            'name' => 'Tentang Sekolah',
            'url' => '/profile',
            'icon' => 'information-circle',
            'isDropdown' => true,
            'children' => [
                [
                    'id' => 'about',
                    'name' => 'Profil Lembaga',
                    'url' => '/profile',
                ],
                [
                    'id' => 'jenjang',
                    'name' => 'Jenjang Sekolah',
                    'isDropdown' => true,
                    'children' => [
                        [
                            'id' => 'sma',
                            'name' => 'SMA Taruna Nusantara Indonesia',
                            'url' => '/profile/sma',
                        ],
                        [
                            'id' => 'smk',
                            'name' => 'SMK Taruna Nusantara Jaya',
                            'url' => '/profile/smk',
                        ],
                    ],
                ],
                [
                    'id' => 'achievement',
                    'name' => 'Prestasi Sekolah',
                    'url' => '/achievement',
                ],
                [
                    'id' => 'news',
                    'name' => 'Berita Sekolah',
                    'url' => '/news',
                ],
                [
                    'id' => 'facility',
                    'name' => 'Fasilitas Sekolah',
                    'url' => '/facility',
                ],
                [
                    'id' => 'alumni',
                    'name' => 'Alumni Sekolah',
                    'url' => '/alumni',
                ],
                [
                    'id' => 'ekstrakurikuler',
                    'name' => 'Ekstrakurikuler',
                    'url' => '/ekstrakurikuler',
                ],
            ],
        ],
        [
            'id' => 'login',
            'name' => 'Pendaftaran',
            'url' => '/login',
            'icon' => 'user-circle',
            'isDropdown' => false,
            'isButton' => true,
        ],
    ];

    public function render()
    {
        $currentPath = '/' . request()->path();
        if ($currentPath === '//') {
            $currentPath = '/';
        }
        
        return view('livewire.components.landing.navbar', [
            'currentUrl' => $currentPath,
        ]);
    }
}
