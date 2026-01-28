<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\YoutubeVideo;
use Livewire\Component;

class LinkYoutube extends Component
{
    public $videos = [];

    public function mount()
    {
        $this->videos = YoutubeVideo::active()->ordered()->get();
    }

    public function render()
    {
        return view('livewire.components.landing.link-youtube');
    }
}