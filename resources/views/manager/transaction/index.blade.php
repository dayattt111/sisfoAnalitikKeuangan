<!-- resources/views/transactions/index.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Transaksi Laporan {{ $financialReport->title }}</title></head>
<body>
<h1>Transaksi untuk: {{ $financialReport->title }}</h1>
<table border="1">
    <tr><th>ID</th><th>Detail</th><th>Aksi</th></tr>
    @foreach ($transactions as $tx)
        <tr>
            <td>{{ $tx->id }}</td>
            <td>{{ $tx->details }}</td>
            <td>
                <a href="{{ route('transactions.show', $tx->id) }}">Detail</a>
            </td>
        </tr>
    @endforeach
</table>
<p><a href="{{ route('financial-reports.show', $financialReport->id) }}">Kembali ke Laporan</a></p>
</body>
</html>
