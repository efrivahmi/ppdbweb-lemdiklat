<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruDocument extends Model
{
    protected $fillable = [
        'guru_id',
        'document_name',
        'document_type',
        'file_path',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Alias untuk backward compatibility
    public function guru()
    {
        return $this->user();
    }

    // Scope untuk filter
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
