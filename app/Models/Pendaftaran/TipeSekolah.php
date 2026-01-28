<?php

namespace App\Models\Pendaftaran;

use App\Models\Pendaftaran\PendaftaranMurid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeSekolah extends Model
{
    protected $fillable = [
        "nama"
    ];

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }

    public function pendaftaranMurids(): HasMany
    {
        return $this->hasMany(PendaftaranMurid::class);
    }
}
