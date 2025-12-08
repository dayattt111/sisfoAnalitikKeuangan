@extends('layouts.manager')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('manager.transaction.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Laporan Transaksi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Detail Transaksi #{{ $transaction->id }}</h1>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">ID Transaksi</label>
                        <p class="text-lg font-semibold text-gray-900">#{{ $transaction->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-calendar text-blue-600 mr-2"></i>
                            {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Staff</label>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            {{ $transaction->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Transaksi</label>
                        @if($transaction->jenis == 'pemasukan')
                            <span class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 text-green-800 font-semibold">
                                <i class="fas fa-arrow-up mr-2"></i> Pemasukan
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-lg bg-red-100 text-red-800 font-semibold">
                                <i class="fas fa-arrow-down mr-2"></i> Pengeluaran
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jumlah</label>
                        <p class="text-3xl font-bold text-gray-900">
                            Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                        </p>
                    </div>

                    @if($transaction->financialReport)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Laporan Keuangan</label>
                            <p class="text-lg text-gray-900">
                                <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                                {{ $transaction->financialReport->judul ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Status: 
                                @if($transaction->financialReport->status == 'pending')
                                    <span class="text-yellow-600 font-medium">Pending</span>
                                @elseif($transaction->financialReport->status == 'approved')
                                    <span class="text-green-600 font-medium">Disetujui</span>
                                @else
                                    <span class="text-red-600 font-medium">Ditolak</span>
                                @endif
                            </p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Pada</label>
                        <p class="text-sm text-gray-900">
                            {{ $transaction->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diupdate</label>
                        <p class="text-sm text-gray-900">
                            {{ $transaction->updated_at->format('d F Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-500 mb-2">Keterangan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900">{{ $transaction->keterangan ?? 'Tidak ada keterangan' }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-6 border-t border-gray-200 flex gap-3">
                <a href="{{ route('manager.transaction.index') }}" 
                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
