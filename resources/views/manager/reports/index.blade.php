@extends('layouts.manager')

@section('title', 'Validasi Laporan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Validasi Laporan Keuangan</h1>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Laporan Pending -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-clock mr-2 text-yellow-600"></i>
            Laporan Menunggu Validasi
        </h2>
        
        @if($pendingReports->isEmpty())
        <p class="text-gray-600">Tidak ada laporan yang menunggu validasi.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingReports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->bulan }}/{{ $report->tahun }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->transactions->count() }} transaksi</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('manager.report.show', $report->id) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas fa-eye mr-1"></i> Validasi
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Riwayat Validasi -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-history mr-2 text-gray-600"></i>
            Riwayat Validasi
        </h2>
        
        @if($validatedReports->isEmpty())
        <p class="text-gray-600">Belum ada riwayat validasi.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Validasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($validatedReports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->bulan }}/{{ $report->tahun }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($report->status === 'approved')
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Disetujui
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($report->komentar_manager, 50) }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $report->validated_at ? $report->validated_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('manager.report.show', $report->id) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $validatedReports->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
