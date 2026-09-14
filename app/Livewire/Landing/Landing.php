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
        $profile = \Illuminate\Support\Facades\Cache::remember('landing.profile', 3600, function () {
            return \App\Models\Landing\ProfileSekolah::first();
        });

        $localVideo = null;
        if ($profile && $profile->video_is_active && $profile->local_video_path) {
            $localVideo = [
                'title' => $profile->video_title,
                'description' => $profile->video_description,
                'path' => $profile->local_video_path,
            ];
        }

        $heroVideo = \Illuminate\Support\Facades\Cache::remember('landing.heroVideo', 3600, function () {
            return \App\Models\Landing\YoutubeVideo::where('is_active', true)
                ->where('is_intro', false)
                ->orderBy('order', 'asc')
                ->first();
        });

        return view('livewire.landing.landing', [
            'localVideo' => $localVideo,
            'heroVideo' => $heroVideo
        ]);
    }
}
