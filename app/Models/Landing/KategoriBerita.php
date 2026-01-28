<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}