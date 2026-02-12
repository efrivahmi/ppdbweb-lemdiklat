<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Landing\Berita;
use App\Models\Landing\KategoriBerita;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class News extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $sortBy = 'latest';
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'sortBy' => ['except' => 'latest']
    ];

    protected $listeners = [
        'search-changed' => 'handleSearchChange',
        'search-cleared' => 'clearSearch',
        'filters-reset' => 'resetFilters'
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function handleSearchChange($data)
    {
        $this->search = $data['search'] ?? '';
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->sortBy = 'latest';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function getNewsQuery()
    {
        $query = Berita::with(['kategori', 'creator'])
            ->where('is_active', true);

        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->selectedCategory) {
            $query->whereHas('kategori', function($q) {
                $q->where('name', $this->selectedCategory);
            });
        }

        // Sorting options
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        return $query;
    }

    public function getNewsProperty()
    {
        return $this->getNewsQuery()
            ->where('is_priority', false)
            ->paginate(9);
    }

    public function getFeaturedNewsProperty()
    {
        // Only admin-designated priority news
        return Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->where('is_priority', true)
            ->orderBy('priority_order')
            ->get();
    }

    public function getLatestNewsProperty()
    {
        // Recent non-priority news for "Berita Terbaru" section
        return Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->where('is_priority', false)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();
    }

    public function getAllNewsProperty()
    {
        return Berita::with(['kategori', 'creator'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCategoriesProperty()
    {
        return KategoriBerita::where('is_active', true)
            ->withCount(['beritas' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();
    }

    public function getStatsProperty()
    {
        $allNews = Berita::where('is_active', true);
        $totalNews = $allNews->count();
        $totalCategories = KategoriBerita::where('is_active', true)->count();
        $thisMonthNews = $allNews->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            'totalNews' => $totalNews,
            'totalCategories' => $totalCategories,
            'thisMonthNews' => $thisMonthNews,
            'filteredCount' => $this->news->total()
        ];
    }

    public function render()
    {
        return view('livewire.landing.pages.news', [
            'news' => $this->news,
            'featuredNews' => $this->featuredNews,
            'latestNews' => $this->latestNews,
            'allNews' => $this->allNews, 
            'categories' => $this->categories,
            'stats' => $this->stats,
        ]);
    }
}