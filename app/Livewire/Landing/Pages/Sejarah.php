<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.landing")]
#[Title("Sejarah Sekolah - Lemdiklat Taruna Nusantara Indonesia")]
class Sejarah extends Component
{
    public function render()
    {
        return view('livewire.landing.pages.sejarah');
    }
}
