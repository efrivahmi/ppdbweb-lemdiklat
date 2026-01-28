<?php

namespace App\Models\Pendaftaran;

use App\Livewire\Landing\Pages\Alumni;
use App\Models\Pendaftaran\PendaftaranMurid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $fillable = [
        "tipe_sekolah_id",
        "nama"
    ];

    public function tipeSekolah()
    {
        return $this->belongsTo(TipeSekolah::class);
    }

    public function pendaftaranMurids(): HasMany
    {
        return $this->hasMany(PendaftaranMurid::class);
    }

    public function alumnis()
    {
        return $this->hasMany(Alumni::class);
    }
}
