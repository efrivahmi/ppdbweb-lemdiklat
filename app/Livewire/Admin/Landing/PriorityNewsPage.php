<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Berita;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Berita Prioritas")]
class PriorityNewsPage extends Component
{
    public $search = '';
    public $priorityNews = [];

    public function mount()
    {
        $this->loadPriorityNews();
    }

    public function loadPriorityNews()
    {
        $this->priorityNews = Berita::where('is_priority', true)
            ->orderBy('priority_order')
            ->get()
            ->toArray();
    }

    public function togglePriority($id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->is_priority) {
            // Remove from priority
            $berita->update([
                'is_priority' => false,
                'priority_order' => null
            ]);
            $this->reorderPriorityNews();
            $this->dispatch('alert', message: 'Berita dihapus dari prioritas', type: 'success');
        } else {
            // Check max 4 limit
            $currentCount = Berita::where('is_priority', true)->count();
            if ($currentCount >= 4) {
                $this->dispatch('alert', message: 'Maksimal 4 berita prioritas! Hapus salah satu terlebih dahulu.', type: 'error');
                return;
            }
            
            // Add to priority
            $maxOrder = Berita::where('is_priority', true)->max('priority_order') ?? 0;
            $berita->update([
                'is_priority' => true,
                'priority_order' => $maxOrder + 1
            ]);
            $this->dispatch('alert', message: 'Berita ditambahkan ke prioritas', type: 'success');
        }
        
        $this->loadPriorityNews();
    }

    public function updateOrder($newsId, $direction)
    {
        $berita = Berita::findOrFail($newsId);
        $currentOrder = $berita->priority_order;
        
        if ($direction === 'up' && $currentOrder > 1) {
            // Find the item above and swap
            $above = Berita::where('is_priority', true)
                ->where('priority_order', '<', $currentOrder)
                ->orderByDesc('priority_order')
                ->first();
            
            if ($above) {
                $aboveOrder = $above->priority_order;
                $above->update(['priority_order' => $currentOrder]);
                $berita->update(['priority_order' => $aboveOrder]);
            }
        } elseif ($direction === 'down') {
            // Find the item below and swap
            $below = Berita::where('is_priority', true)
                ->where('priority_order', '>', $currentOrder)
                ->orderBy('priority_order')
                ->first();
            
            if ($below) {
                $belowOrder = $below->priority_order;
                $below->update(['priority_order' => $currentOrder]);
                $berita->update(['priority_order' => $belowOrder]);
            }
        }
        
        $this->loadPriorityNews();
    }

    public function removePriority($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->update([
            'is_priority' => false,
            'priority_order' => null
        ]);
        
        // Reorder remaining priority news
        $this->reorderPriorityNews();
        $this->loadPriorityNews();
        
        $this->dispatch('alert', message: 'Berita dihapus dari prioritas', type: 'success');
    }

    protected function reorderPriorityNews()
    {
        $priorityNews = Berita::where('is_priority', true)
            ->orderBy('priority_order')
            ->get();
        
        $order = 1;
        foreach ($priorityNews as $news) {
            $news->update(['priority_order' => $order]);
            $order++;
        }
    }

    public function render()
    {
        $availableNews = Berita::with(['kategori'])
            ->where('is_active', true)
            ->where('is_priority', false)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        $priorityNewsList = Berita::with(['kategori'])
            ->where('is_priority', true)
            ->orderBy('priority_order')
            ->get();

        return view('livewire.admin.landing.priority-news-page', [
            'availableNews' => $availableNews,
            'priorityNewsList' => $priorityNewsList,
        ]);
    }
}
