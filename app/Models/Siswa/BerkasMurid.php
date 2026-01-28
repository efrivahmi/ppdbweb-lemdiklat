<?php

namespace App\Models\Siswa;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BerkasMurid extends Model
{
    protected $fillable = [
        'user_id',
        'kk',
        'ktp_ortu',
        'akte',
        'surat_sehat',
        'pas_foto',
        'proses'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
