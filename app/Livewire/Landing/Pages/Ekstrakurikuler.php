<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Landing\Ekstrakurikuler as EkstrakurikulerModel;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Ekstrakurikuler extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'latest';

    protected $updatesQueryString = ['search', 'sortBy', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sortBy']);
    }

    public function render()
    {
        $query = EkstrakurikulerModel::query();

        // Filter pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('desc', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $ekskul = $query->paginate(6);

        return view('livewire.landing.pages.ekstrakurikuler', [
            'ekskul' => $ekskul,
        ]);
    }
}
