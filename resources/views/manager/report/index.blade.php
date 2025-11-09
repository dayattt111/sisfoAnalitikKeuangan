<!-- resources/views/downloads/index.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Riwayat Unduhan Laporan</title></head>
<body>
<h1>Riwayat Unduhan Laporan</h1>
<table border="1">
    <tr><th>User</th><th>Laporan</th><th>Waktu Unduh</th></tr>
    @foreach ($downloads as $d)
        <tr>
            <td>{{ $d->user_name }}</td>
            <td>{{ $d->report_title }}</td>
            <td>{{ $d->downloaded_at }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
