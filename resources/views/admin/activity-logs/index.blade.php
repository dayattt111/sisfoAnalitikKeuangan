@extends('layouts.admin')

@section('title', 'Monitoring Aktivitas')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Log Aktivitas Sistem</h3>

        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                    <select name="user_id" class="w-full border-gray-300 rounded-lg px-3 py-2 border">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full border-gray-300 rounded-lg px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full border-gray-300 rounded-lg px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Aktivitas</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Kata kunci..."
                           class="w-full border-gray-300 rounded-lg px-3 py-2 border">
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    🔄 Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto">
            @if($logs->count() > 0)
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                        <tr>
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Waktu</th>
                            <th class="p-3 text-left">User</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($logs as $index => $log)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="p-3 text-gray-600">{{ ($logs->currentPage() - 1) * $logs->perPage() + $index + 1 }}</td>
                                <td class="p-3 text-sm whitespace-nowrap">
                                    <div>{{ $log->created_at->format('d M Y') }}</div>
                                    <div class="text-gray-500 text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="p-3 font-semibold">{{ $log->user->name ?? 'System' }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ optional($log->user)->role === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ optional($log->user)->role === 'manager' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ optional($log->user)->role === 'staff' ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ optional($log->user)->role ? ucfirst($log->user->role) : '-' }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $log->activity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">Tidak ada log aktivitas yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
