<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-3 px-6 flex justify-between items-center">
        <h1 class="text-lg font-semibold text-gray-800">Sistem Analitik Keuangan</h1>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-sm text-gray-600">Halo, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Konten -->
    <main class="flex-grow p-6">
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="text-center text-gray-500 text-sm py-4 border-t">
        &copy; {{ date('Y') }} Sistem Analitik Keuangan
    </footer>

</body>
</html>
