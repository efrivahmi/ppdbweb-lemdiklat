<?php

namespace App\Models\Pendaftaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_test_id',
        'pertanyaan',
        'image',
        'tipe_soal',
        'options',
        'jawaban_benar',
        'urutan'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function customTest()
    {
        return $this->belongsTo(CustomTest::class);
    }
}