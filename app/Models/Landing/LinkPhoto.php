<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class LinkPhoto extends Model
{
    protected $fillable = [
        "title",
        "image",
        'url',
    ];
}
