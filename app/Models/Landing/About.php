<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model
{
    use HasFactory;

    protected $table = 'about';

    protected $fillable = [
        'badge_text',
        'title_text',
        'title_highlight',
        'title_class_name',
        'description',
        'image_url',
        'image_title',
        'image_description',
        'contact_info',
        'is_active',
        'is_single'
    ];

    protected $casts = [
        'contact_info' => 'array',
        'is_active' => 'boolean'
    ];

    // Accessor untuk format data lengkap (untuk compatibility dengan SchoolSection)
    public function getProfileDataAttribute()
    {
        return [
            'badge' => [
                'text' => $this->badge_text,
                'variant' => 'emerald', // Default variant
                'size' => 'md' // Default size
            ],
            'title' => [
                'text' => $this->title_text,
                'highlight' => $this->title_highlight,
                'size' => '3xl', // Default size
                'className' => $this->title_class_name
            ],
            'descriptions' => [$this->description], // Convert single description to array for compatibility
            'image' => [
                'url' => $this->image_url,
                'title' => $this->image_title,
                'description' => $this->image_description
            ],
            'contact' => $this->contact_info ?? []
        ];
    }

    // Method untuk mendapatkan profil aktif atau default
    public static function getActiveProfile()
    {
        $activeProfile = self::first();
        
        if ($activeProfile) {
            return $activeProfile->profile_data;
        }
        
        return self::getDefaultProfileData();
    }

    // Method untuk mendapatkan atau membuat single record
    public static function getSingle()
    {
        return self::firstOrCreate(['is_single' => true], self::getDefaultData());
    }

    // Method untuk update single record
    public static function updateSingle($data)
    {
        $record = self::getSingle();
        $record->update($data);
        return $record;
    }

    // Data default untuk create
    public static function getDefaultData()
    {
        return [
            'badge_text' => 'Tentang Kami',
            'title_text' => 'Profil Sekolah',
            'title_highlight' => 'Sekolah',
            'title_class_name' => 'lg:text-5xl',
            'description' => 'Lemdiklat Taruna Nusantara Indonesia adalah sekolah menengah atas yang berkomitmen untuk membentuk generasi muda yang berintegritas, berkarakter, dan siap menghadapi tantangan masa depan. Dengan kurikulum komprehensif dan fasilitas modern, kami memberikan pendidikan terbaik yang menggabungkan akademik dan pengembangan karakter.',
            'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'image_title' => 'Gedung Sekolah',
            'image_description' => 'Fasilitas modern untuk mendukung proses pembelajaran',
            'contact_info' => [
                [
                    'icon' => 'MapPinIcon',
                    'text' => 'Jl. Pendidikan No. 123, Jakarta Selatan'
                ],
                [
                    'icon' => 'PhoneIcon',
                    'text' => '(021) 1234-5678'
                ]
            ],
            'is_active' => true,
            'is_single' => true
        ];
    }

    // Method untuk mendapatkan data default jika tidak ada di database (untuk compatibility)
    public static function getDefaultProfileData()
    {
        $defaultData = self::getDefaultData();
        return [
            'badge' => [
                'text' => $defaultData['badge_text'],
                'variant' => 'emerald', // Default variant
                'size' => 'md' // Default size
            ],
            'title' => [
                'text' => $defaultData['title_text'],
                'highlight' => $defaultData['title_highlight'],
                'size' => '3xl', // Default size
                'className' => $defaultData['title_class_name']
            ],
            'descriptions' => [$defaultData['description']],
            'image' => [
                'url' => $defaultData['image_url'],
                'title' => $defaultData['image_title'],
                'description' => $defaultData['image_description']
            ],
            'contact' => $defaultData['contact_info']
        ];
    }

    // Override boot method untuk prevent multiple records
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Prevent creating if record already exists
            if (self::count() > 0) {
                throw new \Exception('Hanya boleh ada satu record About. Gunakan update untuk mengubah data.');
            }
        });
    }
}