<?php

namespace App\Models\Pendaftaran;

use App\Models\Pendaftaran\JalurPendaftaran;
use App\Models\Pendaftaran\Jurusan;
use App\Models\Pendaftaran\TipeSekolah;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Pendaftaran\BuktiPrestasi;
use App\Models\Pendaftaran\BuktiTahfidz;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PendaftaranMurid extends Model
{
    protected $fillable = [
        'user_id',
        'jalur_pendaftaran_id',
        'tipe_sekolah_id',
        'jurusan_id',
        'status',
        'has_prestasi',
        'prestasi_detail'
    ];

    protected $casts = [
        'has_prestasi' => 'boolean',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke jalur pendaftaran
    public function jalurPendaftaran()
    {
        return $this->belongsTo(JalurPendaftaran::class);
    }

    // Relasi ke tipe sekolah
    public function tipeSekolah()
    {
        return $this->belongsTo(TipeSekolah::class);
    }

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke bukti prestasi
    public function buktiPrestasis(): HasMany
    {
        return $this->hasMany(BuktiPrestasi::class, 'pendaftaran_murid_id');
    }

    // Relasi ke bukti tahfidz
    public function buktiTahfidzs(): HasMany
    {
        return $this->hasMany(BuktiTahfidz::class, 'pendaftaran_murid_id');
    }

    /**
     * Check if this registration can upload bukti prestasi
     */
    public function canUploadBuktiPrestasi(): bool
    {
        return $this->jalurPendaftaran->nama === 'Prestasi';
    }

    /**
     * Check if can upload more bukti prestasi (max 3)
     */
    public function canUploadMoreBuktiPrestasi(): bool
    {
        return $this->canUploadBuktiPrestasi() && $this->buktiPrestasis()->count() < 3;
    }

    /**
     * Check if this registration can upload bukti tahfidz
     */
    public function canUploadBuktiTahfidz(): bool
    {
        return $this->jalurPendaftaran->nama === 'Tahfidz Quran';
    }

    /**
     * Check if can upload more bukti tahfidz (max 3)
     */
    public function canUploadMoreBuktiTahfidz(): bool
    {
        return $this->canUploadBuktiTahfidz() && $this->buktiTahfidzs()->count() < 3;
    }
}