<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SchoolSetting extends Model
{
    protected $table = 'school_settings';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'kode_pos',
        'telp',
        'email',
        'website',
        'tahun_ajaran',
        'logo_kiri',
        'logo_kanan',
        'pesan_pembayaran',
        'catatan_penting',
        'maps_embed_link',
        'maps_image_path',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    /**
     * Get cached school settings (Singleton pattern)
     * Uses Cache::rememberForever for optimal frontend performance
     */
    public static function getCached(): self
    {
        return Cache::rememberForever('school_settings', function () {
            $settings = self::first();

            // Return default placeholder if no data exists
            if (!$settings) {
                return new self([
                    'nama_sekolah' => 'Lemdiklat Taruna Nusantara Indonesia',
                    'alamat' => 'Alamat belum diatur',
                    'kode_pos' => '-',
                    'telp' => '-',
                    'email' => 'info@sekolah.sch.id',
                    'website' => '#',
                    'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
                    'maps_embed_link' => null,
                    'maps_image_path' => null,
                    'social_links' => [],
                ]);
            }

            return $settings;
        });
    }

    /**
     * Clear the cached settings (call this after save/update)
     */
    public static function clearCache(): void
    {
        Cache::forget('school_settings');
    }

    /**
     * Get logo kiri URL
     */
    public function getLogoKiriUrlAttribute(): ?string
    {
        if ($this->logo_kiri && Storage::disk('public')->exists($this->logo_kiri)) {
            return asset('storage/' . $this->logo_kiri);
        }
        return null;
    }

    /**
     * Get logo kanan URL
     */
    public function getLogoKananUrlAttribute(): ?string
    {
        if ($this->logo_kanan && Storage::disk('public')->exists($this->logo_kanan)) {
            return asset('storage/' . $this->logo_kanan);
        }
        return null;
    }

    /**
     * Get maps image URL
     */
    public function getMapsImageUrlAttribute(): ?string
    {
        if ($this->maps_image_path && Storage::disk('public')->exists($this->maps_image_path)) {
            return asset('storage/' . $this->maps_image_path);
        }
        return null;
    }
}
