<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Information extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel secara eksplisit
     */
    protected $table = 'informations';

    protected $fillable = [
        'icon',
        'title',
        'url',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Default values for attributes
     */
    protected $attributes = [
        'is_active' => true,
        'order' => 0,
    ];

    /**
     * Scope untuk hanya menampilkan informasi yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get all active informations ordered
     */
    public static function getActiveInformations()
    {
        return self::active()->ordered()->get();
    }

    /**
     * Alias method agar kompatibel dengan pemanggilan lama
     * Contoh: Information::getActiveOrdered();
     */
    public static function getActiveOrdered()
    {
        return self::active()->ordered()->get();
    }
}
