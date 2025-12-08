@extends('layouts.staff')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
            <p class="text-gray-600 mt-2">Lihat dan kelola transaksi Anda</p>
        </div>
        <a href="{{ route('staff.transactions.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                <select name="jenis" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Semua</option>
                    <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-green-100 p-6 rounded-lg">
            <p class="text-green-700 text-sm font-medium">Total Pemasukan</p>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-100 p-6 rounded-lg">
            <p class="text-red-700 text-sm font-medium">Total Pengeluaran</p>
            <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="bg-blue-100 p-6 rounded-lg">
            <p class="text-blue-700 text-sm font-medium">Saldo</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $index => $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $transactions->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                @if($transaction->jenis == 'pemasukan')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-arrow-up mr-1"></i>Pemasukan
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-arrow-down mr-1"></i>Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold {{ $transaction->jenis == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">{{ Str::limit($transaction->keterangan ?? '-', 50) }}</td>
                            <td class="px-6 py-4 text-center text-sm space-x-2">
                                <a href="{{ route('staff.transactions.show', $transaction->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.transactions.edit', $transaction->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff.transactions.destroy', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus transaksi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
