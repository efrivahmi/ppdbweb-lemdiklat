<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

use App\Models\Admin\SchoolSetting;

class LocationSection extends Component
{
    public function render()
    {
        $settings = SchoolSetting::getCached();
        return view('livewire.components.landing.location-section', [
            'settings' => $settings
        ]);
    }
}
