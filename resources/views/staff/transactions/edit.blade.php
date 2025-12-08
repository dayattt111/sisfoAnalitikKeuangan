@extends('layouts.staff')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Edit Transaksi #{{ $transaction->id }}</h3>
            <a href="{{ route('staff.transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ⬅️ Kembali
            </a>
        </div>

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('staff.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Laporan Keuangan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Laporan Keuangan <span class="text-red-500">*</span>
                </label>
                <select name="financial_report_id" required
                        class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Laporan --</option>
                    @foreach($pendingReports as $report)
                    <option value="{{ $report->id }}" 
                            {{ old('financial_report_id', $transaction->financial_report_id) == $report->id ? 'selected' : '' }}>
                        Laporan {{ $report->bulan }}/{{ $report->tahun }}
                    </option>
                    @endforeach
                </select>
                @error('financial_report_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" required value="{{ old('tanggal', $transaction->tanggal) }}"
                           class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500">
                    @error('tanggal')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Transaksi <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis" required
                            class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="pemasukan" {{ old('jenis', $transaction->jenis) === 'pemasukan' ? 'selected' : '' }}>
                            Pemasukan
                        </option>
                        <option value="pengeluaran" {{ old('jenis', $transaction->jenis) === 'pengeluaran' ? 'selected' : '' }}>
                            Pengeluaran
                        </option>
                    </select>
                    @error('jenis')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Jumlah -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah" required min="0" step="1" value="{{ old('jumlah', $transaction->jumlah) }}"
                       class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: 500000">
                @error('jumlah')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan
                </label>
                <textarea name="keterangan" rows="4"
                          class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500"
                          placeholder="Deskripsi transaksi (opsional)">{{ old('keterangan', $transaction->keterangan) }}</textarea>
                @error('keterangan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('staff.transactions.index') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
