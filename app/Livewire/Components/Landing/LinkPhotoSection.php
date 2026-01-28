<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\LinkPhoto;
use Livewire\Component;

class LinkPhotoSection extends Component
{
    public function render()
    {
        $linkPhotos = LinkPhoto::latest()->take(4)->get();
        
        return view('livewire.components.landing.link-photo-section', [
            'linkPhotos' => $linkPhotos
        ]);
    }
}