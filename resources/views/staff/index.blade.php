@extends('layouts.admin')

@section('title', 'Dashboard Staff')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">Selamat datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-pink-100">
            Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>
        </p>
    </div>

    {{-- Statistik Card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Total Transaksi Hari Ini</h3>
            <p class="text-3xl font-bold text-pink-600 mt-2">{{ $todayTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-medium">Laporan yang Dikirim</h3>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $submittedReports ?? 0 }}</p>
        </div>
    </div>

    {{-- Fitur Utama --}}
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-semibold mb-4">Fitur Staff</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('staff.transactions.create') }}"
                class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                💵 Input Transaksi
            </a>
            <a href="{{ route('staff.reports.index') }}"
                class="inline-flex items-center bg-pink-600 hover:bg-pink-700 text-white font-semibold px-5 py-3 rounded-lg transition">
                📄 Lihat Laporan Saya
            </a>
        </div>
    </div>
</div>
@endsection
