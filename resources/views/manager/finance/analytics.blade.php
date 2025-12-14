@extends('layouts.manager')

@section('title', 'Analitik Kesehatan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Tahun Filter -->
    <div class="mb-6 flex items-center gap-4">
        <label for="year" class="text-gray-700 font-semibold">Pilih Tahun:</label>
        <form method="GET" class="flex gap-2">
            <select name="year" id="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                @forelse(\App\Models\Transaction::selectRaw('YEAR(tanggal) as year')->distinct()->orderByDesc('year')->pluck('year') as $availableYear)
                    <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>{{ $availableYear }}</option>
                @empty
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                @endforelse
            </select>
        </form>
    </div>

    <!-- Health Score Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Status Kesehatan Keuangan</h2>
        
        <!-- Overall Health Status -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="text-4xl font-bold">
                    @if($healthMetrics['status']['overall'] == 'Sehat')
                        <span class="text-green-600">✓ SEHAT</span>
                    @elseif($healthMetrics['status']['overall'] == 'Cukup')
                        <span class="text-yellow-600">⚠ CUKUP</span>
                    @else
                        <span class="text-red-600">✗ KURANG</span>
                    @endif
                </div>
            </div>
            <p class="text-gray-600">Status kesehatan finansial keseluruhan berdasarkan analisis 4 metrik utama</p>
        </div>

        <!-- 4 KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Profit Margin Card -->
            <div class="border-l-4 rounded-lg p-4 {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <p class="text-sm font-medium text-gray-600 mb-1">Profit Margin</p>
                <p class="text-3xl font-bold {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'text-green-600' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['profit_margin'] }}%
                </p>
                <p class="text-xs text-gray-500 mt-1">Target: > 30%</p>
                <p class="text-xs font-semibold mt-2 {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'text-green-600' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['status']['details']['profit_margin'] }}
                </p>
            </div>

            <!-- Operating Efficiency Card -->
            <div class="border-l-4 rounded-lg p-4 {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <p class="text-sm font-medium text-gray-600 mb-1">Efisiensi Operasional</p>
                <p class="text-3xl font-bold {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['operating_efficiency'] }}%
                </p>
                <p class="text-xs text-gray-500 mt-1">Target: < 70%</p>
                <p class="text-xs font-semibold mt-2 {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['status']['details']['efficiency'] }}
                </p>
            </div>

            <!-- Liquidity Ratio Card -->
            <div class="border-l-4 rounded-lg p-4 {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <p class="text-sm font-medium text-gray-600 mb-1">Liquidity Ratio</p>
                <p class="text-3xl font-bold {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'text-green-600' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['liquidity_ratio'] }}x
                </p>
                <p class="text-xs text-gray-500 mt-1">Target: > 1.3x</p>
                <p class="text-xs font-semibold mt-2 {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'text-green-600' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['status']['details']['liquidity'] }}
                </p>
            </div>

            <!-- Growth Rate Card -->
            <div class="border-l-4 rounded-lg p-4 {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <p class="text-sm font-medium text-gray-600 mb-1">Growth Rate</p>
                <p class="text-3xl font-bold {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['growth_rate'] }}%
                </p>
                <p class="text-xs text-gray-500 mt-1">Target: > 10%</p>
                <p class="text-xs font-semibold mt-2 {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['status']['details']['growth'] }}
                </p>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-sm text-gray-600">Total Pemasukan</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($healthMetrics['current']['total_pemasukan'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <p class="text-sm text-gray-600">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($healthMetrics['current']['total_pengeluaran'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <p class="text-sm text-gray-600">Total Saldo</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($healthMetrics['current']['total_saldo'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Recommendations Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Rekomendasi & Insight</h2>
        
        <div class="space-y-4">
            @foreach($healthMetrics['recommendations'] as $rec)
                @php
                    $bgColor = match($rec['type']) {
                        'success' => 'bg-green-50 border-l-4 border-green-500',
                        'warning' => 'bg-yellow-50 border-l-4 border-yellow-500',
                        'danger' => 'bg-red-50 border-l-4 border-red-500',
                        default => 'bg-blue-50 border-l-4 border-blue-500',
                    };
                    $textColor = match($rec['type']) {
                        'success' => 'text-green-600',
                        'warning' => 'text-yellow-600',
                        'danger' => 'text-red-600',
                        default => 'text-blue-600',
                    };
                    $iconColor = match($rec['type']) {
                        'success' => 'text-green-500',
                        'warning' => 'text-yellow-500',
                        'danger' => 'text-red-500',
                        default => 'text-blue-500',
                    };
                @endphp
                <div class="{{ $bgColor }} rounded-lg p-4">
                    <div class="flex items-start gap-4">
                        <i class="fas {{ $rec['icon'] }} {{ $iconColor }} text-xl mt-1"></i>
                        <div class="flex-1">
                            <h3 class="font-bold {{ $textColor }} mb-1">{{ $rec['title'] }}</h3>
                            <p class="text-gray-700 text-sm mb-2">{{ $rec['message'] }}</p>
                            <p class="text-sm font-semibold text-gray-800">→ {{ $rec['action'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Forecast Section -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Forecast 3 Bulan Ke Depan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pemasukan Forecast -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Proyeksi Pemasukan</h3>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-3">
                    <p class="text-sm text-gray-600">Estimasi Bulan Depan</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($forecast['pemasukan'], 0, ',', '.') }}</p>
                </div>
                <p class="text-xs text-gray-500">Berdasarkan tren 12 bulan terakhir dengan simple linear regression</p>
            </div>

            <!-- Pengeluaran Forecast -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Proyeksi Pengeluaran</h3>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-3">
                    <p class="text-sm text-gray-600">Estimasi Bulan Depan</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($forecast['pengeluaran'], 0, ',', '.') }}</p>
                </div>
                <p class="text-xs text-gray-500">Berdasarkan tren 12 bulan terakhir dengan simple linear regression</p>
            </div>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600 mb-2"><strong>Catatan:</strong> Proyeksi ini didasarkan pada tren historis 12 bulan terakhir. Nilai aktual dapat berbeda jika ada perubahan signifikan dalam bisnis atau pasar.</p>
        </div>
    </div>

</div>
@endsection
