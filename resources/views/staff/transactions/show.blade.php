@extends('layouts.staff')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Transaksi #{{ $transaction->id }}</h3>
            <a href="{{ route('staff.transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ⬅️ Kembali
            </a>
        </div>

        <!-- Informasi Transaksi -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
            <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Transaksi
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Transaksi:</span>
                        <span class="font-semibold">#{{ $transaction->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jenis:</span>
                        @if($transaction->jenis === 'pemasukan')
                        <span class="px-3 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-arrow-up mr-1"></i>Pemasukan
                        </span>
                        @else
                        <span class="px-3 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">
                            <i class="fas fa-arrow-down mr-1"></i>Pengeluaran
                        </span>
                        @endif
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-bold text-lg {{ $transaction->jenis === 'pemasukan' ? 'text-green-700' : 'text-red-700' }}">
                            Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Laporan:</span>
                        @if($transaction->financialReport)
                        <a href="{{ route('staff.reports.show', $transaction->financial_report_id) }}" 
                           class="text-blue-600 hover:underline font-semibold">
                            Laporan {{ $transaction->financialReport->bulan }}/{{ $transaction->financialReport->tahun }}
                        </a>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat:</span>
                        <span class="font-semibold text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
            <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                <i class="fas fa-comment-alt mr-2 text-purple-600"></i>Keterangan
            </h4>
            @if($transaction->keterangan)
            <p class="text-gray-700">{{ $transaction->keterangan }}</p>
            @else
            <p class="text-gray-400 italic">Tidak ada keterangan</p>
            @endif
        </div>

        <!-- Action Buttons -->
        @if(!$transaction->financialReport || $transaction->financialReport->status === 'pending')
        <div class="flex gap-4">
            <a href="{{ route('staff.transactions.edit', $transaction->id) }}" 
               class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 font-semibold">
                <i class="fas fa-edit mr-2"></i>Edit Transaksi
            </a>
            <form action="{{ route('staff.transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Yakin ingin menghapus transaksi ini?')"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    <i class="fas fa-trash mr-2"></i>Hapus Transaksi
                </button>
            </form>
        </div>
        @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <p class="text-sm text-yellow-800">
                <i class="fas fa-lock mr-2"></i>
                Transaksi ini tidak dapat diedit karena laporan sudah divalidasi.
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
