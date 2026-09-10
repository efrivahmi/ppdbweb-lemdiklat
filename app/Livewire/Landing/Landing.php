<?php

namespace App\Livewire\Landing;

use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Landing extends Component
{
    public function render()
    {
        $introVideo = \App\Models\Landing\YoutubeVideo::where('is_active', true)
            ->where('is_intro', true)
            ->first();

        return view('livewire.landing.landing', compact('introVideo'));
    }
}
