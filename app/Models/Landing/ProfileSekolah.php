<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class ProfileSekolah extends Model
{
    protected $fillable = [
        "school_type",
        "title",
        "content",
        "image",
        "mobile_image",
        "badge",
        "hero_data",
        "identity_data",
        "academic_data",
        "uniform_data",
        "activity_data",
        "cta_data",
    ];

    protected $casts = [
        'hero_data' => 'array',
        'identity_data' => 'array',
        'academic_data' => 'array',
        'uniform_data' => 'array',
        'activity_data' => 'array',
        'cta_data' => 'array',
    ];

    /**
     * Scope to filter by school type (sma or smk)
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('school_type', $type);
    }

    /**
     * Get SMA profile
     */
    public static function getSma()
    {
        return self::byType('sma')->first();
    }

    /**
     * Get SMK profile
     */
    public static function getSmk()
    {
        return self::byType('smk')->first();
    }

    /**
     * Get default hero data structure
     */
    public static function getDefaultHeroData(): array
    {
        return [
            'logo' => null,
            'title_prefix' => '',
            'title_main' => '',
            'subtitle' => '',
            'badges' => [],
        ];
    }

    /**
     * Get default identity data structure
     */
    public static function getDefaultIdentityData(): array
    {
        return [
            'principal_name' => '',
            'principal_title' => 'Kepala Sekolah',
            'principal_image' => null,
            'principal_quote' => '',
            'school_name' => '',
            'npsn' => '',
            'accreditation' => '',
            'year_founded' => '',
            'curriculum' => '',
            'students_teachers' => '',
            'description' => '',
        ];
    }

    /**
     * Get default academic data structure
     */
    public static function getDefaultAcademicData(): array
    {
        return [
            'curriculum_description' => '',
            'programs' => [],
            'featured_programs' => [],
        ];
    }

    /**
     * Get default uniform data structure
     */
    public static function getDefaultUniformData(): array
    {
        return [
            'uniforms' => [],
        ];
    }

    /**
     * Get default CTA data structure
     */
    public static function getDefaultCtaData(): array
    {
        return [
            'badge_text' => 'Bergabunglah Bersama Kami',
            'title' => '',
            'description' => '',
            'primary_button_text' => 'Daftar Sekarang',
            'primary_button_url' => '/login',
            'secondary_button_text' => 'Info Pendaftaran',
            'secondary_button_url' => '/spmb',
        ];
    }
}

