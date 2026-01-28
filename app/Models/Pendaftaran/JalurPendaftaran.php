<?php

namespace App\Models\Pendaftaran;

use App\Models\Pendaftaran\PendaftaranMurid;
use App\Models\Pendaftaran\TesJalur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JalurPendaftaran extends Model
{
    protected $fillable = [
        "nama",
        "img",
        "deskripsi",
    ];
    
    public function pendaftaranMurids(): HasMany
    {
        return $this->hasMany(PendaftaranMurid::class);
    }

    public function tesJalurs(): HasMany
    {
        return $this->hasMany(TesJalur::class);
    }
}