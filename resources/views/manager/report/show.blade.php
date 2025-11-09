<!-- resources/views/downloads/show.blade.php -->
<!DOCTYPE html>
<html>
<head><title>Detail Unduhan</title></head>
<body>
<h1>Unduhan #{{ $download->id }}</h1>
<p>User: {{ $download->user_name }}</p>
<p>Laporan: {{ $download->report_title }}</p>
<p>Waktu: {{ $download->downloaded_at }}</p>
<p><a href="{{ route('downloads.index') }}">Kembali ke Riwayat Unduhan</a></p>
</body>
</html>
