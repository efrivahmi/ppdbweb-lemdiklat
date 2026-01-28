<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikulers'; // nama tabel

    protected $fillable = [
        'img',
        'title',
        'desc',
    ];
}
