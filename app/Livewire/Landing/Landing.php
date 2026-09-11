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
        $introVideo = \Illuminate\Support\Facades\Cache::remember('landing.introVideo', 3600, function () {
            return \App\Models\Landing\YoutubeVideo::where('is_active', true)
                ->where('is_intro', true)
                ->first();
        });

        $heroVideo = \Illuminate\Support\Facades\Cache::remember('landing.heroVideo', 3600, function () {
            return \App\Models\Landing\YoutubeVideo::where('is_active', true)
                ->where('is_intro', false)
                ->orderBy('order', 'asc')
                ->first();
        });

        return view('livewire.landing.landing', compact('introVideo', 'heroVideo'));
    }
}
