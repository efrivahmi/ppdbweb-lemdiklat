<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;

class Sidebar extends Component
{
    public $sidebarOpen = false;
    public $expandedItems = [];
    public $currentPath;

    protected $menuItems = [
        // 1. Dashboard
        [
            'key' => 'dashboard',
            'name' => 'Dashboard',
            'url' => 'admin.dashboard',
            'icon' => 'ri-dashboard-3-line',
            'type' => 'link'
        ],

        // 2. Pengguna
        [
            'key' => 'pengguna',
            'name' => 'Pengguna',
            'icon' => 'ri-group-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'Admin',
                    'url' => 'admin.admin',
                    'icon' => 'ri-admin-line'
                ],
                [
                    'name' => 'Guru',
                    'url' => 'admin.guru',
                    'icon' => 'ri-user-3-line'
                ],
                [
                    'name' => 'Siswa',
                    'url' => 'admin.siswa',
                    'icon' => 'ri-user-add-line'
                ],
            ]
        ],

        // 3. Data Pendaftaran
        [
            'key' => 'pendaftaran',
            'name' => 'Data Pendaftaran',
            'icon' => 'ri-survey-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'Gelombang Pendaftaran',
                    'url' => 'admin.pendaftaran.gelombang',
                    'icon' => 'ri-calendar-schedule-line'
                ],
                [
                    'name' => 'Jalur Pendaftaran',
                    'url' => 'admin.pendaftaran.jalur',
                    'icon' => 'ri-stack-line'
                ],
                [
                    'name' => 'Jenjang Sekolah & Jurusan',
                    'url' => 'admin.pendaftaran.tipe',
                    'icon' => 'ri-parent-line'
                ],
                [
                    'name' => 'Jalur Tes',
                    'url' => 'admin.pendaftaran.tes-jalur',
                    'icon' => 'ri-book-3-line'
                ],
                [
                    'name' => 'Custom Test',
                    'url' => 'admin.pendaftaran.custom-test',
                    'icon' => 'ri-question-answer-line'
                ],
                [
                    'name' => 'Review Jawaban',
                    'url' => 'admin.review-answers',
                    'icon' => 'ri-check-double-line'
                ],
                [
                    'name' => 'Akun Bank',
                    'url' => 'admin.pembayaran.bank-account',
                    'icon' => 'ri-bank-line'
                ],
                [
                    'name' => 'Bukti Transfer',
                    'url' => 'admin.pembayaran.bukti-transfer',
                    'icon' => 'ri-wallet-3-line'
                ],
                [
                    'name' => 'Mata Pelajaran',
                    'url' => 'admin.guru.mapel',
                    'icon' => 'ri-book-open-line'
                ],
            ]
        ],

        // 4. Data Landing Page (diurutkan alfabetis)
        [
            'key' => 'landing-page',
            'name' => 'Data Landing Page',
            'icon' => 'ri-database-2-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'About',
                    'url' => 'admin.landing.about',
                    'icon' => 'ri-information-line'
                ],
                [
                    'name' => 'Alumni',
                    'url' => 'admin.landing.alumni',
                    'icon' => 'ri-user-star-line'
                ],
                [
                    'name' => 'Berita',
                    'url' => 'admin.landing.berita',
                    'icon' => 'ri-news-line'
                ],
                [
                    'name' => 'Berita Prioritas',
                    'url' => 'admin.landing.priority-news',
                    'icon' => 'ri-star-line'
                ],
                [
                    'name' => 'Encourage',
                    'url' => 'admin.landing.encourage',
                    'icon' => 'ri-lightbulb-line'
                ],
                [
                    'name' => 'Ekstrakurikuler',
                    'url' => 'admin.landing.ekstrakurikuler',
                    'icon' => 'ri-trophy-line'
                ],
                [
                    'name' => 'Fasilitas',
                    'url' => 'admin.landing.fasilitas',
                    'icon' => 'ri-community-line'
                ],
                [
                    'name' => 'Footer',
                    'url' => 'admin.landing.footer',
                    'icon' => 'ri-layout-bottom-line'
                ],
                [
                    'name' => 'Gallery',
                    'url' => 'admin.landing.gallery',
                    'icon' => 'ri-gallery-line'
                ],
                [
                    'name' => 'Hero Beranda',
                    'url' => 'admin.landing.profile-sekolah',
                    'icon' => 'ri-home-smile-line'
                ],
                [
                    'name' => 'Hero Profile',
                    'url' => 'admin.landing.hero-profile',
                    'icon' => 'ri-profile-line'
                ],
                [
                    'name' => 'Hero SPMB',
                    'url' => 'admin.landing.hero-spmb',
                    'icon' => 'ri-book-open-line'
                ],
                [
                    'name' => 'Information',
                    'url' => 'admin.landing.information',
                    'icon' => 'ri-information-2-line'
                ],
                [
                    'name' => 'Kategori Berita',
                    'url' => 'admin.landing.kategori-berita',
                    'icon' => 'ri-newspaper-line'
                ],
                [
                    'name' => 'Kurikulum',
                    'url' => 'admin.landing.kurikulum',
                    'icon' => 'ri-book-2-line'
                ],
                [
                    'name' => 'Link Photo',
                    'url' => 'admin.landing.link-photo',
                    'icon' => 'ri-link'
                ],
                [
                    'name' => 'Link youtube',
                    'url' => 'admin.landing.link-youtube',
                    'icon' => 'ri-youtube-line'
                ],
                [
                    'name' => 'PDF Settings',
                    'url' => 'admin.landing.pdf-settings',
                    'icon' => 'ri-file-pdf-line'
                ],
                [
                    'name' => 'Persyaratan',
                    'url' => 'admin.landing.persyaratan',
                    'icon' => 'ri-file-list-3-line'
                ],
                [
                    'name' => 'Prestasi',
                    'url' => 'admin.landing.prestasi',
                    'icon' => 'ri-medal-line'
                ],
                [
                    'name' => 'Stats',
                    'url' => 'admin.landing.stats-section',
                    'icon' => 'ri-bar-chart-line'
                ],
                // [
                //     'name' => 'Struktur Sekolah',
                //     'url' => 'admin.landing.struktur-sekolah',
                //     'icon' => 'ri-organization-chart'
                // ],
                [
                    'name' => 'Visi Misi',
                    'url' => 'admin.landing.visi-misi',
                    'icon' => 'ri-focus-3-line'
                ],
            ]
        ],

        // 5. Profile Sekolah
        [
            'key' => 'profile-sekolah',
            'name' => 'Profile Sekolah',
            'icon' => 'ri-school-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'SMA Taruna Nusantara',
                    'url' => 'admin.profile-sekolah.sma',
                    'icon' => 'ri-graduation-cap-line'
                ],
                [
                    'name' => 'SMK Taruna Nusantara',
                    'url' => 'admin.profile-sekolah.smk',
                    'icon' => 'ri-tools-line'
                ],
            ]
        ],

        // 6. Pengaturan
        [
            'key' => 'settings',
            'name' => 'Pengaturan',
            'icon' => 'ri-settings-3-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'Pengaturan Sekolah',
                    'url' => 'admin.settings.school',
                    'icon' => 'ri-school-line'
                ],
            ]
        ]
    ];


    public function mount()
    {
        $this->currentPath = request()->route()->getName();

        // Auto expand menu based on current path, but exclude dashboard
        if ($this->currentPath !== 'admin.dashboard') {
            if (
                str_contains($this->currentPath, 'admin.admin') ||
                str_contains($this->currentPath, 'admin.siswa') ||
                str_contains($this->currentPath, 'admin.guru')
            ) {
                $this->expandedItems[] = 'pengguna';
            }

            if (
                str_contains($this->currentPath, 'admin.pendaftaran') ||
                str_contains($this->currentPath, 'admin.pembayaran') ||
                str_contains($this->currentPath, 'admin.review-answers')
            ) {
                $this->expandedItems[] = 'pendaftaran';
            }

            if (str_contains($this->currentPath, 'admin.landing')) {
                $this->expandedItems[] = 'landing-page';
            }

            if (str_contains($this->currentPath, 'admin.settings')) {
                $this->expandedItems[] = 'settings';
            }
        }
    }

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    public function closeSidebar()
    {
        $this->sidebarOpen = false;
    }

    public function toggleExpanded($key)
    {
        if (in_array($key, $this->expandedItems)) {
            $this->expandedItems = array_filter($this->expandedItems, fn($item) => $item !== $key);
        } else {
            $this->expandedItems[] = $key;
        }
    }

    public function isActiveRoute($route)
    {
        // Exact match only - no partial matching to avoid double active
        return $this->currentPath === $route;
    }

    public function isActiveParent($key, $children)
    {
        // Check if any child is currently active
        foreach ($children as $child) {
            if ($this->currentPath === $child['url']) {
                return true;
            }
        }
        return false;
    }

    public function getMenuItems()
    {
        return collect($this->menuItems)->map(function ($item) {
            if (isset($item['url'])) {
                $item['url'] = route($item['url']);
                $item['route_name'] = $this->getRouteNameFromItem($item);
            }
            if (isset($item['children'])) {
                $item['children'] = collect($item['children'])->map(function ($child) {
                    $child['url'] = route($child['url']);
                    $child['route_name'] = $this->getRouteNameFromItem($child);
                    return $child;
                })->toArray();
            }
            return $item;
        })->toArray();
    }

    private function getRouteNameFromItem($item)
    {
        // Extract route name from the original menu items
        if (isset($item['url']) && is_string($item['url'])) {
            // Find the original route name in menuItems
            return $this->findOriginalRouteName($item['url']);
        }
        return null;
    }

    private function findOriginalRouteName($url)
    {
        foreach ($this->menuItems as $menuItem) {
            if (isset($menuItem['url']) && route($menuItem['url']) === $url) {
                return $menuItem['url'];
            }
            if (isset($menuItem['children'])) {
                foreach ($menuItem['children'] as $child) {
                    if (route($child['url']) === $url) {
                        return $child['url'];
                    }
                }
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.components.admin.sidebar', [
            'menuItems' => $this->getMenuItems()
        ]);
    }
}
