<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@analitik.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manager Keuangan',
            'email' => 'manager@analitik.com',
            'email_verified_at' => now(),
            'password' => Hash::make('manager123'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Staff Operasional',
            'email' => 'staff@analitik.com',
            'email_verified_at' => now(),
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Staff Lapangan',
            'email' => 'staff2@analitik.com',
            'email_verified_at' => now(),
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        ActivityLog::create([
            'user_id' => 1,
            'activity' => 'Admin pertama kali dibuat pada sistem',
        ]);

        ActivityLog::create([
            'user_id' => 2,
            'activity' => 'Manager keuangan ditambahkan ke sistem',
        ]);

        ActivityLog::create([
            'user_id' => 3,
            'activity' => 'Staff operasional ditambahkan ke sistem',
        ]);

        ActivityLog::create([
            'user_id' => 4,
            'activity' => 'Staff lapangan ditambahkan ke sistem',
        ]);
    }
}
