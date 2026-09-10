<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class RunningText extends Model
{
    protected $fillable = [
        'text',
        'is_active',
    ];
}
