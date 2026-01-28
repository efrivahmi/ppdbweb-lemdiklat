<?php

namespace App\Models\Siswa;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BuktiTransfer extends Model
{
    protected $fillable = [
        'user_id',
        'transfer_picture',
        'atas_nama',
        'no_rek',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}