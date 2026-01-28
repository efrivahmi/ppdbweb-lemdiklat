<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

/**
 * Student Real-time Notification Listener
 * 
 * Listens to private channel events for the authenticated student.
 * Shows toast notifications when their status/payment is updated.
 */
class StudentNotificationListener extends Component
{
    public ?int $userId = null;

    public function mount()
    {
        $this->userId = Auth::id();
    }

    /**
     * Handle pendaftaran status update
     */
    #[On('echo-private:user.{userId},.pendaftaran.status.updated')]
    public function handleStatusUpdated($data)
    {
        $this->dispatch('alert', 
            message: $data['message'] ?? 'Status pendaftaran Anda telah diperbarui!', 
            type: 'info'
        );

        // Dispatch event to refresh any listening components
        $this->dispatch('refresh-status');
    }

    /**
     * Handle payment verification
     */
    #[On('echo-private:user.{userId},.payment.verified')]
    public function handlePaymentVerified($data)
    {
        $type = match($data['status'] ?? 'info') {
            'success' => 'success',
            'decline' => 'error',
            default => 'info',
        };

        $this->dispatch('alert', 
            message: $data['message'] ?? 'Status pembayaran Anda telah diperbarui!', 
            type: $type
        );

        // Dispatch event to refresh dashboard
        $this->dispatch('refresh-payment-status');
    }

    public function render()
    {
        return <<<'HTML'
        <div 
            wire:key="student-notification-listener-{{ $userId }}"
            class="hidden"
            x-data="{
                init() {
                    // Listen to private channel for this user
                    if (window.Echo && {{ $userId }}) {
                        console.log('🔔 Student notification listener active for user:', {{ $userId }});
                        
                        window.Echo.private('user.{{ $userId }}')
                            .listen('.pendaftaran.status.updated', (e) => {
                                console.log('📢 Status updated:', e);
                                $wire.handleStatusUpdated(e);
                            })
                            .listen('.payment.verified', (e) => {
                                console.log('💳 Payment verified:', e);
                                $wire.handlePaymentVerified(e);
                            });
                    }
                }
            }"
        >
            {{-- Hidden component - only handles events --}}
        </div>
        HTML;
    }
}
