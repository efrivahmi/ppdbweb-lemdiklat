<?php

namespace App\Console\Commands;

use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Pendaftaran\CustomTest;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDuplicateAnswers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:duplicate-answers 
                            {--dry-run : Show duplicates without making changes}
                            {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identify and reset duplicate answers caused by state binding bugs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Scanning for duplicate answers...');
        $this->newLine();

        // Find users with duplicate answers in the same test
        $duplicates = $this->findDuplicateAnswers();

        if ($duplicates->isEmpty()) {
            $this->info('✅ No duplicate answers found. Database is clean!');
            return Command::SUCCESS;
        }

        // Display the duplicates
        $this->displayDuplicates($duplicates);

        // If dry-run, stop here
        if ($this->option('dry-run')) {
            $this->warn('🔸 Dry-run mode: No changes were made.');
            return Command::SUCCESS;
        }

        // Ask for confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('Do you want to reset these duplicate answers to "[Data Error - Reset]"?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        // Reset the duplicates
        $resetCount = $this->resetDuplicates($duplicates);

        $this->newLine();
        $this->info("✅ Successfully reset {$resetCount} duplicate answer(s).");
        $this->info('💡 Affected students should re-submit their answers.');

        return Command::SUCCESS;
    }

    /**
     * Find all duplicate answers (same user, same test, same answer text for different questions)
     */
    private function findDuplicateAnswers()
    {
        // Step 1: Find combinations of (user_id, custom_test_id, jawaban) that appear more than once
        $duplicateCombinations = DB::table('custom_test_answers')
            ->select('user_id', 'custom_test_id', 'jawaban')
            ->whereNotNull('jawaban')
            ->where('jawaban', '!=', '')
            ->where('jawaban', '!=', '[Data Error - Reset]')
            ->groupBy('user_id', 'custom_test_id', 'jawaban')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($duplicateCombinations->isEmpty()) {
            return collect();
        }

        // Step 2: Get the actual answer records for these duplicates with relationships
        $duplicateRecords = collect();

        foreach ($duplicateCombinations as $combo) {
            $records = CustomTestAnswer::with(['customTest', 'customTestQuestion'])
                ->where('user_id', $combo->user_id)
                ->where('custom_test_id', $combo->custom_test_id)
                ->where('jawaban', $combo->jawaban)
                ->get();

            // Get user info
            $user = User::find($combo->user_id);

            $duplicateRecords->push([
                'user' => $user,
                'test' => $records->first()?->customTest,
                'answer_text' => $combo->jawaban,
                'records' => $records,
                'count' => $records->count(),
            ]);
        }

        return $duplicateRecords;
    }

    /**
     * Display the duplicate entries in a formatted table
     */
    private function displayDuplicates($duplicates): void
    {
        $this->error("⚠️  Found {$duplicates->count()} duplicate answer group(s):");
        $this->newLine();

        $tableData = [];
        $totalAffected = 0;

        foreach ($duplicates as $index => $duplicate) {
            $userName = $duplicate['user']?->name ?? 'Unknown User';
            $userEmail = $duplicate['user']?->email ?? 'N/A';
            $testName = $duplicate['test']?->nama_test ?? 'Unknown Test';
            $answerPreview = $this->truncateText($duplicate['answer_text'], 50);
            $questionsAffected = $duplicate['records']->pluck('custom_test_question_id')->implode(', ');
            
            $tableData[] = [
                '#' . ($index + 1),
                $userName,
                $userEmail,
                $testName,
                $duplicate['count'] . ' questions',
                "Q IDs: {$questionsAffected}",
                $answerPreview,
            ];

            $totalAffected += $duplicate['count'];
        }

        $this->table(
            ['#', 'User Name', 'Email', 'Test Name', 'Duplicates', 'Question IDs', 'Answer Preview'],
            $tableData
        );

        $this->newLine();
        $this->warn("📊 Total affected answer records: {$totalAffected}");
        $this->newLine();

        // Show detailed breakdown if requested
        if ($this->confirm('Show detailed answer breakdown?', false)) {
            $this->showDetailedBreakdown($duplicates);
        }
    }

    /**
     * Show detailed breakdown of each duplicate
     */
    private function showDetailedBreakdown($duplicates): void
    {
        foreach ($duplicates as $index => $duplicate) {
            $this->newLine();
            $this->info("━━━ Duplicate Group #" . ($index + 1) . " ━━━");
            $this->line("User: " . ($duplicate['user']?->name ?? 'Unknown'));
            $this->line("Test: " . ($duplicate['test']?->nama_test ?? 'Unknown'));
            $this->line("Repeated Answer: " . $this->truncateText($duplicate['answer_text'], 100));
            $this->newLine();

            $detailData = [];
            foreach ($duplicate['records'] as $record) {
                $questionText = $record->customTestQuestion?->pertanyaan ?? 'Unknown Question';
                $detailData[] = [
                    $record->id,
                    $record->custom_test_question_id,
                    $this->truncateText($questionText, 40),
                    $record->created_at?->format('Y-m-d H:i') ?? 'N/A',
                ];
            }

            $this->table(
                ['Answer ID', 'Question ID', 'Question Text', 'Created At'],
                $detailData
            );
        }
    }

    /**
     * Reset duplicate answers
     */
    private function resetDuplicates($duplicates): int
    {
        $resetCount = 0;

        DB::transaction(function () use ($duplicates, &$resetCount) {
            foreach ($duplicates as $duplicate) {
                foreach ($duplicate['records'] as $record) {
                    $record->update([
                        'jawaban' => '[Data Error - Reset]',
                        'is_correct' => null, // Reset correction status too
                    ]);
                    $resetCount++;
                }
            }
        });

        return $resetCount;
    }

    /**
     * Truncate text with ellipsis
     */
    private function truncateText(?string $text, int $length): string
    {
        if ($text === null) {
            return 'NULL';
        }
        
        // Remove newlines for display
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);
        
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length - 3) . '...';
    }
}
