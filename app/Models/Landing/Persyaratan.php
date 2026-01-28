<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persyaratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'value',
        'unit',
        'gender',
        'color',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Scope untuk persyaratan fisik
    public function scopePhysical($query)
    {
        return $query->where('type', 'physical');
    }

    // Scope untuk persyaratan dokumen
    public function scopeDocument($query)
    {
        return $query->where('type', 'document');
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessor untuk mendapatkan formatted value
    public function getFormattedValueAttribute()
    {
        if ($this->type === 'physical') {
            return $this->value . ' ' . strtoupper($this->unit);
        }
        
        return $this->value . ' ' . $this->unit;
    }

    // Accessor untuk mendapatkan gender display
    public function getGenderDisplayAttribute()
    {
        return $this->gender === 'male' ? 'Laki-laki' : 'Perempuan';
    }

    // Static method untuk get physical requirements
    public static function getPhysicalRequirements()
    {
        return self::physical()
            ->active()
            ->ordered()
            ->get()
            ->groupBy('gender');
    }

    // Static method untuk get document requirements
    public static function getDocumentRequirements()
    {
        return self::document()
            ->active()
            ->ordered()
            ->get();
    }
}