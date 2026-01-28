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
        'alamat_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'pendidikan_ibu',
        'telp_ibu',
        'pekerjaan_ibu',
        'alamat_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'pendidikan_wali',
        'telp_wali',
        'pekerjaan_wali',
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
            'Nelayan' => 'Nelayan',
            'Petani' => 'Petani',
            'Peternak' => 'Peternak',
            'PNS/TNI/Polri' => 'PNS/TNI/Polri',
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
}
