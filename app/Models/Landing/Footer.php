<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $table = 'footers';

    protected $fillable = [
        'site_title',
        'site_description', 
        'copyright_text',
        'social_icons',
        'footer_links',
        'legal_links',
        'is_active',
    ];

    protected $casts = [
        'social_icons' => 'array',
        'footer_links' => 'array', 
        'legal_links' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active footer settings
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }

    /**
     * Get social icons with default structure
     */
    public function getSocialIconsAttribute($value)
    {
        if (!$value) return [];
        
        $icons = is_string($value) ? json_decode($value, true) : $value;
        
        return collect($icons)->map(function ($icon) {
            return [
                'icon' => $icon['icon'] ?? '',
                'href' => $icon['href'] ?? '#',
                'label' => $icon['label'] ?? ucfirst($icon['icon'] ?? '')
            ];
        })->toArray();
    }

    /**
     * Get footer links with default structure
     */
    public function getFooterLinksAttribute($value)
    {
        if (!$value) return [];
        
        $links = is_string($value) ? json_decode($value, true) : $value;
        
        return collect($links)->map(function ($section) {
            return [
                'title' => $section['title'] ?? '',
                'links' => collect($section['links'] ?? [])->map(function ($link) {
                    return [
                        'text' => $link['text'] ?? '',
                        'href' => $link['href'] ?? '#'
                    ];
                })->toArray()
            ];
        })->toArray();
    }

    /**
     * Get legal links with default structure
     */
    public function getLegalLinksAttribute($value)
    {
        if (!$value) return [];
        
        $links = is_string($value) ? json_decode($value, true) : $value;
        
        return collect($links)->map(function ($link) {
            return [
                'text' => $link['text'] ?? '',
                'href' => $link['href'] ?? '#'
            ];
        })->toArray();
    }

    /**
     * Get formatted copyright text with current year
     */
    public function getFormattedCopyrightAttribute()
    {
        return str_replace('{year}', date('Y'), $this->copyright_text ?? '');
    }

    /**
     * Scope for active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}