<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px;
        }
        .summary {
            margin: 20px 0;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .summary table {
            width: 100%;
        }
        .summary td {
            padding: 8px;
            font-weight: bold;
        }
        .summary .label {
            text-align: left;
            width: 70%;
        }
        .summary .value {
            text-align: right;
            width: 30%;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table.data td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table.data tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pemasukan {
            color: green;
            font-weight: bold;
        }
        .pengeluaran {
            color: red;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #333;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .total-row {
            background-color: #e8f4f8 !important;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI KEUANGAN</h1>
        <p>Sistem Analitik Keuangan</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td style="width: 150px;"><strong>Periode</strong></td>
                <td>: 
                    @if($request->filled('start_date') || $request->filled('end_date'))
                        {{ $request->start_date ? \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') : 'Awal' }}
                        s/d
                        {{ $request->end_date ? \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') : 'Sekarang' }}
                    @else
                        Semua Periode
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Jenis Transaksi</strong></td>
                <td>: 
                    @if($request->filled('jenis'))
                        {{ ucfirst($request->jenis) }}
                    @else
                        Semua Jenis
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Total Transaksi</strong></td>
                <td>: {{ $transactions->count() }} transaksi</td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Total Pemasukan:</td>
                <td class="value pemasukan">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Pengeluaran:</td>
                <td class="value pengeluaran">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 2px solid #333;">
                <td class="label">Saldo Akhir:</td>
                <td class="value" style="font-size: 16px;">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 20%;">Staff</th>
                <th style="width: 12%;">Jenis</th>
                <th style="width: 18%;">Jumlah</th>
                <th style="width: 33%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>
                        <span class="{{ $transaction->jenis == 'pemasukan' ? 'pemasukan' : 'pengeluaran' }}">
                            {{ ucfirst($transaction->jenis) }}
                        </span>
                    </td>
                    <td style="text-align: right;">Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $transaction->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Analitik Keuangan</p>
        <p>&copy; {{ date('Y') }} Sistem Analitik Keuangan. All rights reserved.</p>
    </div>
</body>
</html>
