<!-- resources/views/transactions/show.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Detail Transaksi</title></head>
<body>
<h1>Transaksi #{{ $transaction->id }}</h1>
<p>Detail: {{ $transaction->details }}</p>
<p>Nominal: Rp{{ $transaction->amount }}</p>
<p><a href="{{ route('financial-reports.show', $financialReport->id) }}">Kembali ke Laporan</a></p>
</body>
</html>
