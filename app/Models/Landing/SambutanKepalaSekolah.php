<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SambutanKepalaSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'badge_variant',
        'badge_size',
        'title_text',
        'title_highlight',
        'title_size',
        'title_class_name',
        'principal_name',
        'principal_title',
        'principal_image',
        'principal_signature',
        'greeting_opening',
        'greeting_paragraphs',
        'greeting_closing',
        'quote_text',
        'quote_author',
        'is_active',
    ];

    protected $casts = [
        'greeting_paragraphs' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active principal greeting
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Get formatted data for component
     */
    public function getFormattedData(): array
    {
        return [
            'badge' => [
                'text' => $this->badge_text,
                'variant' => $this->badge_variant,
                'size' => $this->badge_size,
            ],
            'title' => [
                'text' => $this->title_text,
                'highlight' => $this->title_highlight,
                'size' => $this->title_size,
                'className' => $this->title_class_name,
            ],
            'principal' => [
                'name' => $this->principal_name,
                'title' => $this->principal_title,
                'image' => $this->principal_image ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'signature' => $this->principal_signature,
            ],
            'greeting' => [
                'opening' => $this->greeting_opening,
                'paragraphs' => $this->greeting_paragraphs,
                'closing' => $this->greeting_closing,
            ],
            'quote' => [
                'text' => $this->quote_text,
                'author' => $this->quote_author,
            ],
        ];
    }

    /**
     * Scope to get only active greetings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Set only this greeting as active
     */
    public function setAsActive(): void
    {
        // Set all other greetings to inactive
        self::where('id', '!=', $this->id)->update(['is_active' => false]);

        // Set this greeting as active
        $this->update(['is_active' => true]);
    }
}
