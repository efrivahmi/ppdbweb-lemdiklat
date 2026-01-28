<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\VisiMisi;

class VisiMisiSection extends Component
{
    public $visiData = [];
    public $misiData = [];

    public function mount()
    {
        $this->loadVisiMisiData();
    }

    public function loadVisiMisiData()
    {
        $this->visiData = VisiMisi::getVisiData();
        $this->misiData = VisiMisi::getMisiData();
    }

    public function render()
    {
        return view('livewire.components.landing.visi-misi-section');
    }
}