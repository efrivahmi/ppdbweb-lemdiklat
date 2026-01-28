<?php

namespace App\Models\Pendaftaran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BuktiPrestasi extends Model
{
    protected $fillable = [
        'pendaftaran_murid_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function pendaftaranMurid(): BelongsTo
    {
        return $this->belongsTo(PendaftaranMurid::class);
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

        static::deleting(function ($buktiPrestasi) {
            if (Storage::exists($buktiPrestasi->file_path)) {
                Storage::delete($buktiPrestasi->file_path);
            }
        });
    }
}