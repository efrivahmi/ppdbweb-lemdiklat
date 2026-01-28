<?php

namespace App\Models\Pendaftaran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BuktiTahfidz extends Model
{
    protected $fillable = [
        'pendaftaran_murid_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    /**
     * Relasi ke PendaftaranMurid
     */
    public function pendaftaranMurid(): BelongsTo
    {
        return $this->belongsTo(PendaftaranMurid::class, 'pendaftaran_murid_id');
    }

    /**
     * Get the full URL of the file
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Delete file from storage when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($buktiTahfidz) {
            if (Storage::disk('public')->exists($buktiTahfidz->file_path)) {
                Storage::disk('public')->delete($buktiTahfidz->file_path);
            }
        });
    }
}