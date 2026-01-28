<?php
namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Landing\Prestasi;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;

#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Achievement extends Component
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
    
    public function getAchievementsQuery()
    {
        $query = Prestasi::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->selectedCategory) {
            $query->where('title', 'like', '%' . $this->selectedCategory . '%');
        }
        
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
    
    public function getAchievementsProperty()
    {
        try {
            return $this->getAchievementsQuery()
                ->paginate(9)
                ->through(function($prestasi) {
                    // Transform image path - SAMA SEPERTI DI AchivementSection
                    $prestasi->image = $prestasi->image 
                        ? asset('storage/' . $prestasi->image) 
                        : null;
                    return $prestasi;
                });
        } catch (\Exception $e) {
            Log::error('Error fetching achievements: ' . $e->getMessage());
            return collect([]);
        }
    }
    
    public function getCategoriesProperty()
    {
        return collect([
            'Akademik',
            'Olahraga', 
            'Seni',
            'Kompetisi',
            'Penelitian',
            'Kepemimpinan'
        ])->map(function($category) {
            return (object)[
                'name' => $category,
                'beritas_count' => Prestasi::where('title', 'like', '%' . $category . '%')->count()
            ];
        });
    }
    
    public function getStatsProperty()
    {
        $allAchievements = Prestasi::query();
        $totalAchievements = $allAchievements->count();
        $totalCategories = $this->categories->count();
        $thisMonthAchievements = Prestasi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return [
            'totalAchievements' => $totalAchievements,
            'totalCategories' => $totalCategories,
            'thisMonthAchievements' => $thisMonthAchievements,
            'filteredCount' => $this->achievements->total()
        ];
    }
    
    public function render()
    {
        return view('livewire.landing.pages.achievement', [
            'achievements' => $this->achievements,
            'categories' => $this->categories,
            'stats' => $this->stats,
        ]);
    }
}