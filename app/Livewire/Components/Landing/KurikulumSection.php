<?php

namespace App\Livewire\Components\Landing;

use Livewire\Component;
use App\Models\Landing\Kurikulum;

class KurikulumSection extends Component
{
    public $kurikulum;
    public $isLoading = true;
    public $errorMessage = null;

    public function mount()
    {
        try {
            $this->kurikulum = Kurikulum::where('is_single', true)->first();
            if (!$this->kurikulum) {
                $this->errorMessage = "Data kurikulum belum diatur oleh admin.";
            }
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.components.landing.kurikulum-section', [
            'kurikulum' => $this->kurikulum,
        ]);
    }
}
