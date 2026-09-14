<?php

namespace App\Livewire\Siswa;

use Livewire\Component;

class PpdbClosedPage extends Component
{
    public function render()
    {
        return view('livewire.siswa.ppdb-closed-page')
            ->layout('layouts.blank', ['title' => 'SPMB Ditutup']);
    }
}
