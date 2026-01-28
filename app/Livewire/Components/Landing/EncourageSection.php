<?php

namespace App\Livewire\Components\Landing;
use App\Models\Landing\Advantage;
use Livewire\Component;

class EncourageSection extends Component
{
    public $advantages = [];

    public function mount()
    {
        // Ambil data advantages dari database
        $this->advantages = Advantage::getActiveAdvantages()
            ->map(function ($advantage) {
                return [
                    'icon' => $advantage->icon,
                    'title' => $advantage->title,
                    'description' => $advantage->description
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.components.landing.encourage-section');
    }
}