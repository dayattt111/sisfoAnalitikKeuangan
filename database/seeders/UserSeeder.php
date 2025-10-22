<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@mail.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Manager',
        'email' => 'manager@mail.com',
        'password' => Hash::make('manager123'),
        'role' => 'manager',
    ]);

    User::create([
        'name' => 'Staff',
        'email' => 'staff@mail.com',
        'password' => Hash::make('staff123'),
        'role' => 'staff',
    ]);
}
}
