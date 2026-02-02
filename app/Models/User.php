<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Pendaftaran\CustomTestAnswer;
use App\Models\Siswa\BerkasMurid;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\Siswa\BuktiTransfer;
use App\Models\Pendaftaran\PendaftaranMurid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'nisn', 'role', 'telp', 'password', 'foto_profile', 'mapel_id', 'guru_approved', 'guru_approved_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'guru_approved_at' => 'datetime',
            'show_in_contact' => 'boolean',
        ];
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isSiswa()
    {
        return $this->role == 'siswa';
    }

    public function isGuru()
    {
        return $this->role == 'guru';
    }

    // Check if guru can manage specific mapel
    public function canManageMapel($mapelId)
    {
        return $this->isGuru() && $this->mapel_id == $mapelId;
    }

    // Check if guru can create/edit soal
    public function canManageSoal()
    {
        return $this->isGuru() && $this->mapel_id !== null;
    }

    // Check if user can manage (delete/approve) users
    public function canManageUsers()
    {
        return $this->isAdmin();
    }

    // Check if user can create custom test
    public function canCreateCustomTest()
    {
        return $this->isAdmin() || ($this->isGuru() && $this->mapel_id !== null);
    }

    // Check if guru can manage specific custom test based on mapel
    public function canManageCustomTest($customTest)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isGuru() && $this->mapel_id !== null) {
            // Jika custom test object
            if (is_object($customTest)) {
                return $customTest->mapel_id == $this->mapel_id;
            }
            // Jika mapel_id langsung
            return $customTest == $this->mapel_id;
        }

        return false;
    }

    // Check if user can view siswa data
    public function canViewSiswaData()
    {
        return $this->isAdmin();
    }

    public function getProfilePhotoUrlAttribute()
    {
        // Jika ada file di storage
        if ($this->foto_profile && Storage::disk('public')->exists($this->foto_profile)) {
            return asset('storage/' . $this->foto_profile);
        }

        // Jika tidak ada, generate avatar laravolt
        return Avatar::create($this->name)->toBase64();
    }

    public function hasProfilePhoto()
    {
        return $this->foto_profile && Storage::disk('public')->exists($this->foto_profile);
    }

    // Relasi data murid
    public function dataMurid()
    {
        return $this->hasOne(DataMurid::class);
    }

    public function dataOrangTua()
    {
        return $this->hasOne(DataOrangTua::class);
    }

    public function berkasMurid()
    {
        return $this->hasOne(BerkasMurid::class);
    }

    public function buktiTransfer()
    {
        return $this->hasOne(BuktiTransfer::class);
    }

    public function pendaftaranMurids()
    {
        return $this->hasMany(PendaftaranMurid::class);
    }

    public function customTestAnswers()
    {
        return $this->hasMany(CustomTestAnswer::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru_documents()
    {
        return $this->hasMany(GuruDocument::class, 'guru_id');
    }

    /**
     * Relationship to urgent test schedules (Jadwal Ujian Khusus)
     */
    public function jadwalUjianKhusus()
    {
        return $this->belongsToMany(JadwalUjianKhusus::class, 'siswa_jadwal_ujian_khusus');
    }

    /**
     * Check if student has any active urgent schedule right now
     */
    public function hasActiveUrgentSchedule(): bool
    {
        $now = now();
        return $this->jadwalUjianKhusus()
            ->where('is_active', true)
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now)
            ->exists();
    }

    /**
     * Get active urgent schedules for this student
     */
    public function getActiveUrgentSchedules()
    {
        $now = now();
        return $this->jadwalUjianKhusus()
            ->where('is_active', true)
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now)
            ->get();
    }


    // Method untuk cek apakah user sudah mengerjakan test tertentu
    public function hasCompletedTest($customTestId)
    {
        return $this->customTestAnswers()
            ->where('custom_test_id', $customTestId)
            ->exists();
    }

    // Method untuk mendapatkan skor test (termasuk essay yang sudah direview)
    public function getTestScore($customTestId)
    {
        $answers = $this->customTestAnswers()
            ->where('custom_test_id', $customTestId)
            ->with('customTestQuestion')
            ->get();

        $totalCorrect = $answers->where('is_correct', true)->count();
        $totalReviewed = $answers->whereIn('is_correct', [true, false])->count();

        $radioCorrect = $answers->filter(function($answer) {
            return $answer->customTestQuestion->tipe_soal === 'radio' && $answer->is_correct === true;
        })->count();

        $radioTotal = $answers->filter(function($answer) {
            return $answer->customTestQuestion->tipe_soal === 'radio';
        })->count();

        $essayCorrect = $answers->filter(function($answer) {
            return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct === true;
        })->count();

        $essayReviewed = $answers->filter(function($answer) {
            return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct !== null;
        })->count();

        $essayPending = $answers->filter(function($answer) {
            return $answer->customTestQuestion->tipe_soal === 'text' && $answer->is_correct === null;
        })->count();

        return [
            'total_correct' => $totalCorrect,
            'total_reviewed' => $totalReviewed,
            'radio_correct' => $radioCorrect,
            'radio_total' => $radioTotal,
            'essay_correct' => $essayCorrect,
            'essay_reviewed' => $essayReviewed,
            'essay_pending' => $essayPending,
            'percentage' => $totalReviewed > 0 ? ($totalCorrect / $totalReviewed) * 100 : 0
        ];
    }
}
