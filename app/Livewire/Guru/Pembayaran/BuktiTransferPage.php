<?php

namespace App\Livewire\Guru\Pembayaran;

use App\Models\Siswa\BuktiTransfer;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.guru")]
#[Title("Verifikasi Pembayaran")]
class BuktiTransferPage extends Component
{
    
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';

    public function updateStatus($transferId, $status)
    {
        $transfer = BuktiTransfer::findOrFail($transferId);
        $transfer->update(['status' => $status]);
        
        $statusText = match($status) {
            'success' => 'diterima',
            'decline' => 'ditolak',
            'pending' => 'pending'
        };
        
        $this->dispatch('success', message: "Transfer berhasil di{$statusText}");
    }

    public function render()
    {
        $transfers = BuktiTransfer::with(['user'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.guru.pembayaran.bukti-transfer-page', ['transfers' => $transfers]);
    }
}