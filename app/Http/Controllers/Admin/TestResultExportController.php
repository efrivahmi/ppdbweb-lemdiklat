<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran\CustomTest;
use App\Models\User;
use App\Models\Pendaftaran\CustomTestAnswer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TestResultExportController extends Controller
{
    public function exportPdf(Request $request, $testId)
    {
        // Increase limits for large PDF generation
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $test = CustomTest::with(['mapel'])->findOrFail($testId);
        $totalQuestionsInTest = $test->questions()->count();
        
        $userIds = $request->input('userIds');
        if ($userIds && is_string($userIds)) {
            $userIds = explode(',', $userIds);
        }

        // Get all users who took the test
        $usersQuery = User::whereHas('customTestAnswers', function($query) use ($testId) {
            $query->where('custom_test_id', $testId);
        });

        if ($userIds && count($userIds) > 0) {
            $usersQuery->whereIn('id', $userIds);
        }

        $users = $usersQuery->orderBy('name', 'asc')
        ->with(['pendaftaranMurids', 'dataMurid', 'customTestAnswers' => function($query) use ($testId) {
            $query->where('custom_test_id', $testId)->with('customTestQuestion');
        }])
        ->get()
        ->map(function($user) use ($testId, $totalQuestionsInTest) {
            $answers = $user->customTestAnswers;
            
            $correctAnswers = $answers->where('is_correct', true)->count();
            $pendingAnswers = $answers->whereNull('is_correct')->count();
            
            $user->score_stats = [
                'total' => $totalQuestionsInTest,
                'correct' => $correctAnswers,
                'pending' => $pendingAnswers,
                'percentage' => $totalQuestionsInTest > 0 ? round(($correctAnswers / $totalQuestionsInTest) * 100, 2) : 0
            ];
            
            // Format answers for display
            $user->detailed_answers = $answers->sortBy(function($a) {
                return $a->customTestQuestion->urutan ?? 0;
            })->map(function($a) {
                $q = $a->customTestQuestion;
                $displayAnswer = $a->jawaban;
                $displayKey = $q->jawaban_benar ?? '-';

                if ($q->tipe_soal === 'radio' || $q->tipe_soal === 'checkbox') {
                    $options = $q->options ?? [];
                    
                    // Helper to get text from letter (A, B, C...)
                    $getText = function($val) use ($options) {
                        $index = ord(strtoupper($val)) - 65;
                        return isset($options[$index]) ? $val . '. ' . $options[$index] : $val;
                    };

                    if ($q->tipe_soal === 'radio') {
                        $displayAnswer = $getText($a->jawaban);
                        $displayKey = $getText($q->jawaban_benar);
                    } else {
                        // Checkbox (JSON array of letters)
                        $vals = json_decode($a->jawaban, true);
                        if (is_array($vals)) {
                            $displayAnswer = implode(', ', array_map($getText, $vals));
                        }
                    }
                }

                $a->display_answer = $displayAnswer;
                $a->display_key = $displayKey;
                return $a;
            });
            
            return $user;
        });

        $data = [
            'test' => $test,
            'users' => $users,
            'date' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('exports.test-results', $data)->setPaper('a4', 'portrait');
        
        return $pdf->stream('Hasil_Test_' . str_replace(' ', '_', $test->nama_test) . '.pdf');
    }
}
