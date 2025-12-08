@extends('layouts.admin')

@section('title', 'Kelola Tahun Laporan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Tahun Laporan</h1>
            <p class="text-gray-600 mt-2">Kelola tahun yang tersedia untuk pembuatan laporan keuangan</p>
        </div>
        <button onclick="document.getElementById('addYearModal').classList.remove('hidden')" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transition duration-200">
            <i class="fas fa-plus-circle"></i>
            Tambah Tahun Baru
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Fiscal Years Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fiscalYears as $year)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-bold text-gray-900">{{ $year->year }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($year->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-ban mr-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $year->description ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $year->creator->name }}</div>
                            <div class="text-xs text-gray-500">{{ $year->creator->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $year->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Toggle Status -->
                                <form action="{{ route('admin.fiscal-years.toggle', $year->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-{{ $year->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $year->is_active ? 'yellow' : 'green' }}-900"
                                            title="{{ $year->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $year->is_active ? 'toggle-on' : 'toggle-off' }} text-xl"></i>
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.fiscal-years.destroy', $year->id) }}" method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus tahun {{ $year->year }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada tahun laporan yang ditambahkan</p>
                            <p class="text-gray-400 text-sm mt-2">Klik tombol "Tambah Tahun Baru" untuk menambahkan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($fiscalYears->hasPages())
            <div class="bg-gray-50 px-6 py-4">
                {{ $fiscalYears->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add Year Modal -->
<div id="addYearModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-bold text-gray-800">Tambah Tahun Laporan Baru</h3>
            <button onclick="document.getElementById('addYearModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.fiscal-years.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="year" 
                       name="year" 
                       min="2020" 
                       max="2100"
                       value="{{ old('year', date('Y') + 1) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          maxlength="500"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Contoh: Tahun fiscal untuk periode 2026">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button"
                        onclick="document.getElementById('addYearModal').classList.add('hidden')"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
            </div>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addYearModal').classList.remove('hidden');
    });
</script>
@endif
@endsection
