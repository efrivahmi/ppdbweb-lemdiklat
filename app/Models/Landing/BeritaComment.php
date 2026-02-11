<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class BeritaComment extends Model
{
    protected $fillable = [
        'berita_id',
        'name',
        'message',
        'ip_address',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}
