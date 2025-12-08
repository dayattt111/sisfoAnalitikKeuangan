@extends('layouts.staff')

@section('title', 'Dashboard Staff')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Staff</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}! 👋</p>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <a href="{{ route('staff.transactions.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Input Transaksi Baru</p>
                    <p class="text-2xl font-bold mt-2">Tambah Data</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-plus text-3xl"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('staff.reports.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Buat Laporan Baru</p>
                    <p class="text-2xl font-bold mt-2">Laporan Keuangan</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-file-alt text-3xl"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('staff.transactions.index') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Lihat Riwayat</p>
                    <p class="text-2xl font-bold mt-2">Transaksi Saya</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-history text-3xl"></i>
                </div>
            </div>
        </a>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTransaksi }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-exchange-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-arrow-up text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-arrow-down text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Laporan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalLaporan }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-file-alt text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Laporan & Statistik Bulan Ini --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Status Laporan</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-yellow-500 rounded-full p-2">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <span class="font-medium text-gray-700">Pending</span>
                    </div>
                    <span class="text-2xl font-bold text-yellow-600">{{ $laporanPending }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-500 rounded-full p-2">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <span class="font-medium text-gray-700">Disetujui</span>
                    </div>
                    <span class="text-2xl font-bold text-green-600">{{ $laporanApproved }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-500 rounded-full p-2">
                            <i class="fas fa-times text-white"></i>
                        </div>
                        <span class="font-medium text-gray-700">Ditolak</span>
                    </div>
                    <span class="text-2xl font-bold text-red-600">{{ $laporanRejected }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistik Bulan Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                    <p class="text-blue-700 text-sm font-medium">Transaksi Bulan Ini</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $transaksiThisMonth }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg">
                    <p class="text-green-700 text-sm font-medium">Pemasukan Bulan Ini</p>
                    <p class="text-xl font-bold text-green-600 mt-2">Rp {{ number_format($pemasukanThisMonth, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg">
                    <p class="text-red-700 text-sm font-medium">Pengeluaran Bulan Ini</p>
                    <p class="text-xl font-bold text-red-600 mt-2">Rp {{ number_format($pengeluaranThisMonth, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Data --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Transactions --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Transaksi Terbaru</h3>
                <a href="{{ route('staff.transactions.index') }}" class="text-blue-100 hover:text-white text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                @forelse($recentTransactions as $transaction)
                    <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="bg-{{ $transaction->jenis == 'pemasukan' ? 'green' : 'red' }}-100 rounded-full p-2">
                                    <i class="fas fa-arrow-{{ $transaction->jenis == 'pemasukan' ? 'up' : 'down' }} text-{{ $transaction->jenis == 'pemasukan' ? 'green' : 'red' }}-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ ucfirst($transaction->jenis) }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y') }}</p>
                                </div>
                            </div>
                            <p class="font-bold text-{{ $transaction->jenis == 'pemasukan' ? 'green' : 'red' }}-600">
                                Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Reports --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Laporan Terbaru</h3>
                <a href="{{ route('staff.reports.index') }}" class="text-green-100 hover:text-white text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                @forelse($recentReports as $report)
                    <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->judul }}</p>
                                <p class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                @if($report->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($report->status == 'approved')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada laporan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
