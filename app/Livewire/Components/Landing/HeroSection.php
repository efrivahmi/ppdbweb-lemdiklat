<?php
namespace App\Livewire\Components\Landing;

use App\Models\Landing\ProfileSekolah;
use Livewire\Component;

class HeroSection extends Component
{
    public $heroData;

    public function mount()
    {
        $profile = ProfileSekolah::first(); // Ambil satu-satunya data
        
        $this->heroData = [
            'badge' => [
                'text' => $profile->badge ?? 'Sekolah Unggulan Nasional',
                'variant' => 'emerald',
            ],
            'title' => [
                'text' => $profile->title ?? 'Judul Default',
                'highlight' => 'Taruna',
            ],
            'description' => $profile->content ?? 'Deskripsi default jika tidak ada data.',
            'backgroundImage' => $profile->image ?? 'https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=1986&q=80',
            'mobileBackgroundImage' => $profile->mobile_image ?? ($profile->image ?? 'https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=1986&q=80'),
        ];
    }

    public function render()
    {
        return view('livewire.components.landing.hero-section');
    }
}
