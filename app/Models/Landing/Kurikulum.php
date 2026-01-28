<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $fillable = [
        'badge_text',
        'badge_variant',
        'badge_size',
        'title_text',
        'title_highlight',
        'title_size',
        'title_class',
        'descriptions',
        'image_url',
        'image_title',
        'image_description',

        // Empat foto wajib
        'photo_1_url',
        'photo_1_title',
        'photo_2_url',
        'photo_2_title',
        'photo_3_url',
        'photo_3_title',

        'is_active',
        'is_single',
    ];

    protected $casts = [
        'descriptions' => 'array',
        'is_active' => 'boolean',
        'is_single' => 'boolean',
    ];
}
