@extends('layouts.staff')

@section('title', 'Detail Laporan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Laporan #{{ $report->id }}</h3>
            <a href="{{ route('staff.reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ⬅️ Kembali
            </a>
        </div>

        <!-- Informasi Laporan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-blue-600"></i>Informasi Laporan
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Laporan:</span>
                        <span class="font-semibold">#{{ $report->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Periode:</span>
                        <span class="font-semibold">{{ $report->bulan }}/{{ $report->tahun }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Dibuat:</span>
                        <span class="font-semibold">{{ $report->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        @if($report->status === 'pending')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @elseif($report->status === 'approved')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-check-circle mr-1"></i>Disetujui
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </span>
                        @endif
                    </div>
                    @if($report->validated_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Validasi:</span>
                        <span class="font-semibold">{{ $report->validated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-calculator mr-2 text-green-600"></i>Ringkasan Keuangan
                </h4>
                @php
                    $totalPemasukan = $report->transactions->where('jenis', 'pemasukan')->sum('jumlah');
                    $totalPengeluaran = $report->transactions->where('jenis', 'pengeluaran')->sum('jumlah');
                    $saldo = $totalPemasukan - $totalPengeluaran;
                @endphp
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center p-2 bg-green-50 rounded">
                        <span class="text-gray-700">Total Pemasukan:</span>
                        <span class="font-bold text-green-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-red-50 rounded">
                        <span class="text-gray-700">Total Pengeluaran:</span>
                        <span class="font-bold text-red-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-blue-50 rounded border-t-2 border-blue-300">
                        <span class="text-gray-700 font-semibold">Saldo:</span>
                        <span class="font-bold {{ $saldo >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            Rp {{ number_format($saldo, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-2">
                        <span class="text-gray-600">Jumlah Transaksi:</span>
                        <span class="font-semibold">{{ $report->transactions->count() }} transaksi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluasi Manager (jika ada) -->
        @if($report->komentar_manager)
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
            <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                <i class="fas fa-user-tie mr-2"></i>Evaluasi dari Manager
            </h4>
            <p class="text-gray-700 text-sm">{{ $report->komentar_manager }}</p>
            @if($report->validated_at)
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-clock mr-1"></i>{{ $report->validated_at->format('d/m/Y H:i') }}
            </p>
            @endif
        </div>
        @endif

        <!-- Catatan Admin (jika ada) -->
        @if($report->komentar_admin)
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
            <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                <i class="fas fa-user-shield mr-2"></i>Catatan dari Admin
            </h4>
            <p class="text-gray-700 text-sm">{{ $report->komentar_admin }}</p>
        </div>
        @endif

        <!-- Detail Transaksi -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-gray-700 flex items-center">
                    <i class="fas fa-list mr-2 text-purple-600"></i>Detail Transaksi
                </h4>
                @if($report->status === 'pending')
                <a href="{{ route('staff.transactions.create', ['financial_report_id' => $report->id]) }}" 
                   class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i>Tambah Transaksi
                </a>
                @endif
            </div>
            
            @if($report->transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-3 text-left">No</th>
                                <th class="p-3 text-left">Tanggal</th>
                                <th class="p-3 text-left">Jenis</th>
                                <th class="p-3 text-right">Jumlah</th>
                                <th class="p-3 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($report->transactions as $index => $transaction)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}</td>
                                    <td class="p-3">
                                        @if($transaction->jenis === 'pemasukan')
                                        <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">
                                            <i class="fas fa-arrow-up mr-1"></i>Pemasukan
                                        </span>
                                        @else
                                        <span class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">
                                            <i class="fas fa-arrow-down mr-1"></i>Pengeluaran
                                        </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right font-semibold">Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                    <td class="p-3">{{ $transaction->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500 mb-3">Belum ada transaksi dalam laporan ini.</p>
                    @if($report->status === 'pending')
                    <a href="{{ route('staff.transactions.create', ['financial_report_id' => $report->id]) }}" 
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Transaksi Pertama
                    </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            @if($report->status === 'pending')
            <a href="{{ route('staff.reports.edit', $report->id) }}" 
               class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 font-semibold">
                <i class="fas fa-edit mr-2"></i>Edit Laporan
            </a>
            <form action="{{ route('staff.reports.destroy', $report->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Yakin ingin menghapus laporan ini? Semua transaksi terkait akan ikut terhapus.')"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    <i class="fas fa-trash mr-2"></i>Hapus Laporan
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
