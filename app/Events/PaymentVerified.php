<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event broadcasted when a payment (bukti transfer) is verified.
 * Notifies the student instantly about their payment status.
 */
class PaymentVerified implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public string $status, // 'success', 'decline', 'pending'
        public string $message = ''
    ) {
        $statusMessages = [
            'success' => 'Pembayaran Anda telah diverifikasi! ✅',
            'decline' => 'Pembayaran Anda ditolak. Silakan upload ulang bukti transfer.',
            'pending' => 'Bukti transfer Anda sedang diproses.',
        ];
        $this->message = $message ?: ($statusMessages[$status] ?? 'Status pembayaran diperbarui.');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user->id),
            new PrivateChannel('admin-dashboard'),
        ];
    }

    public function broadcastWith(): array
    {
        // Persist to database for the user
        $this->user->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\PaymentVerified',
            'data' => [
                'status' => $this->status,
                'message' => $this->message,
                'icon' => $this->status === 'success' ? 'check-circle' : ($this->status === 'decline' ? 'x-circle' : 'clock'),
                'type' => 'payment',
            ],
            'read_at' => null,
        ]);

        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'status' => $this->status,
            'message' => $this->message,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'payment.verified';
    }
}
