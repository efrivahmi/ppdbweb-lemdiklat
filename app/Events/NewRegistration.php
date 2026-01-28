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
 * Event broadcasted when a new student registers.
 * Notifies admin dashboard in real-time.
 */
class NewRegistration implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-dashboard'),
        ];
    }

    public function broadcastWith(): array
    {
        // Persist to database
         \App\Models\User::where('role', 'admin')
            ->orWhere('role', 'super_admin') // Just in case
            ->chunk(100, function($admins) {
            foreach ($admins as $admin) {
                try {
                    $admin->notifications()->create([
                        'id' => \Illuminate\Support\Str::uuid(),
                        'type' => 'App\Notifications\NewRegistration',
                        'data' => [
                            'user_id' => $this->user->id,
                            'user_name' => $this->user->name,
                            'message' => "Pendaftar baru: {$this->user->name}",
                            'icon' => 'user-plus',
                            'type' => 'registration', 
                        ],
                        'read_at' => null,
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to create notification for admin: ' . $admin->id, ['error' => $e->getMessage()]);
                }
            }
        });

        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'nisn' => $this->user->nisn,
            'message' => "Pendaftar baru: {$this->user->name}",
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new.registration';
    }
}
