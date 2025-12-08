@extends('layouts.admin')

@section('title', 'Monitoring Laporan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Monitoring Laporan Keuangan</h1>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Laporan yang Sudah Divalidasi Manager (Perlu Review Admin) -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>
            Laporan Tervalidasi Manager - Perlu Review Admin
        </h2>
        
        @if($managerValidated->isEmpty())
        <p class="text-gray-600">Tidak ada laporan yang menunggu review admin.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Validasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($managerValidated as $report)
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
                            <a href="{{ route('admin.reports.show', $report->id) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas fa-eye mr-1"></i> Review
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Semua Laporan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-list mr-2 text-gray-600"></i>
            Semua Laporan
        </h2>
        
        @if($allReports->isEmpty())
        <p class="text-gray-600">Belum ada laporan.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar Manager</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($allReports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->bulan }}/{{ $report->tahun }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($report->status === 'pending')
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                            @elseif($report->status === 'approved')
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
                            @if($report->komentar_manager)
                            <span class="text-xs text-green-600"><i class="fas fa-comment mr-1"></i>Ada</span>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($report->komentar_admin)
                            <span class="text-xs text-blue-600"><i class="fas fa-comment mr-1"></i>Ada</span>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('admin.reports.show', $report->id) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                            @if($report->status === 'pending')
                            <button onclick="openValidateModal({{ $report->id }}, '{{ $report->user->name }}', '{{ $report->bulan }}/{{ $report->tahun }}')"
                                    class="text-green-600 hover:text-green-900">
                                <i class="fas fa-check-circle mr-1"></i>Validasi
                            </button>
                            @endif
                            <button onclick="confirmDelete({{ $report->id }}, '{{ $report->user->name }}', '{{ $report->bulan }}/{{ $report->tahun }}')"
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $allReports->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Validasi -->
<div id="validateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Validasi Laporan</h3>
            <p class="text-sm text-gray-600 mb-4">
                Staff: <span id="validateStaffName" class="font-semibold"></span><br>
                Periode: <span id="validatePeriode" class="font-semibold"></span>
            </p>
            
            <form id="validateForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Validasi</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="approved">✓ Setujui</option>
                        <option value="rejected">✗ Tolak</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar Admin</label>
                    <textarea name="komentar_admin" rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Masukkan komentar atau catatan validasi..."
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeValidateModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Validasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 text-center mb-4">Hapus Laporan?</h3>
            <p class="text-sm text-gray-600 text-center mb-2">
                Staff: <span id="deleteStaffName" class="font-semibold"></span><br>
                Periode: <span id="deletePeriode" class="font-semibold"></span>
            </p>
            <p class="text-sm text-red-600 text-center mb-4">
                <i class="fas fa-exclamation-triangle mr-1"></i> Semua transaksi terkait juga akan dihapus!
            </p>
            
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openValidateModal(reportId, staffName, periode) {
    document.getElementById('validateStaffName').textContent = staffName;
    document.getElementById('validatePeriode').textContent = periode;
    document.getElementById('validateForm').action = `/admin/reports/${reportId}/validate`;
    document.getElementById('validateModal').classList.remove('hidden');
}

function closeValidateModal() {
    document.getElementById('validateModal').classList.add('hidden');
}

function confirmDelete(reportId, staffName, periode) {
    document.getElementById('deleteStaffName').textContent = staffName;
    document.getElementById('deletePeriode').textContent = periode;
    document.getElementById('deleteForm').action = `/admin/reports/${reportId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const validateModal = document.getElementById('validateModal');
    const deleteModal = document.getElementById('deleteModal');
    if (event.target == validateModal) {
        closeValidateModal();
    }
    if (event.target == deleteModal) {
        closeDeleteModal();
    }
}
</script>
@endsection
