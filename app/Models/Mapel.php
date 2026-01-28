<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = [
        "mapel_name"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
