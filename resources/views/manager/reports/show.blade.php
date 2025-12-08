@extends('layouts.manager')

@section('title', 'Detail Laporan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Laporan #{{ $report->id }}</h3>
            <a href="{{ route('manager.report.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
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
                        <span class="text-gray-600">Staff:</span>
                        <span class="font-semibold">{{ $report->user->name }}</span>
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
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-calculator mr-2 text-green-600"></i>Ringkasan Keuangan
                </h4>
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
                        <span class="font-bold {{ ($totalPemasukan - $totalPengeluaran) >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-2">
                        <span class="text-gray-600">Jumlah Transaksi:</span>
                        <span class="font-semibold">{{ $report->transactions->count() }} transaksi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluasi Manager (jika sudah ada) -->
        @if($report->komentar_manager)
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
            <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                <i class="fas fa-user-tie mr-2"></i>Evaluasi Manager
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
            <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                <i class="fas fa-list mr-2 text-purple-600"></i>Detail Transaksi
            </h4>
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
                <p class="text-gray-500 text-center py-4">Tidak ada transaksi dalam laporan ini.</p>
            @endif
        </div>

        <!-- Form Validasi (jika status pending) -->
        @if($report->status === 'pending')
        <div class="border-t-2 border-gray-200 pt-6">
            <h4 class="font-semibold text-gray-800 mb-4 text-lg">
                <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>Validasi Laporan
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Form Setuju -->
                <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4">
                    <h5 class="font-semibold text-green-800 mb-3">
                        <i class="fas fa-check-circle mr-2"></i>Setujui Laporan
                    </h5>
                    <form action="{{ route('manager.report.approve', $report->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Evaluasi & Komentar <span class="text-red-500">*</span>
                            </label>
                            <textarea name="komentar_manager" rows="4" required
                                      class="w-full border-gray-300 rounded-lg px-3 py-2 border focus:ring-2 focus:ring-green-500 text-sm"
                                      placeholder="Berikan evaluasi positif dan saran untuk peningkatan..."></textarea>
                            @error('komentar_manager')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menyetujui laporan ini?')"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">
                            <i class="fas fa-check mr-2"></i>Setujui Laporan
                        </button>
                    </form>
                </div>

                <!-- Form Tolak -->
                <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4">
                    <h5 class="font-semibold text-red-800 mb-3">
                        <i class="fas fa-times-circle mr-2"></i>Tolak Laporan
                    </h5>
                    <form action="{{ route('manager.report.reject', $report->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Penolakan & Saran Perbaikan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="komentar_manager" rows="4" required
                                      class="w-full border-gray-300 rounded-lg px-3 py-2 border focus:ring-2 focus:ring-red-500 text-sm"
                                      placeholder="Jelaskan alasan penolakan dan berikan saran perbaikan yang jelas..."></textarea>
                            @error('komentar_manager')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menolak laporan ini?')"
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-semibold">
                            <i class="fas fa-times mr-2"></i>Tolak Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
