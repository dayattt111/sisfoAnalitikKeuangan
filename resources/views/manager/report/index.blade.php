@extends('layouts.manager')

@section('title', 'Rekapitulasi Keuangan & Staff')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl">
        <h2 class="text-2xl md:text-3xl font-extrabold text-center mb-8 text-indigo-800">
            📊 Rekapitulasi Keuangan & Kinerja
        </h2>

        {{-- 1. OVERVIEW CARDS: Pemasukan, Pengeluaran, Saldo, Margin --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- Card Total Pemasukan --}}
            <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-5 shadow-lg">
                <p class="text-sm font-medium text-emerald-600 uppercase">Total Pemasukan</p>
                <p class="text-3xl font-bold text-emerald-900 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>

            {{-- Card Total Pengeluaran --}}
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-5 shadow-lg">
                <p class="text-sm font-medium text-red-600 uppercase">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-red-900 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>

            {{-- Card Saldo Akhir --}}
            <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-5 shadow-lg">
                <p class="text-sm font-medium text-indigo-600 uppercase">Saldo Akhir</p>
                <p class="text-3xl font-bold text-indigo-900 mt-1">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
            </div>

            {{-- Card Profit Margin --}}
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-5 shadow-lg">
                <p class="text-sm font-medium text-yellow-600 uppercase">Profit Margin</p>
                <p class="text-3xl font-bold text-yellow-900 mt-1">{{ $profitMargin }}%</p>
            </div>
        </div>

        {{-- 2. STAFF PERFORMANCE RECAP --}}
        <h3 class="text-xl font-bold text-indigo-700 mb-4 border-b pb-2">Rekapitulasi Kinerja Staff</h3>
        <div class="overflow-x-auto mb-10 shadow-lg rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <th class="py-3 px-4 text-left">Nama Staff</th>
                        <th class="py-3 px-4 text-left">Posisi</th>
                        <th class="py-3 px-4 text-right">Pemasukan (Realisasi)</th>
                        <th class="py-3 px-4 text-right">Target Revenue</th>
                        <th class="py-3 px-4 text-center">Progres (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($staffRecap as $staff)
                        <tr class="hover:bg-gray-50 transition duration-150 text-sm text-gray-700">
                            <td class="py-3 px-4 font-medium">{{ $staff['name'] }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $staff['role'] }}</td>
                            <td class="py-3 px-4 text-right font-semibold text-emerald-700 whitespace-nowrap">
                                Rp {{ number_format($staff['pemasukan'], 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right text-indigo-600 whitespace-nowrap">
                                @if ($staff['target_revenue'] > 0)
                                    Rp {{ number_format($staff['target_revenue'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                {{-- Progress Bar --}}
                                @php
                                    $progressColor = $staff['progress'] >= 100 ? 'bg-emerald-500' : 'bg-yellow-500';
                                    $progressWidth = min($staff['progress'], 100);
                                @endphp
                                <div class="bg-gray-200 rounded-full h-2.5">
                                    <div class="{{ $progressColor }} h-2.5 rounded-full" style="width: {{ $progressWidth }}%"></div>
                                </div>
                                <div class="text-center mt-1 text-xs @if ($staff['progress'] >= 100) text-emerald-600 @else text-yellow-600 @endif">
                                    {{ $staff['progress'] }}%
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 3. FORECAST TRANSACTIONS --}}
        <h3 class="text-xl font-bold text-indigo-700 mb-4 border-b pb-2">Transaksi Perkiraan (Forecast)</h3>
        <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <th class="py-3 px-4 text-left">Periode</th>
                        <th class="py-3 px-4 text-right">Perkiraan Revenue</th>
                        <th class="py-3 px-4 text-right">Perkiraan Beban</th>
                        <th class="py-3 px-4 text-right">Perkiraan Profit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($forecast as $f)
                        @php
                            $profitEstimate = $f['revenue_estimate'] - $f['expense_estimate'];
                        @endphp
                        <tr class="hover:bg-blue-50 transition duration-150 text-sm text-gray-700">
                            <td class="py-3 px-4 font-medium">{{ $f['month'] }}</td>
                            <td class="py-3 px-4 text-right text-emerald-600 whitespace-nowrap">Rp {{ number_format($f['revenue_estimate'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right text-red-600 whitespace-nowrap">Rp {{ number_format($f['expense_estimate'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right font-bold text-indigo-700 whitespace-nowrap">Rp {{ number_format($profitEstimate, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection