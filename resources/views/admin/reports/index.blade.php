@extends('layouts.admin')

@section('title', 'Validasi Laporan Keuangan')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Laporan Menunggu Validasi</h3>
        
        @if($pendingReports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-yellow-100 text-yellow-900">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Staff</th>
                            <th class="p-3 text-left">Dibuat</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendingReports as $report)
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="p-3 font-semibold">#{{ $report->id }}</td>
                                <td class="p-3">{{ $report->staff->name ?? '-' }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $report->created_at->format('d M Y H:i') }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                </td>
                                <td class="p-3 text-center space-x-2">
                                    <a href="{{ route('admin.reports.show', $report) }}" 
                                       class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Tidak ada laporan yang menunggu validasi.</p>
            </div>
        @endif
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Riwayat Validasi (20 Terakhir)</h3>
        
        @if($validatedReports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-900">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Staff</th>
                            <th class="p-3 text-left">Validator</th>
                            <th class="p-3 text-left">Waktu Validasi</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($validatedReports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-semibold">#{{ $report->id }}</td>
                                <td class="p-3">{{ $report->staff->name ?? '-' }}</td>
                                <td class="p-3">{{ $report->validatedBy->name ?? '-' }}</td>
                                <td class="p-3 text-sm text-gray-600">
                                    {{ $report->validated_at ? $report->validated_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $report->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $report->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('admin.reports.show', $report) }}" 
                                       class="inline-block bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-sm">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Belum ada riwayat validasi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
