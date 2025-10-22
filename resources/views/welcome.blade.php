<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Analitik Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-blue-600">Sistem Informasi Analitik Keuangan</h1>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-500 px-3">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 px-3">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center items-center text-center px-6">
        <h2 class="text-3xl font-bold mb-4">Hi</h2>
        <p class="text-gray-600 max-w-lg">
            Ini adalah sebuah Sistem Informasi Analitik Keuangan
        </p>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel Project') }}. All rights reserved.
    </footer>

</body>
</html>
