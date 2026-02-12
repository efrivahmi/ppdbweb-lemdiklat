<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;

class FaqSection extends Component
{
    public $activeIndex = null;

    public function toggle($index)
    {
        $this->activeIndex = $this->activeIndex === $index ? null : $index;
    }

    public function render()
    {
        return view('livewire.components.landing.faq-section');
    }
}
