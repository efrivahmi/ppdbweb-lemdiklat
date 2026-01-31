<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pdfSetting->judul_pdf }}</title>
    <style>
        @page {
            margin: 12mm 10mm;
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
            line-height: 1.3;
            padding: 5mm 10mm;
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
            width: 80px;
            vertical-align: middle;
        }

        .logo {
            width: 65px;
            height: auto;
            max-height: 65px;
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
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0 8px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .congratulation {
            background-color: #e8f5e8;
            border: 1px solid #4CAF50;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }

        .congratulation h3 {
            font-size: 12px;
            margin-bottom: 5px;
            color: #2E7D32;
        }

        .congratulation p {
            font-size: 9px;
            color: #2E7D32;
        }

        .greeting {
            margin-bottom: 10px;
            font-size: 9px;
        }

        .main-content {
            margin-bottom: 12px;
            font-size: 9px;
            text-align: justify;
        }

        .student-info {
            border: 1px solid #000;
            margin: 12px 0;
        }

        .section-title {
            background-color: #f0f0f0;
            border-bottom: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            border-right: 1px solid #000;
            padding: 3px 5px;
            font-size: 8px;
            vertical-align: top;
        }

        .info-table td:last-child {
            border-right: none;
        }

        .info-label {
            font-weight: bold;
            width: 30%;
        }

        .info-value {
            width: 70%;
        }

        .program-box {
            background-color: #e3f2fd;
            border: 1px solid #1976d2;
            padding: 8px;
            margin: 10px 0;
            text-align: center;
        }

        .program-box h4 {
            font-size: 9px;
            margin-bottom: 5px;
            color: #1976d2;
            font-weight: bold;
        }

        .program-details {
            font-size: 8px;
            color: #1976d2;
            font-weight: bold;
        }

        .next-steps {
            background-color: #fff8e1;
            border: 1px solid #ff9800;
            padding: 8px;
            margin: 10px 0;
        }

        .next-steps h4 {
            font-size: 9px;
            margin-bottom: 5px;
            text-align: center;
            color: #e65100;
            font-weight: bold;
        }

        .steps-list {
            font-size: 8px;
            color: #e65100;
            padding-left: 12px;
        }

        .steps-list li {
            margin-bottom: 2px;
        }

        .important-note {
            background-color: #ffebee;
            border: 1px solid #f44336;
            padding: 8px;
            margin: 10px 0;
        }

        .important-note h4 {
            font-size: 9px;
            margin-bottom: 5px;
            color: #c62828;
            font-weight: bold;
        }

        .important-note p {
            font-size: 8px;
            color: #c62828;
            line-height: 1.3;
        }

        .closing {
            margin: 10px 0;
            font-size: 9px;
        }

        .date-location {
            text-align: right;
            margin-bottom: 15px;
            font-size: 8px;
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

        .footer-note {
            text-align: center;
            font-size: 7px;
            margin-top: 15px;
            font-style: italic;
            border-top: 1px solid #ccc;
            padding-top: 5px;
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
                <div class="school-address">Email: {{ $pdfSetting->email }} | Telp. {{ $pdfSetting->telepon }}</div>
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
    <div class="subtitle">TAHUN PELAJARAN {{ $tahunPelajaran }}</div>

    <!-- Congratulation -->
    <div class="congratulation">
        <h3>SELAMAT!</h3>
        <p>Anda telah di terima sebagai siswa baru di {{ $pdfSetting->nama_sekolah }}</p>
    </div>

    <!-- Letter Content -->
    <div class="greeting">
        Kepada Yth. Calon Siswa/Siswi Baru<br>
        <strong>{{ $user->name }}</strong><br>
        Di tempat
    </div>

    <div class="main-content">
        Berdasarkan hasil seleksi SPMB {{ $pdfSetting->nama_sekolah }} Tahun Pelajaran {{ $tahunPelajaran }}, dengan ini kami sampaikan bahwa {{ strtoupper($user->name) }} telah&nbsp;<strong>DITERIMA</strong> sebagai siswa baru.
    </div>

    <!-- Student Information -->
    <div class="student-info">
        <div class="section-title">INFORMASI PESERTA DIDIK YANG DI TERIMA</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Lengkap</td>
                <td class="info-value">{{ $user->name }}</td>
                <td class="info-label">NISN</td>
                <td class="info-value">{{ $user->nisn ?? '-' }}</td>
            </tr>
            <tr>

                <td class="info-label">No. WhatsApp</td>
                <td class="info-value">{{ $user->dataMurid->whatsapp ?? $user->telp ?? '-' }}</td>
                <td class="info-label">Email</td>
                <td class="info-value">{{ $user->email }}</td>
            </tr>
        </table>
    </div>

    <!-- Program Information -->
    <div class="program-box">
        <h4>Di terima DI PROGRAM:</h4>
        <div class="program-details">
            Jalur Pendaftaran: {{ $pendaftaran->jalurPendaftaran->nama }} |
            Jenjang: {{ $pendaftaran->tipeSekolah->nama }} |
            Jurusan: {{ $pendaftaran->jurusan->nama }}
        </div>
    </div>

    <!-- Next Steps -->
    {{-- <div class="next-steps">
        <h4>LANGKAH SELANJUTNYA - DAFTAR ULANG</h4>
        <ol class="steps-list">
            <li>Melakukan pembayaran biaya daftar ulang sesuai ketentuan</li>
            <li>Melengkapi berkas-berkas yang diperlukan (dokumen asli dan fotokopi)</li>
            <li>Menghadiri sesi orientasi siswa baru dan pengarahan program pembelajaran</li>
            <li>Melakukan foto untuk kartu pelajar dan administrasi sekolah</li>
        </ol>
    </div> --}}

    <!-- Important Message -->
    @if($pdfSetting->pesan_penting)
    <div>
        <h4>INFORMASI PENTING</h4>
        <p>{{ $pdfSetting->pesan_penting }}</p>
        @if($pdfSetting->catatan_tambahan)
        <p style="margin-top: 3px;"><strong>Catatan:</strong> {{ $pdfSetting->catatan_tambahan }}</p>
        @endif
    </div>
    @endif

    <!-- Closing -->
    <div class="closing">
        Demikian surat penerimaan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
    </div>

    <!-- Signature Section -->
    <div class="date-location">{{ $pdfSetting->kabupaten }}, {{ $tanggalCetak }}</div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Mengetahui,<br>Orang Tua/Wali Siswa</div>
            <div class="signature-name">(...........................)</div>
        </div>

        <div class="signature-box">
            <div class="signature-title">{{ $pdfSetting->jabatan_operator }}<br>{{ $pdfSetting->nama_sekolah }}</div>
            <div class="signature-name">{{ $pdfSetting->nama_operator }}</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-note">
        Dokumen ini diterbitkan secara resmi oleh {{ strtoupper($pdfSetting->nama_sekolah) }} - {{ $tahunPelajaran }}
    </div>
</body>

</html>