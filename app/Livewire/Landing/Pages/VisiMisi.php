<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.landing")]
#[Title("Visi & Misi - Lemdiklat Taruna Nusantara Indonesia")]
class VisiMisi extends Component
{
    public function render()
    {
        return view('livewire.landing.pages.visi-misi');
    }
}
