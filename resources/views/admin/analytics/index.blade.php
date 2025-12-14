@extends('layouts.admin')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with Actions -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Financial Health Analytics</h1>
            <p class="text-gray-600 mt-1">Comprehensive financial health assessment with predictive insights</p>
        </div>
        <div class="flex gap-3">
            <form method="GET" class="flex gap-2">
                <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    @foreach($availableYears as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>{{ $availableYear }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('admin.analytics.comparison') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-chart-bar mr-2"></i>Comparison
            </a>
            <a href="{{ route('admin.analytics.export', ['year' => $year]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-download mr-2"></i>Export
            </a>
        </div>
    </div>

    <!-- Overall Health Status Card -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Overall Health Status</h2>
                <p class="text-gray-600 mt-1">Year {{ $year }}</p>
            </div>
            <div class="text-right">
                @if($healthMetrics['status']['overall'] == 'Sehat')
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-3xl mr-3"></i>
                        <span class="text-2xl font-bold text-green-600">SEHAT</span>
                    </div>
                @elseif($healthMetrics['status']['overall'] == 'Cukup')
                    <div class="inline-flex items-center px-6 py-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-yellow-600 text-3xl mr-3"></i>
                        <span class="text-2xl font-bold text-yellow-600">CUKUP</span>
                    </div>
                @else
                    <div class="inline-flex items-center px-6 py-3 bg-red-100 rounded-lg">
                        <i class="fas fa-times-circle text-red-600 text-3xl mr-3"></i>
                        <span class="text-2xl font-bold text-red-600">KURANG</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- 4 KPI Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Profit Margin -->
            <div class="border-l-4 rounded-lg p-5 {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-percentage text-3xl {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'text-green-600' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}"></i>
                    @if($yoyComparison)
                        <span class="text-xs {{ $yoyComparison['profit_margin_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-arrow-{{ $yoyComparison['profit_margin_change'] >= 0 ? 'up' : 'down' }}"></i>
                            {{ number_format(abs($yoyComparison['profit_margin_change']), 2) }}%
                        </span>
                    @endif
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Profit Margin</p>
                <p class="text-4xl font-bold {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'text-green-600' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['profit_margin'] }}%
                </p>
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Target: > 30%</p>
                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $healthMetrics['status']['details']['profit_margin'] == 'Sehat' ? 'bg-green-200 text-green-700' : ($healthMetrics['status']['details']['profit_margin'] == 'Cukup' ? 'bg-yellow-200 text-yellow-700' : 'bg-red-200 text-red-700') }}">
                        {{ $healthMetrics['status']['details']['profit_margin'] }}
                    </span>
                </div>
            </div>

            <!-- Operating Efficiency -->
            <div class="border-l-4 rounded-lg p-5 {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-cogs text-3xl {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}"></i>
                    @if($yoyComparison)
                        <span class="text-xs {{ $yoyComparison['efficiency_change'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-arrow-{{ $yoyComparison['efficiency_change'] <= 0 ? 'down' : 'up' }}"></i>
                            {{ number_format(abs($yoyComparison['efficiency_change']), 2) }}%
                        </span>
                    @endif
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Operating Efficiency</p>
                <p class="text-4xl font-bold {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['operating_efficiency'] }}%
                </p>
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Target: < 70%</p>
                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $healthMetrics['status']['details']['efficiency'] == 'Baik' ? 'bg-green-200 text-green-700' : ($healthMetrics['status']['details']['efficiency'] == 'Cukup' ? 'bg-yellow-200 text-yellow-700' : 'bg-red-200 text-red-700') }}">
                        {{ $healthMetrics['status']['details']['efficiency'] }}
                    </span>
                </div>
            </div>

            <!-- Liquidity Ratio -->
            <div class="border-l-4 rounded-lg p-5 {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-water text-3xl {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'text-green-600' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'text-yellow-600' : 'text-red-600') }}"></i>
                    @if($yoyComparison)
                        <span class="text-xs {{ $yoyComparison['liquidity_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-arrow-{{ $yoyComparison['liquidity_change'] >= 0 ? 'up' : 'down' }}"></i>
                            {{ number_format(abs($yoyComparison['liquidity_change']), 2) }}x
                        </span>
                    @endif
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Liquidity Ratio</p>
                <p class="text-4xl font-bold {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'text-green-600' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['liquidity_ratio'] }}x
                </p>
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Target: > 1.3x</p>
                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $healthMetrics['status']['details']['liquidity'] == 'Likuid' ? 'bg-green-200 text-green-700' : ($healthMetrics['status']['details']['liquidity'] == 'Normal' ? 'bg-yellow-200 text-yellow-700' : 'bg-red-200 text-red-700') }}">
                        {{ $healthMetrics['status']['details']['liquidity'] }}
                    </span>
                </div>
            </div>

            <!-- Growth Rate -->
            <div class="border-l-4 rounded-lg p-5 {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'border-green-500 bg-green-50' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-chart-line text-3xl {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'text-yellow-600' : 'text-red-600') }}"></i>
                    @if($yoyComparison)
                        <span class="text-xs {{ $yoyComparison['growth_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-arrow-{{ $yoyComparison['growth_change'] >= 0 ? 'up' : 'down' }}"></i>
                            {{ number_format(abs($yoyComparison['growth_change']), 2) }}%
                        </span>
                    @endif
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Growth Rate</p>
                <p class="text-4xl font-bold {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'text-green-600' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $healthMetrics['current']['growth_rate'] }}%
                </p>
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Target: > 10%</p>
                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $healthMetrics['status']['details']['growth'] == 'Tumbuh Baik' ? 'bg-green-200 text-green-700' : ($healthMetrics['status']['details']['growth'] == 'Stabil' ? 'bg-yellow-200 text-yellow-700' : 'bg-red-200 text-red-700') }}">
                        {{ $healthMetrics['status']['details']['growth'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary & Forecast -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Financial Summary -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Financial Summary</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-arrow-up text-blue-600 text-2xl"></i>
                        <div>
                            <p class="text-sm text-gray-600">Total Pemasukan</p>
                            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($healthMetrics['current']['total_pemasukan'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-arrow-down text-red-600 text-2xl"></i>
                        <div>
                            <p class="text-sm text-gray-600">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($healthMetrics['current']['total_pengeluaran'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-wallet text-green-600 text-2xl"></i>
                        <div>
                            <p class="text-sm text-gray-600">Total Saldo</p>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($healthMetrics['current']['total_saldo'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forecast -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Predictive Forecast</h3>
            <div class="space-y-4">
                <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-crystal-ball text-blue-600 text-xl"></i>
                        <p class="text-sm font-medium text-gray-700">Proyeksi Pemasukan Bulan Depan</p>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($forecast['pemasukan'], 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">Berdasarkan tren 12 bulan dengan linear regression</p>
                </div>
                <div class="p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg border border-red-200">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-crystal-ball text-red-600 text-xl"></i>
                        <p class="text-sm font-medium text-gray-700">Proyeksi Pengeluaran Bulan Depan</p>
                    </div>
                    <p class="text-3xl font-bold text-red-600">Rp {{ number_format($forecast['pengeluaran'], 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">Berdasarkan tren 12 bulan dengan linear regression</p>
                </div>
                @php
                    $projectedProfit = $forecast['pemasukan'] - $forecast['pengeluaran'];
                    $projectedMargin = $forecast['pemasukan'] > 0 ? ($projectedProfit / $forecast['pemasukan']) * 100 : 0;
                @endphp
                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                        <p class="text-sm font-medium text-gray-700">Proyeksi Profit Margin</p>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($projectedMargin, 2) }}%</p>
                    <p class="text-xs text-gray-500 mt-2">Estimasi profit dari proyeksi pemasukan & pengeluaran</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">AI-Generated Insights & Recommendations</h3>
        <div class="space-y-4">
            @foreach($healthMetrics['recommendations'] as $rec)
                @php
                    $bgColor = match($rec['type']) {
                        'success' => 'bg-green-50 border-l-4 border-green-500',
                        'warning' => 'bg-yellow-50 border-l-4 border-yellow-500',
                        'danger' => 'bg-red-50 border-l-4 border-red-500',
                        default => 'bg-blue-50 border-l-4 border-blue-500',
                    };
                    $iconColor = match($rec['type']) {
                        'success' => 'text-green-600',
                        'warning' => 'text-yellow-600',
                        'danger' => 'text-red-600',
                        default => 'text-blue-600',
                    };
                    $textColor = match($rec['type']) {
                        'success' => 'text-green-700',
                        'warning' => 'text-yellow-700',
                        'danger' => 'text-red-700',
                        default => 'text-blue-700',
                    };
                @endphp
                <div class="{{ $bgColor }} rounded-lg p-5">
                    <div class="flex items-start gap-4">
                        <i class="fas {{ $rec['icon'] }} {{ $iconColor }} text-2xl mt-1"></i>
                        <div class="flex-1">
                            <h4 class="font-bold {{ $textColor }} text-lg mb-2">{{ $rec['title'] }}</h4>
                            <p class="text-gray-700 mb-3">{{ $rec['message'] }}</p>
                            <div class="flex items-start gap-2 p-3 bg-white rounded-md">
                                <i class="fas fa-lightbulb text-yellow-500 mt-1"></i>
                                <p class="text-sm font-semibold text-gray-800">{{ $rec['action'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
