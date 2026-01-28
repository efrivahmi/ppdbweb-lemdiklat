<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PDF extends Model
{
    protected $table = 'p_d_f_s';
    
    protected $fillable = [
        'jenis',
        'nama_sekolah',
        'alamat_sekolah',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'email',
        'telepon',
        'website',
        'logo_kiri',
        'logo_kanan',
        'judul_pdf',
        'pesan_penting',
        'nama_operator',
        'jabatan_operator',
        'catatan_tambahan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk PDF verifikasi
    public function scopeVerifikasi($query)
    {
        return $query->where('jenis', 'verifikasi');
    }

    // Scope untuk PDF penerimaan
    public function scopePenerimaan($query)
    {
        return $query->where('jenis', 'penerimaan');
    }

    // Scope untuk yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk URL logo kiri
    public function getLogoKiriUrlAttribute()
    {
        if ($this->logo_kiri && Storage::disk('public')->exists($this->logo_kiri)) {
            return asset('storage/' . $this->logo_kiri);
        }
        return null;
    }

    // Accessor untuk URL logo kanan
    public function getLogoKananUrlAttribute()
    {
        if ($this->logo_kanan && Storage::disk('public')->exists($this->logo_kanan)) {
            return asset('storage/' . $this->logo_kanan);
        }
        return null;
    }

    // Method untuk mendapatkan absolute path logo kiri (untuk PDF generation)
    public function getLogoKiriPathAttribute()
    {
        if ($this->logo_kiri && Storage::disk('public')->exists($this->logo_kiri)) {
            return Storage::disk('public')->path($this->logo_kiri);
        }
        return null;
    }

    // Method untuk mendapatkan absolute path logo kanan (untuk PDF generation)
    public function getLogoKananPathAttribute()
    {
        if ($this->logo_kanan && Storage::disk('public')->exists($this->logo_kanan)) {
            return Storage::disk('public')->path($this->logo_kanan);
        }
        return null;
    }

    // Accessor untuk alamat lengkap
    public function getAlamatLengkapAttribute()
    {
        return $this->alamat_sekolah . ', ' . $this->kecamatan . ', ' . $this->kabupaten . ', ' . $this->provinsi . ' ' . $this->kode_pos;
    }

    // Method untuk mengecek apakah logo ada
    public function hasLogoKiri()
    {
        return $this->logo_kiri && Storage::disk('public')->exists($this->logo_kiri);
    }

    public function hasLogoKanan()
    {
        return $this->logo_kanan && Storage::disk('public')->exists($this->logo_kanan);
    }

    // Static method untuk mendapatkan setting berdasarkan jenis
    public static function getSettingsByJenis($jenis)
    {
        return self::where('jenis', $jenis)->where('is_active', true)->first();
    }
}