<?php

namespace App\Models\Pendaftaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTest extends Model
{
    use HasFactory;

    protected $fillable = ['nama_test', 'deskripsi', 'is_active', 'mapel_id', 'category'];
    // category ['custom_test', 'kuesioner_ortu']
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(CustomTestQuestion::class)->orderBy('urutan');
    }

    public function tesJalurs()
    {
        return $this->belongsToMany(TesJalur::class, 'tes_jalur_custom_tests');
    }
    public function answers()
    {
        return $this->hasMany(CustomTestAnswer::class);
    }

    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class);
    }

    // Method untuk mendapatkan statistik test (termasuk essay yang sudah direview)
    public function getStatistics()
    {
        $totalParticipants = $this->answers()->select('user_id')->distinct()->count();

        $totalQuestions = $this->questions()->count();

        if ($totalParticipants === 0) {
            return [
                'total_participants' => 0,
                'average_score' => 0,
                'pass_rate' => 0,
                'radio_avg' => 0,
                'essay_avg' => 0,
            ];
        }

        // Hitung statistik per user (hanya yang sudah direview)
        $userStats = collect();

        $users = $this->answers()->select('user_id')->distinct()->pluck('user_id');

        foreach ($users as $userId) {
            $userAnswers = $this->answers()->where('user_id', $userId)->with('customTestQuestion')->get();

            $totalCorrect = $userAnswers->where('is_correct', true)->count();
            $totalReviewed = $userAnswers->whereIn('is_correct', [true, false])->count();

            $radioCorrect = $userAnswers
                ->filter(function ($answer) {
                    return $answer->customTestQuestion->tipe_soal === 'radio' && $answer->is_correct === true;
                })
                ->count();

            $radioTotal = $userAnswers
                ->filter(function ($answer) {
                    return $answer->customTestQuestion->tipe_soal === 'radio';
                })
                ->count();

            $essayCorrect = $userAnswers
                ->filter(function ($answer) {
                    return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct === true;
                })
                ->count();

            $essayReviewed = $userAnswers
                ->filter(function ($answer) {
                    return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct !== null;
                })
                ->count();

            if ($totalReviewed > 0) {
                $userStats->push([
                    'total_correct' => $totalCorrect,
                    'total_reviewed' => $totalReviewed,
                    'radio_correct' => $radioCorrect,
                    'radio_total' => $radioTotal,
                    'essay_correct' => $essayCorrect,
                    'essay_reviewed' => $essayReviewed,
                    'percentage' => ($totalCorrect / $totalReviewed) * 100,
                ]);
            }
        }

        if ($userStats->isEmpty()) {
            return [
                'total_participants' => $totalParticipants,
                'average_score' => 0,
                'pass_rate' => 0,
                'radio_avg' => 0,
                'essay_avg' => 0,
            ];
        }

        $averageScore = $userStats->avg('percentage');
        $passThreshold = 70; // 70% untuk lulus
        $passedUsers = $userStats->where('percentage', '>=', $passThreshold)->count();

        $radioAvg = $userStats->where('radio_total', '>', 0)->avg(function ($stat) {
            return ($stat['radio_correct'] / $stat['radio_total']) * 100;
        });

        $essayAvg = $userStats->where('essay_reviewed', '>', 0)->avg(function ($stat) {
            return ($stat['essay_correct'] / $stat['essay_reviewed']) * 100;
        });

        return [
            'total_participants' => $totalParticipants,
            'average_score' => round($averageScore, 2),
            'pass_rate' => round(($passedUsers / $userStats->count()) * 100, 2),
            'radio_avg' => round($radioAvg ?? 0, 2),
            'essay_avg' => round($essayAvg ?? 0, 2),
        ];
    }
}
