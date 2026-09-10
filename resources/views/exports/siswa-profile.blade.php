<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profil Siswa - {{ $user->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; }
        .section { margin-bottom: 20px; }
        .section-title { background-color: #f3f4f6; padding: 5px 10px; font-weight: bold; margin-bottom: 10px; border-left: 4px solid #4CAF50; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; vertical-align: top; }
        th { width: 35%; background-color: #fafafa; font-weight: normal; color: #555; }
        td { font-weight: bold; }
        .footer { text-align: right; margin-top: 40px; font-size: 11px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Profil Data Siswa</h1>
        <p>PPDB Web Lemdiklat</p>
    </div>

    @php
        $tahun = $user->created_at->format('Y');
        $tahunAjaran = "TA {$tahun}/" . ($tahun + 1);
        $pendaftaran = $user->pendaftaranMurids->first();
    @endphp

    <div class="section">
        <div class="section-title">Informasi Akun & Pendaftaran</div>
        <table>
            <tr><th>Tahun Ajaran</th><td>{{ $tahunAjaran }}</td></tr>
            <tr><th>Nama Lengkap</th><td>{{ $user->name }}</td></tr>
            <tr><th>NISN</th><td>{{ $user->nisn }}</td></tr>
            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
            <tr><th>No Telepon</th><td>{{ $user->telp }}</td></tr>
            <tr><th>Tanggal Daftar</th><td>{{ $user->created_at->format('d M Y, H:i') }}</td></tr>
            <tr><th>Jalur Pendaftaran</th><td>{{ $pendaftaran->jalurPendaftaran->nama ?? '-' }}</td></tr>
            <tr><th>Tipe Sekolah</th><td>{{ $pendaftaran->tipeSekolah->nama ?? '-' }}</td></tr>
            <tr><th>Jurusan</th><td>{{ $pendaftaran->jurusan->nama ?? '-' }}</td></tr>
            <tr><th>Status Pendaftaran</th><td>{{ $pendaftaran ? ucfirst($pendaftaran->status) : 'Belum Mendaftar' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Diri Siswa</div>
        <table>
            <tr><th>No KK</th><td>{{ $user->dataMurid->no_kk ?? '-' }}</td></tr>
            <tr><th>Tempat, Tgl Lahir</th><td>{{ $user->dataMurid->tempat_lahir ?? '-' }}, {{ $user->dataMurid->tgl_lahir ? date('d M Y', strtotime($user->dataMurid->tgl_lahir)) : '-' }}</td></tr>
            <tr><th>Jenis Kelamin</th><td>{{ $user->dataMurid->jenis_kelamin ?? '-' }}</td></tr>
            <tr><th>Agama</th><td>{{ $user->dataMurid->agama ?? '-' }}</td></tr>
            <tr><th>WhatsApp</th><td>{{ $user->dataMurid->whatsapp ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->dataMurid->alamat ?? '-' }}</td></tr>
            <tr><th>Asal Sekolah</th><td>{{ $user->dataMurid->asal_sekolah ?? '-' }}</td></tr>
            <tr><th>Berat / Tinggi Badan</th><td>{{ $user->dataMurid->bb ? $user->dataMurid->bb . ' kg' : '-' }} / {{ $user->dataMurid->tb ? $user->dataMurid->tb . ' cm' : '-' }}</td></tr>
            <tr><th>Riwayat Penyakit</th><td>{{ $user->dataMurid->riwayat_penyakit ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Orang Tua (Ayah)</div>
        <table>
            <tr><th>Nama Ayah</th><td>{{ $user->dataOrangTua->nama_ayah ?? '-' }}</td></tr>
            <tr><th>Pendidikan</th><td>{{ $user->dataOrangTua->pendidikan_ayah ?? '-' }}</td></tr>
            <tr><th>No. Telp</th><td>{{ $user->dataOrangTua->telp_ayah ?? '-' }}</td></tr>
            <tr><th>Pekerjaan</th><td>{{ $user->dataOrangTua->pekerjaan_ayah ?? '-' }}</td></tr>
            <tr><th>Status Pekerjaan</th><td>{{ $user->dataOrangTua->status_pekerjaan_ayah ?? '-' }}</td></tr>
            <tr><th>Penghasilan</th><td>{{ $user->dataOrangTua->penghasilan_ayah ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->dataOrangTua->alamat_ayah ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Orang Tua (Ibu)</div>
        <table>
            <tr><th>Nama Ibu</th><td>{{ $user->dataOrangTua->nama_ibu ?? '-' }}</td></tr>
            <tr><th>Pendidikan</th><td>{{ $user->dataOrangTua->pendidikan_ibu ?? '-' }}</td></tr>
            <tr><th>No. Telp</th><td>{{ $user->dataOrangTua->telp_ibu ?? '-' }}</td></tr>
            <tr><th>Pekerjaan</th><td>{{ $user->dataOrangTua->pekerjaan_ibu ?? '-' }}</td></tr>
            <tr><th>Status Pekerjaan</th><td>{{ $user->dataOrangTua->status_pekerjaan_ibu ?? '-' }}</td></tr>
            <tr><th>Penghasilan</th><td>{{ $user->dataOrangTua->penghasilan_ibu ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->dataOrangTua->alamat_ibu ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
