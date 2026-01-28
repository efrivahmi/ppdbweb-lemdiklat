<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

/**
 * Send automated reminders to students with incomplete data
 * 
 * Run daily via cron: php artisan ppdb:send-reminders
 */
class SendReminders extends Command
{
    protected $signature = 'ppdb:send-reminders 
                            {--type=all : Type of reminder (all, data, payment)}
                            {--dry-run : Preview without sending}';

    protected $description = 'Send automated WhatsApp reminders to students';

    public function handle(NotificationService $notificationService): int
    {
        $type = $this->option('type');
        $dryRun = $this->option('dry-run');

        $this->info("📢 PPDB Reminder System");
        $this->info("Type: {$type} | Dry Run: " . ($dryRun ? 'Yes' : 'No'));
        $this->newLine();

        // Get all students with incomplete registrations
        $students = User::where('role', 'siswa')
            ->with(['dataMurid', 'dataOrangTua', 'berkasMurid', 'buktiTransfer'])
            ->get();

        $sentCount = 0;
        $skippedCount = 0;

        foreach ($students as $student) {
            // Check what data is missing
            $missingData = $notificationService->checkMissingData($student);

            if (empty($missingData)) {
                $skippedCount++;
                continue;
            }

            if (!$student->telp) {
                $this->warn("⚠️  {$student->name}: No phone number");
                $skippedCount++;
                continue;
            }

            // Determine what type of reminder to send
            $shouldSend = false;
            
            if ($type === 'all') {
                $shouldSend = true;
            } elseif ($type === 'data' && $this->hasMissingData($missingData)) {
                $shouldSend = true;
            } elseif ($type === 'payment' && $this->hasMissingPayment($missingData)) {
                $shouldSend = true;
            }

            if (!$shouldSend) {
                $skippedCount++;
                continue;
            }

            // Display info
            $this->line("📱 {$student->name} ({$student->telp})");
            $this->line("   Missing: " . implode(', ', $missingData));

            if (!$dryRun) {
                $notificationService->sendDataReminder($student, $missingData);
                $this->info("   ✅ Reminder sent!");
            } else {
                $this->comment("   [DRY RUN] Would send reminder");
            }

            $sentCount++;
            $this->newLine();
        }

        $this->newLine();
        $this->info("📊 Summary:");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Students', $students->count()],
                ['Reminders Sent', $sentCount],
                ['Skipped (Complete/No Phone)', $skippedCount],
            ]
        );

        return Command::SUCCESS;
    }

    protected function hasMissingData(array $missing): bool
    {
        return collect($missing)->contains(fn($item) => 
            str_contains($item, 'Data') || str_contains($item, 'Berkas')
        );
    }

    protected function hasMissingPayment(array $missing): bool
    {
        return collect($missing)->contains(fn($item) => 
            str_contains($item, 'Pembayaran')
        );
    }
}
