<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\HeroProfile as HeroProfileModel;

class HeroProfile extends Component
{
    public $heroData = [];

    public function mount()
    {
        // Ambil satu data pertama dari tabel hero_profiles
        $profile = HeroProfileModel::first();

        // Setup hero data dengan fallback
        $this->heroData = [
            'backgroundImage' => $this->getBackgroundImage($profile),
        ];
    }

    /**
     * Get background image with fallback
     */
    private function getBackgroundImage($profile)
    {
        if ($profile && $profile->image) {
            // Check if image exists in storage
            $imagePath = storage_path('app/public/' . $profile->image);
            if (file_exists($imagePath)) {
                return $profile->image;
            }
        }

        // Return null to use gradient fallback
        return null;
    }

    public function render()
    {
        return view('livewire.components.landing.hero-profile');
    }
}