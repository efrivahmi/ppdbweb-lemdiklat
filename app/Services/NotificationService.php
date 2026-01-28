<?php

namespace App\Services;

use App\Models\User;
use App\Events\NewRegistration;
use App\Events\PaymentVerified;
use App\Events\PendaftaranStatusUpdated;
use App\Events\DashboardUpdated;
use Illuminate\Support\Facades\Log;

/**
 * Unified Notification Service
 * 
 * Handles all notifications across multiple channels:
 * - Real-time (Pusher)
 * - WhatsApp (Fonnte)
 * - Database (for history)
 */
class NotificationService
{
    protected WhatsAppService $whatsApp;

    public function __construct(WhatsAppService $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }

    /**
     * Notify about new registration
     */
    public function notifyNewRegistration(User $user): void
    {
        // 1. Broadcast to admin dashboard (real-time)
        NewRegistration::dispatch($user);

        // 2. Send WhatsApp welcome message to student
        if ($user->telp) {
            $this->whatsApp->sendWelcome($user->telp, $user->name);
        }

        Log::info('New registration notification sent', ['user_id' => $user->id]);
    }

    /**
     * Notify about payment verification
     */
    public function notifyPaymentVerified(User $user, string $status): void
    {
        // 1. Broadcast to student (private channel) and admin
        PaymentVerified::dispatch($user, $status);

        // 2. Send WhatsApp notification
        if ($user->telp) {
            $this->whatsApp->sendPaymentVerified($user->telp, $user->name, $status);
        }

        Log::info('Payment verification notification sent', [
            'user_id' => $user->id,
            'status' => $status,
        ]);
    }

    /**
     * Notify about status update
     */
    public function notifyStatusUpdate(User $user, string $status, string $message = ''): void
    {
        // 1. Broadcast real-time
        PendaftaranStatusUpdated::dispatch($user, $status, $message);

        // 2. Send WhatsApp
        if ($user->telp) {
            $this->whatsApp->sendStatusUpdate($user->telp, $user->name, $status, $message);
        }

        Log::info('Status update notification sent', [
            'user_id' => $user->id,
            'status' => $status,
        ]);
    }

    /**
     * Send data completion reminder
     */
    public function sendDataReminder(User $user, array $missingData): void
    {
        if ($user->telp && count($missingData) > 0) {
            $this->whatsApp->sendDataReminder($user->telp, $user->name, $missingData);

            Log::info('Data reminder sent', [
                'user_id' => $user->id,
                'missing' => $missingData,
            ]);
        }
    }

    /**
     * Send payment reminder
     */
    public function sendPaymentReminder(User $user, array $paymentInfo): void
    {
        if ($user->telp) {
            $this->whatsApp->sendPaymentReminder($user->telp, $user->name, $paymentInfo);

            Log::info('Payment reminder sent', ['user_id' => $user->id]);
        }
    }

    /**
     * Notify acceptance
     */
    public function notifyAccepted(User $user, string $sekolah, string $instruksi = ''): void
    {
        // 1. Broadcast real-time
        PendaftaranStatusUpdated::dispatch($user, 'diterima', 'Selamat! Kamu diterima!');

        // 2. Send WhatsApp
        if ($user->telp) {
            $this->whatsApp->sendAccepted($user->telp, $user->name, $sekolah, $instruksi);
        }

        Log::info('Acceptance notification sent', ['user_id' => $user->id]);
    }

    /**
     * Notify rejection
     */
    public function notifyRejected(User $user): void
    {
        // 1. Broadcast real-time
        PendaftaranStatusUpdated::dispatch($user, 'ditolak', 'Mohon maaf, kamu tidak diterima.');

        // 2. Send WhatsApp
        if ($user->telp) {
            $this->whatsApp->sendRejected($user->telp, $user->name);
        }

        Log::info('Rejection notification sent', ['user_id' => $user->id]);
    }

    /**
     * Broadcast dashboard update (stats refresh)
     */
    public function refreshDashboard(string $type, array $data = []): void
    {
        DashboardUpdated::dispatch($type, $data);
    }

    /**
     * Check what data is missing for a user
     */
    public function checkMissingData(User $user): array
    {
        $missing = [];

        // Check DataMurid
        $dataMurid = $user->dataMurid;
        if (!$dataMurid || $dataMurid->proses !== '1') {
            $missing[] = 'Data Diri (Biodata)';
        }

        // Check DataOrangTua
        $dataOrangTua = $user->dataOrangTua;
        if (!$dataOrangTua || !$dataOrangTua->nama_ayah || !$dataOrangTua->nama_ibu) {
            $missing[] = 'Data Orang Tua';
        }

        // Check BerkasMurid
        $berkas = $user->berkasMurid;
        if (!$berkas || $berkas->proses !== '1') {
            $missing[] = 'Berkas/Dokumen';
        }

        // Check BuktiTransfer
        $transfer = $user->buktiTransfer;
        if (!$transfer) {
            $missing[] = 'Bukti Pembayaran';
        } elseif ($transfer->status === 'pending') {
            $missing[] = 'Pembayaran (Menunggu Verifikasi)';
        } elseif ($transfer->status === 'decline') {
            $missing[] = 'Pembayaran (Ditolak - Upload Ulang)';
        }

        return $missing;
    }
}
