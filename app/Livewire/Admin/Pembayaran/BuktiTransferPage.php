<?php

namespace App\Livewire\Admin\Pembayaran;

use App\Models\Siswa\BuktiTransfer;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Verifikasi Transfer")]
class BuktiTransferPage extends Component
{
    
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';

    public function updateStatus($transferId, $status, NotificationService $notificationService)
    {
        $transfer = BuktiTransfer::with('user')->findOrFail($transferId);
        $transfer->update(['status' => $status]);
        
        $statusText = match($status) {
            'success' => 'diterima',
            'decline' => 'ditolak',
            'pending' => 'pending'
        };
        
        // Send notifications (real-time + WhatsApp)
        $notificationService->notifyPaymentVerified($transfer->user, $status);
        
        $this->dispatch("alert", message: "Transfer berhasil " . $statusText, type: "success");
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
            
        return view('livewire.admin.pembayaran.bukti-transfer-page', ['transfers' => $transfers]);
    }
}