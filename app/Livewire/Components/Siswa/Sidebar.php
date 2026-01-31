<?php

namespace App\Livewire\Components\Siswa;

use Livewire\Component;
use App\Models\GelombangPendaftaran;

class Sidebar extends Component
{
    public $sidebarOpen = false;
    public $expandedItems = [];
    public $currentPath;

    protected $menuItems = [
        [
            'key' => 'dashboard',
            'name' => 'Dashboard',
            'url' => 'siswa.dashboard',
            'icon' => 'ri-dashboard-3-line',
            'type' => 'link'
        ],
        [
            'key' => 'panduan',
            'name' => 'Panduan Pendaftaran',
            'url' => 'siswa.panduan',
            'icon' => 'ri-map-pin-user-line',
            'type' => 'link'
        ],
        [
            'key' => 'formulir',
            'name' => 'Formulir',
            'icon' => 'ri-folder-open-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'Data Siswa',
                    'url' => 'siswa.formulir.data-murid',
                    'icon' => 'ri-user-add-line'
                ],
                [
                    'name' => 'Data Orang Tua',
                    'url' => 'siswa.formulir.data-orang-tua',
                    'icon' => 'ri-parent-line'
                ],
                [
                    'name' => 'Berkas Siswa',
                    'url' => 'siswa.formulir.berkas-murid',
                    'icon' => 'ri-book-3-line'
                ]
            ]
        ],
        [
            'key' => 'pendaftaran',
            'name' => 'Jalur Pendaftaran',
            'url' => 'siswa.pendaftaran',
            'icon' => 'ri-clipboard-line',
            'type' => 'link'
        ],
        [
            'key' => 'informasi-tes',
            'name' => 'Informasi Tes',
            'url' => 'siswa.informasi-tes',
            'icon' => 'ri-information-line',
            'type' => 'link'
        ],
        [
            'key' => 'test',
            'name' => 'Test',
            'url' => 'siswa.tests.index',
            'icon' => 'ri-test-tube-line',
            'type' => 'link'
        ],
        // New Pages
        [
            'key' => 'hasil-seleksi',
            'name' => 'Hasil Seleksi',
            'url' => 'siswa.hasil-seleksi',
            'icon' => 'ri-award-line',
            'type' => 'link'
        ],
        [
            'key' => 'surat-verifikasi',
            'name' => 'Surat Verifikasi',
            'url' => 'siswa.surat-verifikasi',
            'icon' => 'ri-file-text-line',
            'type' => 'link'
        ],
    ];

    public function mount()
    {
        $this->currentPath = request()->route()->getName();
        
        // Auto expand menu based on current path, but exclude dashboard
        if ($this->currentPath !== 'siswa.dashboard') {
            if (str_contains($this->currentPath, 'siswa.formulir')) {
                $this->expandedItems[] = 'formulir';
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
        // Ambil gelombang terbaru yang sudah mulai pendaftaran
        $gelombangActive = GelombangPendaftaran::where('pendaftaran_mulai', '<=', now())
                                                ->orderBy('created_at', 'desc')
                                                ->first();

        return view('livewire.components.siswa.sidebar', [
            'menuItems' => $this->getMenuItems(),
            'gelombangActive' => $gelombangActive
        ]);
    }
}