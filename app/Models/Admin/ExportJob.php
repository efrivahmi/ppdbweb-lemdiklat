<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ExportJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'filename',
        'status',
        'file_path',
        'error_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
