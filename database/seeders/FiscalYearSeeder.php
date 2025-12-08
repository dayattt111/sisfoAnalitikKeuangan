<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FiscalYear;
use App\Models\User;

class FiscalYearSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Add current year and next year
        $currentYear = date('Y');
        
        FiscalYear::create([
            'year' => $currentYear - 1,
            'is_active' => true,
            'description' => 'Tahun fiscal ' . ($currentYear - 1),
            'created_by' => $admin->id,
        ]);

        FiscalYear::create([
            'year' => $currentYear,
            'is_active' => true,
            'description' => 'Tahun fiscal ' . $currentYear,
            'created_by' => $admin->id,
        ]);

        FiscalYear::create([
            'year' => $currentYear + 1,
            'is_active' => true,
            'description' => 'Tahun fiscal ' . ($currentYear + 1),
            'created_by' => $admin->id,
        ]);

        $this->command->info('✓ Berhasil membuat 3 tahun fiscal (2024, 2025, 2026)');
    }
}
