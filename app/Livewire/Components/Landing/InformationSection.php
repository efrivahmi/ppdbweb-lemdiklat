<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\Information;
use Livewire\Component;

class InformationSection extends Component
{
    public $informations = [];

    public function mount()
    {
        // Mengambil data dari database
        $this->informations = Information::getActiveOrdered()
            ->map(function ($info) {
                return [
                    'icon' => $info->icon,
                    'title' => $info->title,
                    'url' => $info->url,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.components.landing.information-section');
    }
}