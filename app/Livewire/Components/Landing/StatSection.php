<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\StatSections;

class StatSection extends Component
{
    public $statsData = [];

    public function loadStats()
    {
        // Ambil data terbaru dari DB
        $this->statsData = StatSections::all(['label', 'value'])->toArray();
    }

    public function render()
    {
        // selalu load stats tiap render
        $this->loadStats();

        return view('livewire.components.landing.stat-section', [
            'statsData' => $this->statsData,
        ]);
    }
}