@extends('layouts.admin')

@section('title', 'Year-over-Year Comparison')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.analytics.index') }}" class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Year-over-Year Comparison</h1>
        </div>
        <p class="text-gray-600">Compare financial health metrics across multiple years</p>
    </div>

    <!-- Year Range Selector -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Year</label>
                <select name="start_year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $startYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">End Year</label>
                <select name="end_year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $endYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-sync mr-2"></i>Compare
            </button>
        </form>
    </div>

    <!-- Comparison Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                        @foreach($comparisons as $year => $data)
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $year }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Overall Status -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Overall Status</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $data['status']['overall'] == 'Sehat' ? 'bg-green-100 text-green-700' : ($data['status']['overall'] == 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $data['status']['overall'] }}
                                </span>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Profit Margin -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Profit Margin</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-bold {{ $data['current']['profit_margin'] >= 30 ? 'text-green-600' : ($data['current']['profit_margin'] >= 15 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $data['current']['profit_margin'] }}%
                                </span>
                                <p class="text-xs text-gray-500">{{ $data['status']['details']['profit_margin'] }}</p>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Operating Efficiency -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Operating Efficiency</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-bold {{ $data['current']['operating_efficiency'] <= 70 ? 'text-green-600' : ($data['current']['operating_efficiency'] <= 85 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $data['current']['operating_efficiency'] }}%
                                </span>
                                <p class="text-xs text-gray-500">{{ $data['status']['details']['efficiency'] }}</p>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Liquidity Ratio -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Liquidity Ratio</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-bold {{ $data['current']['liquidity_ratio'] >= 1.3 ? 'text-green-600' : ($data['current']['liquidity_ratio'] >= 1.0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $data['current']['liquidity_ratio'] }}x
                                </span>
                                <p class="text-xs text-gray-500">{{ $data['status']['details']['liquidity'] }}</p>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Growth Rate -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Growth Rate</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-bold {{ $data['current']['growth_rate'] >= 10 ? 'text-green-600' : ($data['current']['growth_rate'] >= 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $data['current']['growth_rate'] }}%
                                </span>
                                <p class="text-xs text-gray-500">{{ $data['status']['details']['growth'] }}</p>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Total Pemasukan -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Total Pemasukan</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-semibold text-blue-600">
                                    Rp {{ number_format($data['current']['total_pemasukan'], 0, ',', '.') }}
                                </span>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Total Pengeluaran -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Total Pengeluaran</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-semibold text-red-600">
                                    Rp {{ number_format($data['current']['total_pengeluaran'], 0, ',', '.') }}
                                </span>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Total Saldo -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Total Saldo</td>
                        @foreach($comparisons as $year => $data)
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-semibold {{ $data['current']['total_saldo'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($data['current']['total_saldo'], 0, ',', '.') }}
                                </span>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Insights -->
    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
            <div>
                <h3 class="font-bold text-blue-900 mb-2">Analysis Insight</h3>
                <p class="text-blue-800 text-sm">
                    Tabel di atas menunjukkan perbandingan metrik kesehatan keuangan dari tahun {{ $startYear }} hingga {{ $endYear }}.
                    Gunakan data ini untuk mengidentifikasi tren jangka panjang dan membuat keputusan strategis.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
