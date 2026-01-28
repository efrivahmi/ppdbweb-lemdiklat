<?php

namespace App\Livewire\Components\Landing;

use App\Models\Pendaftaran\JalurPendaftaran;
use Livewire\Component;

class JalurPendaftaranSection extends Component
{
    public function render()
    {
        $jalurs = JalurPendaftaran::latest()->take(3)->get();
        
        return view('livewire.components.landing.jalur-pendaftaran-section', [
            'jalurs' => $jalurs
        ]);
    }
}