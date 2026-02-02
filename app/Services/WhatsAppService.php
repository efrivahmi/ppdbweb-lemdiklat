<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Service using Fonnte API
 * 
 * Fonnte is a free Indonesian WhatsApp API.
 * Register at https://fonnte.com to get your API token.
 * 
 * Free tier: 500 messages/day
 */
class WhatsAppService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('whatsapp.fonnte.token');
        $this->baseUrl = config('whatsapp.fonnte.base_url', 'https://api.fonnte.com');
    }

    /**
     * Send a WhatsApp message
     */
    public function send(string $phone, string $message, ?string $fileUrl = null): array
    {
        if (empty($this->token)) {
            Log::warning('WhatsApp: Token not configured');
            return ['success' => false, 'message' => 'Token not configured'];
        }

        // Clean phone number (remove spaces, dashes, etc)
        $phone = $this->cleanPhoneNumber($phone);

        try {
            $payload = [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62', // Indonesia
            ];

            if ($fileUrl) {
                $payload['url'] = $fileUrl;
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->baseUrl . '/send', $payload);

            $result = $response->json();

            Log::info('WhatsApp sent', [
                'phone' => $phone,
                'status' => $result['status'] ?? 'unknown',
            ]);

            return [
                'success' => ($result['status'] ?? false) === true,
                'data' => $result,
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send message using template
     */
    public function sendTemplate(string $phone, string $templateName, array $data = []): array
    {
        $template = config("whatsapp.templates.{$templateName}");
        
        if (!$template) {
            return ['success' => false, 'message' => "Template '{$templateName}' not found"];
        }

        // Replace placeholders
        $message = $this->replacePlaceholders($template, $data);

        return $this->send($phone, $message);
    }

    /**
     * Send welcome message after registration
     */
    public function sendWelcome(string $phone, string $nama): array
    {
        if (!config('whatsapp.notifications.send_welcome', true)) {
            return ['success' => false, 'message' => 'Welcome messages disabled'];
        }

        return $this->sendTemplate($phone, 'welcome', [
            'nama' => $nama,
            'url' => route('login'),
        ]);
    }

    /**
     * Send incomplete data reminder
     */
    public function sendDataReminder(string $phone, string $nama, array $missingData): array
    {
        if (!config('whatsapp.notifications.send_data_reminder', true)) {
            return ['success' => false, 'message' => 'Data reminders disabled'];
        }

        $dataList = collect($missingData)->map(fn($item) => "❌ {$item}")->join("\n");

        return $this->sendTemplate($phone, 'incomplete_data', [
            'nama' => $nama,
            'daftar_data_kosong' => $dataList,
            'url' => route('siswa.dashboard'),
        ]);
    }

    /**
     * Send payment reminder
     */
    public function sendPaymentReminder(string $phone, string $nama, array $paymentInfo): array
    {
        if (!config('whatsapp.notifications.send_payment_reminder', true)) {
            return ['success' => false, 'message' => 'Payment reminders disabled'];
        }

        return $this->sendTemplate($phone, 'payment_reminder', [
            'nama' => $nama,
            'nominal' => number_format($paymentInfo['nominal'] ?? 0, 0, ',', '.'),
            'bank' => $paymentInfo['bank'] ?? '-',
            'no_rek' => $paymentInfo['no_rek'] ?? '-',
            'url' => route('siswa.dashboard'),
        ]);
    }

    /**
     * Send payment verified notification
     */
    public function sendPaymentVerified(string $phone, string $nama, string $status): array
    {
        if (!config('whatsapp.notifications.send_status_update', true)) {
            return ['success' => false, 'message' => 'Status updates disabled'];
        }

        $statusText = match($status) {
            'success' => 'DIVERIFIKASI ✅',
            'decline' => 'DITOLAK ❌',
            default => $status,
        };

        $pesanTambahan = match($status) {
            'success' => 'Pembayaranmu telah dikonfirmasi. Silakan cek dashboard untuk langkah selanjutnya.',
            'decline' => 'Mohon upload ulang bukti transfer yang valid.',
            default => '',
        };

        return $this->sendTemplate($phone, 'payment_verified', [
            'nama' => $nama,
            'status' => $statusText,
            'pesan_tambahan' => $pesanTambahan,
            'url' => route('siswa.dashboard'),
        ]);
    }

    /**
     * Send status update notification
     */
    public function sendStatusUpdate(string $phone, string $nama, string $status, string $pesan = ''): array
    {
        if (!config('whatsapp.notifications.send_status_update', true)) {
            return ['success' => false, 'message' => 'Status updates disabled'];
        }

        return $this->sendTemplate($phone, 'status_update', [
            'nama' => $nama,
            'status' => strtoupper($status),
            'pesan_tambahan' => $pesan,
            'url' => route('siswa.dashboard'),
        ]);
    }

    /**
     * Send acceptance notification
     */
    public function sendAccepted(string $phone, string $nama, string $sekolah, string $instruksi = ''): array
    {
        return $this->sendTemplate($phone, 'accepted', [
            'nama' => $nama,
            'sekolah' => $sekolah,
            'instruksi' => $instruksi ?: "Silakan cek dashboard untuk detail registrasi ulang.",
            'url' => route('siswa.dashboard'),
        ]);
    }

    /**
     * Send rejection notification
     */
    public function sendRejected(string $phone, string $nama): array
    {
        return $this->sendTemplate($phone, 'rejected', [
            'nama' => $nama,
        ]);
    }

    /**
     * Clean phone number
     */
    protected function cleanPhoneNumber(string $phone): string
    {
        // Remove all non-digits
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert 08xxx to 628xxx
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with 62, add it
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Replace placeholders in template
     */
    protected function replacePlaceholders(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }

    /**
     * Check if WhatsApp is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->token);
    }
}
