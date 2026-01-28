<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pdfSetting->judul_pdf }}</title>
    <style>
        @page {
            margin: 15mm 10mm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 5mm 10mm;
            line-height: 1.2;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .logo-left,
        .logo-right {
            display: table-cell;
            width: 60px;
            vertical-align: middle;
        }

        .logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .school-info {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            padding: 0 15px;
        }

        .school-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .school-address {
            font-size: 8px;
            margin-bottom: 1px;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .tahun {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }

        .section-title {
            background-color: #e0e0e0;
            border: 1px solid #000;
            padding: 3px 5px;
            font-weight: bold;
            font-size: 9px;
            text-align: center;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 9px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 25%;
        }

        .colon {
            width: 3%;
            text-align: center;
        }

        .value {
            width: 72%;
        }

        .additional-data {
            margin: 15px 0;
        }

        .additional-data .section-title {
            text-align: center;
            margin-bottom: 5px;
        }

        .additional-table {
            width: 100%;
            border-collapse: collapse;
        }

        .additional-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 9px;
            text-align: center;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 8px;
            margin: 15px 0;
            font-size: 9px;
            line-height: 1.3;
        }

        .warning-title {
            font-weight: bold;
            color: #856404;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 15px;
        }

        .signature-box {
            display: table-cell;
            text-align: center;
            width: 50%;
            vertical-align: top;
        }

        .signature-title {
            font-size: 8px;
            margin-bottom: 35px;
        }

        .signature-name {
            font-size: 9px;
            border-top: 1px solid #000;
            padding-top: 3px;
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        .date-location {
            text-align: right;
            margin-bottom: 20px;
            font-size: 9px;
        }

        .footer-note {
            text-align: center;
            font-size: 8px;
            margin-top: 20px;
            font-style: italic;
        }

        .two-column {
            display: flex;
            gap: 20px;
        }

        .column {
            flex: 1;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-15 {
            margin-bottom: 15px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="logo-left">
                @if($pdfSetting->hasLogoKiri())
                <img src="{{ $pdfSetting->logo_kiri_path }}" alt="Logo Kiri" class="logo">
                @endif
            </div>

            <div class="school-info">
                <div class="school-name">{{ strtoupper($pdfSetting->nama_sekolah) }}</div>
                <div class="school-address">{{ $pdfSetting->alamat_lengkap }}</div>
                <div class="school-address">
                    Email: {{ $pdfSetting->email }} | Telp. {{ $pdfSetting->telepon }}
                </div>
                @if($pdfSetting->website)
                <div class="school-address">Website: {{ $pdfSetting->website }}</div>
                @endif
            </div>

            <div class="logo-right">
                @if($pdfSetting->hasLogoKanan())
                <img src="{{ $pdfSetting->logo_kanan_path }}" alt="Logo Kanan" class="logo">
                @endif
            </div>
        </div>
    </div>

    <!-- Title -->
    <div class="title">{{ $pdfSetting->judul_pdf }}</div>
    <div class="subtitle">PENERIMAAN SISWA BARU</div>
    <div class="tahun">TAHUN PELAJARAN {{ $tahunPelajaran }}</div>

    <!-- Info Verifikasi -->
    <table class="info-table mb-15">
        <thead>
            <tr>
                <th colspan="3" class="section-title">INFO VERIFIKASI PENDAFTARAN</th>
            </tr>
            <tr>
                <th>NISN</th>
                <th>Nomor Kartu Keluarga</th>
                <th>Nomor WhatsApp</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; padding: 5px; border: 1px solid #000;">{{ $user->nisn ?? '-' }}</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #000;">{{ $user->dataMurid->nomor_kartu_keluarga ?? '-' }}</td>
                <td style="text-align: center; padding: 5px; border: 1px solid #000;">{{ $user->dataMurid->whatsapp ?? $user->telp ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Biodata Section -->
    <div class="two-column">
        <!-- Biodata Siswa -->
        <div class="column">
            <div class="section-title mb-10">BIODATA SISWA/SISWI</div>
            <table class="data-table">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="value">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="value">{{ $user->dataMurid->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tgl & Lahir</td>
                    <td class="value">
                        @if($user->dataMurid)
                        {{ $user->dataMurid->tempat_lahir }}, {{ \Carbon\Carbon::parse($user->dataMurid->tgl_lahir)->format('d M Y') }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Agama</td>
                    <td class="value">{{ $user->dataMurid->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="value">{{ $user->dataMurid->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Sekolah Asal</td>
                    <td class="value">{{ $user->dataMurid->asal_sekolah ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Biodata Orang Tua -->
        <div class="column">
            <div class="section-title mb-10">BIODATA ORANG TUA</div>
            <table class="data-table">
                <tr>
                    <td class="label">Nama Ayah</td>
                    <td class="value">{{ $user->dataOrangTua->nama_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="value">{{ $user->dataOrangTua->pekerjaan_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Penghasilan Ayah</td>
                    <td class="value">{{ $user->dataOrangTua->penghasilan_ayah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Ibu</td>
                    <td class="value">{{ $user->dataOrangTua->nama_ibu ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="value">{{ $user->dataOrangTua->pekerjaan_ibu ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Penghasilan Ibu</td>
                    <td class="value">{{ $user->dataOrangTua->penghasilan_ibu ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Data Tambahan -->
    <div class="additional-data">
        <div class="section-title mb-10">DATA TAMBAHAN</div>
        <table class="additional-table">
            <tr>
                <td><strong>Riwayat Penyakit</strong></td>
                <td><strong>Berat Badan</strong></td>
                <td><strong>Tinggi Badan</strong></td>
            </tr>
            <tr>
                <td>{{ $user->dataMurid->riwayat_penyakit ?? 'Tidak ada' }}</td>
                <td>{{ $user->dataMurid->berat_badan ?? '-' }} kg</td>
                <td>{{ $user->dataMurid->tinggi_badan ?? '-' }} cm</td>
            </tr>
        </table>
    </div>

    <!-- Pesan Penting -->
    @if($pdfSetting->pesan_penting)
    <div class="warning">
        <div class="warning-title">Perhatian!</div>
        <div style="margin-top: 5px;">{{ $pdfSetting->pesan_penting }}</div>
        @if($pdfSetting->catatan_tambahan)
        <div style="margin-top: 5px;"><strong>Catatan:</strong> {{ $pdfSetting->catatan_tambahan }}</div>
        @endif
    </div>
    @endif

    <!-- Signature Section -->
    <div class="date-location">{{ $pdfSetting->kabupaten }}, {{ $tanggalCetak }}</div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Menyetujui data diatas<br>Ortu/Wali Siswa Terdaftar</div>
            <div class="signature-name">(...........................)</div>
        </div>

        <div class="signature-box">
            <div class="signature-title">{{ $pdfSetting->jabatan_operator }}<br>{{ $pdfSetting->nama_sekolah }}</div>
            <div class="signature-name">{{ $pdfSetting->nama_operator }}</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-note">
        {{ strtoupper($pdfSetting->nama_sekolah) }} TP.{{ $tahunPelajaran }}
    </div>
</body>

</html>