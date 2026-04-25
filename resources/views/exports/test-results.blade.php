<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Test - {{ $test->nama_test }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .page {
            page-break-after: always;
            padding: 20px;
        }
        .page:last-child {
            page-break-after: avoid;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4f46e5;
        }
        .header h1 {
            margin: 0;
            color: #1e1b4b;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            color: #6b7280;
            font-size: 12px;
        }
        
        .section-title {
            background-color: #f3f4f6;
            padding: 8px 12px;
            font-weight: bold;
            color: #1e1b4b;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            border-left: 4px solid #4f46e5;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
            width: 140px;
        }
        .info-value {
            color: #1f2937;
        }

        .score-card {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .score-value {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
        }
        .score-label {
            font-size: 12px;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .answers-table {
            width: 100%;
            border-collapse: collapse;
        }
        .answers-table th {
            background-color: #4f46e5;
            color: white;
            text-align: left;
            padding: 10px 8px;
            font-size: 11px;
        }
        .answers-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
            vertical-align: top;
        }
        
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        
        .question-text {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .student-answer {
            color: #4b5563;
            font-style: italic;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Page 1: Recapitulation Table (The "One Form" view)
    <div class="page">
        <div class="header" style="margin-bottom: 10px;">
            <h1>REKAPITULASI HASIL TEST</h1>
            <p>{{ config('app.name', 'Lemdiklat Taruna Nusantara Indonesia') }}</p>
        </div>

        <div class="section-title">INFORMASI TEST</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Test</td>
                <td class="info-value">: {{ $test->nama_test }}</td>
                <td class="info-label">Total Peserta</td>
                <td class="info-value">: {{ $users->count() }} Siswa</td>
            </tr>
        </table>

        <table class="answers-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 45%">Nama Lengkap</th>
                    <th style="width: 20%">NISN</th>
                    <th style="width: 15%">Benar/Total</th>
                    <th style="width: 15%">Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $u)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->nisn ?? '-' }}</td>
                    <td>{{ $u->score_stats['correct'] }} / {{ $u->score_stats['total'] }}</td>
                    <td style="font-weight: bold; color: #4f46e5;">{{ $u->score_stats['percentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> -->

    @foreach($users as $user)
    <div class="page">
        <div class="header">
            <h1>LAPORAN HASIL TEST {{ $test->nama_test }}</h1>
        </div>

        <div class="section-title">BIODATA PESERTA</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Lengkap</td>
                <td class="info-value">: {{ $user->name }}</td>
                <td class="info-label">NISN</td>
                <td class="info-value">: {{ $user->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Jenis Kelamin</td>
                <td class="info-value">: {{ $user->dataMurid->jenis_kelamin ?? '-' }}</td>
                <td class="info-label">Telepon</td>
                <td class="info-value">: {{ $user->telp ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Nama Test</td>
                <td class="info-value">: {{ $test->nama_test }}</td>
            </tr>
        </table>

        <div class="score-card">
            <div class="score-label">SKOR AKHIR</div>
            <div class="score-value">{{ $user->score_stats['percentage'] }}%</div>
            <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                Jawaban Benar: {{ $user->score_stats['correct'] }} dari {{ $user->score_stats['total'] }} Soal
            </div>
        </div>

        <div class="section-title">DETAIL JAWABAN</div>
        <table class="answers-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 55%">Pertanyaan & Jawaban Siswa</th>
                    <th style="width: 25%">Kunci Jawaban (Radio)</th>
                    <th style="width: 15%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->detailed_answers as $index => $answer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="question-text">{{ $answer->customTestQuestion->pertanyaan }}</span>
                        <div class="student-answer">
                            Jawaban: {{ $answer->display_answer }}
                        </div>
                    </td>
                    <td>
                        {{ $answer->display_key }}
                    </td>
                    <td>
                        @if($answer->is_correct === true)
                            <span class="badge badge-success">Benar</span>
                        @elseif($answer->is_correct === false)
                            <span class="badge badge-danger">Salah</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | Halaman individual test report
    </div>
</body>
</html>
