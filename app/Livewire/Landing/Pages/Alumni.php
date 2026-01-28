<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use App\Models\Landing\Alumni as AlumniModel;
use App\Models\Pendaftaran\Jurusan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Alumni extends Component
{
    #[Url]
    public $jurusan_id = null;
    
    #[Url]
    public $search = '';
    
    public $sortBy = 'latest';


    public function mount()
    {
        // Initialize default values if needed
    }

    public function updatedJurusanId()
    {
        // This method will be called when jurusan_id is updated
        $this->resetPage();
    }

    public function updatedSearch()
    {
        // This method will be called when search is updated
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        // This method will be called when sortBy is updated
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['jurusan_id', 'search', 'sortBy']);
        $this->sortBy = 'latest';
    }

    public function filterByJurusan($jurusanId)
    {
        $this->jurusan_id = $jurusanId;
    }

    protected function resetPage()
    {
        // Reset pagination if you're using it
        // $this->resetPage();
    }


    public function render()
    {
        $alumnis = AlumniModel::with('jurusan')
            ->when($this->jurusan_id, function ($query) {
                $query->where('jurusan_id', $this->jurusan_id);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('desc', 'like', '%' . $this->search . '%')
                      ->orWhereHas('jurusan', function ($subQuery) {
                          $subQuery->where('nama', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest();
            })
            ->when($this->sortBy === 'name_asc', function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->when($this->sortBy === 'name_desc', function ($query) {
                $query->orderBy('name', 'desc');
            })
            ->when($this->sortBy === 'tahun_lulus_desc', function ($query) {
                $query->orderBy('tahun_lulus', 'desc');
            })
            ->when($this->sortBy === 'tahun_lulus_asc', function ($query) {
                $query->orderBy('tahun_lulus', 'asc');
            })
            ->get();

    
            $jurusans = Jurusan::all();
        // Statistics
        $totalAlumni = $alumnis->count();
        $selectedAlumni = $alumnis->where('is_selected', true)->count();
        $jurusanStats = $jurusans->map(function ($jurusan) {
            return [
                'jurusan' => $jurusan,
                'count' => AlumniModel::where('jurusan_id', $jurusan->id)->count()
            ];
        });

        return view('livewire.landing.pages.alumni', compact(
            'alumnis', 
            'jurusans', 
            'totalAlumni', 
            'selectedAlumni', 
            'jurusanStats'
        ));
    }
}