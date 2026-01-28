<?php

// app/Livewire/Components/Landing/NewsSection.php
namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\Berita;

class NewsSection extends Component
{
    public $sectionData = [];
    public $showPriorityNews = true;
    public $priorityNewsCount = 1;

    public function mount($sectionData = [], $showPriorityNews = true, $priorityNewsCount = 1)
    {
        $this->sectionData = $sectionData ?: $this->getDefaultSectionData();
        $this->showPriorityNews = $showPriorityNews;
        $this->priorityNewsCount = $priorityNewsCount;
    }

    public function getActiveNews()
    {
        return Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->get();
    }

    public function getPriorityNews()
    {
        if (!$this->showPriorityNews) {
            return collect([]);
        }

        // HYBRID: First, try to get manually selected priority news
        $manualPriority = Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->where('is_priority', true)
            ->orderBy('priority_order')
            ->orderByDesc('created_at')
            ->take($this->priorityNewsCount)
            ->get();

        // If admin has manually selected priority news, use those
        if ($manualPriority->count() > 0) {
            return $manualPriority;
        }

        // FALLBACK: If no manual priority set, use latest news as priority
        return Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->take($this->priorityNewsCount)
            ->get();
    }

    public function getRegularNews()
    {
        $limit = $this->sectionData['displayLimit'] ?? 3;
        
        // Get main priority news ID to exclude
        $mainPriorityId = $this->getPriorityNews()->first()?->id;
        
        // HYBRID: First, try to get remaining admin-selected priority news (positions 2, 3, 4)
        $adminSelectedRegular = Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->where('is_priority', true)
            ->when($mainPriorityId, fn($q) => $q->where('id', '!=', $mainPriorityId))
            ->orderBy('priority_order')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();

        // If we have enough admin-selected news, use them
        if ($adminSelectedRegular->count() >= $limit) {
            return $adminSelectedRegular;
        }

        // FALLBACK: Fill remaining slots with latest news
        $excludeIds = $adminSelectedRegular->pluck('id')->toArray();
        if ($mainPriorityId) {
            $excludeIds[] = $mainPriorityId;
        }
        
        $remainingCount = $limit - $adminSelectedRegular->count();
        $latestNews = Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->whereNotIn('id', $excludeIds)
            ->orderByDesc('created_at')
            ->take($remainingCount)
            ->get();

        return $adminSelectedRegular->concat($latestNews);
    }

    public function render()
    {
        return view('livewire.components.landing.news-section', [
            'activeNews' => $this->getActiveNews(),
            'priorityNews' => $this->getPriorityNews(),
            'regularNews' => $this->getRegularNews(),
        ]);
    }

    private function getDefaultSectionData()
    {
        return [
            'badge' => [
                'text' => 'Informasi Terkini',
                'variant' => 'emerald'
            ],
            'title' => [
                'text' => 'Berita & Pengumuman',
                'highlight' => 'Pengumuman',
                'size' => '3xl',
                'className' => ''
            ],
            'button' => [
                'text' => 'Lihat Semua Berita',
                'href' => '/news',
                'variant' => 'success',
                'icon' => 'ArrowRightIcon',
                'iconPosition' => 'right',
                'animation' => 'pulse',
                'className' => 'mb-2'
            ],
            'displayLimit' => 3
        ];
    }
}
