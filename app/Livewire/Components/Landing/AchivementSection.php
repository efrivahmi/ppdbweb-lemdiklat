<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\Prestasi;
use Illuminate\Support\Facades\Log;

class AchivementSection extends Component
{
    public $sectionData = [];
    public $displayLimit = 6;

    public function mount()
    {
        $this->sectionData = [
            'badge' => [
                'text' => 'Prestasi',
                'variant' => 'gold'
            ],
            'title' => [
                'text' => 'Prestasi Gemilang Siswa',
                'highlight' => 'Prestasi',
                'size' => '3xl',
                'className' => ''
            ],
            'button' => [
                'text' => 'Lihat Semua Prestasi',
                'variant' => 'success',
                'theme' => 'light',
                'href' => '/achievement',
                'icon' => 'arrow-right',
                'iconPosition' => 'right',
                'className' => 'group'
            ]
        ];
    }

    public function getAchievementsProperty()
    {
        try {
            $achievements = Prestasi::latest()
                ->take(3) // Langsung 3 tanpa variable
                ->get()
                ->map(function ($prestasi) {
                    return [
                        'id' => $prestasi->id,
                        'title' => $prestasi->title,
                        'description' => $prestasi->description,
                        'image' => $prestasi->image ? asset('storage/' . $prestasi->image) : null,
                        'created_at' => $prestasi->created_at->format('d M Y'),
                    ];
                })
                ->toArray();

            return $achievements;
        } catch (\Exception $e) {
            Log::error('Error fetching achievements: ' . $e->getMessage());
            return [];
        }
    }

    public function handleAchievementClick($achievement)
    {
        Log::info('Achievement clicked: ' . $achievement['title']);
        $this->dispatch('achievement-detail-requested', $achievement);
    }

    public function loadMore()
    {
        $this->displayLimit += 3;
        $this->dispatch('achievements-updated');
    }

    protected $listeners = [
        'achievement-clicked' => 'handleAchievementClick'
    ];

    public function render()
    {
        return view('livewire.components.landing.achivement-section');
    }
}
