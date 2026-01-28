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
        return view('livewire.landing.landing');
    }
}
