<?php

namespace App\Models\Pendaftaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesJalur extends Model
{
    use HasFactory;

    protected $table = 'tes_jalurs';

    protected $fillable = [
        'jalur_pendaftaran_id',
        'nama_tes',
        'deskripsi'
    ];

    public function jalurPendaftaran()
    {
        return $this->belongsTo(JalurPendaftaran::class);
    }

    public function customTests()
    {
        return $this->belongsToMany(CustomTest::class, 'tes_jalur_custom_tests');
    }
}