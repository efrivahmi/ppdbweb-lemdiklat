<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operators';

    protected $fillable = [
        'nama',
        'jabatan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the currently active operator
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
