<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\Gallery;
use Livewire\Component;

class GallerySection extends Component
{
    public function render()
    {
        $galleries = Gallery::latest()->get();
        
        return view('livewire.components.landing.gallery-section', [
            'galleries' => $galleries
        ]);
    }
}