@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">Selamat datang, {{ Auth::user()->name }}</h2>
        <p class="text-blue-100">
            Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total User</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Admin</h3>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalAdmin }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Manager</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalManager }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Staff</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalStaff }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg shadow">
            <h3 class="text-yellow-700 text-sm font-medium">Laporan Pending</h3>
            <p class="text-3xl font-bold text-yellow-800 mt-2">{{ $pendingReports }}</p>
            <a href="{{ route('admin.reports.index') }}" class="text-yellow-600 text-sm hover:underline mt-2 inline-block">Lihat Detail →</a>
        </div>

        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg shadow">
            <h3 class="text-green-700 text-sm font-medium">Laporan Disetujui</h3>
            <p class="text-3xl font-bold text-green-800 mt-2">{{ $approvedReports }}</p>
        </div>

        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow">
            <h3 class="text-red-700 text-sm font-medium">Laporan Ditolak</h3>
            <p class="text-3xl font-bold text-red-800 mt-2">{{ $rejectedReports }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-600 text-sm font-medium">Total Transaksi</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $totalTransactions }}</p>
        </div>

        <div class="bg-emerald-50 p-6 rounded-lg shadow">
            <h3 class="text-emerald-600 text-sm font-medium">Total Pemasukan</h3>
            <p class="text-2xl font-bold text-emerald-700 mt-2">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-rose-50 p-6 rounded-lg shadow">
            <h3 class="text-rose-600 text-sm font-medium">Total Pengeluaran</h3>
            <p class="text-2xl font-bold text-rose-700 mt-2">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4 flex items-center justify-between">
            <span>Aktivitas Terbaru</span>
            <a href="{{ route('admin.activity-logs.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua →</a>
        </h3>
        <div class="space-y-3">
            @forelse($recentActivities as $activity)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">{{ $activity->activity }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            oleh <strong>{{ $activity->user->name ?? 'System' }}</strong> - 
                            {{ $activity->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
