@extends('layouts.staff')

@section('title', 'Edit Laporan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Edit Laporan Keuangan #{{ $report->id }}</h3>
            <a href="{{ route('staff.reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
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

        <form action="{{ route('staff.reports.update', $report->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Bulan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bulan <span class="text-red-500">*</span>
                    </label>
                    <select name="bulan" required
                            class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Bulan --</option>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('bulan', $report->bulan) == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                        @endfor
                    </select>
                    @error('bulan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun" required
                            class="w-full border-gray-300 rounded-lg px-4 py-2 border focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Tahun --</option>
                        @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                        <option value="{{ $year }}" {{ old('tahun', $report->tahun) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endfor
                    </select>
                    @error('tahun')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mb-6">
                <h4 class="font-semibold text-yellow-800 mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Perhatian
                </h4>
                <p class="text-sm text-gray-700">
                    Hanya laporan dengan status "Pending" yang dapat diedit.
                    Pastikan periode yang dipilih tidak bentrok dengan laporan lain Anda.
                </p>
            </div>

            <div class="flex gap-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('staff.reports.index') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
