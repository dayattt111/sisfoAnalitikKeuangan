<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialReport;
use App\Models\Transaction;
use App\Models\User;

class FinancialReportSeeder extends Seeder
{
    public function run(): void
    {
        // Get staff users
        $staff1 = User::where('email', 'staff@analitik.com')->first();
        $staff2 = User::where('email', 'staff2@analitik.com')->first();
        $manager = User::where('role', 'manager')->first();

        // Data for each month (Januari - Desember)
        $monthsData = [
            1 => ['name' => 'Januari', 'pemasukan' => [15000000, 12000000, 8000000], 'pengeluaran' => [5000000, 3000000, 2000000]],
            2 => ['name' => 'Februari', 'pemasukan' => [18000000, 14000000, 9000000], 'pengeluaran' => [6000000, 3500000, 2500000]],
            3 => ['name' => 'Maret', 'pemasukan' => [20000000, 15000000, 10000000], 'pengeluaran' => [7000000, 4000000, 3000000]],
            4 => ['name' => 'April', 'pemasukan' => [17000000, 13000000, 8500000], 'pengeluaran' => [5500000, 3200000, 2300000]],
            5 => ['name' => 'Mei', 'pemasukan' => [22000000, 16000000, 11000000], 'pengeluaran' => [8000000, 4500000, 3500000]],
            6 => ['name' => 'Juni', 'pemasukan' => [19000000, 14500000, 9500000], 'pengeluaran' => [6500000, 3800000, 2800000]],
            7 => ['name' => 'Juli', 'pemasukan' => [21000000, 15500000, 10500000], 'pengeluaran' => [7500000, 4200000, 3200000]],
            8 => ['name' => 'Agustus', 'pemasukan' => [23000000, 17000000, 12000000], 'pengeluaran' => [8500000, 4800000, 3800000]],
            9 => ['name' => 'September', 'pemasukan' => [20000000, 15000000, 10000000], 'pengeluaran' => [7000000, 4000000, 3000000]],
            10 => ['name' => 'Oktober', 'pemasukan' => [24000000, 18000000, 13000000], 'pengeluaran' => [9000000, 5000000, 4000000]],
            11 => ['name' => 'November', 'pemasukan' => [22000000, 16500000, 11500000], 'pengeluaran' => [8000000, 4600000, 3600000]],
            12 => ['name' => 'Desember', 'pemasukan' => [25000000, 19000000, 14000000], 'pengeluaran' => [9500000, 5500000, 4500000]],
        ];

        foreach ($monthsData as $month => $data) {
            // Report from Staff 1 (Approved by Manager)
            $report1 = FinancialReport::create([
                'user_id' => $staff1->id,
                'bulan' => $month,
                'tahun' => 2025,
                'status' => 'approved',
                'validated_by' => $manager->id,
                'validated_at' => now()->subDays(rand(1, 15)),
                'komentar_manager' => 'Laporan bulan ' . $data['name'] . ' sudah sesuai. Pemasukan meningkat dibanding bulan sebelumnya. Pertahankan kinerja yang baik.',
            ]);

            // Add transactions for report 1
            Transaction::create([
                'financial_report_id' => $report1->id,
                'tanggal' => now()->setMonth($month)->setDay(5),
                'keterangan' => 'Penjualan Produk A',
                'jenis' => 'pemasukan',
                'jumlah' => $data['pemasukan'][0],
            ]);

            Transaction::create([
                'financial_report_id' => $report1->id,
                'tanggal' => now()->setMonth($month)->setDay(15),
                'keterangan' => 'Penjualan Produk B',
                'jenis' => 'pemasukan',
                'jumlah' => $data['pemasukan'][1],
            ]);

            Transaction::create([
                'financial_report_id' => $report1->id,
                'tanggal' => now()->setMonth($month)->setDay(10),
                'keterangan' => 'Biaya Operasional',
                'jenis' => 'pengeluaran',
                'jumlah' => $data['pengeluaran'][0],
            ]);

            Transaction::create([
                'financial_report_id' => $report1->id,
                'tanggal' => now()->setMonth($month)->setDay(20),
                'keterangan' => 'Gaji Karyawan',
                'jenis' => 'pengeluaran',
                'jumlah' => $data['pengeluaran'][1],
            ]);

            // Report from Staff 2 (Some approved, some pending)
            $status = $month <= 10 ? 'approved' : ($month == 11 ? 'pending' : 'pending');
            $komentar = null;
            $validatedBy = null;
            $validatedAt = null;

            if ($status === 'approved') {
                $komentar = 'Laporan ' . $data['name'] . ' dari Staff Lapangan telah direview. Data lengkap dan akurat. Good job!';
                $validatedBy = $manager->id;
                $validatedAt = now()->subDays(rand(1, 10));
            }

            $report2 = FinancialReport::create([
                'user_id' => $staff2->id,
                'bulan' => $month,
                'tahun' => 2025,
                'status' => $status,
                'validated_by' => $validatedBy,
                'validated_at' => $validatedAt,
                'komentar_manager' => $komentar,
            ]);

            // Add transactions for report 2
            Transaction::create([
                'financial_report_id' => $report2->id,
                'tanggal' => now()->setMonth($month)->setDay(7),
                'keterangan' => 'Penjualan Jasa Konsultasi',
                'jenis' => 'pemasukan',
                'jumlah' => $data['pemasukan'][2],
            ]);

            Transaction::create([
                'financial_report_id' => $report2->id,
                'tanggal' => now()->setMonth($month)->setDay(12),
                'keterangan' => 'Biaya Transportasi',
                'jenis' => 'pengeluaran',
                'jumlah' => $data['pengeluaran'][2],
            ]);

            // Add one rejected report for demonstration (only for March)
            if ($month == 3) {
                $report3 = FinancialReport::create([
                    'user_id' => $staff1->id,
                    'bulan' => $month,
                    'tahun' => 2024, // Last year
                    'status' => 'rejected',
                    'validated_by' => $manager->id,
                    'validated_at' => now()->subDays(30),
                    'komentar_manager' => 'Data tidak lengkap. Mohon tambahkan detail transaksi dan bukti pendukung. Silakan submit ulang.',
                ]);

                Transaction::create([
                    'financial_report_id' => $report3->id,
                    'tanggal' => now()->subYear()->setMonth($month)->setDay(10),
                    'keterangan' => 'Transaksi tidak lengkap',
                    'jenis' => 'pemasukan',
                    'jumlah' => 5000000,
                ]);
            }
        }

        $this->command->info('✓ Berhasil membuat ' . (count($monthsData) * 2 + 1) . ' laporan keuangan dengan transaksi');
    }
}
