<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

class ExploreSchoolSection extends Component
{
    public $exploreItems = [
        [
            'id' => 'about',
            'title' => 'Profil Lembaga',
            'desc' => 'Mengenal lebih dekat sejarah, visi, dan misi lembaga penghasil pemimpin bangsa.',
            'icon' => 'ri-building-4-line',
            'url' => '/profile',
            'color' => 'blue'
        ],
        [
            'id' => 'sma',
            'title' => 'SMA Taruna Nusantara',
            'desc' => 'Pendidikan menengah atas dengan kurikulum khusus berbasis kenusantaraan.',
            'icon' => 'ri-school-line',
            'url' => '/profile/sma',
            'color' => 'emerald'
        ],
        [
            'id' => 'smk',
            'title' => 'SMK Taruna Nusantara',
            'desc' => 'Pendidikan kejuruan unggulan siap kerja dengan fasilitas modern.',
            'icon' => 'ri-hammer-line',
            'url' => '/profile/smk',
            'color' => 'amber'
        ],
        [
            'id' => 'achievement',
            'title' => 'Prestasi Sekolah',
            'desc' => 'Jejak langkah keberhasilan para siswa di kancah nasional dan internasional.',
            'icon' => 'ri-trophy-line',
            'url' => '/achievement',
            'color' => 'yellow'
        ],
        [
            'id' => 'facility',
            'title' => 'Fasilitas Kampus',
            'desc' => 'Sarana prasarana lengkap mendukung kegiatan akademik dan non-akademik.',
            'icon' => 'ri-community-line',
            'url' => '/facility',
            'color' => 'purple'
        ],
        [
            'id' => 'alumni',
            'title' => 'Jejaring Alumni',
            'desc' => 'Ikatan persaudaraan kuat dan kontribusi nyata bagi masyarakat.',
            'icon' => 'ri-group-line',
            'url' => '/alumni',
            'color' => 'indigo'
        ],
        [
            'id' => 'ekskul',
            'title' => 'Ekstrakurikuler',
            'desc' => 'Wadah pengembangan bakat dan minat siswa di luar jam pelajaran.',
            'icon' => 'ri-basketball-line',
            'url' => '/ekstrakurikuler',
            'color' => 'rose'
        ]
    ];

    public function render()
    {
        return view('livewire.components.landing.explore-school-section', [
            'items' => $this->exploreItems
        ]);
    }
}
