<!-- resources/views/financial_reports/index.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Daftar Laporan Keuangan</title></head>
<body>
<h1>Daftar Laporan Keuangan</h1>
<table border="1">
    <tr><th>Judul Laporan</th><th>Aksi</th></tr>
    @foreach ($reports as $report)
        <tr>
            <td>{{ $report->title }}</td>
            <td><a href="{{ route('financial-reports.show', $report->id) }}">Lihat</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
