<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelombangPendaftaran extends Model
{
    protected $fillable = [
        'nama_gelombang',
        'pendaftaran_mulai',
        'pendaftaran_selesai',
        'ujian_mulai',
        'ujian_selesai',
        'pengumuman_tanggal',
    ];

    protected $casts = [
        'pendaftaran_mulai' => 'datetime',
        'pendaftaran_selesai' => 'datetime',
        'ujian_mulai' => 'datetime',
        'ujian_selesai' => 'datetime',
        'pengumuman_tanggal' => 'datetime',
    ];

    // helper cek status sekarang
    public function getStatusAttribute()
    {
        $today = now();

        if ($today < $this->pendaftaran_mulai) {
            return 'belum_dimulai';
        } elseif ($today->between($this->pendaftaran_mulai, $this->pendaftaran_selesai)) {
            return 'pendaftaran';
        } elseif ($today->between($this->ujian_mulai, $this->ujian_selesai)) {
            return 'ujian';
        } elseif ($today->isSameDay($this->pengumuman_tanggal)) {
            return 'pengumuman';
        } elseif ($today > $this->pengumuman_tanggal) {
            return 'selesai';
        }

        return 'menunggu';
    }

    // Scope untuk mendapatkan gelombang yang sedang aktif
    // Gelombang dianggap aktif dari mulai pendaftaran sampai setelah pengumuman
    public function scopeAktif($query)
    {
        $today = now();
        return $query->where('pendaftaran_mulai', '<=', $today)
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk mendapatkan gelombang yang sedang dalam periode pendaftaran
    public function scopePendaftaranAktif($query)
    {
        $today = now();
        return $query->where('pendaftaran_mulai', '<=', $today)
                    ->where('pendaftaran_selesai', '>=', $today);
    }

    // Pengecekan apakah pendaftaran aktif
    public function isPendaftaranAktif(): bool
    {
        $today = now();
        return $today->between($this->pendaftaran_mulai, $this->pendaftaran_selesai);
    }

    // Pengcekan apakah ujian aktif
    public function isUjianAktif(): bool
    {
        $today = now();
        return $today->between($this->ujian_mulai, $this->ujian_selesai);
    }

    // Pengecekan apakah pengumuman aktif (hari pengumuman saja)
    public function isPengumumanHariIni(): bool
    {
        $today = now();
        return $today->isSameDay($this->pengumuman_tanggal);
    }

    // Pengecekan apakah pengumuman sudah bisa dibuka (sejak tanggal pengumuman dan seterusnya)
    public function isPengumumanTerbuka(): bool
    {
        $today = now();
        return $today->greaterThanOrEqualTo($this->pengumuman_tanggal->startOfDay());
    }

    // Pengecekan apakah sudah selesai
    public function isSelesai(): bool
    {
        $today = now();
        return $today->greaterThan($this->pengumuman_tanggal);
    }
}