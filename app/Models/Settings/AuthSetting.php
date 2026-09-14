<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class AuthSetting extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'sub_description',
        'image',
    ];
}
