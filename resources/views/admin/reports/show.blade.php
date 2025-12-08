@extends('layouts.admin')

@section('title', 'Detail Laporan Keuangan')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Laporan #{{ $report->id }}</h3>
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ⬅️ Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-700 mb-2">Informasi Laporan</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Laporan:</span>
                        <span class="font-semibold">#{{ $report->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat oleh:</span>
                        <span class="font-semibold">{{ $report->staff->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Dibuat:</span>
                        <span class="font-semibold">{{ $report->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $report->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                </div>
            </div>

            @if($report->status !== 'pending')
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-2">Informasi Validasi</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Divalidasi oleh:</span>
                            <span class="font-semibold">{{ $report->validatedBy->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Validasi:</span>
                            <span class="font-semibold">{{ $report->validated_at ? $report->validated_at->format('d M Y H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h4 class="font-semibold text-gray-700 mb-3">Transaksi dalam Laporan</h4>
            @if($report->transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2 text-left">No</th>
                                <th class="p-2 text-left">Tanggal</th>
                                <th class="p-2 text-left">Jenis</th>
                                <th class="p-2 text-right">Jumlah</th>
                                <th class="p-2 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($report->transactions as $index => $transaction)
                                <tr>
                                    <td class="p-2">{{ $index + 1 }}</td>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y') }}</td>
                                    <td class="p-2">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $transaction->jenis === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($transaction->jenis) }}
                                        </span>
                                    </td>
                                    <td class="p-2 text-right font-semibold">Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                    <td class="p-2">{{ $transaction->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-end space-x-4 text-sm font-semibold">
                    <div class="bg-green-100 px-4 py-2 rounded">
                        Total Pemasukan: Rp {{ number_format($report->transactions->where('jenis', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}
                    </div>
                    <div class="bg-red-100 px-4 py-2 rounded">
                        Total Pengeluaran: Rp {{ number_format($report->transactions->where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada transaksi dalam laporan ini.</p>
            @endif
        </div>

        @if($report->status === 'pending')
            <div class="border-t pt-6">
                <h4 class="font-semibold text-gray-700 mb-4">Aksi Validasi</h4>
                <div class="flex gap-4">
                    <form action="{{ route('admin.reports.approve', $report) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menyetujui laporan ini?')"
                                class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold transition">
                            ✅ Setujui Laporan
                        </button>
                    </form>

                    <button type="button" 
                            onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                            class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold transition">
                        ❌ Tolak Laporan
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Tolak Laporan</h3>
        <form action="{{ route('admin.reports.reject', $report) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Alasan Penolakan (Opsional)</label>
                <textarea name="rejection_note" rows="4" 
                          class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-red-500"
                          placeholder="Berikan alasan penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    Tolak
                </button>
                <button type="button" 
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
