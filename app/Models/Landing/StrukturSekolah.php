<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturSekolah extends Model
{
    use HasFactory;

    protected $table = 'struktur_sekolahs';

    protected $fillable = [
        'nama',
        'desc',
        'jabatan',
        'posisi',
        'img'
    ];

    /**
     * Cast attributes to specific types
     */
    protected $casts = [
        'posisi' => 'integer',
    ];

    /**
     * Default ordering by posisi (ascending - jabatan tertinggi di atas)
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('posisi', 'asc');
        });
    }

    /**
     * Scope untuk mendapatkan struktur berdasarkan urutan posisi
     */
    public function scopeByPosition($query)
    {
        return $query->orderBy('posisi', 'asc');
    }

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
     * Accessor untuk mendapatkan nama lengkap dengan jabatan
     */
    public function getFullTitleAttribute()
    {
        return $this->nama . ' - ' . $this->jabatan;
    }
}