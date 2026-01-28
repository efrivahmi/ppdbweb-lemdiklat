<?php

namespace App\Livewire\Components\Landing;

use App\Models\Landing\Footer;
use Livewire\Component;

class FooterSection extends Component
{
    public $footerData;

    public function mount()
    {
        $this->footerData = Footer::getActive();
    }

    public function render()
    {
        return view('livewire.components.landing.footer-section');
    }
}