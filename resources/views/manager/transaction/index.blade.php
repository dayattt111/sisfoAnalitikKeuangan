@extends('layouts.manager')

@section('content')
<div class="container mx-auto mt-8 px-4">
    {{-- Mengganti Bootstrap Card dengan div Tailwind --}}
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl">
        <h2 class="text-2xl md:text-3xl font-extrabold text-center mb-6 text-indigo-700">
            💼 Laporan Transaksi Staff
        </h2>

        <div class="overflow-x-auto">
            {{-- Mengganti kelas Table Bootstrap dengan Tailwind --}}
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-indigo-50 border-b border-indigo-200">
                    <tr class="text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4 text-left">Nama Staff</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Jenis</th>
                        {{-- Rata kanan untuk header Jumlah --}}
                        <th class="py-3 px-4 text-right">Jumlah</th>
                        <th class="py-3 px-4 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($transactions as $t)
                        <tr class="hover:bg-gray-50 transition duration-150 text-sm text-gray-700">
                            <td class="py-3 px-4 text-center">{{ $t['id'] }}</td>
                            <td class="py-3 px-4 font-medium">{{ $t['nama_staff'] }}</td>
                            <td class="py-3 px-4 text-center">{{ \Carbon\Carbon::parse($t['tanggal'])->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                {{-- Badge menggunakan Tailwind --}}
                                @php
                                    $badgeClass = $t['jenis'] == 'Pemasukan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                    {{ $t['jenis'] }}
                                </span>
                            </td>
                            {{-- Rata kanan untuk data Jumlah --}}
                            <td class="py-3 px-4 font-semibold text-right whitespace-nowrap">
                                Rp {{ number_format($t['jumlah'], 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-sm">{{ $t['keterangan'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- Footer menggunakan Tailwind --}}
                <tfoot class="font-bold border-t-2 border-indigo-600">
                    <tr class="bg-gray-100">
                        <td colspan="4" class="py-3 px-4 text-right text-emerald-600">Total Pemasukan</td>
                        <td class="py-3 px-4 text-right text-emerald-600 whitespace-nowrap">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td colspan="4" class="py-3 px-4 text-right text-red-600">Total Pengeluaran</td>
                        <td class="py-3 px-4 text-right text-red-600 whitespace-nowrap">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr class="bg-indigo-100 border-t border-indigo-300">
                        <td colspan="4" class="py-3 px-4 text-right text-indigo-700">Saldo Akhir</td>
                        <td class="py-3 px-4 text-right text-indigo-700 text-lg whitespace-nowrap">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection