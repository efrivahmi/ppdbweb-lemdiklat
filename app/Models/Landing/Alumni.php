<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tahun_lulus',
        'desc',
        'image',
        'jurusan_id',
        'is_selected',
    ];

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Pendaftaran\Jurusan::class, 'jurusan_id');
    }
}
