<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-8 bg-white rounded-2xl shadow-md max-w-md">
        <h1 class="text-2xl font-semibold mb-4">Selamat Datang di Sistem Analitik Keuangan</h1>
        <p class="text-gray-600 mb-6">Silakan login untuk melanjutkan ke dashboard.</p>

        <a href="{{ route('login') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
           Login Sekarang
        </a>
    </div>
</body>
</html>
