<?php

namespace App\Models\Siswa;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DataOrangTua extends Model
{
    protected $fillable = [
        'user_id',
        'nama_ayah',
        'pendidikan_ayah',
        'telp_ayah',
        'pekerjaan_ayah',
        'status_pekerjaan_ayah',
        'alamat_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'pendidikan_ibu',
        'telp_ibu',
        'pekerjaan_ibu',
        'status_pekerjaan_ibu',
        'alamat_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'pendidikan_wali',
        'telp_wali',
        'pekerjaan_wali',
        'status_pekerjaan_wali',
        'alamat_wali',
        'penghasilan_wali',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get penghasilan options for dropdown
     */
    public static function getPenghasilanOptions()
    {
        return [
            'Tidak memiliki penghasilan' => 'Tidak memiliki penghasilan',
            '< Rp 1.000.000' => '< Rp 1.000.000',
            'Rp 1.000.000 - Rp 2.000.000' => 'Rp 1.000.000 - Rp 2.000.000',
            'Rp 2.000.000 - Rp 3.000.000' => 'Rp 2.000.000 - Rp 3.000.000',
            'Rp 3.000.000 - Rp 4.000.000' => 'Rp 3.000.000 - Rp 4.000.000',
            'Rp 4.000.000 - Rp 5.000.000' => 'Rp 4.000.000 - Rp 5.000.000',
            'Rp 5.000.000 - Rp 10.000.000' => 'Rp 5.000.000 - Rp 10.000.000',
            '> Rp 10.000.000' => '> Rp 10.000.000',
        ];
    }

    /**
     * Get pekerjaan options for dropdown (Dapodik)
     */
    public static function getPekerjaanOptions()
    {
        return [
            'Tidak Bekerja' => 'Tidak Bekerja',
            'PNS' => 'PNS (Pegawai Negeri Sipil)',
            'TNI' => 'TNI (Tentara Nasional Indonesia)',
            'Polri' => 'Polri (Kepolisian RI)',
            'Nelayan' => 'Nelayan',
            'Petani' => 'Petani',
            'Peternak' => 'Peternak',
            'Karyawan Swasta' => 'Karyawan Swasta',
            'Pedagang Kecil' => 'Pedagang Kecil',
            'Pedagang Besar' => 'Pedagang Besar',
            'Wiraswasta' => 'Wiraswasta',
            'Wirausaha' => 'Wirausaha',
            'Buruh' => 'Buruh',
            'Pensiunan' => 'Pensiunan',
            'Tenaga Kerja Indonesia' => 'Tenaga Kerja Indonesia',
            'Karyawan BUMN' => 'Karyawan BUMN',
            'Tidak Dapat Diterapkan' => 'Tidak Dapat Diterapkan',
            'Sudah Meninggal' => 'Sudah Meninggal',
        ];
    }

    public static function getStatusPekerjaanOptions(): array
    {
        return [
            'aktif' => 'Aktif',
            'pensiun' => 'Pensiun',
        ];
    }

    // Helper: apakah pekerjaan memerlukan KTA (TNI/Polri)
    public static function requiresKtaAndStatus(?string $pekerjaan): bool
    {
        return in_array($pekerjaan, ['TNI', 'Polri']);
    }

    // Helper: apakah pekerjaan memerlukan status pekerjaan (PNS/TNI/Polri)
    public static function requiresStatusPekerjaan(?string $pekerjaan): bool
    {
        return in_array($pekerjaan, ['PNS', 'TNI', 'Polri']);
    }
}
