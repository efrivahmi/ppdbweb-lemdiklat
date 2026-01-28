<?php

namespace App\Livewire\Components\Guru;

use Livewire\Component;

class Sidebar extends Component
{
    public $sidebarOpen = false;
    public $expandedItems = [];
    public $currentPath;

    protected $menuItems = [
        [
            'key' => 'dashboard',
            'name' => 'Dashboard',
            'url' => 'guru.dashboard',
            'icon' => 'ri-dashboard-3-line',
            'type' => 'link'
        ],
        [
            'key' => 'pendaftaran',
            'name' => 'Data Pendaftaran',
            'icon' => 'ri-survey-line',
            'type' => 'folder',
            'children' => [
                [
                    'name' => 'Jalur Tes',
                    'url' => 'guru.pendaftaran.tes-jalur',
                    'icon' => 'ri-book-3-line'
                ],
                [
                    'name' => "Custom Test",
                    'url' => "guru.pendaftaran.custom-test",
                    'icon' => 'ri-question-answer-line'
                ],
                [
                    'name' => "Review Jawaban",
                    'url' => 'guru.review-answers',
                    'icon' => 'ri-clipboard-line'
                ],
            ]
        ],
    ];

    public function mount()
    {
        $this->currentPath = request()->route()->getName();
        
        // Auto expand menu based on current path, but exclude dashboard
        if ($this->currentPath !== 'guru.dashboard') {
            if (str_contains($this->currentPath, 'guru.siswa')) {
                $this->expandedItems[] = 'pengguna';
            }
            
            if (str_contains($this->currentPath, 'guru.pendaftaran') || 
                str_contains($this->currentPath, 'guru.review-answers')) {
                $this->expandedItems[] = 'pendaftaran';
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
        return view('livewire.components.guru.sidebar', [
            'menuItems' => $this->getMenuItems()
        ]);
    }
}