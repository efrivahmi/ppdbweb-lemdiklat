<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class ToastNotif extends Component
{
    public function showToast()
    {
        LivewireAlert::title('Sukses!')
            ->text('Data berhasil disimpan.')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->show();
    }
    
    public function render()
    {
        return view('livewire.components.toast-notif');
    }
}
