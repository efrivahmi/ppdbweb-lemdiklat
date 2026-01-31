<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjianKhusus extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ujian_khusus';

    protected $fillable = [
        'nama',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'is_active',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get all students assigned to this schedule
     */
    public function siswa()
    {
        return $this->belongsToMany(User::class, 'siswa_jadwal_ujian_khusus');
    }

    /**
     * Check if schedule is currently active (within time window and enabled)
     */
    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        return $now->between($this->waktu_mulai, $this->waktu_selesai);
    }

    /**
     * Get status of the schedule
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'nonaktif';
        }

        $now = now();

        if ($now < $this->waktu_mulai) {
            return 'akan_datang';
        } elseif ($now->between($this->waktu_mulai, $this->waktu_selesai)) {
            return 'berlangsung';
        } else {
            return 'selesai';
        }
    }

    /**
     * Scope to get active schedules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get currently running schedules
     */
    public function scopeRunning($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now);
    }
}
