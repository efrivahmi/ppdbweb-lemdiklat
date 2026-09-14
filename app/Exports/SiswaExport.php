<?php

namespace App\Exports;

use App\Models\User;
use App\Models\GelombangPendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Builder;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $statusFilter;
    protected $selectedTahunAjaranId;
    protected $selectedGelombangId;
    protected $search;

    public function __construct($statusFilter, $selectedTahunAjaranId, $selectedGelombangId, $search)
    {
        $this->statusFilter = $statusFilter;
        $this->selectedTahunAjaranId = $selectedTahunAjaranId;
        $this->selectedGelombangId = $selectedGelombangId;
        $this->search = $search;
    }

    public function collection()
    {
        return User::where('role', 'siswa')
            ->with(['dataMurid', 'dataOrangTua', 'berkasMurid', 'buktiTransfer', 'pendaftaranMurids'])
            ->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nisn', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'lengkap':
                        $query->whereHas('dataMurid', fn($q) => $q->whereNotNull('tempat_lahir'))
                              ->whereHas('dataOrangTua', fn($q) => $q->whereNotNull('nama_ayah')->orWhereNotNull('nama_ibu'))
                              ->whereHas('berkasMurid', fn($q) => $q->whereNotNull('kk'))
                              ->whereHas('pendaftaranMurids');
                        break;
                    case 'belum_lengkap':
                        $query->where(function($q) {
                            $q->whereDoesntHave('dataMurid')
                              ->orWhereDoesntHave('dataOrangTua')
                              ->orWhereDoesntHave('berkasMurid')
                              ->orWhereDoesntHave('pendaftaranMurids');
                        });
                        break;
                    case 'pendaftaran_pending':
                        $query->whereHas('pendaftaranMurids', fn($q) => $q->where('status', 'pending'));
                        break;
                    case 'pendaftaran_diterima':
                        $query->whereHas('pendaftaranMurids', fn($q) => $q->where('status', 'diterima'));
                        break;
                    case 'pendaftaran_ditolak':
                        $query->whereHas('pendaftaranMurids', fn($q) => $q->where('status', 'ditolak'));
                        break;
                }
            })
            ->when($this->selectedGelombangId, function ($query) {
                $gelombang = GelombangPendaftaran::find($this->selectedGelombangId);
                if ($gelombang) {
                    $query->whereBetween('created_at', [
                        $gelombang->pendaftaran_mulai, 
                        $gelombang->pendaftaran_selesai
                    ]);
                }
            }, function ($query) {
                if ($this->selectedTahunAjaranId) {
                    $gelombangs = GelombangPendaftaran::where('tahun_ajaran_id', $this->selectedTahunAjaranId)->get();
                    if ($gelombangs->isNotEmpty()) {
                        $minDate = $gelombangs->min('pendaftaran_mulai');
                        $maxDate = $gelombangs->max('pendaftaran_selesai');
                        $query->whereBetween('created_at', [$minDate, $maxDate]);
                    } else {
                        $query->where('created_at', null);
                    }
                }
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tahun Ajaran',
            'Nama Lengkap',
            'NISN',
            'Email',
            'No Telepon',
            
            // Data Murid
            'No KK',
            'Tempat Lahir',
            'Tgl Lahir',
            'Jenis Kelamin',
            'Agama',
            'WhatsApp',
            'Alamat',
            'Asal Sekolah',
            
            // Pendaftaran
            'Jalur Pendaftaran',
            'Tipe Sekolah',
            'Jurusan',
            'Status Pendaftaran',
            
            // Orang Tua (Ayah)
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Status Ayah',
            
            // Orang Tua (Ibu)
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Status Ibu',
            
            'Tanggal Daftar'
        ];
    }

    public function map($user): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $pendaftaran = $user->pendaftaranMurids->first();
        
        $tahun = $user->created_at->format('Y');
        $tahunAjaran = "{$tahun}/" . ($tahun + 1);

        return [
            $rowNumber,
            $tahunAjaran,
            $user->name,
            $user->nisn,
            $user->email,
            $user->telp,
            
            $user->dataMurid?->no_kk ?? '-',
            $user->dataMurid?->tempat_lahir ?? '-',
            $user->dataMurid?->tgl_lahir ? date('d-m-Y', strtotime($user->dataMurid->tgl_lahir)) : '-',
            $user->dataMurid?->jenis_kelamin ?? '-',
            $user->dataMurid?->agama ?? '-',
            $user->dataMurid?->whatsapp ?? '-',
            $user->dataMurid?->alamat ?? '-',
            $user->dataMurid?->asal_sekolah ?? '-',
            
            $pendaftaran?->jalurPendaftaran?->nama ?? '-',
            $pendaftaran?->tipeSekolah?->nama ?? '-',
            $pendaftaran?->jurusan?->nama ?? '-',
            $pendaftaran ? ucfirst($pendaftaran->status) : 'Belum Mendaftar',
            
            $user->dataOrangTua?->nama_ayah ?? '-',
            $user->dataOrangTua?->pekerjaan_ayah ?? '-',
            $user->dataOrangTua?->status_pekerjaan_ayah ?? '-',
            
            $user->dataOrangTua?->nama_ibu ?? '-',
            $user->dataOrangTua?->pekerjaan_ibu ?? '-',
            $user->dataOrangTua?->status_pekerjaan_ibu ?? '-',
            
            $user->created_at->format('d-m-Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4CAF50']]],
        ];
    }
}
