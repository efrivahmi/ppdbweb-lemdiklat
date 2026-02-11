<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class BeritaReaction extends Model
{
    protected $fillable = [
        'berita_id',
        'ip_address',
        'reaction',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}
