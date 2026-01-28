<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\GelombangPendaftaran;
use App\Models\Pendaftaran\PendaftaranMurid;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

#[Layout("layouts.admin")]
#[Title("Gelombang Pendaftaran")]
class GelombangPendaftaranPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;
    
    public $nama_gelombang, $pendaftaran_mulai, $pendaftaran_selesai, $ujian_mulai, $ujian_selesai, $pengumuman_tanggal;
    
    protected $rules = [
        'nama_gelombang' => 'required|string|max:100',
        'pendaftaran_mulai' => 'required|date_format:Y-m-d\TH:i',
        'pendaftaran_selesai' => 'required|date_format:Y-m-d\TH:i|after:pendaftaran_mulai',
        'ujian_mulai' => 'required|date_format:Y-m-d\TH:i|after:pendaftaran_selesai',
        'ujian_selesai' => 'required|date_format:Y-m-d\TH:i|after:ujian_mulai',
        'pengumuman_tanggal' => 'required|date_format:Y-m-d\TH:i|after:ujian_selesai',
    ];
    
    protected $messages = [
        'nama_gelombang.required' => 'Nama gelombang wajib diisi',
        'nama_gelombang.max' => 'Nama maksimal 100 karakter',
        'pendaftaran_mulai.required' => 'Tanggal mulai pendaftaran wajib diisi',
        'pendaftaran_mulai.date_format' => 'Format tanggal dan jam tidak valid (contoh: 2023-10-01T14:30)',
        'pendaftaran_selesai.required' => 'Tanggal selesai pendaftaran wajib diisi',
        'pendaftaran_selesai.date_format' => 'Format tanggal dan jam tidak valid (contoh: 2023-10-01T14:30)',
        'pendaftaran_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai pendaftaran',
        'ujian_mulai.required' => 'Tanggal mulai ujian wajib diisi',
        'ujian_mulai.date_format' => 'Format tanggal dan jam tidak valid (contoh: 2023-10-01T14:30)',
        'ujian_mulai.after' => 'Tanggal mulai ujian harus setelah selesai pendaftaran',
        'ujian_selesai.required' => 'Tanggal selesai ujian wajib diisi',
        'ujian_selesai.date_format' => 'Format tanggal dan jam tidak valid (contoh: 2023-10-01T14:30)',
        'ujian_selesai.after' => 'Tanggal selesai ujian harus setelah mulai ujian',
        'pengumuman_tanggal.required' => 'Tanggal pengumuman wajib diisi',
        'pengumuman_tanggal.date_format' => 'Format tanggal dan jam tidak valid (contoh: 2023-10-01T14:30)',
        'pengumuman_tanggal.after' => 'Tanggal pengumuman harus setelah selesai ujian',
    ];
    
    public function openModal()
    {
        $this->dispatch('open-modal', name: 'gelombang-pendaftaran');
    }
    
    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'gelombang-pendaftaran');
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->reset([
            'nama_gelombang', 
            'pendaftaran_mulai', 
            'pendaftaran_selesai', 
            'ujian_mulai', 
            'ujian_selesai', 
            'pengumuman_tanggal', 
            'editMode', 
            'selectedId'
        ]);
        $this->resetErrorBag();
    }
    
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }
    
    public function edit($id)
    {
        $gelombang = GelombangPendaftaran::findOrFail($id);
        $this->selectedId = $id;
        $this->nama_gelombang = $gelombang->nama_gelombang;
        
        $this->pendaftaran_mulai = $gelombang->pendaftaran_mulai->format('Y-m-d\TH:i');
        $this->pendaftaran_selesai = $gelombang->pendaftaran_selesai->format('Y-m-d\TH:i');
        $this->ujian_mulai = $gelombang->ujian_mulai->format('Y-m-d\TH:i');
        $this->ujian_selesai = $gelombang->ujian_selesai->format('Y-m-d\TH:i');
        $this->pengumuman_tanggal = $gelombang->pengumuman_tanggal->format('Y-m-d\TH:i');
        
        $this->editMode = true;
        $this->openModal();
    }
    
    public function save()
    {
        $this->validate();
        
        $appTimezone = config('app.timezone');
        $data = [
            'nama_gelombang' => $this->nama_gelombang,
            'pendaftaran_mulai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->pendaftaran_mulai)
                                         ->setTimezone($appTimezone)
                                         ->toDateTimeString(),
            'pendaftaran_selesai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->pendaftaran_selesai)
                                           ->setTimezone($appTimezone)
                                           ->toDateTimeString(),
            'ujian_mulai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->ujian_mulai)
                                   ->setTimezone($appTimezone)
                                   ->toDateTimeString(),
            'ujian_selesai' => Carbon::createFromFormat('Y-m-d\TH:i', $this->ujian_selesai)
                                     ->setTimezone($appTimezone)
                                     ->toDateTimeString(),
            'pengumuman_tanggal' => Carbon::createFromFormat('Y-m-d\TH:i', $this->pengumuman_tanggal)
                                          ->setTimezone($appTimezone)
                                          ->toDateTimeString(),
        ];
        
        if ($this->editMode) {
            $gelombang = GelombangPendaftaran::findOrFail($this->selectedId);
            $gelombang->update($data);
            $message = 'Gelombang pendaftaran berhasil diperbarui';
        } else {
            GelombangPendaftaran::create($data);
            $message = 'Gelombang pendaftaran berhasil ditambahkan';
        }
        
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
        
        $this->resetPage();
    }
    
    public function delete($id)
    {
        try {
            $gelombang = GelombangPendaftaran::findOrFail($id);
            $gelombang->delete();
            $this->dispatch("alert", message: "Gelombang pendaftaran berhasil di hapus.", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat menghapus gelombang pendaftaran yang digunakan", type: "error");
        }
    }
    
    public function exportExcel($id)
    {
        try {
            $gelombang = GelombangPendaftaran::findOrFail($id);
            
            // Ambil data pendaftaran murid yang created_at nya dalam periode gelombang
            $pendaftarans = PendaftaranMurid::with([
                'user.dataMurid',
                'user.dataOrangTua', 
                'jalurPendaftaran',
                'tipeSekolah',
                'jurusan'
            ])
            ->whereBetween('created_at', [
                $gelombang->pendaftaran_mulai,
                $gelombang->pendaftaran_selesai
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
            // Generate nama file
            $filename = 'Gelombang_' . str_replace(' ', '_', $gelombang->nama_gelombang) . '_' . now()->format('YmdHis') . '.xlsx';
            
            // Download Excel
            return Excel::download(
                new GelombangPendaftaranExport($gelombang, $pendaftarans), 
                $filename
            );
            
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal mengexport Excel: " . $e->getMessage(), type: "error");
            return null;
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $gelombangs = GelombangPendaftaran::where('nama_gelombang', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);
        
        return view('livewire.admin.pendaftaran.gelombang-pendaftaran-page', ['gelombangs' => $gelombangs]);
    }
}

// Excel Export Class
class GelombangPendaftaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $gelombang;
    protected $pendaftarans;
    protected $rowNumber = 0;
    
    public function __construct($gelombang, $pendaftarans)
    {
        $this->gelombang = $gelombang;
        $this->pendaftarans = $pendaftarans;
    }
    
    public function collection()
    {
        return $this->pendaftarans;
    }
    
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'WhatsApp',
            'Alamat',
            'Asal Sekolah',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Telp Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Telp Ibu',
            'Jalur Pendaftaran',
            'Tipe Sekolah',
            'Jurusan',
            'Status',
            'Tanggal Daftar'
        ];
    }
    
    public function map($pendaftaran): array
    {
        $this->rowNumber++;
        
        return [
            $this->rowNumber,
            $pendaftaran->user->name ?? '-',
            $pendaftaran->user->nisn ?? '-',
            $pendaftaran->user->dataMurid->tempat_lahir ?? '-',
            $pendaftaran->user->dataMurid->tgl_lahir ? 
                Carbon::parse($pendaftaran->user->dataMurid->tgl_lahir)->format('d-m-Y') : '-',
            $pendaftaran->user->dataMurid->jenis_kelamin ?? '-',
            $pendaftaran->user->dataMurid->agama ?? '-',
            $pendaftaran->user->dataMurid->whatsapp ?? '-',
            $pendaftaran->user->dataMurid->alamat ?? '-',
            $pendaftaran->user->dataMurid->asal_sekolah ?? '-',
            $pendaftaran->user->dataOrangTua->nama_ayah ?? '-',
            $pendaftaran->user->dataOrangTua->pekerjaan_ayah ?? '-',
            $pendaftaran->user->dataOrangTua->telp_ayah ?? '-',
            $pendaftaran->user->dataOrangTua->nama_ibu ?? '-',
            $pendaftaran->user->dataOrangTua->pekerjaan_ibu ?? '-',
            $pendaftaran->user->dataOrangTua->telp_ibu ?? '-',
            $pendaftaran->jalurPendaftaran->nama ?? '-',
            $pendaftaran->tipeSekolah->nama ?? '-',
            $pendaftaran->jurusan->nama ?? '-',
            $this->getStatusText($pendaftaran->status),
            Carbon::parse($pendaftaran->created_at)->format('d-m-Y H:i')
        ];
    }
    
    private function getStatusText($status)
    {
        return match($status) {
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'pending' => 'Pending',
            default => 'Belum Diproses'
        };
    }
    
    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:U1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '84CC16'] // lime-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        
        // Data rows styling
        $lastRow = $this->pendaftarans->count() + 1;
        $sheet->getStyle('A2:U' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        
        // Auto-size columns
        foreach (range('A', 'U') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        // Wrap text for alamat column
        $sheet->getStyle('I2:I' . $lastRow)->getAlignment()->setWrapText(true);
        
        return [];
    }
    
    public function title(): string
    {
        return substr($this->gelombang->nama_gelombang, 0, 31); // Excel sheet title max 31 chars
    }
}