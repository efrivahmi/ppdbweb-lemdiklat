<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class AlurPendaftaran extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'order_num',
    ];
}
