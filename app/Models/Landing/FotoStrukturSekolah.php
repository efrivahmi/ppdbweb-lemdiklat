<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoStrukturSekolah extends Model
{
    use HasFactory;

    protected $table = 'foto_struktur_sekolahs';

    protected $fillable = [
        'nama',
        'img'
    ];

    /**
     * Accessor untuk mendapatkan URL gambar
     */
    public function getImageUrlAttribute()
    {
        if ($this->img) {
            return asset('storage/' . $this->img);
        }
        
        return null;
    }

    /**
     * Accessor untuk mengecek apakah memiliki gambar
     */
    public function getHasImageAttribute()
    {
        return !empty($this->img);
    }

    /**
     * Scope untuk data yang memiliki gambar
     */
    public function scopeHasImage($query)
    {
        return $query->whereNotNull('img');
    }

    /**
     * Scope untuk data yang tidak memiliki gambar
     */
    public function scopeNoImage($query)
    {
        return $query->whereNull('img');
    }
}