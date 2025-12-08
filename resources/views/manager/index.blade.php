@extends('layouts.manager')

@section('title', 'Dashboard Manager')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-green-600 text-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">Selamat datang, {{ Auth::user()->name }}</h2>
        <p class="text-green-100">
            Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>
        </p>
    </div>

    {{-- Statistik Card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Laporan Keuangan</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalReports ?? 0 }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Transaksi Bulan Ini</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $monthlyTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Staff Aktif</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalStaff ?? 0 }}</p>
        </div>
    </div>

    {{-- Fitur Utama --}}
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-semibold mb-4">Fitur Manager</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('manager.finance.index') }}"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                <i class="fas fa-chart-bar mr-2"></i> Lihat Laporan Keuangan
            </a> 
            <a href="{{ route('manager.transaction.index') }}"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                <i class="fas fa-credit-card mr-2"></i> Laporan Transaksi
            </a>
            <a href="{{ route('manager.report.index') }}"
                class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                <i class="fas fa-check-circle mr-2"></i> Validasi Laporan
            </a>
        </div>
    </div>
</div>
@endsection
