<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class StatSections extends Model
{
    protected $table = 'stats_section';

    protected $fillable = ['label', 'value', 'is_editable'];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if (!$model->is_editable) {
                return false;
            }
        });
    }
}
