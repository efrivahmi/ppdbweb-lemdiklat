<?php

namespace App\Livewire\Landing\Pages;

use App\Models\Landing\Fasilitas;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Facility extends Component
{
    public function getFacilitiesProperty()
    {
        return Fasilitas::where('is_active', true)
                       ->orderBy('created_at', 'desc')
                       ->get();
    }

    public function render()
    {
        return view('livewire.landing.pages.facility', [
            'facilities' => $this->facilities,
        ]);
    }
}