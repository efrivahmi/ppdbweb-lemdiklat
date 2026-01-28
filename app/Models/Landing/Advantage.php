<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Scope untuk mendapatkan advantages yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mendapatkan advantages yang terurut
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get all active advantages ordered
     */
    public static function getActiveAdvantages()
    {
        return self::active()->ordered()->get();
    }

    /**
     * Daftar heroicons yang tersedia untuk dipilih
     */
    public static function getAvailableIcons()
    {
        return [
            'academic-cap' => 'Academic Cap',
            'trophy' => 'Trophy',
            'user-group' => 'User Group',
            'shield-check' => 'Shield Check',
            'building-library' => 'Building Library',
            'globe-asia-australia' => 'Globe Asia Australia',
            'sparkles' => 'Sparkles',
            'light-bulb' => 'Light Bulb',
            'rocket-launch' => 'Rocket Launch',
            'star' => 'Star',
            'fire' => 'Fire',
            'bolt' => 'Bolt',
            'heart' => 'Heart',
            'check-badge' => 'Check Badge',
            'beaker' => 'Beaker',
            'book-open' => 'Book Open',
            'chart-bar' => 'Chart Bar',
            'clock' => 'Clock',
            'cog' => 'Cog',
            'currency-dollar' => 'Currency Dollar'
        ];
    }
}