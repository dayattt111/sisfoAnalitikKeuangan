<!-- resources/views/financial_reports/show.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Detail Laporan {{ $report->title }}</title></head>
<body>
<h1>{{ $report->title }}</h1>
<p>{{ $report->description }}</p>

<h2>Transaksi dalam Laporan</h2>
@if(count($transactions))
    <ul>
    @foreach ($transactions as $tx)
        <li>{{ $tx->description }} – Rp{{ $tx->amount }}</li>
    @endforeach
    </ul>
@else
    <p>Tidak ada transaksi.</p>
@endif

<p><a href="{{ route('financial-reports.index') }}">Kembali ke daftar laporan</a></p>
</body>
</html>
