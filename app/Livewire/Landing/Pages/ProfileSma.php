<?php

namespace App\Livewire\Landing\Pages;

use App\Models\Landing\ProfileSekolah;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.landing")]
#[Title("SMA Taruna Nusantara Indonesia")]
class ProfileSma extends Component
{
    public $profile;
    public $heroData;
    public $identityData;
    public $academicData;
    public $uniformData;
    public $ctaData;

    public function mount()
    {
        $this->profile = ProfileSekolah::getSma();
        
        // Use profile data or defaults
        $this->heroData = $this->profile?->hero_data ?? ProfileSekolah::getDefaultHeroData();
        $this->identityData = $this->profile?->identity_data ?? ProfileSekolah::getDefaultIdentityData();
        $this->academicData = $this->profile?->academic_data ?? ProfileSekolah::getDefaultAcademicData();
        $this->uniformData = $this->profile?->uniform_data ?? ProfileSekolah::getDefaultUniformData();
        $this->ctaData = $this->profile?->cta_data ?? ProfileSekolah::getDefaultCtaData();
    }

    public function render()
    {
        return view('livewire.landing.pages.profile-sma');
    }
}
