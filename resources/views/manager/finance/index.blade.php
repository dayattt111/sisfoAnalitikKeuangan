@extends('layouts.manager')

@section('title', 'Ringkasan Keuangan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">📊 Ringkasan Keuangan</h2>
        <p class="text-green-100">Laporan keuangan bulanan dan tahunan.</p>
    </div>

    {{-- Statistik Tahunan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500 text-sm font-medium">Total Pemasukan</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500 text-sm font-medium">Total Pengeluaran</h3>
            <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500 text-sm font-medium">Saldo Akhir</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Tabel Ringkasan Bulanan --}}
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-semibold mb-4">📅 Ringkasan Keuangan Bulanan</h3>
        <table class="w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Bulan</th>
                    <th class="p-3 text-right">Pemasukan</th>
                    <th class="p-3 text-right">Pengeluaran</th>
                    <th class="p-3 text-right">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $data)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $data['bulan'] }}</td>
                        <td class="p-3 text-right text-green-600">Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right text-red-600">Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-semibold text-blue-600">
                            Rp {{ number_format($data['pemasukan'] - $data['pengeluaran'], 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
