<?php

namespace App\Livewire\Landing\Pages;

use App\Models\Landing\StrukturSekolah;
use App\Models\Landing\FotoStrukturSekolah;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Structure extends Component
{
    public function render()
    {
        $struktur = StrukturSekolah::all();
        $fotoStruktur = FotoStrukturSekolah::first(); 
        
        return view('livewire.landing.pages.structure', [
            'struktur' => $struktur,
            'fotoStruktur' => $fotoStruktur
        ]);
    }
}