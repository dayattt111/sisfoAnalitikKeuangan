@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Ringkasan Keuangan</h2>

    <div class="row text-center">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Pemasukan</h5>
                <h3 class="text-success">Rp {{ number_format($total_pemasukan, 2, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Pengeluaran</h5>
                <h3 class="text-danger">Rp {{ number_format($total_pengeluaran, 2, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Saldo Akhir</h5>
                <h3 class="text-primary">Rp {{ number_format($saldo_akhir, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <canvas id="financeChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financeChart');
    const data = {
        labels: {!! json_encode($grafik->pluck('bulan')) !!},
        datasets: [
            {
                label: 'Pemasukan',
                data: {!! json_encode($grafik->pluck('total_pemasukan')) !!},
                borderColor: 'green',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode($grafik->pluck('total_pengeluaran')) !!},
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.3)',
            }
        ]
    };

    new Chart(ctx, {
        type: 'bar',
        data: data,
    });
</script>
@endsection
