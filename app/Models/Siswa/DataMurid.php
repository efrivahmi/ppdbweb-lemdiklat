<?php

namespace App\Models\Siswa;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DataMurid extends Model
{
    protected $fillable = [
        "user_id",
        "nisn",
        "nomor_kartu_keluarga",
        "tempat_lahir",
        "tgl_lahir",
        "jenis_kelamin",
        "agama",
        "whatsapp",
        "alamat",
        "asal_sekolah",
        "proses",
        "tinggi_badan",
        "berat_badan",
        "riwayat_penyakit"
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'berat_badan' => 'decimal:1',
        'tinggi_badan' => 'decimal:1',
        'proses' => 'string'
    ];

    // Default values
    protected $attributes = [
        'jenis_kelamin' => 'Laki-laki',
        'proses' => '0'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk format tanggal lahir
    public function getFormattedTglLahirAttribute()
    {
        return $this->tgl_lahir ? $this->tgl_lahir->format('d F Y') : null;
    }

    // Accessor untuk umur
    public function getUmurAttribute()
    {
        return $this->tgl_lahir ? $this->tgl_lahir->age : null;
    }

    // Method untuk menghitung BMI
    public function getBMI()
    {
        if ($this->berat_badan && $this->tinggi_badan) {
            $tinggiMeter = $this->tinggi_badan / 100;
            return round($this->berat_badan / ($tinggiMeter * $tinggiMeter), 2);
        }
        return null;
    }

    // Method untuk status BMI
    public function getBMIStatus()
    {
        $bmi = $this->getBMI();
        
        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Kurus';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Gemuk';
        return 'Obesitas';
    }

    // Scope untuk filter berdasarkan jenis kelamin
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    // Scope untuk data yang sudah lengkap
    public function scopeCompleted($query)
    {
        return $query->where('proses', '1');
    }

    // Method untuk cek kelengkapan data
    public function isDataComplete()
    {
        return !empty($this->tempat_lahir) &&
               !empty($this->tgl_lahir) &&
               !empty($this->jenis_kelamin) &&
               !empty($this->agama) &&
               !empty($this->whatsapp) &&
               !empty($this->alamat) &&
               !empty($this->asal_sekolah) &&
               !empty($this->berat_badan) &&
               !empty($this->tinggi_badan);
    }
}