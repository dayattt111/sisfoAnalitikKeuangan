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

        {{-- SIDEBAR --}}
        <aside id="sidebar"
               class="w-64 bg-slate-800 text-white flex flex-col shadow-lg transform transition-transform duration-300 lg:translate-x-0 -translate-x-full fixed lg:static z-50">
            
            {{-- Logo / Judul --}}
            <div class="p-6 text-xl font-semibold border-b border-slate-700">
                <span class="text-white">Admin Panel</span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 p-4 space-y-1 mt-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                   <i class="fas fa-chart-line w-5"></i>
                   <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                   <i class="fas fa-users w-5"></i>
                   <span>Kelola User</span>
                </a>

                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.reports.*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                   <i class="fas fa-file-alt w-5"></i>
                   <span>Validasi Laporan</span>
                </a>

                <a href="{{ route('admin.activity-logs.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                   <i class="fas fa-history w-5"></i>
                   <span>Monitoring Aktivitas</span>
                </a>

                <a href="{{ route('admin.fiscal-years.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.fiscal-years.*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                   <i class="fas fa-calendar-alt w-5"></i>
                   <span>Kelola Tahun</span>
                </a>
            </nav>

            {{-- Footer Sidebar --}}
            <div class="p-4 border-t border-slate-700 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-md text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-150">
                   <i class="fas fa-user-cog w-5"></i>
                   <span>Edit Profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full text-left px-4 py-2.5 rounded-md text-sm font-medium text-slate-300 hover:bg-red-600 hover:text-white transition-colors duration-150">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ✅ MAIN CONTENT --}}
        <main class="flex-1 flex flex-col bg-gray-50 lg:ml-0">
            {{-- Header --}}
            <header class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center gap-3">
                    <button id="toggleSidebar" class="lg:hidden text-slate-700 hover:text-slate-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg lg:text-xl font-semibold text-gray-800">@yield('title', 'Dashboard Admin')</h1>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
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



</body>
</html>
