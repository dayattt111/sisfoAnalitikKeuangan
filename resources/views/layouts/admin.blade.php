<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Analitik Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <div class="flex min-h-screen overflow-hidden">

        {{-- ✅ SIDEBAR --}}
        <aside id="sidebar"
               class="w-64 bg-gradient-to-b from-indigo-800 via-blue-800 to-blue-600 text-white flex flex-col shadow-2xl transform transition-transform duration-300 lg:translate-x-0 -translate-x-full fixed lg:static z-50">
            
            {{-- Logo / Judul --}}
            <div class="p-6 text-2xl font-bold border-b border-blue-500 flex items-center gap-2">
                {{-- <span class="text-blue-200 text-3xl">💼</span> --}}
                <span class="text-white">Admin Panel</span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 p-5 space-y-2 mt-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
                   <span>📊 Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
                   <span>👥 Kelola User</span>
                </a>

                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
                   <span>📋 Validasi Laporan</span>
                </a>

                <a href="{{ route('admin.activity-logs.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
                   <span>📜 Monitoring Aktivitas</span>
                </a>

                <a href="{{ route('admin.fiscal-years.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 {{ request()->routeIs('admin.fiscal-years.*') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
                   <span>📅 Kelola Tahun</span>
                </a>
            </nav>

            {{-- Footer Sidebar --}}
            <div class="p-5 border-t border-blue-500 space-y-2">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-600 transition duration-200">
                   ⚙️ <span>Edit Profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 w-full text-left px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                        🚪 <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ✅ MAIN CONTENT --}}
        <main class="flex-1 flex flex-col bg-gray-50 lg:ml-0">
            {{-- Header --}}
            <header class="bg-white shadow-md p-4 flex justify-between items-center border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center gap-3">
                    <button id="toggleSidebar" class="lg:hidden text-blue-700 text-2xl hover:text-blue-900">
                        ☰
                    </button>
                    <h1 class="text-lg lg:text-xl font-semibold text-gray-700">@yield('title', 'Dashboard Admin')</h1>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </header>

            {{-- Konten --}}
            <div class="p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- ✅ Script Toggle Sidebar --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Klik di luar sidebar untuk menutup (mobile)
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

    {{-- ✅ Extra Style for Glow --}}
    <style>
        a:hover {
            text-shadow: 0 0 6px rgba(255, 255, 255, 0.7);
        }
        aside {
            backdrop-filter: blur(6px);
        }
    </style>

</body>
</html>
