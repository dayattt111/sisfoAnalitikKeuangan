<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialReport;
use App\Models\Transaction;

class FinancialReportSeeder extends Seeder
{
    public function run(): void
    {
        $report1 = FinancialReport::create([
            'staff_id' => 3,
            'validated_by' => null,
            'status' => 'pending',
            'validated_at' => null,
        ]);

        Transaction::create([
            'financial_report_id' => $report1->id,
            'user_id' => 3,
            'jenis' => 'pemasukan',
            'jumlah' => 5000000.00,
            'keterangan' => 'Penjualan produk bulan ini',
            'tanggal' => now()->format('Y-m-d'),
        ]);

        Transaction::create([
            'financial_report_id' => $report1->id,
            'user_id' => 3,
            'jenis' => 'pengeluaran',
            'jumlah' => 1500000.00,
            'keterangan' => 'Pembelian bahan baku',
            'tanggal' => now()->format('Y-m-d'),
        ]);

        $report2 = FinancialReport::create([
            'staff_id' => 4,
            'validated_by' => 1,
            'status' => 'approved',
            'validated_at' => now(),
        ]);

        Transaction::create([
            'financial_report_id' => $report2->id,
            'user_id' => 4,
            'jenis' => 'pemasukan',
            'jumlah' => 7500000.00,
            'keterangan' => 'Pendapatan jasa konsultasi',
            'tanggal' => now()->subDays(2)->format('Y-m-d'),
        ]);

        Transaction::create([
            'financial_report_id' => $report2->id,
            'user_id' => 4,
            'jenis' => 'pengeluaran',
            'jumlah' => 2000000.00,
            'keterangan' => 'Biaya operasional',
            'tanggal' => now()->subDays(2)->format('Y-m-d'),
        ]);

        $report3 = FinancialReport::create([
            'staff_id' => 3,
            'validated_by' => 1,
            'status' => 'rejected',
            'validated_at' => now(),
        ]);

        Transaction::create([
            'financial_report_id' => $report3->id,
            'user_id' => 3,
            'jenis' => 'pemasukan',
            'jumlah' => 3000000.00,
            'keterangan' => 'Penjualan minggu lalu',
            'tanggal' => now()->subDays(5)->format('Y-m-d'),
        ]);

        Transaction::create([
            'financial_report_id' => $report3->id,
            'user_id' => 3,
            'jenis' => 'pengeluaran',
            'jumlah' => 500000.00,
            'keterangan' => 'Biaya transport',
            'tanggal' => now()->subDays(5)->format('Y-m-d'),
        ]);
    }
}
