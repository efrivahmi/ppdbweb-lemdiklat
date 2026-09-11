<?php

namespace App\Models\Pendaftaran;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomTestAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'custom_test_id',
        'custom_test_question_id',
        'jawaban',
        'is_correct',
        'completed_at'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customTest()
    {
        return $this->belongsTo(CustomTest::class);
    }

    public function customTestQuestion()
    {
        return $this->belongsTo(CustomTestQuestion::class)->withTrashed();
    }
}