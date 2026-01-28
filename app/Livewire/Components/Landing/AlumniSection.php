<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\Alumni;
use Livewire\Component;

class AlumniSection extends Component
{
    public function render()
    {
        // Ambil 3 alumni terpilih terbaru dengan relasi jurusan
        $selectedAlumni = Alumni::with('jurusan')
            ->where('is_selected', true)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.components.landing.alumni-section', [
            'alumnis' => $selectedAlumni
        ]);
    }
}