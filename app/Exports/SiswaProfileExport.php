<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaProfileExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return User::where('id', $this->userId)->with(['dataMurid', 'dataOrangTua', 'berkasMurid', 'pendaftaranMurids'])->get();
    }

    public function headings(): array
    {
        return [
            'Field',
            'Value'
        ];
    }

    public function map($user): array
    {
        $pendaftaran = $user->pendaftaranMurids->first();
        $tahun = $user->created_at->format('Y');
        $tahunAjaran = "{$tahun}/" . ($tahun + 1);

        $data = [
            ['Informasi Akun', ''],
            ['Tahun Ajaran', $tahunAjaran],
            ['Nama Lengkap', $user->name],
            ['NISN', $user->nisn],
            ['Email', $user->email],
            ['No Telepon', $user->telp],
            ['Tanggal Daftar', $user->created_at->format('d-m-Y H:i')],
            
            ['', ''],
            ['Data Murid', ''],
            ['No KK', $user->dataMurid->no_kk ?? '-'],
            ['Tempat Lahir', $user->dataMurid->tempat_lahir ?? '-'],
            ['Tanggal Lahir', $user->dataMurid->tgl_lahir ? date('d-m-Y', strtotime($user->dataMurid->tgl_lahir)) : '-'],
            ['Jenis Kelamin', $user->dataMurid->jenis_kelamin ?? '-'],
            ['Agama', $user->dataMurid->agama ?? '-'],
            ['WhatsApp', $user->dataMurid->whatsapp ?? '-'],
            ['Alamat', $user->dataMurid->alamat ?? '-'],
            ['Asal Sekolah', $user->dataMurid->asal_sekolah ?? '-'],
            ['Berat Badan', $user->dataMurid->bb ? $user->dataMurid->bb . ' kg' : '-'],
            ['Tinggi Badan', $user->dataMurid->tb ? $user->dataMurid->tb . ' cm' : '-'],
            ['Riwayat Penyakit', $user->dataMurid->riwayat_penyakit ?? '-'],

            ['', ''],
            ['Data Pendaftaran', ''],
            ['Jalur Pendaftaran', $pendaftaran->jalurPendaftaran->nama ?? '-'],
            ['Tipe Sekolah', $pendaftaran->tipeSekolah->nama ?? '-'],
            ['Jurusan', $pendaftaran->jurusan->nama ?? '-'],
            ['Status', $pendaftaran ? ucfirst($pendaftaran->status) : 'Belum Mendaftar'],

            ['', ''],
            ['Data Orang Tua (Ayah)', ''],
            ['Nama Ayah', $user->dataOrangTua->nama_ayah ?? '-'],
            ['Pendidikan Ayah', $user->dataOrangTua->pendidikan_ayah ?? '-'],
            ['Telp Ayah', $user->dataOrangTua->telp_ayah ?? '-'],
            ['Pekerjaan Ayah', $user->dataOrangTua->pekerjaan_ayah ?? '-'],
            ['Status Pekerjaan Ayah', $user->dataOrangTua->status_pekerjaan_ayah ?? '-'],
            ['Penghasilan Ayah', $user->dataOrangTua->penghasilan_ayah ?? '-'],
            ['Alamat Ayah', $user->dataOrangTua->alamat_ayah ?? '-'],
            
            ['', ''],
            ['Data Orang Tua (Ibu)', ''],
            ['Nama Ibu', $user->dataOrangTua->nama_ibu ?? '-'],
            ['Pendidikan Ibu', $user->dataOrangTua->pendidikan_ibu ?? '-'],
            ['Telp Ibu', $user->dataOrangTua->telp_ibu ?? '-'],
            ['Pekerjaan Ibu', $user->dataOrangTua->pekerjaan_ibu ?? '-'],
            ['Status Pekerjaan Ibu', $user->dataOrangTua->status_pekerjaan_ibu ?? '-'],
            ['Penghasilan Ibu', $user->dataOrangTua->penghasilan_ibu ?? '-'],
            ['Alamat Ibu', $user->dataOrangTua->alamat_ibu ?? '-'],
        ];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
