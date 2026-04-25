<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi PPDB</title>
    <style>
        @page { margin: 25px; }
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-4 { margin-bottom: 1rem; }
        .mt-4 { margin-top: 1rem; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 12px; color: #555; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="title">Laporan Rekapitulasi PPDB</div>
    <div class="subtitle">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>

    <table class="mb-4">
        <thead>
            <tr>
                <th colspan="2">Statistik Pendaftar Global</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="50%">Total Pendaftar (Telah Isi Form)</td>
                <td width="50%" class="text-right">{{ $stats['total'] }}</td>
            </tr>
            <tr>
                <td>Pending Verifikasi</td>
                <td class="text-right">{{ $stats['pending'] }}</td>
            </tr>
            <tr>
                <td>Diterima</td>
                <td class="text-right">{{ $stats['accepted'] }}</td>
            </tr>
            <tr>
                <td>Ditolak</td>
                <td class="text-right">{{ $stats['rejected'] }}</td>
            </tr>
        </tbody>
    </table>

    <table class="mt-4">
        <thead>
            <tr>
                <th>Jurusan</th>
                <th class="text-center">Total</th>
                <th class="text-center">Pending</th>
                <th class="text-center">Diterima</th>
                <th class="text-center">Ditolak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($majorRecap as $item)
            <tr>
                <td>{{ $item->nama_jurusan ?? $item->nama }}</td>
                <td class="text-center">{{ $item->total_applicants }}</td>
                <td class="text-center">{{ $item->pending_count }}</td>
                <td class="text-center">{{ $item->accepted_count }}</td>
                <td class="text-center">{{ $item->rejected_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="mt-4">
        <thead>
            <tr>
                <th colspan="7">Daftar Siswa Terdaftar</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Daftar</th>
                <th>Email</th>
                <th>No. Telp</th>
                <th>Jalur Pendaftaran</th>
                <th>Jurusan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registeredUsers as $index => $reg)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $reg->user->name ?? '-' }}</td>
                <td>{{ $reg->created_at->format('d M Y') }}</td>
                <td>{{ $reg->user->email ?? '-' }}</td>
                <td>{{ $reg->user->telp ?? '-' }}</td>
                <td>{{ $reg->jalurPendaftaran->nama ?? '-' }}</td>
                <td>{{ $reg->jurusan->nama ?? '-' }}</td>
                <td class="text-center">{{ ucfirst($reg->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data siswa terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
